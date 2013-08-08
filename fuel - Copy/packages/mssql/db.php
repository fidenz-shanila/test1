<?php
namespace MSSQL; 
class Db
{
	/**
	* Connection id
	*
	* @var Resource
	*/
	public $connectionId;

	/**
	* Current environment
	*
	* @var string
	*/
	private $environment;

	protected static $instance = null;

	public static function forge($config = array())
	{
		$default_config = \Config::get('mssql');
		$setup = \Arr::merge($default_config, $config);

		if(self::$instance == null)
		{
			$conn = new Connection(\Config::get('mssql.type'));
			self::$instance = new self($conn->getDatabaseConnection(\Config::get('mssql.server'), \Config::get('mssql.user'), \Config::get('mssql.password'), \Config::get('mssql.database')), \Config::get('mssql.environment'));
		}
		return self::$instance;
	}

	public static function _init()
	{
		\Config::load('mssql', true);
                if(!function_exists('sqlsrv_query'))
                {
                    throw new \Exception('MSSQL Drivers not found.');
                }
	}

	/**
	* Creates a database instance.
	*
	* @param  Resource           $connection a copy of the current connection id for the MSSQL SERVER
	* @param  string             $environment OPTIONAL parameter that could be development or production
	*/
	public function __construct($connection, $environment = "production")
	{
		$this->connectionId = $connection;
		$this->environment = $environment;
	}

	/**
	* Processes the current select query and return rows in an array
	*
	* @param  string             $query MSSQL SERVER query syntax, e.g SELECT TOP 1000 [ID] FROM [sandbox].[dbo].[foobar];
	* @return array
	*/
	public function select($query)
	{
		$rows = $this->query($query);

		return $this->fetchArray($rows);
	}

	/**
	* Processes the current query
	*
	* @param  string             $queryString MSSQL SERVER query syntax, e.g DELETE FROM [sandbox].[dbo].[foobar] WHERE [ID] = 1;
	* @return array
	*/
	public function query($queryString)
	{
		if (function_exists("mssql_query"))
			$result = @mssql_query($queryString, $this->connectionId);
		else if (function_exists("sqlsrv_query"))
			$result = sqlsrv_query($this->connectionId, $queryString);

		$error_message = $this->errorMessages();

	    if (!empty($error_message) && $result === false)
		{
			if (strtoupper(trim($this->environment)) == "DEVELOPMENT")
				return $this->sqlError("Query Error - " .$queryString);
			else
				return false;
		}

	    return $result;
	}

	/**
	* Creates an array of records
	*
	* @param  string             $result use a result set and create an associative array of records
	* @return array
	*/
	public function fetchArray($result)
	{
		$finalRecords = array();

		if (function_exists("mssql_query"))
		{
		    $row = @mssql_fetch_array($result);

			if (@mssql_num_rows($result)!=0)
			{
				mssql_data_seek($result,0);

				while($row = mssql_fetch_array($result, MSSQL_ASSOC))
					$finalRecords[] = $row;

				return $finalRecords;
			}
			else
				return NULL;
		}

		if (function_exists("sqlsrv_fetch_array"))
		{
			while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
				$finalRecords[] = $row;

			return $finalRecords;
		}

		return NULL;
	}
	
	public function fetchObject($result)
	{
		$finalRecords = array();

		if (function_exists("sqlsrv_fetch_object"))
		{
			while($row = sqlsrv_fetch_object($result))
				$finalRecords[] = $row;

			if( count($finalRecords) == 1)
				return $finalRecords[0];
			else
				return $finalRecords;
		}

		return NULL;
	}
	
	/**
	* Inserts values into a table based on an array with keys matching only the selected table fields
	*
	* @param  array              $values an array of records with associated values matching the current table's structure
	* @param  string             $table simply the name of the MSSQL SERVER table
	* @param  integer            $insertId a copy of the id created by the last insert of the connection object
	* @return boolean
	*/
	function insert($values, $table, &$insertId)
	{
		$insertQuery = "INSERT INTO [" .$table ."] (";
			foreach ($values as $key => $value)
				$insertQuery .= " $key, ";

		$insertQuery = substr($insertQuery, 0, -2).") VALUES (";
			foreach ($values as $key)
				if (strtoupper($key) == "NULL")
					$insertQuery .= $key .", ";
				else
					$insertQuery .= "'" .$key ."', ";

		$insertQuery = substr($insertQuery, 0, -2). ");";

		$result = $this->query($insertQuery);
		$insertId = $this->mssql_insert_id();

		return $result;
	}

	/**
	* Update values in a table based on an array with keys matching only the selected table fields
	*
	* @param  array              $values an array of records with associated values matching the current table's structure
	* @param  string             $table simply the name of the MSSQL SERVER table
	* @param  string             $condition OPTIONAL the condition of the MSSQL query, default is designed to fail the current update
	* @return boolean
	*/
	function update($values, $table, $condition = "1 = 2")
	{
		$updateQuery = "UPDATE [" .$table ."] SET ";

		foreach($values as $key => $value)
			if (strtoupper($value) == "NULL")
				$updateQuery .= $key ."=" .$value .", ";
			else
				$updateQuery .= $key ."=\"" .$value ."\", ";

		$updateQuery = substr($updateQuery, 0, -2). " WHERE " .$condition .";";

		$result = $this->query($updateQuery);
		return $result;
	}

	/**
	* Creates an array of records of the table names, equivalent to MySQL's show tables; command
	*
	* @return array
	*/
	public function showTables()
	{
		return $this->select("SELECT NAME AS table_name FROM SYSOBJECTS WHERE XTYPE = 'U' ORDER BY NAME;");
	}

	/**
	* Creates an array of records of the table description, equivalent to MySQL's desc table; command
	*
	* @param  string             $table simply the name of the MSSQL SERVER table
	* @return array
	*/
	public function describeTable($table)
	{
		return $this->select("SELECT * FROM INFORMATION_SCHEMA.columns WHERE TABLE_NAME = '" .$table ."' ORDER BY ORDINAL_POSITION;");
	}

	/**
	* Returns the previous error message from the MSSQL Server, equivalent to MySQL's mysql_error() function
	*
	* @return string
	*/
	public function errorMessages()
	{
		if (function_exists("mssql_get_last_message"))
			return mssql_get_last_message($this->connectionId);
		else if (function_exists("sqlsrv_errors"))
		{
			$errors = sqlsrv_errors();

			return $errors[0]['message'];
		}
		return NULL;
	}

	/**
	* Returns the id of the previous insert statement, equivalent to MySQL's mysql_insert_id function
	*
	* @return integer
	*/
	private function insert_id()
	{
		if (function_exists("mssql_fetch_array"))
			$row = mssql_fetch_array(mssql_query("SELECT @@IDENTITY AS insert_id", $this->connectionId));
		else if (function_exists("sqlsrv_fetch_array"))
			$row = sqlsrv_fetch_array(sqlsrv_query($this->connectionId, "SELECT @@IDENTITY AS insert_id"));

		return $row[0];
	}

	function sqlError($message)
	{
		throw new Exception($message);
	}

} /*end of class Data*/