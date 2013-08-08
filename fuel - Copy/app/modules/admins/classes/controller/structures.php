<?php

namespace Admins;

class Controller_Structures extends \Controller_Base
{
    function action_index()
    {
        
    }
    
    /**
     * NMI Branches
     * @param
     * @author Namal
     */ 
    function action_nmi_branches()
    {
        $this->set_iframe_template('nmi-branch');
        $view = \View::forge('structure/nmi_branches');
        $view->branches = Model_Structure::get_branches();
        $this->template->content = $view;
    }
    
    /**
     * Branch Form with section listing
     * @param
     * @author Namal
     */ 
    function action_branch_form()
    {
        $B_BranchID_pk =  \Input::param('B_BranchID_pk'); 
        $B_Name =  \Input::param('name'); 
        $this->set_iframe_template('branch_form nmi-branch');
        $view = \View::forge('structure/branch_form/branch_form');
        $view->set('sections', Model_Structure::get_sections($B_BranchID_pk), false);
        $view->set('name', $B_Name, false);
        $view->set('B_BranchID_pk', $B_BranchID_pk, false);
        $this->template->content = $view;
    }
    
    /*
     * Insert Branch
     * @param
     * @author Namal
     */ 
    
    function action_insert_branch()
    {
    	$fs = \Fieldset::forge('insert_branch');
    	$fs->add('branch', 'Branch :', array('type' => 'text', 'class' => 'textbox-1' ), array( array('required'), array('max_length', '80') ));
    	
    	if($fs->validation()->run())
        {
	    
    	    try
    	    {
        		$fields = $fs->validated();
        		$stmt = $this->db->prepare("sp_insert_into_t_Branch :B_Name_ind");
        		$stmt->bindValue(':B_Name_ind', $fields['branch']);
        		$stmt->execute();

                \Message::set('success', 'New branch added.');
                \Response::redirect('admins/structures/nmi_branches');
    	    }
    	    catch(Exception $e)
    	    {
                //$e->getMessage();
    	       \Message::set('error', 'An error occurred.');
            }
    	}
        else
        {
            \Message::set('error', $fs->validation()->error());
        }
	
        $this->set_iframe_template('nmi-branch');
        $view = \View::forge('structure/branch_form/insert_branch');
    	$view->set('form', $fs->form(), false);
    	$this->template->content = $view;
    }
    
    /*
     * Delete Branch
     * @author Namal
     * @param
     */ 
    public function action_delete_branch()
    {
        $B_BranchID_pk =  \Input::param('B_BranchID_pk'); 
        Model_Structure::delete_branch($B_BranchID_pk);
        \Message::set('success', 'Branch deleted.');
        \Response::redirect(\Uri::create('admins/structures/nmi_branches'), 'refresh');	
    }
    
    /*
     * Delete section in Branch Form
     * @param
     * @author Namal
     */ 
    function action_delete_section()
    {
        $S_SectionID_pk = (int) \Input::param('S_SectionID_pk');
        $B_BranchID_pk  =  \Input::param('B_BranchID_pk'); 
        $B_Name =  \Input::param('name');  
        Model_Structure::delete_section($S_SectionID_pk);
        \Message::set('success', 'Section deleted.');
        \Response::redirect(\Uri::create('admins/structures/branch_form?B_BranchID_pk='.$B_BranchID_pk.'&name='.urlencode($B_Name)), 'refresh');	
    }
    
    /*
     * Insert section in Brach form
     * @param
     * @author Namal
     */
    function action_insert_section()
    {
        $S_BranchID_fk = \Input::param('S_BranchID_fk');

        $fs = \Fieldset::forge('insert_section');
        $fs->add('section', 'Section :', array('type' => 'text', 'class' => 'textbox-1' ), array( array('required'), array('max_length', '80') ));
        $fs->add('S_BranchID_fk', 'S_BranchID_fk :', array('type' => 'hidden'))->set_value($S_BranchID_fk);
	
        if($fs->validation()->run())
        {
    	    try
    	    {
        		$fields = $fs->validated();
        		$stmt = $this->db->prepare("sp_insert_into_t_Section @S_Name_ind=?, @S_BranchID_fk=?");
        		$stmt->bindValue(1, $fields['section']);
        		$stmt->bindValue(2, $fields['S_BranchID_fk'], \PDO::PARAM_INT);
        		$stmt->execute();
                \Message::set('success', 'New section added.');
                \Response::redirect('admins/structures/branch_form?B_BranchID_pk='.$S_BranchID_fk);
    	    }
    	    catch(Exception $e)
    	    {
    	       \Message::set('error', 'An error occurred.');
            }
    	}
        else
        {
            \Message::set('error', $fs->validation()->error());
        }
	
        $this->set_iframe_template('nmi-branch');
        $view = \View::forge('structure/branch_form/insert_section');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    /*
     * Section form
     * @param
     * @author Namal
     */ 
    function action_section_form() 
    {
        $S_SectionID_pk = \Input::param('S_SectionID_pk');
        $Name = \Input::param('name');
        $s_code = \Input::param('s_code');
	
        $this->set_iframe_template('nmi-branch');
        $view = \View::forge('structure/branch_form/section_form/section_form');
        $view->projects = Model_Structure::get_projects($S_SectionID_pk);
        $view->staff = Model_Structure::get_staff();
        $view->S_SectionID_pk = $S_SectionID_pk;
        $view->name = $Name;
        $view->s_code = $s_code;
        $this->template->content = $view;
    }
    
    /**
     * Project Form
     * @param
     * @author Namal
     */ 
     function action_project_form()  
    {
        $name = \Input::param('name');
	$P_ProjectID_pk = \Input::param('P_ProjectID_pk');

        $this->set_iframe_template('project_form nmi-branch');
        $view = \View::forge('structure/branch_form/section_form/project_form/project_form');
        $view->set('name', $name, false);
        $view->set('areas', Model_Structure::get_area($P_ProjectID_pk), false);
        $view->set('staff', Model_Structure::get_staff(), false);
        $this->template->content = $view;
    }
    
     /**
     * Insert Project
     * @param
     * @author Namal
     */
    function action_insert_project() 
    {
        $S_SectionID_pk = \Input::param('S_SectionID_pk');

        $fs = \Fieldset::forge('insert_section');
        $fs->add('project', 'Project :', array('type' => 'text', 'class' => 'textbox-1' ), array( array('required'), array('max_length', '80') ));
        $fs->add('S_SectionID_pk', 'P_SectionID_fk :', array('type' => 'hidden'))->set_value($S_SectionID_pk);
	
        if($fs->validation()->run())
        {
    	    try
    	    {
        		$fields = $fs->validated();
        		
        		$stmt = $this->db->prepare("sp_insert_into_t_Project @P_Name_ind=?, @P_SectionID_fk=?");
        		$stmt->bindValue(1, $fields['project']);
        		$stmt->bindValue(2, $fields['S_SectionID_pk']);
        		$stmt->execute();
            
                \Message::set('success', 'New Project Added.');
                \Response::redirect("admins/structures/section_form?S_SectionID_pk={$S_SectionID_pk}&name=".urlencode($fields['project']));
            }
    	    catch(Exception $e)
    	    {
    	       \Message::set('error', 'An error occurred.');
            }
    	}
        else
        {
            \Message::set('error', $fs->validation()->error());
        }
	
        $this->set_iframe_template('insert_branch nmi-branch');
        $view = \View::forge('structure/branch_form/section_form/insert_project');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    /*
     * Delete project
     * @param
     * @author Namal
     */
    function action_delete_project()
    {
    	$P_ProjectID_pk = \Input::param('P_ProjectID_pk');
    	$S_SectionID_pk = \Input::param('S_SectionID_pk');
    	$name = \Input::param('name');
    	
    	Model_Structure::delete_project($P_ProjectID_pk);
    	\Message::set('success', 'Project deleted.');
        \Response::redirect(\Uri::create('admins/structures/section_form?S_SectionID_pk='.$S_SectionID_pk.'&name='.$name), 'refresh');	
    }
	
	function action_delete_staff()
	{
		$SE_SectionEmployeeID_pk = \Input::param('SE_SectionEmployeeID_pk');
		$S_SectionID_pk = \Input::param('S_SectionID_pk');
		$name = \Input::param('name');
		
		Model_Structure::delete_staff($SE_SectionEmployeeID_pk);
		\Message::set('success', 'Staff deleted.');
        \Response::redirect(\Uri::create('admins/structures/section_form?S_SectionID_pk='.$S_SectionID_pk.'&name='.$name), 'refresh');	
	}
    
    function action_employee_form()  
    {
        $this->set_iframe_template('employee_form');
        $view = \View::forge('structure/branch_form/section_form/employee_form');
        $this->template->content = $view;
    }
    
    function action_manage_staff_section_form() 
    {
	$employees = Model_Structure::get_staff_for_manage();
	$section_staff = Model_Structure::get_section_staff();

        $this->set_iframe_template('manage_staff');
        $view = \View::forge('structure/branch_form/section_form/manage_staff_section_form');
	$view->set('employees', $employees, false);
	$view->set('section_staff', $section_staff, false);
        $this->template->content = $view;
    }
    
    function action_add_staff()
    {
	
	$S_SectionID_pk = \Input::param('S_SectionID_pk');
	$SE_EmployeeID_fk = \Input::param('SE_EmployeeID_fk');
	
	$return = Model_Structure::add_staff($SE_EmployeeID_fk, $S_SectionID_pk);
	
	if($return == 0){
	    \Message::set('error', 'You can\'t assign this person twice. Operation cancelled.');
	}else{
	    \Message::set('success', 'Person added successfully.');
	}
	
    }
    
    function action_remove_section_staff()
    {
	$SE_SectionEmployeeID_pk = \Input::param('S_SectionID_pk');
	$return = Model_Structure::remove_section_staff($SE_SectionEmployeeID_pk);
	if($return){
	    \Message::set('success', 'Person removed successfully.');
	}
    }
    
    function action_insert_area()   
    {
        $this->set_iframe_template('insert_branch');
        $view = \View::forge('structure/branch_form/section_form/project_form/insert_area');
        $this->template->content = $view;
    }
    
    /*
     * Area Form
     * @author Namal
     */ 
    
    function action_area_form()  
    {
	$A_AreaID_pk = \Input::param('A_AreaID_pk');
	$A_Name_ind = \Input::param('A_Name_ind');
	
	$area = Model_Structure::get_fee($A_AreaID_pk);
	$selected_types = Model_Structure::get_selected_types($A_AreaID_pk);
	$available_types = Model_Structure::get_available_types();
	
        $this->set_iframe_template('area_form');
        $view = \View::forge('structure/branch_form/section_form/project_form/area_form/area_form');
	$view->set('area', $area, false );
	$view->set('A_Name_ind', $A_Name_ind, false );
	$view->set('selected_types', $selected_types, false );
	$view->set('available_types', $available_types, false );
	$view->set('A_AreaID_pk', $A_AreaID_pk, false );
        $this->template->content = $view;
    }
    
    /**
     * add to selected types from available types
     * @author Namal
     */
    public function action_add_selected_type()
    {
	$lstAvailableInstruments = \Input::param('lstAvailableInstruments');
	$A_AreaID_pk = \Input::param('A_AreaID_pk');
	
	Model_Structure::add_to_selected_type($lstAvailableInstruments, $A_AreaID_pk);
	
	$selected_types = Model_Structure::get_selected_types($A_AreaID_pk);
	
	//TODO, add the records with ajax. (an error occured)
	
	//echo json_encode($selected_types);
	//exit;
	
    }
    
    /**
     * Delete from selected types
     * @author Namal
     */
    public function action_delete_from_selected()
    {
	$AIT_AreaInstumentTypeID_pk = \Input::param('AIT_AreaInstumentTypeID_pk');
	
	$return = Model_Structure::delete_from_selected_types($AIT_AreaInstumentTypeID_pk);
	if($return){
	    \Message::set('success', 'Removed succefully');
	}
    }
    
    function action_edit_instrmunt_type_form() 
    {
        $this->set_iframe_template('nmi-branch');
        $view = \View::forge('structure/branch_form/section_form/project_form/area_form/edit_instrmunt_type_form');
        $this->template->content = $view;
    }
    
    /**
     * Edit available type
     * @author Namal
     */
    public function action_edit_available_type()
    {
	$IT_Name_ind = \Input::param('IT_Name_ind');
	$IT_InstrumentTypeID_pk = \Input::param('IT_InstrumentTypeID_pk');
	
	Model_Structure::edit_available_type($IT_Name_ind, $IT_InstrumentTypeID_pk);
	\Message::set('success', 'Type changes succefully');
	\Response::redirect(\Uri::create('admins/structures/area_form'), 'refresh');	
    }
    
    /**
     * Delete from available Instrument type
     * @author Namal
     */ 
    public function action_delete_available_type()
    {
	$IT_InstrumentTypeID_pk = \Input::param('IT_InstrumentTypeID_pk');
	echo Model_Structure::delete_available_type($IT_InstrumentTypeID_pk);
	exit;
    }
    
    /**
     * insert instrumetal type form and control
     * @author Namal
     */
    function action_insert_instrument_type_form() 
    {
	$A_AreaID_pk = \Input::param('A_AreaID_pk');
	
	$fs = \Fieldset::forge('insert_instrument_type_form');
        $fs->add('IT_Name_ind', 'New Type', array('type'=>'text', 'class' => 'textbox-1'), array( array('required'), array('numeric_max', '70') ));
        $fs->add('A_AreaID_pk', 'A_AreaID_pk', array('type'=>'hidden', 'class' => 'textbox-1', 'value' => $A_AreaID_pk ), array( array('required'), array('numeric_max', '70') ));
	
	if($fs->validation()->run() == true)
        {
	    $fields = $fs->validated();
	
	    $return = Model_Structure::insert_new_available_type($fields['IT_Name_ind']);
	    
	    //TODO, redirect error
	    if ($return)
	    {
		\Message::set('success', 'Type insert succefully');
		\Response::redirect(\Uri::create('admins/structures/area_form?A_AreaID_pk='.$fields['$A_AreaID_pk'] ), 'refresh');	
	    }
	}
	
	$this->set_iframe_template('edit_instrmunt');
        $view = \View::forge('structure/branch_form/section_form/project_form/area_form/insert_instrument_type_form');
	$view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    
    function action_insert_fee() 
    {
	$A_AreaID_pk = \Input::param('A_AreaID_pk');
	
        $this->set_iframe_template('insert_fee');
        $view = \View::forge('structure/branch_form/section_form/project_form/area_form/insert_fee');
	$view->set('A_AreaID_pk', $A_AreaID_pk, false);
        $this->template->content = $view;
    }
    
    /**
     * Inserting fees
     * @author Namal
     */ 
    
    function action_insert_fees()
    {
	$F_Code		 = \Input::param('F_Code');
	$F_Description 	 = \Input::param('F_Description');
	$F_Fee 		 = \Input::param('F_Fee');
	$F_AreaID_ind_fk = \Input::param('A_AreaID_pk');
	
	$return = Model_Structure::insert_fee($F_Code, $F_Description, $F_Fee, $F_AreaID_ind_fk);
	
	if ($return){
	    \Message::set('success', 'Fee added successfully.');
	}else{
	    \Message::set('error', 'Fee add failed.');
	}
	
	\Response::redirect(\Uri::create('admins/structures/insert_fee'), 'refresh');	
    }
    
    /**
     * Delete fee
     * @author Namal
     */
    public function action_delete_fee()
    {
	$F_FeeID_pk = \Input::param('F_FeeID_pk');
	$return     = Model_Structure::delete_fee($F_FeeID_pk);
	
	if ($return){
	    \Message::set('success', 'Fee deleted successfully.');
	}else{
	    \Message::set('error', 'Fee delete failed.');
	}
	
	\Response::redirect(\Uri::create('admins/structures/area_form'), 'refresh');
	
    }
    
    function action_manage_project_staff() 
    {
        $this->set_iframe_template('manage_staff');
        $view = \View::forge('structure/branch_form/section_form/project_form/manage_project_staff/manage_project_staff');
        $this->template->content = $view;
    }
    
}