<?php
/**
 * Mini worklog area in header of main form
 */

namespace Quotes;

class Subform_Worksub extends \Subform
{
	protected $prefix = 'artefact_work';
	protected $view = 'Quotes::subform/worksub';

	function render( $params = array() )
	{
		$work_log = \Quotes\Model_Quote::get_worklog(\Input::get('quote_id'));
		$employees = \Quotes\Model_Quote::work_sub_test_officers();

		$view = $this->get_view();
		$view->set('work_log', $work_log, false);
		$view->set('employees', $employees, false);

		return parent::render();
	}

}
/* eof */