<?php

namespace Jobs;

class Model_Job extends \Model_Base 
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

    /**
     * Array of filters for searching
     * @var array
     */
    public $filter = array();
    
    public $search_criteria = null;

    public function sql_from() 
    {
        return "FROM vw_JobListing INNER JOIN vw_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind ";
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

                                OR1_Name_ind,
                                OR1_FullName,
                                OR1_InternalOrExternal,
                                A_YearSeq_pk,
                                A_Type,
                                A_Make, 
                                A_Model,
                                A_SerialNumber, 
                                A_PerformanceRange,
                                A_Description, 
                                A_CF_FileNumber_fk,
                                FileLocation, 
                                A_ArtefactMainImagePath,
                                A_OR1_OrgID_fk,
                                A_ContactID,
                                J_YearSeq_pk,
                                J_FullNumber,
                                FullStatusString,
                                FullStatusDaysInt";
        
    }

    public function sql_where()
    {
        
        $filter = \NMI_Db::escape($this->filter); //TODO, escape filter
        $swst = '';

        if (isset($filter['status'])){
             //print_r(($filter['status']));exit;
            switch ($filter['status']) {

                case '\'1\'':
                    $swst = " AND FullStatusString LIKE 'Live:%' ";
                    break;
                
                case '\'2\'':
                    $swst = " AND FullStatusString LIKE 'Live: Not started%' ";
                    break;
                
                case '\'3\'':
                    $swst = " AND FullStatusString LIKE 'Live: Started%' ";
                    break;
                
                case '\'4\'':
                    $swst = " AND FullStatusString LIKE 'Live: Client delay%' ";
                    break;

                case '\'5\'':
                    $swst = " AND FullStatusString LIKE 'Closed:%' ";
                    break;

                case '\'6\'':
                    $swst = " AND FullStatusString LIKE 'Closed: Completed%' ";
                    break;

                case '\'7\'':
                    $swst = " AND FullStatusString LIKE 'Closed: Partially completed%' ";
                    break;

                case '\'8\'':
                    $swst = " AND FullStatusString LIKE 'Closed: Not completed%' ";
                    break;

                case '\'9\'':
                    $swst = " AND FullStatusString LIKE 'Live: Wrong data%' ";
                    break;
               
            }
        }
            

        $swhere = '';
          if(isset($filter['type']) and !empty($filter['type']))
        {
           if($filter['type']=='\'90&deg; square block\''){
               $filter['type']='\'90° square block\'';
           }
             $swhere .= "AND A_Type = {$filter['type']} ";
        }else{
            $swhere .= null;
        }

        //$swhere .= isset($filter['type']) && !empty($filter['type']) ? " AND A_Type = {$filter['type']}" : null;
        $swhere .= isset($filter['branch']) && !empty($filter['branch']) ? " AND WDB_B_Name = {$filter['branch']} " : null;
        $swhere .= isset($filter['section']) && !empty($filter['section']) ? " AND WDB_S_Name = {$filter['section']} " : null;
        $swhere .= isset($filter['project']) && !empty($filter['project']) ? " AND WDB_P_Name = {$filter['project']} " : null;
        $swhere .= isset($filter['area']) && !empty($filter['area']) ? " AND WDB_A_Name = {$filter['area']} " : null;
        $swhere .= isset($filter['test_officer']) && !empty($filter['test_officer']) ? "  AND TestOfficer = {$filter['test_officer']} " : null;
        $swhere .= isset($filter['file_location']) && !empty($filter['file_location']) ? " AND FileLocation = {$filter['file_location']} " : null;
        $swhere .= isset($filter['owner']) && !empty($filter['owner']) ? " AND A_OR1_OrgID_fk = {$filter['owner']} " : null;
        $swhere .= isset($filter['owner_type']) && !empty($filter['owner_type']) ? " AND OR1_InternalOrExternal = {$filter['owner_type']} " : null;

        $filter = null;
         if(!empty($this->search_criteria)){
        $filter = \Helper_App::build_search_string($this->search_criteria['field_crieteria_01'], $this->search_criteria['field_crieteria_02'], $this->search_criteria['date_crieteria'], $this->SearchCriteria1(), $this->SearchCriteria2(), $this->DateCriteria1());
        }else{
            $filter = '';
        }
        return "WHERE J_YearSeq_pk > 0 {$swst} {$swhere} {$filter} ";
    }

    public function sql_order_by()
    {

         if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY J_FullNumber DESC";
        
        $orderby    = $this->order_by; //TODO, escape $this->order_by
        $sorder_by  = '';

        switch ($orderby['column']) {

            case "Number":
                $sorder_by = "ORDER BY J_YearSeq_pk ". strtoupper($orderby['sort']);
                break;
            case "Description":
                $sorder_by = "ORDER BY A_Description ". strtoupper($orderby['sort']);
                break;
            case "Organisation":
                $sorder_by = "ORDER BY OR1_FullName ".strtoupper($orderby['sort']);
                break;
            case "Status":
                $sorder_by = "ORDER BY FullStatusDaysInt ".strtoupper($orderby['sort']);
                break;
        }

        return $sorder_by;
    }

    public function SearchCriteria1()
    {
        

        $filter = $this->search_criteria;
        $filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria']))
            return null;
        
        $sql = null;
        

        switch ($filter['field']) {
            case 'Artefact Description':
                $sql = 'A_Description ';
                break;
            case 'Artefact Make':
                $sql = 'A_Description ';
                break;
            case 'Artefact Model':
                $sql = 'A_Model ';
                break;
            case 'Artefact Owner':
                $sql .= 'OR1_Name_ind ';
                break;
            case 'Artefact Serial number':
                $sql = 'A_SerialNumber ';
                break;
            case 'Certificate offered':
                $sql = 'Q_CertificateOffered ';
                break;
            case 'Internal delivery instructions':
                $sql = 'Q_DeliveryInstructions ';
                break;
            case 'Purchase order number':
                $sql = 'Q_PurchaseOrderNumber ';
                break;
            case 'Job number':
                $sql = 'J_FullNumber ';
                break;
            case 'Quote sent method':
                $sql = 'Q_SentMethod ';
                break;
            case 'Services offered':
                $sql = 'Q_ServicesOffered ';
                break;
            case 'Special requirements':
                $sql = 'Q_SpecialRequirements ';
                break;
            
        }
        
                $option1='';
                $option2='';
                        if($filter['equality']=="LIKE"||$filter['equality']=="NOT LIKE"){
                    $option1='yes';

                }else{
                    $option1='no';
                }
                if($filter['equality']=="STARTS WITH"||$filter['equality']=="ENDS WITH"){
                    $option2='yes';

                }else{
                    $option2='no';
                }
        
        
        //print_r($option1.' '.$option2);exit;
            if($filter['Intelligent']=='yes'&& $filter['field']=='Artefact Serial number' &&($option1=='yes'||$option2=='yes') ){
             
                $criteria=$this->intelligent_search($filter['criteria']);
            }else{
                $criteria=$filter['criteria'];
            }
            
        switch ($filter['equality']) {
            case "LIKE":
                $sql .= "LIKE '%" . $criteria . "%' ";
                break;
            case "NOT LIKE":
                $sql .= "NOT LIKE '%" . $criteria . "%' ";
                break;
            case "EQUAL TO":
                $sql .= "= '" . $criteria . "' ";
                break;
            case "NOT EQUAL TO":
                $sql .= "<> '" . $criteria . "' ";
                break;
            case "STARTS WITH":
                $sql .= "LIKE '" . $criteria . "%' ";
                break;
            case "ENDS WITH":
                $sql .= "LIKE '%" . $criteria . "' ";
                break;
        }
        
        
        
        return $sql;
    }
    
    public function SearchCriteria2()
    {

        $filter = $this->search_criteria;
        $filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['advance']['field']) || empty($filter['advance']['equality']) || empty($filter['advance']['criteria']))
            return null;

        $sql = null;
        

        switch ($filter['advance']['field']) {
            case 'Artefact Description':
                $sql = 'A_Description ';
                break;
            case 'Artefact Make':
                $sql = 'A_Description ';
                break;
            case 'Artefact Model':
                $sql = 'A_Model ';
                break;
            case 'Artefact Owner':
                $sql = 'OR1_Name_ind ';
                break;
            case 'Artefact Serial number':
                $sql = 'A_SerialNumber ';
                break;
            case 'Certificate offered':
                $sql = 'Q_CertificateOffered ';
                break;
            case 'Internal delivery instructions':
                $sql = 'Q_DeliveryInstructions ';
                break;
            case 'Purchase order number':
                $sql = 'Q_PurchaseOrderNumber ';
                break;
            case 'Job number':
                $sql = 'J_FullNumber ';
                break;
            case 'Quote sent method':
                $sql = 'Q_SentMethod ';
                break;
            case 'Services offered':
                $sql = 'Q_ServicesOffered ';
                break;
            case 'Special requirements':
                $sql = 'Q_SpecialRequirements ';
                break;
        }
        $option1='';
        $option2='';
                if($filter['advance']['equality']=="LIKE"||$filter['advance']['equality']=="NOT LIKE"){
            $option1='yes';
        
        }else{
            $option1='no';
        }
        if($filter['advance']['equality']=="STARTS WITH"||$filter['advance']['equality']=="ENDS WITH"){
            $option2='yes';
        
        }else{
            $option2='no';
        }
        
        if($filter['Intelligent']=='yes'&& ($option1=='yes'||$option2=='yes') ){
             
             $criteria2=$this->intelligent_search($filter['advance']['criteria']);
         }else{
            $criteria2=$filter['advance']['criteria'];
         }

        switch ($filter['advance']['equality']) {
            case "LIKE":
                $sql .= "LIKE '%" . $criteria2 . "%' ";
                break;
            case "NOT LIKE":
                $sql .= "NOT LIKE '%" . $criteria2 . "%' ";
                break;
            case "EQUAL TO":
                $sql .= "= '" . $criteria2 . "' ";
                break;
            case "NOT EQUAL TO":
                $sql .= "<> '" . $criteria2 . "' ";
                break;
            case "STARTS WITH":
                $sql .= "LIKE '" . $criteria2 . "%' ";
                break;
            case "ENDS WITH":
                $sql .= "LIKE '%" . $criteria2 . "' ";
                break;
        }

            return $sql;
    }
    
    
     public function DateCriteria1()
    {
         $filter    = $this->search_criteria;
         $sql       = null;
         $from_date = null;
         $to_date   = null;
         $what_to_apply = null;
         
        if (empty($this->search_criteria) && empty($filter['date']['field']) && empty($filter['date']['from']) && empty($filter['date']['to']))
            return null;
        
        if(isset($filter['date']['from']) || (!empty($filter['date']['from'])))
             $from_date = \Helper_App::FormatDateForSql($filter['date']['from']);
        
        if(isset($filter['date']['to']) || (!empty($filter['date']['to'])))
             $to_date = \Helper_App::FormatDateForSql($filter['date']['to']);
        
         if(!isset($filter['date']['from']) || (empty($filter['date']['from'])))//TODO false || false => true oO
         {
            $what_to_apply =  "To date only";
         }
         else if(!isset($filter['date']['to']) || (empty($filter['date']['to'])))
         {
             $what_to_apply =  "From date only";
         }
         else 
         {
             $what_to_apply = "To and from date";
         }
         
         switch ($filter['date']['field']) {
            
                case 'Planned Start Date':
                    if($what_to_apply == "To date only"){
                       $sql = "J_PlannedStartDate <= "  . "'" . $to_date  . "'" ;
                    }else if($what_to_apply == "From date only"){
                       $sql = "J_PlannedStartDate >= "  . "'" . $from_date  . "'" ;
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(J_PlannedStartDate >= "  . "'" . $from_date  . "'" . " AND J_PlannedStartDate <= "  . "'" . $to_date  . "'" . ") ";
                    }
                break;
                
                case 'Actual Start Date':
                    if($what_to_apply == "To date only"){
                       $sql = "J_ActualStartDate <= "  . "'" . $to_date  . "'" ;
                    }else if($what_to_apply == "From date only"){
                      $sql = "J_ActualStartDate >= "  . "'" . $from_date  . "'" ;
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(J_ActualStartDate >= "  . "'" . $from_date  . "'" . " AND J_ActualStartDate <= "  . "'" . $to_date  . "'" . ") ";
                    }
                 break;
                
                case 'Outcome Date':
                    if($what_to_apply == "To date only"){
                        $sql = "J_OutComeDate <= "  . "'" . $to_date  . "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "J_OutComeDate >= "  . "'" . $from_date  . "'";
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(J_OutComeDate >= " . "'" . $from_date . "'" . " AND J_OutComeDate <= " . "'" . $to_date . "'" . ") ";
                    }
                 break;
                
                 case 'Date returned to store':
                    if($what_to_apply == "To date only"){
                        $sql = "J_DateInstReturnedToStore <= "  . "'" . $to_date  . "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "J_DateInstReturnedToStore >= "  . "'" . $from_date  . "'" ;
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(J_DateInstReturnedToStore >= "  . "'" . $from_date  . "'" . " AND J_DateInstReturnedToStore <= "  . "'" . $to_date  . "'" . ") ";
                    }
                 break;
                
                 case 'Testing start date':
                    if($what_to_apply == "To date only"){
                        $sql = "J_TestStartDate <= "  . "'" . $to_date  . "'" ;
                    }else if($what_to_apply == "From date only"){
                        $sql = "J_TestStartDate >= "  . "'" . $from_date  . "'" ;
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(J_TestStartDate >= "  . "'" . $from_date  . "'" . " AND J_TestStartDate <= "  . "'" . $to_date  . "'" . ") ";
                    }
                 break;
                
                case 'Testing end date':
                    if($what_to_apply == "To date only"){
                        $sql = "J_TestEndDate <= "  . "'" . $to_date  . "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "J_TestEndDate >= "  . "'" . $from_date  . "'" ;
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(J_TestEndDate >= "  . "'" . $from_date  . "'" . " AND J_TestEndDate <= "  . "'" . $to_date  . "'" . ") ";
                    }
                 break;
          }
          
        return $sql;
    }
    public function intelligent_search($search_criteria)
    {
        $sXX = "a####b";
        
        $search_criteria = str_replace('0', $sXX, $search_criteria);
        $search_criteria = str_replace('o', $sXX, $search_criteria);
        $search_criteria = str_replace($sXX, '[0o]', $search_criteria);
        
        $search_criteria = str_replace('1', $sXX, $search_criteria);
        $search_criteria = str_replace('i', $sXX, $search_criteria);
        $search_criteria = str_replace($sXX, '[1i]', $search_criteria);
        
        $search_criteria = str_replace('2', $sXX, $search_criteria);
        $search_criteria = str_replace('z', $sXX, $search_criteria);
        $search_criteria = str_replace($sXX, '[2z]', $search_criteria);
        
        $search_criteria = str_replace('5', $sXX, $search_criteria);
        $search_criteria = str_replace('s', $sXX, $search_criteria);
        $search_criteria = str_replace($sXX, '[5s]', $search_criteria);
        
        $search_criteria = str_replace('/', $sXX, $search_criteria);
        $search_criteria = str_replace('\\', $sXX, $search_criteria);
        $search_criteria = str_replace('|', $sXX, $search_criteria);
        $search_criteria = str_replace('_', $sXX, $search_criteria);
        $search_criteria = str_replace('-', $sXX, $search_criteria);
        $search_criteria = str_replace('.', $sXX, $search_criteria);
        $search_criteria = str_replace(' ', $sXX, $search_criteria);
        $search_criteria = str_replace($sXX, '[ ./\|_-]', $search_criteria);
        
        return $search_criteria;
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

        //calling query builders
        $select = $this->sql_select();
        $from   = $this->sql_from();
        $where  = $this->sql_where();
        $order_by = $this->sql_order_by();

        $full_sql = "WITH NumberedRows AS 
                (
                    {$select},
                        Row_Number() OVER ({$order_by}) AS RowNumber 
                    {$from}
                    {$where}
                    
                ) 
                SELECT * FROM NumberedRows";
                
        //$page_sql   = $full_sql . ' ' . $paging;
                    $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by; 
      
        
        $count_sql  = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT J_FullNumber) AS [count] FROM NumberedRows', ''), $full_sql);

        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }


    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------


    public function get_branches()
     {

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT WDB_B_Name {$from} {$where}";
        $sql   .= "ORDER BY WDB_B_Name ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }

    public function get_sections() 
      {

        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql   = "SELECT DISTINCT WDB_S_Name {$from} {$where}";
        $sql  .= "ORDER BY WDB_S_Name ASC";
        
         $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
    }

    public function get_projects()
    {

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT WDB_P_Name {$from} {$where}";
        $sql    .= "ORDER BY WDB_P_Name ASC";
        
         $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
    }

    public function get_areas()
    {

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT WDB_A_Name {$from} {$where}";
        $sql    .= "ORDER BY WDB_A_Name ASC";
        
         $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }

    public function get_types()
    {
        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT A_Type {$from} {$where}";
        $sql    .= "ORDER BY A_Type ASC";
        
         $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
    }
    
     public function get_owns()
     { 
        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT  A_OR1_OrgID_fk, OR1_FullName {$from} {$where}";
        $sql    .= "ORDER BY OR1_FullName ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'A_OR1_OrgID_fk', 'OR1_FullName');
    }

    /**
     * Get test officers list, filters are done according to $this->filter
     * @return Array names of test officers
     */
    public function get_test_officers() 
    { 
        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT TestOfficer {$from} {$where}";
        $sql    .= "ORDER BY TestOfficer ASC";

        $types   = \NMI::Db()->query($sql)->fetchAll();
        
        return \Arr::assoc_to_keyval($types, 'TestOfficer', 'TestOfficer');
    }

    /**
     * Get a specific job, used in main form
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author  Sahan <[email]>
     */
    public static function get_job($id)
    {
        $stmt = \NMI::Db()->prepare("SELECT * from t_Job WHERE J_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $job = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(empty($job))
            return false;

        //full status string
        $stmt = \NMI::Db()->prepare("SELECT J_FullNumber, FullStatusString FROM vw_JobListing WHERE J_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $meta = $stmt->fetch();
        
        return array_merge( (array) $job, (array) $meta );
    }

    /**
     * Delete a job
     * @param  [type] $J_YearSeq_pk [description]
     * @return [type]               [description]
     */
    public static function delete($J_YearSeq_pk)
    {
        $sql = "sp_delete_from_t_Job_and_t_Report :J_YearSeq_pk";

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('J_YearSeq_pk', $J_YearSeq_pk);
           
        return $stmt->execute();
    }

    public static function get_report_expiry_date()
    {
        $stmt = \NMI::Db()->prepare("SELECT DISTINCT R_ValidityPeriodInMonths FROM t_Report WHERE R_ValidityPeriodInMonths IS NOT NULL ORDER BY R_ValidityPeriodInMonths ASC");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Result set used to generate the Excel
     * @return [type] [description]
     */
    public function excel_results()
    {
        $sql = "SELECT ";

        if($this->limit != 'ALL' and $this->limit > 0)
        {
            $limit  = \NMI_Db::escape((int) $this->limit);
            $sql .= "TOP {$limit} ";
        }
        
        
        $sql .=  " J_FullNumber AS JobNumber, A_Description AS [Description], TestOfficer, ";
        $sql .=  "A_Type AS Type, A_Make AS Make, A_Model AS Model, A_SerialNumber AS SerialNumber, ";
        $sql .=  "A_PerformanceRange AS PerformanceRange, OR1_FullName AS Owner, J_FeeDue AS FeeDue, ";
        $sql .=  "Q_ServicesOffered AS ServicesOffered, Q_CertificateOffered AS CertificateOffered, Q_SpecialRequirements AS SpecialConditions, ";
        $sql .=  "Q_PurchaseOrderNumber AS PurchaseOrderNumber, A_CF_FileNumber_fk AS CbFileNumber, dbo.fn_DateInWords(J_TestStartDate) as TestingStartDate, dbo.fn_DateInWords(J_TestEndDate) AS TestingEndDate, ";
        $sql .=  "dbo.fn_DateInWords(J_PlannedStartDate) AS PlannedStartDate, dbo.fn_DateInWords(J_ActualStartDate) AS ActualStartDate, ";
        $sql .=  "dbo.fn_DateInWords(J_OutComeDate) AS JobOutComeDate, dbo.fn_DateInWords(J_DateInstReturnedToStore) AS DateInstReturnedToStore, ";
        $sql .=  "J_OutCome As JobOutcome, FullStatusString, J_YearSeq_pk, FullStatusDaysInt, ";
        $sql .=  "(SELECT dbo.fn_DateInWords(Q_TargetReportDespatchDate) FROM t_Quote WHERE Q_YearSeq_pk = J_YearSeq_pk) AS TargetReportDespatchDate ";
        
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_order_by();
        

        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    /**
     * Delay Log
     * @author Namal
     */
    
    public static function add_delay_log($JD_Type, $JD_EmployeeFullname, $JD_Startdate, $JD_Description, $JD_J_YearSeq_fk_ind)
    {
         $sql = "
            SET NOCOUNT ON
            DECLARE @return_value int

            EXEC    @return_value = [sp_insert_into_t_JobDelay]
                    @JD_Type = :JD_Type,
                    @JD_EmployeeFullnameNoTitle = :JD_EmployeeFullname,
                    @JD_Startdate = :JD_Startdate,
                    @JD_Description = :JD_Description,
                    @JD_J_YearSeq_fk_ind = :JD_J_YearSeq_fk_ind,
                    @JD_DelayID_pk = :JD_DelayID_pk

            SELECT  'return' = @return_value";

            $stmt = \NMI::Db()->prepare($sql);
            
            $stmt->bindValue('JD_Type', $JD_Type);
            $stmt->bindValue('JD_EmployeeFullname', $JD_EmployeeFullname);
            $stmt->bindValue('JD_Startdate', $JD_Startdate);
            $stmt->bindValue('JD_Description', $JD_Description);
            $stmt->bindValue('JD_J_YearSeq_fk_ind', $JD_J_YearSeq_fk_ind);
            $stmt->bindParam('JD_DelayID_pk', $JD_DelayID_pk, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 6);
            
            $stmt->execute();
            
            if ($row = $stmt->fetch()) {
                return (int) $row['return'];
            } else {
                return false;
        }
    }
       
    /**
     * lisitin job delay log
     * @author
     */
    public static function delay_list_log($J_YearSeq_pk)
    {
        $sql  = "SELECT * FROM t_JobDelay where JD_J_YearSeq_fk_ind = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $J_YearSeq_pk);
        $stmt->execute();
        return $stmt->fetchAll();
    
    }
    

    /**
     * Email/Melb link
     * @return [type] [description]
     */
    public static function email_melb_link($job_id)
    {
        $quote = \Quotes\Model_Quote::get_quote($job_id);
        $artefact = \Artefacts\Model_Artefact::get_artefact($job_id);

        //cb files
        $cbfile = \Files\Model_File::get_cb_file($artefact['A_CF_FileNumber_fk']);

        //email data
        $emails = \NMI::current_user('email').';carolyn.murray@measurement.gov.au';

        $subject = "QUOTE {$quote['Q_FullNumber']} HAS BEEN {$quote['Q_OutCome']} ON {$quote['Q_OutComeDate']}";

        $body  = "CB File details: \t\n\nNo.:\t {$cbfile['CF_FileNumber_pk']} \n";
        $body .= "Title: \t {$cbfile['CF_Title']} \t";

        return array('to' => $emails, 'subject' => $subject, 'message' => $body);
    }
    
    /**
     * Email NMI Client
     * @author Namal
     */
    public static function email_nmi_client($job_id)
    {
        
        $job = self::get_job($job_id);
        
        $R_FullNumber_pk = str_replace('J', 'RN', $job['J_FullNumber']);
        
        $report     = \Reports\Model_Report::get_report($R_FullNumber_pk);
        $artefact   = \Artefacts\Model_Artefact::get_artefact($job_id);
        $quote      = \Quotes\Model_Quote::get_quote($job_id);
        $work_done  = \Quotes\Model_Quote::get_worklog($quote['Q_YearSeq_pk']);
        $employee   = \Employees\Model_Employee::get_all_employee($work_done[0]['WDB_TestOfficerEmployeeID']); //$EM1_EmployeeID_pk
        $has_contact= \Contacts\Model_Contact::is_contact($artefact['A_ContactID']);
        
        if ($has_contact == 0) {
            return false;    
            exit;
           
        } else {
            
            $contacts       = \Contacts\Model_Contact::get_contact($artefact['A_ContactID']);
            
            $employee_name  = $employee['EM1_Title'].' '.$employee['EM1_Fname'].' '.$employee['EM1_Lname_ind'];
            $employee_email = $employee['EM1_Email'];
            
            $phone = explode(' ', $employee['EM1_Phone']);
            
            $Date_Instrument_Required = $quote['Q_DateInstRequired'];
            
            $client_email='';
    
            if(isset($contacts->CO_Email) && !empty($contacts->CO_Email)){
                $client_email = $contacts->CO_Email.';';
            }
            
            $contact_name  = $contacts->CO_Title.' '.$contacts->CO_Fname.' '.$contacts->CO_Lname_ind;
            
            $sEmailAddress = $client_email.$employee_email;
            
            $sEmailSubject = $R_FullNumber_pk.":  ".$artefact['A_Description'];
            
            $sEmailBody  = "ATTENTION ".$contact_name.".\n\n";
            $sEmailBody .= "Report " .$R_FullNumber_pk. " has been created for the above instrument.  Please send the instrument to " .$employee_name. " on " .$Date_Instrument_Required."\n\n";
            $sEmailBody .= "Contact Test Officer " .$employee_name. " (EXT. " .$phone[0]. ") if you require any further information.";
        
            return array('address' => $sEmailAddress, 'subject' => $sEmailSubject, 'body' => $sEmailBody);
    
        }
    }
    
     /**
     * add end date for job delay
     * @author Namal
     */
     public static function add_end_date($JD_EndDate, $JD_DelayID_pk)
    {
        $sql  = "UPDATE t_JobDelay SET JD_EndDate = ? WHERE JD_DelayID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $JD_EndDate);
        $stmt->bindValue(2, $JD_DelayID_pk);
        return $stmt->execute();
    }
     
    
    /**
     * delete job delay
     * @author Namal
     */
    
    public static function delete_job_delay($QM_QuoteModuleID_pk)
    {
        $sql = "sp_delete_from_t_JobDelay :QM_QuoteModuleID_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('QM_QuoteModuleID_pk', $QM_QuoteModuleID_pk);
        
        return $stmt->execute();
    }
    
    /**
     * Work done by in job tab
     * @author Namal
     */
    
    public static function get_work_done_by( $WDB_YearSeq_fk_ind )
    {
        $sql  = "SELECT * FROM t_WorkDoneBy WHERE WDB_YearSeq_fk_ind = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $WDB_YearSeq_fk_ind);
        $stmt->execute();
        
        return $stmt->fetchAll();
        
    }
    
    /**
     * edit fee due
     * @author Namal
     */
    
    public static function edit_fee_due( $WDB_FeeDue, $WDB_WorkDoneBy_pk,$J_FeeJustification,$J_YearSeq_pk,$J_FeeDue,$J_FeeJustificationStatus)
    {
        $sql  = "UPDATE t_WorkDoneBy SET WDB_FeeDue = :WDB_FeeDue WHERE WDB_WorkDoneBy_pk = :WDB_WorkDoneBy_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('WDB_FeeDue', $WDB_FeeDue);
        $stmt->bindValue('WDB_WorkDoneBy_pk', $WDB_WorkDoneBy_pk);
        $stmt->execute();
        
        $sql = " UPDATE t_Job  SET J_FeeJustification= :J_FeeJustification, J_FeeJustificationStatus= :J_FeeJustificationStatus, J_FeeDue= :J_FeeDue WHERE J_YearSeq_pk = :J_YearSeq_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('J_FeeJustification', $J_FeeJustification);
        $stmt->bindValue('J_FeeJustificationStatus',$J_FeeJustificationStatus);
        $stmt->bindValue('J_YearSeq_pk', $J_YearSeq_pk);
        $stmt->bindValue('J_FeeDue', $J_FeeDue);
        $stmt->execute();
        return $J_FeeDue;
        exit;
    }
    
    /*
     * insert job - from quote tab - accept quote
     * @param $A_YearSeq_pk
     * @return @J_FullNumber
     * @author Namal
     */
    public static function insert_job_from_quote($A_YearSeq_pk)
    {
        //$sql  = "sp_insert_into_t_Job @A_YearSeq_pk=:A_YearSeq_pk, @J_FullNumber=:J_FullNumber";
        $sql = "SET NOCOUNT ON
                DECLARE	@return_value int,
                        @J_FullNumber varchar(10)

                EXEC	@return_value = [dbo].[sp_insert_into_t_Job]
                                @A_YearSeq_pk = ?,
                                @J_FullNumber = ? 

                SELECT	'Return Value' = @return_value            
";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($A_YearSeq_pk,$J_FullNumber));
        
        return $J_FullNumber;
    }
    
    /*
     * psUpdateInvoiceProjectCodeSummary - description
     * @param $J_YearSeq_pk
     * @return null
     * @author Namal
     */
    public static function psUpdateInvoiceProjectCodeSummary($J_YearSeq_pk)
    {
        try{
                // $sql  = "sp_GetProjectCodeData_v2 @J_YearSeq_pk=:J_YearSeq_pk";
                 $sql   =    "SET NOCOUNT ON
                             DECLARE	@return_value int

                             EXEC	@return_value = [dbo].[sp_GetProjectCodeData_v2]
                                             @J_YearSeq_pk = ?

                             SELECT	'Return Value' = @return_value";
                 $stmt = \NMI::Db()->prepare($sql);
                 $stmt->execute(array($J_YearSeq_pk));
        }catch(\PDOException  $e){
            \log::error($e);
            
        }
    }
    
    /*
     * check job exists - description
     * @param $J_YearSeq_pk
     * @return bool
     * @author Namal
     */
    public static function check_job_exists($J_YearSeq_pk)
    {
        $sql = "DECLARE	@return_value int

        EXEC	@return_value = [sp_DoesJobExist]
                @YearSeq_pk = {$J_YearSeq_pk}
        
        SELECT	'Return Value' = @return_value";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        
        $row = $stmt->fetch();
        return $row['Return Value'];
        
    }
    
    /*
     * get_methods_used - description
     * @param $J_YearSeq_pk
     * @return null
     * @author Namal
     */
    public static function get_method_used($J_YearSeq_pk)
    {
        $sql  = "SELECT A_YearSeq_pk,  A_TestMethodUsed FROM t_Artefact WHERE A_YearSeq_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $J_YearSeq_pk);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        return \Arr::assoc_to_keyval($rows, 'A_YearSeq_pk', 'A_TestMethodUsed');
    }
    
    /*
     * get mothod 
     * code by Sri
     */
    public static function get_method_job($YearSeq_pk_ind){
        $sql    =   " SELECT DISTINCT A_TestMethodUsed FROM dbo.t_Artefact INNER Join dbo.t_WorkDoneBy ON A_YearSeq_pk = WDB_YearSeq_fk_ind ";
        $sql    .= " WHERE (WDB_B_Name IN (SELECT DISTINCT WDB_B_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND (WDB_S_Name IN (SELECT DISTINCT WDB_S_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND(WDB_P_Name IN (SELECT DISTINCT WDB_P_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .=  " AND (WDB_A_Name IN (SELECT DISTINCT WDB_A_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND A_TestMethodUsed IS NOT NULL ORDER BY A_TestMethodUsed ASC";
        $rows = \NMI::DB()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'A_TestMethodUsed', 'A_TestMethodUsed');
    }



    /*
     * get_certificate_offered - description
     * @param $arg
     * @return null
     * @author Namal
     */
    public static function get_certificate_offered($J_YearSeq_pk)
    {
        $sql  = "SELECT Q_YearSeq_pk, Q_CertificateOffered FROM t_Quote WHERE Q_YearSeq_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $J_YearSeq_pk);
        $stmt->execute();
        return $stmt->fetch();
    }
    
 
}