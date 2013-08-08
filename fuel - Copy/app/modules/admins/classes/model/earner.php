<?php

namespace Admins;

class Model_Earner extends \Model_Base
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
        
        $select = "SELECT {$this->top} ";
        
        if(isset($this->filter['based_on']) && $this->filter['based_on'] == 'Org. Full name'){
            $select .= "OR1_FullName, OR1_InternalOrExternal, SUM(J_FeeDue) As TotalIncome, COUNT(J_FeeDue) As NoJobs ";
        }else{
            $select .= "OR1_name_ind, OR1_InternalOrExternal, SUM(J_FeeDue) As TotalIncome, COUNT(J_FeeDue) As NoJobs ";
        }
       
        return $select;
    }
    
    /**
     * building 'From' part for listing data
     * @param - none
     * @return String From
     * @author Namal
     */ 
    public function sql_from()
    {
        return  "FROM t_Organisation1 INNER JOIN t_Artefact ON OR1_OrgID_pk = A_OR1_OrgID_fk INNER JOIN t_Quote ON A_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Job ON Q_YearSeq_pk = J_YearSeq_pk INNER JOIN t_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind ";
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
        
        $where .= isset($filter['section']) && !empty($filter['section']) ? "AND WDB_S_Name = '{$filter['section']}' " : null;
        $where .= isset($filter['project']) && !empty($filter['project']) ? "AND WDB_P_Name = '{$filter['project']}' " : null;
        $where .= isset($filter['area']) && !empty($filter['area']) ? "AND WDB_A_Name = '{$filter['area']}' " : null;
        $where .= isset($filter['type']) && !empty($filter['type']) ? "AND OR1_InternalOrExternal = '{$filter['type']}' " : null;
        
        if(isset($filter['job_start_date']) && !empty($filter['job_start_date'])){
            $job_start_date = str_replace('/', '-', $filter['job_start_date']);
            $where .= " AND J_OutComeDate >= '{$job_start_date}' ";
        }
        
        if(isset($filter['job_start_date']) && !empty($filter['job_start_date'])){
            $job_end_date   = str_replace('/', '-', $filter['job_end_date']);
            $where .= " AND J_OutComeDate <= '{$job_end_date}' ";
        }
        
        return "WHERE J_OutCome IS NOT NULL  {$where}";
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
        
        if (!isset($this->order_by) || (empty($this->order_by)) || (!isset($this->order_by)))
           return null;
        
        switch ($sColumn) {
            case 'OrganisationTitle':
                $order_by = (isset($this->filter['based_on']) && $this->filter['based_on'] == 'Org. Full name') ? "ORDER BY OR1_FullName ". strtoupper($sort) : "ORDER BY OR1_name_ind " . strtoupper($sort);
                break;
            
            case 'Income' :
                $order_by = "ORDER BY TotalIncome ". strtoupper($sort);
                break;
            
            case 'NoJobs' :
                $order_by = "ORDER BY NoJobs ". strtoupper($sort);
                break;
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
        return (isset($this->filter['based_on']) && $this->filter['based_on'] == 'Org. Full name') ? "GROUP BY OR1_FullName, OR1_InternalOrExternal" : "GROUP BY OR1_name_ind, OR1_InternalOrExternal";
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
        
        //echo "{$select} {$from} {$where} {$group_by} {$order_by}";exit;
        
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

        //echo $count_sql; exit;
        
        $sql = "{$select} {$from} {$where} {$group_by} {$order_by}";
        
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
    public static function dropdown_type()
    {
        
        $sql = "SELECT DISTINCT OR1_InternalOrExternal FROM t_Organisation1 INNER JOIN t_Artefact ON OR1_OrgID_pk = A_OR1_OrgID_fk INNER JOIN t_Quote ON A_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Job ON Q_YearSeq_pk = J_YearSeq_pk INNER JOIN t_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind WHERE J_OutCome IS NOT NULL ORDER BY OR1_InternalOrExternal ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'OR1_InternalOrExternal', 'OR1_InternalOrExternal');
    }
    
     /**
     * Values for Sections drop down
     * @param none
     * @return Array Sections
     * @author Namal
     */
    public static function dropdown_section()
    {
        $sql = "SELECT DISTINCT WDB_S_Name FROM t_Organisation1 INNER JOIN t_Artefact ON OR1_OrgID_pk = A_OR1_OrgID_fk INNER JOIN t_Quote ON A_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Job ON Q_YearSeq_pk = J_YearSeq_pk INNER JOIN t_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind WHERE J_OutCome IS NOT NULL ORDER BY WDB_S_Name ASC";
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
        $sql = "SELECT DISTINCT WDB_P_Name FROM t_Organisation1 INNER JOIN t_Artefact ON OR1_OrgID_pk = A_OR1_OrgID_fk INNER JOIN t_Quote ON A_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Job ON Q_YearSeq_pk = J_YearSeq_pk INNER JOIN t_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind WHERE J_OutCome IS NOT NULL ORDER BY WDB_P_Name ASC";
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
        $sql = "SELECT DISTINCT WDB_A_Name FROM t_Organisation1 INNER JOIN t_Artefact ON OR1_OrgID_pk = A_OR1_OrgID_fk INNER JOIN t_Quote ON A_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Job ON Q_YearSeq_pk = J_YearSeq_pk INNER JOIN t_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind WHERE J_OutCome IS NOT NULL ORDER BY WDB_A_Name ASC";
        $rows = \NMI::db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }
    
}