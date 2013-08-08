<?php

namespace Files;

class Subform_cbfilelocation extends \Subform
{
	protected $prefix = 'files';
	
    protected $view   = 'Files::file_location_form';

	//TODO :- set CF_FileNumber_pk id
	function render( $params = array() )
	{
		$cb_file_id 		   = \Input::get('CF_FileNumber_pk');
		$cb_file_info		   = Model_File::get_cb_file($cb_file_id);//print_r($cb_file_info);exit;
		$options				=	Model_File::get_cb_location_list(); 

                
		//set initial fields
		$this->fields = array(
			'CF_FileLocation'                 => array('class' => 'textarea-1', 'type' => 'select', 'id'=>'CF_FileLocation', 'options'=>Model_File::get_cb_location_list()),
			'CF_FileRequestLocation'    	  => array('class' => 'textarea-1', 'type' => 'select', 'id'=>'CF_FileRequestLocation', 'options'=>Model_File::get_cb_location_list()),
			'CF_FileLocationDate'             => array('class' => 'date_picker','id'=>"datepicker_file_loaction_date"),
			'CF_FileRequestDate'              => array('class' => 'date_picker','id'=>"datepicker_file_request_date"),
			'CF_DirectoryPath'      	 => array('class' => 'textarea-1'),
		);

        $this->populate($cb_file_info);

		$view           			= $this->get_view();
		$view->cb_file 		  		= $cb_file_info;
                $view->cb_file_content          	= Model_File::get_cb_file_content_list($cb_file_id);
		$view->CF_FileNumber_pk                 = $cb_file_id;
		//$this->template->content = $view;
		
	    return parent::render();
	}
	

	
	
	
	
}
/* eof */