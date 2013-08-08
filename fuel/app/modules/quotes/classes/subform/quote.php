<?php

namespace Quotes;

class Subform_Quote extends \Subform
{
	protected $prefix = 'quote_tab';
	
    protected $view   = 'Quotes::subform/quote_tab';

	//TODO :- set quote id
	function render( $params = array() )
	{
		$quote_id = \Input::get('quote_id');
		$quote    = \Quotes\Model_Quote::get_quote($quote_id);
		$email	  = \Quotes\Model_Quote::generate_email($quote_id);
                $Q_PreparedByEmployeeID_list = \Employees\Model_Employee::get_employees();
                $artefacts = \Artefacts\Model_Artefact::get_artefact($quote_id);
                $lock      = \Controller_Form::OfficeFormLock($quote['Q_LockForm']);
                
                

                $acceptButtonValue = 'create J'. $quote['Q_YearSeq_pk'];
                
                $current_user = \Session::get('current_user');
                
                if($current_user['CanLockQuote']==0){
                    $quote_admin_lock = 'disabled';
                }elseif($quote['Q_SendEmail']==0){
                    $quote_admin_lock = 'disabled';
                }else{
                    $quote_admin_lock = '';
                }
                
                if($current_user['CanLockQuote']==0){
                    $officeLock = 'disabled';
                }else{
                    $officeLock = ''; 
                }
              
                
                $outCome = array(
                  'Accepted'=>'Accepted',
                  'Requoted'=>'Requoted',
                  'Rejected'=>'Rejected',
                  'Cancelled'=>'Cancelled'  
                );
                
                $sendMethod = array(
                    'Fax'       =>'Fax',
                    'Email'     =>'Email',
                    'Letter'    =>'Letter',
                    'by hand'   =>'by hand',
                    'Internal'  =>'Internal'
                    
                );
               // echo  \Quotes\Model_Quote::get_w_test_method($quote['Q_YearSeq_pk']); exit;
                $quote_price = \NMI_Db::set_number_format($quote['Q_QuotedPrice']);
                
		//set initial fields
		$this->fields = array(
			'Q_PreparedByEmployeeID'     => array('class' => 'select-1 prepared' ,'type'=>'select' , $lock['AdminEdit'],'options' => $Q_PreparedByEmployeeID_list),
			'Q_DateInstRequired'         => array('class' => 'textbox-1 datepicker',$lock['AdminEdit']),
			'Q_TargetReportDespatchDate' => array('class' => 'textbox-1 datepicker',$lock['AdminEdit']),
			'Q_ServicesOffered'          => array('class' => 'textarea-1',  'type' => 'textarea', 'maxlength'=>"300",$lock['AdminEdit']),array(array('max_length[300]')),
			'Q_CertificateOffered'       => array('class' => 'select-1', 'type' => 'select',  $lock['Admintype'], $lock['AdminEdit'],'options' => \Quotes\Model_Quote::get_certificate_offred()),
			'Q_SpecialRequirements'      => array('class' => 'textarea-1', 'id'=>'Q_SpecialRequirements', 'type' => 'textarea', 'maxlength'=>"300", $lock['AdminEdit']),
			'Q_PurchaseOrderNumber'      => array('class' => 'textbox-1', $lock['AdminEdit']),
			'Q_DeliveryInstructions'     => array('class' => 'textarea-1', 'type' => 'textarea', $lock['AdminEdit']),
			'Q_Comments'      	     => array('class' => ($quote['Q_HighlightComment'] == 1)?'textarea-1 comment_highlight highlight':'textarea-1 comment_highlight q_comment', 'type' => 'textarea', $lock['AdminEdit']),
			'Q_OfferDate'      	     => array('class' => 'textbox-1 datepicker',$lock['AdminEdit']),
			'Q_ValidityInDays'           => array('class' => 'select-2'  ,   $lock['AdminEdit'],'options' => array('7' => '7', '14' => '14', '21' => '21','28' =>'28', '30' => '30')),
			'Q_ExpiryDate'      	     => array('class' => 'textbox-1 datepicker',$lock['AdminEdit'],),
                        'Q_QuotedPrice_Set'              => array('class' => 'textbox-1','readonly','value'=>  $quote_price),
			'Q_YearSeq_pk'    	     => array('type'  => 'hidden', 'class' => 'textbox-1', 'value' => $quote_id),
                        'A_CF_FileNumber_fk'         => array('type' => 'hidden', 'class' => 'textbox-2 cb_file_id', 'value'=>$artefacts['A_CF_FileNumber_fk']),
                        'A_TestMethodUsed'           => array('class' => 'select-1 editable', $lock['AdminEdit'], 'type' => 'select','options' => \Quotes\Model_Quote::get_w_test_method($quote_id)),
                        'Q_CheckedByEmployeeID'      => array('class' => 'select-1 checked_employee',  $lock['AdminEdit'],'options' => \Employees\Model_Employee::get_employees()),
                        'Q_SentMethod'               => array('class' => 'select-1 method ', 'type'=>'select' ,$officeLock,  $lock['AdminEdit'], 		'options' => $sendMethod),
			'Q_DateSent'		     => array('class' => 'textbox-1 datepicker',$officeLock, $lock['AdminEdit'], 'style' => 'width:80px'),
                        'Q_OutCome'                  => array('class' => 'select-1', 'type'=>'select'  ,$officeLock,  $lock['AdminEdit'], 'options'=>$outCome ,'id' => 'outcome'),
                        'Q_OutComeDate'              => array('class'=>'textbox-1 datepicker',$lock['AdminEdit'],'id'=>'outcome_data_pic'),
			'Email_User'		     => array('type'  => 'button',$officeLock, $quote_admin_lock, $lock['AdminEdit'], 'class'	=> 'button1', 'id' => 'email', 'value' => 'Email ', 'href' => "mailto:{$email['address']}?Subject={$email['subject']}&Body={$email['body']}", 'style' => 'width:140px;'),
                        'BuildPrice'                 => array('type'=>"button", $lock['AdminEdit'], 'href'=> \Uri::create('quotes/insert_work_group/'.$quote['Q_YearSeq_pk']), 'class'=>"cb iframe button1", 'id'=>"insert_workgroup", 'value'=>"ADD ' WORK GROUP '"),
                        //'RequestEmail'             => array('type'=>"checkbox", $lock['AdminEdit'], 'class'=>"radio",  'value'=>$email_options),
                        'BtnPrintQuotes'             => array('type'=>"button", $officeLock,$lock['AdminEdit'], 'onclick'=>"javascript:alert('user not support');"/*'href'=>\Uri::create('Quotes/get_quote_merge_data?Q_YearSeq_pk='.$quote['Q_YearSeq_pk'])*/, 'value'=>"print quote document", 'class'=>"button1"),
                        'BtnAcceptQutoes'           => array( 'href'=>\Uri::create('quotes/accept_quote/'.$quote['Q_YearSeq_pk']),$officeLock,$lock['AdminEdit'], 'type'=>"button", 'value'=>$acceptButtonValue, 'class'=>"button1", 'id'=>"accept_quote")
		);

        $this->populate($quote);

		$view           = $this->get_view();
		$view->quote    = $quote;
                $view->fields    = $this->fields;
                $view->lock      = $lock;
		$view->quote_id = $quote_id;
		
	    return parent::render();
	}
	
	function update($fields)
	{ 
		if (!isset($fields['Q_LockForm'])) $fields['Q_LockForm'] = 0;
		if (!isset($fields['Q_HighlightComment'])) $fields['Q_HighlightComment'] = 0;
                if(!isset($fields['Q_SendEmail']))$fields['Q_SendEmail']=0;
                
                if(isset($fields['Q_QuotedPrice_Set'])){unset($fields['Q_QuotedPrice_Set']);} 
               
                
		$fields['Q_DateInstRequired'] = \NMI_Db::format_date($fields['Q_DateInstRequired']);
		$fields['Q_TargetReportDespatchDate'] = \NMI_Db::format_date($fields['Q_TargetReportDespatchDate']);
              // echo $fields['Q_TargetReportDespatchDate'];exit;
		$fields['Q_OfferDate'] = \NMI_Db::format_date($fields['Q_OfferDate']);
		$fields['Q_ExpiryDate'] = \NMI_Db::format_date($fields['Q_ExpiryDate']);
                $fields['Q_DateSent']   = \NMI_Db::format_date($fields['Q_DateSent']);
                $fields['Q_OutComeDate']   = \NMI_Db::format_date($fields['Q_OutComeDate']);
            
                    \NMI_DB::update('t_Artefact', array('A_TestMethodUsed'=>$fields['A_TestMethodUsed'],'A_CF_FileNumber_fk' => $fields['A_CF_FileNumber_fk']), array('A_YearSeq_pk' => $fields['Q_YearSeq_pk']));      
                    unset($fields['A_TestMethodUsed']); unset($fields['A_CF_FileNumber_fk']); 
                    
                   
                     \NMI_DB::update('t_Quote', $fields, array('Q_YearSeq_pk' => $fields['Q_YearSeq_pk']));
                    

        }
	
}
/* eof */