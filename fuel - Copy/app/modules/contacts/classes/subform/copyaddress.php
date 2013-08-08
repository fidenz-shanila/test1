<?php

namespace Contacts;

class Subform_Copyaddress extends \Subform
{
	protected $prefix = 'copy_address';
	
        protected $view   = 'copy_address';

	
	function render( $params = array() )
	{
		$ori_info = Model_Contact::get_ori_info($params['A_OR1_OrgID_fk']);
                $ori_info = $ori_info[0];              
                
                
		//set initial fields
		$this->fields = array(
			'OR1_FullName'     => array('class' => 'textarea-2' ,'type'=>'textarea'),
			'OR2_Postal1'      => array('class' => 'textbox-3','readonly','id'=>'pos_1'),
                        'OR2_Postal2'      => array('class' => 'textbox-3','readonly','id'=>'pos_2'),
			'OR2_Postal3'      => array('class' => 'textbox-3','readonly','id'=>'pos_3'),
			'OR2_Postal4'      => array('class' => 'textbox-3','readonly','id'=>'pos_4'),
			'OR2_Physical1'    => array('class' => 'textbox-3','readonly','id'=>'phy_1'),
			'OR2_Physical2'    => array('class' => 'textbox-3','readonly','id'=>'phy_2'),
			'OR2_Physical3'    => array('class' => 'textbox-3','readonly','id'=>'phy_3'),
			'OR2_Physical4'    => array('class' => 'textbox-3','readonly','id'=>'phy_4'),
                        'OR2_Invoice1'    => array('class' => 'textbox-3','readonly','id'=>'invo_1'),
			'OR2_Invoice2'    => array('class' => 'textbox-3','readonly','id'=>'invo_2'),
			'OR2_Invoice3'    => array('class' => 'textbox-3','readonly','id'=>'invo_3'),
			'OR2_Invoice4'    => array('class' => 'textbox-3','readonly','id'=>'invo_4'),
			
		);
 
        $this->populate($ori_info);
 

		$view           = $this->get_view();
		$view->ori_info    = $ori_info;
                $view->div_id      =    $params['div_id'];
                $view->sub_div_id  =    $params['sub_div_id'];
		
	    return parent::render();
	}
	
	
	
}
/* eof */