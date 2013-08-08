<?php

namespace Jobs;

class Subform_Jobs extends \Subform
{
	protected $prefix = 'job_tab';

	protected $view = 'Jobs::subform/job_tab';
        
	//TODO :- set quote id
	function render( $params = array() )
	{
		$job_id  = \Input::get('quote_id');
		$job     = \Jobs\Model_Job::get_job($job_id);
                $lock      = \Controller_Form::OfficeFormLock($job['J_LockForm']);
		
		$email_client = array('type' => 'button', 'class' => 'spaced uppercase', 'value' => 'Email NMI Client');
		
		$client  = Model_Job::email_nmi_client($job_id);
		$methods = Model_Job::get_method_job($job_id);
		$certificates = Model_Job::get_certificate_offered($job['J_YearSeq_pk']);
               
                
                $quote    = \Quotes\Model_Quote::get_quote($job_id);
                
               
		
		//checking a contact is available
		if ($client == 0) {
			$email_client['onclick'] = "javascript:alert('No client')";
			
		}else{
			$cbody    = rawurlencode($client['body']);
			$csubject = rawurlencode($client['subject']);
			
			$email_client['href'] = "mailto:{$client['address']}?Subject={$csubject}&body={$cbody}";
		}
                 
	    if($job)
	    {
	    	$this->fields = array(
                                'Q_QuotedPrice'             => array('class' => 'textbox-1 txt_bold currency','value'=>$quote['Q_QuotedPrice'], 'disabled'=>'disabled'),
                                'Q_DateInstRequired'        => array('class' => 'textbox-1 datepicker','value'=>$quote['Q_DateInstRequired'], 'disabled'=>'disabled'),
				'J_PlannedStartDate'        => array('class' => 'textbox-1 datepicker',$lock['AdminEdit'],'id'=>'J_PlannedStartDate'),
                                'J_YearSeq_pk'              => array('type'=>'hidden'),
				'J_ActualStartDate'    	    => array('class' => 'textbox-1 type_check datepicker red_str',$lock['AdminEdit']),
				'J_FeeDue_Set'                  => array('class' => 'textbox-1 currency', 'id'=>'J_FeeDue_Set','readonly',$lock['AdminEdit'], 'value'=>$job['J_FeeDue']),
				'J_DateInstReturnedToStore' => array('class' => 'textbox-1 datepicker',$lock['AdminEdit']),
				'J_TestStartDate'    	    => array('class' => 'textbox-1 type_check datepicker red_str',$lock['AdminEdit']),
				'J_TestEndDate'    	    	=> array('class' => 'textbox-1 type_check datepicker red_str',$lock['AdminEdit']),
				'J_OutCome'                 => array('class' => 'select-1 type_check ', 'type' => 'select',$lock['AdminEdit'], 'options' => array('Completed' => 'Completed', 'Partially cometed' => 'Partially cometed', 'Not completed' => 'Not completed')),
				'J_OutComeDate'    	    	=> array('class' => 'textbox-1 datepicker type_check ','disabled'=>'disabled'),
				'J_Comments'    	    	=> array('type'  => 'textarea', 'class' => 'textarea-1','readonly',$lock['AdminEdit']),
				'J_FeeDueLocked'    	    => array('class' => 'textbox-1 currency',$lock['AdminEdit']),
				'Email_Client'				=> $email_client,
				'A_TestMethodUsed'	   => array('class' => 'select-1 type_check ', 'type' => 'select', 'options' => $methods,$lock['AdminEdit']),
				'Certificated_offered'		=> array('class' => 'textbox-1 ', 'value' => $certificates['Q_CertificateOffered'], 'disabled'=>'disabled')
			);

	    	$reports = \Reports\Model_Report::get_reports($job_id);

	    	//set reports
			$view = $this->get_view();
			$view->job = $job;
                        $view->lock = $lock;
			$view->email_melb = Model_Job::email_melb_link($job_id);
			$view->reports = $reports;
			$this->populate($job);
	    }
	    else 
	    {
	    	return false;
	    }

	    return parent::render();
	}
	
	function update($fields)
	{ 
            if(\Input::post('cancel')){
                return \Response::redirect(\Uri::create('quotes'));
            }
		
            $A_fields = array(
                'A_TestMethodUsed'=>$fields['A_TestMethodUsed'],
            );   
           // print_r($fields); exit;
            $update = \Nmi_Db::update('t_Artefact',$A_fields , array('A_YearSeq_pk' => $fields['J_YearSeq_pk']));
            
            unset($fields['A_TestMethodUsed']);
            if(isset($fields['J_FeeDue_Set'])){unset($fields['J_FeeDue_Set']);} 
            
                if(!isset($fields['J_LockForm'])){$fields['J_LockForm'] = 0;}
               // echo $fields['J_PlannedStartDate']; echo '------';
		if(isset($fields['J_PlannedStartDate'])){$fields['J_PlannedStartDate'] = \NMI_Db::format_date($fields['J_PlannedStartDate']);}
		if(isset($fields['J_ActualStartDate'])){$fields['J_ActualStartDate'] = \NMI_Db::format_date($fields['J_ActualStartDate']);}	
                if(isset($fields['J_DateInstReturnedToStore'])){$fields['J_DateInstReturnedToStore'] = \NMI_Db::format_date($fields['J_DateInstReturnedToStore']);}
                if(isset($fields['J_TestStartDate'])){$fields['J_TestStartDate'] = \NMI_Db::format_date($fields['J_TestStartDate']);}
                if(isset($fields['J_TestEndDate'])){$fields['J_TestEndDate'] = \NMI_Db::format_date($fields['J_TestEndDate']);}       
                if(isset($fields['J_OutComeDate'])){$fields['J_OutComeDate'] = \NMI_Db::format_date($fields['J_OutComeDate']);}

               
                $update = \Nmi_Db::update('t_Job', $fields, array('J_YearSeq_pk' => $fields['J_YearSeq_pk']));
                 

                
	}
	
	
	
}
/* eof */