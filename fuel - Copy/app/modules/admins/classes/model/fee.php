<?php

namespace Admins;

class Model_Fee extends \Model_Base
{
    public $filter = Array();
    public $limit  = "";
    
    /**
     * building 'Select' part for listing query
     * @param none
     * @return String Select
     * @author Namal
     */ 
    public function sql_select()
    {
        $sLimit = '';
        
        if( !empty($this->filter['iDisplayLength']) ){
            $sLimit = "DISTINCT";
        }
        
        return "SELECT {$sLimit} F_FeeID_pk, F_Code, F_Description, F_Fee, F_AreaID_ind_fk, A_Name_ind, P_Name_ind, S_Name_ind, B_Name_ind ";
    }
    
    /**
     * building 'From' part for listing data
     * @param - none
     * @return String From
     * @author Namal
     */ 
    public function sql_from()
    {
        return  "FROM t_Fee INNER JOIN t_Area ON F_AreaID_ind_fk = A_AreaID_pk INNER JOIN t_Project ON A_ProjectID_fk = P_ProjectID_pk INNER JOIN t_Section ON P_SectionID_fk = S_SectionID_pk INNER JOIN t_Branch ON S_BranchID_fk = B_BranchID_pk ";
    }
    
    /**
     * building 'Where' part for listing data
     * @param Array $filter 
     * @return String Where
     * @author Namal
     */ 
    public function sql_where()
    {
        $where  = '';
        $filter = $this->filter;
        
        $where .= isset($filter['section']) && !empty($filter['section']) ? "AND S_Name_ind = '{$filter['section']}' " : null;
        $where .= isset($filter['project']) && !empty($filter['project']) ? "AND P_Name_ind = '{$filter['project']}' " : null;
        $where .= isset($filter['area']) && !empty($filter['area']) ? "AND A_Name_ind = '{$filter['area']}' " : null;
        $where .= isset($filter['branch']) && !empty($filter['branch']) ? "AND B_Name_ind = '{$filter['branch']}' " : null;

        return "WHERE F_FeeID_pk > 0 {$where}";
    }
    
    /**
     * building order by part for listing data
     * @param String Coloumn, String $cboBasedOn
     * @return String Order By
     * @author Namal
     */ 
    public function sql_order_by()
    {
        return "ORDER BY B_Name_ind, S_Name_ind, P_Name_ind, A_Name_ind, F_Code ASC";
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

                    ) 
                    SELECT * FROM NumberedRows";
                    
        $page_sql  = $full_sql . ' ' . $paging;
        
        
        
        $count_sql = str_replace(array("SELECT * FROM", "WHERE RowNumber > {$start} AND RowNumber < {$limit}"), array("SELECT COUNT(*) AS count FROM", ""), $page_sql);
        
        $rows      = \NMI::db()->query($page_sql)->fetchAll();
        $row_count = \NMI::db()->query($count_sql)->fetch();
        
        $data_array = Array("iTotalRecords" => "{$row_count['count']}", "iTotalDisplayRecords" => "{$row_count['count']}", "aaData" => $rows);
                      
        return $data_array;
    }
    
    /**
     * Values for Branches drop down
     * @param none
     * @return Array Branches
     * @author Namal
     */
    public function dropdown_branch()
    {
        
        $sql = "SELECT DISTINCT B_Name_ind {$this->sql_from()} {$this->sql_where()} ORDER BY B_Name_ind ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'B_Name_ind', 'B_Name_ind');
    }
    
     /**
     * Values for Sections drop down
     * @param none
     * @return Array Sections
     * @author Namal
     */
    public function dropdown_section()
    {
        $sql = "SELECT DISTINCT S_Name_ind {$this->sql_from()} {$this->sql_where()} ORDER BY S_Name_ind ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'S_Name_ind', 'S_Name_ind');
    }
    
    /**
     * Values for Projects drop down
     * @param none
     * @return Array Projects
     * @author Namal
     */
    public function dropdown_project()
    {
        $sql = "SELECT DISTINCT P_Name_ind {$this->sql_from()} {$this->sql_where()} ORDER BY P_Name_ind ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'P_Name_ind', 'P_Name_ind');
    }
    
    /**
     * Values for Area drop down
     * @param none
     * @return Array Areas
     * @author Namal
     */
    public function dropdown_area()
    {
        $sql = "SELECT DISTINCT A_Name_ind {$this->sql_from()} {$this->sql_where()} ORDER BY A_Name_ind ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'A_Name_ind', 'A_Name_ind');
    }
    
}