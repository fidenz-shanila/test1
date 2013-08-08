<?php

namespace Reports;

class Controller_Reportmaster extends \Controller_Base
{
    function action_index()
    {
        
        if(\Input::post('export_to_excel'))
        {
            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        $view                           = \View::forge('common/listing');
        $view->grid                     = \View::forge('grids/reportmaster');
         $view->body_classes = 'clr_reportmaster';
         $view->topmenu = \View::forge('grids/topmenu_reportmaster');
        $view->sidebar                  = \View::forge('sidebar/reportmaster');
        $view->sidebar->job_branch      = array();
        $view->sidebar->job_sector      = array();
        $view->sidebar->job_project     = array();
        $view->sidebar->job_area        = array();
        $this->template->body_classes   = array('clr_reportmaster');
        $this->template->content        = $view;
    }

    function action_listing_data()
    {
       
        $listing = $this->generate_listing();
        $result  = $listing->listing(); 
        
        $form_url   = \Uri::create('reports/reportmaster/report_master');
        $quote_url  = \Uri::create('reports/reportmaster/redirect_to_main_form/');
        //$form_url = \Uri::create('mainform/index/?tab=3&quote_id='.$c['R_J_YearSeq_fk_ind']);
        
            
        $data = array();
        foreach ($result['result'] as $c)
        {
            
            if((strtok($c['RML_DateOfReport'],' ')==false)){
                $dateOfReq='<div  style="width:100%; background-color:#E2C1A0; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.' '.'</div></div>';
            }else{
                $stp1=strtok($c['RML_DateOfReport'],' '); 
                $stp2=explode("-",$stp1);
                $stp3=$stp2[1].'/'.$stp2[2].'/'.$stp2[0];
                $dateOfReq='<div  style="width:100%; background-color:#E2C1A0; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$stp3.'</div></div>';
            }
            $data[] = array(      
                '<div  style="width:100%; background-color:#AEAE59;padding:2px; height:30px;"><button href="'. $form_url.'?id='.$c['RML_ReportNumber_pk'].'" type="button" class="spaced1" data-ID="' . $c['RML_ReportNumber_pk'] . '" value="..." />...</button></div>',
                '<div  style="width:100%; background-color:#C78645;padding:2px;height:30px; "><button href="'. $quote_url . $c['RML_QuoteNumber'].'/3'.'" class="spaced1">...</button></div>',
                '<div  style="width:100%; background-color:#E2C1A0;padding:2px;height:30px;  "><p  align="center" style="margin:5px;background-color:#D6D6D6;padding:2px;padding-left:5px;border: 1px solid #aaadaa;text-align:center height:15px;overflow:hidden;"><b>'.$c['RML_ReportNumber_pk'].'</b></p></div>',
                '<div  style="width:100%; background-color:#FEDD7A;padding:2px;height:30px;  "><button href="'. $quote_url . $c['RML_QuoteNumber'].'/1'.'" class="spaced1">...</button></div>',
                '<div  style="width:100%; background-color:#FEE69C;padding:2px;height:30px; "><p align="center"   style="margin:5px;background-color:#D6D6D6;padding:2px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;"><b>'.$c['RML_QuoteNumber'].'</b></p></div>',
                '<div  style="width:100%; background-color:#9D9D9D; padding:2px; height:30px;"><div   style="margin:5px;background-color:#D6D6D6;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['RML_Description'].'</div></div>',
                '<div  style="width:100%; background-color:#8FA5FA; padding:2px; height:30px;"><div   style="margin:5px;background-color:#D6D6D6;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['RML_OrganisationFullName'].'</div></div>',
                '<div  style="width:100%; background-color:#D7AEFF; padding:2px; height:30px;"><div   style="margin:5px;background-color:#D6D6D6;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['RML_TestOfficer'].'</div></div>',
                $dateOfReq,
                '<div  style="width:100%; background-color:#FFFFA6; padding:2px; height:30px;"><div   style="margin:5px;background-color:#D6D6D6;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['RML_FileNumber'].'</div></div>',
                 '<div  style="width:100%; background-color:#c2c48f; padding:2px; height:30px;"><div   style="margin:5px;background-color:#D6D6D6;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['RML_RecordDerivedFrom'].'</div></div>',
              
                
            );
        }

        $json = array(
            'sEcho'                 => (int) \Input::get('sEcho'),
            'iTotalRecords'         => $result['count'],
            'iTotalDisplayRecords'  => $result['count'],
            'aaData'                => $data,
        );

        echo json_encode($json);
        exit;
    }
    
    function action_redirect_to_main_form($Q_FullNumber, $tab_number)
    {
        $Q_YearSeq_pk = Model_Reportmaster::get_quote_number($Q_FullNumber);
        
        \Response::redirect('http://localhost/nmi-tc/public/index.php/mainform/index/?tab='. $tab_number .'&quote_id='. $Q_YearSeq_pk);
    }

    function action_dropdown_data()
    {
        $extra_search_fields  = array();

        foreach (\Input::get() as $key => $input) {
            if (strpos($key, 'extra_search_') !== false) {
                $search_col   = str_replace('extra_search_', '', $key);
                $search_col   = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }
        }

        $global_search        = \Input::get('sSearch');
        $no_of_records        = (int) \Input::get('iDisplayLength', 10);
        $no_of_columns        = \Input::get('iColumns');
        $offset               = \Input::get('iDisplayStart', 0);

        $listing              = new Model_Reportmaster;
        $listing->limit       = $no_of_records;
        $listing->offset      = $offset;
        $listing->filter      = $extra_search_fields;
    
        $org = $listing->get_organisation();
        //array_shift($org);
        $data['prefix']       = $listing->get_prefix();
        $data['year']         = $listing->get_year();
        $data['organisation'] = $org;
        $data['test_officer'] = $listing->get_test_officer();
        $data['source']       = $listing->get_source();

        echo json_encode($data);
        exit; 
    }

    function action_edit($id = null) {
        $view                    = \View::forge('edit');
        $this->template->content = $view;
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
           //search for normal filters
            if (strpos($key, 'extra_search_') !== false and !empty($input))
            {
                $search_col = str_replace('extra_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $extra_search_fields[$search_col] = $input;
            }else if (strpos($key, 'advance_search_') !== false and !empty($input))
            { 

            //search for advance filters
            
                $search_col = str_replace('advance_search_', '', $key);
                $search_col = str_replace('-', '.', $search_col);
                $advance_search_fields[$search_col] = $input;


            }else{
                 $extra_search_fields[$key] = $input;
                // $advance_search_fields[$key] = $input;
            }
        }
        
        $order_by = array();
        if (\Input::get('iSortCol_0') == 2) {
           $order_by['column']  = 'ReportNumber';
        }
        if (\Input::get('iSortCol_0') == 4) {
            $order_by['column'] = 'QuoteNumber';
        }
        if (\Input::get('iSortCol_0') == 6) {
            $order_by['column'] = 'Organisation';
        }
        if (\Input::get('iSortCol_0') == 7) {
            $order_by['column'] = 'TestOfficer';
        }
        if (\Input::get('iSortCol_0') == 8) {
            $order_by['column'] = 'DOR';
        }
        
        $order_by['sort']           = \Input::get('sSortDir_0');

        $global_search              = \Input::get('sSearch');
        if(!empty($extra_search_fields['limitData'])){
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::param('iDisplayLength', 10);
        }else{
            $no_of_records = '';
        }
        $no_of_columns              = \Input::get('iColumns');
        $offset                     = \Input::get('iDisplayStart', 0);

        $listing                    = new Model_Reportmaster; 
        $listing->limit             = $no_of_records;
        $listing->offset            = $offset;
        $listing->filter            = $extra_search_fields;
        $listing->order_by          = $order_by;
        $listing->search_criteria   = $advance_search_fields;

        return $listing;
    }
    
    public function action_report_master()
    {
        $this->set_iframe_template('report_master');
        $view = \View::forge('report_master');
		
		$id = \Input::param('id');
		$report_master_data_set = Model_Reportmaster::get_report_master_data($id);
		$rmdata = $report_master_data_set[0];
		
		$fs = \Fieldset::forge();
		$fs->add('RML_ReportNumber_pk', 'Report Number', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_ReportNumber_pk']));
		$fs->add('RML_Prefix', 'Prefix', array('type'=>'text', 'class' => 'textbox-2', 'value'=>$rmdata['RML_Prefix']));
		$fs->add('RML_RnSeq_ind', 'Sequential', array('type'=>'text', 'class' => 'textbox-2', 'value'=>$rmdata['RML_RnSeq_ind']));
		$fs->add('RML_RnYear', 'Report year', array('type'=>'text', 'class' => 'textbox-2', 'value'=>$rmdata['RML_RnYear']));
		$fs->add('RML_DateOfReport', 'Date of report', array('type'=>'text', 'class' => 'textbox-2 datepicker', 'value'=>$rmdata['RML_DateOfReport']));
		$fs->add('RML_QuoteNumber', 'Quote Number', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_QuoteNumber']));
		$fs->add('RML_QnSeq', 'Sequential', array('type'=>'text', 'class' => 'textbox-2', 'value'=>$rmdata['RML_QnSeq']));
		$fs->add('RML_QuoteDate', 'Quote Date', array('type'=>'text', 'class' => 'textbox-2 datepicker', 'value'=>$rmdata['RML_QuoteDate']));
		$fs->add('RML_Make', 'Make', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_Make']));
		$fs->add('RML_TestOfficer', 'Test Officer', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_TestOfficer']));
		$fs->add('RML_Model', 'Model', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_Model']));
		$fs->add('RML_FileNumber', 'File Number', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_FileNumber']));
		$fs->add('RML_SerialNumber', 'Serial Number', array('type'=>'text', 'class' => 'textbox-1', 'value'=>$rmdata['RML_SerialNumber']));
		$fs->add('RML_Description', 'Description', array('type'=>'textarea', 'class' => 'textarea-1', 'value'=>$rmdata['RML_Description']));
		$fs->add('RML_OrganisationFullName', 'Organisation', array('type'=>'textarea', 'class' => 'textarea-1', 'value'=>$rmdata['RML_OrganisationFullName']));
		$fs->add('RML_Contact', 'Contact', array('type'=>'text', 'class' => 'textbox-2', 'value'=>$rmdata['RML_Contact']));
		$fs->add('RML_ServicesOffered', 'Services offered', array('type'=>'textarea', 'class' => 'textarea-1', 'value'=>$rmdata['RML_ServicesOffered']));
		$fs->add('RML_SpecialRequirements', 'Special requirements', array('type'=>'textarea', 'class' => 'textarea-1', 'value'=>$rmdata['RML_SpecialRequirements']));
		$fs->add('RML_Comments', 'Comments', array('type'=>'textarea', 'class' => 'textarea-1', 'value'=>$rmdata['RML_Comments']));	
		$fs->add('RML_RecordDerivedFrom', 'Source', array('type'=>'text', 'class' => 'textbox-3', 'value'=>$rmdata['RML_RecordDerivedFrom']));
		$fs->add('RML_DateCreated', 'Date Created', array('type'=>'text', 'class' => 'textbox-3 datepicker', 'value'=>$rmdata['RML_DateCreated']));
		$fs->add('RML_LastUpdated', 'Date last updated', array('type'=>'text', 'class' => 'textbox-3 datepicker', 'value'=>$rmdata['RML_LastUpdated']));
		$fs->add('submit', 'Submit', array('type' => 'submit', 'value' => 'close', 'class' => 'button1'));
		
		if ($fs->validation()->run()) {
                $fields = $fs->validated();
                
                        $fields['RML_DateOfReport'] = \NMI_Db::format_date($fields['RML_DateOfReport']);
                        $fields['RML_QuoteDate'] = \NMI_Db::format_date($fields['RML_QuoteDate']);
                        $fields['RML_DateCreated'] = \NMI_Db::format_date($fields['RML_DateCreated']);
                        $fields['RML_LastUpdated'] = \NMI_Db::format_date($fields['RML_LastUpdated']);
                        
			$data_array = $fields;
			unset($data_array['RML_ReportNumber_pk']);
			unset($data_array['submit']);
			$where_array = array('RML_ReportNumber_pk' => $fields['RML_ReportNumber_pk']);
			\Nmi_Db::update('t_ReportMasterList', $data_array, $where_array);
			
			\Response::redirect('reports/report_master/?id='.$id);
        }
		
		$view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }

}