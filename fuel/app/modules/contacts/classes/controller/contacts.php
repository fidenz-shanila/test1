<?php

namespace Contacts;

class Controller_Contacts extends \Controller_Base {

    /**
     * Contacts Home - Listing Grid
     * @return [type] [description]
     */
    function action_index() 
    {
        if (\Input::post('export_to_excel')) {

            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI_Db::send_excel($listing->excel_results());
        
        }
        
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/contacts');
        $view->body_classes = 'clr_administration';
        $view->sidebar = \View::forge('sidebar/listing');
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar->contact_cats = Model_Contact::get_categories();
        $view->sidebar->org_cats = Model_Contact::get_org_categories();

        $this->template->body_classes = array('clr_administration');
        $this->set_iframe_template();
       if(\Input::get('mode')){
	 $this->set_iframe_template('grids/contacts');
         $this->template->content = $view;
        }else{
	 $this->template->content = $view;
	}
       // echo "<script> alert('22');</script>";
    }
    function action_catForme() {
        $this->set_iframe_template('');
        $view = \View::forge('cat');
        $view->contact_cats = Model_Contact::get_categories();
        $view->org_cats = Model_Contact::get_org_categories();
        $this->template->content = $view;
    }
    
      function action_search_contacts() {
        $this->set_iframe_template('search_contacts');
        $view = \View::forge('search_contacts');
        $this->template->content = $view;
    }

    /**
     * JSON generator to send data to the grid
     * @return [type] [description]
     */
    function action_listing_data() 
    {

        $listing = $this->generate_listing();
        $result = $listing->listing();
        $data = array();
        foreach ($result['result'] as $c) 
        {
                $data[] = array(
                    (\Input::get('mode'))?'<div id="divForButton"  style="background-color:#8da7eb;width:100%;padding:0px;"><input type="button" class="select_item2 spaced3" data-org_id="' . $c['OR1_OrgID_pk'] . '" data-contact_id="' . $c['CO_ContactID_pk'] . '" data-org_name="' . $c['CO_Fullname'] .'" data-contact_name="' . $c['OR1_FullName'] . '" value="<" /><input type="button"  class="select_item spaced3" onclick=cleanSetIntervalFunction() id="' . $c['CO_ContactID_pk'] . '" data-id="' . $c['CO_ContactID_pk'] . '" value=".." /></div>':'<div  style="background-color:#8da7eb;width:100%;padding:2px"><input type="button"  class="select_item spaced5" onclick=cleanSetIntervalFunction() id="' . $c['CO_ContactID_pk'] . '" data-id="' . $c['CO_ContactID_pk'] . '" value=".." /></div>',
                   '<input type="text" name="LastName" value="'.$c['CO_Fullname'].'" style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;width:94%;font-size: 11px;" readonly>',
                     '<input type="text" name="LastName" value="'.$c['OR1_FullName'].'" style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;width:98%;font-size: 11px;" readonly>',
                    '<div  style="margin:5px;background-color:#d5d6d0;padding:2px;height:10px;padding-left:5px;border: 1px solid #aaadaa;width:100%;overflow:hidden;">'.$c['CO_Phone'].'</div>',
                    '<div  style="margin:5px;background-color:#d5d6d0;padding:2px;height:10px;padding-left:5px;border: 1px solid #aaadaa;width:100%;overflow:hidden;">'.$c['CO_Mobile'].'</div>'
                );
            
        }
//<div  style="background-color:#8da7eb;width:100%;height:30px;padding:2px"><input type="button" class="select_item " data-org_id="' . $c['OR1_OrgID_pk'] . '" data-contact_id="' . $c['CO_ContactID_pk'] . '" data-org_name="' . $c['CO_Fullname'] .'" data-contact_name="' . $c['OR1_FullName'] . '" value="<<" /></div>
        $json = array(
            'sEcho' => (int) \Input::get('sEcho'),
            'iTotalRecords' => $result['count'],
            'iTotalDisplayRecords' => $result['count'],
            'aaData' => $data,
        );

        echo json_encode($json);
        exit;
    }

    /**
     * JSON Dropdown Data
     * @return [type] [description]
     */
    function action_dropdown_data() 
    {
        $extra_search_fields = array();

        foreach (\Input::get() as $key => $input) 
        {
            if (empty($input))
                continue;

            if (strpos($key, 'extra_search_') !== false and !empty($input)) 
            {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }
        }

        $global_search = \Input::get('sSearch');
        $no_of_records = (int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::get('iColumns');
        $offset = \Input::get('iDisplayStart', 0);

        $listing = new Model_Contact;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['a_type'] = $listing->get_types();
        $data['wdb_branch'] = $listing->get_branches();
        $data['wdb_section'] = $listing->get_sections();
    
        $data['wdb_project'] = $listing->get_projects();
        $data['wdb_area'] = $listing->get_areas();

        echo json_encode($data);
        exit;
    }

    /**
     * Edit Contact
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function action_edit($id = null) 
    {
        $successful='';
        $contact = Model_Contact::get_contact($id);

        #generate word
        if (\Input::post('mailmerge_submit')) {

            if (!\Input::post('mailmerge')) {
                \Message::set('warning', 'Choose a mailmerge option.');
            }
            
            try {
            
                \NMI_Doc::contact_mailmerge($contact->CO_ContactID_pk, \Input::post('mailmerge'));
            
            } catch(\NMIDocException $e) {

                \Message::set('error', $e->getMessage());
                \Response::redirect("contacts/edit/{$id}");
            }
        }

        #update
        if (\Input::All('save')) {
			 
			$fields = \Input::All();
			$org_1  = $fields['organization1'];
			$org_2  = $fields['organization2'];
	    
			try {
	    	
				$this->db->beginTransaction();
                 if(\Input::post('CO_LockForm')==1){
                $CO_LockForm=true;
                }else{
                  $CO_LockForm=false;
                }
                if(\Input::post('CO_Email')==''){
                    
                $CO_Email='NULL';
               // print_r($CO_Email);exit;
                }else{
                  $CO_Email=\Input::post('CO_Email');
                }
                
       
//                if($org_2['OR2_Email']==''){
//                    
//                    $org_2['OR2_Email']=NULL;
//               // print_r($CO_Email);exit;
//                }       
 // print_r($CO_Email);exit;
                $contact_update = array(

                    'CO_Title' => \Input::post('CO_Title',\Input::post('CO_Title')), //passing false due to form lock section
                    'CO_Fname' => \Input::post('CO_Fname', \Input::post('CO_Fname')),
                    'CO_LockForm' => $CO_LockForm,
                    'CO_Lname_ind' => \Input::post('CO_Lname_ind', \Input::post('CO_Lname_ind')),
                    'CO_Pos' => \Input::post('CO_Pos'),
                    'CO_Phone' => \Input::post('CO_Phone'),
                    'CO_Mobile' => \Input::post('CO_Mobile'),
                    'CO_Fax' => \Input::post('CO_Fax'),
                    'CO_Email' => $CO_Email,
                    'CO_CurrencyStatus' => \Input::post('CO_CurrencyStatus'),
                    'CO_ApprovedByEmployeeID' => \Input::post('CO_ApprovedByEmployeeID'),
                    'CO_Categories' =>  \Input::post('CO_Categories'),

                );
               //print_r($org_2);exit;
                if(\Input::post('OR1_LockForm')==1){
                $OR1_LockForm=true;
                }else{
                  $OR1_LockForm=false;
                }
                  if($org_2['OR2_Email']==''){
                    
                    $OR2_MainEmail='NULL';
               // print_r($CO_Email);exit;
                }else{
                    $OR2_MainEmail=$org_2['OR2_Email'];
                }    
                //print_r(\Input::post('OR1_LockForm'));exit;
//print_r($org_2['OR2_Email']);exit;
                $Org2_update = array(

                    'OR2_Phone' => $org_2['OR2_Phone'], //passing false due to form lock section
                    'OR2_ABN' => $org_2['OR2_ABN'],
                    'OR2_Country' => $org_2['OR2_Country'],
                    'OR2_Fax' => $org_2['OR2_Fax'],
                    'OR2_Web' => $org_2['OR2_Web'],
                    'OR2_PhoneOther' => $org_2['OR2_PhoneOther'],
                    'OR2_Email' => $OR2_MainEmail,
                    'OR2_Postal1' => $org_2['OR2_Postal1'],
                    'OR2_Postal2' => $org_2['OR2_Postal2'],
                    'OR2_Postal3' => $org_2['OR2_Postal3'],
                    'OR2_Postal4' => $org_2['OR2_Postal4'],
                    'OR2_Physical1' => $org_2['OR2_Physical1'],
                    'OR2_Physical2' => $org_2['OR2_Physical2'],
                    'OR2_Physical3' => $org_2['OR2_Physical3'],
                    'OR2_Physical4' => $org_2['OR2_Physical4'],
                    'OR2_Invoice1' => $org_2['OR2_Invoice1'],
                    'OR2_Invoice2' => $org_2['OR2_Invoice2'],
                    'OR2_Invoice3' => $org_2['OR2_Invoice3'],
                    'OR2_Invoice4' => $org_2['OR2_Invoice4'],
                    'OR2_Comments' => $org_2['OR2_Comments'],
                    

                );
               //print_r(($org_2));exit;
                
                \Nmi_Db::update('t_Contact', $contact_update, array('CO_ContactID_pk' => $contact->CO_ContactID_pk));
                 \Nmi_Db::update('t_Organisation2', $Org2_update, array('OR2_OrgID_pk_ind' => $contact->CO_OrgID_fk));

				//$stmt1 = $this->db->prepare("UPDATE t_Contact SET CO_Title=?, CO_Fname=?, CO_Lname_ind=?, CO_Pos=?, CO_Phone=?,CO_Mobile=?,CO_Fax=?,CO_Email=?,CO_CurrencyStatus=?,CO_ApprovedByEmployeeID=?, CO_Categories=? WHERE CO_ContactID_pk=?");
				$stmt2 = $this->db->prepare("UPDATE t_Organisation1 set OR1_Name_ind=?, OR1_Section=?, OR1_Location=?, OR1_ContractID=?, OR1_LockForm=?, OR1_ContractExpiryDate=?, OR1_Categories=? WHERE OR1_OrgID_pk=?");
				$stmt3 = $this->db->prepare("UPDATE t_Organisation2 set OR2_Phone=?, OR2_ABN=?, OR2_Fax=?, OR2_Web=?, OR2_PhoneOther=?, OR2_Email=?, OR2_Postal1=?,OR2_Physical1=?,OR2_Invoice1=?,OR2_Comments=? WHERE OR2_OrgID_pk_ind=?");		       
	    
				$stmt2->bindValue(1, $org_1['OR1_Name_ind']);
				$stmt2->bindValue(2, $org_1['OR1_Section']);
				$stmt2->bindValue(3, $org_1['OR1_Location']);
				$stmt2->bindValue(4, $org_1['OR1_ContractID']);
                                $stmt2->bindValue(5, $OR1_LockForm);
                                $stmt2->bindValue(6, \NMI_Db::format_date($org_1['OR1_ContractExpiryDate']));
				$stmt2->bindValue(7, Model_Contact::format_categories((array) $org_1['OR1_Categories']));
				$stmt2->bindValue(8, $contact->CO_OrgID_fk);
				$stmt2->execute();
		
				$stmt3->bindValue(1, $org_2['OR2_Phone']);
				$stmt3->bindValue(2, $org_2['OR2_ABN']);
				$stmt3->bindValue(3, $org_2['OR2_Fax']);
				$stmt3->bindValue(4, $org_2['OR2_Web']);
				$stmt3->bindValue(5, $org_2['OR2_PhoneOther']);
                                //print_r($org_2['OR2_Email']);exit;
                                $stmt3->bindValue(6, $org_2['OR2_Email']);
				$stmt3->bindValue(7, $org_2['OR2_Postal1']);
				$stmt3->bindValue(8, $org_2['OR2_Physical1']);
				$stmt3->bindValue(9, $org_2['OR2_Invoice1']);
				$stmt3->bindValue(10, $org_2['OR2_Comments']);
				$stmt3->bindValue(11, $contact->CO_OrgID_fk);
				//$stmt3->execute();
				//print_r($stmt3->execute());exit;
                               // $successful='success';
				$this->db->commit();
                               print_r('<input type="text" id="cherDelectValue" value="saved"><script>parent.$(\'body\').css(\'overflow\',\'auto\'); window.parent.closeIframe();</script>');
    
                               
                                
                //\Message::set('success', 'Contact updated.');
                
                //\Response::redirect('contacts');
		
			} catch(\PDOException $e) {
echo '<pre>',print_r($e),'</pre>';exit;
				$this->db->rollBack();
			    //\Message::set('error', 'Database error occured. Please contact administrator.');
                \Response::redirect('contacts');
			
            }
			
			//\Response::redirect("contacts/edit/{$contact->CO_ContactID_pk}");
		}

        $data['location'] = Model_Contact::get_locations();
        $data['country'] = Model_Contact::get_country();
        $data['approve'] = Model_Contact::get_approve_list();
        $data['title'] = Model_Contact::get_title_list();

        $view = \View::forge('edit');
        $this->set_iframe_template();
        $form   =   \Input::get('form');
        if($form!=''){$this->set_iframe_template('edit');}
        $view->dropdown = $data;
        $view->set('contact', $contact, false);
         $view->set('successful', $successful, false);
        $this->template->content = $view;
        
    }


    /**
     * New Organization
     * @return [type] [description]
     */
    function action_new_org()
    {
        $this->set_iframe_template('create_new_org');
    	$view = \View::forge('create_new_org');
    	$names 	= Model_Contact::get_organisation_names();
    	$titles = Model_Contact::get_title();
    	
    	$fs = \Fieldset::forge('new_org');
    	
    	$fs->add('names', 'Name :', array('type' => 'select', 'class' => 'select-1 editable', 'options' => array_merge(array(' '),$names) ), array(array('required')));
    	$fs->add('titles', 'Title :', array('type' => 'select', 'class' => 'select-1 editable', 'options' => $titles ), array(array('required')));
    	$fs->add('sections', 'sections :', array('type' => 'text', 'class' => 'select-1 editable' ));
    	$fs->add('fname', 'First Name :', array('type' => 'text', 'class' => 'text-1'));
    	$fs->add('lname', 'Last Name :', array('type' => 'text', 'class' => 'select-1' ));
    	$fs->add('createdby', 'Created By :', array('type' => 'text', 'class' => 'select-1', 'readonly' => 'readonly', 'value' => \NMI::current_user('full_name'),'style'=>'text-align:center' ));
    	$fs->add('submit', 'Submit :', array('type' => 'submit', 'value' => 'insert', 'class' => 'button2','id'=>'IdSubmit','style'=>'font-weight: bold;height:40px'));
    	
    	if($fs->validation()->run())
    	{
            $fields = $fs->validated();

            try
            {
                $contact_id = NULL;

                $stmt = $this->db->prepare("EXEC sp_insert_into_t_Organisation1 @OR1_Name_ind=?, @OR1_Section=?, @OR1_CreatedBy=?, @CO_Title=?, @CO_FName=?, @CO_LName_ind=?, @OR1_OrgID_pk=?, @CO_ContactID_pk=?");
                $stmt->bindValue(1, $fields['names']);
                $stmt->bindValue(2, $fields['sections']);
                $stmt->bindValue(3, $fields['createdby']);
                $stmt->bindValue(4, $fields['titles']);
                $stmt->bindValue(5, $fields['fname']);
                $stmt->bindValue(6, $fields['lname']);
                $stmt->bindParam(7, $org_id, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);
                $stmt->bindParam(8, $contact_id, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);
                $stmt->execute();
        
                $contact_id = $this->db->lastInsertId(); //TODO, get ID from stored procedure returns
                echo "<script type='text/javascript'>parent.newOrgParent('$contact_id'); parent.$('#NewOrg').dialog('close');</script>";exit;
                \Response::redirect("contacts/edit/{$contact_id}");

            }
            catch(\PDOException $e)
            {
                \Message::set('error', 'Database error occured.');
            }
        }
	
    	
    	$view->set('form', $fs->form(), false);
    	$this->template->content = $view;

    }
    

    function action_copy_address($quote_id)
    {
        $get_div_id = \Input::get('div_id');
        $get_sub_div_id = \Input::get('sub_div_id');
        $this->set_iframe_template();
        //$view = \View::forge('copy_address');
        $A_OR1_OrgID_fk = \Artefacts\Model_Artefact::get_artefact_all_info($quote_id);   
        $this->template->content = \Contacts\Subform_Copyaddress::forge()->render(array('A_OR1_OrgID_fk'=>$A_OR1_OrgID_fk[0]['A_OR1_OrgID_fk'],'div_id'=>$get_div_id,'sub_div_id'=>$get_sub_div_id));
       // $this->template->content = $view;
    }

    /**
     * Add New Contact
     * @param  [type] $CO_OrgID_fk [description]
     * @return [type]              [description]
     */
    function action_new_contact($CO_OrgID_fk)
    {	
        //print_r($CO_OrgID_fk);exit;
        $fs = \Fieldset::forge('new_quote');
        $fs->add('title', 'Title :', array('type' => 'select', 'class' => 'editable','id'=>'InsertConTitle','style'=>'border-color:red', 'options' => Model_Contact::get_new_contact_title()), array(array('required')));
        $fs->add('first_name', 'First Name :', array('type' => 'text'), array(array('required')));
        $fs->add('last_name', 'Last Name :', array('type' => 'text'), array(array('required')));
        $fs->add('hiddenTitle', '', array('type' => 'text' ,'id'=>'InsertConTitleHidden','style'=>'display:none'));
        $fs->add('hiddenTitleKeyUp', '', array('type' => 'text' ,'id'=>'InsertConTitleHiddenKeyUpId','style'=>'display:none'));

       
        if($fs->validation()->run())
        {
            $fields = $fs->validated();
    
            try
            {
                
                 if(strlen($fields['hiddenTitle'])!=0){
            $title=$fields['hiddenTitle'];
        } elseif(strlen($fields['hiddenTitleKeyUp'])!=0) {
            
            $title=$fields['hiddenTitleKeyUp'];
        }
        
                
//                $stmt =$this->db->prepare("DECLARE @return_value int,
//                        @CO_ContactID_pk int
//                        SELECT	@CO_ContactID_pk 
//
//                        EXEC	@return_value = [dbo].[sp_insert_into_t_Contact]
//                    @CO_Title =?,
//                    @CO_Fname =?,
//                    @CO_Lname_ind =?,
//                    @CO_OrgID_fk =?,
//                    @CO_ContactID_pk =?,
//                   @CO_ContactID_pk = @CO_ContactID_pk OUTPUT
//
//                SELECT	@CO_ContactID_pk as N'@CO_ContactID_pk' ");

               
        
        $stmt =$this->db->prepare("SET NOCOUNT ON
            DECLARE @return_value int,
		@CO_ContactID_pk int
                
                EXEC @return_value = [dbo].[sp_insert_into_t_Contact]
		@CO_Title = :title,
		@CO_Fname = :fields_first_name,
		@CO_Lname_ind = :fields_last_name,
		@CO_OrgID_fk = :CO_OrgID_fk,
		@CO_ContactID_pk = :ReturnString
               SELECT @CO_ContactID_pk as abc");
        
                
    		  //$stmt = $this->db->prepare("EXEC sp_insert_into_t_contact @CO_Title=?, @CO_Fname=?, @CO_Lname_ind=?, @CO_OrgID_fk=?, @CO_ContactID_pk=?");
    		    $stmt->bindValue('title', $title);
    		    $stmt->bindValue('fields_first_name', $fields['first_name']);
    		    $stmt->bindValue('fields_last_name', $fields['last_name']);
    		    $stmt->bindValue('CO_OrgID_fk', $CO_OrgID_fk);
    		    $stmt->bindParam( 'ReturnString', $CO_ContactID_pk, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);
                    //$stmt->bindValue('CALL sp_insert_into_t_contact(6, @CO_ContactID_pk, @return_value)');
                    //$stmt->bindValue('SELECT @CO_ContactID_pk,@return_value ');
    		    $result=$stmt->execute();
                      
	    $data = $stmt->fetch();
//echo $CO_ContactID_pk;
           // $this->action_edit();    
echo "<script> parent.$('#controlpanal').val('$CO_ContactID_pk'); parent.$('#dialog').dialog('close');parent.openNewWen('".$CO_ContactID_pk."'); </script>";exit;
                \Message::set('success', 'New contact added.');
            }
            catch(\Exception $e)
            {
                \Message::set('error', 'An error occured.');
            }
	    }
        else 
        {
            \Message::set('error', $fs->validation()->error());
        }
		

        $this->set_iframe_template('new_contact');
        $view = \View::forge('new_contact');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    /**
     * Delete a contact.
     * @param  [type] $contact_id [description]
     * @return [type]             [description]
     */
    function action_delete($contact_id)
    {
	
        $return = Model_Contact::delete_contact($contact_id);

        if($return == 0)
        {
            // echo '<input type="text" id="cherDelectValue" value="DELECTED"><script> alert(\'gfgfgfg\')</script>';exit;
            //\Message::set('error', 'Contact has categories assigned.  These must be cleared before deleting a contact.');
        }
        elseif($return == 1)
        {
        	//\Message::set('error', 'Contact is the only one related to the organisation and the organisation has categories assigned. These must be cleared before deleting a contact.');
        }
        elseif($return == 2)
        {
        	//\Message::set('error', 'Contact is internal and has related quote(s). Delete cancelled.');
        }
        elseif($return == 3)
        {
        	//\Message::set('error', 'Contact has related quote(s). Delete cancelled.');
        }
        elseif($return == 4)
        {
          //  \Message::set('success', 'Contact and organisation sucessfully deleted.');
        }
        elseif($return == 5)
        {
           // \Message::set('success', 'Contact sucessfully deleted.');
        }
        else 
        {
            //\Message::set('error', 'An error has occured.  Contact Adminstrator.');
        }
   echo '<input type="text" id="cherDelectValue" value="DELETED"><script>parent.$(\'body\').css(\'overflow\',\'auto\'); window.parent.closeIframe();</script>';exit;
        \Response::redirect('contacts/index/contacts');	
	
    }
    
     /**
     * Parse the data from data grid fields and generate a Model_ instance, used for listing grid and, excel export
     * @return [type] [description]
     */
    function generate_listing()
    {
        $extra_search_fields = $advance_search_fields = array();
        
        foreach (\Input::param() as $key => $input)
        {
            if (empty($input))
                continue;

            //search for normal filters
            if (strpos($key, 'extra_search_') !== false and !empty($input))
            {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }else if (strpos($key, 'advance_search_') !== false and !empty($input))
            { 

            //search for advance filters
            
                $search_col = str_replace('advance_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $advance_search_fields[$search_col] = $input;


            }else{
                 $extra_search_fields[$key] = $input;
            }
        }

        $order_by = array();
        if (\Input::param('iSortCol_0') == 1)
        {
            $order_by['column'] = 'LastName';
        }

        if (\Input::param('iSortCol_0') == 2)
        {
            $order_by['column'] = 'Organisation';
        }
       
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        $no_of_records = $extra_search_fields['limitData'];//\Input::param('iDisplayLength', 10);
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Contact;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;

        return $listing;
    }
    function setCountOfData(){
        $listing = $this->generate_listing();
        $result = $listing->listing();
        return count($result['result']);
    }
    public function action_load_project_select_ajax(){ 
        //exit;
//        $array=array(1,2,3);
   echo "<script>koko(); </script>";
//     echo json_encode($array);
//                        exit;
//                        p
        //load_project_select_ajax1();
       // return 2;
       // print_r("<script> alert('ddd');</script>");exit;
}
function load_project_select_ajax1(){
    //echo "<script> alert('ddd');</script>";
}
}
