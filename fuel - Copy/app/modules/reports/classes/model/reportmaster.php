<?php

namespace Reports;

class Model_Reportmaster extends \Model_Base
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
        return "FROM t_ReportMasterList";
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
              
            RML_ReportNumber_pk,
            RML_Prefix,
            RML_RnYear,
            RML_RnSeq_ind,
            RML_FileNumber,
            RML_QuoteNumber,
            RML_QnSeq,
            RML_Description,
            RML_TestOfficer,
            RML_DateOfReport,
            RML_Contact,
            RML_OrganisationFullName,
            RML_RecordDerivedFrom
              ";
        
    }

    public function sql_where()
    {
        $filter  = $this->filter;
        $sWSt    = '';
        $swhere  = '';
        
        
        
         if(isset($filter['source']) && !empty($filter['source']))
        {
            //print_r($filter['type']);exit;
           if($filter['source']=='Current T&amp;C'){
               $filter['source']=htmlspecialchars_decode($filter['source']);
           }
           if($filter['source']=='Old T&amp;C'){
               $filter['source']=htmlspecialchars_decode($filter['source']);
           }
            if($filter['source']=='55555'){
               $filter['source']='Old T&amp;C';
           }
             $swhere .= " AND RML_RecordDerivedFrom        ='{$filter['source']}'"; 
        }else{
            $swhere .= null;
        }
        
          if(isset($filter['organisation']) && !empty($filter['organisation']))
        {
            //print_r($filter['type']);exit;
             $filter['organisation']= str_replace("&amp;","&",$filter['organisation']);
          
             $swhere .= " AND RML_OrganisationFullName   ='{$filter['organisation']}'"; 
        }else{
            $swhere .= null;
        }
        
        $swhere .= isset($filter['prefix'])       && !empty($filter['prefix'])      ? " AND RML_Prefix               = '{$filter['prefix']}'"      : null;
        $swhere .= isset($filter['year'])         && !empty($filter['year'])        ? " AND RML_RnYear               = '{$filter['year']}'"        : null;
        //$swhere .= isset($filter['organisation']) && !empty($filter['organisation'])? " AND RML_OrganisationFullName = '{$filter['organisation']}'"      : null;
       // $swhere .= isset($filter['source'])       && !empty($filter['source'])      ? " AND RML_RecordDerivedFrom        = '{$filter['source']}'"      : null;
        $swhere .= isset($filter['test_officer']) && !empty($filter['test_officer'])? " AND RML_TestOfficer          = '{$filter['test_officer']}'"      : null;

        
        if(!empty($this->search_criteria)){
          $filter = \Helper_App::build_search_string($this->search_criteria['field_crieteria_01'], $this->search_criteria['field_crieteria_02'], $this->search_criteria['date_crieteria'], $this->SearchCriteria1(), $this->SearchCriteria2(), $this->DateCriteria1());
        }else{
            $filter = '';
        }
       

        return "WHERE RML_Prefix IS NOT NULL {$sWSt} {$swhere} {$filter}";
    }

    public function sql_orderby()
    {                                            

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY RML_RnSeq_ind DESC";

        $sorderby           = null;
        $order_by           = array_merge(array('column' => '', 'sort' => ''), (array) $this->order_by);
        $order_by['column'] = $this->order_by['column'];
        $order_by['sort1']   = ($this->order_by['sort']=='desc') ? 'ASC' : 'DESC';

        switch ($order_by['column']) {
          
            case "ReportNumber":
                $sorder_by  = "ORDER BY RML_RnSeq_ind ".strtoupper($order_by['sort']);
            break;
            case "QuoteNumber":
                $sorder_by  = "ORDER BY RML_QnSeq ".strtoupper($order_by['sort1']);
            break;
            case "Organisation":
                $sorder_by  = "ORDER BY RML_OrganisationFullName ".strtoupper($order_by['sort']);
            break;
            case "TestOfficer":
                $sorder_by  = "ORDER BY RML_TestOfficer ".strtoupper($order_by['sort']);
            break;
            case "DOR":
                $sorder_by  = "ORDER BY RML_DateOfReport ".strtoupper($order_by['sort1']);
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
                $sql = "RML_Description ";
                break;
            case "Artefact Make":
                $sql = "RML_Make ";
                break;
            case "Artefact Model":
                $sql = "RML_Model ";
                break;
            case "Artefact Serial number":
                $sql = "RML_SerialNumber ";
                break;
            case "Artefact Contact":
                $sql = "RML_Contact ";
                break;
            case "File number":
                $sql = "RML_FileNumber ";
                break;
            case "Artefact Owner":
                $sql = "RML_OrganisationFullName ";
                break;
            case "Report number":
                $sql = "RML_ReportNumber_pk ";
                break;
            case "Test Officer":
                $sql = "RML_TestOfficer ";
                break;
            case "Services Offered":
                $sql = "RML_ServicesOffered ";
                break;
            case "Special Conditions":
                $sql = "RML_SpecialRequirements ";
                break;
            case "Quote number":
                $sql = "RML_QuoteNumber ";
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
        
        
        //print_r($filter['field']);exit;
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
                $sql .= "NOT LIKE '%" .$criteria. "%' ";
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
                $sql = "RML_Description ";
                break;
            case "Artefact Make":
                $sql = "RML_Make ";
                break;
            case "Artefact Model":
                $sql = "RML_Model ";
                break;
            case "Artefact Serial number":
                $sql = "RML_SerialNumber ";
                break;
            case "Artefact Contact":
                $sql = "RML_Contact ";
                break;
            case "File number":
                $sql = "RML_FileNumber ";
                break;
            case "Artefact Owner":
                $sql = "RML_OrganisationFullName ";
                break;
            case "Report number":
                $sql = "RML_ReportNumber_pk ";
                break;
            case "Test Officer":
                $sql = "RML_TestOfficer ";
                break;
            case "Services Offered":
                $sql = "RML_ServicesOffered ";
                break;
            case "Special Conditions":
                $sql = "RML_SpecialRequirements ";
                break;
            case "Quote number":
                $sql = "RML_QuoteNumber ";
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
                       $sql = "RML_DateOfReport <= '" . $to_date . "'";
                    }else if($what_to_apply == "From date only"){
                       $sql = "RML_DateOfReport >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(RML_DateOfReport >= '" . $from_date . "' AND RML_DateOfReport <= '" . $to_date . "') ";
                    }
                break;
                
                case 'Quotation date':
                    if($what_to_apply == "To date only"){
                       $sql = "RML_QuoteDate <= '" . $to_date. "'";
                    }else if($what_to_apply == "From date only"){
                      $sql = "RML_QuoteDate >= '" . $from_date. "'";
                    }else if($what_to_apply == "To and from date" ){
                       $sql = "(RML_QuoteDate >= '" . $from_date . "' AND RML_QuoteDate <= '" . $to_date . "') ";
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

        //calling query builders
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
                   //print_r($page_sql);exit;
        $count_sql  = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT RML_ReportNumber_pk) AS [count] FROM NumberedRows', ''), $full_sql);

        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => $rows);
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------


    public function get_prefix()
    {                                                   

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT RML_Prefix {$from} {$where}";
        $sql   .= "ORDER BY RML_Prefix ASC";
        
        
         $rows   = \NMI::Db()->query($sql)->fetchAll();
         $newRow=\Arr::assoc_to_keyval($rows, 'RML_Prefix', 'RML_Prefix');
         $countArray=count($newRow);
         if($countArray==0){
            $newRow=array(); 
         }
         return $newRow;
    }

    public function get_year()
    {                                        

        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT RML_RnYear {$from} {$where}";
        $sql   .= "AND RML_RnYear IS NOT NULL ";
        $sql   .= "ORDER BY RML_RnYear DESC";
        
          $rows   = \NMI::Db()->query($sql)->fetchAll();
         $newRow=\Arr::assoc_to_keyval($rows, 'RML_RnYear', 'RML_RnYear');
         $countArray=count($newRow);
         if($countArray==0){
            $newRow=array(); 
         }
         return $newRow;
        
  
    }

    public function get_organisation()
    {   
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT  RML_OrganisationFullName {$from} {$where}";
        $sql   .= "ORDER BY RML_OrganisationFullName ASC";

 $rows   = \NMI::Db()->query($sql)->fetchAll();
         $newRow=\Arr::assoc_to_keyval($rows, 'RML_OrganisationFullName', 'RML_OrganisationFullName');
         $countArray=count($newRow);
         if($countArray==0){
            $newRow=array(); 
         }
         return $newRow;


    }

    public function get_test_officer($id=null)
    {                                                 
        $from   = $this->sql_from();
        $where  = ($id)?'':$this->sql_where();

        $sql    = "SELECT DISTINCT RML_TestOfficer {$from} {$where}";
        $sql   .= "ORDER BY RML_TestOfficer ASC";

       $rows   = \NMI::Db()->query($sql)->fetchAll();
         $newRow=\Arr::assoc_to_keyval($rows, 'RML_TestOfficer', 'RML_TestOfficer');
         $countArray=count($newRow);
         if($countArray==0){
            $newRow=array(); 
         }
         return $newRow;
      
      
    }

    public function get_source()
    {                                   
        $from   = $this->sql_from();
        $where  = $this->sql_where();

        $sql    = "SELECT DISTINCT RML_RecordDerivedFrom {$from} {$where}";
        $sql   .= "ORDER BY RML_RecordDerivedFrom ASC";
       $rows   = \NMI::Db()->query($sql)->fetchAll();
         $newRow=\Arr::assoc_to_keyval($rows, 'RML_RecordDerivedFrom', 'RML_RecordDerivedFrom');
        $countArray=count($newRow);
     
        
  //print_r($newRow);exit;
         return $newRow;
      

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
        
        $sql .=  "RML_ReportNumber_pk AS ReportNumber, RML_QuoteNumber AS QuoteNumber, RML_TestOfficer As TestOfficer, ";
        $sql .=  "RML_Description AS [Description], RML_Make AS Make, RML_Model AS Model, RML_SerialNumber AS SerialNumber, ";
        $sql .=  "dbo.fn_DateInWords(RML_DateOfReport) AS DateOfReport, RML_Contact AS ClientContact, ";
        $sql .=  "RML_OrganisationFullName AS Owner, RML_ServicesOffered As ServicesOffered, ";
        $sql .=  "RML_SpecialRequirements AS SpecialConditions, ";
        $sql .=  "RML_FileNumber As FileNumber, RML_Comments AS Comments, RML_RecordDerivedFrom AS DerivedFrom, ";
        $sql .=  "RML_Prefix As Prefix, RML_RnYear As Year, RML_RnSeq_ind As ReportSeq, RML_QnSeq As QuoteSeq ";
        
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();

        return \NMI::DB()->query($sql)->fetchAll();
        
    }
	
	
	public static function get_report_master_data($id=null)
    {
        $sql = "SELECT * FROM t_ReportMasterList WHERE RML_ReportNumber_pk = '$id'";
		return \NMI::DB()->query($sql)->fetchAll();       
    }
    
    /*
     * function get_quote_number - description
     * @param $Q_FullNumber
     * @return $Q_YearSeq_pk
     * @author Namal
     */
    public static function get_quote_number($Q_FullNumber)
    {
        $sql  = "SELECT Q_YearSeq_pk FROM t_Quote WHERE Q_FullNumber = :Q_FullNumber";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam('Q_FullNumber', $Q_FullNumber);
        $stmt->execute();
        
        $row = $stmt->fetch();
        return $row['Q_YearSeq_pk'];
        
        
    }

}