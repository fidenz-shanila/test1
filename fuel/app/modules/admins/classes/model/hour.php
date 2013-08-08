<?php

namespace Admins;

class Model_Hour extends \Model_Base
{
    public $order_by = '';
    public $sorting  = '';
    public $filter   = Array();
    public $top = 'DISTINCT';
    
    
    /**
     * building 'Select' part for listing query
     * @param String $top - limiting the results
     * @return String Select
     * @author Namal
     */ 
    public function sql_select()
    {
        return "SELECT SUM(H_HoursInDec) AS SumOfHours, EM1_Lname_ind , EM1_FullNameNoTitle ";
    }
    
    /**
     * building 'From' part for listing data
     * @param - none
     * @return String From
     * @author Namal
     */ 
    public function sql_from()
    {
        return  "FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk ";
    }
    
    /**
     * building 'Where' part for listing data
     * @param Array $filter - data array for Section, Project, Area, Owner_Type, Job_Start_Date, Job_End_Date
     * @return String Where
     * @author Namal
     */ 
    public function sql_where()
    {
        $where  = '';
        $filter = $this->filter;
        
        $sWSt = '';
        
        switch($filter['status'])
        {
            case 'Hours today':
                $sWSt = "AND H_HoursDate = CONVERT(varchar,dateadd(day,0,getdate()),101) ";
                break;
            case 'Hours yesterday':
                $sWSt = "AND H_HoursDate = CONVERT(varchar,dateadd(day,-1,getdate()),101) ";
                break;
            case 'Hours over last 7 days':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(day,-7,getdate()),101) ";
                break;
            case 'Hours this month':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(day,-datepart(day,getdate())+1,getdate()),101) ";
                break;
            case 'Hours over last 3 months':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(month,-3,getdate()),101) ";
                break;
            case 'Hours over last 6 months':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(month,-6,getdate()),101) ";
                break;
            case 'Hours over last 12 months':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(month,-12,getdate()),101) ";
                break;
            case 'Hours this year':
                $sWSt = "AND DATEPART(month, H_HoursDate) >= DATEPART(month, GETDATE()) ";
                break;
            case 'Hours over last 12 months':
                $sWSt = "AND H_HoursDate >= CONVERT(varchar,dateadd(month,-12,getdate()),101) ";
                break;
        }
        
        $where .= isset($filter['section']) && !empty($filter['section']) ? "AND WDB_S_Name = '{$filter['section']}' " : null;
        $where .= isset($filter['branch']) && !empty($filter['branch']) ? "AND WDB_B_Name = '{$filter['branch']}' " : null;
        $where .= isset($filter['project']) && !empty($filter['project']) ? "AND WDB_P_Name = '{$filter['project']}' " : null;
        $where .= isset($filter['area']) && !empty($filter['area']) ? "AND WDB_A_Name = '{$filter['area']}' " : null;
        $where .= isset($filter['officer']) && !empty($filter['officer']) ? "AND H_EmployeeID  = '{$filter['officer']}' " : null;
        
        return "WHERE H_HoursInDec > 0   {$sWSt} {$where}";
    }
    
    /**
     * building order by part for listing data
     * @param String Coloumn, String $cboBasedOn
     * @return String Order By
     * @author Namal
     */ 
    public function sql_order_by()
    {
        $order_by = '';
        $sColumn  = $this->order_by;
        $sort     = $this->sorting;
        
        switch ($sColumn) {
            case 'Employee':
                $order_by = "ORDER BY EM1_Lname_ind ". strtoupper($sort);
                break;
            
            case 'HoursDec' :
                $order_by = "ORDER BY SumOfHours ". strtoupper($sort);
                break;
            
            default :
                $order_by = "ORDER BY EM1_Lname_ind ". strtoupper($sort);
        }
        return $order_by;
    }
    
    /**
     * building group by part for listing data
     * @param String Org. Full name
     * @return String Group by
     * @author Namal
     */ 
    public function sql_group_by()
    {
        return "GROUP BY EM1_Lname_ind , EM1_FullNameNoTitle ";
    }
    
    /**
     * Listing the data from generated SQL
     * @param none
     * @return sql result
     * @author Namal
     */
    public function listing_data()
    {
        $select = $this->sql_select();
        $from   = $this->sql_from();
        $where  = $this->sql_where();
        $group_by = $this->sql_group_by();
        $order_by = $this->sql_order_by();
        
        $paging = null;
        $offset = $this->filter['iDisplayStart'];
        $limit  = $this->filter['iDisplayLength'];
        
        if (isset($offset))
        {
            $start   = $offset;
            $limit   = $limit + $offset;
            $paging  = " WHERE RowNumber > {$start} AND RowNumber < {$limit} ";
        }
        
        $full_sql = "WITH NumberedRows AS 
                    (
                        {$select},
                                Row_Number() OVER ({$order_by}) AS RowNumber
                        {$from}
                        {$where}
                        {$group_by}

                    ) 
                    SELECT * FROM NumberedRows";
                    
       $page_sql  = $full_sql . ' ' . $paging;
        
        $count_sql = str_replace(array("SELECT * FROM", "WHERE RowNumber > {$start} AND RowNumber < {$limit}"), array("SELECT COUNT(*) AS count FROM", ""), $page_sql);

        $rows = \NMI::db()->query($page_sql)->fetchAll();
        $row_count = \NMI::db()->query($count_sql)->fetch();
        
        $data_array = Array("iTotalRecords" => "{$row_count['count']}", "iTotalDisplayRecords" => "{$row_count['count']}", "aaData" => $rows);
                      
        return $data_array;
    }
    
    /**
     * Values for Types drop down
     * @param none
     * @return Array Types
     * @author Namal
     */
    public static function dropdown_branch()
    {
        $sql = "SELECT DISTINCT WDB_B_Name FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk  WHERE H_HoursInDec > 0 ORDER BY WDB_B_Name ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }
    
     /**
     * Values for Sections drop down
     * @param none
     * @return Array Sections
     * @author Namal
     */
    public static function dropdown_section()
    {
        $sql = "SELECT DISTINCT WDB_S_Name FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk  WHERE H_HoursInDec > 0 ORDER BY WDB_S_Name ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
    }
    
    /**
     * Values for Projects drop down
     * @param none
     * @return Array Projects
     * @author Namal
     */
    public static function dropdown_project()
    {
        $sql = "SELECT DISTINCT WDB_P_Name FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk  WHERE H_HoursInDec > 0 ORDER BY WDB_P_Name ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
    }
    
    /**
     * Values for Area drop down
     * @param none
     * @return Array Areas
     * @author Namal
     */
    public static function dropdown_area()
    {
        $sql = "SELECT DISTINCT WDB_A_Name FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk  WHERE H_HoursInDec > 0 ORDER BY WDB_A_Name ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }
    
     /**
     * Values for Officer drop down
     * @param none
     * @return Array Officer
     * @author Namal
     */
    public static function dropdown_officer()
    {
        $sql = "SELECT DISTINCT H_EmployeeID, EM1_Lname_ind, EM1_LastNameFirst FROM t_WorkDoneBy INNER JOIN t_Hours ON WDB_WorkDoneBy_pk = H_WDB_WorkDoneBy_fk_ind INNER JOIN t_Employee1 ON H_EmployeeID = EM1_EmployeeID_pk  WHERE H_HoursInDec > 0 ORDER BY EM1_Lname_ind ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'H_EmployeeID', 'EM1_LastNameFirst');
    }
    
}
