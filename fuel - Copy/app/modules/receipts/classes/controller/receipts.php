<?php

namespace Receipts;

class Controller_Receipts extends \Controller_Base {

    function action_index() {
        
        if(\Input::post('export_to_excel'))
        {
            $listing = $this->generate_listing();//generate model instance
            //print_r($listing);exit;
            $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/receipts');
        $view->body_classes = 'clr_receipt';
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar = \View::forge('sidebar/listing');
        $view->sidebar->job_branch = array();
        $view->sidebar->job_sector = array();
        $view->sidebar->job_project = array();
        $view->sidebar->job_area = array();
        $this->template->body_classes = array('clr_receipt');
        $this->template->content = $view;
    }

    function action_listing_data() {

        $listing = $this->generate_listing();
        $result  = $listing->listing();

        $data = array();

        foreach ($result['result'] as $c) 
          
        {
             
            $form_url = \Uri::create('mainform/index/?tab=2&quote_id='.$c['RD_YearSeq_pk']);
            $img_path = $this->get_image_url($c['RD_YearSeq_pk']);
            
            $img_btn  = '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" align="center" style=" background-color:#ffffa1;width:100%;height:34px;"><button class="spaced2  viewimage1" onclick="call_to_img(' . "'" . $img_path . "'" .')" ></button></div>';
            $data[] = array(
                '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#79bdb9;padding:2px; height:30px;"><button class="spaced1" href="'.$form_url.'">...</button></div>',
                '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#fce69d; padding:2px; height:30px;"><div id="NMB'.$c['Q_FullNumber'].'" " align="center"  style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['Q_FullNumber'].'</b></div></div>',
                $img_btn,
                '<div style="width:100%; background-color:#bcc1c2; padding:2px; height:30px;"><input type="text" name="LastName" value="'.$c['A_Description'].'" style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;width:94%;font-size: 11px;" readonly></div>',
                '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#95a7ed; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['OR1_FullName'].'</div></div>',
                '<div id="'.$c['Q_FullNumber'].'" onclick="selecter(this.id)" style="width:100%; background-color:#abd6d4; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa;height:15px;overflow:hidden;">'.$c['FullStatusString'].'</div></div>',
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

        $listing = new Model_Receipt;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

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
        $view = \View::forge('edit');
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
        if (\Input::param('iSortCol_0') == 1) 
        {
           $order_by['column'] = 'Number';
        }
        
        if (\Input::param('iSortCol_0') == 3) 
        {
            $order_by['column'] = 'Description';
        }
        
        if (\Input::param('iSortCol_0') == 4) 
        {
            $order_by['column'] = 'Fullname';
        }
        
         if (\Input::param('iSortCol_0') == 5) {
            $order_by['column'] = 'Status';
        }
        
        
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::param('sSearch');
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::param('iColumns');
        $offset = \Input::param('iDisplayStart', 0);

        $listing = new Model_Receipt;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;
//print_r($advance_search_fields);exit;
        return $listing;
    }
    
    /*
     * function dispatch_label - description
     * @param $RD_YearSeq_pk
     * @param type => f- form, l -label
     * @return null
     * @author Namal
     */
    public function action_generate_dispach($type, $RD_YearSeq_pk)
    {
        if ($type == 'f') {
            $generate_type = 'Despatch Form Template';
        
        } elseif ($type == 'l') {
            $generate_type = 'Despatch Label Template';
        }
                
      
        $data = \NMI_db::run_sp('sp_JobMergeData', 'J_YearSeq_pk', $RD_YearSeq_pk);
        
        $new_data_array = array();
        
        foreach ($data as $key => $val) {
                                
            if ($key%2 == 0) {
                $new_data_array[$val] = $data[++$key];
            }
                
        }
        
        $doc = \NMI_Doc::generate_template('DespatchLabel.dotx', $new_data_array);
        \NMI_Doc::save($doc, 'despatch_label.doc');
    }
    
    /*
     * function custom_proform_invoice - description
     * @param $RD_YearSeq_pk
     * @return null
     * @author Namal
     */
    public function action_custom_proform_invoice($RD_YearSeq_pk)
    {
        $job_exists = \Jobs\Model_Job::check_job_exists($RD_YearSeq_pk);
        
        if ($job_exists == false) {
            \Message::set('error', 'Unable to perform merge.  Job doesn\'t exist.');
            return false;
        }
        
        //format R_FullNumber_pk from RD_YearSeq_pk 20110001 => RN110001
        $R_FullNumber_pk = 'RN' . substr($RD_YearSeq_pk, -6);
        
        //gets data array
        $data = \NMI_db::run_sp('sp_ReportMergeData_v2', 'R_FullNumber_pk', $R_FullNumber_pk);
        
        $new_data_array = array();
        
        //format the array according to the template
        foreach ($data as $key => $val) {
                                
            if ($key%2 == 0) {
                $new_data_array[$val] = $data[++$key];
            }
                
        }
        
        //path of template
        $path = \Helper_App::GetPath('Customs proforma invoice');
        
        //generate the word
        $doc  = \NMI_Doc::generate_template('CustomsProformaInvoice.dotx', $new_data_array);
        \NMI_Doc::save($doc, 'Customs_Proform_Invoice.doc');
        
    }
    
    /*
     * Upload main image of a recipt
     * @return null
     * @author Namal
     */
    public function action_upload_main_image($RD_YearSeq_pk)
    {
        $this->set_iframe_template('file_content_upload');

        $fs = \Fieldset::forge('upload');
        $fs->add('image', 'image', array('type' => 'file'));
        $fs->add('RD_YearSeq_pk', 'RD_YearSeq_pk', array('type' => 'hidden'))->set_value($RD_YearSeq_pk);
        
        if ($fs->validation()->run()) {

            $fields = $fs->validated();
            
            try {
                
                $path = \Config::get('receipts_path') .'/'. $fields['RD_YearSeq_pk'] ;
                @mkdir($path); 
                $file_new_name = 'receipt_'. $fields['RD_YearSeq_pk']; 
                $file = \Nmi_File::upload_file('image', $path, array('new_name' => $file_new_name, 'overwrite' => true), true);
               // $path = $fields['RD_YearSeq_pk'].DS.$file['saved_as'];
                $path = $file['saved_as'];

                \NMI_Db::update('t_ReceiptAndDespatch', array('RD_ReceiptImagePath' => $path), array('RD_YearSeq_pk' => $fields['RD_YearSeq_pk']));
                //\Message::set('success', 'File upload Success');
                // return $this->close_iframe(null, true);
                echo'<script type="text/javascript">alert("File upload Success");</script>';
    
            } catch (\NMIUploadException $e) {
            
                //\Message::set('error', $e->getMessage());
                echo'<script type="text/javascript">alert("'.$e->getMessage().'");</script>';
            }

        } else {
            
            //\Message::set('error', $fs->validation()->error());
           //  echo'<script type="text/javascript">alert("'.$fs->validation()->error().'");</script>';
        
        }
    
        $view = \View::forge('upload');
        $this->set_iframe_template();
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;

    }
    
    
    
    
    
      /*
     * Upload main image of a recipt
     * @return null
     * @author Namal
     */
    public function action_upload_main_image_despatch($RD_YearSeq_pk)
    {
        $this->set_iframe_template('file_content_upload');

        $fs = \Fieldset::forge('upload');
        $fs->add('image', 'image', array('type' => 'file'));
        $fs->add('RD_YearSeq_pk', 'RD_YearSeq_pk', array('type' => 'hidden'))->set_value($RD_YearSeq_pk);
        
        if ($fs->validation()->run()) {

            $fields = $fs->validated();
            
            try {
                
                $path = \Config::get('despatch_path') .'/'. $fields['RD_YearSeq_pk'] ;
                @mkdir($path);
                $file_new_name = 'despath_'. $fields['RD_YearSeq_pk'];
                $file = \Nmi_File::upload_file('image', $path, array('new_name' => $file_new_name, 'overwrite' => true), true);
                //$path = $fields['RD_YearSeq_pk'].DS.$file['saved_as'];
                 $path = $file['saved_as'];

                \NMI_Db::update('t_ReceiptAndDespatch', array('RD_DespatchImagePath' => $path), array('RD_YearSeq_pk' => $fields['RD_YearSeq_pk']));
               // \Message::set('success', 'File upload Success');
                // return $this->close_iframe(null, true);
                echo'<script type="text/javascript">alert("File upload Success");</script>';
            } catch (\NMIUploadException $e) {
            
                //\Message::set('error', $e->getMessage());
                echo'<script type="text/javascript">alert("'.$e->getMessage().'");</script>';
            }

        } else {
            
            //\Message::set('error', $fs->validation()->error());
             //echo'<script type="text/javascript">alert("'.$fs->validation()->error().'");</script>';
        
        }
        $this->set_iframe_template('upload');
        $view = \View::forge('upload');
        $view->set('RD_YearSeq_pk',$RD_YearSeq_pk,false);
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;

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
	* Load View Image
	*Code by Sri
	**
	*/
	public function action_view_img_display($RD_YearSeq_pk){
            
			$input_para = \Input::get('type');
                        $data = Model_Receipt::get_receipt_dispatch($RD_YearSeq_pk);
                        
                        if($input_para=='d'){
                            $folder = 'despatch_file';
                            $path =$data['RD_DespatchImagePath'];
                        }else{
                            $folder = 'receipts_files';
                            $path =$data['RD_ReceiptImagePath'];
                        }
                        
                        if($input_para=='d'){
                            $cofig_path =\Config::get('despatch_path');
                        }else{
                            $cofig_path =\Config::get('receipts_uri');  
                        }

                        
                         $data = array('RD_YearSeq_pk'=>$RD_YearSeq_pk,
                                    'img_path'=>$path,
                                    'folder'=>$folder
                            );
                         
                    
                        $this->set_iframe_template('view_img');    
                        $view   = \View::forge('view_img');
                        $view->set('data', $data, false);
				
                        $this->template->content = $view;
			
		}

}