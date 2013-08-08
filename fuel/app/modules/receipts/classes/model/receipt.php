<?php

namespace Receipts;

class Model_Receipt extends \Model_Base 
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

        return "FROM vw_ReceiptAndDespatchListing LEFT OUTER JOIN vw_WorkDoneBy ON RD_YearSeq_pk = WDB_YearSeq_fk_ind";
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
                 A_Description,
                 Q_FullNumber,
                 RD_YearSeq_pk,
                 A_ArtefactMainImagePath,
                 FullStatusString,
                 FullStatusDaysInt";
        
    }

    public function sql_where() {

        $filter = $this->filter; //TODO, escape
        $sWSt = '';

        if (isset($filter['status']))
            switch ($filter['status']) {
                               
            case 'All Live':
                $sWSt = "AND FullStatusString LIKE 'Live:%' ";
                break;
            case 'Live: May arrive':
                $sWSt = "AND FullStatusString LIKE '%May arrive%' ";
                break;
            case 'Live: Expected':
                $sWSt = "AND FullStatusString LIKE 'Live: Expected%' "." 'OR FullStatusString LIKE 'Live: May come in%' ";
                break;
            case 'Live: Received':
                $sWSt = "AND FullStatusString LIKE 'Live: Received%' ";
                break;
            case 'Live: Returned to store':
                $sWSt = "AND FullStatusString LIKE 'Live: Returned to store%' ";
                break;
            case 'All Closed':
                $sWSt = "AND FullStatusString LIKE 'Closed%' ";
                break;
            case 'Closed: Despatched':
                $sWSt = "AND FullStatusString LIKE 'Closed: Despatched%' ";
                break;
            case 'Closed: Not despatched':
                $sWSt = "AND FullStatusString LIKE 'Closed:%' AND FullStatusString NOT LIKE 'Closed: Despatched%' ";
                break;
            case 'Closed: Site visit':
                $sWSt = "AND FullStatusString LIKE 'Closed: Site visit%' ";
                break;
            case 'Wrong data':
                $sWSt = "AND FullStatusString LIKE 'Live: Wrong data%' ";
                break;
        }
        
        //$swhere = '';
        //print_r($filter);exit;
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
        return "WHERE RD_YearSeq_pk > 0 {$sWSt} {$swhere} {$filter} ";
    }

    public function sql_orderby()
    { 

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY Q_FullNumber DESC";

        $sorderby = null;
        $order_by = array_merge(array('column' => '', 'sort' => ''), (array)  ($this->order_by));
        $order_by['column'] = $this->order_by['column'];

        switch ($order_by['column']) {
          
            case "Number":
                $sorder_by = "ORDER BY RD_YearSeq_pk " . strtoupper($order_by['sort']);
                break;
            case "Description":
                $sorder_by = "ORDER BY A_Description ". strtoupper($order_by['sort']);
                break;
            case "Fullname":
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
        $filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria']))
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
            case "Internal delivery instructions":
                $sql = "Q_DeliveryInstructions ";
                 break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                 break;
            case "CB file number":
                $sql = "A_CF_FileNumber_fk ";
                 break;
            case "Quote number":
                $sql = "Q_FullNumber ";
                 break;
            case "Return organisation":
                $sql = "RD_ReturnOrganisation ";
                 break;
            case "Return contact":
                $sql = "RD_ReturnContact ";
                 break;
            case "Shipping mode":
                $sql = "RD_ShippingMode ";
                 break;
            case "Shipping urgency":
                $sql = "RD_ShippingUrgency ";
                 break;
            case "Carrier":
                $sql = "RD_CarrierName ";
                 break;
            case "Carrier acc. no.":
                $sql = "RD_CarrierAccountNumber ";
                 break;
            case "Carrier contact":
                $sql = "RD_CarrierContactPerson ";
                 break;
            case "Delivered by":
                $sql = "RD_DeliveredBy ";
                 break;
            case "Delivery con note no.":
                $sql = "RD_DeliveryConNote ";
                 break;
            case "Picked up by":
                $sql = "RD_PickedUpBy ";
                 break;
            case "Insurance instructions":
                $sql = "RD_InsuranceInstructions ";
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
            case "Internal delivery instructions":
                $sql = "Q_DeliveryInstructions ";
                 break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                 break;
            case "CB file number":
                $sql = "A_CF_FileNumber_fk ";
                 break;
            case "Quote number":
                $sql = "Q_FullNumber ";
                 break;
            case "Return organisation":
                $sql = "RD_ReturnOrganisation ";
                 break;
            case "Return contact":
                $sql = "RD_ReturnContact ";
                 break;
            case "Shipping mode":
                $sql = "RD_ShippingMode ";
                 break;
            case "Shipping urgency":
                $sql = "RD_ShippingUrgency ";
                 break;
            case "Carrier":
                $sql = "RD_CarrierName ";
                 break;
            case "Carrier acc. no.":
                $sql = "RD_CarrierAccountNumber ";
                 break;
            case "Carrier contact":
                $sql = "RD_CarrierContactPerson ";
                 break;
            case "Delivered by":
                $sql = "RD_DeliveredBy ";
                 break;
            case "Delivery con note no.":
                $sql = "RD_DeliveryConNote ";
                 break;
            case "Picked up by":
                $sql = "RD_PickedUpBy ";
                 break;
            case "Insurance instructions":
                $sql = "RD_InsuranceInstructions ";
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
            
                case 'Date despatched':
                    if($what_to_apply == "To date only"){
                       $sql = "RD_DespatchedDate <= '" . $to_date ."'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "RD_DespatchedDate >= '" . $from_date.'"';
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(RD_DespatchedDate >= '" . $from_date . "' AND RD_DespatchedDate <= '" . $to_date . "') ";
                    }
                break;
                
                case 'Date received':
                    if($what_to_apply == "To date only"){
                       $sql = "RD_ReceivedDate <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "RD_ReceivedDate >= '" . $from_date ."'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(RD_ReceivedDate >= '" . $from_date . "' AND RD_ReceivedDate <= '" . $to_date . "') ";
                    }
                 break;
                
                case 'Date sent to store':
                    if($what_to_apply == "To date only"){
                        $sql = "RD_SentToStoreDate <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "RD_SentToStoreDate >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(RD_SentToStoreDate >= '" . $from_date . "' AND RD_SentToStoreDate <= '" . $to_date . "') ";
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
                        
        $count_sql   = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT Q_FullNumber) AS [count] FROM NumberedRows', ''), $full_sql);
        
        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();
//print_r($page_sql);exit;
        return array('count' => (int) $count['count'], 'result' => $rows);
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------


    public function get_branches() 
    { 

        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql   = "SELECT DISTINCT WDB_B_Name {$from} {$where}";
        $sql  .= "ORDER BY WDB_B_Name ASC";
        
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

        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql   = "SELECT DISTINCT WDB_P_Name {$from} {$where}";
        $sql  .= "ORDER BY WDB_P_Name ASC";
        
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
    
    public function get_test_offices() 
    {
        $from    = $this->sql_from();
        $where   = $this->sql_where();

        $sql     = "SELECT DISTINCT TestOfficer {$from} {$where}";
        $sql    .= "ORDER BY TestOfficer ASC";
        
        $rows   = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'TestOfficer', 'TestOfficer');
      
    }

    /**
     * Get receipt and dispatch data for a job
     * @param  [int] $id [description]
     * @return [array] 
     */
    public static function get_receipt_dispatch($id)
    {
        $stmt = \NMI::Db()->prepare("SELECT * from t_ReceiptAndDespatch WHERE RD_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $receipt = $stmt->fetch();

        //full status string
        $stmt = \NMI::Db()->prepare("SELECT Q_FullNumber, FullStatusString FROM vw_ReceiptAndDespatchListing WHERE RD_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $meta = $stmt->fetch();
        
        return array_merge( (array) $receipt, (array) $meta );
    }
    
     /**
     * Get Shipping Mode
     * @author Namal <[email]>
     * @param   []
     * @return Array [modes]
     */
     
    public static function get_shipping_mode()
    {           
        $rows = \NMI::Db()->query("SELECT DISTINCT RD_ShippingMode FROM t_ReceiptAndDespatch WHERE RD_ShippingMode IS NOT NULL ORDER BY RD_ShippingMode ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'RD_ShippingMode', 'RD_ShippingMode');
    }
    
     /**
     * Get Shipping ugency
     * @author Namal <[email]>
     * @param   []
     * @return Array [ugency]
     */
     
    public static function get_shipping_ugency()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT RD_ShippingUrgency  FROM t_ReceiptAndDespatch WHERE RD_ShippingUrgency IS NOT NULL ORDER BY RD_ShippingUrgency  ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'RD_ShippingUrgency', 'RD_ShippingUrgency');
    }
    
     /**
     * Get Career Name
     * @author Namal <[email]>
     * @param   []
     * @return Array [names]
     */
     
    public static function get_career_name()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT RD_CarrierName  FROM t_ReceiptAndDespatch WHERE RD_CarrierName IS NOT NULL ORDER BY RD_CarrierName  ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'RD_CarrierName', 'RD_CarrierName');
    }
    
     /**
     * Get Career contct person
     * @author Namal <[email]>
     * @param   []
     * @return Array [contact person]
     */
     
    public static function get_career_contact_person()
    {
        
        $rows = \NMI::Db()->query("SELECT DISTINCT RD_CarrierContactPerson FROM t_ReceiptAndDespatch WHERE RD_CarrierContactPerson IS NOT NULL AND RD_CarrierName = 'TNT' ORDER BY RD_CarrierContactPerson ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'RD_CarrierContactPerson', 'RD_CarrierContactPerson');
    }
    
     /**
     * Get Career contct phone
     * @author Namal <[email]>
     * @param   []
     * @return Array [contact person]
     */
     
    public static function get_career_contact_phone()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT RD_CarrierContactPhone FROM t_ReceiptAndDespatch WHERE RD_CarrierContactPhone IS NOT NULL AND RD_CarrierName = 'TNT' ORDER BY RD_CarrierContactPhone ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'RD_CarrierContactPhone', 'RD_CarrierContactPhone');
    }
    
     /**
     * Get rturn contact
     * @author Namal <[email]>
     * @param   []
     * @return Array [contact]
     */
     
    public static function get_return_contact($org_id)
    {
        $stmt = \NMI::Db()->prepare("SELECT NameAndPhone = CASE WHEN CO_Phone IS NOT NULL THEN CO_Fullname +', (ph: ' + CO_Phone + ')' ELSE CO_Fullname END, CO_Lname_ind FROM t_Contact INNER JOIN t_Organisation1 ON CO_OrgID_fk = OR1_OrgID_pk WHERE OR1_OrgID_pk = ? ORDER BY CO_Lname_ind ASC");
        $stmt->execute(array($org_id));
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'NameAndPhone', 'NameAndPhone');
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
        
        
        $sql .=  "Q_FullNumber AS QuoteNumber, A_Description AS [Description], TestOfficer, ";
        $sql .=  "A_Type AS Type, A_Make AS Make, A_Model AS Model, A_SerialNumber AS SerialNumber, OR1_FullName AS Owner, ";
        $sql .=  "Q_ServicesOffered AS ServicesOffered, ";
        $sql .=  "Q_PurchaseOrderNumber AS PurchaseOrderNumber, A_CF_FileNumber_fk AS CbFileNumber, ";
        $sql .=  "RD_ReturnOrganisation As ReturnOrganisation, RD_ReturnContact AS ReturnContact, RD_ShippingMode AS ShippingMode, ";
        $sql .=  "RD_ShippingUrgency AS ShippingUrgency, RD_CarrierName AS CarrierName, RD_CarrierAccountNumber AS CarrierAccNo, ";
        $sql .=  "RD_CarrierContactPerson AS CarrierContactPerson, RD_DeliveredBy AS DeliveredBy, RD_DeliveryConNote As DeliveryConNote, ";
        $sql .=  "RD_PickedUpBy AS PickedUpBy, RD_DespatchConNote As DespatchConNote, ";
        $sql .=  "RD_InsuranceInstructions As InsuranceInstructions, FullStatusString, ";
        $sql .=  "dbo.fn_DateInWords(RD_DespatchedDate) AS DespatchedDate, ";
        $sql .=  "dbo.fn_DateInWords(RD_ReceivedDate) AS ReceivedDate, dbo.fn_DateInWords(RD_SentToStoreDate) AS SentToStoreDate, ";
        $sql .=  "RD_YearSeq_pk, FullStatusDaysInt ";
        
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();
        
        return \NMI::DB()->query($sql)->fetchAll();
    }
    
     /**
     * Email test officer
     * @author Namal
     */
    public static function email_test_officer($A_YearSeq_pk)
    {
        $sql = "DECLARE
            @return_value int,
            @ExaminerEmailAddress varchar(80),
            @Subject varchar(150),
            @EmailBody varchar(250)
    
            EXEC	@return_value = [sp_GetDetailsForReceiptEmail]
                    @RD_YearSeq_pk = ?,
                    @ExaminerEmailAddress = @ExaminerEmailAddress OUTPUT,
                    @Subject = @Subject OUTPUT,
                    @EmailBody = @EmailBody OUTPUT
            
            SELECT	@ExaminerEmailAddress as 'ExaminerEmailAddress',
                    @Subject as 'Subject',
                    @EmailBody as 'EmailBody',
                    @return_value as 'ReturnValue'";
            
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $A_YearSeq_pk);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    
    
    
    

}