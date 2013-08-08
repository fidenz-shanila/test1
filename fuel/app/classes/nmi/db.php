<?php

class NMI_Db
{
	public static $connection = false;

	function __construct(Array $config)
	{
		if (!self::$connection) {
			self::connect($config);
		}

		return self::$connection;
			
	}

	/**
	 * Create the connection
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	public static function connect($config)
	{
		
		\Config::load('nmidb', true);
		$default_config = \Config::get('nmidb.default');
		$config = array_merge($default_config, $config);


		$con = new \PDO("sqlsrv:Server={$config['server']};Database={$config['database']}", $config['username'], $config['password']);
		$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$con->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC); 

		self::$connection = $con;

		return self::$connection;
	}

	/**
	 * Escape a string to sql safe PDO::quote
	 * This helper method allows usiage of arrays (multi level)
	 * @param  MIXED [varname] [description]
	 * @return [type] [description]
	 */
	public static function escape($values)
	{
		if(is_numeric($values))
		{
			return $values;
		}

		$input = $values; //create a copy so no references will affect input parameter
		if(is_array($input))
		{
			array_walk_recursive($input, function(&$item, &$key){ $item = \NMI::Db()->quote($item); $key = \NMI::Db()->quote($key); });
			return $input;
		}
		else
		{
			return \NMI::Db()->quote($input);
		}
	}

	/**
	 * Execute a stored procedure with single param
	 * @param  (string) stored procedure name
	 * @param  (string) param name
	 * @param  (string) param value
	 * @return Array data
	 * @author Namal
	 */

	public static function run_sp($sp, $param_name, $param_value)
	{
		$sql  = "{$sp} @{$param_name}=:{$param_name}";

		$stmt = \NMI::Db()->prepare($sql);
		$stmt->bindValue($param_name, $param_value);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_NUM);
	}

	/**
	 * Helper method for updating data
	 * @param  String $table table name
	 * @param  Array  $data  assoc array of data, column => value
	 * @param  Array  $where Where clause
	 * @return [type]        [description]
	 */
              
	public static function update($table, Array $data, Array $where = array())
	{
		
		//$data = array_filter($data,'');
		$data = static::escape($data);
		
		$data = \Arr::filter_keys($data, array_keys($where), true); //remove where coloumn from data set

		$us = array();
		$sql = "UPDATE [{$table}] SET ";
                
		foreach($data as $wc => $wv)
		{
                   if ($wv == "'NULL'"){
                        $sql .= "[$wc]" ."= NULL, ";
                   }else{
                         $sql .= "[$wc] = $wv ,"; 
                    }
                        
		}

                $sql = substr($sql, 0, -2);
                
		if(!empty($where))
		{
                    $where = static::escape($where);

			$ws = array();
			foreach($where as $wc => $wv)
			{
				$ws[] = "[$wc] = $wv";
			}
			$sql .= " WHERE ".implode(' AND ', $ws);	
		}
//print_r($sql);exit;
		try{
                    $save = \NMI::Db()->exec($sql);
                    return $save;
                     //\Message::set('success', 'Data save success.');
                    
                }catch(\PDOException $e){
                    //return \Message::set('error', $e->getMessage());
                    return \Message::set('error', 'Error in save');
                 }

	}


	public static function format_date($date=null)
	{ 
          
            if(strlen($date)!=0){
                $date_set = explode('/', $date);    
                $date_set = $date_set[2].'-'.$date_set[1].'-'.$date_set[0];
                $date = date('Y-m-d H:i:s', strtotime($date_set));
                 //print_r($date_set);exit;
                return $date;
            }else{
                return NULL;
            }
            
	}
        
        public static function set_number_format($data)
        {
            return  '$'. @number_format($data,2 ,'.' ,',');
        }
        
        public static function reset_number_format($data)
        {
            $string = str_replace('$', '', $data);
            $string = str_replace(',', '', $string);
            return $string;
        }
        
/**
  * Convert an array to a excel file and return to the browser as a download
  * @param  [type] $data           [description]
  * @param  [type] $file_name=null [description]
  * @param  Array  $columns        [description]
  * @return [type]                 [description]
  */
 public static function send_excel(Array $data, $filename = null, Array $columns=array())
    {
     $content = \Format::forge($data)->to_csv();
  
     if(!isset($filename))
    $filename = "export_".date("Y-m-d_H-i",time());
     
         header("Content-Type: application/octet-stream");
        header("Content-disposition: attachment; filename=".$filename.".csv");
    exit($content);
    }

}

/* eof */