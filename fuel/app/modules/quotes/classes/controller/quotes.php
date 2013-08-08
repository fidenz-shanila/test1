<?php

namespace Quotes;

class Controller_Quotes extends \Controller_Base {

    /**
     * Quote listing
     * @return [type] [description]
     * 
     */
    function action_index()
    {
        if(\Input::post('export_to_excel'))
        {//print_r(\Input::All());
            $listing = $this->generate_listing();//generate model instance
           // print_r($listing);exit;
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }

        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/quotes');
        $view->body_classes = 'clr_quotes';
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar = \View::forge('sidebar/listing');
        $view->sidebar->quote_branch = array();
        $this->template->body_classes = array('clr_quotes');
        $this->template->content = $view;
    }

    /**
     * Insert new work group
     * @author Namal
     */
    function action_insert_work_group($id = null)
    {
        $this->template = \View::forge('template_strip');        
        $view      = \View::forge('insert_work_group');
        
        $branches  = Model_Quote::get_w_nmi_branch();
        
        $fs = \Fieldset::forge('insert_work_group');
        $fs->add('branches', 'Branches :', array('type' => 'select', 'class' => 'select-1', 'data-id' => 'work_branches', 'options' => $branches, 'id' => 'work_branches'), array(array('required')));
        $fs->add('xbranches', 'Branches :', array('type' => 'hidden', 'class' => 'work_branches'));
        $fs->add('sections', 'Sections :', array('type' => 'select', 'class' => 'select-1', 'data-id' => 'work_sections', 'options' => array(), 'id' => 'work_sections'), array(array('required')));
        $fs->add('xsections', 'Sections :', array('type' => 'hidden', 'class' => 'work_sections'));
        $fs->add('projects', 'Projects :', array('type' => 'select', 'class' => 'select-1', 'data-id' => 'work_projects', 'options' => array(), 'id' => 'work_projects'), array(array('required')));
        $fs->add('xprojects', 'Projects :', array('type' => 'hidden', 'class' => 'work_projects'));
        $fs->add('area', 'Area :', array('type' => 'select', 'class' => 'select-1', 'options' => array(), 'data-id' => 'work_areas', 'id' => 'work_area' ), array(array('required')));
        $fs->add('xarea', 'Area :', array('type' => 'hidden', 'class' => 'work_areas'));
        $fs->add('employees', 'Employees :', array('type' => 'select', 'class' => 'select-2', 'options' => array(), 'id' => 'work_employees' ), array(array('required')));
        $fs->add('WDB_YearSeq_fk_ind', '', array('type' => 'hidden', 'value' => $id ), array(array('required')));
        $fs->add('submit',   'Submit   :', array('type' => 'submit', 'value' => 'insert',   'class'   => 'button1'));
    
        if($fs->validation()->run())
        {
            $fields = $fs->validated();
    
            $return = Model_Quote::insert_work_doneby(array('WDB_B_Name' => $fields['xbranches'], 'WDB_S_Name' => $fields['xsections'], 'WDB_P_Name' => $fields['xprojects'], 'WDB_A_Name' => $fields['xarea'], 'WDB_TestOfficerEmployeeID' => $fields['employees'], 'WDB_YearSeq_fk_ind' => $fields['WDB_YearSeq_fk_ind']));
            
            if($return == 2)
            {
                 \Message::set('success', 'Workgroup added.');
                 return $this->close_iframe(null, true);
            }
            elseif($return === 0)
            {
                \Message::set('error', 'This area is already working on this quote and cannot be entered twice.');
            }
            elseif($return === 1)
            {
                \Message::set('error', 'There is an error in the \'Work performed by\' part of the data entry.  It is possible the data doesn\'t exist.  Please revise and try again.');
            }
       
        }
        
        
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }

    /**
     * Delete workgroup entry
     * @param  [type] $WDB_WorkDoneBy_pk [description]
     * @return [type]                    [description]
     */
    public function action_delete_workgroup($WDB_WorkDoneBy_pk)
    {
        if(!\Input::get('yes')){
            echo '<p style="text-align:center; padding:10%; color:#F00;">Are you sure you wish to delete this work group?</p>';
            echo '<div style="text-align:center; padding:10%"><input class="button1" type="button" href="'. \Uri::create("quotes/delete_workgroup/" . $WDB_WorkDoneBy_pk . '?yes=yes') . '" value="YES" />';
            echo '<input class="button1" type="button"  value="NO" onclick="javascript:parent.jQuery.fn.colorbox.close()" /></div>';
        }else{
            $return = Model_Quote::delete_workgroup($WDB_WorkDoneBy_pk);

            if($return == 0)
            {
                \Message::set('error', 'There must be at least one work group attached to this quote/job.  Firtsly add the required work group then delete this work group.  Delete operation cancelled.');
            }
            elseif($return == 1)
            {
                \Message::set('success', 'Workgroup deleted. Close this box to continue');
                 return $this->close_iframe(null, true);
            }elseif($return==2){
                
            }
        }
            $this->set_iframe_template();
            $this->template->content = null;
    }
    
    
    /**
     * action_w_drop_down (JSON) \
     * @author Namal
     */
    
    function action_w_drop_down()
    {
        $dropdowns = new Model_Quote;
        
        if(\Input::get('branches'))
        {
            $data['sections'] = $dropdowns->get_w_nmi_section(\Input::get('branches'));
            echo json_encode($data);
            exit;
        }
        
        if(\Input::get('sections'))
        {
            $data['projects']  = $dropdowns->get_w_nmi_project(\Input::get('sections'));
            $data['employees'] = $dropdowns->get_w_employees(\Input::get('sections'));
            echo json_encode($data);
            exit;
        }
        
        if(\Input::get('projects'))
        {
            $data['area']      = $dropdowns->get_w_nmi_area(\Input::get('projects')); 
            echo json_encode($data);
            exit;
        }
        
    }

    /**
     * Quote listing ajax source (JSON)
     * @return [type] [description]
     */
    function action_listing_data()
    {

        $listing = $this->generate_listing();//generate model instance
        
        $result = $listing->listing();

        $data = array();

        foreach ($result['result'] as $c)
        { //print_r($result); exit;
            $form_url = \Uri::create('mainform/index/?tab=1&quote_id='.$c['A_YearSeq_pk']);
            $img_path = $this->get_image_url($c['A_YearSeq_pk']);
            
            $img_btn  = '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  align="center" style=" background-color:#fce69d;width:100%;height:32px;"><button class="spaced2  viewimage1" onclick="call_to_img(' . "'" . $img_path . "'" .')">...</button></div>';

            if((strtok($c['Q_DateInstRequired'],' ')==false)){
                $dateOfReq='<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  style=" margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'.''.'</div>';
            }else{
                $stp1=strtok($c['Q_DateInstRequired'],' '); 
                $stp2=explode("-",$stp1);
                $stp3=$stp2[1].'/'.$stp2[2].'/'.$stp2[0];
                $dateOfReq='<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  align="center" style=" margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'.$stp3.'</div>';
            }
            
            
            
            
            $data[] = array(
                 '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#fcdb77;padding:2px; height:30px;"><button class="spaced1" href="'.$form_url.'"><b>...<b></button><div>',
                '<div id="NMB'.$c['Q_FullNumber'].'" align="center"  style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['Q_FullNumber'].'</b></div>',
                $img_btn,
               $dateOfReq, 
                 '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  style="width:100%; background-color:#9c9c97; padding:2px; height:30px;"><div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['A_Description'].'</div></div>',
                '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  style="width:100%; background-color:#95a7ed; padding:2px; height:30px;"><div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['OR1_FullName'].'</div></div>',
               '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  style="width:100%; background-color:#fce69d; padding:2px; height:30px;"><div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['FullStatusString'].'</div></div>',
               '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.\NMI_Db::set_number_format($c['Q_QuotedPrice']).'</b></div>'
            );
        }

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
     * Quote listing filter dropdown ajax soure (JSON)
     * @return [type] [description]
     */
    function action_dropdown_data()
    {
        $extra_search_fields = array();

        foreach (\Input::get() as $key => $input) 
        {
            if(empty($input))
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

        $listing = new Model_Quote;
        $listing->limit  = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['branch']  = $listing->get_branches();
        $data['section'] = $listing->get_sections();
        $data['project'] = $listing->get_projects();
        $data['area']    = $listing->get_areas();
        $data['type']    = $listing->get_types();
        
        //$data['type']    = $listing->get_types();
        $data['owner']   = $listing->get_owns();
        $data['test_officer'] = $listing->get_test_offices();
//print_r(json_encode ($data['owner']));exit;
        echo json_encode($data);
        exit;
    }
    
    function action_edit($id = null)
    {
        $view = \View::forge('edit');
        $this->template->content = $view;
    }
    


    /**
     * New quote listing
     * @author Namal
     */
    
    function action_new_quote_listing()
    {
        $new_quote_listing = new Model_Quote;
        
       
        
        if(\Input::get('WDB_S_Name')){
            $new_quote_listing->data['section'] = \Input::get('WDB_S_Name');
        }
        
        if(\Input::get('WDB_P_Name')){
            $new_quote_listing->data['project'] = \Input::get('WDB_P_Name');
        }
        
        if(\Input::get('WDB_A_Name')){
            $new_quote_listing->data['area']    = \Input::get('WDB_A_Name');
        }
        
        $new_quote_listing->new_quote_from();
        $new_quote_listing->new_quote_where();
        
        $data['WDB_S_Name'] = $new_quote_listing->get_nmi_section();
        $data['WDB_P_Name'] = $new_quote_listing->get_nmi_project();
        $data['WDB_A_Name'] = $new_quote_listing->get_nmi_area();
        
        echo json_encode($data);
        exit;
        
    }
    
   /**
     * New quote
     * @return [type] [description]
	 * Code change by Sri
     */
    function action_new_quote($year_seq_pk_id=null)
    {
		$inputs			 = \Input::all();
                $call_sp                 =  '';
               
		$sections 		 = Model_Quote::get_nmi_section();
		$Organisation            = Model_Quote::get_organisation();
		$offices 		 = Model_Quote::get_nmi_test_offices();
                $types                   = Model_Quote::get_nmi_type(); 
		
		if(isset($inputs['base_quote'])){
			$call_sp		 = Model_Quote::call_to_sp_NewQuoteBasedOnPreviousQuote($inputs); 
			$projects 		 = Model_Quote::get_nmi_project($call_sp['S_Name_ind']);
			$areas   		 = Model_Quote::get_nmi_area($call_sp['projects']);
                        $offices                 = $call_sp['offices'];
                        $quote                   = Model_Quote::get_quote($year_seq_pk_id);
                        
		 }else{
			$projects 		 = Model_Quote::get_nmi_project(0); 
			$areas   		 = Model_Quote::get_nmi_area(0);

		 }
		 
        $view       	 = \View::forge('insert_new_quote');

        $fs = \Fieldset::forge('new_quote');
		
        //create from fields
        $fs->add('sel_type_owner', 'Owner Type :', array('type' => 'select', 'class' => 'select-1', 'id'=>'sel_type_owner', 'name'=>'sel_type_owner',  'options' =>array('NMI' => 'NMI','EXTERNAL'=>'EXTERNAL' ) ), array(array('required')));
        $fs->add('org_names',    'Names      :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'org_name', 'name'=>'org_names','readonly' => 'readonly'), array(array('required')));
        $fs->add('hid_org_id',    'Hidden Org Id      :', array('type' => 'hidden', 'class' => 'textbox-1', 'id' => 'hid_org_id', 'name'=>'hid_org_id'));
        $fs->add('hid_contact_id',    'Hidden Contact Id      :', array('type' => 'hidden', 'class' => 'textbox-1', 'id' => 'hid_contact_id', 'name'=>'hid_contact_id'));
        $fs->add('certificate_offered',    'Certificate Offered      :', array('type' => 'hidden', 'class' => 'textbox-1', 'id' => 'hid_certificate_offered', 'name'=>'hid_certificate_offered'));
        $fs->add('servicesoffered',    'Services Offered      :', array('type' => 'hidden', 'class' => 'textbox-1', 'id' => 'hid_sevice_offered', 'value'=>'0', 'name'=>'action_nmi_internal_projects_and_contacts()hid_sevice_offered'));
        $fs->add('special_requirements',    'SpecialRequirements      :', array('type' => 'hidden', 'class' => 'textbox-1', 'id' => 'hid_special_requirements', 'name'=>'hid_special_requirements'));
        $fs->add('org_contact',    'Contact Name      :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'org_contact', 'name'=>'org_contact','readonly' => 'readonly','style'=>'text-align:center'));
        $fs->add('S_Name_ind', 'Sections :', array('type' => 'select', 'class' => 'select-1 wdb_data add_reset_filter_Sections editable', 'id'=>'sections',  'options' => array(''=>'')), array(array('required')));
        $fs->add('projects', 'Projects :', array('type' => 'select', 'class' => 'select-1 wdb_data add_reset_filter_Projects editable', 'id'=>'projects', 'options' =>array(''=>'') ), array(array('required')));
        $fs->add('areas',    'Areas    :', array('type' => 'select', 'class' => 'select-1 wdb_data add_reset_filter_Areas editable', 'options' => array(''=>''), 'id'=>'sel_area', 'name'=>'sel_area' ),    array(array('required')));
        $fs->add('offices',  'Offices  :', array('type' => 'select', 'class' => ' wdb_data ', 'id'=>'FrmInsert_officer','style'=>'background:#fff; border:solid 1px #999; height:18px; width:100%;' ),  array(array('required')));
        //$fs->add('WDB_TestOfficerEmployeeID', 'WDB_TestOfficerEmployeeID :', array( 'type'=>'select', 'class' => 'select-1 quote_listing', 'options' => $offices), array(array('required')));
        $fs->add('types',    'Types    :', array('type' => 'select', 'class' => 'select-1 wdb_data ', 'id' => 'sel_type', 'options' => array(''=>'')),    array(array('required')));
        $fs->add('make',    'Make      :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'txt_make'));
        $fs->add('branch_name',    'NMI Branch :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'txt_branch_name', 'value'=>'Physical metrology','readonly'=>'readonly'));
        $fs->add('model',    'Model    :', array('type' => 'text', 'class' => 'textbox-1' , 'id' => 'txt_model'));
        $fs->add('serial_no','Serial No:', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'txt_serial'));
        $fs->add('range',    'Range    :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'txt_range'), array(array('numeric_min'=>'-200', 'numeric_max'=>'100')));
        $fs->add('description','Description:', array('type' => 'textarea', 'class' => 'textarea-1', 'id' => 'txt_description'));
        $fs->add('file_no', 'file_no :', array('type' => 'text', 'class' => 'textbox-1 cb_file_id','name'=>'txt_file_name', 'id'=>'txt_file_name','style'=>'text-align:center', 'readonly' => 'readonly'), array(array('required')));
        $fs->add('title', 'Title :', array('type' => 'text', 'class' => 'textbox-8 cb_file_title', 'name' => 'txt_file_title', 'id'=>'txt_file_title','style'=>'text-align:center', 'readonly' => 'readonly'), array(array('required')));
        //$fs->add('file_no','File Number:', array('type' => 'text', 'class' => 'textbox-1', 'name'=>'txt_file_name', 'id'=>'txt_file_name', 'readonly' => 'readonly'));
        //$fs->add('title','Title        :', array('type' => 'text', 'class' => 'textbox-1', 'name' => 'txt_file_title', 'id'=>'txt_file_title', 'readonly' => 'readonly'));
        $fs->add('submit',   'Submit   :', array('type' => 'submit', 'value' => 'insert',   'class'   => 'button1'));
		
	if(isset($inputs['base_quote'])&&(!isset($inputs['mode']))){$fs->populate($call_sp,false); }
		
        if($fs->validation()->run())
	    { 
            $fields = $fs->validated();

            try
            { 	
                    if(!isset($inputs['base_quote'])){                                               
                        $quote['Q_ServicesOffered']      = $fields['servicesoffered'];
                        $quote['Q_CertificateOffered']   = $fields['certificate_offered'];
                        $quote['Q_SpecialRequirements']  = $fields['special_requirements'];
                    }
                
              //  $stmt = $this->db->prepare("EXEC sp_insert_into_t_ArtefactAndQuote @WDB_B_Name=?, @WDB_S_Name=?, @WDB_P_Name=?, @WDB_A_Name=?, @WDB_TestOfficerEmployeeID=?, @A_Type=?, @A_Make=?,@A_Model=?,@A_SerialNumber=?,@A_Description=?,@A_CF_FileNumber_fk=?,@A_OR1_OrgID_fk=?,@A_ContactID=?,@Q_ServicesOffered=?,@Q_CertificateOffered=?,@Q_SpecialRequirements=?,@A_PerformanceRange=?,@A_YearSeq_pk=?");
		
                
                $stmt = $this->db->prepare(" SET NOCOUNT ON
                                                        DECLARE	@return_value int,
                                                        @A_YearSeq_pk int
                                                       
                                        
                                        EXEC	@return_value = [dbo].[sp_insert_into_t_ArtefactAndQuote]
                                        @WDB_B_Name = :WDB_B_Name,
                                        @WDB_S_Name  = :WDB_S_Name,
                                        @WDB_P_Name = :WDB_P_Name,
                                        @WDB_A_Name = :WDB_A_Name,
                                        @WDB_TestOfficerEmployeeID = :WDB_TestOfficerEmployeeID,
                                        @A_Type     = :A_Type,
                                        @A_Make     = :A_Make,
                                        @A_Model    = :A_Model,
                                        @A_SerialNumber = :A_SerialNumber,
                                        @A_PerformanceRange = :A_PerformanceRange,
                                        @A_Description  = :A_Description,
                                        @A_CF_FileNumber_fk = :A_CF_FileNumber_fk,
                                        @A_OR1_OrgID_fk = :A_OR1_OrgID_fk,
                                        @A_ContactID    = :A_ContactID,
                                        @Q_ServicesOffered  = :Q_ServicesOffered,
                                        @Q_CertificateOffered   = :Q_CertificateOffered,
                                        @Q_SpecialRequirements  = :Q_SpecialRequirements,
                                        @A_YearSeq_pk = :A_YearSeq_pk                                      

                                        
                                        SELECT  'return' = @return_value ");

                 $stmt->bindValue('WDB_B_Name', $fields['branch_name']);
                 $stmt->bindValue('WDB_S_Name', $fields['S_Name_ind']);
                 $stmt->bindValue('WDB_P_Name', $fields['projects']);
                 $stmt->bindValue('WDB_A_Name', $fields['areas']);
                 $stmt->bindValue('WDB_TestOfficerEmployeeID', $fields['offices']);
                 $stmt->bindValue('A_Type', $fields['types']);
                 $stmt->bindValue('A_Make', $fields['make']);
                 $stmt->bindValue('A_Model', $fields['model']);
                 $stmt->bindValue('A_SerialNumber', $fields['serial_no']);
                 $stmt->bindValue('A_PerformanceRange', $fields['range']);
                 $stmt->bindValue('A_Description', $fields['description']);
                 $stmt->bindValue('A_CF_FileNumber_fk', $fields['file_no']);
                 $stmt->bindValue('A_OR1_OrgID_fk', $fields['hid_org_id']);
                 $stmt->bindValue('A_ContactID', $fields['hid_contact_id']);
                 $stmt->bindValue('Q_ServicesOffered', $quote['Q_ServicesOffered']);
                 $stmt->bindValue('Q_CertificateOffered', $quote['Q_CertificateOffered']);
                 $stmt->bindValue('Q_SpecialRequirements', $quote['Q_SpecialRequirements']);
                 $stmt->bindParam('A_YearSeq_pk', $year_seq_pk_id, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);
                 $stmt->execute();// print_r($stmt);exit;
                 
                 $return =$stmt->fetchAll();
                 
                 $year_seq_pk_id_sender=str_replace("","",$year_seq_pk_id);
                //print_r($year_seq_pk_id_sender);exit;
                if ($return[0]['return'] == 0) {
                    \Message::set('error', 'There is an error in the \'Work performed by\' part of the data entry.  It is possible the data doesn\'t exist.  Please revise and try again.');
                 
                 } else {
                            echo "<script type='text/javascript'>parent.$('#InsertQuote').dialog('close'); parent.openNweTab('$year_seq_pk_id_sender');</script>";exit;
                    \Message::set('success', 'Quote insert success');
             
                    // \Response::redirect('mainform/index/?tab=1&quote_id=20130216');	
                    return $this->close_iframe(null, true);
                    // echo "<script type='text/javascript'>parent.jQuery.fn.colorbox.close();</script>";
                 }
            }catch(\PDOException  $e)
            {
                //die($e->getMessage());
                \Message::set('error', 'There is an error in save');
                exit();
                //return $this->close_iframe(null, false);
            }
			
		//\Response::redirect('quotes/');
       
	    }
            if(isset($inputs['base_quote'])||isset($inputs['form'])){
                    $this->set_iframe_template();
            }
                
            $view->set('form', $fs->form(), false);
            $view->call_sp = $call_sp;
	    $this->template->content = $view;

    }
    
    /**
     * Main form quote tab worklog
     */    
    public function action_mainform_worklog($quote_id)
    {
        $this->set_iframe_template();
        $this->template->content = \Quotes\Subform_Work::forge()->render(array('quote_id'=>$quote_id));
    }
    
     /**
     * Hours Log form
     * @author Namal
     * @param
     */    
    public function action_hours_log()
    {
        $WDB_P_Name =  \Input::param('WDB_P_Name'); 
        $WDB_WorkDoneBy_pk =  \Input::param('WDB_WorkDoneBy_pk');
                
        $employee_list = Model_Quote::get_hours_log_employee_list($WDB_P_Name);
        $artefacts = \Artefacts\Model_Artefact::get_artefact(\Input::get('quote_id'));
        
        //TODO
        $fs = \Fieldset::forge('hours_log');
        $fs->add('A_description', '', array('type' => 'textarea', 'class' => 'textarea-1','readonly'=>'readonly', 'value' => $artefacts['A_Description']));
        $fs->add('type', 'Type of Hour :', array('type' => 'select', 'class' => 'select-1', 'options' => array('Admin' => 'Admin', 'Technical' => 'Technical'), array(array('required'))));
        $fs->add('date', 'Date :', array('type' => 'text', 'class' => 'textbox-1 datepicker' ), array(array('required')));
        $fs->add('employee', 'Employee :', array('type' => 'select', 'class' => 'select-1', 'options' => $employee_list, array(array('required'))));
        $fs->add('hours', 'Hours :', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));         
        $fs->add('minutes', 'Minutes :', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));         
        $fs->add('WDB_WorkDoneBy_pk', '', array('type' => 'hidden', 'value' => $WDB_WorkDoneBy_pk));
        $fs->add('WDB_P_Name', '', array('type' => 'hidden', 'value' => $WDB_P_Name));

        if ($fs->validation()->run()) {
            $fields = $fs->validated();
      
            $hours          = (int)$fields['hours'];
            $mins           = (int)$fields['minutes'];
            $H_HoursInHhMm  = \Helper_App::format_time($hours, $mins);
			
            Model_Quote::insert_into_hour_log($H_HoursInHhMm, date("Y-m-d H:i:s", strtotime($fields['date'])), $fields['employee'], $WDB_WorkDoneBy_pk, $fields['type']);
        
        } else {

            \Message::set('error', $fs->validation()->error());
            $fs->repopulate();
        
        }
        
        $this->set_iframe_template('hours');
         
        $work_log_hours = Model_Quote::get_work_log_hrs($WDB_WorkDoneBy_pk);
		$worklog_entry  = Model_Quote::get_worklog_entry($WDB_WorkDoneBy_pk);

    
        $view = \View::forge('hours_log');
        $view->WDB_P_Name = $WDB_P_Name;
        $view->WDB_WorkDoneBy_pk = $WDB_WorkDoneBy_pk;
		$view->WDB_HoursInHhMm = $worklog_entry['WDB_HoursInHhMm'];
        $view->set('log', $work_log_hours, false);
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
     
    }
    
    /**
    *get Change test officer
    *Code by Sri
    */
    public function action_change_test_officers(){
            $inputs	=	\Input::all();
            $this->set_iframe_template();
    $this->template->content = \quotes\Subform_Changetestofficer::forge()->update($inputs);
        echo "<script type='text/javascript'>parent.location.reload();parent.jQuery.fn.colorbox.close();</script>";
    }
    
    /**
    *get test officer
    *Code by Sri
    */
    public function action_load_test_officers(){
            $inputs	=	\Input::all();
            $this->set_iframe_template();
    $this->template->content = \quotes\Subform_Changetestofficer::forge()->render($inputs);
    }
    
    /**
     * Delete hours log
     * @author Namal
     */
    
    public function action_delete_work_log($H_HoursID_pk)
    {
        $WDB_P_Name =  \Input::param('WDB_P_Name'); 
        $WDB_WorkDoneBy_pk =  \Input::param('WDB_WorkDoneBy_pk');

        Model_Quote::delete_work_log_hrs($H_HoursID_pk);
        \Message::set('success', 'Hour log entry deleted.');
        \Response::redirect(\Uri::create('quotes/hours_log?WDB_P_Name='.urlencode($WDB_P_Name).'&WDB_WorkDoneBy_pk='.urlencode($WDB_WorkDoneBy_pk)), 'refresh');
    }

    /**
     * Build quote price form
     * @author Namal
     */    
    public function action_build_quote_price($WDB_WorkDoneBy_pk)
    {
        $wdb = Model_Quote::get_worklog_entry($WDB_WorkDoneBy_pk);

        $this->set_iframe_template('build_quote_price');
        $view = \View::forge('build_quote_price');
        $view->set('wdb', $wdb, false);
        $view->set('wdb_quote_price', Model_Quote::get_worklog_quote_price($wdb['WDB_WorkDoneBy_pk']), false);
        $view->set('selected_modules', Model_Quote::selected_modules_for_quote($wdb['WDB_WorkDoneBy_pk']), false);
        $view->set('all_modules', Model_Quote::all_modules_for_quote($wdb['WDB_B_Name'], $wdb['WDB_S_Name'], $wdb['WDB_P_Name'], $wdb['WDB_A_Name']), false);
        $view->set('test_officers', Model_Quote::quote_module_test_officers($wdb['WDB_B_Name'], $wdb['WDB_S_Name'], $wdb['WDB_P_Name'], $wdb['WDB_A_Name']), false);
        $this->template->content = $view;
    }
    
    /**
     * Update module in build quote
     * @author Namal
     */
    
    public function action_update_module($QM_QuoteModuleID_pk)
    {
        $QM_F_Fee = \Input::post('QM_F_Fee');
        $QM_Quantity = \Input::post('QM_Quantity');
        $QM_DiscountPercentage = \Input::post('QM_DiscountPercentage');
        $WDB_WorkDoneBy_pk =  \Input::param('WDB_WorkDoneBy_pk');
    
        Model_Quote::update_module($QM_QuoteModuleID_pk, $QM_F_Fee, $QM_Quantity, $QM_DiscountPercentage);

        //\Message::set('success', 'Module updated.');
        \Response::redirect("quotes/build_quote_price/{$WDB_WorkDoneBy_pk}");
    }
    
    /**
     * Delete module in quote
     * @author Namal 
     */
     public function action_delete_module($QM_QuoteModuleID_pk)
     {
        $WDB_WorkDoneBy_pk =  \Input::param('WDB_WorkDoneBy_pk');

        Model_Quote::delete_module($QM_QuoteModuleID_pk);

        //\Message::set('success', 'Module deleted.');
        \Response::redirect("quotes/build_quote_price/{$WDB_WorkDoneBy_pk}");
     }
     
     
     /**
      * push module
      * @author Namal
      */
    public function action_push_module($F_FeeID_pk , $WDB_WorkDoneBy_pk)
    {
        Model_Quote::push_module($F_FeeID_pk, $WDB_WorkDoneBy_pk);
        
        //\Message::set('success', 'New module added.');    
        \Response::redirect("quotes/build_quote_price/{$WDB_WorkDoneBy_pk}");
    }
    
    
    	/**
	*Load Select List
	*/
	public function action_load_project_select_ajax(){ 
//		$listing = new Model_Quote;
//		//if(\Input::get('sections')){
//			$section		=\Input::get('sections');
//                        $project                =\Input::get('projects');
//                         $sel_area                =\Input::get('sel_area');
//			$projects 		= Model_Quote::fill_data_according_projects($section,$project,$sel_area);
//			//create json
//			$data['Section']	=	'[{"optionValue":"","optionDisplay":""},';
//			for($x=0;$x<count($projects);$x++){
//				if($x!=0){$data .=',';}
//				$data  .= '{"optionValue":"';
//				$data .= $projects[$x]['S_Name_ind'];
//				$data  .= '","optionDisplay":"';
//				$data .= $projects[$x]['S_Name_ind'];
//				$data .= '"}';
//			}
//			$data	.=	']';
//			echo $data;
//			
//		//}
//		exit;
            
          //print_r(\Input::get('sections'));exit;
            $data=array('section'=>\Input::get('sections'),'project'=>\Input::get('projects'),'area'=>\Input::get('sel_area'),'type'=>\Input::get('sel_type'),'emp'=>\Input::get('sel_emp'));
            $listing = new Model_Quote;
//             $data['section']		=\Input::get('sections');
//             $data['$project']               =\Input::get('projects');
//               $data['area']               =\Input::get('sel_area');
            //$projects = array($section,$project,$sel_area,4,5,6);
            //'emp'=>\Input::get('sel_emp')
        $listing->data  = $data;
        //print_r( $data);exit;
            $array['areas']  = $listing->get_new_area();
            $array['projects']  = $listing->get_new_project();
            $array['S_Name_ind']  = $listing->get_new_section();
            $array['types']  = $listing->get_new_type();
          //  print_r(\Input::get('emp_button'));exit;
            if(\Input::get('emp_button')=='yes'){
                $array['offices']  = $listing->get_new_emp_button();
            }else{
                $array['offices']  = $listing->get_new_emp();
            }
            
                //print_r($data1);exit;       
                        echo json_encode($array);
                        exit;
	}
	
	
	/**
	*Load Select Area list
	*Code by Sri
	*/
	public function action_load_select_area_ajax(){
		$listing = new Model_Quote;
		if(\Input::get('select_id')){
			$project		=	\Input::get('select_id');
			$area 		= Model_Quote::get_nmi_area_ajax($project);

			//create json
			$data['area ']	=	'[{"optionValue":"","optionDisplay":""},';
			for($x=0;$x<count($area);$x++){
				if($x!=0){$data .=',';}
				$data  .= '{"optionValue":"';
				$data .= $area[$x]['A_Name_ind'];
				$data  .= '","optionDisplay":"';
				$data .= $area[$x]['A_Name_ind'];
				$data .= '"}';
			}
			$data	.=	']';
			echo ($data);
			
		}
		exit;
	}
     

    /**
     * Change owner
     * @author Namal
     * @author Niroshana
     */    
    public function action_change_owner()
    {
        $Q_YearSeq_pk =  \Input::param('Q_YearSeq_pk');
        
        $fs = \Fieldset::forge();
        $fs->add('A_OR1_OrgID_fk', 'Organization ID', array('type'=>'hidden'), array('required'));
        $fs->add('A_ContactID', 'ContactID', array('type'=>'hidden'), array('required'));
        $fs->add('Q_YearSeq_pk', 'QuoteID', array('type'=>'hidden', 'value'=>$Q_YearSeq_pk), array('required'));
        $fs->add('submit', 'Submit', array('type' => 'submit', 'value' => 'Apply', 'class' => 'button1'));
        
        if ($fs->validation()->run()) {

            $fields = $fs->validated();
            \Artefacts\Model_Artefact::update_owner($fields['Q_YearSeq_pk'], $fields['A_ContactID'], $fields['A_OR1_OrgID_fk']);
            \Message::set('success', 'Owner updated, close this box.');
        }
        

        $this->set_iframe_template('change_owner');
        $view = \View::forge('change_owner');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
     
    /**
     * Select owner NMI
     * @author Niroshana
     */    
    public function action_select_owner_nmi()
    {
        $this->set_iframe_template('select_owner_nmi');
        $view = \View::forge('select_owner_nmi');
        $view->set('nmi_projects', Model_Owner::get_nmi_projects(), false);
        $view->set('nmi_contacts', Model_Owner::get_nmi_contacts(), false);
        $this->template->content = $view;
    }
     
    /**
     * Select owner Extrenal
     * @author Niroshana
     */    
    public function action_select_owner_extrenal()
    {
        $this->set_iframe_template('select_owner_extrenal');
        $view = \View::forge('select_owner_extrenal');
    //$view->contact_cats = Model_Contact::get_categories(); --- ORIGINAL CODE FROM CONTACT CONTROLLER
    $view->set('contact_cats', \Contacts\Model_Contact::get_categories(), false);
        //$view->org_cats = Model_Contact::get_org_categories(); --- ORIGINAL CODE FROM CONTACT CONTROLLER
    $view->set('org_cats', \Contacts\Model_Contact::get_org_categories(), false);
        $this->template->content = $view;
    }

      /**
     * Main form work group
     */    
    public function action_create_batch()
    {
        $fs = \Fieldset::forge();
        $fs->add('QuotesToBatch', 'Number of Quotes', array('type'=>'text'), array( array('required'), array('numeric_max', '9') ));
        $fs->add('Q_YearSeq_pk', 'YearSeq_pk', array('type'=>'hidden', 'value' => \Input::param('Q_YearSeq_pk')), array('required'));
        $fs->add('Q_FullNumber', 'FullNumber', array('type'=>'hidden', 'value' => \Input::param('Q_FullNumber')), array('FullNumber'));

        if($fs->validation()->run() == true)
        {
            extract($fs->validated());
            $return = Model_Quote::insert_create_batch(array('Q_YearSeq_pk' => $Q_YearSeq_pk, 'QuotesToBatch' => $QuotesToBatch, 'Q_FullNumberOUT' => $Q_FullNumber));
            
            if($return == 0)
            {
                \Message::set('error', 'Invalid number of batches entered.  Operation cancelled.');
            }
            elseif($return == 1)
            {
                \Message::set('error', 'Work done by selection invalid.  Operation cancelled.');
            }
            else
            {
                \Message::set('success', "{$QuotesToBatch} quote(s) has been created.");
            }
        }
        else
        {
            \Message::set('error', $fs->validation()->error());
        }

        $this->set_iframe_template('create_batch');
        $view = \View::forge('create_batch');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }

    public function action_search_quote()
    {
        $fs = \Fieldset::forge('search_for_quotes');
        $fs->add('QuotesToBatch', 'Number of Quotes', array('type'=>'text'), array( array('required'), array('numeric_max', '9') ));
        
        $this->set_iframe_template('searchforquote');
        $view = \View::forge('search_for_quotes');
        $this->template->content = $view;
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
            $order_by['column'] = 'Number';
        }

        if (\Input::param('iSortCol_0') == 3)
        {
            $order_by['column'] = 'DateInstrumentRequired';
        }
       
        if (\Input::param('iSortCol_0') == 4)
        {
            $order_by['column'] = 'Description';
        }
       
        if (\Input::param('iSortCol_0') == 5)
        {
            $order_by['column'] = 'Client';
        }
       
        if (\Input::param('iSortCol_0') == 6)
        {
            $order_by['column'] = 'Status';
        }
       
        if (\Input::param('iSortCol_0') == 7)
        {
            $order_by['column'] = 'QuotedPrice';
        }
       
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        if(!empty($extra_search_fields['limitData'])){
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::param('iDisplayLength', 10);
        }else{
            $no_of_records = '';
        }
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Quote;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;
        //print_r($advance_search_fields);exit;
        return $listing;
    }


    /**
     * Insert job record
     * @return [type] [description]
     */
    public function action_insert_job_record()
    {
        
//         'This sp insert a job record
// 'Check to see if permission OK
// 'Check permission
//     'Dim sPermission As String
//     'sPermission = IsUserDbOfficial 'pfIsPermissionGranted("ExecuteSp", "sp_insert_into_t_Job", "")
//     If IsUserQuoteAdmin = False Then
//         MsgBox "You do not have permission to perform this action."
//         Exit Sub
//     End If
// 'Check to see if job record already exists
//     If DoesJobExist(Me.Q_YearSeq_pk) = True Then
//         MsgBox "The job record already exists!"
//         Exit Sub
//     End If
// 'Check to see if quote has been accepted
//     If Me.Q_OutCome <> "Accepted" Or IsNull(Me.Q_OutComeDate) Or Me.Q_OutComeDate = "" Then
//         MsgBox "A job record can only be created after the quote has been accepted."
//         Exit Sub
//     End If
// 'Insert the job
// 'Declare variables
//     Dim cmd1 As ADODB.Command
//     Dim prmA_YearSeq_pk As ADODB.Parameter
//     Dim prmJ_FullNumber As ADODB.Parameter
//     Dim sJ_FullNumber As String
//     Dim stDocName As String
//     Dim stLinkCriteria As String
//     Dim frm As Form
//     Dim lYearSeq As Long
// 'Set value of variables
//     lYearSeq = Me.Q_YearSeq_pk
// 'Set value of global
//     gsSetFocus = Me.Q_FullNumber
// 'Initiate and assign properties to command object
//     Set cmd1 = New ADODB.Command
//     cmd1.ActiveConnection = CurrentProject.Connection
//     cmd1.CommandType = adCmdStoredProc
//     cmd1.CommandText = "sp_insert_into_t_Job"
// 'Create input/output parameters for cmd1
//     Set prmA_YearSeq_pk = cmd1.CreateParameter("@A_YearSeq_pk", adInteger, adParamInput)
//     Set prmJ_FullNumber = cmd1.CreateParameter("@J_FullNumber", adVarChar, adParamOutput, 10)
// 'Append and assign values to parameters
//     cmd1.Parameters.Append prmA_YearSeq_pk
//     prmA_YearSeq_pk.Value = Me.Q_YearSeq_pk
//     cmd1.Parameters.Append prmJ_FullNumber 'OUTPUT
// 'Run command
//     cmd1.Execute
// 'Set value of variable
//     sJ_FullNumber = prmJ_FullNumber.Value
// 'cleanup recordset resources
//     Set prmA_YearSeq_pk = Nothing
//     Set prmJ_FullNumber = Nothing
// 'Close this form
//     DoCmd.Close
// 'Update the job project code summary
//     Call psUpdateInvoiceProjectCodeSummary(lYearSeq)
// 'Open the form
//     stDocName = "frmMainForm"
// 'make 'stLinkCriteria'
//     stLinkCriteria = "[Q_YearSeq_pk]= " & lYearSeq
// 'Open the form and display the relevant contact details
//     DoCmd.OpenForm stDocName, , , stLinkCriteria
// 'Set form
//     'frm.tabMain.Pages("JobAndReportPage").Visible = True
//     'frm.tabMain.Pages("InvoicingPage").Visible = True
//     Set frm = Forms!frmMainForm
//     frm.Form.tabMain.Pages("JobAndReportPage").SetFocus
    }
    
    /*
     * function name - description
     * @param $arg
     * @return null
     * @author Namal
     */
    public function action_get_quote_merge_data()
    {
        $Q_YearSeq_pk   = \Input::param('Q_YearSeq_pk');
        $x_ContractType = \Helper_App::GetContractType_v2(false, $Q_YearSeq_pk, "Any", 0);
        $template_path  = \Helper_App::ReturnTemplatePathBasedOnContractType($x_ContractType);
    
        if(empty($template_path)) {
       
            \Message::set('error', 'No Quote document Created due to Invalid path for Quote/Hire Document.  Please contact Adminstrator.');
            $this->template->content = null; //blank page
            return null;
       
        } else {

            $data = \NMI_db::run_sp('sp_QuoteMergeData', 'Q_YearSeq_pk', $Q_YearSeq_pk);

            $new_data_array = array();
            
            foreach ($data as $key => $val) {
                                    
                if ($key%2 == 0) {
                    $new_data_array[$val] = $data[++$key];
                }
                    
            }

            $doc = \NMI_Doc::generate_template($template_path, $new_data_array);
            \NMI_Doc::save($doc, 'quote_merge_data.doc');

        }
        
        
    }
    
    /*
     * function accept_quote - description
     * @param $A_YearSeq_pk
     * @return null
     * @author Namal
     */
    public function action_accept_quote($A_YearSeq_pk)
    {
        //TODO, Check permission
        //TODO, Check to see if quote has been accepted
        
        $exists  = \Jobs\Model_Job::check_job_exists($A_YearSeq_pk);
    
        if ($exists == '1') {

            \Message::set('error', 'The job record already exists!');
            \Response::redirect('mainform/index/?tab=1&quote_id='.$A_YearSeq_pk);
        
        } else {
            $J_YearSeq_pk = \Jobs\Model_Job::insert_job_from_quote($A_YearSeq_pk);
            \Jobs\Model_Job::psUpdateInvoiceProjectCodeSummary($J_YearSeq_pk);
            \Message::set('success', 'Success');
            \Response::redirect('mainform/index/?tab=2&quote_id='.$A_YearSeq_pk);
        }
        
    }
    
    
    /*
     * update quotes Accept
     */
    public function action_update_quotes($Q_YearSeq_pk){
        $getString = \Input::get('string');
        $getDate = \Input::get('outDate');
        
        $updateQuote = Model_Quote::update_quote($Q_YearSeq_pk, $getString,$getDate);
        if($updateQuote==true){
            return $getString;
            exit;
        }else{
            return NULL;
            exit;
        }
    }
    



    /*
   * action_build_artifact_description - description
   * @param $arg
   * @return null
   * @author Namal
   */
  public function action_build_artifact_description()
  {
    $A_Type = \Input::param('form_A_Type');
    $A_Make = \Input::param('form_A_Make');
    $A_Model = \Input::param('form_A_Model');
    $A_SerialNumber = \Input::param('form_A_SerialNumber');
    $A_PerformanceRange = \Input::param('form_A_PerformanceRange');
    
    $description = Model_Quote::build_artifact_descrption($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange);
    
    echo json_encode($description);
    exit;
  }
  
  
  	
	/** CREATE NMI Projects FORM
	**
	*Code by Sri
	*/
	public function action_nmi_internal_projects_and_contacts(){
		$view = \View::forge('frmSelectInternalOrgAndContact');
                $this->set_iframe_template('');
		
		$project_list	=	Model_Quote::get_nmi_internal_projects();
		$contact_list	=	Model_Quote::get_nmi_internal_contacts();
		
		$fs	=	\Fieldset::forge('nmi_internal_projects');
		//$fs->add('txt_projects', 'Projects:', array('type'=>'select', 'class'=>'', 'id'=>'txt_projects', 'width'=>'200px','height'=>'500px', 'multiple size'=>"15", 'options' => $project_list));
                $i=0;
                $opctionForTxtProjects='';
                foreach($project_list as $key => $value){ $opctionForTxtProjects .= '<li id="txt_projects" class="ui-widget-content Contactcon">'.$value.'</li>' ;$i++; };
                $outPutOFOpctionForTxtProjects=$opctionForTxtProjects;
		$fs->add('txt_contacts', 'Contacts:', array('type'=>'select', 'class'=>'', 'id'=>'txt_contacts','height'=>'500px', 'multiple size'=>"30", 'options' => $contact_list));
		
		$view->set('form', $fs->form(), false);
		
	        $this->template->content = $view;
	}
    
	
	
	/*
	* Load View Image
	*Code by Sri
	**
	*/
        
        public function get_image_url($A_YearSeq_pk)
        { 
            $artifact_info = \Artefacts\Model_Artefact::get_artifact_info($A_YearSeq_pk); 
            $path = '';
            if($artifact_info['A_ArtefactMainImagePath'] !=''){
                $path = \Config::get('artefact_parth') .DS. $A_YearSeq_pk .DS . $artifact_info['A_ArtefactMainImagePath'] ;
                $path = '../../../files/artefact/' . $A_YearSeq_pk .'/'. $artifact_info['A_ArtefactMainImagePath'] ;
                return $path;
            }else{
              return $path;
            }

         }

        public function action_load_ret($quote_id=null){
            $view = \View::forge('calender');
            $this->set_iframe_template('');
            $view->set('Q_DateInstRequired',\Input::get('Q_RD'),false);
            $view->set('Q_SpecialRequirements',\Input::get('Q_SR'),false);
            $this->template->content = $view;
        }
	

}