<?php

namespace Quotes;

class Model_Quote extends \Model_Base 
{

    public $limit           = 10;
    public $offset          = null;
    public $filter          = array();
    public $search_criteria = null;
    public $data            = array();
    public $quote_from      = null;
    public $quote_where     = null;

    public  function sql_select() 
    {
        if ($this->offset) {
            $this->limit = $this->limit + $this->offset;
        }

        $limit = $this->limit;

        $sLimit = null;

        if ($limit)
            $sLimit = " TOP {$limit} ";


        return "SELECT DISTINCT {$sLimit} 
      
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
                Q_YearSeq_pk,
                Q_FullNumber,
                Q_DateInstRequired,
                Q_QuotedPrice,
                FullStatusString, 
                FullStatusDaysInt ";
    }

    public  function sql_from() 
    {
        return "FROM vw_QuoteListing INNER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind";
    }

    public  function sql_where() 
    {
        $filter = \NMI_Db::escape($this->filter); 
        $swst = '';

       if (isset($filter['status'])){
            // print_r(($filter['status']));exit;
            switch ($filter['status']) {
           
            case '\'1\'':
               // print_r("fff");exit;
                $swst = "AND FullStatusString LIKE 'Live:%' ";
                break;
            case '\'2\'':
                $swst = "AND FullStatusString LIKE 'Live:%' AND FullStatusDaysInt > 0 ";
                break;
            case '\'3\'':
                $swst = "AND FullStatusString LIKE 'Live:%' AND FullStatusDaysInt < 0 ";
                break;
            case '\'4\'':
                $swst = "AND FullStatusString LIKE 'Live: Offered and ready for checking%' ";
                break;
            case '\'5\'':
                $swst = "AND FullStatusString LIKE 'Live: Offered and ready for sending%' ";
                break;
            case '\'6\'':
                $swst = "AND FullStatusString LIKE 'Closed:%' ";
                break;
            case '\'7\'':
                $swst = "AND FullStatusString LIKE 'Closed: Accepted%' ";
                break;
            case '\'8\'':
                $swst = "AND FullStatusString LIKE 'Closed: Rejected%' ";
                break;
            case '\'9\'':
                $swst = "AND FullStatusString LIKE 'Closed: Requoted%' ";
                break;
            case '\'10\'':
                $swst = "AND FullStatusString LIKE 'Closed: Cancelled%' ";
                break;
            case '\'11\'':
                $swst = "AND FullStatusString LIKE '%Nothing issued%' ";
                break;
            case '\'12\'':
                $swst = "AND Q_LockForm = 1 ";
                break;
            case '\'13\'':
                $swst = "AND Q_LockForm = 0 ";
                break;
            case '\'14\'':
                $swst = "AND FullStatusString LIKE 'Live: Wrong data%' ";
                break;
        }
       }
//print_r($filter['status']."&&".$swst);exit;
        $filter = \NMI_Db::escape($this->filter)+array('status'=>'');
        $swhere = '';
       // print_r($filter['field']);exit;
         if(isset($filter['type']) and !empty($filter['type']))
        {
           if($filter['type']=='\'90&deg; square block\''){
               $filter['type']='\'90° square block\'';
           }
             $swhere .= "AND A_Type = {$filter['type']} ";
        }else{
            $swhere .= null;
        }


        //$swhere .= (isset($filter['type']) && !empty($filter['type'])) ? "AND A_Type = {$filter['type']} " : null;
        $swhere .= (isset($filter['branch']) && !empty($filter['branch'])) ? "AND WDB_B_Name = {$filter['branch']} " : null;
        $swhere .= (isset($filter['section']) && !empty($filter['section'])) ? "AND WDB_S_Name = {$filter['section']} " : null;
        $swhere .= (isset($filter['project']) && !empty($filter['project'])) ? "AND WDB_P_Name = {$filter['project']} " : null;
        $swhere .= (isset($filter['area']) && !empty($filter['area'])) ? "AND WDB_A_Name = {$filter['area']} " : null;
        $swhere .= (isset($filter['test_officer']) && !empty($filter['test_officer'])) ? "AND TestOfficer = {$filter['test_officer']} " : null;
        $swhere .= (isset($filter['file_location']) && !empty($filter['file_location'])) ? "AND FileLocation = {$filter['file_location']} " : null;
        $swhere .= (isset($filter['owner_type'])  && !empty($filter['owner_type'])) ? "AND OR1_InternalOrExternal = {$filter['owner_type']} " : null;
        $swhere .= (isset($filter['owner'])  && !empty($filter['owner'])) ? "AND A_OR1_OrgID_fk = {$filter['owner']} " : null;
        if(!empty($this->search_criteria)){
               
        $filter  = \Helper_App::build_search_string($this->search_criteria['field_criteria_1'],$this->search_criteria['field_criteria_2'],$this->search_criteria['date_criteria'], $this->search_criteria_1(), $this->search_criteria_2(), $this->date_criteria());
               
        
                }else{
            $filter = '';
        }
       //print_r($this->search_criteria['Intelligent'] );exit;
        return "WHERE Q_YearSeq_pk > 0 {$swst} {$swhere} {$filter} ";
    }

    public  function sql_order_by($filter = array())
    {
        if(empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY Q_FullNumber DESC";
        
        $sorderby = null;
        $order_by = array_merge(array('column' => '', 'sort' => ''), (array) $this->order_by);
        $order_by['column'] = $this->order_by['column'];
        $order_by['sort']   = ($this->order_by['sort']=='desc') ? 'DESC' : 'ASC';
        $order_by['sort1']   = ($this->order_by['sort']=='desc') ? 'ASC' : 'DESC';

        $sorder_by = null;
        
        switch ($order_by['column']) {
            case "Number":
                $sorder_by = "ORDER BY Q_YearSeq_pk " . strtoupper($order_by['sort']);
                break;
            case "Description":
                $sorder_by = "ORDER BY A_Description ". strtoupper($order_by['sort']);
                break;
            case "Client":
                $sorder_by = "ORDER BY OR1_FullName ". strtoupper($order_by['sort']);
                break;
            case "Status":
                $sorder_by = "ORDER BY FullStatusDaysInt " . strtoupper($order_by['sort']);
                break;
            case "QuotedPrice":
                $sorder_by = "ORDER BY Q_QuotedPrice ". strtoupper($order_by['sort1']);
                break;
            case "DateInstrumentRequired":
                $sorder_by =  "ORDER BY Q_DateInstRequired ". strtoupper($order_by['sort1']);
                break;
        }
        
        return $sorder_by;
    }

    public function search_criteria_1() 
    {
        
           
        $filter = $this->search_criteria;

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['field_criteria_1']) || empty($filter['equality']) || empty($filter['criteria'])|| empty($filter['Intelligent']))
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
            case "Certificate offered":
                $sql = "Q_CertificateOffered ";
                break;
            case "Internal delivery instructions":
                $sql = "Q_DeliveryInstructions ";
                break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                break;
            case "Quote checked by":
                $sql = "Q_CheckedBy ";
                break;
            case "Quote number":
                $sql = "Q_FullNumber ";
                break;
            case "Quote sent method":
                $sql = "Q_SentMethod ";
                break;
            case "Services offered":
                $sql = "Q_ServicesOffered ";
                break;
            case "Special requirements":
                $sql = "Q_SpecialRequirements ";
                break;
            case "CB File Number":
                $sql = "A_CF_FileNumber_fk ";
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
                $sql .= "LIKE '%" .$criteria . "%' ";
                break;

            case "NOT LIKE":
                $sql .= "NOT LIKE '%" .$criteria . "%' ";
                break;

            case "EQUAL TO":
                $sql .= "= '" .$criteria . "' ";
                break;

            case "NOT EQUAL TO":
                $sql .= "<> '" . $criteria . "' ";
                break;

            case "STARTS WITH":
                $sql .= "LIKE '" .$criteria . "%' ";
                break;

            case "ENDS WITH":
                $sql .= "LIKE '%" .$criteria . "' ";
                break;
        }
         
        return $sql;
    }
    
    
     public function search_criteria_2() 
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
            case "Internal delivery instructions":
                $sql = "Q_DeliveryInstructions ";
                break;
            case "Purchase order number":
                $sql = "Q_PurchaseOrderNumber ";
                break;
            case "Quote checked by":
                $sql = "Q_CheckedBy ";
                break;
            case "Quote number":
                $sql = "Q_FullNumber ";
                break;
            case "Quote sent method":
                $sql = "Q_SentMethod ";
                break;
            case "Services offered":
                $sql = "Q_ServicesOffered ";
                break;
            case "Special requirements":
                $sql = "Q_SpecialRequirements ";
                break;
            case "CB File Number":
                $sql = "A_CF_FileNumber_fk ";
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
                $sql .= "LIKE '%" .$criteria1. "%' ";
                break;

            case "NOT LIKE":
                $sql .= "NOT LIKE '%" . $criteria1. "%' ";
                break;

            case "EQUAL TO":
                $sql .= "= '" . $criteria1 . "' ";
                break;

            case "NOT EQUAL TO":
                $sql .= "<> '" . $criteria1. "' ";
                break;

            case "STARTS WITH":
                $sql .= "LIKE '" . $criteria1 . "%' ";
                break;

            case "ENDS WITH":
                $sql .= "LIKE '%" . $criteria1 . "' ";
                break;
        }
        
        return $sql;
    }
    
    
    public function date_criteria()
    {
         $filter    = $this->search_criteria;
         $sql       = null;
         $from_date = null;
         $to_date   = null;
         $what_to_apply = null;
         
         
        if (empty($this->search_criteria) && empty($filter['date']['equality']) && empty($filter['date']['from']) && empty($filter['date']['to']))
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
         
         switch ($filter['date']['equality']) {
            
                case 'Artefacts required':
                    if($what_to_apply == "To date only"){
                       $sql = "Q_DateInstRequired <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "Q_DateInstRequired >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(Q_DateInstRequired >= '" . $from_date . "' AND Q_DateInstRequired <= '" . $to_date . "') ";
                    }
                break;
                
                case 'Quotes expired':
                    if($what_to_apply == "To date only"){
                       $sql = "Q_ExpiryDate <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                      $sql = "Q_ExpiryDate >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(Q_ExpiryDate >= '" . $from_date . "' AND Q_ExpiryDate <= '" . $to_date . "') ";
                    }
                 break;
                
                case 'Quotes offered':
                    if($what_to_apply == "To date only"){
                        $sql = "Q_OfferDate <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                        $sql = "Q_OfferDate >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(Q_OfferDate >= '" . $from_date . "' AND Q_OfferDate <= '" . $to_date . "') ";
                    }
                 break;
                
                case 'Quotes sent':
                    if($what_to_apply == "To date only"){
                        $sql = "Q_DateSent <= '" . $to_date. "'";

                    }else if($what_to_apply == "From date only"){
                        $sql = "Q_DateSent >= '" . $from_date. "'";

                    }else if($what_to_apply == "To and from date" ){
                        $sql = "(Q_DateSent >= '" . $from_date . "' AND Q_DateSent <= '" . $to_date . "') ";
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
        $limit  = \NMI_Db::escape((int) $this->limit);
        $offset = \NMI_Db::escape((int) $this->offset);
        $filter = \NMI_Db::escape($this->filter);

        $paging = null;

        if ($offset)
        {
            $start   = $offset;
            $limit   = $limit + $offset;
            $paging  = " where RowNumber > {$start} and RowNumber < {$limit} ";
        }

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
                        $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by; 
                        //print_r($page_sql);exit;   
       // $page_sql    = $full_sql . ' ' . $paging;
        //\log::error($full_sql);
        $count_sql   = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT Q_FullNumber) AS [count] FROM NumberedRows', ''), $full_sql);

        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }
    
    function action_new_quote()
    {
        $view = \View::forge('insert_new_quote');
        $this->template->content = $view;
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

        return $ret;
    }
    
    	
    public static function get_nmi_project_ajax($section='')
    {
        if($section!=''){$section =" S_Name_ind = '" . $section . "' AND ";}else{$section='';}
        $rows   = \NMI::Db()->query("SELECT DISTINCT P_Name_ind FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE " . $section . " B_BranchID_pk > 0 AND P_Name_ind IS NOT NULL ORDER BY P_Name_ind ASC")->fetchAll();
           // return \Arr::assoc_to_keyval($rows, 'P_Name_ind', 'P_Name_ind');
			return $rows;
    }
    
	//Coded by Sri
	//Get all area list
    public static function get_nmi_area_ajax($project='')
    {
        if($project!=''){$project ="  AND P_Name_ind ='" . $project . "'  ";}else{$project='';}
        $rows   = \NMI::Db()->query("SELECT DISTINCT A_Name_ind FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE B_BranchID_pk > 0 " . $project . " AND  A_Name_ind IS NOT NULL ORDER BY A_Name_ind ASC")->fetchAll();
			return $rows;
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
        $data = \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
       
        return array_filter($data, 'strlen');
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
    
    /*********************************************************
     *new quotes
     *********************************************************/
    
    /*
     * sql for  'from' in new quote
     * @author Namal
     */ 
    
    public function new_quote_from()
    {
        $sql  = "FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk ";
        $sql .= "INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk ";
        $sql .= "INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk ";
        $sql .= "LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk ";
        $sql .= "LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk ";
        $sql .= "LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk ";
        $sql .= "LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk ";
                            
        $this->quote_from = $sql;
    }
     public function new_quote_from_arrange()
    {
         
        $sql  = "FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk ";
        $sql .= "INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk ";
        $sql .= "INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk ";
        $sql .= "LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk ";
        $sql .= "LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk ";
        $sql .= "LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk ";
        $sql .= "LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk";
                            
        return $sql;
    }
    
    /*
     * sql for 'where' in new quote
     * @param 
     * @author Namal
     */ 
    
    public function new_quote_where()
    {
        $data = \NMI_Db::escape($this->data); 
//        if(strlen($data['section'])!=2){
//            print_r(strlen($data['section']));exit;
//        }
    
        $where='';
        $where .= (strlen($data['section'])!=2)? " AND S_Name_ind = {$data['section']} " : null;
        $where  .= (strlen($data['project'])!=2)? " AND P_Name_ind = {$data['project']} " : null;
        $where  .= (strlen($data['area'])!=2)? " AND A_Name_ind = {$data['area']} " : null;
        $where  .= (strlen($data['type'])!=2)? " AND IT_Name_ind = {$data['type']} " : null;
        //print_r($w_section);exit;
        $this->quote_where = "WHERE B_BranchID_pk > 0 {$where} ";
    }
    public function new_quote_where_arrange($section='',$project='',$area='')
    {
        //$data = $this->data;
        
        $w_section  = ( !empty($section)) ? " AND S_Name_ind = '{$section}' " : '';
        $w_project  = ( !empty($project)) ? " AND P_Name_ind = '{$project}' " : '';
        $w_area     = (!empty($area)) ? " AND A_Name_ind = '{$area}' " : '';
        
       $sql = "WHERE B_BranchID_pk > 0 {$w_section} {$w_project} {$w_area}";
        return $sql;
    }
    
    public  function get_new_section()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
        $rows	=\NMI::Db()->query("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where." AND S_Name_ind IS NOT NULL ORDER BY S_Name_ind ASC")->fetchAll();
      // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where." AND S_Name_ind IS NOT NULL ORDER BY S_Name_ind ASC");exit;
         return \Arr::assoc_to_keyval($rows, 'S_Name_ind', 'S_Name_ind');
        
    
    }
     public  function get_new_project()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
         $rows	=\NMI::Db()->query("SELECT DISTINCT P_Name_ind ".$this->quote_from.' '.$this->quote_where." AND P_Name_ind IS NOT NULL ORDER BY P_Name_ind ASC")->fetchAll();
       // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where);exit;
         return \Arr::assoc_to_keyval($rows, 'P_Name_ind', 'P_Name_ind');
        
    
    }
    
    public  function get_new_area()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
         $rows	=\NMI::Db()->query("SELECT DISTINCT A_Name_ind ".$this->quote_from.' '.$this->quote_where." AND A_Name_ind IS NOT NULL ORDER BY A_Name_ind ASC")->fetchAll();
       // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where);exit;
         return \Arr::assoc_to_keyval($rows, 'A_Name_ind', 'A_Name_ind');
        
    
    }
    
      public  function get_new_type()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
         $rows	=\NMI::Db()->query("SELECT DISTINCT IT_Name_ind ".$this->quote_from.' '.$this->quote_where." AND IT_Name_ind IS NOT NULL ORDER BY IT_Name_ind ASC")->fetchAll();
       // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where);exit;
         return \Arr::assoc_to_keyval($rows, 'IT_Name_ind', 'IT_Name_ind');
        
    
    }
    
     public  function get_new_emp()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
         $rows	=\NMI::Db()->query("SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst,EM1_Lname_ind, EM1_CurrencyStatus ".$this->quote_from.' '.$this->quote_where." AND EM1_FullNameNoTitle IS NOT NULL AND EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_Lname_ind ASC")->fetchAll();
       // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where);exit;
         return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
        
    
    }
     public  function get_new_emp_button()
    {
        $this->new_quote_from();
         $this->new_quote_where();
        // print_r('shanila');exit;
         $rows	=\NMI::Db()->query("SELECT EM1_EmployeeID_pk , EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC")->fetchAll();
       // print_r("SELECT DISTINCT S_Name_ind ".$this->quote_from.' '.$this->quote_where);exit;
         return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
        
    
    }
    
    /** 
    *Get Organisation
    *@return Array[]
    */
    public static function get_organisation()
    {
            $rows	=	\NMI::Db()->query("SELECT OR1_OrgID_pk,OR1_FullName FROM t_Organisation1 ORDER BY OR1_FullName ASC")->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'OR1_OrgID_pk', 'OR1_FullName');	
    }
    
    /*
     * Get NMI section for 'insert new quote'
     * @author Namal
     */   
    public static function get_nmi_section()
    {
         $rows   = \NMI::Db()->query("SELECT DISTINCT S_Name_ind FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE B_BranchID_pk > 0 AND S_Name_ind IS NOT NULL ORDER BY S_Name_ind ASC")->fetchAll();
         return \Arr::assoc_to_keyval($rows, 'S_Name_ind', 'S_Name_ind');
    }
    
    public static function get_nmi_project($section)
    {
        if($section!=0){$section =" S_Name_ind = '" . $section . "' AND ";}else{$section='';}
        $rows   = \NMI::Db()->query("SELECT DISTINCT P_Name_ind FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE" . $section ." B_BranchID_pk > 0 AND P_Name_ind IS NOT NULL ORDER BY P_Name_ind ASC")->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'P_Name_ind', 'P_Name_ind');
			//return $rows;
    }
    
	//Coded by Sri
	//Get all area list
    public static function get_nmi_area($project)
    {
         if($project!=0){$project ="  AND P_Name_ind ='" . $project . "'  ";}else{$project='';}
        $rows   = \NMI::Db()->query("SELECT DISTINCT A_Name_ind FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE B_BranchID_pk > 0 " . $project . " AND A_Name_ind IS NOT NULL ORDER BY A_Name_ind ASC")->fetchAll();
		return \Arr::assoc_to_keyval($rows, 'A_Name_ind', 'A_Name_ind');
			//return $rows;
    }
    
    public static function  get_nmi_test_offices()
    {
        $rows   = \NMI::Db()->query("SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst,EM1_Lname_ind, EM1_CurrencyStatus FROM t_Employee1 WHERE EM1_FullNameNoTitle IS NOT NULL AND EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_Lname_ind ASC")->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    }
    
    public static function  get_test_employee($EM1_EmployeeID_pk)
    {
        $rows   = \NMI::Db()->query("SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst,EM1_Lname_ind, EM1_CurrencyStatus FROM t_Employee1 WHERE EM1_FullNameNoTitle IS NOT NULL AND EM1_CurrencyStatus = 'CURRENT' AND [EM1_EmployeeID_pk] = '" . $EM1_EmployeeID_pk . "' ORDER BY EM1_Lname_ind ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    }
    
  /*   public  function get_nmi_type()
    {
         $rows   = \NMI::Db()->query("SELECT DISTINCT IT_Name_ind {$this->quote_from} AND IT_Name_ind IS NOT NULL ORDER BY IT_Name_ind ASC")->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'IT_Name_ind', 'IT_Name_ind');
    }
   * 
   */
   public static function get_nmi_type()
    {
         $rows   = \NMI::Db()->query("SELECT DISTINCT IT_Name_ind
FROM          t_Branch INNER JOIN
                        t_Section ON B_BranchID_pk = S_BranchID_fk INNER JOIN
                        t_Project ON S_SectionID_pk = P_SectionID_fk INNER JOIN
                        t_Area ON P_ProjectID_pk = A_ProjectID_fk LEFT OUTER JOIN
                        t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk LEFT OUTER JOIN
                        t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk LEFT OUTER JOIN
                        t_j_AreaInstumentType ON A_AreaID_pk = AIT_A_AreaID_ind_fk LEFT OUTER JOIN
                        t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk
WHERE      B_BranchID_pk > 0 AND IT_Name_ind IS NOT NULL
ORDER BY IT_Name_ind ASC")->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'IT_Name_ind', 'IT_Name_ind');
    }
    
 public  function  fill_data_according_projects($section='',$project='',$sel_area='')
    {
     
     $sql="SELECT DISTINCT S_Name_ind ".$this->new_quote_from_arrange().' '.$this->new_quote_where_arrange($section,$project,$sel_area).' '."AND S_Name_ind IS NOT NULL ORDER BY S_Name_ind ASC";
       $rows   = \NMI::Db()->query($sql)->fetchAll();
           
            print_r( \Arr::assoc_to_keyval($rows, 'S_Name_ind', 'S_Name_ind'));exit;
    }
    
    
    /**
     * Get a Quote
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function get_quote($id)
    {
        $stmt = \NMI::Db()->prepare("SELECT * from t_Quote WHERE Q_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $quote = $stmt->fetch();

        //full status string
        $stmt = \NMI::Db()->prepare("SELECT Q_FullNumber, FullStatusString FROM vw_QuoteListing WHERE Q_YearSeq_pk = ?");
        $stmt->execute(array($id));
        $meta = $stmt->fetch();
        
        return array_merge( (array) $quote, (array) $meta );

    }
    
    /**
     * Selected modules for quote in build quote price, quote build/price
     * @param 
     * @author Namal
     */ 
    public static function selected_modules_for_quote($QM_WDB_WorkDoneBy_fk)
    {
        $sql  = "SELECT QM_QuoteModuleID_pk, QM_F_Code, QM_F_Description, QM_F_Fee, QM_DiscountPercentage, QM_Quantity, QM_FeeDue, QM_WDB_WorkDoneBy_fk, QM_YearSeq_ind FROM t_QuoteModule WHERE QM_WDB_WorkDoneBy_fk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute( array($QM_WDB_WorkDoneBy_fk) );
        
        return $stmt->fetchAll();   
    }
    
    /*
     * Available modules for quote in build quote price
     * @author Namal
     */
    //TODO, parameters can be reduced, passing the wdb_pk
    public static function all_modules_for_quote($WDB_B_Name, $WDB_S_Name, $WDB_P_Name, $WDB_A_Name)
    { 
     try{
        $sql = "SELECT F_FeeID_pk, F_Code + ' : ' + F_Description AS CodeAndDescription, F_Fee, F_AreaID_ind_fk ";
        $sql .= "FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk ";
        $sql .= "INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk ";
        $sql .= "INNER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk ";
        $sql .= "INNER JOIN t_Fee ON A_AreaID_pk = F_AreaID_ind_fk ";
        $sql .= "WHERE B_Name_ind = '" . $WDB_B_Name . "'";
        $sql .= "AND S_Name_ind = '" . $WDB_S_Name . "'";
        $sql .= "AND P_Name_ind = '" . $WDB_P_Name . "'";
        $sql .= "AND A_Name_ind = '" . $WDB_A_Name . "'";
        $sql .= "ORDER BY F_Code ASC";

        $stmt = \NMI::Db()->query($sql);
            return $stmt->fetchAll();
     }catch(\PDOException $e){
         \Message::set('error', 'Data error');
         return true;
        }
    
        
        
    }

   
    /**
     * [new_quote_module description]
     * @param  Array  $data [description]
     * @return [type]       [description]
     * @author Sahan <[email]>
     */
    public static function push_module($F_FeeID_pk, $QM_WDB_WorkDoneBy_fk)
    {
        $sql = "
         SET NOCOUNT ON
            DECLARE @return_value int

            EXEC    @return_value = [sp_insert_into_t_QuoteModule]
                    @F_FeeID_pk = ?,
                    @QM_WDB_WorkDoneBy_fk = ?,
                    @QM_QuoteModuleID_pk = ?

            SELECT  'return' = @return_value";

        $QM_QuoteModuleID_pk = null;

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $F_FeeID_pk);
        $stmt->bindValue(2, $QM_WDB_WorkDoneBy_fk);
        $stmt->bindParam(3, $QM_QuoteModuleID_pk, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);
        $stmt->execute();
    }
    
    /**
     * Update module
     * @author Namal
     */
    
    public static function update_module($QM_QuoteModuleID_pk, $QM_F_Fee, $QM_Quantity, $QM_DiscountPercentage)
    {
        $sql = "UPDATE t_QuoteModule SET QM_F_Fee = ?, QM_Quantity = ?, QM_DiscountPercentage = ? WHERE QM_QuoteModuleID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        return $stmt->execute(array($QM_F_Fee, $QM_Quantity, $QM_DiscountPercentage, $QM_QuoteModuleID_pk));
    }
    
    /**
     * Delete module in quote
     * @author Namal
     */
    public static function delete_module($QM_QuoteModuleID_pk)
    {
        $sql  = "sp_delete_from_t_QuoteModule @QM_QuoteModuleID_pk = :QM_QuoteModuleID_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('QM_QuoteModuleID_pk', $QM_QuoteModuleID_pk);
        $stmt->execute();
    }
    
    
    /*
	*Get Test Officers
	*For Change Test Officer
	*Coded by Sri
	*/
	public static function get_test_officer_list($P_Name_ind){
		$sql	=	"SELECT      EM1_EmployeeID_pk, EM1_LastNameFirst
					FROM          t_Employee1 INNER JOIN
											t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk INNER JOIN
											t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk
					WHERE      P_Name_ind = ? AND EM1_CurrencyStatus = 'CURRENT'
					ORDER BY EM1_Lname_ind ASC";
					
		$stmt = \NMI::Db()->prepare($sql);
                $stmt->execute(array($P_Name_ind));
                $rows = $stmt->fetchAll();
                return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
	}
        
        
       /*
	*Get Test Officers
	*For Change Test Officer
	*Coded by Sri
	*/
	public static function get_current_test_officer($id){
		$sql	=	"SELECT      EM1_EmployeeID_pk, EM1_LastNameFirst
					FROM          t_Employee1 WHERE EM1_EmployeeID_pk= ? ";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch();
		  
	}
    
    /**
     * Test offices for build quote price
     * @author Namal
     */
    
  public static function quote_module_test_officers($WDB_B_Name, $WDB_S_Name, $WDB_P_Name)
    { 
        $sql = " SELECT EM1_EmployeeID_pk, EM1_LastNameFirst FROM t_Branch INNER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk 
               INNER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk 
               INNER JOIN t_j_ProjectEmployee ON P_ProjectID_pk = PE_ProjectID_ind_fk
               INNER JOIN t_Employee1 ON PE_EmployeeID_fk = EM1_EmployeeID_pk 
               WHERE B_Name_ind = '" . $WDB_B_Name . "' 
               AND S_Name_ind = '" . $WDB_S_Name . "'  
               AND P_Name_ind = '" . $WDB_P_Name . "' 
               ORDER BY EM1_Lname_ind ASC ";
        
        $stmt = \NMI::Db()->query($sql);

        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    }
    
    /*
     * test officers for work sub - description
     * @param $arg
     * @return null
     * @author Namal
     */
    public static function work_sub_test_officers()
    {
        $sql = "SELECT EM1_EmployeeID_pk, EM1_LastNameFirst FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk WHERE P_Name_ind = 'Mass and related quantities' AND EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_Lname_ind ASC";
        $stmt = \NMI::Db()->query($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
        
    }
    
    public static function get_certificates_offered()
    {
        $rows = \NMI::Db()->query('SELECT CO_CertName_pk FROM t_CertificateOffered ORDER BY CO_CertName_pk ASC')->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'CO_CertName_pk', 'CO_CertName_pk');
    }
    
    public static function get_test_methods()
    {
        $rows = \NMI::Db()->query('SELECT A_YearSeq_pk, A_TestMethodUsed  FROM t_Artefact')->fetchAll();
        $method = \Arr::assoc_to_keyval($rows, 'CO_CertName_pk', 'CO_CertName_pk');
        return array_unique($method);
    }

    /**
     * Get worklog entries for a quote
     * => WDB_YearSeq_fk_ind
     * @param  [type] $quote_id [description]
     * @return Array           [description]
     */
    public static function get_worklog($quote_id)
    {
        $sql = "SELECT WDB_WorkDoneBy_pk, 
                (SELECT EM1_FullNameNoTitle FROM t_Employee1 WHERE EM1_EmployeeID_pk = WDB_TestOfficerEmployeeID) 
                AS Employee, 
                WDB_TestOfficerEmployeeID, 
                WDB_B_Name,
                WDB_S_Name,
                WDB_P_Name, 
                WDB_A_Name, 
                WDB_HoursInHhMm, 
                WDB_YearSeq_fk_ind,
                WDB_WorkGroupNumber, 
                WDB_WorkGroupTotalNumber, 
                WDB_WorkGroupNumberString, 
                WDB_QuotedPrice, 
                WDB_FeeDue FROM t_WorkDoneBy WHERE WDB_YearSeq_fk_ind = ? ORDER BY WDB_WorkGroupNumber ASC, WDB_WorkGroupTotalNumber ASC";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($quote_id));
        $log = $stmt->fetchAll();

        foreach($log as &$entry)
        {
            $entry['quote_pricing'] = static::get_quote_pricing($entry['WDB_WorkDoneBy_pk']);
        }

        return $log;
    }

    /**
     * Get single worklog entry
     * @param  WDB_WorkDoneBy_pk [varname] PK
     */
    public static function get_worklog_entry($WDB_WorkDoneBy_pk)
    {
        $sql = "SELECT WDB_WorkDoneBy_pk, 
                (SELECT EM1_FullNameNoTitle FROM t_Employee1 WHERE EM1_EmployeeID_pk = WDB_TestOfficerEmployeeID) 
                AS Employee,
                WDB_TestOfficerEmployeeID, 
                WDB_B_Name,
                WDB_S_Name,
                WDB_P_Name, 
                WDB_A_Name, 
                WDB_HoursInHhMm, 
                WDB_YearSeq_fk_ind,
                WDB_WorkGroupNumber, 
                WDB_WorkGroupTotalNumber, 
                WDB_WorkGroupNumberString, 
                WDB_QuotedPrice, 
                WDB_FeeDue FROM t_WorkDoneBy WHERE WDB_WorkDoneBy_pk = ?";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($WDB_WorkDoneBy_pk));
        $log = $stmt->fetch();

        $log['quote_pricing'] = static::get_quote_pricing($WDB_WorkDoneBy_pk);

        return $log;
    }

    /**
     * Get pricing of a specific worklog
     * @return [type] [description]
     */
    public static function get_quote_pricing($done_by)
    {
        $sql = "SELECT
                QM_QuoteModuleID_pk, 
                QM_F_Code+ ': ' + QM_F_Description AS CodeAndDescription, 
                QM_F_Fee, 
                QM_DiscountPercentage, 
                QM_Quantity, 
                QM_FeeDue, 
                QM_WDB_WorkDoneBy_fk,
                QM_YearSeq_ind 
                FROM t_QuoteModule WHERE QM_WDB_WorkDoneBy_fk = ?";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($done_by));
        return $stmt->fetchAll();
    }

     /**
     * Get quote price of a single work log entry, used in BuildQuotePrice form
     * @return [type] [description]
     */
    public static function get_worklog_quote_price($WDB_WorkDoneBy_pk)
    {
        $sql = "SELECT WDB_WorkDoneBy_pk, WDB_QuotedPrice, Q_QuotedPrice, Q_LockForm  FROM t_WorkDoneBy INNER JOIN t_Quote ON WDB_YearSeq_fk_ind = Q_YearSeq_pk WHERE WDB_WorkDoneBy_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($WDB_WorkDoneBy_pk));
        
        return $stmt->fetch();
    }

    
   
   /**
    * Get NMI branches
    * @author  Namal <[email]>
    * @return  Array [description]
    */ 
    public static  function get_w_nmi_branch()
    {
        $rows = \NMI::Db()->query("SELECT B_BranchID_pk, B_Name_ind FROM t_Branch ORDER BY B_Name_ind ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'B_BranchID_pk', 'B_Name_ind');
    }
    
    /**
     * Get sections for new workgroup branch.
     * @author  Namal <[email]>
     * @param  [type] $B_BranchID_pk [description]
     * @return [type]                [description]
     */
    public static function get_w_nmi_section($B_BranchID_pk)
    {
         $sql  = "SELECT S_SectionID_pk, S_Name_ind FROM t_Section WHERE S_BranchID_fk = ? ";
         $sql .= "ORDER BY S_Name_ind ASC";
         
         $stmt = \NMI::Db()->prepare($sql);
         $stmt->bindParam(1, $B_BranchID_pk);
         $stmt->execute();
         $rows = $stmt->fetchAll();
         
         return \Arr::assoc_to_keyval($rows, 'S_SectionID_pk', 'S_Name_ind');
    }
    
    /**
     * Get projects for new workgroup. $P_SectionID_fk should be passed.  
     * @author  Namal <[email]>      
     * @param int $P_SectionID_fk section id
     * @return Array
     */
    public static function get_w_nmi_project($P_SectionID_fk)
    {
        $sql = "SELECT P_ProjectID_pk, P_Name_ind FROM t_Project WHERE P_SectionID_fk = ? ORDER BY P_Name_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $P_SectionID_fk);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        return \Arr::assoc_to_keyval($rows, 'P_ProjectID_pk', 'P_Name_ind');
    }
    
    /**
     * Get workgroup NMI Area
     * @author  Namal <[email]>
     * @param int A_ProjectID_fk
     * @return Array
     */
    public static function get_w_nmi_area($A_ProjectID_fk)
    { 
        $stmt = \NMI::Db()->prepare("SELECT A_AreaID_pk, A_Name_ind FROM t_Area WHERE A_ProjectID_fk = ? ORDER BY A_Name_ind ASC");
        $stmt->execute(array($A_ProjectID_fk));
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'A_AreaID_pk', 'A_Name_ind');
    }
    
    /**
     * Get get_w_test_method
     * @return A_TestMethodUsed
     * @author  Namal <[email]>
     */
    public static function get_w_test_method($YearSeq_pk_ind)
    {
        $sql    =   " SELECT DISTINCT A_TestMethodUsed FROM dbo.t_Artefact INNER Join dbo.t_WorkDoneBy ON A_YearSeq_pk = WDB_YearSeq_fk_ind ";
        $sql    .= " WHERE (WDB_B_Name IN (SELECT DISTINCT WDB_B_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND (WDB_S_Name IN (SELECT DISTINCT WDB_S_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND(WDB_P_Name IN (SELECT DISTINCT WDB_P_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .=  " AND (WDB_A_Name IN (SELECT DISTINCT WDB_A_Name FROM t_WorkDoneBy  WHERE WDB_YearSeq_fk_ind ='".$YearSeq_pk_ind."')) ";
        $sql    .= " AND A_TestMethodUsed IS NOT NULL ORDER BY A_TestMethodUsed ASC";
        
      // return $sql;
        $stmt = \NMI::Db()->query($sql);
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'A_TestMethodUsed', 'A_TestMethodUsed');
    }
    
    /**
     * Get workgroup employees
     * @author  Namal <[email]>
     * @param  int $S_SectionID_pk section id
     * @return Array
     */
    public static function get_w_employees($S_SectionID_pk)
    {
        $sql  = "SELECT DISTINCT EM1_EmployeeID_pk, EM1_LastNameFirst ";
        $sql .= "FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk ";
        $sql .= "INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk ";
        $sql .= "WHERE P_SectionID_fk = ? ";
        $sql .= "AND EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_LastNameFirst ASC";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $S_SectionID_pk);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
    }

    /**
     * Insert in to work done by, sp_insert_into_t_WorkDoneBy stored procedure is executed.
     * @return int/bool 1,0 returned on an error, bool true is returned on seuccess
     * @return [type] [description]
     */
    public static function insert_work_doneby(Array $fields)
    {
        $valid_fields = array('WDB_B_Name', 'WDB_S_Name', 'WDB_P_Name', 'WDB_A_Name', 'WDB_TestOfficerEmployeeID', 'WDB_YearSeq_fk_ind');

        $sql = "
            SET NOCOUNT ON
            DECLARE @return_value int

            EXEC    @return_value = [sp_insert_into_t_WorkDoneBy]
                    @WDB_B_Name = :WDB_B_Name,
                    @WDB_S_Name = :WDB_S_Name,
                    @WDB_P_Name = :WDB_P_Name,
                    @WDB_A_Name = :WDB_A_Name,
                    @WDB_TestOfficerEmployeeID = :WDB_TestOfficerEmployeeID,
                    @WDB_YearSeq_fk_ind = :WDB_YearSeq_fk_ind

            SELECT  'return' = @return_value";

       $stmt = \NMI::Db()->prepare($sql);
       
       foreach($valid_fields as $field_name)
       {
            if(isset($fields[ $field_name ]))
            {
                $stmt->bindValue($field_name, $fields[ $field_name ]);
            }
       }
       
       $stmt->execute();

       if($row = $stmt->fetch())
       {    
            return (int) $row['return'];
       }
       else
       {
            return false;
       }

    }
    
    /**
     * Create a new quote based on existing quote
     * @author Sahan <[email]>
     * @param  [type] $Q_YearSeq_pk [description]
     * @return [type]               [description]
     */
    public static function insert_quote_based_this($Q_YearSeq_pk)
    {
        $Q_YearSeq_pk = (int) $Q_YearSeq_pk;

        $sql = "
            DECLARE	@return_value int,
            		@OR1_InternalOrExternal varchar(30),
            		@A_OR1_OrgID_fk int,
            		@OrgName varchar(120),
            		@A_ContactID int,
            		@ContactName varchar(80),
            		@WDB_B_Name varchar(80),
            		@WDB_S_Name varchar(80),
            		@WDB_P_Name varchar(80),
            		@WDB_A_Name varchar(80),
            		@WDB_TestOfficerEmployeeID int,
            		@A_Type varchar(80),
            		@A_Make varchar(80),
            		@A_Model varchar(80),
            		@A_SerialNumber varchar(400),
            		@A_PerformanceRange varchar(80),
            		@A_Description varchar(600),
            		@A_CF_FileNumber_fk varchar(16),
            		@FileTitle varchar(200)

            EXEC	@return_value = [sp_NewQuoteBasedOnPreviousQuote]
            		@Q_YearSeq_pk = ?,
            		@OR1_InternalOrExternal = @OR1_InternalOrExternal OUTPUT,
            		@A_OR1_OrgID_fk = @A_OR1_OrgID_fk OUTPUT,
            		@OrgName = @OrgName OUTPUT,
            		@A_ContactID = @A_ContactID OUTPUT,
            		@ContactName = @ContactName OUTPUT,
            		@WDB_B_Name = @WDB_B_Name OUTPUT,
            		@WDB_S_Name = @WDB_S_Name OUTPUT,
            		@WDB_P_Name = @WDB_P_Name OUTPUT,
            		@WDB_A_Name = @WDB_A_Name OUTPUT,
            		@WDB_TestOfficerEmployeeID = @WDB_TestOfficerEmployeeID OUTPUT,
            		@A_Type = @A_Type OUTPUT,
            		@A_Make = @A_Make OUTPUT,
            		@A_Model = @A_Model OUTPUT,
            		@A_SerialNumber = @A_SerialNumber OUTPUT,
            		@A_PerformanceRange = @A_PerformanceRange OUTPUT,
            		@A_Description = @A_Description OUTPUT,
            		@A_CF_FileNumber_fk = @A_CF_FileNumber_fk OUTPUT,
            		@FileTitle = @FileTitle OUTPUT

            SELECT	@OR1_InternalOrExternal as N'OR1_InternalOrExternal',
            		@A_OR1_OrgID_fk as N'A_OR1_OrgID_fk',
            		@OrgName as N'OrgName',
            		@A_ContactID as N'A_ContactID',
            		@ContactName as N'ContactName',
            		@WDB_B_Name as N'WDB_B_Name',
            		@WDB_S_Name as N'WDB_S_Name',
            		@WDB_P_Name as N'WDB_P_Name',
            		@WDB_A_Name as N'WDB_A_Name',
            		@WDB_TestOfficerEmployeeID as N'WDB_TestOfficerEmployeeID',
            		@A_Type as N'A_Type',
            		@A_Make as N'A_Make',
            		@A_Model as N'A_Model',
            		@A_SerialNumber as N'A_SerialNumber',
            		@A_PerformanceRange as N'A_PerformanceRange',
            		@A_Description as N'A_Description',
            		@A_CF_FileNumber_fk as N'A_CF_FileNumber_fk',
            		@FileTitle as N'FileTitle'

            SELECT	'Return Value' = @return_value";
                    
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $Q_YearSeq_pk);
        
        $stmt->execute();
        
        return $stmt->fetch();
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

        $sql .= "Q_FullNumber AS QuoteNumber, A_Description AS [Description], TestOfficer, ";
        $sql .= "A_Type AS Type, A_Make AS Make, A_Model AS Model, A_SerialNumber AS SerialNumber, ";
        $sql .= "A_PerformanceRange AS PerformanceRange, OR1_FullName AS Owner, Q_QuotedPrice AS QuotedPrice, ";
        $sql .= "Q_ServicesOffered AS ServicesOffered, Q_CertificateOffered AS CertificateOffered, Q_SpecialRequirements AS SpecialConditions, ";
        $sql .= "Q_PurchaseOrderNumber AS PurchaseOrderNumber, A_CF_FileNumber_fk AS CbFileNumber, ";
        $sql .= "dbo.fn_DateInWords(Q_OfferDate) AS QuoteOfferDate, dbo.fn_DateInWords(Q_ExpiryDate) AS QuoteExpiryDate, ";
        $sql .= "dbo.fn_DateInWords(Q_DateInstRequired) AS DateInstRequired, dbo.fn_DateInWords(Q_TargetReportDespatchDate) AS TargetReportDespatchDate, ";
        $sql .= "dbo.fn_DateInWords(Q_DateSent) AS DateQuoteSent, dbo.fn_DateInWords(Q_OutComeDate) AS QuoteOutcomeDate, ";
        $sql .= "Q_DeliveryInstructions As DeliveryInstructions, Q_SentMethod As QuoteSentMethod, FullStatusString, Q_YearSeq_pk, FullStatusDaysInt ";
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_order_by();
        
        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    /*
     * Insert Create Batch
     * @param array fields
     * @author Namal
     */
     public static function insert_create_batch(Array $fields)
     {
        $valid_fields = array('Q_YearSeq_pk', 'QuotesToBatch', 'Q_FullNumberOUT');
        
        $sql = "
            SET NOCOUNT ON
            DECLARE @return_value int

            EXEC    @return_value   = [sp_BulkQuoteInsert]
                    @Q_YearSeq_pk   = :Q_YearSeq_pk,
                    @QuotesToBatch  = :QuotesToBatch,
                    @Q_FullNumberOUT = :Q_FullNumberOUT

            SELECT  'return' = @return_value";
            
             $stmt = \NMI::Db()->prepare($sql);
             
       
        foreach($valid_fields as $field_name)
        {
            if(isset($fields[ $field_name ]))
            {
                $stmt->bindValue($field_name, $fields[ $field_name ]);
            }
        }

        $stmt->execute();

        return $stmt->fetch();

     }
     
     /*
      * Get Employee list for hours log
      * @author Namal
      * @param string WDB_P_Name Proj from mainform worklog
      * @return array employee list
      */
     
     public static function get_hours_log_employee_list($WDB_P_Name)
     {
        $stmt = \NMI::Db()->prepare("SELECT DISTINCT EM1_EmployeeID_pk, EM1_Lname_ind, EM1_LastNameFirst FROM t_Employee1 INNER JOIN t_j_ProjectEmployee ON EM1_EmployeeID_pk = PE_EmployeeID_fk INNER JOIN t_Project ON PE_ProjectID_ind_fk = P_ProjectID_pk WHERE P_Name_ind = ? ORDER BY EM1_Lname_ind ASC");
        $stmt->bindParam(1, $WDB_P_Name);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
     }

     /**
      * Delete a workgroup entry
      * @param  [type] $WDB_WorkDoneBy_pk [description]
      * @return [type]                    [description]
      */
     public static function delete_workgroup($WDB_WorkDoneBy_pk)
     { 

        $sql = "
            SET NOCOUNT ON
            DECLARE @return_value int,
                    @WDB_WorkDoneBy_pk int

            EXEC    @return_value   = [sp_delete_from_t_WorkDoneBy]
                    @WDB_WorkDoneBy_pk   = :WDB_WorkDoneBy_pk
            SELECT  'return' = @return_value";

        $stmt = \NMI::Db()->prepare($sql);


        $stmt->bindValue('WDB_WorkDoneBy_pk', $WDB_WorkDoneBy_pk);
       try{
         $stmt->execute();
       }catch(\PDOException $e){
          \Message::set('error',  "can’t delete multiple price compositions");
          return 2;
       }

        $return = $stmt->fetch();
        return $return['return'];
     }

    /**
     * Get hours log for a specific worklog entry
     * @param  [type] $WDB_WorkDoneBy_pk [description]
     * @return [type]                    [description]
     * @author  Sahan <[email]>
     */
    public static function get_work_log_hrs($WDB_WorkDoneBy_pk)
    {
        $sql = "SELECT H_HoursID_pk, H_HoursInHhMm, H_HoursDate, H_HoursType, H_EmployeeID, H_Q_YearSeq, H_WDB_WorkDoneBy_fk_ind, (SELECT EM1_FullNameNoTitle FROM t_Employee1 WHERE EM1_EmployeeID_pk = H_EmployeeID) AS EmployeeFullName FROM t_Hours WHERE H_WDB_WorkDoneBy_fk_ind = ? ORDER BY H_HoursDate DESC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($WDB_WorkDoneBy_pk));
        return $stmt->fetchAll();
    }
    
    
    	/*
	*Get Internal Projects
	**
	*/
	public static function get_nmi_internal_projects(){
		$sql	=	"SELECT      OR1_OrgID_pk, OR1_FullName
					FROM          t_Organisation1
					WHERE      OR1_InternalOrExternal = 'NMI' AND OR1_CurrencyStatus = 'CURRENT'
					ORDER BY OR1_Name_ind ASC";
		//$sql->execute();
        $rows = \NMI::DB()->query($sql)->fetchAll();
		//return $rows;
        return \Arr::assoc_to_keyval($rows,'OR1_OrgID_pk', 'OR1_FullName');
	}
	
	/*
	*Get Internal Contacts
	**
	*/
	public static function get_nmi_internal_contacts(){
		$sql	=	"SELECT      EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Lname_ind + ', ' + EM1_FName
					FROM          t_Employee1
					WHERE      EM1_CurrencyStatus = 'CURRENT'
					ORDER BY EM1_Lname_ind ASC";
					
        $rows = \NMI::DB()->query($sql)->fetchAll();
		//return $rows;
        return \Arr::assoc_to_keyval($rows,'EM1_EmployeeID_pk', 'EM1_FullNameNoTitle');
	}
    
    /**
     * Delete hours log
     * @param
     * @return
     * @author Namal
     */
    public static function delete_work_log_hrs($H_HoursID_pk)
    {
        $sql  = "sp_delete_from_t_Hours :H_HoursID_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(':H_HoursID_pk', $H_HoursID_pk);
        $stmt->execute();
    }

    /**
     * Insert into hours log
     */
    public static function insert_into_hour_log($H_HoursInHhMm, $date, $employee, $WDB_WorkDoneBy_pk, $H_HoursType)
    {
        $stmt = \NMI::Db()->prepare("EXEC sp_Insert_into_t_Hours :H_HoursInHhMm, :H_HoursDate, :H_EmployeeID, :H_WDB_WorkDoneBy_fk_ind, :H_HoursType");
        $stmt->bindValue('H_HoursInHhMm', $H_HoursInHhMm);
        $stmt->bindValue('H_HoursDate', $date);
        $stmt->bindValue('H_EmployeeID', $employee);
        $stmt->bindValue('H_WDB_WorkDoneBy_fk_ind', $WDB_WorkDoneBy_pk);
        $stmt->bindValue('H_HoursType', $H_HoursType);
        $stmt->execute();

    }
    
    /**
     * Email for user
     * @author Namal
     */
    public static function generate_email($quote_id)
    {
        $artefact   = \Artefacts\Model_Artefact::get_artefact($quote_id);
        $quote      = self::get_quote($quote_id);
        $employee   = \Employees\Model_Employee::get_all_employee($quote['Q_PreparedByEmployeeID']);
        $contact    = \NMI::current_user('full_name_no_title');

        $Subject    = $quote['Q_FullNumber'].": ".$artefact['A_Description'];
        $address    = $employee['EM1_Email'];
        
        $BodyText   = "The above quote has been sent by 'Q_SentMethod' on 'Q_DateSent'. ";
        $BodyText  .= "Please contact {$contact} if you require any further information.";
        
        return array('address' => $address, 'subject' => $Subject, 'body' => $BodyText);
    }
    
    /*
     * Build Artefact Description - build for insert new quote
     * @param $arg
     * @return null
     * @author Namal
     */
    public static function build_artifact_descrption($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange)
    {
        $sql  = "sp_BuildArtefactDescription @A_Type=?, @A_Make=?, @A_Model=?, @A_SerialNumber=?, @A_PerformanceRange=?, @A_Description=?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $A_Type);
        $stmt->bindValue(2, $A_Make);
        $stmt->bindValue(3, $A_Model);
        $stmt->bindValue(4, $A_SerialNumber);
        $stmt->bindValue(5, $A_PerformanceRange);
        $stmt->bindParam(6, $A_Description, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 180);
        $stmt->execute();
        
        return $A_Description;
    }
    
    
       /**
     * Insert new quote base on previouse quote = sp_NewQuoteBasedOnPreviousQuote
     * @return int/bool 1,0 returned on an error, bool true is returned on seuccess
	 * code by sri
     * @return [type] [description]
     */
    public static function call_to_sp_NewQuoteBasedOnPreviousQuote(Array $fields)
    { //echo $fields['Q_YearSeq_pk']; exit;
		 $valid_fields = array('Q_YearSeq_pk','OR1_InternalOrExternal','A_OR1_OrgID_fk','OrgName','A_ContactID','ContactName','WDB_B_Name','WDB_S_Name','WDB_P_Name','WDB_A_Name','WDB_TestOfficerEmployeeID','A_Type','A_Make','A_Model','A_SerialNumber','A_PerformanceRange','A_Description','A_CF_FileNumber_fk','FileTitle');

$sql = "    

DECLARE	
		@return_value int,@OR1_InternalOrExternal varchar(30),@A_OR1_OrgID_fk int,@OrgName varchar(120),@A_ContactID int,@ContactName varchar(80),@WDB_B_Name varchar(80),@WDB_S_Name varchar(80),@WDB_P_Name varchar(80),@WDB_A_Name varchar(80),@WDB_TestOfficerEmployeeID int,@A_Type varchar(80),@A_Make varchar(80),@A_Model varchar(80),@A_SerialNumber varchar(400),@A_PerformanceRange varchar(80),@A_Description varchar(600),@A_CF_FileNumber_fk varchar(16),@FileTitle varchar(200)


EXEC	
@return_value = [dbo].[sp_NewQuoteBasedOnPreviousQuote]	@Q_YearSeq_pk = ?,@OR1_InternalOrExternal = @OR1_InternalOrExternal OUTPUT,@A_OR1_OrgID_fk = @A_OR1_OrgID_fk OUTPUT,@OrgName = @OrgName OUTPUT,@A_ContactID = @A_ContactID OUTPUT,@ContactName = @ContactName OUTPUT,@WDB_B_Name = @WDB_B_Name OUTPUT,@WDB_S_Name = @WDB_S_Name OUTPUT,@WDB_P_Name = @WDB_P_Name OUTPUT,@WDB_A_Name = @WDB_A_Name OUTPUT,@WDB_TestOfficerEmployeeID = @WDB_TestOfficerEmployeeID OUTPUT,@A_Type = @A_Type OUTPUT,@A_Make = @A_Make OUTPUT,	@A_Model = @A_Model OUTPUT,	@A_SerialNumber = @A_SerialNumber OUTPUT,@A_PerformanceRange = @A_PerformanceRange OUTPUT,@A_Description = @A_Description OUTPUT,@A_CF_FileNumber_fk = @A_CF_FileNumber_fk OUTPUT,@FileTitle = @FileTitle OUTPUT


SELECT	
@OR1_InternalOrExternal as N'sel_type_owner',@A_OR1_OrgID_fk as N'hid_org_id',@OrgName as N'org_names',@A_ContactID as N'hid_contact_id',@ContactName as N'org_contact',@WDB_B_Name as N'branch_name',@WDB_S_Name as N'S_Name_ind',@WDB_P_Name as N'projects',@WDB_A_Name as N'areas',@WDB_TestOfficerEmployeeID as N'offices',@A_Type as N'types',@A_Make as N'make',@A_Model as N'model',@A_SerialNumber as N'serial_no',@A_PerformanceRange as N'range',@A_Description as N'description',@A_CF_FileNumber_fk as N'file_no',@FileTitle as N'title'

SELECT	'Return Value' = @return_value";

        $stmt = \NMI::Db()->prepare($sql);
    	$stmt->bindValue(1, $fields['Q_YearSeq_pk']); 
		$stmt->execute();
		$row = $stmt->fetch();
		return $row;


    }
    
    
       
    /**
     * Get CERTIFICATE OFFERED
     * @author  Thanraga
     * @param int A_ProjectID_fk
     * @return Array
     */
    public static function get_certificate_offred()
    { 
        $stmt = \NMI::Db()->query("SELECT      CO_CertName_pk
                                        FROM          t_CertificateOffered
                                        ORDER BY CO_CertName_pk ASC");
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'CO_CertName_pk', 'CO_CertName_pk');
    }
    
    public static function update_quote($Q_YearSeq_pk,$getString,$getDate){
        $sql = " UPDATE t_Quote SET Q_OutCome='" . $getString . "',Q_OutComeDate='".$getDate."' WHERE Q_YearSeq_pk='" . $Q_YearSeq_pk . "'";
        $stmt = \NMI::Db()->query($sql);
        return $stmt;
    }
    
}
/* eof */
