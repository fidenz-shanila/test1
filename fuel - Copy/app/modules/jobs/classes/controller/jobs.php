<?php

namespace Jobs;

class Controller_Jobs extends \Controller_Base {

    function action_index() {
        
         if(\Input::post('export_to_excel'))
        {
            $listing = $this->generate_listing();//generate model instance
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/jobs');
        $view->body_classes = 'clr_job';
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar = \View::forge('sidebar/listing');
        $view->sidebar->job_branch = array();
        $view->sidebar->job_sector = array();
        $view->sidebar->job_project = array();
        $view->sidebar->job_area = array();
        $this->template->body_classes = array('clr_job');
        $this->template->content = $view;
    }

    function action_listing_data() {

        $listing = $this->generate_listing();
        $result  = $listing->listing();

        $data = array();
        
        foreach ($result['result'] as $c) {
            $form_url = \Uri::create('mainform/index/?tab=3&quote_id='.$c['J_YearSeq_pk']);
            $img_path = $this->get_image_url($c['J_YearSeq_pk']);
            
            $img_btn  = '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" align="center" style=" background-color:#fce69d;width:100%;height:32px;"><button class="spaced2  viewimage1"  onclick="call_to_img(' . "'" . $img_path . "'" .')" ></button></div>';
            $data[] = array(
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#7aebab;padding:2px; height:30px;"><button class="spaced1" href="'.$form_url.'"><b>...<b></button><div>',
                '<div id="NMB'.$c['J_FullNumber'].'" align="center"  style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['J_FullNumber'].'</b></div>',
                $img_btn,
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#9c9c97; padding:2px; height:30px;"><div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['A_Description'].'</div></div>',
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#95a7ed; padding:2px; height:30px;"><div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['OR1_FullName'].'</div></div>',
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#aaf2ca; padding:2px; height:30px;"><div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['FullStatusString'].'</div></div>',
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

        $listing = new Model_Job;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['branch'] = $listing->get_branches();
        $data['section'] = $listing->get_sections();
        $data['project'] = $listing->get_projects();
        $data['area'] = $listing->get_areas();
        $data['type'] = $listing->get_types();
        $data['owner'] = $listing->get_owns();
        $data['test_officer'] = $listing->get_test_officers();

        echo json_encode($data);
        exit;
    }

    function action_edit($id = null) 
    {
        $view = \View::forge('edit');
        $this->template->content = $view;
    }
    
    function action_delete($job_id)
    {
        Model_Job::delete($job_id);
        \Message::set('success', 'Job has been deleted.');
        \Response::redirect('jobs');
    }

    function action_search_jobs() 
    {
        $view = \View::forge('search_for_jobs');
        $this->template->content = $view;
    }
    
    /**
     * Delays
     * @author Namal
     */

    function action_delays($J_YearSeq_pk) 
    {        
        $fs = \Fieldset::forge('delays');
        $fs->add('entered', 'ENTERED BY :', array('value' => \NMI::current_user('full_name_no_title'), 'class' => 'textbox-1' ), array(array('required')));
        $fs->add('date', 'START DATE :', array('type' => 'text', 'class' => 'datepicker textbox-1' ), array(array('required')));
        $fs->add('description', 'DESCRIPTION :', array('type' => 'textarea', 'class' => 'textarea-1' ), array(array('required')));
        
        if ($fs->validation()->run()) {
            
            $fields = $fs->validated();
            
            $return = Model_Job::add_delay_log('client delay', $fields['entered'], $fields['date'], $fields['description'], $J_YearSeq_pk);
                
                if ($return == 1) {
                    \Message::set('error', 'You can\'t delay a job that is already complete.  Insert cancelled.');
                    
                } elseif ($return == 2) {
                    \Message::set('error', 'There is a delay already in progress.  Insert cancelled.');
                }
                else {
                    \Message::set('success', 'Job delay inserteed.');
                }

        } else {
            \Message::set('error', $fs->validation()->error());
        }
        
        $this->set_iframe_template('delays');
        $view = \View::forge('delays');
        $view->J_YearSeq_pk = $J_YearSeq_pk;
        $view->set('form', $fs->form(), false);
        $view->set('log', Model_Job::delay_list_log($J_YearSeq_pk), false);
        $this->template->content = $view;
    }
    
    /**
     * add end date for job delay
     * @author Namal
     */
    
    public static function action_add_end_date_for_job_delay()
    {
        $JD_EndDate = \Input::param('JD_EndDate');
        $JD_DelayID_pk = \Input::param('JD_DelayID_pk');
        $J_YearSeq_pk = \Input::param('J_YearSeq_pk');
        
        Model_Job::add_end_date($JD_EndDate, $JD_DelayID_pk);
        \Response::redirect('jobs/delays/'.$J_YearSeq_pk );
    }
    
    
    /**
     * delete job delay
     * @author Namal
     */
    
    public static function action_delete_job_delay()
    {
        $JD_DelayID_pk = \Input::param('JD_DelayID_pk');
        $J_YearSeq_pk  = \Input::param('J_YearSeq_pk');
        
        Model_Job::delete_job_delay($QM_QuoteModuleID_pk);
        \Response::redirect('jobs/delays/'.$J_YearSeq_pk );
    }

    function action_change_fee_due() 
    {
        
        $J_YearSeq_pk = \Input::param('J_YearSeq_pk');
        $works = Model_Job::get_work_done_by($J_YearSeq_pk);
        $job     = \Jobs\Model_Job::get_job($J_YearSeq_pk);
        
        $this->set_iframe_template('change_fee_due');
        $view = \View::forge('change_fee_due');
        $view->set('works', $works, false);
        $view->set('job',$job,false);
        $this->template->content = $view;
    }
    
    /**
     * Edit fee due in the change fee dur form
     * @author Namal
     */
    public function action_edit_fee_due()
    {
        $WDB_FeeDue = \NMI_Db::reset_number_format(\Input::param('WDB_FeeDue'));
        $WDB_WorkDoneBy_pk = \Input::param('WDB_WorkDoneBy_pk');
        $J_FeeJustification = \Input::param('J_FeeJustification');
        $J_FeeJustificationStatus = \Input::param('J_FeeJustificationStatus');
        $J_YearSeq_pk   =   \Input::param('J_YearSeq_pk');
        $J_FeeDue       = \NMI_Db::reset_number_format(\Input::param('J_FeeDue'));
        $return = Model_Job::edit_fee_due( $WDB_FeeDue, $WDB_WorkDoneBy_pk,$J_FeeJustification,$J_YearSeq_pk,$J_FeeDue,$J_FeeJustificationStatus);
        return $return;
        exit;
    }
    
    
    /**
     * Parse the data from data grid fields and generate a Model_ instance, used for listing grid and, excel export
     * @return [type] [description]
     */
    function generate_listing()
    {
       $extra_search_fields = $advance_search_fields = array();

         foreach (\Input::param() as $key => $input) {
            if (empty($input))
                continue;

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
        
       
        $order_by = array();
        if (\Input::get('iSortCol_0') == 1) {
           $order_by['column'] = 'Number';
        }

       if (\Input::get('iSortCol_0') == 3) {
            $order_by['column'] = 'Description';
       }
      
       if (\Input::get('iSortCol_0') == 4) {
            $order_by['column'] = 'Organisation';
       }
       
        if (\Input::get('iSortCol_0') == 5) {
            $order_by['column'] = 'Status';
       }

       
       
       $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        if(!empty($extra_search_fields['limitData'])){
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::param('iDisplayLength', 10);
        }else{
            $no_of_records = '';
        }
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Job;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;

        return $listing;
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

    
    public function action_change_fee_due_window(){
        $x  =   \Input::param('x');
        $value = \Input::param('val');
        $view = \View::forge('make_change');
        $this->set_iframe_template();
        $view->set('x', $x);
        $view->set('val', $value);
        $this->template->content = $view;
    }
    

}