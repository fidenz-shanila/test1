<?php

namespace Employees; 

class Controller_Employees extends \Controller_Base {

    function action_index() 
    {
    
        if (\Input::post('export_to_excel')) {
            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/employee');
        $view->body_classes = 'clr_employee';
        $view->sidebar = \View::forge('sidebar/listing');
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar->job_branch = array();
        $view->sidebar->job_sector = array();
        $view->sidebar->job_project = array();
        $view->sidebar->job_area = array();
        $this->template->body_classes = array('clr_employee');
        $this->template->content = $view;
        
        
    }

    function action_listing_data() 
    {
        
        $listing = $this->generate_listing();
        $result  = $listing->listing();
        
        $data = array();
        
        foreach ($result['result'] as $c) {

            $url = \Uri::create("employees/edit/{$c['EM1_EmployeeID_pk']}");
            
            $data[] = array( 
                '<div  style="background-color:#B66CFF;width:100%;height:30px;padding:2px"><input type="button" href='.$url.' class="spaced1" data-ID="' . $c['EM1_Fullname'] . '" value="..." /></div>',
               '<div  style="margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'. $c['EM1_Fullname'].'</div>',
                '<div align="center" style="margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'. $c['EM1_Phone'].'</div>',
                '<div  style="margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'. $c['EM1_FullPositionDescription'].'</div>',
                '<div  style="margin:5px;background-color:#d5d6d0;padding:2px;min-height:18px;padding-left:5px;border: 1px solid #aaadaa;">'. $c['EM1_SD_SiteName_fk'].'</div>',
              
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
     * Dropdowns
     * @return [type] [description]
     */
    function action_dropdown_data() 
    {
        $extra_search_fields = array();

        foreach (\Input::get() as $key => $input) {

            if (strpos($key, 'extra_search_') !== false and !empty($input)) {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }
        }

        $global_search = \Input::get('sSearch');
        $no_of_records = (int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::get('iColumns');
        $offset        = \Input::get('iDisplayStart', 0);

        $listing = new Model_Employee;
        $listing->limit  = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['status']  = $listing->get_status();
        $data['site']    = $listing->get_site();
        $data['branch']  = $listing->get_branches();
        $data['section'] = $listing->get_sections();

        echo json_encode($data);
        exit;
    }


    /**
     * Edit
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function action_edit($EM1_EmployeeID_pk) 
    {
        
    	$employee 	= new Model_Employee;
        $Employees      = $employee->get_employee($EM1_EmployeeID_pk);
        //'This sub enables or disable controls, performed by locking the form
	$ObjectCurrentUser = \Session::get('current_user');
       
        $formLock       =   \Controller_Form::FormLock($Employees['EM1_Username'], $ObjectCurrentUser['CanChangeEmployeeRecords']);
     
        $topic      = $Employees['EM1_Title'].' '.$Employees['EM1_Initials_unq'].' '.$Employees['EM1_Fname'].' '.$Employees['EM1_Lname_ind']; 
        $email      = $Employees['EM1_Email'];
        
    	$titles           = $employee->get_title();
        $employee_types   =  $employee->get_employee_type();
        $sites            = $employee->get_employee_sites();
        
    	$branch 	= $employee->emp_dropdown_branch();
    	$section 	= $employee->emp_dropdown_section();
    	$project 	= $employee->emp_dropdown_project();
    	$area 		= $employee->emp_dropdown_area();
        
        $fs = \Fieldset::forge('employee_form');
        $fs->set_config('form_attributes', array('enctype' => 'multipart/form-data'));
        $fs->add('title', 'Title  :', array('options' => $titles, $formLock['AdminEdit'], 'type'=>$formLock['Admintype'], 'class' => 'select-1', 'value' => $Employees['EM1_Title']), array(array($formLock['AdminRequired'])));
        $fs->add('initials', 'Initials  :', array('type' => 'text',$formLock['AdminEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Initials_unq'] ), array(array($formLock['AdminRequired'])));
        $fs->add('fname', 'First Name  :', array('type' => 'text',$formLock['AdminEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Fname']));
        $fs->add('lname', 'Last Name  :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Lname_ind']), array(array($formLock['AdminUserRequired'])));
        $fs->add('postion1', 'Position 1 :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_PositionDescriptor1']), array(array($formLock['AdminUserRequired'])));
        $fs->add('postion2', 'Position 2 :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_PositionDescriptor2']));
        $fs->add('postion3', 'Position 3 :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_PositionDescriptor3']));
        $fs->add('phone', 'Phone :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Phone']));
        $fs->add('mobile', 'Mobile :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Mobile']));
        $fs->add('fax', 'Fax :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Fax']));
        $fs->add('email', 'Email :', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-2', 'style' => 'float:left;', 'value' => $Employees['EM1_Email']), array(array($formLock['AdminUserRequired'])));
        $fs->add('username', 'User Name :', array('type' => 'text', $formLock['AdminEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Username']), array(array($formLock['AdminRequired'])));
        $fs->add('currency', 'Currency Status:', array('options'=> array('CURRENT' => 'CURRENT', 'OBSOLETE' => 'OBSOLETE'), 'type'=>$formLock['Admintype'],  $formLock['AdminEdit'], 'class' => 'select-1', 'value' => $Employees['EM1_CurrencyStatus']));
        $fs->add('employment', 'Employment type:', array('type'=>$formLock['Admintype'], $formLock['AdminEdit'], 'class' => 'select-1', 'options'=> $employee_types, 'value' => $Employees['EM1_EmploymentType']), array(array($formLock['AdminRequired'])));
        $fs->add('site', 'Site:', array('type'=>$formLock['Admintype'], $formLock['AdminEdit'], 'class' => 'select-1', 'options' =>  $sites,  'value' => $Employees['EM1_SD_SiteName_fk']), array(array($formLock['AdminRequired'])));
        $fs->add('room', 'Room:', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textbox-1', 'value' => $Employees['EM1_Room']));
        $fs->add('comments', 'Comments:', array('type' => 'text', $formLock['AdminUserEdit'], 'class' => 'textarea-1', 'value' => $Employees['EM1_Comments']));
        $fs->add('image', 'Image', array('type' => 'file', $formLock['AdminUserEdit']));
	$fs->add('resetpass', 'resetpass:', array('type' => 'button', $formLock['AdminUserButtonFunction'],  'class' => 'button1', 'value' => 'RESET PASSWORD', 'onclick'=>"javascript:$.fn.colorbox({width:'60%', height:'60%', iframe:true, href:'". \Uri::create('employees/reset_password/'.$EM1_EmployeeID_pk) ."'});"));
	$fs->add('resetrole', 'resetrole:', array('type' => 'button', $formLock['AdminButtonFunction'],  'class' => 'button1', 'value' => 'RESET ROLES', 'onclick'=>"javascript:$.fn.colorbox({width:'60%', height:'60%', iframe:true, href:'". \Uri::create('employees/reset_user_roles/'.$EM1_EmployeeID_pk) ."'});"));
	$fs->add('save', 'save', array('type'=>'submit',  $formLock['AdminUserButtonFunction'], 'value'=>'SAVE', 'class'=>'button1'));
        
        $options = array(
            1 => 'Unlocked',
        );

        $fs->add('quick_quote', '', array('type' => 'checkbox', $formLock['AdminUserEdit'], 'value' => $Employees['EM1_QuickQuoteEnable'],      'options' => array(1=>'')));
        $fs->add('chk_branch',  '', array('type' => 'checkbox', $formLock['AdminUserEdit'], 'value' => $Employees['EM1_BranchPrefChangeable'],  'options' => $options));
        $fs->add('chk_section', '', array('type' => 'checkbox', $formLock['AdminUserEdit'], 'value' => $Employees['EM1_SectionPrefChangeable'], 'options' => $options ));
        $fs->add('chk_project', '', array('type' => 'checkbox', $formLock['AdminUserEdit'], 'value' => $Employees['EM1_ProjectPrefChangeable'], 'options' => $options));
        $fs->add('chk_area',    '', array('type' => 'checkbox', $formLock['AdminUserEdit'], 'value' => $Employees['EM1_AreaPrefChangeable'],    'options' => $options));

        $fs->add('branch',  'Branch:',  array('type'=>$formLock['AdminUserType'], $formLock['AdminUserEdit'], 'class' => 'select-1', 'options' =>  $branch,     'value' => $Employees['EM1_BranchPreference'] ));
        $fs->add('section', 'Section:', array('type'=>$formLock['AdminUserType'], $formLock['AdminUserEdit'], 'class' => 'select-1', 'options' =>  $section,    'value' => $Employees['EM1_SectionPreference'] ));
        $fs->add('project', 'Project:', array('type'=>$formLock['AdminUserType'], $formLock['AdminUserEdit'], 'class' => 'select-1', 'options' =>  $project,    'value' => $Employees['EM1_ProjectPreference'] ));
        $fs->add('area',    'Area:',    array('type'=>$formLock['AdminUserType'], $formLock['AdminUserEdit'], 'class' => 'select-1', 'options' =>  $area,       'value' => $Employees['EM1_AreaPreference'] ));

        
        if ($fs->validation()->run()) {
	      
            $fields = $fs->validated();
            
            $chkQuote   = isset( $fields['quick_quote'] ) ? '1' : '0';
            $chkBranch  = isset( $fields['chk_branch'] ) ? '1' : '0';
            $chkSection = isset( $fields['chk_section'] ) ? '1' : '0';
            $chkProject = isset( $fields['chk_project'] ) ? '1' : '0';
            $chkArea    = isset( $fields['chk_area'] ) ? '1' : '0';
			
           
            $data = array(
                            'EM1_Title' => $fields['title'],
                            'EM1_Fname' => $fields['fname'],
                            'EM1_Lname_ind' => $fields['lname'],
                            'EM1_Initials_unq' => $fields['initials'],
                            'EM1_Phone' => $fields['phone'],
                            'EM1_Mobile' => $fields['mobile'],
                            'EM1_Fax' => $fields['fax'],
                            'EM1_Email' => $fields['email'],
                            'EM1_Username' => $fields['username'],
                            'EM1_Room' => $fields['room'],
                            'EM1_EmploymentType' => $fields['employment'],
                            'EM1_CurrencyStatus' => $fields['currency'],
                            'EM1_Comments' => $fields['comments'],
                            'EM1_QuickQuoteEnable' => $chkQuote,
                            'EM1_BranchPrefChangeable' => $chkBranch,
                            'EM1_SectionPrefChangeable' => $chkSection,
                            'EM1_ProjectPrefChangeable' => $chkProject,
                            'EM1_AreaPrefChangeable' => $chkArea,
                            'EM1_PositionDescriptor1' => $fields['postion1'],
                            'EM1_PositionDescriptor2' => $fields['postion2'],
                            'EM1_PositionDescriptor3' => $fields['postion3']         
                        );
		
            
            //image upload
            try {
                
                $file = \Nmi_File::upload_file('image', \Config::get('profile_image_path'), array('new_name' => $Employees['EM1_Username'], 'overwrite' => true), true);
                $data['EM1_ImagePath'] = $file['saved_as'];
				

            } catch (\NMIUploadException $e) {

                \Message::set('error', $e->getMessage());
            
            }

            \Nmi_Db::update('t_Employee1', $data, array('EM1_EmployeeID_pk' => $EM1_EmployeeID_pk));
            \Message::set('success', 'Employee updated.');
             echo "<script type='text/javascript'>parent.jQuery.fn.colorbox.close();</script>";
            //\Response::redirect('employees/edit/'.$EM1_EmployeeID_pk);
            
        } else {
           
            \Message::set('error', $fs->validation()->error());
        }
        
        //$this->set_iframe_template('employee_form');
        
        $view = \View::forge('employee_form');
        $form = \Input::get('form');
        if($form!=''){$this->set_iframe_template('employee_form');}
        $view->set('form', $fs->form(), false);
        $view->set('topic', $topic, false);
        $view->set('email', $email, false);
        $view->profile_image = \Uri::base(false)."uploads/profile_pics/{$Employees['EM1_ImagePath']}";
        $this->template->content = $view;
    }
	
	function action_reset_password($EM1_EmployeeID_pk)
	{
		//$inputs	=	\Input::all();
		//$EM1_EmployeeID_pk = $inputs['EM1_EmployeeID_pk'];
                $ObjectCurrentUser = \Session::get('current_user');
		$employee 	= new Model_Employee;
                $Employees  = $employee->get_employee($EM1_EmployeeID_pk);
		$UserRoleInfo  = $employee->get_user_role_info($Employees['EM1_Username']); // print_r($UserRoleInfo); exit;
		$formLock       =   \Controller_Form::FormLock($Employees['EM1_Username'], $ObjectCurrentUser['CanChangeEmployeeRecords']);

        
                $topic      = $Employees['EM1_Title'].' '.$Employees['EM1_Initials_unq'].' '.$Employees['EM1_Fname'].' '.$Employees['EM1_Lname_ind']; 
                $email      = $Employees['EM1_Email'];
		
		$fs = \Fieldset::forge('emp_reset_pass');
		$fs->add('resetpass', 'resetpass  :', array('type' => 'password', 'class' => 'textbox-1'), array(array('required')));
		$fs->add('cancel', 'cancel:', array('type' => 'button', $formLock['AdminUserEdit'], 'class' => 'button1', 'value' => 'cancel / close', 'onclick'=>"javascript:parent.$.fn.colorbox.close()"));
		$fs->add('save', 'save', array('type'=>'submit',  $formLock['AdminUserButtonFunction'], 'value'=>'SAVE', 'class'=>'button1'));
				
		if ($fs->validation()->run()) {
			
			$fields = $fs->validated();

			$data = array(
				'EM1_Password'=>md5($fields['resetpass'])
				);
		try{
			\Nmi_Db::update('t_Employee1', $data, array('EM1_EmployeeID_pk' => $EM1_EmployeeID_pk));
	
		}catch(\PDOException $e) {
				\Log::error($e->getMessage());
				 \Message::set('error',$e->getMessage() );
                
         }    
		 
			\Message::set('success', 'Employee updated.');
		echo "<script>parent.$.fn.colorbox.close(); </script>";
			//\Response::redirect('employees/edit/'.$EM1_EmployeeID_pk);
		}
		$view = \View::forge('emp_reset_pass');
		$this->set_iframe_template('emp_reset_pass');
		$view->set('form', $fs->form(), false);
		$view->set('topic', $topic, false);
                $view->set('email', $email, false);
		$view->profile_image = \Uri::base(false)."uploads/profile_pics/{$Employees['EM1_ImagePath']}";
                $this->template->content = $view;
	}
	

	
	
	
	
	function action_reset_user_roles($EM1_EmployeeID_pk)
	{
		//$inputs	=	\Input::all();
		//$EM1_EmployeeID_pk = $inputs['EM1_EmployeeID_pk'];
                $ObjectCurrentUser = \Session::get('current_user');
		$employee 	= new Model_Employee;
                $Employees  = $employee->get_employee($EM1_EmployeeID_pk);
		$UserRoleInfo  = $employee->get_user_role_info($Employees['EM1_Username']); // print_r($UserRoleInfo); exit;
		$db_roles=	$employee->get_db_role_info();
		
		$formLock       =   \Controller_Form::FormLock($Employees['EM1_Username'], $ObjectCurrentUser['CanChangeEmployeeRecords']);
		
		$db_roles	=	\Arr::filter_keys($db_roles, array('public', 'db_owner', 'db_accessadmin','db_securityadmin','db_ddladmin','db_backupoperator','db_datareader','db_datawriter','db_denydatareader','db_denydatawriter'),true);
        
        $topic      = $Employees['EM1_Title'].' '.$Employees['EM1_Initials_unq'].' '.$Employees['EM1_Fname'].' '.$Employees['EM1_Lname_ind']; 
        $email      = $Employees['EM1_Email'];
		
		$fs = \Fieldset::forge('emp_reset_pass');
		$fs->add('cancel', 'cancel:', array('type' => 'button', 'class' => 'button1', 'value' => 'cancel / close', 'onclick'=>"javascript:parent.$.fn.colorbox.close()"));
		$fs->add('chk_role',  '', array('type' => 'checkbox', $formLock['AdminButtonFunction'], 'value'=> $UserRoleInfo, 'options' => $db_roles));
		$fs->add('save', 'save', array('type'=>'submit',  $formLock['AdminButtonFunction'], 'value'=>'SAVE', 'class'=>'button1'));
		
		if ($fs->validation()->run()) {
			
			$fields = $fs->validated();
			if($formLock['AdminEdit']=='')
			{
				//Make Array Roles accoding to SP
				$roleArray	=	'';
				$i = 0;
				foreach ($fields['chk_role']as $a) {
					$i++;
					$roleArray .=  $a ;
					if(count($fields['chk_role'])>$i){
						$roleArray .=  ',' ;
					}
				}
				
				//Make Array Roles accoding to SP
				$AllRoles	=	'';
				$i = 0;
				foreach ($db_roles as $s) {
					$i++;
					$AllRoles .=  $s ;
					if(count($db_roles)>$i){
						$AllRoles .=  ',' ;
					}
				}
			}

		try{
			
			$EmployeeMod 	= new Model_Employee;
			if($formLock['AdminEdit']=='')
			{
				//rest roles
				$rest_roles_remove = $EmployeeMod->rest_user_roles_remove($AllRoles,$Employees['EM1_Username']);
				$rest_roles_update = $EmployeeMod->rest_user_roles_update($roleArray,$Employees['EM1_Username']);
			}
			
		}catch(\PDOException $e) {
				\Log::error($e->getMessage());
				 \Message::set('error',$e->getMessage() );
         }    
		 
			\Message::set('success', 'Employee role updated.');
			echo "<script>parent.$.fn.colorbox.close(); </script>";
		}
		$view = \View::forge('employee_reset_roles');
		$this->set_iframe_template('employee_reset_roles');
		$view->set('form', $fs->form(), false);
		$view->set('topic', $topic, false);
        $view->set('email', $email, false);
		$view->profile_image = \Uri::base(false)."uploads/profile_pics/{$Employees['EM1_ImagePath']}";
        $this->template->content = $view;
	}
	

    /**
     * New Employee
     * @return [type] [description]
     */
    function action_new_employee()
    {
        $view   = \View::forge('insert_new_employee');
        $titles = Model_Employee::get_title();
        $initials = Model_Employee::get_initials();
		$db_roles=	Model_Employee::get_db_role_info(); //print_r($db_roles);exit;
		$db_roles	=	\Arr::filter_keys($db_roles, array('public', 'db_owner', 'db_accessadmin','db_securityadmin','db_ddladmin','db_backupoperator','db_datareader','db_datawriter','db_denydatareader','db_denydatawriter'),true);
		
		$options = array(
            1 => 1,
			0 => 0,
        );

        $fs = \Fieldset::forge('new_employee');
        $fs->add('title', 'title :', array('type' => 'select', 'class' => 'select-1', 'options' => $titles ), array(array('required')));
        $fs->add('fname', 'fname  :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')));
        $fs->add('lname', 'lname  :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')));
        $fs->add('initials', 'initials  :', array('type' => 'select', 'class' => 'select-1', 'options' => $initials ), array(array('required')));
        $fs->add('position', 'position  :', array('type' => 'text', 'class' => 'textbox-2'), array(array('required')));
        $fs->add('phone', 'phone  :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')));
		//$fs->add('email', 'email  :', 'match_value[me@mydomain.com,1]|valid_email');
        $fs->add('email', 'email  :', array('type' => 'text', 'id'=>'email', 'onchange'=>'emailcheck()', 'class' => 'textbox-2'), array(array('required'), array('valid_email')));
		$fs->add('userrole',  'userrole:',  array('type' => 'select', 'class' => 'select-1', 'options' => $db_roles));
        $fs->add('uname', 'uname  :', array('type' => 'text', 'onchange'=>'check_user_id()', 'id'=>'txt_uname', 'class' => 'textbox-1'), array(array('required', 'trim', 'spaces','punctuation','dashes','valid_string[alpha,lowercase,numeric]')));
		$fs->add('password', 'password  :', array('type' => 'password', 'class' => 'textbox-1'), array(array('required')));
        $fs->add('submit', 'submit   :', array('type' => 'submit', 'value' => 'insert',   'class'   => 'button2'));
		foreach($db_roles as $u){
			$fs->add('chk_role',  '', array('type' => 'checkbox', 'value' => $u[$u],  'options' => $db_roles));
		}
		

        
        if ($fs->validation()->run()) { 
	   
            $fields = $fs->validated();
            try {
				 
                $employee_id = NULL;

			//Make Array Roles accoding to SP
			$roleArray	=	'';
			$i = 0;
			foreach ($fields['chk_role']as $a) {
				$i++;
				$roleArray .=  $a ;
				if(count($fields['chk_role'])>$i){
					$roleArray .=  ',' ;
				}
			}
				

                $stmt = $this->db->prepare("EXEC sp_insert_into_t_Employee1 @EM1_Title=?, @EM1_Fname=?, @EM1_Lname_ind=?, @EM1_Initials_unq=?, @EM1_PositionDescriptor1=?, @EM1_Phone=?,@EM1_Email=?,@EM1_Username=?,@EM1_Password=?,@EM1_EmployeeID_pk=?,@EM_QUERY=?");
                $stmt->bindValue(1, $fields['title']);
                $stmt->bindValue(2, $fields['fname']);
                $stmt->bindValue(3, $fields['lname']);
                $stmt->bindValue(4, $fields['initials']);
                $stmt->bindValue(5, $fields['position']);
                $stmt->bindValue(6, $fields['phone']);
                $stmt->bindValue(7, $fields['email']);
                $stmt->bindValue(8, $fields['uname']);
				 $stmt->bindValue(9, md5($fields['password']));
                $stmt->bindParam(10, $employee_id, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 10);

				$stmt->bindValue(11, '');
                $stmt->execute();

                $results = array();
				
				$EmployeeMod 	= new Model_Employee;
				//rest roles
				$rest_roles_update = $EmployeeMod->rest_user_roles_update($roleArray,$fields['uname']);
				\Message::set('success', 'Inserted new employee .');
				echo "<script>parent.$.fn.colorbox.close(); </script>";


            } catch(\PDOException $e) {
                die($e->getMessage());
            }            
           
        }else {
           
            \Message::set('error', $fs->validation()->error());
		}
		//$view = \View::forge('insert_new_employee');
        $this->set_iframe_template('insert_new_employee');
        $this->template->content = $view;
        $view->set('form', $fs->form(), false);
	    $this->template->content = $view;
    }
    
     /**
     * Parse the data from data grid fields and generate a Model_ instance, used for listing grid and, excel export
     * @return [type] [description]
     */
    function generate_listing()
    {
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

        if (\Input::get('iSortCol_0') == 1) {
           $order_by['column'] = 'LastName';
        }

        if (\Input::get('iSortCol_0') == 4) {
            $order_by['column'] = 'Site';
        }
        
        $order_by['sort'] = \Input::get('sSortDir_0');

        $global_search = \Input::get('sSearch');
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::param('iDisplayLength', 10);
        $no_of_columns = \Input::get('iColumns');
        $offset        = \Input::get('iDisplayStart', 0);
        
        $listing = new Model_Employee;
        $listing->limit  = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        if(!empty($advance_search_fields)){
             $listing->search_criteria = $advance_search_fields;
        
        }
       

        return $listing;
    }
	
	
	function action_check_emp_id($EM1_Username){
		$sql	= " SELECT EM1_Username FROM t_Employee1 WHERE EM1_Username = ? ";
		$stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $EM1_Username);
        $stmt->execute();
		$rows = $stmt->fetchAll();
		if(count($rows)>0){
			echo 1;
		}else{
			echo 0;
		}
		exit;
	}
}

