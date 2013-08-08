<?php

namespace Reports; 

class Controller_Reports extends \Controller_Base {

    function action_index() 
    {
        if(\Input::post('export_to_excel'))
        {
            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/reports');
        $view->body_classes = 'clr_report';
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar = \View::forge('sidebar/listing');
        $view->sidebar->job_branch = array();
        $view->sidebar->job_sector = array();
        $view->sidebar->job_project = array();
        $view->sidebar->job_area = array();
        $this->template->body_classes = array('clr_report');
        $this->template->content = $view;
    }

    function action_listing_data() 
    {

        $listing = $this->generate_listing();
        $result = $listing->listing();
        

        $data = array();
        //$form_url = \Uri::create('mainform/index/?tab=3');
        foreach ($result['result'] as $c) {
//$FullStatusString=strlen($c['FullStatusString']);

        
                    $form_url = \Uri::create('mainform/index/?tab=3&quote_id='.$c['R_J_YearSeq_fk_ind']);
                    $img_path = $this->get_image_url($c['R_J_YearSeq_fk_ind']);
                    
            $img_btn  = '<div onclick="selecter(this.id)" id="'.$c['R_FullNumber_pk'].'" onclick="selecter()" align="center" style=" background-color:#fce69d;width:100%;height:32px;"><button class="spaced2 viewimage1" onclick="call_to_img(' . "'" . $img_path . "'" .') " ></button></div>';
            $data[] = array(
               '<div id="'.$c['R_FullNumber_pk'].'" onclick="selecter(this.id)" style="width:100%; background-color:#D19F6D;padding:2px; height:30px;"><button class="spaced1" href="'.$form_url.'"><b>...<b></button><div>',
                '<div id="NMB'.$c['R_FullNumber_pk'].'" "  align="center"   style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['R_FullNumber_pk'].'</b></div>',
                '<div id="'.$c['R_FullNumber_pk'].'" onclick="selecter(this.id)" align="center" style=" background-color:#e0c2a2;width:100%;height:32px;"><button style="margin:5px;"onclick="call_to_pdf()"  >pdf</button></div>',
                $img_btn,
                '<div id="'.$c['R_FullNumber_pk'].'" onclick="selecter(this.id)" style="width:100%; background-color:#9c9c97; padding:2px; height:30px;"><div onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['A_Description'].'</div></div>',
                '<div id="'.$c['R_FullNumber_pk'].'" onclick="selecter(this.id)" style="width:100%; background-color:#95a7ed; padding:2px; height:30px;"><div onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['OR1_FullName'].'</div></div>',
                '<div id="'.$c['R_FullNumber_pk'].'" onclick="selecter(this.id)" style="width:100%; background-color:#e0c2a2; padding:2px; height:30px;"><div onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['FullStatusString'].'</div></div>',
               // $c['R_ReportPath']
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

    function action_dropdown_data() 
    {
        $extra_search_fields = array();

        foreach (\Input::get() as $key => $input) 
        {
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

        $listing = new Model_Report; 
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['branch']  = $listing->get_branches();
        $data['section'] = $listing->get_sections();
        $data['project'] = $listing->get_projects();
        $data['area']    = $listing->get_areas();
        $data['type']    = $listing->get_types();
        $data['owner']   = $listing->get_owns();
        $data['test_officer'] = $listing->get_test_offices();


        echo json_encode($data);
        exit;
    }

    function action_edit($id = null) {
        $view = \View::forge('edit');
        $this->template->content = $view;
    }

    /**
     * Report iframe to show in jobs tab of mainform
     * @return [type] [description]
     */
    function action_mainform_report($report_id)
    {
        $this->template =  \View::forge('template_strip');
       
        $form = \Reports\Subform_Report::forge();
        $view = $form->get_view();
        $view->report_id = $report_id;
        $quote_id = \Input::get('quote_id');
        

        $form->render(array('report_id' => $report_id,'quote_id'=>$quote_id));

        if (\Input::post('save')) {
            $form->update(\Input::post('reports'));
        }

        $this->template->content = $form->render(array('report_id' => $report_id,'quote_id'=>$quote_id));
    }
    
     /**
     * Insert next Revision
     * @param int A_YearSeq_pk
     * @author Namal
     */
    function action_next_revision()
    {
        $current_report = \Input::get('R_FullNumber_pk');
        $A_YearSeq_pk = \Input::get('R_J_YearSeq_fk_ind');
        
        $report = Model_Report::get_report($current_report);

        if (empty($report['R_OutCome']) or empty($report['R_OutCome_Date'])) {        
             \Message::set('error', 'Next issue cannot be created as this issue has not been closed out.');
           
        } else {
            Model_Report::insert_next_revision($A_YearSeq_pk);
        
        }
        
        \Response::redirect(\Uri::create('reports/mainform_report/'.$current_report.'/?quote_id='.$A_YearSeq_pk));
            
    }
    
    /**
     * Delete revision
     * @param 
     * @author Namal 
     */
    function action_delete_report()
    {
        $R_FullNumber_pk = \Input::param('R_FullNumber_pk');
        $quote_id        = \Input::param('quote_id');
        $return = Model_Report::delete_report($R_FullNumber_pk); 
        if($return == 0){
             \Message::set('error', 'There must ne at least one report attached to this job.  Delete Report cancelled.');
        }
        
        \Response::redirect('reports/mainform_report/'.$R_FullNumber_pk.'?quote_id='.$quote_id);
        //TODO, return = '1' logic
        
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
            }
        }
        
        

        //order by
        $order_by = array();
        if (\Input::param('iSortCol_0') == 1) {
           $order_by['column'] = 'Number';
        }
        if (\Input::param('iSortCol_0') == 4) {
            $order_by['column'] = 'Description';
        }
        
         if (\Input::param('iSortCol_0') == 5) {
            $order_by['column'] = 'Client';
        }
        
         if (\Input::param('iSortCol_0') == 6) {
            $order_by['column'] = 'Status';
        }
        
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
      
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::param('iDisplayLength', 10);
        
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Report;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;
        //print_r($listing->search_criteria);exit;
        return $listing;
    }

    /**
     * Send the user defined template help document
     */
    function action_user_defined_template_help()
    {
        $doc = \Nmi_doc::generate_template('ReportMailMergeBookmarks.dotx');
        \Nmi_doc::save($doc, 'ReportMailMergeBookmarks.doc');
    }
    

    /*
     * function build report - description
     * @param $R_J_YearSeq_fk_ind
     * @return $f_path
     * @author Namal
     */
    public function action_build_report()
    {
        
        $R_J_YearSeq_fk_ind = \Input::param('R_J_YearSeq_fk_ind');
        $R_FullNumber_pk    = \Input::param('R_FullNumber_pk');
        
        $path = \Config::get('cb_files_path'); //path
        $year = (int)$R_J_YearSeq_fk_ind / 10000;
        $report_number = str_replace('/', '_', $R_FullNumber_pk);
        
        $f_path = $path.DS.$year.DS.$report_number.'.pdf';
        
        return $f_path;
    }
    
    /*
     * function action_cb_file_cover_sheet - generate word doc for cb file cover
     * @param int $R_FullNumber_pk
     * @return - download
     * @author Namal
     */
    public function action_cb_file_cover_sheet($R_FullNumber_pk)
    {
        $cover_sheet = Model_Report::cb_file_cover_sheet($R_FullNumber_pk);
        
        $new_data_array = \Helper_App::format_array($cover_sheet);
        
        $doc = \Nmi_doc::generate_template('CbFileCoverSheet.dotx', $new_data_array);
        \Nmi_doc::save($doc, 'CbFileCoverSheet.doc');
    }
    
    /*
	* Load View Image
	*Code by Sri
	**
	*/
        
        public function get_image_url($A_YearSeq_pk)
        { 
            $artifact_info = \Artefacts\Model_Artefact::get_artifact_info($A_YearSeq_pk); 
            $path = '';
            if($artifact_info['A_ArtefactMainImagePath'] !=''){
                $path = \Config::get('artefact_parth') .DS. $A_YearSeq_pk .DS . $artifact_info['A_ArtefactMainImagePath'] ;
                $path = '../../../files/artefact/' . $A_YearSeq_pk .'/'. $artifact_info['A_ArtefactMainImagePath'] ;
                return $path;
            }else{
              return $path;
            }

         }
    
    
    /*
     * function open_standard_report_template - description
     * @param $arg
     * @return null
     * @author Namal
     */
    public function action_open_standard_report_template()
    {
        //MsgBox "To obtain the 'Standard Report Template', perform a 'Save As' on the following Template."
        $doc = \Nmi_doc::generate_template('StandardReportTemplate.dotx');
        \Nmi_doc::save($doc, 'StandardReportTemplate.doc');
    }
    
}