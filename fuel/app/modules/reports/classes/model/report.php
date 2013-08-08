<?php

namespace Reports;

class Model_Report extends \Model_Base 
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

        return "FROM vw_ReportListing INNER JOIN vw_WorkDoneBy ON R_J_YearSeq_fk_ind = WDB_YearSeq_fk_ind";
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

                OR1_Name_ind,
                OR1_FullName,
                OR1_InternalOrExternal,
                A_YearSeq_pk,
                A_Type,
                A_Make, A_Model,
                A_SerialNumber,
                A_PerformanceRange, 
                A_Description,
                A_CF_FileNumber_fk,
                FileLocation,
                A_ArtefactMainImagePath, 
                A_OR1_OrgID_fk,
                A_ContactID,
                R_FullNumber_pk,
                R_DateOfReport,
                R_ExpiryApplicable,
                R_ValidityPeriodInMonths,
                R_ExpiryDate,
                R_DateReportSent,
                R_OutCome,
                R_OutComeDate,
                R_LockForm,
                R_ReportNumber, 
                R_ReportPath,
                R_J_YearSeq_fk_ind,
                FullStatusString,
                FullStatusDaysInt,
                R_ReportLateReason,
                R_ReportLateCustSerCategory";
        
    }

    public function sql_where() 
    { 
        
        $filter = $this->filter; //TODO, escape
        $sWSt = '';

        if (isset($filter['status']))
            switch ($filter['status']) {
            

        case "All Live" :
            $sWSt = "AND FullStatusString LIKE 'Live:%' ";
            break;
        case "Live: No report date":
            $sWSt = "AND FullStatusString LIKE 'Live: No report date%' ";
             break;
        case "Live: Ready for sending":
            $sWSt = "AND FullStatusString LIKE 'Live: Ready for sending%' ";
             break;
        case "Live: Has expiry":
            $sWSt = "AND FullStatusString LIKE 'Live: Expiry on%' ";
             break;
        case "All Closed":
            $sWSt = "AND FullStatusString LIKE 'Closed:%' ";
             break;
        case "Closed: No expiry":
            $sWSt = "AND FullStatusString LIKE 'Closed: No expiry%' ";
             break;
        case "Closed: Not Issued":
            $sWSt = "AND FullStatusString LIKE 'Closed: Not Issued%' ";
             break;
        case "Closed: Expired":
            $sWSt = "AND FullStatusString LIKE 'Closed: Expired%' ";
             break;
        case "Closed: Superceeded":
            $sWSt = "AND FullStatusString LIKE 'Closed: Superceeded%' ";
             break;
        case "Closed: Withdrawn":
            $sWSt = "AND FullStatusString LIKE 'Closed: Withdrawn%' ";
             break;
        case "Wrong data":
            $sWSt = "AND FullStatusString LIKE 'Live: Wrong data%' ";
             break;
        }

        $swhere  = '';
        if(isset($filter['type']) and !empty($filter['type']))
        {
            //print_r($filter['type']);exit;
           if($filter['type']=='90&deg; square block'){
               $filter['type']='90° square block';
           }
             $swhere .= "AND A_Type = '{$filter['type']}'"; 
        }else{
            $swhere .= null;
        }
        
        //$swhere .= isset($filter['type']) && !empty($filter['type']) ? "AND A_Type = '{$filter['type']}'" : null;
        $swhere .= isset($filter['branch']) && !empty($filter['branch']) ? "AND WDB_B_Name = '{$filter['branch']}'" : null;
        $swhere .= isset($filter['section']) && !empty($filter['section']) ? "AND WDB_S_Name = '{$filter['section']}'" : null;
        $swhere .= isset($filter['project']) && !empty($filter['project']) ? "AND WDB_P_Name = '{$filter['project']}'" : null;
        $swhere .= isset($filter['area']) && !empty($filter['area']) ? "AND WDB_A_Name = '{$filter['area']}'" : null;
        $swhere .= isset($filter['test_officer']) && !empty($filter['test_officer']) ? "AND TestOfficer = '{$filter['test_officer']}'" : null;
        $swhere .= isset($filter['file_location']) && !empty($filter['file_location']) ? "AND FileLocation = '{$filter['file_location']}'" : null;
        $swhere .= isset($filter['owner']) && !empty($filter['owner']) ? "AND A_OR1_OrgID_fk = '{$filter['owner']}'" : null;
        $swhere .= isset($filter['owner_type']) && !empty($filter['owner_type']) ? "AND OR1_InternalOrExternal = '{$filter['owner_type']}'" : null;
        
        $filter = null;
        if(!empty($this->search_criteria)){
        $filter = \Helper_App::build_search_string($this->search_criteria['field_crieteria_01'], $this->search_criteria['field_crieteria_02'], $this->search_criteria['date_crieteria'], $this->SearchCriteria1(), $this->SearchCriteria2(), $this->DateCriteria1());
        }else{
            $filter = '';
        }
        return "WHERE R_J_YearSeq_fk_ind > 0 {$sWSt} {$swhere} {$filter} ";
    }

    public function sql_orderby() 
    {  

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY R_FullNumber_pk DESC";

        $sorderby = null;
        $order_by = array_merge(array('column' => '', 'sort' => ''), (array) ($this->order_by));
        $order_by['column'] = $this->order_by['column'];

        switch ($order_by['column']) {
          
            case "Number":
                $sorder_by = "ORDER BY R_J_YearSeq_fk_ind " . strtoupper($order_by['sort']) . ", R_ReportNumber " . strtoupper($order_by['sort']);
                break;
            case "Description":
                $sorder_by = "ORDER BY A_Description ". strtoupper($order_by['sort']);
                break;
            case "Client":
                $sorder_by = "ORDER BY OR1_FullName " . strtoupper($order_by['sort']);
                break;
            case "Status":
                $sorder_by = "ORDER BY FullStatusDaysInt ". strtoupper($order_by['sort']);
                break;
        }

        return $sorder_by;
    }

   public function SearchCriteria1() 
    {

        $filter = $this->search_criteria;

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['field_crieteria_01']) || empty($filter['equality']) || empty($filter['criteria']))
            return null;

        $sql = null;
        
//print_r($filter['field']);exit;
        switch ($filter['field']) {
            case "Artefact Description":
                $sql = "A_Description ";
                break;
            case "Artefact Make":
                $sql = "A_Make ";
                break;
            case "Artefact Model":
                $sql = "A_Model ";
                break;
            case "Artefact Owner":
                $sql = "OR1_Name_ind ";
                break;
            case "Artefact Serial number":
                $sql = "A_SerialNumber ";
                break;
            case "Certificate offered":
                $sql = "Q_CertificateOffered ";
                break;
            case "CB File Number":
                $sql = "A_CF_FileNumber_fk ";
                break;
            case "Report number":
                $sql = "R_FullNumber_pk ";
                break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                break;
            case "Test method":
                $sql = "A_TestMethodUsed ";
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
                $sql .= "= '" . $filter['criteria'] . "' ";
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
        //$filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['advance']['field']) || empty($filter['advance']['equality']) || empty($filter['advance']['criteria']))
            return null;

        $sql = null;
        

        switch ($filter['advance']['field']) {
            case "Artefact Description":
                $sql = "A_Description ";
                break;
            case "Artefact Make":
                $sql = "A_Make ";
                break;
            case "Artefact Model":
                $sql = "A_Model ";
                break;
            case "Artefact Owner":
                $sql = "OR1_Name_ind ";
                break;
            case "Artefact Serial number":
                $sql = "A_SerialNumber ";
                break;
            case "Certificate offered":
                $sql = "Q_CertificateOffered ";
                break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                break;
            case "Report number":
                $sql = "R_FullNumber_pk ";
                break;
            case "CB File Number":
                $sql = "A_CF_FileNumber_fk ";
                break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                break;
            case "Test method":
                $sql = "A_TestMethodUsed ";
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
        
        if($filter['Intelligent']=='yes'&& $filter['advance']['field']=='Artefact Serial number' && ($option1=='yes'||$option2=='yes') ){
             
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
        
        
         if(!isset($filter['date']['from']) || (empty($filter['date']['from'])))
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
            
                case 'Date of report':
                    if($what_to_apply == "To date only"){
                       $sql = "R_DateOfReport <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "R_DateOfReport >= '" . $from_date . "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(R_DateOfReport >= '" . $from_date . "' AND R_DateOfReport <= '" . $to_date . "') ";
                    }
                break;
                
                case 'Date report sent':
                    if($what_to_apply == "To date only"){
                       $sql = "R_DateReportSent <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                      $sql = "R_DateReportSent >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(R_DateReportSent >= '" . $from_date . "' AND R_DateReportSent <= '" . $to_date . "') ";
                    }
                 break;
                
                case 'Certificate expiry date':
                    if($what_to_apply == "To date only"){
                        $sql = "R_CertificateExpiryDate <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "R_CertificateExpiryDate >= '" . $from_date . "'";
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(R_CertificateExpiryDate >= '" . $from_date . "' AND R_CertificateExpiryDate <= '" . $to_date . "') ";
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
        $order_by = $this->sql_orderby();

        $full_sql = "WITH NumberedRows AS 
                        (
                        {$select},
                          Row_Number() OVER ({$order_by}) AS RowNumber 
                        {$from}
                        {$where}

                        ) 
                        SELECT * FROM NumberedRows";
                        
                  
                        
                                        
        //$page_sql  = $full_sql . ' ' . $paging;
                        $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by;
        
        $count_sql = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT R_FullNumber_pk) AS [count] FROM NumberedRows', ''), $full_sql);
//print_r($page_sql);exit;
        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------


    public function get_branches()
    {  

        $from    = $this->sql_from();
        $where   = $this->sql_where();
       
        $sql     = "SELECT DISTINCT WDB_B_Name {$from} {$where}";
        $sql    .= "ORDER BY WDB_B_Name ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }

    public function get_sections()
    { 

        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT WDB_S_Name {$from} {$where}";
        $sql    .= "ORDER BY WDB_S_Name ASC";
        
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
        
        $rows    = \NMI::Db()->query($sql)->fetchAll();
        $data    = \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
        return array_filter($data, 'strlen');
    }
    
    public function get_owns()
    { 
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT  A_OR1_OrgID_fk, OR1_FullName {$from} {$where}";
        $sql   .= "ORDER BY OR1_FullName ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'A_OR1_OrgID_fk', 'OR1_FullName');
    }
    
    
    public function get_test_offices() 
    { 
        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT TestOfficer {$from} {$where}";
        $sql    .= " ORDER BY TestOfficer ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'TestOfficer', 'TestOfficer');
    }
    
    /**
     * Get reports for a specfic job
     * Relation t_job.J_YearSeq_pk => .t_ReportR_J_YearSeq_fk_ind
     * @uptatedby Sahan
     * @author Namal 
     */   
    
    public static function get_reports($A_YearSeq_pk)
    {
        $sql  = "SELECT R_FullNumber_pk, R_CreationDate, R_ContactID, R_DocumentSignerID, R_ReportAddress1, R_ReportAddress2, ";
        $sql .= "R_ReportAddress3, R_ReportAddress4, R_DateOfReport, R_ExpiryApplicable, R_ValidityPeriodInMonths, R_CoverLetterAddress1, ";
        $sql .= "R_CoverLetterAddress2, R_CoverLetterAddress3, R_CoverLetterAddress4, R_ExpiryDate,R_ReadyForSending, R_DateReportSent, ";
        $sql .= "R_OutCome, R_OutComeDate, R_Status, R_SignificantDate, R_LockForm , R_ReportNumber, R_ReportTotalNumber, ";
        $sql .= "R_ReportNumberString, R_CertificateExpiryDate, R_ReportPath, R_Comments, R_J_YearSeq_fk_ind, R_HighlightComment, ";
        $sql .= "R_NmiSignatoryID, R_NataSignatoryID, R_ReportAddressedToFullName, R_ReportWithItem, R_CertValidityPeriodInYears,  ";
        $sql .= "R_ReportLateReason, R_ReportLateCustSerCategory FROM t_Report WHERE R_J_YearSeq_fk_ind = ? ORDER BY R_ReportNumber DESC, ";
        $sql .= "R_ReportTotalNumber DESC ";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $A_YearSeq_pk);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get a single report
     * @param  [type] $report_id [R_FullNumber_pk]
     * @return Array            [description]
     * @author Sahan <[email]>
     */
    public static function get_report($R_FullNumber_pk)
    {
        $sql  = "SELECT R_FullNumber_pk, R_CreationDate, R_ContactID, R_DocumentSignerID, R_ReportAddress1, R_ReportAddress2, ";
        $sql .= "R_ReportAddress3, R_ReportAddress4, R_DateOfReport, R_ExpiryApplicable, R_ValidityPeriodInMonths, R_CoverLetterAddress1, ";
        $sql .= "R_CoverLetterAddress2, R_CoverLetterAddress3, R_CoverLetterAddress4, R_ExpiryDate,R_ReadyForSending, R_DateReportSent, ";
        $sql .= "R_OutCome, R_OutComeDate, R_Status, R_SignificantDate, R_LockForm , R_ReportNumber, R_ReportTotalNumber, ";
        $sql .= "R_ReportNumberString, R_CertificateExpiryDate, R_ReportPath, R_Comments, R_J_YearSeq_fk_ind, R_HighlightComment, ";
        $sql .= "R_NmiSignatoryID, R_NataSignatoryID, R_ReportAddressedToFullName, R_ReportWithItem, R_CertValidityPeriodInYears,  ";
        $sql .= "R_ReportLateReason, R_ReportLateCustSerCategory FROM t_Report WHERE R_FullNumber_pk = ?";

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $R_FullNumber_pk);
        $stmt->execute();
        $report = $stmt->fetch();

        //full status string
        $sql  = "SELECT R_FullNumber_pk, FullStatusString FROM vw_ReportListing WHERE R_FullNumber_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($R_FullNumber_pk));
        $meta = $stmt->fetch();
        
        return array_merge( (array) $report, (array) $meta );

    }
    
     /**
      * get_nmi_signatory
     * @author Namal <[email]>
     */
    
    
    public static function get_nmi_signatory($R_FullNumber_pk)
    {
    
         $sql  = "SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst ";
         $sql .= "FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk ";
         $sql .= "INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk INNER JOIN ";
         $sql .= "t_WorkDoneBy ON P_Name_ind = WDB_P_Name WHERE EM1_IsNmiSignatory = 1 AND WDB_YearSeq_fk_ind = ?";
         $sql .= " ORDER BY EM1_LastNameFirst ASC";
         
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($R_FullNumber_pk));
        $row  = $stmt->fetchAll();
         
        return \Arr::assoc_to_keyval($row, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    }
    
     /**
      * get_nata_signatory
     * @author Namal <[email]>
     */
    
    
    public static function get_nata_signatory($R_FullNumber_pk)
    {
    
        $sql  = "SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst ";
        $sql .= "FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk ";
        $sql .= "INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk INNER JOIN ";
        $sql .= "t_WorkDoneBy ON P_Name_ind = WDB_P_Name WHERE EM1_IsNataSignatory = 1 AND WDB_YearSeq_fk_ind = ?"; 
        $sql .= " ORDER BY EM1_LastNameFirst ASC";
    
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($R_FullNumber_pk));
        $row = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($row, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    
    }
    
      /**
       * get_letter_signed_by
     * @author Namal <[email]>
     */
    
    
     public static function get_letter_signed_by($R_FullNumber_pk)
     {
         
        $sql  = "SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst ";
        $sql .= "FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk ";
        $sql .= "INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk INNER JOIN ";
        $sql .= "t_WorkDoneBy ON P_Name_ind = WDB_P_Name WHERE WDB_YearSeq_fk_ind =? ";
        $sql .= "ORDER BY EM1_LastNameFirst ASC";
                   
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($R_FullNumber_pk));
        $row  =  $stmt->fetchAll();
        return \Arr::assoc_to_keyval($row, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
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
        
        $sql .=  "R_FullNumber_pk AS ReportNumber, A_Description AS [Description], TestOfficer, ";
        $sql .=  "A_Type AS Type, A_Make AS Make, A_Model AS Model, A_SerialNumber AS SerialNumber, A_TestMethodUsed AS TestMethod, ";
        $sql .=  "A_PerformanceRange AS PerformanceRange, OR1_FullName AS Owner, ";
        $sql .=  "Q_ServicesOffered AS ServicesOffered, Q_CertificateOffered AS CertificateOffered, Q_SpecialRequirements AS SpecialConditions, ";
        $sql .=  "Q_PurchaseOrderNumber AS PurchaseOrderNumber, A_CF_FileNumber_fk AS CbFileNumber, ";
        $sql .=  "dbo.fn_DateInWords(R_DateOfReport) AS DateOfReport, R_ValidityPeriodInMonths AS ValidityPeriodInMonths, ";
        $sql .=  "dbo.fn_DateInWords(R_ExpiryDate) AS ExpiryDate, dbo.fn_DateInWords(R_DateReportSent) AS DateReportSent, ";
        $sql .=  "R_OutCome AS ReportOutcome, dbo.fn_DateInWords(R_OutComeDate) AS ReportOutComeDate, dbo.fn_DateInWords(R_CertificateExpiryDate) AS CertificateExpiryDate, ";
        $sql .=  "FullStatusString , R_ReportNumber, R_J_YearSeq_fk_ind, FullStatusDaysInt, R_ReportWithItem, R_ReportLateReason, R_ReportLateCustSerCategory, ";
        $sql .=  "(SELECT dbo.fn_DateInWords(Q_TargetReportDespatchDate) FROM t_Quote WHERE Q_YearSeq_pk =R_J_YearSeq_fk_ind) AS TargetReportDespatchDate ";
      
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();

        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    /**
     * Insert next Revision
     * @param int A_YearSeq_pk
     * @author Namal
     */
    public static function insert_next_revision($A_YearSeq_pk)
    {
        $sql = "sp_insert_into_t_Report @A_YearSeq_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($A_YearSeq_pk));
    }
    
    /**
     * Delete revision
     * @param 
     * @author Namal 
     */
    public static function delete_report($R_FullNumber_pk)
    {
        $sql = "SET NOCOUNT ON
                DECLARE	@return_value int

                EXEC	@return_value = [dbo].[sp_delete_from_t_Report]
                        @R_FullNumber_pk = :R_FullNumber_pk

                SELECT	'Return Value' = @return_value";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('R_FullNumber_pk', $R_FullNumber_pk);
        
        $stmt->execute();
        
        $return = $stmt->fetch();
        return $return['Return Value'];
     
    }
    
    /*
     * function cb_file_cover_sheet - get word file data for cb_file cover sheet
     * @param int $R_FullNumber_pk
     * @return null
     * @author Namal
     */
    public static function cb_file_cover_sheet($R_FullNumber_pk)
    {
        $sql = "sp_ReportMergeData @R_FullNumber_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($A_YearSeq_pk));
        
        return $stmt->fetchAll();
    }
    
    /*
     * function get_report_merge_data - for word download
     * @param $R_FullNumber_pk
     * @return array
     * @author Namal
     */
    public static function get_report_merge_data($R_FullNumber_pk)
    {
        $sql = "sp_ReportMergeData_v2 @R_FullNumber_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($R_FullNumber_pk));
        
        return $stmt->fetchAll();
    }
    
    public static function get_rp_exper_date_month()
    {
       $row = \NMI::Db()->query(" SELECT DISTINCT R_ValidityPeriodInMonths
        FROM          t_Report
        WHERE      R_ValidityPeriodInMonths IS NOT NULL
        ORDER BY R_ValidityPeriodInMonths ASC ")->fetchAll();
       
       return \Arr::assoc_to_keyval($row, 'R_ValidityPeriodInMonths', 'R_ValidityPeriodInMonths');
       
    }
    
    public static function get_contact_org_info($R_J_YearSeq_fk_ind){
        $row = \NMI::DB()->query(" SELECT DISTINCT CS_OrganisationFullName FROM t_ContactSurvey WHERE CS_R_J_YearSeq_fk_ind='".$R_J_YearSeq_fk_ind."'")->fetchAll();
        if(count($row)>0){
            return $row[0];
         }
    
    }
    
    
}