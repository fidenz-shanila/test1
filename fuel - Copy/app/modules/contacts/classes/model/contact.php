<?php

/**
 * Model for contact module db stuff
 * @author  Sahan H. <[email]>
 */

namespace Contacts;

class Model_Contact extends \Model_Base 
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
    public $search_criteria = null;

    /**
     * Array of filters for searching
     * @var array
     */
    public $filter = array();
    public $orderby = array();

    public function listing() 
    {
        //print_r($this->filter);exit;
        $limit  = \NMI_Db::escape((int) $this->limit);
        $offset = \NMI_Db::escape((int) $this->offset);
        $filter = \NMI_Db::escape((int) $this->filter);


        $paging = null;

        if ($offset) 
        {
            $start = $offset;
            $limit = $limit + $offset;

            $paging = " where RowNumber > {$start} and RowNumber < {$limit} ";
        }

        //calling query builders
        $select = $this->sql_select();
        $from   = $this->sql_from();
        $where  = $this->sql_where();
        $order_by = $this->sql_order_by();
/**/
        $full_sql = "WITH NumberedRows AS 
                    (
                            {$select},
                                    Row_Number() OVER ({$order_by}) AS RowNumber 
                            {$from}
                            {$where}

                    ) 
                    SELECT * FROM NumberedRows";

		    

        //$page_sql = $full_sql . ' ' . $paging; 
        
        $page_sql = $select.' '.$from.' '.$where.' '.$paging.' '.$order_by; 
        //$count_sql='SELECT COUNT(*) AS count '.$from.''.$where.' '.$paging.' '.$order_by;
        //$count_sql='SELECT  COUNT(*) AS [count] '.$from.' '.$where;
        //\log::error($full_sql);
         //$page_sql;
        $count_sql   = str_replace(array('SELECT * FROM NumberedRows', "TOP {$this->limit}"), array('SELECT COUNT ( DISTINCT CO_ContactID_pk) AS [count] FROM NumberedRows', ''), $full_sql);
        //$count_sql = $select.' COUNT '.$from.' '.$where.' '.$paging.' '.$order_by;
        $rows  = \NMI::Db()->query($page_sql)->fetchAll();
        $count = \NMI::Db()->query($count_sql)->fetch();

        return array('count' => (int) $count['count'], 'result' => (array) $rows);
    }

    public function sql_from() 
    {
        $sql = "FROM t_Contact INNER JOIN t_Organisation1 ON CO_OrgID_fk = OR1_orgID_pk ";
        $sql    .= "INNER JOIN t_Organisation2 ON OR1_orgID_pk = OR2_OrgID_pk_ind ";
        $sql    .= "LEFT OUTER JOIN t_Artefact ON OR1_orgID_pk = A_OR1_OrgID_fk ";
        $sql    .= "LEFT OUTER JOIN t_WorkDoneBy ON A_YearSeq_pk = WDB_YearSeq_fk_ind ";
        return $sql;
    }

    public function sql_select() 
    {
        if ($this->offset) 
        {
            $this->limit = $this->limit + $this->offset;
        }

        $limit = (int) $this->limit;

        $sLimit = null;

        if ($limit)
            $sLimit = " TOP {$limit} ";

        return "SELECT DISTINCT {$sLimit}
						CO_ContactID_pk,
						CO_Lname_ind,
						CO_Phone,
						CO_Mobile,
						CO_Email,
						CO_Fullname,
						OR1_OrgID_pk,
						OR1_Name_ind,
						OR1_FullName";
    }

    public function sql_where() 
    {
        $filter = $this->filter;

        //-----------------------------------------------------------
        // Filtering
        //-----------------------------------------------------------

        /* -- Org Types -- */
        $sot = '';
        if (isset($filter['org_type']))
            switch ($filter['org_type']) 
            {
                case 'EXTERNAL':
                    $sot = "AND OR1_InternalOrExternal = 'EXTERNAL' ";
                    break;

                case 'NMI':
                    $sot = "AND OR1_InternalOrExternal = 'NMI' ";
                    break;

                case 'APPROVED':
                    $sot = "AND CO_ApprovedByEmployeeID IS NOT NULL ";
                    break;

                case 'UNAPPROVED':
                    $sot = "AND CO_ApprovedByEmployeeID IS NULL ";
                    break;

                case 'No credit (O/S)':
                    $sot = "AND OR1_FinancialStatus =  'No credit (O/S)' ";
                    break;

                case 'No credit (AUS)':
                    $sot = "AND OR1_FinancialStatus =  'No credit (AUS)' ";
                    break;

                case 'Credit OK':
                    $sot = "AND OR1_FinancialStatus =  'Credit OK' ";
                    break;
            }

        //status
        $swo = '';
        
        if (isset($filter['status'])) \log::error($filter['status']);
            switch ($filter['status']) 
            {
                case '1':
                    $swo = "AND CO_CurrencyStatus = 'CURRENT' AND OR1_CurrencyStatus = 'CURRENT' ";
                    break;

                case '2':
                    $swo = "AND CO_CurrencyStatus = 'OBSOLETE' AND OR1_CurrencyStatus = 'CURRENT' ";
                    break;

                case '3':
                    $swo = "AND OR1_CurrencyStatus = 'OBSOLETE' ";
                    break;
                case '4':
                    $swo = " ";
                    break;
            }
        
        
    
        $swhere = '';
        if(isset($filter['type']) and !empty($filter['type']))
        {
           $filter['type']    = \NMI_Db::escape($filter['type']);
           if($filter['type']=='\'90&deg; square block\''){
               $filter['type']='\'90° square block\'';
                //str_replace("&deg;","°",$filter['type']);
           }
             $swhere .= "AND A_Type = {$filter['type']} ";
        }

        if(isset($filter['branch']) and !empty($filter['branch']))
        {
            $filter['branch']  = \NMI_Db::escape($filter['branch']);
            $swhere .= "AND WDB_B_Name = {$filter['branch']} ";
        }
            

        if(isset($filter['section']) and !empty($filter['section']))
        {
            $filter['section'] = \NMI_Db::escape($filter['section']);
            $swhere .= "AND WDB_S_Name = {$filter['section']} ";
        }

        if(isset($filter['project']) and !empty($filter['project']))
        {
            $filter['project'] = \NMI_Db::escape($filter['project']);
            $swhere .= "AND WDB_P_Name = {$filter['project']} ";
        }
            

        if(isset($filter['area']) and !empty($filter['area']))
        {
            $filter['area']    = \NMI_Db::escape($filter['area']);
            $swhere .= "AND WDB_A_Name = {$filter['area']} ";
        }
            

        if(isset($filter['contact_cat']) and !empty($filter['contact_cat']))
            $swhere .= "AND CO_Categories LIKE '%" . (int) $filter['contact_cat'] . "%' "; //int no need to escape
            
        if(isset($filter['org_cat']) and !empty($filter['org_cat']))
            $swhere .= "AND OR1_Categories LIKE '%" . (int) $filter['org_cat'] . "%' "; //int  no neeed to escape

        if(isset($filter['by_letter']) and !empty($filter['by_letter'])) 
        {
            $filter['by_letter'] = \NMI_Db::escape("{$filter['by_letter']}%");

            //if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            //$swhere .= "AND CO_Lname_ind LIKE {$filter['by_letter']}";
            
            if (isset($this->order_by['column']) and $this->order_by['column'] == 'LastName') 
            {
                $swhere .= "AND CO_Lname_ind LIKE {$filter['by_letter']}";
            } else 
            {
                $swhere .= "AND OR1_Name_ind LIKE {$filter['by_letter']}";
            }
        }

        if(!empty($this->search_criteria['advance'])){
        $filter = \Helper_App::build_search_string('AND',$this->search_criteria['advance']['add_criteria'], 'N/A', $this->search_criteria_1(), $this->search_criteria_2());
        }else{
            $filter = '';
        }
        return "WHERE CO_ContactID_pk > 0 {$sot} {$swo} {$swhere} {$filter}";
    }

    public function sql_order_by() 
    {
        if (empty($this->order_by) || empty($this->order_by['column']) || empty($this->order_by['sort']))
            return "ORDER BY OR1_Name_ind ASC ";

        $sorderby = null;
        $orderby  = $this->order_by;
        $orderby['sort'] = $orderby['sort'] == 'desc' ? 'DESC' : 'ASC';

        switch ($orderby['column'])
        {
            case "LastName":
                $sorderby = "ORDER BY CO_Lname_ind " . $orderby['sort'];
                break;

            case "Organisation":
                $sorderby = "ORDER BY OR1_Name_ind " . $orderby['sort'];
                break;
        }
	
        return $sorderby;
    }

    //-----------------------------------------------------------
    // Dropdown values
    //-----------------------------------------------------------
    public function get_types() 
    {
        $from = $this->sql_from();
        $where = $this->sql_where();

        $sql  = "SELECT DISTINCT A_Type {$from} {$where}";
        $sql .= "AND A_Type IS NOT NULL ";
        $sql .= "ORDER BY A_Type ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        $data = \Arr::assoc_to_keyval($rows, 'A_Type', 'A_Type');
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

    function search_criteria_1() 
    {
        $filter = $this->search_criteria;

        if (empty($this->search_criteria) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria']))
            return null;

        $sql = null;

        switch ($filter['field']) {
            case "Last name":
                $sql .= "CO_Lname_ind ";
                break;

            case "First name":
                $sql .= "CO_FName ";
                break;

            case "Phone":
                $sql .= "CO_Phone ";
                break;

            case "Position":
                $sql .= "CO_Pos ";
                break;

            case "Country":
                $sql .= "OR2_Country ";
                break;

            case "Org. name":
                $sql .= "OR1_Name_ind ";
                break;

            case "Org. web address":
                $sql .= "OR2_Web ";
                break;
        }


        switch ($filter['equality']) 
        {
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

    function search_criteria_2()
    {
        $filter = $this->search_criteria['advance'];

        if($filter['add_criteria'] == 'N/A')
            return null;

        if (empty($filter) || empty($filter['field']) || empty($filter['equality']) || empty($filter['criteria']))
            return null;


        $sql = '';

        if($filter['field'] == 'Last name')
            $sql .= 'CO_Lname_ind ';

        if($filter['field'] == 'First name')
            $sql .= 'CO_FName ';

        if($filter['field'] == 'Phone')
            $sql .= 'CO_Phone ';

        if($filter['field'] == 'Position')
            $sql .= 'CO_Pos ';

        if($filter['field'] == 'Country')
            $sql .= 'OR2_Country ';

        if($filter['field'] == 'Org. name')
            $sql .= 'OR1_Name_ind ';

        if($filter['field'] == 'Org. web address')
            $sql .= 'OR2_Web ';

        switch ($filter['equality']) 
        {
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

    /**
     * Get contact categories
     * @return [type] [description]
     */
    public static function get_categories() 
    {
        $sql   = "SELECT  COC_code_ind,  COC_NameAndCode FROM t_ContactCategory";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'COC_code_ind', 'COC_NameAndCode');
    }

    /**
     * Get organization categories
     * @return [type] [description]
     */
    public static function get_org_categories() 
    {
        $sql   = "SELECT ORGC_Code_ind, ORGC_NameAndCode FROM t_OrganisationCategory ORDER BY ORGC_Code_ind ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'ORGC_Code_ind', 'ORGC_NameAndCode');
    }

    /**
     * Get a contact
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function get_contact($id)
    {
        $id = (int) $id;
        $db = \NMI::Db();
        
        //$stmt = $db->query("SELECT * FROM t_Contact WHERE CO_ContactID_pk = {$id}");
		//$stmt->bindValue(':id', $id);
		$contact = $db->query("SELECT * FROM t_Contact WHERE CO_ContactID_pk = '{$id}'")->fetch(\PDO::FETCH_OBJ);
		//$stmt->execute();
		//$contact = $stmt->fetch(\PDO::FETCH_OBJ);
		
		$organization1 = $db->query("SELECT * FROM t_Organisation1 WHERE  OR1_OrgID_pk = '{$contact->CO_OrgID_fk}'")->fetch(\PDO::FETCH_OBJ);    
                $organization2 = $db->query("SELECT * FROM t_Organisation2 WHERE OR2_OrgID_pk_ind = '{$contact->CO_OrgID_fk}'")->fetch(\PDO::FETCH_OBJ);
        
//		$stmt1 = $db->query("SELECT * FROM t_Organisation1 WHERE  OR1_OrgID_pk = ?");
//		$stmt1->bindValue(1, $contact->CO_OrgID_fk );
//		$stmt1->execute();
//		$organization1 = $stmt1->fetch(\PDO::FETCH_OBJ);
//		
//        
//		$stmt2 = $db->query("SELECT * FROM t_Organisation2 WHERE OR2_OrgID_pk_ind = ?");
//		$stmt2->bindValue(1, $contact->CO_OrgID_fk );
//		$stmt2->execute();
//		$organization2 = $stmt2->fetch(\PDO::FETCH_OBJ);
//
                //print_r($contact);exit;
        $contact->organization1 = $organization1;
        $contact->organization2 = $organization2;
        //print_r( $organization2);exit;
        return $contact;
    }
	
	/**
	* check weahter a contact available
	* @return , has => 1, no => 0
	* @author Namal
	*/
	public static function is_contact($id)
        {
		$contact = \NMI::Db()->query("SELECT COUNT(*) AS count FROM t_Contact WHERE CO_ContactID_pk='{$id}'")->fetch();
		return $contact['count'] > 0 ? 1 : 0; 
	}
	
    
   
    public static function get_organisation_names()
    {	
        $sql   = "SELECT DISTINCT OR1_Name_ind FROM t_Organisation1 ORDER BY OR1_Name_ind ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'OR1_Name_ind', 'OR1_Name_ind');
	}

    
    public static function get_title()
    {
    	$sql   = "SELECT DISTINCT CO_Title FROM t_Contact ORDER BY CO_Title";
    	$rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'CO_Title', 'CO_Title');
    }
    
    public static function get_new_contact_title()
    {
    	$sql   = "SELECT DISTINCT CO_Title FROM t_Contact WHERE CO_Title NOT LIKE '%?%' ORDER BY CO_Title ASC";
    	$rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'CO_Title', 'CO_Title');
    }
    
    
    //-----------------------------------------------------------
    // Edit section
    //-----------------------------------------------------------
    
    public static function get_locations()
    {
    	$locations = \NMI::Db()->query("SELECT DISTINCT OR1_Location FROM t_Organisation1 WHERE OR1_Location IS NOT NULL ORDER BY OR1_Location ASC")->fetchAll();
    	return \Arr::assoc_to_keyval($locations, 'OR1_Location', 'OR1_Location');
    }
    
    public static function get_country()
    {
    	$country = \NMI::Db()->query("SELECT DISTINCT OR2_Country FROM t_Organisation2 WHERE OR2_Country IS NOT NULL ORDER BY OR2_Country")->fetchAll();
    	return \Arr::assoc_to_keyval($country, 'OR2_Country', 'OR2_Country');
    }
    
    public static function get_approve_list()
    {
        $sql = "SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Email, EM1_LastNameFirst FROM t_Employee1 ORDER BY EM1_Lname_ind ASC";
        $rows  = \NMI::Db()->query($sql)->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_FullNameNoTitle', 'EM1_FullNameNoTitle');
    }
    

    public static function get_contact_cat_list()
    {
        $rows  = \NMI::Db()->query("SELECT  COC_code_ind,  COC_NameAndCode FROM t_ContactCategory")->fetchAll();
	    return \Arr::assoc_to_keyval($rows, 'COC_code_ind', 'COC_NameAndCode');
    }
    
    public static function get_org_cat_list()
    {
        $rows  = \NMI::Db()->query("SELECT ORGC_Code_ind, ORGC_NameAndCode FROM t_OrganisationCategory ORDER BY ORGC_Code_ind ASC")->fetchAll();
	    return \Arr::assoc_to_keyval($rows, 'ORGC_Code_ind', 'ORGC_NameAndCode');
    }
     public static function get_title_list()
    {
    	$titles = \NMI::Db()->query("SELECT DISTINCT CO_Title FROM t_Contact WHERE CO_Title NOT LIKE '%?%' ORDER BY CO_Title ASC")->fetchAll();
    	return \Arr::assoc_to_keyval($titles, 'CO_Title', 'CO_Title');
    }

    /**
     * Get contacts under a specific organzation
     * For usage in a dropdown
     * !SINCE DEMO DB HAS LOTS OF DUPLICATES ASSOC ARRAY WILL BE SMALL
     * @param  int $org_id [description]
     * @return array         [description]
     * @author Sahan <[email]>
     */
    public static function get_org_contacts($org_id)
    {
        if(!static::is_org_internal($org_id))
        {
            $sql  = "SELECT CO_Fullname AS full_name, CO_Lname_ind FROM t_Contact INNER JOIN t_Organisation1 ";
            $sql .= "ON CO_OrgID_fk = OR1_OrgID_pk ";
            $sql .= "WHERE OR1_OrgID_pk = ? ";
            $sql .= "ORDER BY CO_Lname_ind ASC ";
            $stmt = \NMI::Db()->prepare($sql);
            $stmt->bindValue(1, $org_id);
        }
        else
        {
            $sql = "SELECT EM1_Fullname AS full_name, EM1_Lname_ind FROM t_Employee1 ORDER BY EM1_Lname_ind ASC";
            $stmt = \NMI::Db()->prepare($sql);
        }    

        $stmt->execute();
        $contacts = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($contacts, 'full_name', 'full_name');
    }

    /**
     * Check if organization is internal or external
     * @param  [type]  $org_id [description]
     * @return boolean         [description]
     */
    public static function is_org_internal($org_id)
    {

        $stmt = \NMI::Db()->prepare("EXEC sp_IsOrgInternalOrExternal @OR1_OrgID_pk=?, @OrgType=?");
        $stmt->bindParam(1, $org_id);
        $stmt->bindParam(2, $org_type, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 10);
        $stmt->execute();

        if($org_type == 'EXTERNAL')
            return false;
        else
            return true;
    }
    
     /**
     * Result set used to generate the Excel
     * @return [type] [description]
     */
    public function excel_results()
    {
        $sql = "SELECT DISTINCT ";

        if($this->limit != 'ALL' and $this->limit > 0)
        {
            $limit  = \NMI_Db::escape((int) $this->limit);
            $sql .= "TOP {$limit} ";
        }
        
        $sql .= "CO_Fullname AS ContactFullName, CO_Fname AS ContactFirstName, CO_Lname_ind AS ContactLastName, CO_Pos AS ContactPosition, ";
        $sql .= "CO_Phone AS ContactPhone, CO_Fax AS ContactFax, CO_Email AS ContactEmail, CO_CurrencyStatus AS ContactCurrency, OR1_FullName AS OrganisationFullName,";
        $sql .= "OR1_Name_ind AS OrganisationName, OR1_Section AS OrganisationSection, OR1_Location AS OrganisationLocation, OR1_CurrencyStatus AS OrganisationCurrency, OR1_InternalOrExternal AS OrganisationType, ";
        $sql .= "OR2_Phone AS OrganisationMainPhone, OR2_Fax AS OrganisationMainFax, OR2_Email AS OrganisationEmail, OR2_Web AS OrganisationWeb, ";
        $sql .= "OR2_Postal1 AS OrganisationPostalAddress1, OR2_Postal2 AS OrganisationPostalAddress2, OR2_Postal3 AS OrganisationPostalAddress3, ";
        $sql .= "OR2_Postal4 AS OrganisationPostalAddress4, OR2_Physical1 AS OrganisationPhysicalAddress1, OR2_Physical2 AS OrganisationPhysicalAddress2, ";
        $sql .= "OR2_Physical3 AS OrganisationPhysicalAddress3, OR2_Physical4 AS OrganisationPhysicalAddress4, OR2_Country AS OrganisationCountry, ";
        $sql .= "OR2_InvoiceContactFullname AS OrganisationInvoiceContact, OR2_Invoice1 AS OrganisationInvoiceAddress1, ";
        $sql .= "OR2_Invoice2 As OrganisationInvoiceAddress2, OR2_Invoice3 As OrganisationInvoiceAddress3, OR2_Invoice4 As OrganisationInvoiceAddress4 ";

        $sql .= $this->sql_from().' '.$this->sql_where().' '.$this->sql_order_by();

        return \NMI::DB()->query($sql)->fetchAll();
        
    }
    
    
    /*
     * Delete contact
     * @param int contact_id
     */
    public static function delete_contact($contact_id)
    {
	
	
	$sql = "
        SET NOCOUNT ON
        DECLARE @return_value int,
        @ReturnString varchar(300)

        EXEC    @return_value = [dbo].[sp_delete_from_t_Contact]
                @CO_ContactID_pk = :CO_ContactID_pk,
                @ReturnString = :ReturnString

        SELECT  'return' = @return_value";
	   //print_r($sql);exit; 
	    $stmt = \NMI::Db()->prepare($sql);
	    $stmt->bindValue('CO_ContactID_pk', $contact_id);
	    $stmt->bindParam('ReturnString', $return, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 10);
	    $stmt->execute();
	    
	    $data = $stmt->fetch();
//print_r($data);exit;
	    return  $data['return'];   

    }
    
    /**
     * Helpers
     */
    

    /**
     * Format set of categories from the database, convert the string based categories to array and an array to string
     * @param  [type] $cats [description]
     * @return [type]       [description]
     */
    public static function format_categories($cats)
    {
        if(is_array($cats))
        {
            return implode(';', $cats);
        }
        else
        {
            return explode(';', $cats);
        }
    }
    
    public static function get_ori_info($OR1_OrgID_pk)
    {
        $sql = \NMI::DB()->query(" SELECT * FROM t_Organisation1,t_Organisation2 WHERE t_Organisation1.OR1_OrgID_pk='" . $OR1_OrgID_pk . "' AND t_Organisation2.OR2_OrgID_pk_ind='" . $OR1_OrgID_pk . "'" )->fetchAll();
        return $sql;
    }
    


}

/* eof */