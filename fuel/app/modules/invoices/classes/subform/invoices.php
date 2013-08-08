<?php

namespace Invoices;

class Subform_Invoices extends \Subform
{
	protected $prefix = 'invoice_tab';

	protected $view = 'Invoices::subform/invoice_tab';
        
   	function render( $params = array() )
	{
		$quote_id = \Input::get('quote_id');
		$quote    = \Quotes\Model_Quote::get_quote($quote_id);
		$owner    = \Artefacts\Model_Artefact::get_owner($quote_id);
		$details  = Model_Invoice::get_address_details();
		$address  = Model_Invoice::get_addresses();
		
		$job = \Jobs\Model_Job::get_job($quote['Q_YearSeq_pk']);
		
		if (!$job) {
			return false;
		}

		$order_number = Model_Invoice::get_purchase_order_number($job['J_YearSeq_pk']);
		
		//Fee due button
		$fee_due_button = array('type' => 'button', 'value' => '..','class'=>'button1');
		
		if (strpos($job['J_Status'], 'complete') === true){
			$fee_due_button['onclick']	= 'javascript:copy();return false;';
		
		}elseif ($job['J_PaymentMethod'] == 'Prepayment') {
			$fee_due_button['onclick']	= 'javascript:copy();return false;';
		
		}else{
			$fee_due_button['onclick']	= "javascript:check('conf');return false;";
		}
		
		//format the address lines to display it in textarea
		//$formatted_address = $job['J_InvoiceAddress1']."\n".$job['J_InvoiceAddress2']."\n".$job['J_InvoiceAddress3']."\n".$job['J_InvoiceAddress4']."\n";
		
		
		$this->fields = array(
			'J_InvoiceContactID'       => array('class' => 'select-1', 'type' => 'select', 'options' => \Invoices\Model_Invoice::get_invoice_contact_id($owner['OR1_OrgID_pk'])),
			'OR1_FullName'    	  => array('class' => 'textarea-1', 'type' => 'textarea', 'value' => $details['OR1_FullName'],'disabled'=>'disabled'),
			'OR2_ABN'    	   		   => array('class' => 'textbox-1', 'value'	=> $details['OR2_ABN'],'disabled'=>'disabled'),
			'J_PaymentMethod'    	   => array('class' => 'select-1', 'type' => 'select', 'options' => array('Prepayment - credit card' => 'Prepayment - credit card', 'Prepayment - EFT/Cheque/bank draft' => 'Prepayment - EFT/Cheque/bank draft', 'Credit card' => 'Credit card', 'Invoice' => 'Invoice', 'Internal transfer' => 'Internal transfer', 'Own Project - No invoice' => 'Own Project - No invoice', 'Contract - No invoice' => 'Contract - No invoice')),
			'J_DatePOReceived'    	   => array('class' => 'textbox-1 datepicker '),
			'J_FeeDue_Set'                 => array('class' => 'textbox-1 currency', 'id' => 'fee_due','value'=> $job['J_FeeDue'],'disabled'=>'disabled'),
			'J_FeeJustificationStatus' => array('class' => 'textbox-1','disabled'=>'disabled'),
			'J_FeeJustification'       => array('class' => 'textarea-1', 'type' => 'textarea','disabled'=>'disabled'),
			'J_FeeDueLocked_Set'    	   => array('class' => 'FeeDuelocked currency', 'id' => 'fee_due_locked', 'value'=> $job['J_FeeDueLocked']),
			'J_DateSentToFinance'      => array('class' => 'FeeDuelocked datepicker'),
			'J_InvoiceNumber'    	   => array('class' => 'FeeDuelocked'),
                        'J_InvoiceDate'    	   => array('class' => 'FeeDuelocked datepicker'),
                        'J_PaidDate'    	  => array('class' => 'FeeDuelocked datepicker'),
                        'J_InvoiceAddress1'    	   => array('class' => 'textbox','id'=>'J_Return1'),
                        'J_InvoiceAddress2'    	   => array('class' => 'textbox','id'=>'J_Return2'),
                        'J_InvoiceAddress3'    	   => array('class' => 'textbox','id'=>'J_Return3'),
                        'J_InvoiceAddress4'    	   => array('class' => 'textbox','id'=>'J_Return4'),
			'J_InvoiceComments'        => array('class' => ($job['J_HighlightInvoiceComment'] == 1)?'textarea-1 comment_highlight highlight':'textarea-1 comment_highlight q_comment', 'type' => 'textarea'),
			'J_ProjectCodeSummary'     => array('class' => 'textarea-1', 'type' => 'textarea','disabled'=>'disabled'),
			'Q_PurchaseOrderNumber'    => array('class' => 'textbox-1', 'value' => $order_number['Q_PurchaseOrderNumber'], 'disabled'=> 'disabled'),
			'J_YearSeq_pk'      	   => array('type'  => 'hidden', 'value' => $quote_id),
			'fee_due_button'		   => $fee_due_button
		);
                
		$this->populate($job);
		
		$view = $this->get_view();
		$view->address = $address;
		$view->job = $job;
		$view->quote_id = $quote_id;
		
	    return parent::render();
	}
	
	function update($fields)
	{
                if (!isset($fields['J_HighlightInvoiceComment'])) $fields['J_HighlightInvoiceComment'] = 0;
                $fields['J_DatePOReceived'] = \NMI_Db::format_date($fields['J_DatePOReceived']);
                $fields['J_FeeDueLocked'] = \NMI_Db::reset_number_format($fields['J_FeeDueLocked_Set']);
                if(isset($fields['J_FeeDueLocked_Set'])){unset($fields['J_FeeDueLocked_Set']);}
                $fields['J_DateSentToFinance'] = \NMI_Db::format_date($fields['J_DateSentToFinance']);
                $fields['J_InvoiceDate'] = \NMI_Db::format_date($fields['J_InvoiceDate']);
                $fields['J_PaidDate'] = \NMI_Db::format_date($fields['J_PaidDate']);
		//print_r($fields); exit;
		\NMI_DB::update('t_Job', $fields,array('J_YearSeq_pk' => $fields['J_YearSeq_pk']));		
				
	}
	
	
	
	
}
/* eof */