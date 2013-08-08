<?php

namespace Invoices;

class Controller_Invoices extends \Controller_Base
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
        $view->body_classes = 'clr_invoice';
        $view->grid                     = \View::forge('grids/invoices');
        $view->topmenu                  = \View::forge('grids/topmenu');
        $view->sidebar                  = \View::forge('sidebar/listing');
        $view->sidebar->job_branch      = array();
        $view->sidebar->job_sector      = array();
        $view->sidebar->job_project     = array();
        $view->sidebar->job_area        = array();
        $this->template->body_classes   = array('clr_invoice');
        $this->template->content        = $view;
    }

    function action_listing_data()
    {
        
        $listing = $this->generate_listing();
        $result  = $listing->listing();

        $data = array();
        $form_url = \Uri::create('mainform/index/?tab=4');
        foreach ($result['result'] as $c)
        {
            $form_url = \Uri::create('mainform/index/?tab=4&quote_id='.$c['J_YearSeq_pk']);

            $data[] = array(  
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#8696c4;padding:2px; height:30px;"><button class="spaced1" href="'.$form_url.'">...</button></div>',
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#bac7de; padding:2px; height:30px;"><div id="NMB'.$c['J_FullNumber'].'" " align="center"  style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['J_FullNumber'].'</b></div></div>',
                 '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#9c9c97; padding:2px; height:30px;"><div onclick="selecter(this.id)"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['A_Description'].'</div></div>',
               '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#95a7ed; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['OR1_FullName'].'</div></div>',
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#bac7de; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['FullStatusString'].'</div></div>',
                '<div id="'.$c['J_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#bac7de; padding:2px; height:30px;"><div align="center"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.\NMI_Db::set_number_format($c['J_FeeDue']).'</div></div>'
                
            );
        }
        //print_r($c['A_Description']);exit;

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
        {;
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

        $listing = new Model_Invoice;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
//print_r($listing->get_branches());exit;
        $data['branch'] = $listing->get_branches();
        $data['section'] = $listing->get_sections();
        $data['project'] = $listing->get_projects();
        $data['area'] = $listing->get_areas();
        $data['type'] = $listing->get_types();
        $data['owner'] = $listing->get_owns();
        $data['test_officer'] = $listing->get_test_offices();

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
           $order_by['column']  = 'Number';
        }
        if (\Input::get('iSortCol_0') == 2) {
            $order_by['column'] = 'Description';
        }
        if (\Input::get('iSortCol_0') == 3) {
            $order_by['column'] = 'Fullname';
        }
        if (\Input::get('iSortCol_0') == 4) {
            $order_by['column'] = 'Status';
        }
        if (\Input::get('iSortCol_0') == 5) {
            $order_by['column'] = 'Dev';
        }
        
        
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Invoice;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;
//print_r($advance_search_fields);exit;
        return $listing;
    }
    
    
    /*
     * function cmdMergeBillingInfo_Click - description
     * @param $J_FullNumber
     * @param $J_ProjectCodeSummary
     * @return null
     * @author Namal
     */
    public static function action_billing_info($quote_id)
    {
        $job_data = \Jobs\Model_Job::get_job($quote_id);

        if (empty($job_data['J_ProjectCodeSummary']) ) {

            \Message::set('error', 'Please complete the \'Project Code Summary\' before proceeding.');
            \Response::redirect("mainform/index/?tab=3&quote_id={$quote_id}#tab5");
            return false;
        
        }
        
        //format J_FullNumber from RD_YearSeq_pk 20110001 => RN110001
        $R_FullNumber_pk = 'RN' . substr($job_data['J_FullNumber'], -6);
        
        //gets data array
        //TODO don't use the run_sp create a spearate method to get the array of data
        $data = \NMI_db::run_sp('sp_ReportMergeData_v2', 'R_FullNumber_pk', $R_FullNumber_pk);
        
        $new_data_array = \Helper_App::format_array($data);
        
        //path of template
        $path = \Helper_App::GetPath('Billing Info template');
        
        //generate the word
        $doc  = \NMI_Doc::generate_template('BillingInformation.dotx', $new_data_array);
        \NMI_Doc::save($doc, 'Billing_Information.doc');
    }

}