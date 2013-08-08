<?php
/**
 * Reports form of jobs tab (mainform)
 */
namespace Reports;

class Subform_Editsurveys extends \Subform
{
	protected $prefix = 'edit_surveys';
	protected $view = 'Reports::survey/edit_survey';
        
	function render( $params = array() )
	{
        $CS_ContactSurvey_pk = $params['CS_ContactSurvey_pk'];
        $survey_info        = \Reports\Model_Survey::get_survey_info($CS_ContactSurvey_pk);

		$this->fields = array(
                    'CS_R_FullNumber_ind'                => array('class' => 'textbox-1', 'disabled'),
                    'CS_ContactFullName'                 => array('class' => 'textbox-1', 'disabled'),
                    'CS_OrganisationFullName'            => array('class' => 'textbox-1', 'disabled'),
                    'CS_SurveyVersion'                   => array('class' => 'textbox-1', 'disabled'),
                    'CS_DateSent'                        => array('class' => 'textbox-1 datepicker'),
                    'CS_DateReturned'                    => array('class' => 'textbox-1 datepicker'),
                    'CS_ContactNotifiedOfOutcome'        => array('type'  => 'select','class' => 'textbox-1','option'=>array('YES'=>'YES','NO'=>'NO','N/A'=>'N/A')),
                    'CS_Outcome'                         => array('type'  => 'select','class' => 'textbox-1','option'=>array('No action required'=>'No action required','Correction action required'=>'Correction action required','No response'=>'No response')),
                    'CS_OutcomeDate'                     => array('class' => 'textbox-1 datepicker'),
                    'CS_Comments'                        => array('class' => 'textbox-1'),
                    'CS_ContactNotifiedOfOutcome'        => array('class' => 'textbox-1'),
                    'CS_ReturnedBy'                      => array('type' => 'select','class' => 'textbox-1','option'=>array('Email'=>'Email','Fax'=>'Fax','Mail'=>'Mail','Other'=>'Other')),
                    'CS_CarNo'                           => array('class' => 'textbox-1')

		);

		$this->populate($survey_info);
				
		$this->get_view()->set('survey_info', $survey_info);
	    return parent::render();
	}

	public function update($fields)
	{
                
                
                    $update = \Nmi_Db::update('t_ContactSurvey', $fields, array('CS_ContactSurvey_pk' => $fields['CS_ContactSurvey_pk']));
                 
                    if($update)
                    {
                        return \Message::set('success', 'Successfully saved..!') . \Response::redirect(\Uri::create('reports/mainform_report/'.$fields['R_FullNumber_pk'] . '?quote_id='.$quote_id)) ;
                    }
                 
	}
	
}
/* eof */