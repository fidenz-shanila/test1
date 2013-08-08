<?php

namespace Receipts;

class Subform_Receipt extends \Subform
{
	protected $prefix = 'receipt_tab';

	protected $view = 'Receipts::subform/receipt_tab';

	//TODO :- set quote id
	function render( $params = array() )
	{
	
        $quote_id = \Input::get('quote_id');
        $owner    = \Artefacts\Model_Artefact::get_owner($quote_id);
        $quote    = \Quotes\Model_Quote::get_quote($quote_id);
        $receipt  = \Receipts\Model_Receipt::get_receipt_dispatch($quote_id);
        $mail     = \Receipts\Model_Receipt::email_test_officer($quote_id);
		
		$msg = '';
		switch($mail['ReturnValue'])
		{
			case '1':
				$msg = 'There is no received by date. Operation cancelled.';
				break;
			
			case '2':
				$msg = 'There is no received by person. Operation cancelled.';
				break;
			
			case '3':
				$msg = 'There is no Test Officer nominated for the job. Operation cancelled.';
				break;
		}
		
		$default_button = array('type' => 'button', 'value' => 'EMAIL TEST OFFICER', 'class' => 'button1');
		
		$button = array();
		if (isset($msg) && !empty($msg)) {
			$button = array('onclick'=> "javascript:alert('{$msg}')" );

		} elseif($mail['ReturnValue'] == 0) {
			$button = array('target'=> '_self', 'href' => "mailto:{$mail['ExaminerEmailAddress']}?Subject={$mail['Subject']}&Body={$mail['EmailBody']}");
		}
		
		$display_button = array_merge($default_button, $button);
		
		//format the address lines to display it in textarea
		//$formatted_address = $receipt['RD_ReturnAddress1']."\n".$receipt['RD_ReturnAddress2']."\n".$receipt['RD_ReturnAddress3']."\n".$receipt['RD_ReturnAddress4']."\n";
		

		//set initial fields
		$this->fields = array(
			'RD_ReceivedByEmployeeID' 	 => array('class' => 'select-1', 'type' => 'select', 'options' => \Employees\Model_Employee::get_employees()),
			'RD_ReceivedDate'                => array('class' => 'textbox-1 datepicker'),
			'RD_DeliveredBy'                 => array('class' => 'textbox-1'),
			'RD_DeliveryConNote'      	 => array('class' => 'textbox-1'),
			'RD_ReceiptImagePath'   	 => array('class' => 'textbox-1'),
			'RD_InsuranceInstructions'  	 => array('class' => 'textarea-1', 'type' => 'textarea'),
			'RD_AustValueForCustomsPurposes' => array('class' => 'textbox-1'),
			'RD_ShippingMode'                => array('class' => 'select-1', 'type' => 'select', 'options' => \Receipts\Model_Receipt::get_shipping_mode()),
			'RD_ShippingUrgency'      	 => array('class' => 'select-1', 'type' => 'select', 'options' => \Receipts\Model_Receipt::get_shipping_ugency() ),
			'RD_CarrierName'      	 	 => array('class' => 'select-1'),
			'RD_CarrierAccountNumber'        => array('class' => 'textbox-1'),
			'RD_CarrierContactPerson'        => array('class' => 'select-1', 'type' => 'select', 'options' => \Receipts\Model_Receipt::get_career_contact_person()),
			'RD_CarrierContactPhone'      	 => array('class' => 'select-1', 'type' => 'select', 'options' => \Receipts\Model_Receipt::get_career_contact_phone()),
			'RD_ReturnContact'      	 => array('class' => 'select-1', 'type' => 'select', 'options' => \Receipts\Model_Receipt::get_return_contact($owner['OR1_OrgID_pk'])),
			'RD_ReturnOrganisation'      	 => array('class' => 'textarea-1', 'type' => 'textarea'),
			'RD_ReturnAddress1'      	 => array('class' => 'textbox', 'id' => 'RD_return1'),
                        'RD_ReturnAddress2'      	 => array('class' => 'textbox', 'id' => 'RD_return2'),
                        'RD_ReturnAddress3'      	 => array('class' => 'textbox', 'id' => 'RD_return3'),
                        'RD_ReturnAddress4'      	 => array('class' => 'textbox', 'id' => 'RD_return4'),
			'RD_PackagingRequirements'       => array('class' => ($receipt['RD_HighlightPackagingRequirements'] == 1)?'textarea-1 comment_highlight highlight':'textarea-1 comment_highlight r_comment', 'type' => 'textarea'),
			'RD_DespatchedByEmployeeID'      => array('class' => 'select-1', 'type' => 'select', 'options' => \Employees\Model_Employee::get_employees()),
			'RD_DespatchedDate'      	 => array('class' => 'textbox-1 datepicker'),
			'RD_PickedUpBy'      	 	 => array('class' => 'textbox-1'),
			'RD_DespatchConNote'      	 => array('class' => 'textbox-1'),
			'RD_DespatchImagePath'      	 => array('class' => 'textbox-1'),
			'RD_Comments'      	 	 => array('class' => ($receipt['RD_HighlightComment'] == 1)?'textarea-1 comment_highlight_2 highlight':'textarea-1 comment_highlight_2 r_comment', 'type' => 'textarea'),
			'Q_DeliveryInstructions'       	 => array('class' => 'textarea-1','disabled'=>'disabled', 'type' => 'textarea', 'value' => $quote['Q_DeliveryInstructions']),
			'Q_PurchaseOrderNumber'       	 => array('class' => 'textbox-1', 'disabled'=>'disabled', 'value' => $quote['Q_PurchaseOrderNumber']),
			'RD_YearSeq_pk'      		 => array('type'  => 'hidden', 'value' => $quote_id),
			'RD_mail'			 => $display_button,
			
		);
                

		$this->populate($receipt);

		$view = $this->get_view();
		$view->receipt = $receipt;
		$view->RD_YearSeq_pk = $quote_id;
		
	    return parent::render();
	}
	
	function update($fields)
	{
		//$address = explode("\n", $fields['RD_ReturnAddress']);		
		if(!isset($fields['RD_HighlightComment'])) $fields['RD_HighlightComment'] = 0;
                if(!isset($fields['RD_HighlightPackagingRequirements'])) $fields['RD_HighlightPackagingRequirements'] = 0;
                if(!isset($fields['RD_NotApplicable'])) $fields['RD_NotApplicable'] = 0;
                if(isset($fields['RD_ReceivedDate'])){$fields['RD_ReceivedDate']= \NMI_Db::format_date($fields['RD_ReceivedDate']);}
                if(isset($fields['RD_DespatchedDate'])){$fields['RD_DespatchedDate']= \NMI_Db::format_date($fields['RD_DespatchedDate']);}
                
                
                
                
		\NMI_DB::update('t_ReceiptAndDespatch', $fields,array('RD_YearSeq_pk' => $fields['RD_YearSeq_pk']));
		
		/*\NMI_DB::update('t_Quote', array(
			'Q_DeliveryInstructions'     	=>  $fields['Q_DeliveryInstructions'],
			'Q_PurchaseOrderNumber'  	=>  $fields['Q_PurchaseOrderNumber'],
		),
				
		array('Q_YearSeq_pk'  => $fields['RD_YearSeq_pk']));	*/	
	}
	
}
/* eof */