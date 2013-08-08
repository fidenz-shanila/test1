<?php

namespace Quotes;

class Subform_Work extends \Subform
{
	protected $prefix = 'quote_work';
	protected $view = 'Quotes::subform/work';

	function render( $params = array() )
	{
		$work_log = \Quotes\Model_Quote::get_worklog($params['quote_id']);
                $quote    = \Quotes\Model_Quote::get_quote($params['quote_id']);
                $lock      = \Controller_Form::OfficeFormLock($quote['Q_LockForm']);
                
                $this->fields=  array(
                        'BtnDelete' => array('type'=>"button",$lock['AdminEdit'], 'class'=>"button1 cb iframe delete_workgroup", 'href'=> \Uri::create("quotes/delete_workgroup/" . $work_log[0]['WDB_WorkDoneBy_pk']), 'value'=>"DELETE"),
                        'BuildEditPrice' => array('type'=>'button',$lock['AdminEdit'],'class'=>"cb iframe", 'href'=>\Uri::create("quotes/build_quote_price/".$work_log[0]['WDB_WorkDoneBy_pk']), 'value'=>'Build/Edit Price')
                        );

		$view = $this->get_view();
		$view->set('work_log', $work_log, false);
                $view->set('lock', $lock);

		return parent::render();
	}

}
/* eof */