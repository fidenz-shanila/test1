<?php

namespace Artefacts;

class Subform_Owner extends \Subform
{
	protected $prefix = 'artefact_owner';
	protected $view   = 'Artefacts::owner';
       

	function render( $params = array() )
	{
		$quote_id = \Input::get('quote_id');
                $artifact = \Artefacts\Model_Artefact::get_owner($quote_id);
                
                    if($artifact['OR1_InternalOrExternal']=='EXTERNAL'){
                         $url =   \Uri::create('contacts/edit/'.$artifact['A_ContactID'].'?form=form'); 
                    }  else {
                         $url =   \Uri::create('employees/edit/'.$artifact['A_ContactID'].'?form=form'); 
                    }
               

		$this->fields = array(
			'OR1_FullName' 	     => array('type'=>'textarea', 'class' => 'textarea-1', 'disabled' => 'disabled'),
			'ContactName' 	     => array('class'=>'textbox-1', 'disabled' => 'disabled'),
			'A_YearSeq_pk'       => array('type' => 'hidden', 'value' => $quote_id),
			'buttonContact'        => array('type' => 'button', 'class'=>"cb iframe button1", 'href' =>$url,'value' => '..')
		);
		
		

		$this->populate($artifact);
		
		$view           	  = $this->get_view();
		$view->A_ContactID    = $artifact['A_ContactID'];

        return parent::render();
	}
	
	
}
/* eof */