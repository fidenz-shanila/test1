<?php

namespace Admins;

class Controller_Admins extends \Controller_Base
{

    function action_index()
    {
        $view = \View::forge('home');
        $this->template->body_classes = array('clr_contact');
        $this->template->content = $view;
    }
    
    /**
     * Category listing
     * @return [type] [description]
     */
    function action_contact_categories()
    {
        $this->set_iframe_template('insert-conact-catergories');
        $view = \View::forge('conact_catergories');
		$view->set('sort_order',Model_Admin::get_contact_categories(), false);
        $this->template->content = $view;
    }
    
    /**
     * Contact category update
     */
    function action_update_conact_catergory()
    {
     	$id =  \Input::param('element_id'); 
		$cat_name =  \Input::param('update_value'); 
		Model_Admin::update_contact_category($id, $cat_name);
		echo $cat_name;
        exit;
    }

    /**
     * New category
     */
    function action_insert_conact_catergories()
    {
        $this->set_iframe_template('insert-conact-catergories');
        $view = \View::forge('insert_conact_catergories');
		$sort_order = Model_Admin::get_contact_categories();
		$sort_order_options = array('' => '');
		foreach ($sort_order as $sort_order_item) 
		{
			$sort_order_options[$sort_order_item['COC_Code_ind']] = $sort_order_item['COC_Code_ind'].' ('.$sort_order_item['COC_Name'].')';
		}
		
		$fs = \Fieldset::forge('insert_work_group');
        $fs->add('sort_order', 'Sort Order', array('type' => 'select', 'class' => 'select-1', 'options' => $sort_order_options, 'id' => 'work_projects'));
		$fs->add('sort_order_value', 'Category Order', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));
		$fs->add('category_name', 'Category Name', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));
		$fs->add('submit', 'Submit', array('type' => 'submit', 'value' => 'Insert', 'class' => 'button1'));
        
        if($fs->validation()->run())
	    {
            $fields = $fs->validated();
			
			$stmt = $this->db->prepare("EXEC sp_insert_into_t_ContactCategory @COC_Code_ind=?, @COC_Name=?");
			$stmt->bindValue(1, $fields['sort_order_value']);
			$stmt->bindValue(2, $fields['category_name']);
			$stmt->execute();
			
			\Response::redirect('admins/contact_categories');
		}
		
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    /**
     * Organizations category listing
     * @return [type] [description]
     */
    function action_organisation_catergories()
    {
        $this->set_iframe_template('insert_orga');
        $view = \View::forge('organisation_catergories');
		$view->set('sort_order',Model_Admin::get_organisation_categories(), false);
        $this->template->content = $view;
    }
    
    /**
     * Contact category update
     */
    function action_update_organisation_catergory()
    {
     	$id =  \Input::param('element_id'); 
		$cat_name =  \Input::param('update_value'); 
		Model_Admin::update_organisation_category($id, $cat_name);
		echo $cat_name;
        exit;
    }
    
	/**
     * New organisation category
     */
    function action_insert_organisation_cats()
    {
        $this->set_iframe_template('insert_orga');
    	$view = \View::forge('insert_organisation_cats');
	$sort_order = Model_Admin::get_organisation_categories();
	$sort_order_options = array('' => '');
	foreach ($sort_order as $sort_order_item) 
	{
	    $sort_order_options[$sort_order_item['ORGC_Code_ind']] = $sort_order_item['ORGC_Code_ind'].' ('.$sort_order_item['ORGC_Name'].')';
	}
	
	$fs = \Fieldset::forge('insert_work_group');
	$fs->add('sort_order', 'Sort Order', array('type' => 'select', 'class' => 'select-1', 'options' => $sort_order_options, 'id' => 'work_projects'));
	$fs->add('sort_order_value', 'Organisation Order', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));
	$fs->add('organisation_name', 'Organisation Name', array('type' => 'text', 'class' => 'textbox-1' ), array(array('required')));
	$fs->add('submit', 'Submit', array('type' => 'submit', 'value' => 'Insert', 'class' => 'button1'));
        
        if($fs->validation()->run())
	    {
            $fields = $fs->validated();
			
		$stmt = $this->db->prepare("EXEC sp_insert_into_t_OrganisationCategory @ORGC_Code_ind=?, @ORGC_Name=?");
		$stmt->bindValue(1, $fields['sort_order_value']);
		$stmt->bindValue(2, $fields['organisation_name']);
		$stmt->execute();
		
		\Response::redirect('admins/organisation_catergories');
	    }
		
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    function action_manage_signs()
    {
        $this->set_iframe_template('insert-conact');
    	$view = \View::forge('manage_signs');
		$view->set('staff', Model_Manager::get_staff(), false);
		$view->set('nmi', Model_Manager::get_nmi_signatories(), false);
		$view->set('nata', Model_Manager::get_nata_signatories(), false);
    	$this->template->content = $view;
    }
	
	function action_manage_sign()
	{
		$s_mode 			= \Input::param('s_mode');
		$b_is_signatory 	= \Input::param('b_is_signatory');
		$iEM1_EmployeeID_pk = \Input::param('iEM1_EmployeeID_pk');
		
		$signatory = array('s_mode' => $s_mode, 'b_is_signatory' => $b_is_signatory, 'iEM1_EmployeeID_pk' => $iEM1_EmployeeID_pk );
		
		$manager = new Model_Manager;
		$manager->signatory = $signatory;
		$manager->add_or_remove_signatory();
		\Message::set('success', 'Operation success');
		
	}
    
    function action_site_details_listing()
    {
		$details = Model_Admin::site_detail_listing();
        $this->set_iframe_template('site_detail');
    	$view = \View::forge('site_details_listing');
		$view->set('details', $details, false);
    	$this->template->content = $view;
    }
    
    function action_add_new_details()
    {
	$fs = \Fieldset::forge('site_detail_add_new');
	$fs->add('site_name', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Site Detail'));
	$fs->add('physical_addess_1', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Physical Address 1'));
	$fs->add('physical_addess_2', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Physical Address 2'));
	$fs->add('physical_addess_3', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Physical Address 3'));
	$fs->add('postal_addess_1', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Postal Address 1'));
	$fs->add('postal_addess_2', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Postal Address 2'));
	$fs->add('postal_addess_3', '', array('type' => 'text', 'class' => 'textbox-1', 'placeholder' => 'Postal Address 3'));
	$fs->add('main_phone', '', array('type' => 'text', 'class' => 'textbox-1'));
	$fs->add('main_fax', '', array('type' => 'text', 'class' => 'textbox-1'));
	$fs->add('quote', '', array('type' => 'text', 'class' => 'textbox-1'));

	if($fs->validation()->run())
	{
            $fields = $fs->validated();
	    
	    $data = array();
	    foreach ( $fields as $fld )
	    {
		$data[] = $fld;
	    }
	    
	    if (Model_Admin::add_site_detail($data)) {
			 \Message::set('success', 'Site detail added');
		}else{
			\Message::set('error', 'Insert failed');
		}
	
	}else{
	    \Message::set('error', $fs->validation()->error());
            $fs->repopulate();
	}
       
        $this->set_iframe_template('site_detail');
    	$view = \View::forge('site_detail_add_new');
		$view->set('form', $fs->form(), false);
    	$this->template->content = $view;
    }
	
	function action_file_storage_locations()
	{
		$storage = Model_Admin::view_file_storage_table();
		$this->set_iframe_template('storage');
    	$view = \View::forge('storage');
		$view->set('storage', $storage, false);
    	$this->template->content = $view;
		
	}
	
	function action_certificates_offered()
	{
		$certificates = Model_Admin::view_certificates_offered_table();
		$this->set_iframe_template('certificates');
    	$view = \View::forge('certificates');
		$view->set('certificates', $certificates, false);
    	$this->template->content = $view;
		
	}
}