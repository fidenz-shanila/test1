<?php
/**
 * Reports form of jobs tab (mainform)
 */
namespace Reports;

class Subform_Report extends \Subform
{
	protected $prefix = 'reports';
	protected $view = 'Reports::subform/report';
        
	function render( $params = array() )
	{
        if(!isset($params['report_id']))
        	throw new \InvalidArgumentException('A report id should present.');

        $report_id = $params['report_id'];
        $quote_id   =   $params['quote_id']; 
        $month_info = Model_Report::get_rp_exper_date_month();
        
        $periodInMonths = array(
            '0.5'=>'0.5',
            '1'=>'1',
            '2'=>'2',
            '3'=>'3',
            '4'=>'4',
            '5'=>'5',
            '10'=>'10'
            );
        
        $report = \Reports\Model_Report::get_report($report_id); //print_r($report);
        $lock      = \Controller_Form::OfficeFormLock($report['R_LockForm']);
        
        $get_org_name = \Reports\Model_Report::get_contact_org_info($report['R_J_YearSeq_fk_ind']);
        
         
        $canDo = \Users\Model_User::PermissionGranted('UpdateColumn' , 't_Report', 'R_LockForm'); 
        $lock['canDo'] = $canDo;
		
		$owner  = \Artefacts\Model_Artefact::get_owner($report['R_J_YearSeq_fk_ind']);

		$this->fields = array(
			'R_ExpiryApplicable'          => array('class' => 'textbox-1',$lock['AdminEdit']),
			'R_DateOfReport'              => array('class' => 'textbox-1 red_str datepicker',$lock['AdminEdit']),
			'R_DateReportSent'            => array('class' => 'textbox-1 datepicker',$lock['AdminEdit']),
			'R_CertValidityPeriodInYears' => array('class' => 'select-1','type' => 'select', 'options' =>$periodInMonths,$lock['AdminEdit'] ),
			'R_CertificateExpiryDate'     => array('class' => 'textbox-1 type_check datepicker','id'=>'R_CertificateExpiryDate',$lock['AdminEdit']),
			'R_ValidityPeriodInMonths'    => array('class' => 'select-1',$lock['AdminEdit'],'type' => 'select','id'=>'R_ValidityPeriodInMonths', 'options'=> $month_info),
			'R_ExpiryDate'                => array('class' => 'textbox-1 datepicker',$lock['AdminEdit'], 'id'=>'R_ExpiryDate'),
			'R_OutCome'                   => array('class' => 'select-1', $lock['AdminEdit'],'id' => 'outcome', 'type' => 'select', 'options' => array('Cancelled' => 'Cancelled', 'Expired' => 'Expired', 'Not Issued' => 'Not Issued', 'Withdrawn' => 'Withdrawn')),
			'R_OutComeDate'               => array('class' => 'textbox-1 datepicker',$lock['AdminEdit'], 'id' => 'outcome_date'),
			'R_ReportAddressedToFullName' => array('class' => 'select-sp type_check',$lock['AdminEdit'], 'type' => 'select', 'options' => \Contacts\Model_Contact::get_org_contacts($owner['OR1_OrgID_pk']) ),
			'R_NmiSignatoryID'            => array('class' => 'select-1', $lock['AdminEdit'],'type' => 'select', 'options' => Model_Report::get_nmi_signatory($report['R_J_YearSeq_fk_ind'])),
			'R_NataSignatoryID'           => array('class' => 'select-1',$lock['AdminEdit'], 'type' => 'select', 'options' => Model_Report::get_nata_signatory($report['R_J_YearSeq_fk_ind'])),
			'R_DocumentSignerID'          => array('class' => 'select-1',$lock['AdminEdit'], 'type' => 'select', 'options' => Model_Report::get_letter_signed_by($report['R_J_YearSeq_fk_ind'])),
			'R_CoverLetterAddress1'       => array('class' => 'textbox-3','id'=>'Co_add_1',$lock['AdminEdit']),
			'R_CoverLetterAddress2'       => array('class' => 'textbox-3','id'=>'Co_add_2',$lock['AdminEdit']),
			'R_CoverLetterAddress3'       => array('class' => 'textbox-3','id'=>'Co_add_3',$lock['AdminEdit']),
			'R_CoverLetterAddress4'       => array('class' => 'textbox-3','id'=>'Co_add_4',$lock['AdminEdit']),
			'R_ReportAddress1'            => array('class' => 'textbox-3','id'=>'Re_add_1',$lock['AdminEdit']),
			'R_ReportAddress2'            => array('class' => 'textbox-3','id'=>'Re_add_2',$lock['AdminEdit']),
			'R_ReportAddress3'            => array('class' => 'textbox-3','id'=>'Re_add_3',$lock['AdminEdit']),
			'R_ReportAddress4'            => array('class' => 'textbox-3','id'=>'Re_add_4',$lock['AdminEdit']),
			'R_Comments'                  => array('class' => ($report['R_HighlightComment'] == 1)?'textarea-1 comment_highlight highlight':'textarea-1 comment_highlight r_comment',$lock['AdminEdit'], 'type' => 'textarea'),
			'R_ReportLateReason'          => array('class' => 'textarea',$lock['AdminEdit']),
			'R_ReportLateCustSerCategory' => array('class' => 'textbox-1',$lock['AdminEdit'],'type'=>'select','options'=>array('Not categorised'=>'Not categorised','NMI Error'=>'NMI Error','Non-NMI Error'=>'Non-NMI Error')),
			'R_FullNumber_pk'             => array('type'=>'hidden'),
                        'R_ReportPath'                => array('readonly'=>'readonly','type'=>'textarea','class'=>'textbox-3',$lock['AdminEdit'],'id'=>'R_ReportPath'),
                        'quote_id'                    => array('type'=>'hidden','value'=>$quote_id),
                        'surveys'                     =>array('type'=>'button','value'=>'Survey','href'=>\Uri::create('reports/surveys/?n='.$get_org_name['CS_OrganisationFullName']),'target'=>"_blank")
		);

		$this->populate($report);
		
		$this->get_view()->set('R_J_YearSeq_fk_ind', $report['R_J_YearSeq_fk_ind']);		
		$this->get_view()->set('report', $report);
                $this->get_view()->set('lock',$lock);

	    return parent::render();
	}

	public function update($fields)
	{
                if(!isset($fields['R_ReportWithItem'])) $fields['R_ReportWithItem'] = 0;
                if(!isset($fields['R_ExpiryApplicable'])) $fields['R_ExpiryApplicable'] = 0;
                if(!isset($fields['R_LockForm'])) $fields['R_LockForm'] = 0;
                if(!isset($fields['R_ExpiryDate'])){unset($fields['R_ExpiryDate']);}else{$fields['R_ExpiryDate'] = \NMI_Db::format_date($fields['R_ExpiryDate']);}
		if(isset($fields['R_DateOfReport'])){$fields['R_DateOfReport'] = \NMI_Db::format_date($fields['R_DateOfReport']);}
		if(isset($fields['R_DateReportSent'])){$fields['R_DateReportSent'] = \NMI_Db::format_date($fields['R_DateReportSent']);}
		if(!isset($fields['R_CertificateExpiryDate'])){unset($fields['R_CertificateExpiryDate']);}else{$fields['R_CertificateExpiryDate'] = \NMI_Db::format_date($fields['R_CertificateExpiryDate']);}
		if(isset($fields['R_OutComeDate'])){$fields['R_OutComeDate'] = \NMI_Db::format_date($fields['R_OutComeDate']);}
		$quote_id   =   $fields['quote_id']; 
                unset($fields['quote_id']);
                unset($fields['surveys']);
		
		//parent::update($fields);
		//print_r($fields);
                
                    $update = \Nmi_Db::update('t_Report', $fields, array('R_FullNumber_pk' => $fields['R_FullNumber_pk']));
                 
                    if($update)
                    {
                        if(\Input::post('lock')){
                          //return \Message::set('error', 'Form locked has been changed') . \Response::redirect(\Uri::create('reports/mainform_report/'.$fields['R_FullNumber_pk'] . '?quote_id='.$quote_id)) ;  
                        }else{
                             return \Message::set('success', 'Successfully saved..!'). \Response::redirect(\Uri::create('reports/mainform_report/'.$fields['R_FullNumber_pk'] . '?quote_id='.$quote_id)) ;
                        }
                        
                    }
                 
	}
	
}
/* eof */