<?php

namespace Employees;

class Model_Employee extends \Model_Base 
{ 

    /**
     * SQL Limit (TOP 10)
     * @var integer
     */
    public $limit = 10;

    /**
     * Query offsetter
     * @var array
     */
    public $offset = null;
    
    public $search_criteria = null;

    /**
     * Array of filters for searching
     * @var array
     */
    public $filter = array(); 

    public function sql_from() 
    {
        return "FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_j_SectionEmployee ON S_SectionID_pk = SE_SectionID_ind_fk RIGHT OUTER JOIN t_Employee1 ON SE_EmployeeID_fk = EM1_EmployeeID_pk ";
    }

    public function sql_select() 
    { 
        if ($this->offset) {
            $this->limit = $this->limit + $this->offset;
        }

        $limit = $this->limit;
        $s_limit = null;

        if ($limit)
            $s_limit = " TOP {$this->limit} ";

        return "SELECT DISTINCT {$s_limit}

              EM1_EmployeeID_pk,
              EM1_Fullname,
              EM1_PositionDescriptor1,
              EM1_FullPositionDescription,
              EM1_SD_SiteName_fk,
              EM1_Phone,
              EM1_Lname_ind";
    }

    public function sql_where() 
    { 
        
        $filter = \NMI_Db::escape($this->filter);
        $swhere = '';
    
    //$statusVal=$filter['status'];
        $swhere .= isset($filter['by_letter']) && !empty($filter['by_letter']) ? "AND EM1_Lname_ind LIKE ".substr($filter['by_letter'], 0, -1). "%' " : null;
        $swhere .= isset($filter['status']) && !empty($filter['status']) ? "AND EM1_CurrencyStatus = {$filter['status']}" : null;
        $swhere .= isset($filter['site']) && !empty($filter['site']) ? "AND EM1_SD_SiteName_fk = {$filter['site']}" : null;
        $swhere .= isset($filter['branch']) && !empty($filter['branch']) ? "AND B_Name_ind = {$filter['branch']}" : null;
        $swhere .= isset($filter['section']) && !empty($filter['section']) ? "AND S_Name_ind = {$filter['section']}" : null;

        
         if(!empty($this->search_criteria)){
        $filter = \Helper_App::build_search_string("AND", $this->search_criteria['field_crieteria_02'], 'N/A', $this->SearchCriteria1(), $this->SearchCriteria2() );
        //print_r($filter);exit;
        
         }else{
            $filter = '';
        }
        
        
        
        return "WHERE EM1_EmployeeID_pk > 0 {$swhere} {$filter}";
    }

    public function sql_orderby() 
    {  

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY EM1_Lname_ind";

        $sorderby = null;
        $order_by = array_merge(array('column' => null, 'sort' => null), (array) $this->order_by); //TODO, escape $this->order_by
        $order_by['column'] = $this->order_by['column'];
        
        switch ($order_by['column']) {
          
            case "LastName":
                $sorder_by = "ORDER BY EM1_Lname_ind" ;
                break;
            case "Site":
                $sorder_by = "ORDER BY EM1_SD_SiteName_fk ASC";
                break;
        }
        return $sorder_by;
    }

     public function SearchCriteria1() 
    {
        
        $filter = $this->search_criteria;
        //print_r($filter);exit;

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria']))
            return null;

        $sql = null;
        
        switch ($filter['field']) {
        
            case "Full name":
               $sql = "EM1_Fullname ";
               break;
           case "First name":
               $sql = "EM1_Fname ";
               break;
           case "Last name":
               $sql = "EM1_Lname_ind ";
               break;
           case "Phone":
               $sql = "EM1_Phone ";
               break;
           case "Fax":
               $sql = "EM1_Fax ";
               break;
           case "Position descriptor":
               $sql = "EM1_FullPositionDescription ";
               break;
        
        }

        switch ($filter['equality']) {
            case "LIKE":
                $sql .= "LIKE '%" . $filter['criteria'] . "%' ";
                break;

            case "NOT LIKE":
                $sql .= "NOT LIKE '%" . $filter['criteria'] . "%' ";
                break;

            case "EQUAL TO":
                $sql .= "= '" . $filter['criteria'] . "' ";
                break;

            case "NOT EQUAL TO":
                $sql .= "<> '" . $filter['criteria'] . "' ";
                break;

            case "STARTS WITH":
                $sql .= "LIKE '" . $filter['criteria'] . "%' ";
                break;

            case "ENDS WITH":
                $sql .= "LIKE '%" . $filter['criteria'] . "' ";
                break;
        }

        return $sql;
    }
    
    
     public function SearchCriteria2() 
    {
        

        $filter = $this->search_criteria;
        //$filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['advance']['field']) || empty($filter['advance']['equality']) || empty($filter['advance']['criteria']))
            return null;

        $sql = null;
        

        switch ($filter['advance']['field']) {
             case "Full name":
                $sql = "EM1_Fullname ";
                 break;
            case "First name":
                $sql = "EM1_Fname ";
                break;
            case "Last name":
                $sql = "EM1_Lname_ind ";
                break;
            case "Phone":
                $sql = "EM1_Phone ";
                break;
            case "Fax":
                $sql = "EM1_Fax ";
                break;
            case "Position descriptor":
                $sql = "EM1_FullPositionDescription ";
                break;
        }
        

        switch ($filter['advance']['equality']) {
            case "LIKE":
                $sql .= "LIKE '%" . $filter['advance']['criteria'] . "%' ";
                break;

            case "NOT LIKE":
                $sql .= "NOT LIKE '%" . $filter['advance']['criteria'] . "%' ";
                break;

            case "EQUAL TO":
                $sql .= "= '" . $filter['advance']['criteria'] . "' ";
                break;

            case "NOT EQUAL TO":
                $sql .= "<> '" . $filter['advance']['criteria'] . "' ";
                break;

            case "STARTS WITH":
                $sql .= "LIKE '" . $filter['advance']['criteria'] . "%' ";
                break;

            case "ENDS WITH":
                $sql .= "LIKE '%" . $filter['advance']['criteria'] . "' ";
                break;
        }
        
        return $sql;
    }

    public function listing() 
    { 
        $limit  = \NMI_Db::escape($this->limit);
        $offset = \NMI_Db::escape($this->offset);
        $filter = \NMI_Db::escape($this->filter);

        $paging = null;

        if ($offset) {
            $start = $offset;
            $limit = $limit + $offset;

            $paging = " where RowNumber > {$start} and RowNumber < {$limit} ";
        }

        $select   = $this->sql_select();
        $from     = $this->sql_from();
        $where    = $this->sql_where();
        $order_by = $this->sql_orderby();

        $full_sql = "WITH NumberedRows AS 
                    (
                            {$select},
                                    Row_Number() OVER ({$order_by}) AS RowNumber 
                            {$from}
                            {$where}
                    ) 
                    SELECT * FROM NumberedRows";

        //$page_sql    = $full_sql . ' ' . $paging;
           $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by; 
           //print_r($page_sql);exit;
        $count_sql   = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT EM1_Fullname) AS [count] FROM NumberedRows', ''), $full_sql);
        
        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------

    public function get_status() 
    {
         
        $from    = $this->sql_from();
        $where   = $this->sql_where();
        
        $sql     = "SELECT DISTINCT EM1_CurrencyStatus {$from} {$where} ";
        $sql    .= "AND EM1_CurrencyStatus IS NOT NULL ";
        $sql    .= "ORDER BY EM1_CurrencyStatus ASC";
        //print_r($sql);exit;
        $rows    = \NMI::Db()->query($sql)->fetchAll();
        //if(empty($rows)){
            //return array('[EM1_CurrencyStatus]'=>'CURRENT');
       // }else{
           // print_r($rows);exit;
        return \Arr::assoc_to_keyval($rows, 'EM1_CurrencyStatus', 'EM1_CurrencyStatus');
        //}
    }
    
    public function get_site() 
    {

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT EM1_SD_SiteName_fk {$from} {$where} ";
        $sql    .= "AND EM1_SD_SiteName_fk IS NOT NULL ";
        $sql    .= "ORDER BY EM1_SD_SiteName_fk ASC ";
        
        $rows    = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_SD_SiteName_fk', 'EM1_SD_SiteName_fk');

    }

    public function get_branches() 
    {

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT B_Name_ind {$from} {$where} ";
        $sql    .= "AND B_Name_ind IS NOT NULL ";
        $sql    .= "ORDER BY B_Name_ind ASC";

        $rows    = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'B_Name_ind', 'B_Name_ind');
    }

    public function get_sections() 
    {

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT S_Name_ind {$from} {$where} ";
        $sql    .= "AND S_Name_ind IS NOT NULL ";
        $sql    .= "ORDER BY S_Name_ind ASC";

        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'S_Name_ind', 'S_Name_ind');
    }
	

    /**
     * [sp_helpdbfixedrole]
     * @param  roel id
     * @return [type]       [description]
     * @author Sahan <[email]>
     */
    public static function get_db_role_info()
    {			
		$sql=	"select 'RoleName' = name, 'RoleId' = principal_id, 'IsAppRole' = case type when 'A' then 1 else 0 end
			from sys.database_principals where (type = 'R' or type = 'A')";
        $stmt = \NMI::Db()->query($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();// print_r($rows);exit;
		return \Arr::assoc_to_keyval($rows, 'RoleName', 'RoleName');
    }
	
	  /**
     * Change Password
     * @param  roel id
     * @return [type]       [description]
     * @author Sahan <[email]>
     */
    public static function rest_password($EM1_Password,$EM1_EmployeeID_pk)
    {			
		$sql=	" UPDATE t_Employee1 SET EM1_Password = ? WHERE EM1_EmployeeID_pk = ?";
        $stmt = \NMI::Db()->query($sql);
		$stmt->bindValue(1, $EM1_Password);
		$stmt->bindValue(2, $EM1_EmployeeID_pk);
        $stmt->execute();
        return $rows = $stmt->fetchAll();
    }
	
	
	  /**
     * Change Password
     * @param  roel id
     * @return [type]       [description]
     * @author Sahan <[email]>
     */
    public static function get_user_role_info($UserName)
    {			
		$sql=	" 
				SELECT users.name, groups.name
				FROM sysmembers membs
				JOIN sysusers users on membs.memberuid = users.uid
				JOIN sysusers groups on membs.groupuid = groups.uid
				WHERE users.name ='$UserName'";
        $stmt = \NMI::Db()->query($sql);
		//$stmt->bindValue(1, $UserName);
        $stmt->execute();
        $rows = $stmt->fetchAll();
		return  \Arr::assoc_to_keyval($rows, 'name', 'name');
    }
    
 
    /**
     * Employee titles
     * @author  Namal <[email]>
     */   
    public static function get_title()
    {                               
        $rows  = \NMI::Db()->query("SELECT DISTINCT EM1_Title FROM t_Employee1 WHERE EM1_Title IS NOT NULL ORDER BY EM1_Title ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_Title', 'EM1_Title');
    }
    
    /**
     * Get initials
     * @return [type] [description]
     */
    public static function get_initials()
    {
        $rows = \NMI::Db()->query("SELECT EM1_Initials_unq FROM t_Employee1 WHERE EM1_Initials_unq IS NOT NULL ORDER BY EM1_Initials_unq ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_Initials_unq', 'EM1_Initials_unq');     
    }
    
     /**
     * Get Employees
     * Returns an id => string based output for dropdowns
     * @author Namal <[email]>
     * @param   []
     * @return Array [certificates]
     */
     
    public static function get_employees()
    {
        $stmt = \NMI::Db()->query("SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst, EM1_Username FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
        return \Arr::assoc_to_keyval($stmt, 'EM1_EmployeeID_pk', 'EM1_FullNameNoTitle');
    }
    
    
      /**
     * Result set used to generate the Excel
     * @return [type] [description]
     */
    public function excel_results()
    {
        $sql = "SELECT EM1_Fullname AS FullName, EM1_Phone AS Phone, EM1_Fax AS Fax, EM1_Room AS Room, EM1_SD_SiteName_fk AS Site, EM1_Username ";
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();

        return \NMI::DB()->query($sql)->fetchAll();
    }
    
    public static function get_all_employee($EM1_EmployeeID_pk)
    {
    	$sql  = "SELECT * FROM t_Employee1 WHERE EM1_EmployeeID_pk = ?";
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue( 1, $EM1_EmployeeID_pk );
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get employee by username
     * @return void
     * @author Namal
     **/
    public static function get_employee_by_username($EM1_Username)
    {
        $sql  = "SELECT * FROM t_Employee1 WHERE EM1_Username = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $EM1_Username);
        $stmt->execute();
        return $stmt->fetch();
    }
	
	/*Rest Roles 
	**
	//
	*/
	public static function rest_user_roles_remove($AllRoles,$UserName)
	{ 
	//set user roles
		try{
				$stmt	=\NMI::Db()->prepare("DECLARE @return_value int,
											 @InputArray varchar(2000)
											EXEC @return_value = [dbo].[sp_UpdateRoleRemove]
											@InputArray = :InputArray,
											@EM_QUERY  = :EM_QUERY, 
											@EM1_Username  = :EM1_Username
											
											SELECT  'return' = @return_value");
											
				$stmt->bindValue('InputArray', $AllRoles);
				$stmt->bindValue('EM_QUERY', '');
				$stmt->bindValue('EM1_Username', $UserName);
	
				$stmt->execute();
				$stmt->fetch();
				return $stmt['return'];
				
		}catch(\PDOException $e){
			return false;
		}
			
	}
	
	public static function rest_user_roles_update($AssingeRoles,$UserName)
	{	
		try{		
				//set user roles
				$stmt	=\NMI::Db()->prepare("DECLARE @return_value int,
											 @InputArray varchar(2000)
											EXEC @return_value = [dbo].[sp_UpdateRoles]
											@InputArray = :InputArray,
											@EM_QUERY  = :EM_QUERY, 
											@EM1_Username  = :EM1_Username
											
											SELECT  'return' = @return_value");
											
				$stmt->bindValue('InputArray', $AssingeRoles);
				$stmt->bindValue('EM_QUERY', '');
				$stmt->bindValue('EM1_Username', $UserName);
	
			   $stmt->execute(); 
			   $stmt->fetch();
			  return $stmt['return'];
			  
		 	}catch(\PDOException $e){
			return false;
		}
		
	}



    /**
    ***********************************************************************************************************
    * Employee Form
    ***********************************************************************************************************
    */
    
    /**
     * Get employee
     * @return void
     * @author Namal
     **/
    public function get_employee($EM1_EmployeeID_pk)
    {
    	$sql  = "SELECT * FROM t_Employee1 WHERE EM1_EmployeeID_pk = ?";
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $EM1_EmployeeID_pk);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get employee type
     * @author Namal
     */
    public function get_employee_type()
    {
        $sql  = "SELECT DISTINCT(EM1_EmploymentType) FROM t_Employee1 ORDER BY EM1_EmploymentType ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'EM1_EmploymentType', 'EM1_EmploymentType' );
    }
    
    /**
     * Get sites
     * @author Namal
     */
    public function get_employee_sites()
    {
        $sql  = "SELECT SD_SiteName_pk FROM t_SiteDetails ORDER BY SD_SiteName_pk ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'SD_SiteName_pk', 'SD_SiteName_pk' );
    }

    /**
     * sql from for employee form
     *
     * @return void
     * @author Namal
     **/
    public function emp_from()
    {
    	 return "FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk ";
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function emp_where()
    {
        $dropdowns = array();
        
    	$where  = '';
    	$where .= isset($dropdowns['branch']) && !empty($dropdowns['branch']) ? "AND B_Name_ind = {$dropdowns['branch']} " : null;
    	$where .= isset($dropdowns['section']) && !empty($dropdowns['section']) ? "AND S_Name_ind = {$dropdowns['section']} " : null;
    	$where .= isset($dropdowns['project']) && !empty($dropdowns['project']) ? "AND P_Name_ind = {$dropdowns['project']} " : null;
    	$where .= isset($dropdowns['area']) && !empty($dropdowns['area']) ? "AND A_Name_ind = {$dropdowns['area']} " : null;

    	return "WHERE B_BranchID_pk > 0 {$where}";
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function emp_dropdown_branch()
    {
        $from = $this->emp_from();
        $where = $this->emp_where();
        
    	$sql  = "SELECT DISTINCT B_Name_ind {$from} {$where} ORDER BY B_Name_ind ASC";
        
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'B_Name_ind', 'B_Name_ind' );
    }

     /**
     * undocumented function
     * @return void
     * @author 
     **/
    function emp_dropdown_section()
    {
        $from = $this->emp_from();
        $where = $this->emp_where();
        
    	$sql  = "SELECT DISTINCT S_Name_ind {$from} {$where} ORDER BY S_Name_ind ASC";
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'S_Name_ind', 'S_Name_ind' );
    }

     /**
     * undocumented function
     * @return void
     * @author 
     **/
    function emp_dropdown_project()
    {
        $from = $this->emp_from();
        $where = $this->emp_where();
        
    	$sql  = "SELECT DISTINCT P_Name_ind {$from} {$where} ORDER BY P_Name_ind ASC";
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'P_Name_ind', 'P_Name_ind' );
    }

     /**
     * undocumented function
     * @return void
     * @author 
     **/
    function emp_dropdown_area()
    {
        $from = $this->emp_from();
        $where = $this->emp_where();
        
    	$sql  = "SELECT DISTINCT A_Name_ind {$from} {$where} ORDER BY A_Name_ind ASC";
    	$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval( $row, 'A_Name_ind', 'A_Name_ind' );
    }




    
}