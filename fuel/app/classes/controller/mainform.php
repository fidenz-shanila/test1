<?php
/**
 * TODO, Move to appropriate place
 */
class Controller_Mainform extends \Controller_Base
{
	function action_index()
	{	
		//full path to subform classes
		$subforms = array(
			\Artefacts\Subform_Description::forge(),
			\Artefacts\Subform_Owner::forge(),
			\Artefacts\Subform_File::forge(),
			\Quotes\Subform_Worksub::forge(),
			\Quotes\Subform_Quote::forge(),
                        \Receipts\Subform_Receipt::forge(),
                        \Jobs\Subform_Jobs::forge(),
                        \Invoices\Subform_Invoices::forge(),
                        \Files\Subform_Files::forge()
		);

		$vsubforms = array();
		foreach($subforms as $subform)
		{
			if(isset($vsubforms[$subform->get_prefix()]))
			{
				throw new \FuelException('Specified subform prefix already exists in subform test.');
			}
			$vsubforms[$subform->get_prefix()] = $subform->render(); 
		}

		//update
		if(\Input::post('save'))
		{
			foreach ($subforms as $subform) 
			{
				$subform->update(\Input::post($subform->get_prefix()));
			}
		}
                

		if (\Input::post('save') ) 
		{
			if(\Input::param('lock'))
                        {
                            //return \Message::set('error', 'Form locked has been changed'); 
                            $tab = \Input::param('lock');
                             \Response::redirect(\Uri::create('mainform/index/?tab='.$tab.'&quote_id='.$_GET['quote_id']));
                        }else{
                             return \Message::set('success', 'Successfully saved..!') . \Response::redirect(\Uri::create('mainform/index/?tab=0&quote_id='.$_GET['quote_id']));
                        }                       
                }
                
                if ( \Input::post('cancel')) 
		{
			return \Response::redirect(Helper_App::url_from_tab(\Input::get('active_tab')));
                        
		}

		$view = \View::forge('mainform');
                if(\Input::param('wind')){
                     $this->set_iframe_template();
                }
		$view->set('subforms', $vsubforms, false);
		$this->template->body_classes = array('contact_un');
		$this->template->content = $view;		
	}
}
/* eof */