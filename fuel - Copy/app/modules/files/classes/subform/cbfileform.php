<?php

namespace Files;

class Subform_cbfileform extends \Subform
{
	protected $prefix = 'files';
	
    protected $view   = 'Files::cb_file_form';

	//TODO :- set CF_FileNumber_pk id
	function render( $params = array() )
	{
		$cb_file_id = \Input::get('CF_FileNumber_pk');
		$cb_file_info		   = Model_File::get_cb_file($cb_file_id);//print_r($cb_file_info);//exit;

                
		//set initial fields
		$this->fields = array(
			'CF_Title' 		 => array('class' => 'textarea-1', 'type' => 'textarea'),
			'CF_FileLocation'    	 => array('class' => 'textbox-1', 'id'=>'CF_FileLocation','readonly'=>'readonly',),
			'CF_FileRequestLocation' => array('class' => 'textbox-1', 'id'=>'CF_FileRequestLocation','readonly'=>'readonly',),
			'CF_FileLocationDate'    => array('class' => 'date_picker','id'=>"datepicker_file_loaction_date",'readonly'=>'readonly',),
			'CF_FileRequestDate'   	 => array('class' => 'date_picker','id'=>"datepicker_file_request_date",'readonly'=>'readonly',),
			'CF_DirectoryPath'       => array('class' => 'textarea-1'),
			'CF_FileNumber_pk'		 => array('type'=>'hidden')
		);

        $this->populate($cb_file_info);

		$view           			= $this->get_view();
		$view->cb_file 		  		= $cb_file_info;
                $view->cb_file_content                  = Model_File::get_cb_file_content_list($cb_file_id);
		$view->CF_FileNumber_pk     = $cb_file_id;
		//$this->template->content = $view;
		
	    return parent::render();
	}
	
	function update($fields)
	{
            
		\NMI_DB::update('t_CbFile', array(
			'CF_Title'			 => $fields['CF_Title'],
			'CF_FileLocation'               => $fields['CF_FileLocation'],
			'CF_FileRequestLocation'	 => $fields['CF_FileRequestLocation'],
			'CF_FileLocationDate'		 => $fields['CF_FileLocationDate'],
			'CF_FileRequestDate'		 => $fields['CF_FileRequestDate'],
			'CF_DirectoryPath'              => $fields['CF_DirectoryPath'],
		),
				
		array('CF_FileNumber_pk' => $fields['CF_FileNumber_pk']));
		
		//\Response::redirect('files/list_quote_files/?CF_FileNumber_pk=' .  $fields['CF_FileNumber_pk']);
                
	}
	
	
	
	
}
/* eof */