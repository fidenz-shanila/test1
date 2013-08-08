<?php

namespace Artefacts;

class Subform_Description extends \Subform
{
	protected $prefix = 'artefact_description';

	protected $view = 'Artefacts::description';

	function render( $params = array() )
	{
		$quote_id = \Input::get('quote_id');
                $artefacts = \Artefacts\Model_Artefact::get_artefact($quote_id);
                $quote    = \Quotes\Model_Quote::get_quote($quote_id);
                $lock      = \Controller_Form::OfficeFormLock($quote['Q_LockForm']);

		$this->fields = array(
                        'BuildButton'       => array('type'=>"button",$lock['AdminEdit'], 'class'=>"button2", 'name'=>"build", 'value'=>"BUILD", 'id'=>"build"),
                        'ViewA_Button'      => array('type'=>'button', $lock['AdminEdit'],'class'=>"cb iframe", 'value'=>"...",'href'=> \Uri::create("artefacts/art_description/" . $artefacts['A_YearSeq_pk']) ),
			'A_Type' 	     => array('type'=>'select',  $lock['AdminEdit'], 'id' => 'A_Type', 'options'=>Model_Artefact::get_types($quote_id) ),
			'A_Make'             => array( 'class'=>'textbox-1', $lock['AdminEdit'], 'value'=>'testdata', 'id' => 'A_Make'),
			'A_Model'            => array('class'=>'textbox-1', $lock['AdminEdit'], 'id' => 'A_Model'),
			'A_SerialNumber'     => array('class'=>'textbox-1', $lock['AdminEdit'], 'id' => 'A_SerialNumber'),
			'A_PerformanceRange' => array('class'=>'textbox-1', $lock['AdminEdit'], 'id' => 'A_PerformanceRange'),
			'A_Description'      => array('class'=>'textbox-1',  $lock['AdminEdit'],'id' => 'A_Description'),
			'A_YearSeq_pk'       => array('type' => 'hidden', 'value' => $quote_id, 'id' => 'yearseq_pk')
		);

		$this->populate((array)$artefacts);

		
                $this->get_view()->A_YearSeq_pk = $quote_id;
               $this->view->lock    =   $lock;
                $this->view->quote    =   $quote;


		return parent::render();
	}

	function update($fields)
	{
                if(isset($fields['A_Type'])&&($fields['A_Type']!='')){
                    \NMI_DB::update('t_Artefact', array(
                            'A_Type'		 => $fields['A_Type'],
                            'A_Make'		 => $fields['A_Make'],
                            'A_Model'		 => $fields['A_Model'],
                            'A_SerialNumber'	 => $fields['A_SerialNumber'],
                            'A_PerformanceRange'	=> $fields['A_PerformanceRange'],
                            'A_Description'		 => $fields['A_Description']
                    ),

                    array('A_YearSeq_pk' => $fields['A_YearSeq_pk']));
                }
                
				
	}
}
/* eof */