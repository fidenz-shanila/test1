<?php

namespace Artefacts;

class Subform_File extends \Subform
{
	protected $prefix = 'artefact_file';
	protected $view   = 'Artefacts::file';

	function render( $params = array() )
	{
		$quote_id = \Input::get('quote_id');
		$artefact = \Artefacts\Model_Artefact::get_artefact(\Input::get('quote_id'));
		
		$view = $this->get_view();
		$view->CF_FileNumber_pk = $artefact['A_CF_FileNumber_fk'];
		$view->cb_file = \Files\Model_File::get_cb_file($artefact['A_CF_FileNumber_fk']);
		
		
				
        return parent::render();
	}
	
	
}
/* eof */