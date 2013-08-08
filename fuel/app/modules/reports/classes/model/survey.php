<?php

namespace Reports;

class Model_Survey extends \Model_Base 
{
    /**
     * sql for SELECT
     * @author Sri
     * 
     */

    public $limit = 10;

    /**
     * Query offsetter
     * @var array
     */
    public $offset = null;

    /**
     * Array of filters for searching
     * @var array
     */
    public $filter = array();
    
    public $search_criteria = null;
    
    
      /**
     * sql_from
     * @author Sri
     */
    
    public function sql_from()
    {
       return "FROM t_ContactSurvey INNER JOIN t_WorkDoneBy ON CS_R_J_YearSeq_fk_ind = WDB_YearSeq_fk_ind ";

    }
    
    public function sql_select()
    {
        if ($this->offset) 
        {
            $this->limit = $this->limit + $this->offset;
        }

        $limit = $this->limit;

        $s_limit = null;

        if ($limit)
            $s_limit = " TOP {$this->limit} ";
            
       return "SELECT DISTINCT {$s_limit}
        
                        CS_ContactSurvey_pk,
                        CS_R_FullNumber_ind,
                        CS_R_J_YearSeq_fk_ind,
                        CS_ContactID,
                        CS_ContactFullName,
                        CS_CO_Lname_ind,
                        CS_OrganisationFullName,
                        CS_OrgID,
                        CS_SurveyVersion,
                        CS_DateSent,
                        CS_DateReturned,
                        CS_Outcome,
                        CS_ReturnedBy,
                        CS_OutcomeDate,
                        CS_CarNo,
                        CS_ContactNotifiedOfOutcome,
                        CS_Comments ";
    }
    

    
    /**
     * sql_where
     * @author Namal
     */
    
    public function sql_where()
    {
        $filter =  ($this->filter); //TODO, escape filter
        $sWOut = '';  //TODO
	
	//If not set
        if (isset($filter['csr_Outcome']))
            
        switch($filter['csr_Outcome']) { //place switch variable here
        
            case "ALL Returned":
                $sWOut = "AND CS_DateReturned IS NOT NULL ";
                break;
            
            case "Returned - No action required":
                $sWOut = "AND CS_DateReturned IS NOT NULL AND CS_Outcome = 'No action required' ";
                break;
            
            case "Returned - Correction action required":
                $sWOut = "AND CS_DateReturned IS NOT NULL AND CS_Outcome = 'Correction action required' ";
                break;
            
            case "Returned - with comments":
                $sWOut = "AND CS_DateReturned IS NOT NULL AND CS_Comments IS NOT NULL ";
                break;
            
            case "ALL - Not returned":
                $sWOut = "AND CS_DateReturned IS NULL ";
                break;
            
            case "Not Returned - No response":
                $sWOut = "AND CS_DateReturned IS NULL AND CS_Outcome = 'No response' ";
                break;
        }
        
        $where = '';
        
        $where .= isset($filter['csr_sections']) && !empty($filter['csr_sections']) ? "AND WDB_S_Name = '{$filter['csr_sections']}' " : null;
        $where .= isset($filter['csr_projects']) && !empty($filter['csr_projects']) ? "AND WDB_P_Name = '{$filter['csr_projects']}' " : null;
        $where .= isset($filter['csr_get_areas']) && !empty($filter['csr_get_areas']) ? "AND WDB_A_Name = '{$filter['csr_get_areas']}' " : null;
        $where .= isset($filter['csr_survey_version']) && !empty($filter['csr_survey_version']) ? "AND CS_SurveyVersion = '{$filter['csr_survey_version']}' " : null;
        $where .= isset($filter['csr_returned_by']) && !empty($filter['csr_returned_by']) ? "AND CS_ReturnedBy = '{$filter['csr_returned_by']}' " : null;
        $where .= isset($filter['csr_organsiation']) && !empty($filter['csr_organsiation']) ? "AND CS_OrganisationFullName = '{$filter['csr_organsiation']}' " : null;
        
        //TODO, format the date for $filter['survey_sent_from_date'] && $filter['survey_sent_to_date']
        $where .= isset($filter['survey_sent_from_date']) && !empty($filter['survey_sent_from_date']) ? " AND (CS_DateSent >= CAST({$filter['survey_sent_from_date']}) " : null;
        $where .= isset($filter['survey_sent_to_date']) && !empty($filter['survey_sent_to_date']) ? " AND (CS_DateSent <= CAST({$filter['survey_sent_to_date']}) " : null;
        
        return "WHERE CS_R_J_YearSeq_fk_ind > 0 {$sWOut} {$where}";
    }
    
     /**
     * sql_order_by
     * @author Sri
     */
    
    public function sql_order_by()
    {
	 $sOrderBy = '';  //TODO
	 
	 $sort;  //TODO, add the sort field
	 
	 if(!isset($sColomn) || empty($sColomn))
	    return "ORDER BY CS_R_J_YearSeq_fk_ind ASC";
      
	 switch($sColomn){
	    case "Number":
	       $sOrderBy = "ORDER BY CS_R_J_YearSeq_fk_ind {$sort}";
	       break;
	    
	    case "Contact":
               $sOrderBy = "ORDER BY CS_CO_Lname_ind {$sort}";
	       break;
	    
	    case "Organisation":
	       $sOrderBy = "ORDER BY CS_OrganisationFullName {$sort}";
	       break;
	    
	    case "Sent":
	       $sOrderBy = "ORDER BY CS_DateSent {$sort}";
	       break;
	    
	    case "ContactNotified":
               $sOrderBy = "ORDER BY CS_ContactNotifiedOfOutcome {$sort}";
	       break;
	    }
	 
	 return $sOrderBy;
	 
    }
   
    
    public function listing() 
    {
        
        $limit  = \NMI_Db::escape($this->limit);
        $offset = \NMI_Db::escape($this->offset);
        $filter = \NMI_Db::escape($this->filter);

        $paging = null;

        if ($offset) 
        {
            $start = $offset;
            $limit = $limit + $offset;

            $paging = " where RowNumber > {$start} and RowNumber < {$limit} ";
        }

        //calling query builders
        $select   = $this->sql_select();
        $from     = $this->sql_from();
        $where    = $this->sql_where();
        $order_by = $this->sql_order_by();

        $full_sql = "WITH NumberedRows AS 
                        (
                        {$select},
                          Row_Number() OVER ({$order_by}) AS RowNumber 
                        {$from}
                        {$where}

                        ) 
                        SELECT * FROM NumberedRows";
                        
                  
                        
                                        
        $page_sql  = $full_sql . ' ' . $paging;
        
        $count_sql = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT CS_ContactSurvey_pk) AS [count] FROM NumberedRows', ''), $full_sql);

        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }
    
    
    
    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------
    public function get_returned_by() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT CS_ReturnedBy {$from} {$where}";
        $sql .= "AND CS_ReturnedBy IS NOT NULL ";
        $sql .= "ORDER BY CS_ReturnedBy ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        $data = \Arr::assoc_to_keyval($rows, 'CS_ReturnedBy', 'CS_ReturnedBy');
        return array_filter($data, 'strlen');
    }
    
    public function get_survey_version() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT CS_SurveyVersion {$from} {$where}";
        $sql .= "AND CS_SurveyVersion IS NOT NULL ";
        $sql .= "ORDER BY CS_SurveyVersion ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        $data = \Arr::assoc_to_keyval($rows, 'CS_SurveyVersion', 'CS_SurveyVersion');
        return array_filter($data, 'strlen');
    }
    
     public function get_organsiation() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT CS_OrganisationFullName {$from} {$where}";
        $sql .= "AND CS_OrganisationFullName IS NOT NULL ";
        $sql .= "ORDER BY CS_OrganisationFullName ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        $data = \Arr::assoc_to_keyval($rows, 'CS_OrganisationFullName', 'CS_OrganisationFullName');
        return array_filter($data, 'strlen');
    }
    
    
    

    public function get_branches() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_B_Name {$from} {$where}";
        $sql .= "AND WDB_B_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_B_Name ASC";
        
         $rows  = \NMI::Db()->query($sql)->fetchAll();
         return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }

    public function get_sections() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();
 
        $sql  = "SELECT DISTINCT WDB_S_Name {$from} {$where}";
        $sql .= "AND WDB_S_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_S_Name ASC";

        $rows  = \NMI::Db()->query($sql)->fetchAll();

        $data = \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
        return array_filter($data, 'strlen');
    }

    public function get_projects() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_P_Name {$from} {$where}";
        $sql .= "AND WDB_P_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_P_Name ASC";

        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
    }

    public function get_areas() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_A_Name {$from} {$where}";
        $sql .= "AND WDB_A_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_A_Name ASC";

        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }
    
    /*
     * get survey infomation to edit survey
     */
   public static function get_survey_info($CS_ContactSurvey_pk){
       $rows = \NMI::DB()->query(" SELECT * FROM t_ContactSurvey WHERE CS_ContactSurvey_pk='" . $CS_ContactSurvey_pk . "'")->fetchAll();
       return $rows[0];
   }
	
}