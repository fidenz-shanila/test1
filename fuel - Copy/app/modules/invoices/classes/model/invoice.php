<?php

namespace Invoices;

class Model_Invoice extends \Model_Base 
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
        return "FROM vw_InvoiceListing INNER JOIN vw_WorkDoneBy ON J_YearSeq_pk = WDB_YearSeq_fk_ind";
    }

    public function sql_select()
    {

        if ($this->offset)
        {
            $this->limit = $this->limit + $this->offset;
        }

        $limit   = $this->limit;
        $s_limit = null;

        if ($limit)
            $s_limit = " TOP {$this->limit} ";

       

        return "SELECT DISTINCT {$s_limit}
                OR1_Name_ind,
                OR1_FullName,
                A_Description,
                OR1_InternalOrExternal,
                A_YearSeq_pk,
                A_Type,
                A_Make,
                A_Model,
                A_SerialNumber,
                A_PerformanceRange
                A_CF_FileNumber_fk,
                FileLocation,
                A_OR1_OrgID_fk,
                A_ContactID,
                J_YearSeq_pk,
                J_FullNumber,
                J_FeeDue,
                FullStatusString,
                FullStatusDaysInt";
        
    }

    public function sql_where()
    {                                            

        $filter = ($this->filter); //TODO, escape filter
        $sWSt = '';

        if (isset($filter['status']))
            switch ($filter['status']) {
                               
                
        case "All Live":
            $sWSt = "AND FullStatusString LIKE 'Live:%' ";
        break;
        case "Live: No quoted price":
            $sWSt = "AND FullStatusString LIKE 'Live: No quoted price%' ";
        break;
        case "Live: Not complete":
            $sWSt = "AND FullStatusString LIKE 'Live: Not complete%' ";
        break;
        case "Live: Fee to be locked":
            $sWSt = "AND FullStatusString LIKE '%fee to be locked%' ";
        break;
        case "Live: Ready for invoicing":
            $sWSt = "AND (FullStatusString LIKE '%ready for inv.%' OR  FullStatusString LIKE '%fee to be locked%') ";
        break;
        case "Live: With finance":
            $sWSt = "AND (FullStatusString LIKE '%ready for inv.%' OR  FullStatusString LIKE '%fee to be locked%') AND FullStatusString LIKE '%with fin.%' ";
        break;
        case "All Closed":
            $sWSt = "AND FullStatusString LIKE 'Closed:%' ";
        break;
        case "Closed: Invoice issued":
            $sWSt = "AND FullStatusString LIKE 'Closed: Invoice%' AND FullStatusString LIKE '%issued%' ";
        break;
        case "Closed: Invoice paid":
            $sWSt = "AND FullStatusString LIKE 'Closed:%' AND FullStatusString LIKE '%paid%' ";
        break;
        case "Wrong data":
            $sWSt = "AND FullStatusString LIKE 'Live: Wrong data%' ";
        break;
        }

        $swhere = ''; 

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
        return "WHERE J_YearSeq_pk > 0 {$sWSt} {$swhere} {$filter} ";
    }

    public function sql_orderby()
    {                                    

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY J_FullNumber DESC";
        $sorderby           = null;
        $order_by           = array_merge(array('column' => '', 'sort' => ''), (array) ($this->order_by));
        $order_by['column'] = $this->order_by['column'];
        $order_by['sort1']   = ($this->order_by['sort']=='desc') ? 'ASC' : 'DESC';

        switch ($order_by['column']) {
          
            case "Number":
                $sorder_by  = "ORDER BY J_YearSeq_pk ".strtoupper($order_by['sort']);
            break;
            case "Description":
                $sorder_by  = "ORDER BY A_Description ".strtoupper($order_by['sort']);
            break;
            case "Fullname":
                $sorder_by  = "ORDER BY OR1_FullName ".strtoupper($order_by['sort']);
            break;
            case "Status":
                $sorder_by  = "ORDER BY FullStatusDaysInt ".strtoupper($order_by['sort']);
            break;
            case "Dev":
                $sorder_by  = "ORDER BY J_FeeDue ".strtoupper($order_by['sort1']);
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
                case "Payment method":
                    $sql = "J_PaymentMethod ";
                    break;
                case "Fee due (unlocked)":
                    $sql = "J_FeeDue ";
                    break;
                case "Fee due (locked)":
                    $sql = "J_FeeDueLocked ";
                    break;
                case "Fee justification":
                    $sql = "J_FeeJustification ";
                    break;
                case "Invoice number":
                    $sql = "J_InvoiceNumber ";
                    break;
                case "Purchase order number":
                    $sql = "Q_PurchaseOrderNumber ";
                    break;
                case "Job number":
                    $sql = "J_FullNumber ";
                    break;
                case "CB file number":
                    $sql = "A_CF_FileNumber_fk ";
                    break;
                case "Services offered":
                    $sql = "Q_ServicesOffered ";
                    break;
                case "Special conditions":
                    $sql = "Q_SpecialRequirements ";
                    break;
        }

                 $option1='';
                $option2='';
                        if($filter['equality']=="LIKE"||$filter['equality']=="NOT LIKE"){
                    $option1='yes';

                }else{
                    $option1='no';
                }
                if($filter['equality']=="LIKE"||$filter['equality']=="NOT LIKE"){
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
                case "Payment method":
                    $sql = "J_PaymentMethod ";
                    break;
                case "Fee due (unlocked)":
                    $sql = "J_FeeDue ";
                    break;
                case "Fee due (locked)":
                    $sql = "J_FeeDueLocked ";
                    break;
                case "Fee justification":
                    $sql = "J_FeeJustification ";
                    break;
                case "Invoice number":
                    $sql = "J_InvoiceNumber ";
                    break;
                case "Purchase order number":
                    $sql = "Q_PurchaseOrderNumber ";
                    break;
                case "Job number":
                    $sql = "J_FullNumber ";
                    break;
                case "CB file number":
                    $sql = "A_CF_FileNumber_fk ";
                    break;
                case "Services offered":
                    $sql = "Q_ServicesOffered ";
                    break;
                case "Special conditions":
                    $sql = "Q_SpecialRequirements ";
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
            
                case 'Invoice date':
                    if($what_to_apply == "To date only"){
                       $sql = "J_InvoiceDate <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "J_InvoiceDate >= " . $from_date . "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(J_InvoiceDate >= '" . $from_date . "' AND J_InvoiceDate <= '" . $to_date . "') ";
                    }
                break;
                
                case 'Paid date':
                    if($what_to_apply == "To date only"){
                       $sql = "J_PaidDate <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "J_PaidDate >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(J_PaidDate >= '" . $from_date . "' AND J_PaidDate <= '" . $to_date . "') ";
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
            $start  = $offset;
            $limit  = $limit + $offset;
            $paging = " where RowNumber > {$start} and RowNumber < {$limit} ";
        }

        $select     = $this->sql_select();
        $from       = $this->sql_from();
        $where      = $this->sql_where();
        $order_by   = $this->sql_orderby();

        $full_sql   = "WITH NumberedRows AS 
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
       // print_r($page_sql);exit;
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
        $sql   .= " ORDER BY WDB_B_Name ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }

    public function get_sections()
    {                                          

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT WDB_S_Name {$from} {$where}";
        $sql   .= " ORDER BY WDB_S_Name ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
    }

    public function get_projects()
    {                                             

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT WDB_P_Name {$from} {$where}";
        $sql   .= " ORDER BY WDB_P_Name ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
    }

    public function get_areas()
    {                                                 

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT WDB_A_Name {$from} {$where}";
        $sql   .= " ORDER BY WDB_A_Name ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }

    public function get_types()
    {                                  
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT A_Type {$from} {$where}";
        $sql   .= " ORDER BY A_Type ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
    }
    
    public function get_owns()
    {                                          
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT  A_OR1_OrgID_fk, OR1_FullName {$from} {$where}";
        $sql   .= " ORDER BY OR1_FullName ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'A_OR1_OrgID_fk', 'OR1_FullName');
    }
    
    public function get_test_offices()
    {                                  
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT TestOfficer {$from} {$where}";
        $sql   .= " ORDER BY TestOfficer ASC";

        $rows   = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'TestOfficer', 'TestOfficer');
    }

    /**
     *@author Namal 
     */
    
    public static function get_invoice_contact_id($iOrgID)
    {
        $sql  = "SELECT CO_ContactID_pk, CO_Lname_ind, CO_Fullname FROM t_Contact INNER JOIN ";
        $sql .= "t_Organisation1 ON CO_OrgID_fk = OR1_OrgID_pk WHERE OR1_OrgID_pk = ?";
        $sql .= " ORDER BY CO_Lname_ind ASC";
      
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($iOrgID));
        $contacts =  $stmt->fetchAll();
        return \Arr::assoc_to_keyval($contacts, 'CO_ContactID_pk', 'CO_Fullname');
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
        
        $sql .= "J_FullNumber AS JobNumber, A_Description AS [Description], TestOfficer, ";
        $sql .= "A_Type AS Type, A_Make AS Make, A_Model AS Model, A_SerialNumber AS SerialNumber, ";
        $sql .= "A_PerformanceRange AS PerformanceRange, OR1_FullName AS Owner, WDB_QuotedPrice AS QuotedPrice, J_FeeDue AS FeeDue, J_FeeDueLocked As FeeDueLocked, ";
        $sql .= "WDB_HoursInDec AS RecordedHoursInDec, J_PaymentMethod AS PaymentMethod, J_FeeJustification AS FeeJustification, ";
        $sql .= "J_InvoiceNumber AS InvoiceNumber, ";
        $sql .= "dbo.fn_DateInWords(J_InvoiceDate) AS InvoiceDate, dbo.fn_DateInWords(J_PaidDate) AS PaidDate, ";
        $sql .= "FullStatusString , J_YearSeq_pk, FullStatusDaysInt, A_CF_FileNumber_fk AS CbFileNo ";
      
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();
        
        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    /**
     * Get invoice address details form
     * @author Namal
     */
    public static function get_address_details()
    {
        $sql  = "SELECT J_YearSeq_pk, OR1_FullName, OR2_ABN FROM t_Job INNER JOIN t_Quote ON J_YearSeq_pk = Q_YearSeq_pk INNER JOIN t_Artefact ON Q_YearSeq_pk = A_YearSeq_pk INNER JOIN t_Organisation1 ON A_OR1_OrgID_fk = OR1_OrgID_pk INNER JOIN t_Organisation2 ON OR1_OrgID_pk = OR2_OrgID_pk_ind";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    
    /** Get addressess
     * @author Namal
     */
    public static function get_addresses()
    {
        $sql = "SELECT OR1_FullName, OR2_OrgID_pk_ind, OR2_Postal1, OR2_Postal2, OR2_Postal3, OR2_Postal4, OR2_Physical1, OR2_Physical2, OR2_Physical3, OR2_Physical4, OR2_Invoice1, OR2_Invoice2, OR2_Invoice3, OR2_Invoice4 FROM t_Organisation1 INNER JOIN t_Organisation2 ON OR1_OrgID_pk = OR2_OrgID_pk_ind";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get puchase order number
     * @author Namal
     */
    public static function get_purchase_order_number($J_YearSeq_pk)
    {
        $sql = "SELECT Q_YearSeq_pk, Q_PurchaseOrderNumber FROM t_Quote WHERE Q_YearSeq_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $J_YearSeq_pk);
        $stmt->execute();
        return $stmt->fetch();
    }
}