<?php

namespace Files;

class Subform_Files extends \Subform
{
	protected $prefix = 'attached_tab';
	protected $view = 'Files::subform/attached_tab';
        
   	function render( $params = array() )
	{
                        
        //get cb file pk
        $quote    = \Quotes\Model_Quote::get_quote(\Input::get('quote_id'));
        $artefact = \Artefacts\Model_Artefact::get_artefact(\Input::get('quote_id'));

        $view = $this->get_view();
        $view->info_types = Model_File::get_info_type();
        $view->tab_title  = "BUILD AND LOG INFORMATION FOR {$quote['Q_FullNumber']} AGAINST {$artefact['A_CF_FileNumber_fk']}";
        $view->CF_FileNumber_pk = $artefact['A_CF_FileNumber_fk'];

        //information log
	   // $view->info_log = Model_File::get_attached_info($artefact['A_CF_FileNumber_fk']);

        //cb files
        $view->cb_file = Model_File::get_cb_file($artefact['A_CF_FileNumber_fk']);
        $view->cb_file_content = Model_File::get_cb_file_list('20050005');
		
        return parent::render();
	}


}
/* eof */