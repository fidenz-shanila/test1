<?php

namespace Quotes;

class Subform_Changetestofficer extends \Subform
{
	protected $prefix = 'change_test_officer';
	protected $view = 'Quotes::change_test_officer';

	function render( $params = array() )
	{ 
		//Get Test Officers List
		$get_test_officer 		= \Quotes\Model_Quote::get_test_officer_list($params['WDB_P_Name']); 
		$current_test	 		= \Quotes\Model_Quote::get_current_test_officer($params['WDB_TestOfficerEmployeeID']);
		
		//Create Form list
		$this->fields = array(
			'WDB_TestOfficerEmployeeID' 		 => array('class' => 'textarea-1', 'name'=>'WDB_TestOfficerEmployeeID', 'required'=>'required', 'id'=>'WDB_TestOfficerEmployeeID', 'type' => 'select', 'options'=>$get_test_officer),array(array('required')),
			'WDB_WorkDoneBy_pk' 		 => array('class' => 'textarea-1', 'name'=>'WDB_WorkDoneBy_pk', 'id'=>'WDB_WorkDoneBy_pk', 'type'=>'hidden','value'=>$params['WDB_WorkDoneBy_pk'])
		);
		
		$this->populate($current_test);
		 
		$view = $this->get_view();
		

		 return parent::render();
	}
	
	function update($fields)
	{
		$fields	=	$fields['change_test_officer'];
		\NMI_DB::update('t_WorkDoneBy', array(
			'WDB_TestOfficerEmployeeID'		 => $fields['WDB_TestOfficerEmployeeID']
		),
				
		array('WDB_WorkDoneBy_pk' => $fields['WDB_WorkDoneBy_pk']));
				
	}

}
/* eof */