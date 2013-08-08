<?php

namespace Files;

class Model_File extends \Model_Base 
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
        return "FROM t_CbFile LEFT OUTER JOIN vw_QuoteListing ON CF_FileNumber_pk = A_CF_FileNumber_fk LEFT OUTER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind ";
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
                CF_FileNumber_pk,
                CF_Year,
                CF_Seq,
                CF_Title,
                CF_FileLocation,
                CF_FileRequestLocation,
                CF_FileRequestDate,
                CF_FileSummary,
                CF_DirectoryPath,
                CF_MainImagePath";
        
    }

    public function sql_where()
    {


        $filter = \NMI_Db::escape($this->filter);
        $swhere = '';   //print_r($filter);exit;
        
        if(isset($filter['type']) and !empty($filter['type']))
        {
            //print_r($filter['type']);exit;
           if($filter['type']=='\'90&deg; square block\''){
               $filter['type']='\'90° square block\'';
           }
             $swhere .= "AND A_Type = {$filter['type']}"; 
        }else{
            $swhere .= null;
        }
        
        if(isset($filter['owner']) && !empty($filter['owner']))
        {
            //print_r($filter['type']);exit;
             $filter['owner']= str_replace("&amp;","&",$filter['owner']);
          
             $swhere .= " AND OR1_FullName   ={$filter['owner']}"; 
        }else{
            $swhere .= null;
        }
        
        
        //print_r($filter['optShowCatchAlls']);exit;
        $swhere .= isset($filter['year'])       && !empty($filter['year']) ? "AND CF_Year = {$filter['year']}" : null;
        //$swhere .= isset($filter['type'])       && !empty($filter['type']) ? "AND A_Type = {$filter['type']}" : null;
        $swhere .= isset($filter['file_type'])  && !empty($filter['file_type']) ? "AND CF_Prefix = {$filter['file_type']}" : null;
        $swhere .= isset($filter['branch'])     && !empty($filter['branch']) ? "AND WDB_B_Name = {$filter['branch']}" : null;
        $swhere .= isset($filter['section'])    && !empty($filter['section']) ? "AND WDB_S_Name = {$filter['section']}" : null;
        $swhere .= isset($filter['project'])    && !empty($filter['project']) ? "AND WDB_P_Name = {$filter['project']}" : null;
        $swhere .= isset($filter['area'])       && !empty($filter['area']) ? "AND WDB_A_Name = {$filter['area']}" : null;
        $swhere .= isset($filter['test_officer']) && !empty($filter['test_officer']) ? "AND TestOfficer = {$filter['test_officer']}" : null;
        $swhere .= isset($filter['file_location']) && !empty($filter['file_location']) ? "AND FileLocation = {$filter['file_location']}" : null;
        $swhere .= isset($filter['org_type'])   && !empty($filter['org_type']) ? "AND OR1_InternalOrExternal = {$filter['org_type']}" : null;
        $swhere .= isset($filter['optShowCatchAlls'])   && ($filter['optShowCatchAlls']=='\'yes\'') ? "AND (CF_Seq = 0 OR CF_Seq = 2000) " : null;
        //$swhere .= isset($filter['owner']) && !empty($filter['owner']) ? "AND OR1_FullName =  {$filter['owner']}" : null;
       $swhere .= isset($filter['owner_type']) && !empty($filter['owner_type']) ? "AND OR1_InternalOrExternal = {$filter['owner_type']}" : null;
        

        $filter = null;
        
        //TODO, not coming second param
        if(!empty($this->search_criteria)){
        $filter = \Helper_App::build_search_string("AND", $this->search_criteria['field_crieteria_02'], 'N/A', $this->SearchCriteria1(), $this->SearchCriteria2() );
          //print_r($filter);exit;      
        }else{
            $filter = '';
        }
        return "WHERE CF_Year > 0 {$swhere} {$filter} ";
         
    }

    public function sql_orderby()
    { 

        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY CF_Year DESC, CF_Seq DESC";

        $sorderby = null;
        $order_by = array_merge(array('column' => '', 'sort' => ''), (array) ($this->order_by));
        $order_by['column'] = $this->order_by['column'];
         $order_by['sort1']   = ($this->order_by['sort']=='desc') ? 'ASC' : 'DESC';
//print_r(($this->order_by['column']));exit;
        switch ($order_by['column']) {
          
            case "Number":
                $sorder_by = "ORDER BY CF_Year ". strtoupper($order_by['sort']).", CF_Seq ". strtoupper($order_by['sort']);
                break;
            case "Title":
                $sorder_by = "ORDER BY CF_Title ". strtoupper($order_by['sort']);
                break;
            case "Location":
                $sorder_by = "ORDER BY CF_FileLocation " . strtoupper($order_by['sort']);
                break;
        }
        
        return $sorder_by;
    }

     public function SearchCriteria1() 
    {
        
        
        
        $filter = $this->search_criteria;
//print_r($filter);exit;[field_crieteria_02]
        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria'])){
           // print_r('shanila');exit;
            return null;
        }
        $sql = null;
        
        switch ($filter['field']) {
            case "File title":
                $sql = "CF_Title ";
                break;
            case "File number":
                $sql = "CF_FileNumber_pk ";
                break;
            case "File location":
                $sql = "CF_FileLocation ";
                break;
        }

         
                 $option1='';
                       if($filter['equality']=="LIKE"||$filter['equality']=="NOT LIKE"){
                    $option1='yes';

                }else{
                    $option1='no';
                }
                
        
        
        //print_r($option1.' '.$option2);exit;
            if( $filter['field']=='File title' &&($option1=='yes') ){
             
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
        //print_r($filter['advance']['field']);exit;
        //$filter = array_merge(array('field' => '', 'equality' => '', 'criteria' => ''), (array) $this->search_criteria);

        if (empty($this->search_criteria) || empty($filter['advance']['field']) || empty($filter['advance']['equality']) || empty($filter['advance']['criteria'])){
            return null;
        }
        $sql = null;
        

        switch ($filter['advance']['field']) {
            case "File title":
                $sql = "CF_Title ";
                break;
            case "File number":
                $sql = "CF_FileNumber_pk ";
                break;
            case "File location":
                $sql = "CF_FileLocation ";
                break;
        }
        
        
        
        
         
        $option1='';
                if($filter['advance']['equality']=="LIKE"||$filter['advance']['equality']=="NOT LIKE"){
            $option1='yes';
        
        }else{
            $option1='no';
        }
      
        
        if( $filter['advance']['field']=='File title' && ($option1=='yes') ){
             
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

        $select = $this->sql_select();
        $from   = $this->sql_from();
        $where  = $this->sql_where();
        $order_by = $this->sql_orderby();
//print_r($where);exit;
        $full_sql = "WITH NumberedRows AS 
            (
                    {$select},
                            Row_Number() OVER ({$order_by}) AS RowNumber 
                    {$from}
                    {$where}
                    
            ) 
            SELECT * FROM NumberedRows";
                                        

       // $page_sql = $full_sql . ' ' . $paging;
         $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by;  
        // print_r($page_sql);exit;
                    
        $count_sql = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT CF_FileNumber_pk) AS [count] FROM NumberedRows', ''), $full_sql);

        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

            return array('count' => (int) $count['count'], 'result' => $rows);
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------

    
     public function get_org_type()
     { 
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT OR1_InternalOrExternal {$from} {$where} ";
        $sql .= "AND OR1_InternalOrExternal IS NOT NULL ";
        $sql .= "ORDER BY OR1_InternalOrExternal ASC";

        $rows    = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'OR1_InternalOrExternal', 'OR1_InternalOrExternal');
    }
    
    
     public function get_file_type() 
     {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT CF_Prefix {$from} {$where} ";
        $sql .= "AND CF_Prefix IS NOT NULL ";
        $sql .= "ORDER BY CF_Prefix ASC";

        $rows    = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'CF_Prefix', 'CF_Prefix');
    }
    

    public function get_branches()
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_B_Name {$from} {$where} ";
        $sql .= "AND WDB_B_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_B_Name ASC";

        $rows    = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }

    public function get_sections() 
    { 
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_S_Name {$from} {$where} ";
        $sql .= "AND WDB_S_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_S_Name ASC";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
    }

    public function get_projects() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_P_Name {$from} {$where} ";
        $sql .= "AND WDB_P_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_P_Name ASC";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
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
    
    
    
    public function get_areas() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT WDB_A_Name {$from} {$where} ";
        $sql .= "AND WDB_A_Name IS NOT NULL ";
        $sql .= "ORDER BY WDB_A_Name ASC";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
            return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }

    public function get_types() 
    { 
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT A_Type {$from} {$where} ";
        $sql .= "AND A_Type IS NOT NULL ";
        $sql .= "ORDER BY A_Type ASC";

        $rows = \NMI::Db()->query($sql)->fetchAll();
        $data = \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
        return array_filter($data, 'strlen');
    }
    
    public function get_org() 
    { 
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT  OR1_FullName {$from} {$where} ";
        $sql .= "AND OR1_Name_ind IS NOT NULL ";
        $sql .= "ORDER BY OR1_FullName ASC";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'OR1_FullName', 'OR1_FullName');
    }
    
    public function get_year() 
    {
        $from  = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT CF_Year {$from} {$where} ";
        $sql .= "ORDER BY CF_Year DESC ";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'CF_Year', 'CF_Year');
    }
    
    
    
    public function get_test_offices() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT TestOfficer {$from} {$where} ";
        $sql .= "AND TestOfficer IS NOT NULL ";
        $sql .= "ORDER BY TestOfficer ASC";
        
        $rows = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'TestOfficer', 'TestOfficer');
     }

    
    /**
     * Get a single cb file
    *  @param  $CF_FileNumber_pk CB FILE PK
     * @return [type] [description]
     */
    public static function get_cb_file($CF_FileNumber_pk)
    {
        $stmt = \NMI::DB()->prepare("SELECT * FROM t_CbFile WHERE CF_FileNumber_pk=?");
        $stmt->execute(array($CF_FileNumber_pk));
        return $stmt->fetch();
    }
    
     public static function get_cb_file_list($CF_YearSeq_ind)
    {
        $stmt = \NMI::DB()->prepare("SELECT * FROM t_CbFile WHERE CF_YearSeq_ind=?");
        $stmt->execute(array($CF_YearSeq_ind));
        return $stmt->fetch();
    }
    
    /*
     * function get_cb_file_based_CF_YearSeq_ind - for display main image
     * @param $CF_YearSeq_ind
     * @return null
     * @author Namal
     */
    public static function get_cb_file_based_CF_YearSeq_ind($CF_YearSeq_ind)
    {
        $stmt = \NMI::DB()->prepare("SELECT * FROM t_CbFile WHERE CF_YearSeq_ind=?");
        $stmt->execute(array($CF_YearSeq_ind));
        return $stmt->fetch();
    }


     /**
      *attached info tab in main form
      *@author Namal
      */
     
    public static function get_info_type()
    {
        $rows = \NMI::Db()->query("SELECT IT_InfoType_pk_ind FROM t_InformationType")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'IT_InfoType_pk_ind', 'IT_InfoType_pk_ind');
    }


    /**
     * Get atatched info for a cb file
     * @param  $CF_FileNumber_pk CB FILE PK
     * @return [type]                   [description]
     */
    public static function get_attached_info($CF_FileNumber_pk)
    {
        $stmt = \NMI::Db()->prepare("SELECT AI_AttachedInfoID_pk, AI_Date, AI_CreatedBy, AI_Type, AI_CF_FileNumber_fk, AI_Description, AI_Reference, AI_Path, CONVERT(varchar, AI_Date, 103) + ', ' + CONVERT(varchar,DATEDIFF(day,AI_Date, GETDATE())) + ' days ago' AS DaysAgo, CONVERT(varchar, AI_Date, 108) as time FROM t_AttachedInformation WHERE AI_CF_FileNumber_fk=? ORDER BY AI_Date DESC");
        $stmt->bindValue(1, $CF_FileNumber_pk);
        $stmt->execute();
        $return = $stmt->fetchAll();
        return $return;
    }
    
    

    
    
    
    
    /**
     * insert attached info
     * @author Namal
     */
    public static function insert_attached_info(Array $data)
    {
        extract($data);//return  print_r($data);
       
        $sql = "SET NOCOUNT ON             
                DECLARE	@return_value int

                EXEC	@return_value = [dbo].[sp_insert_into_t_AttachedInformation]
                        @AI_Date             = :AI_Date,
                        @AI_CreatedBy        = :AI_CreatedBy,
                        @AI_Type             = :AI_Type,
                        @AI_CF_FileNumber_fk = :AI_CF_FileNumber_fk,
                        @AI_Description      = :AI_Description,
                        @AI_Reference        = :AI_Reference,
                        @AI_Path             = :AI_Path,
                        @AI_AttachedInfoID_pk = :AI_AttachedInfoID_pk
                        
               

                SELECT	'return' = @return_value";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('AI_Date', $AI_Date);
        $stmt->bindValue('AI_CreatedBy', $AI_CreatedBy);
        $stmt->bindValue('AI_Type', $AI_Type);
        $stmt->bindValue('AI_CF_FileNumber_fk', $CF_FileNumber_pk);
        $stmt->bindValue('AI_Description', $AI_Description);
        $stmt->bindValue('AI_Reference', $AI_Reference);
        $stmt->bindValue('AI_Path', $AI_Path);
        $stmt->bindParam('AI_AttachedInfoID_pk', $AI_AttachedInfoID_pk, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 4);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Delete attached info
     * @author Namal
     */
    public static function delete_attached_info($AI_AttachedInfoID_pk)
    {
        $sql  = "sp_delete_from_t_AttachedInformation @AI_AttachedInfoID_pk=:AI_AttachedInfoID_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('AI_AttachedInfoID_pk', $AI_AttachedInfoID_pk);
        $stmt->execute();
    }
    
    /*
     * Move Attached
     */
    
    public static function do_move_attached($fields)
    {
        $CF_FileNumber_pk = $fields['from_AI_CF_FileNumber_fk'];
        $from_AI_AttachedInfoID_pk = $fields['from_AI_AttachedInfoID_pk'];
        $get_attached_info  = Model_File::get_attached_info($CF_FileNumber_pk);
        $get_attached_info  = $get_attached_info[0];
        
        
        $To_CF_FileNumber_pk = $fields['to_AI_CF_FileNumber_fk'];
        $to_cb_inof = Model_File::get_cbfile_full_info($To_CF_FileNumber_pk);
        
        $error_count = 0;
        
        if($get_attached_info['AI_Path']==''){
            \Message::set('error', 'No file to move.');
            $error_count = 1;
        }else{
          $path     = \Uri::base(false);
         // $path     = \Uri::create($path.'files/attached/log/'.$fields['quote_id'] . '/' . $get_attached_info['AI_Path']);
          $path = \Config::get('attached_log') .DS. $fields['quote_id'].DS. $get_attached_info['AI_Path']; 
          if(!file_exists($path)){
            \Message::set('error', 'The file  '.$get_attached_info['AI_Path'].'  does not exist? Please rectify.');
            $error_count = 1; 
          }else{
              if($to_cb_inof['CF_DirectoryPath']==''){
                    \Message::set('error','Please create a directory path for'.$fields['to_AI_CF_FileNumber_fk']. ".");
                     $error_count = 1;             
              }else{
                if($error_count==0){
                    $return = Model_File::call_to_move_attached($from_AI_AttachedInfoID_pk,$get_attached_info['AI_Path'],$To_CF_FileNumber_pk);
                   if($return==1){
                        return \Message::set('success', 'Moving success');
                   }else{
                        return \Message::set('error','CB File '. $To_CF_FileNumber_pk. " does not exist.  Operation cancelled.");
                   }
                    
                }
              }
          }
        }

    }
    
    public static function call_to_move_attached($AI_AttachedInfoID_pk,$AI_Path,$AI_CF_FileNumber_fk_New){
        $sql = " 
                   SET NOCOUNT ON 
                   DECLARE	@return_value int

                EXEC	@return_value = [dbo].[sp_MoveAttachedInformation]
                                @AI_AttachedInfoID_pk = :AI_AttachedInfoID_pk,
                                @AI_Path = :AI_Path,
                                @AI_CF_FileNumber_fk_New = :AI_CF_FileNumber_fk_New'

                SELECT	'return' = @return_value";
        $stmt = \NMI::Db()->prepare($sql);
        
        $stmt->bindValue('AI_AttachedInfoID_pk', $AI_AttachedInfoID_pk);
        $stmt->bindValue('AI_Path', $AI_Path);
        $stmt->bindValue('AI_CF_FileNumber_fk_New', $AI_CF_FileNumber_fk_New);
        $stmt->execute();
        $row = $stmt->fetch();

        return $row['Return_Value'];
        
    }

    public static function get_cbfile_full_info($CF_FileNumber_pk)
    {
        $return = \NMI::DB()->query(" SELECT * FROM [t_CbFile] WHERE CF_FileNumber_pk='".$CF_FileNumber_pk."'")->fetchAll();
        return $return;
    }
    


    /**
     * Insert new Files in CB File Module
     * @author Namal
     */
    
    public static function insert_new_file($CF_Prefix, $CF_Year, $CF_Seq, $CF_Title)
    {

        $sql = "
                SET NOCOUNT ON
                DECLARE	@return_value int,
                @CF_FileNumber_pk varchar(16)
        
                EXEC	@return_value = sp_insert_into_t_CbFile
                        @CF_Prefix    = :CF_Prefix,
                        @CF_Year      = :CF_Year,
                        @CF_Seq       = :CF_Seq,
                        @CF_Title     = :CF_Title,
                        @CF_FileNumber_pk = @CF_FileNumber_pk OUTPUT
                                
                SELECT	'Return_Value' = @return_value";
        
        $stmt = \NMI::Db()->prepare($sql);
        
        $stmt->bindValue('CF_Prefix', $CF_Prefix);
        $stmt->bindValue('CF_Year', $CF_Year);
        $stmt->bindValue('CF_Seq', $CF_Seq);
        $stmt->bindValue('CF_Title', $CF_Title);
            
        $stmt->execute();
        $row = $stmt->fetch();

        return $row['Return_Value'];
    }
    
    /**
     * get next number in insert new file form
     * @author Namal
     */
    
    public static function get_next_number($CF_Prefix, $SydMelb)
    {
        $sql = "DECLARE @return_value int,
                                @Next_Seq int,
                                @Next_Year int
                
                EXEC	@return_value = [dbo].[sp_NextCbFileNumber]
                                @SydMelb = ?,
                                @Prefix = ?,
                                @Next_Seq = @Next_Seq OUTPUT,
                                @Next_Year = @Next_Year OUTPUT
                
                SELECT	@Next_Seq as N'Next_Seq',
                                @Next_Year as N'Next_Year'
                
                SELECT	'Return Value' = @return_value
                ";
                
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $CF_Prefix);
        $stmt->bindValue(2, $SydMelb);
       
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /**
     * No file exists, used in new quote
     */
    public static function no_file_exists()
    {
        $sql = "DECLARE @return_value int,
                        @CF_FileNumber_pk varchar(16),
                        @CF_Title varchar(200)

                EXEC    @return_value = sp_NoCbFileExists
                        @CF_FileNumber_pk = @CF_FileNumber_pk OUTPUT,
                        @CF_Title = @CF_Title OUTPUT

                SELECT  @CF_FileNumber_pk as N'CF_FileNumber_pk',
                        @CF_Title as N'CF_Title'

                SELECT  'Return Value' = @return_value";
                
        
        $stmt = \NMI::Db()->prepare($sql);
       
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * build number in insert new file form
     * @author Namal
     */
    
    public static function build_number($CF_Prefix, $CF_Year, $CF_Seq)
    {
        $sql = "DECLARE	@return_value int,
                                @CF_FileNumber_pk varchar(16)
                
                EXEC	@return_value = [dbo].[sp_FormatCbFileNumber]
                                @CF_Prefix = ?,
                                @CF_Year = ?,
                                @CF_Seq = ?,
                                @CF_FileNumber_pk = @CF_FileNumber_pk OUTPUT
                
                SELECT	@CF_FileNumber_pk as N'CF_FileNumber_pk'
                
                SELECT	'Return Value' = @return_value";
        
       $stmt = \NMI::Db()->prepare($sql);
       $stmt->bindValue(1, $CF_Prefix);
       $stmt->bindValue(2, $CF_Year);
       $stmt->bindValue(3, $CF_Seq);
       $stmt->execute();
       return $stmt->fetch();
    
    
    }          

    
    /**
     * Get CB File 
     * @param
     * @author Namal
     */
    
    
   public static function get_cb_file_content($CF_FileNumber_pk)
    {
        $sql = "SELECT * FROM t_CbFile WHERE CF_FileNumber_pk = ?";
        $stmt = \NMI::DB()->prepare($sql);
        $stmt->execute(array($CF_FileNumber_pk));
        return $stmt->fetch();
    }
    
    
     public static function get_cb_location_list(){
		 $sql	=	" SELECT      EM1_LastNameFirst
						FROM          t_Employee1
						UNION
						SELECT      FSL_LocationName_pk
						FROM          t_FileStorageLocations
						ORDER BY EM1_LastNameFirst ASC";
	   $rows = \NMI::Db()->query($sql)->fetchAll();// print_r($rows); exit;
        return \Arr::assoc_to_keyval($rows, 'EM1_LastNameFirst', 'EM1_LastNameFirst');
    }
    

    /**
     * Get CB Content listing
     * @param  $CF_FileNumber_pk
     * @author Tharanga
     */
    public static function get_cb_file_content_list($CF_FileNumber_pk)
    {
        $sql = "SELECT A_YearSeq_pk, A_Description, A_CF_FileNumber_fk, OR1_Name_ind, ContactName = CASE OR1_InternalOrExternal WHEN 'EXTERNAL' THEN
                            (SELECT      CO_Fullname
                              FROM           t_Contact
                              WHERE       CO_ContactID_pk = A_ContactID) WHEN 'NMI' THEN
                            (SELECT      EM1_FullNameNoTitle
                              FROM           t_Employee1
                              WHERE       EM1_EmployeeID_pk = A_ContactID) ELSE 'Error' END, Q_FullNumber
                FROM          t_Artefact INNER JOIN
                                        t_Organisation1 ON A_OR1_OrgID_fk = OR1_OrgID_pk INNER JOIN
                                        t_Quote ON Q_YearSeq_pk = A_YearSeq_pk
                WHERE A_CF_FileNumber_fk = ?
                ORDER BY A_YearSeq_pk DESC";

        $stmt = \NMI::DB()->prepare($sql);
         $stmt->execute(array($CF_FileNumber_pk));
        return $stmt->fetchAll();
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
        
        $sql .= "CF_FileNumber_pk AS CbFileNumber, CF_Year AS [Year], CF_Seq AS Seq, CF_Title AS Title, CF_FileLocation AS Location, ";
        $sql .= "CF_FileRequestLocation AS RequestedLocation, dbo.fn_DateInWords(CF_FileRequestDate) AS ReqestDate, ";
        $sql .= "CF_DirectoryPath AS DirectoryPath ";
       //print_r($this->sql_where());exit;
        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_orderby();//echo $sql;exit;
        
        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    /*
     * get_file_location - description
     * @return array
     * @author Namal
     */
    public static function get_file_location()
    {
        $sql  = "SELECT EM1_LastNameFirst FROM t_Employee1 UNION SELECT FSL_LocationName_pk FROM t_FileStorageLocations ORDER BY EM1_LastNameFirst ASC";
        $stmt = \NMI::DB()->prepare($sql);
        $stmt->execute();
        $rows =  $stmt->fetchAll();
        
        return \Arr::assoc_to_keyval($rows, 'EM1_LastNameFirst', 'EM1_LastNameFirst');
    }
    
    /**
     * Create CB Directory
     * @param  [type] $year   [description]
     * @param  [type] $folder [description]
     * @return [type]         [description]
     */
    public static function create_cb_directory($CF_FileNumber_pk)
    {
        $base_path = \Config::get('cb_files_path');
        $folder = static::get_cb_file_path($CF_FileNumber_pk);

        if (!$folder) {
            throw new \FuelException('Invalid folder.');
        }

        $path = $base_path.DS.$folder;

        if (is_dir($path)) {
            throw new \FuelException('Folder already exists.  Cannot create folder.');
            return false;
        }

        return mkdir($path, 0777, true);
    }
    
    /*
     * Get the path name of a CB file
     * !Not using the path in database table, because old access app paths will break the web app
     * @param $CF_FileNumber_pk
     * @return path
     * @author Namal
     */
    public static function get_cb_file_path($CF_FileNumber_pk)
    {
        $row  =  static::get_cb_file_content($CF_FileNumber_pk);
        
        if (empty($row)) return false;
        return $row['CF_Year'].DS.str_replace('/', '_', $CF_FileNumber_pk);
     }
    
}