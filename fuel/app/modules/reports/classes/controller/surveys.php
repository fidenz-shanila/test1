<?php

namespace Reports;

class Controller_Surveys extends \Controller_Base
{
    
    /**
     * listing the survey, default
     * @author Namal
     */ 
    public function action_index()
    {     
                
        if (\Input::post('export_to_excel')) {

            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        
        }
        
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('survey/grids/survey');
        $view->sidebar = \View::forge('survey/sidebar/listing');
        $this->template->body_classes = array('clr_report');
	$this->template->content = $view;
            
                
    }
    
    public function action_listing()
    {
        
       /*$list = '{
           "id":-1,
           "error":"",
           "fieldErrors":[],
           "data":[],
           "aaData":[{
           "number":"row_1",
           "contact":"Trident",
           "organisation":"Internet Explorer 4.0",
           "survery":"Win 95+",
           "sent":"4",
           "returned":"X",
           "contact_notified":"X",
           "outcome":"X",
           "outcome_date":"X"
           }]}';
       return $list;
       exit;
        */
        
        
        $listing = $this->generate_listing();
        $result = $listing->listing();
        
        $data = array();
       // $form_url = \Uri::create('mainform/index/?tab=3');
      //  foreach ($result['result'] as $c) {
	
	//$result 	 = \Reports\Model_Survey::listing_data();
	//print_r($result); exit;
	//echo json_encode($result);
	//exit;
    
        //$result = $listing->listing();
       // $data = array();
        foreach ($result['result'] as $c) 
        {
            $btn_edit = '<button class="button1" onClick="call_to_edit('."'" .\Uri::create('reports/surveys/edit_survey/'. $c['CS_ContactSurvey_pk']). "'".')">Edit</button>';
                $data[] = array(
                    $c['CS_R_FullNumber_ind'],
                    $c['CS_ContactFullName'],
                    $c['CS_OrganisationFullName'] .' <br /><br /><div style="font-weight: bold;"> COMMENT :'.$c['CS_Comments'] . '</div>',   
                    $c['CS_SurveyVersion'] .' <br /><br /><div style="font-weight: bold;">RTURNED BY:' . $c['CS_ReturnedBy'] . '</div>',
                    $c['CS_DateSent'].' <br /><br /><div style="font-weight: bold;">CAR NO:'.$c['CS_CarNo']. '</div>',
                    $c['CS_DateReturned'],
                    $c['CS_ContactNotifiedOfOutcome'],
                    $c['CS_Outcome'],
                    $c['CS_OutcomeDate'],
                    $btn_edit
                );
            
        }

        $json = array(
            'sEcho' => (int) \Input::get('sEcho'),
            'iTotalRecords' => $result['count'],
            'iTotalDisplayRecords' => $result['count'],
            'aaData' => $data,
        );

        echo json_encode($json);
        exit;
        
        
        
        
    }

         /**
     * Parse the data from data grid fields and generate a Model_ instance, used for listing grid and, excel export
     * @return [type] [description]
     */
    function generate_listing()
    {
        $extra_search_fields = $advance_search_fields = array();
        
        foreach (\Input::param() as $key => $input)
        {
            if (empty($input))
                continue;

            //search for normal filters
            if (strpos($key, 'extra_search_') !== false and !empty($input))
            {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }

            //search for advance filters
            if (strpos($key, 'advance_search_') !== false and !empty($input))
            {
                $search_col = str_replace('advance_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $advance_search_fields[$search_col] = $input;
            }
        }

        $order_by = array();
        if (\Input::param('iSortCol_0') == 1)
        {
            $order_by['column'] = 'number';
        }

        if (\Input::param('iSortCol_0') == 2)
        {
            $order_by['column'] = 'contact';
        }
        
        if (\Input::param('iSortCol_0') == 3)
        {
            $order_by['column'] = 'organisation';
        }
        
        if (\Input::param('iSortCol_0') == 4)
        {
            $order_by['column'] = 'sent';
        }
        
        if (\Input::param('iSortCol_0') == 5)
        {
            $order_by['column'] = 'contact_notified';
        }
       
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        $no_of_records = (int) \Input::param('iDisplayLength', 10);
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new \Reports\Model_Survey(); 
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;

        return $listing;
    }
	   
    
    
    
    function action_add()
    {
	$view = \View::forge('survey/insert_contact_survey');
	//$rn_number = \Input::get('key');
	//$template_version = \Input::get('key');
	$rn_number = 'RN111890'; // TO BE REMOVED
	$template_version = 'Ver 1'; // TO BE REMOVED
	
	$fs = \Fieldset::forge('new_servey');
	
	$fs->add('rn_number', 'RN NUMBER :', array('type' => 'text', 'class' => 'textbox-1', 'value' => $rn_number), array(array('required')));
	$fs->add('template_version', 'TEMPLATE VERSION :', array('type' => 'text', 'class' => 'textbox-1', 'value' => $template_version), array(array('required')));
	$fs->add('submit', 'Submit :', array('type' => 'submit', 'value' => 'insert', 'class' => 'button1'));
	
	if ($fs->validation()->run()) {
	    
		$fields = $fs->validated();

		$stmt = $this->db->prepare("EXEC sp_insert_into_t_ContactSurvey @CS_R_FullNumber_ind=?, @CS_ContactSurvey_pk=?");
		$stmt->bindValue(1, $fields['rn_number']);
		$stmt->bindValue(2, $fields['template_version']);
		$stmt->execute();

		//TODO, get ID from stored procedure returns

	}

	$view->set('form', $fs->form(), false);
	$this->template->content = $view;
    }
    
     /**
     * JSON Dropdown Data
     * @return [type] [description]
     */
    function action_dropdown_data() 
    {
        $extra_search_fields = array();

        foreach (\Input::get() as $key => $input) 
        {
            if (empty($input))
                continue;

            if (strpos($key, 'extra_search_') !== false and !empty($input)) 
            {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }
        }

        $global_search = \Input::get('sSearch');
        $no_of_records = (int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::get('iColumns');
        $offset = \Input::get('iDisplayStart', 0);

        $listing = new \Reports\Model_Survey;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['csr_returned_by'] = $listing->get_returned_by();
        $data['csr_survey_version'] = $listing->get_survey_version();
        $data['csr_organsiation'] = $listing->get_organsiation();
    
        $data['csr_get_branches'] = $listing->get_branches();
        $data['csr_sections'] = $listing->get_sections();
        $data['csr_projects'] = $listing->get_projects();
        $data['csr_get_areas'] = $listing->get_areas();

        echo json_encode($data);
        exit;
    }
    
    function action_edit_survey($CS_ContactSurvey_pk){
       // $view = \View::forge('survey/edit_survey');
       //$this->set_iframe_template();
       // $this->template->content = $view;
        
        $this->set_iframe_template();
        $this->template->content =  \Reports\Subform_Editsurveys::forge()->render(array('CS_ContactSurvey_pk'=>$CS_ContactSurvey_pk));
    }
  
}