<?php

namespace Files;

class Controller_Files extends \Controller_Base {

    function action_index() 
    {
   
        if(\Input::post('export_to_excel'))
        {
            $listing = $this->generate_listing();//generate model instance
            //print_r($listing);exit;
           // print_r(\Input::all());exit;
           $listing->limit = \Input::post('export_to_excel_limit', 'ALL');
            \NMI::send_excel($listing->excel_results());
        }
        
        $view = \View::forge('common/listing');
        $view->grid = \View::forge('grids/files');
         $view->body_classes = 'clr_files';

        if (\Input::param('is_selectable')) {
            $this->set_iframe_template('clr_files');
            $view->grid->data_url = \Uri::create('files/listing_data/?is_selectable=true');
        } else {
            $view->grid->data_url = \Uri::create('files/listing_data');
        }  
        
        $view->topmenu = \View::forge('grids/topmenu');
        $view->sidebar = \View::forge('sidebar/listing');
        $view->sidebar->job_branch = array();
        $view->sidebar->job_sector = array();
        $view->sidebar->job_project = array();
        $view->sidebar->job_area = array();
        $this->template->body_classes = array('clr_files');
        $this->template->content = $view;
    }

    function action_listing_data() 
    {
        
        $listing = $this->generate_listing();
        $result  = $listing->listing();

        $data = array();
        foreach ($result['result'] as $c) 
        {
            $form_url = \Uri::create('files/edit?CF_FileNumber_pk='.$c['CF_FileNumber_pk']);
            $img_btn  = '<div  align="center" style=" background-color:#ffffb0;width:100%;height:32px;"><button class="spaced2 viewimage1 "   ></button></div>';
            //print_r(\Input::param());exit;
            if (\Input::param('is_selectable')) {
                $action = '<div id="divForButton" style="width:100%; background-color:#ffff80;padding:2px; height:30px;"><input   type="button" class="select_file spaced3" data-id="' . $c['CF_FileNumber_pk'] . '" data-title="' . $c['CF_Title'] . '" value="<" /><input   type="button" class="spaced3" value=".." /></div>';
            } else {
                $action ='<div style="width:100%; background-color:#ffff80;padding:2px; height:30px;"><input class="spaced1"  type="button" value=".." /></div>';
                //$action = '<div style="width:100%; background-color:#ffff80;padding:2px; height:30px;"><input class="spaced1" href="'.$form_url.'" type="button" value=".." /></div>';
                
            }

            $data[] = array(
                //$action,
               $action,
                '<div  style="width:100%; background-color:#ffffb0; padding:2px; height:30px;"><div  align="center"  style="margin:5px;background-color:#d5d6d0;padding:2px;padding-left:5px;border: 1px solid #aaadaa;"><b>'.$c['CF_FileNumber_pk'].'</b></div></div>',
                $img_btn,
                '<div  style="width:100%; background-color:#ffffb0; padding:2px; height:30px;"><div   style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['CF_Title'].'</div></div>',
                '<div  style="width:100%; background-color:#daadff; padding:2px; height:30px;"><div align="center"  style="margin:5px;background-color:#d5d6d0;padding:0px;padding-left:5px;border: 1px solid #aaadaa; height:15px;overflow:hidden;">'.$c['CF_FileLocation'].'</div></div>',
                //$action,
                 '<div style="width:100%; background-color:#ffff80;padding:2px; height:30px;"><input class="spaced1 select_item_file" data-id="' . $c['CF_FileNumber_pk'] . '" type="button" value=".." /></div>',
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

        $listing = new Model_File;
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;

        $data['year'] = $listing->get_year();
        $data['type'] = $listing->get_types();
        $data['file_type'] = $listing->get_file_type();
        $data['branch'] = $listing->get_branches();
        $data['section'] = $listing->get_sections();
        $data['project'] = $listing->get_projects();
        $data['area'] = $listing->get_areas();
        $data['test_officer'] = $listing->get_test_offices();
        $data['owner'] = $listing->get_org();
        $data['owner_type'] = $listing->get_org_type();


        echo json_encode($data);
        exit;
    }
    
    /**
     * form edit cb file
     * @author Namal
     */
    function action_edit() 
    {
        $CF_FileNumber_pk = \Input::param('CF_FileNumber_pk');
        $cb_file_content  = Model_File::get_cb_file_content($CF_FileNumber_pk);
        
        $fs = \Fieldset::forge('edit');
        $fs->add('title', 'TITLE :', array('type' => 'textarea'), array(array('required')))->set_value($cb_file_content['CF_Title']);
        $fs->add('current_location', 'CURRENT LOCATION :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')))->set_value($cb_file_content['CF_FileLocation']);
        $fs->add('cl_date_at_location', 'Date at Location :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')))->set_value($cb_file_content['CF_FileLocationDate']);
        $fs->add('requested_location', 'REQUESTED LOCATION :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')))->set_value($cb_file_content['CF_FileRequestLocation']);
        $fs->add('rl_date_at_location', 'Date at Location :', array('type' => 'text', 'class' => 'textbox-1'), array(array('required')))->set_value($cb_file_content['CF_FileRequestDate']);
        
        $this->set_iframe_template('edit');
        $view = \View::forge('edit');
        $view->set('form', $fs->form(), false);
        $view->CF_Year = $cb_file_content['CF_Year'];
        $view->set('CF_FileNumber_pk', $CF_FileNumber_pk, false);
        $view->set('cb_file_content', Model_File::get_cb_file_listing($CF_FileNumber_pk), false);
        $this->template->content = $view;
    }
    
    /**
     * insert new file
     * @author Namal
     */ 
    function action_new_file()
    {
        $fs = \Fieldset::forge('insert_file');
        $fs->add('type', 'Type :', array('type' => 'select', 'class' => 'select-1', 'options' => array('CB' => 'CB', 'MC' => 'MC', 'CG' => 'CG'), array(array('required'))));
        $fs->add('optsite', '', array('options' => array('1' =>'Syd', '2' =>'Melb'), 'type' => 'radio', 'class' => 'optsite', 'value' => 'true'));
        $fs->add('year', 'YEAR :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'year'), array(array('required')));
        $fs->add('seq', 'SEQ :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'seq' ), array(array('required'))); 
        $fs->add('fill_number', 'FILL NUMBER :', array('type' => 'text', 'class' => 'textbox-1', 'id' => 'fill','readonly'=>'readonly' )); 
        $fs->add('title', 'TITLE :', array('type' => 'textarea', 'class' => 'textarea-1' ), array(array('required'))); 
        
        if ($fs->validation()->run()) {
            
            $fields = $fs->validated();
           // print_r($fields['type']);exit;
            $code = Model_File::insert_new_file($fields['type'], $fields['year'], $fields['seq'], $fields['title']);
            
            if ($code == 0) {
            
                //\Message::set('error', 'THIS FILE ALREADY EXISTS!!  Record not created.');
                echo "<script>message()</script>";
            
            } else {
            
                //\Message::set('success', 'File inserted.');
                echo "<script>parent.$('body').css('overflow','auto'); parent.refrashListing(); parent.$('#InsertNewFile').dialog('close');</script>";exit;
                \Response::redirect("files");
            }
            
        } else {

            \Message::set('error', $fs->validation()->error());

        }
        
        $this->set_iframe_template('insert_file');
        $view = \View::forge('insert_file');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;
    }
    
    /**
     * get next number in cb file
     * @author Namal
     */
    function action_get_next()
    {
        $type = \Input::param('type');
        $optsite = 'SYD';
        
        $data = Model_File::get_next_number($optsite, $type);
        $CF_FileNumber_pk = Model_File::build_number($type, $data['Next_Year'], $data['Next_Seq']);
        $return = array_merge($data, $CF_FileNumber_pk);

        return json_encode($return);
    }
    
    /**
     * build number in cb file
     * @author Namal
     */ 
    function action_build_number()
    {
        $type     = \Input::param('type');
        $optsite  = \Input::param('seq');
        $year     = \Input::param('year');

        $CF_FileNumber_pk = Model_File::build_number($type, $year, $optsite);
        
        return json_encode($CF_FileNumber_pk);
    }
    
    function action_file_location($id) 
    {   
       // print_r( );exit;
       $CF_FileNumber_pk=str_replace(",","/",$id);
        $locations =  Model_File::get_cb_location_list();
       
        if (\Input::All('close_locations')) {
            //print_r('e');exit;
            $fields = \Input::All();
             
            if(isset($fields['date_at_location'])){
                $fields['date_at_location']=\NMI_Db::format_date($fields['date_at_location']);
            }
           // print_r($fields['date_at_location']);exit;
            if(isset($fields['date_required'])){
               $fields['date_required']= \NMI_Db::format_date($fields['date_required']);
            }
            $set='';
             $set .= isset($fields['current_location'])  && !empty($fields['current_location']) ? "CF_FileLocation = '{$fields['current_location']} '," : null;
             $set .= isset($fields['date_at_location'])  && !empty($fields['date_at_location']) ? "CF_FileLocationDate = '{$fields['date_at_location']} '," : null;
             $set .= isset($fields['requested_location'])  && !empty($fields['requested_location']) ? "CF_FileRequestLocation = '{$fields['requested_location']}' ," : null;
             $set .= isset($fields['date_required'])  && !empty($fields['date_required']) ? "CF_FileRequestDate = '{$fields['date_required']}'," : null;
           
            $update_set=substr($set, 0, -1);
          // print_r($update_set);exit;
            Model_File::update_cb_location_list($update_set,$CF_FileNumber_pk);
        }
        
        $setOfLocations =  Model_File::get_cb_file_content($CF_FileNumber_pk);
       //print_r($setOfLocations);exit;
         //print_r($locations);exit;
       // echo $setOfLocations['CF_FileLocation'];
        $fs = \Fieldset::forge('');
        $fs->add('current_location', 'Current_Location :', array('type' => 'select', 'class' => 'select-1', 'options' => array(''=>'')+$locations,'id'=>'FrmInsert_officer1', array(array('required'))))->set_value(trim($setOfLocations['CF_FileLocation']));
        $fs->add('requested_location', 'Requested_Location :', array('type' => 'select', 'class' => 'select-1', 'options' => array(''=>'')+$locations,'id'=>'FrmInsert_officer2', array(array('required'))))->set_value(trim($setOfLocations['CF_FileRequestLocation']));
                
        
        
        
       $this->set_iframe_template('file_location_form');
        $view = \View::forge('file_location_form');
        $view->set('form', $fs->form(), false);
        $view->set('setOfLocations', $setOfLocations, false);
         $view->set('CF_FileNumber_pk', $CF_FileNumber_pk, false);
        $this->template->content = $view;
        
    }
    
    
    function action_update_cb_file_form(){		
            $fields = \Input::all();
            $fields	=	$fields['files'];
            $this->set_iframe_template();
            $this->template->content = \Files\Subform_cbfileform::forge()->update($fields);
            echo "<script type='text/javascript'>parent.jQuery.fn.colorbox.close();</script>";
    }
        
        

    function action_move_attached()
    {
        $param = \Input::all(); 
        $this->set_iframe_template();
        $view = \View::forge('move_attached');
        $view->set('field',$param);
        $this->template->content = $view;
    }
    
    function action_move_attached_info()
    {
        $fields = \Input::all(); 
        $this->set_iframe_template();
        $move_file = Model_File::do_move_attached($fields);
        return $move_file.\Response::redirect(\Uri::create('Files/move_attached/?quote_id='.$fields['quote_id'].'&AI_CF_FileNumber_fk='.$fields['from_AI_CF_FileNumber_fk'].'&AI_AttachedInfoID_pk='.$fields['from_AI_AttachedInfoID_pk']));;
        exit;
    }
    
    function action_delete_attached()
    {
        $quoteid   = \Input::get('quoteid');
        $AI_AttachedInfoID_pk = \Input::get('AI_AttachedInfoID_pk');
        Model_File::delete_attached_info($AI_AttachedInfoID_pk);
        \Message::set('success', 'Delete success');
        \Response::redirect(\Uri::create('files/attached_info?quote_id='.$quoteid));
    }
    
    /**
     * insert attached info
     * @author Namal
     */
    public function action_attached_info()
    {
        $info_types = Model_File::get_info_type();
        $artefact   = \Artefacts\Model_Artefact::get_artefact(\Input::get('quote_id'));
        //return print_r($artefact);exit;
        $session_user = \Session::get('current_user');
        $session_user = $session_user['full_name_no_title'];
        $AI_Reference = \Quotes\Model_Quote::get_quote(\Input::get('quote_id'));
        $AI_Reference = $AI_Reference['Q_FullNumber'];
        $AI_Reference = explode('Q', $AI_Reference);
        $AI_Reference = $AI_Reference[1];
        
        $CF_FileNumber_pk = $artefact['A_CF_FileNumber_fk'];
        
        $fs = \Fieldset::forge('attached_info');
        $fs->add('date', 'AI_Date', array('type' => 'text', 'class' => 'textbox-1 datepicker','id'=>'ai_date', 'value' => \NMI::date('today'), array(array('required'))));
        $fs->add('time', 'AI_Time', array('type' => 'text', 'class' => 'textbox-1', 'id'=>'ai_time', 'value' => date('G:h:m'), array(array('required'))));
        $fs->add('AI_Type', 'infoType :', array('type' => 'select', 'id'=>'sel_type', 'required'=>'required', 'class' => 'select-1', 'options' => $info_types, array(array('required'))));
        $fs->add('AI_Path', 'PATH TO INFO', array('type' => 'text', 'class' => 'textbox-1'));
        $fs->add('AI_CreatedBy', 'AI_CreatedBy', array('type' => 'text', 'class' => 'textbox-1', 'value'=>$session_user));
        $fs->add('CF_FileNumber_pk', 'CF_FileNumber_pk', array('type' => 'hidden',  'value' => $CF_FileNumber_pk));
        $fs->add('AI_Description', 'DESCRIPTION', array('type' => 'textarea','id'=>'ai_description', 'class' => 'textarea-1 attach_comment'), array(array('required')));
        $fs->add('quote_id','Quote_Id', array('type'=>'hidden','value'=>\Input::get('quote_id')));
        $fs->add('file_upload','File_Upload', array('type'=>'file','class'=>'fileup'));
        $fs->add('AI_Reference','AI_Reference',array('type'=>'hidden','value'=>$AI_Reference));
        
        if ($fs->validation()->run()) {
             $fields = $fs->validated();
             
             $fields['AI_Date']             = \Input::param('date').' '.\Input::param('time');
             $fields['AI_Date']             = \NMI_Db::format_date($fields['AI_Date']);
             
             //$fields['AI_Reference']        = 'AI_Reference'; //TODO, AI_Reference value
             $path                          = '';
             if($_FILES['file_upload']['name'])
             {
                $path = \Config::get('attached_log') .'/'. $fields['quote_id'] ;
                @mkdir($path); 
                $file_new_name = 'log_'. rand(10, 100000).'_'.time().'_'. $fields['quote_id']; 
                $file = \Nmi_File::upload_file('image', $path, array('new_name' => $file_new_name, 'overwrite' => true,'auto_rename'=>true), true);
                $path = $file['saved_as'];
             }
             $fields['AI_Path'] =   $path;
             
             $return = Model_File::insert_attached_info($fields);
            // print_r($return); exit;
             return \Message::set('success', 'Log has been created.') .\Response::redirect(\Uri::create('files/attached_info/?quote_id='.\Input::param('quote_id')));
             exit;
        }
        
        $artefact = \Artefacts\Model_Artefact::get_artefact(\Input::get('quote_id'));
        //echo \Input::get('quote_id') ; exit;
        $this->set_iframe_template('attached_info');
        $view = \View::forge('subform/attached_info');
        //$view->set('info_types',$info_types);
        $view->set('form', $fs->form(), false);
        $view->set('quote', \Input::get('quote_id'), false);
        $view->info_log = Model_File::get_attached_info($CF_FileNumber_pk);
        
        $this->template->content = $view;
    }
    
    
    /*
     * Update attached tab
     */
    
    public function action_update_attached(){
        $param = \Input::all(); 
        
         if($_FILES['file_up']['name'])
             {
                $path = \Config::get('attached_log') .'/'. $param['quote_id'] ;
                $unlink_path = $path .'/'. $param['AI_Path'];
                unlink($unlink_path);
                
                @mkdir($path); 
                $file_new_name = 'log_'. rand(10, 100000).'_'.time().'_'. $param['quote_id']; 
                $file = \Nmi_File::upload_file('image', $path, array('new_name' => $file_new_name, 'overwrite' => true,'auto_rename'=>true), true);
                $param['AI_Path'] = $file['saved_as'];
             }
          $fields = array(
                    'AI_Path'=>  $param['AI_Path'],
                    'AI_Reference' =>   $param['AI_Reference'],
                    'AI_Description' =>   $param['AI_Description'],
                    'AI_Date' =>  $param['AI_Date'],
                  );
          $where = array("AI_AttachedInfoID_pk"=>$param['AI_AttachedInfoID_pk']);
          
          $update = \NMI_Db::update('t_AttachedInformation', $fields,$where );
        
          if($update){
             return \Message::set('success', 'Log has been updated.') .\Response::redirect(\Uri::create('files/attached_info/?quote_id='.$param['quote_id']));
             exit;
          }
    }
    
    /*
     * View attached document 
     */
    public function action_view_attached_doc()
    { 
        $quote_id   =   \Input::param('quote_id');
        $AI_Path    =   \Input::param('AI_Path'); 
        $path = \Config::get('attached_log') . '/'. $quote_id . '/' . $AI_Path;
        if($AI_Path!=''){
            $ext = explode('.', $AI_Path);

            if($ext[1]=='docx'||$ext[1]=='doc')
            {
                 $app_type = 'msword'; 
                 echo \NMI_Doc::open_document($path, $app_type);
            }elseif($ext[1]=='pdf'){
                $app_type = 'pdf'; 
                echo \NMI_Doc::open_document($path, $app_type);
            }else{
                 $app_type = $ext[1];
                 $path     = \Uri::base(false);
                 $path     = \Uri::create($path.'files/attached/log/'. $quote_id . '/' . $AI_Path);
                 echo '<img src="'.$path.'" border="0" />';
            }  
        }else{
            echo "<script type='text/javascript'>parent.jQuery.fn.colorbox.close();</script>";
        }
        exit;
        
        
    }








    /**
     * Parse the data from data grid fields and generate a Model_ instance, used for listing grid and, excel export
     * @return [type] [description]
     */
    function generate_listing()
    {
         $extra_search_fields = $advance_search_fields = array();
//print_r(\Input::param());exit;
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

        if (\Input::get('iSortCol_0') == 1) 
        {
           $order_by['column'] = 'Number';
        }

        if (\Input::get('iSortCol_0') == 3) 
        {
            $order_by['column'] = 'Title';
        }
        
        if (\Input::get('iSortCol_0') == 4) 
        {
            $order_by['column'] = 'Location';
        }
        
        $order_by['sort'] = \Input::param('sSortDir_0');

        $global_search = \Input::get('sSearch');
        $no_of_records = $extra_search_fields['limitData'];//(int) \Input::get('iDisplayLength', 10);
        $no_of_columns = \Input::get('iColumns');
        $offset = \Input::get('iDisplayStart', 0);

        $listing = new Model_File; 
        $listing->limit = $no_of_records;
        $listing->offset = $offset;
        $listing->filter = $extra_search_fields;
       // print_r($extra_search_fields);exit;
        $listing->order_by = $order_by;
        $listing->search_criteria = $advance_search_fields;
       // print_r($extra_search_fields);exit;
        return $listing;
    }
    
    /**
     * Get information log
     * @author Namal
     */
    
    public function action_get_information_log($CF_FileNumber_pk)
    {
        Model_File::get_information_log($CF_FileNumber_pk);
    }
    
    /*
     * create_folder - description
     * @param $arg
     * @return null
     * @author Namal
     */
    public function action_create_folder()
    {
        
        $CF_FileNumber_pk = \Input::param('CF_FileNumber_pk');
        
        try{
            
            Model_File::create_cb_directory($CF_FileNumber_pk);
            $path = Model_File::create_cb_directory($CF_FileNumber_pk);

            \NMI_Db::update('t_CbFile', array('CF_DirectoryPath' => $path), array('CF_FileNumber_pk' => $CF_FileNumber_pk));
            \Message::set('success', 'Folder has been created.');

        }catch(\FuelException $e){
            \Message::set('error', $e->getMessage());
        }
        
        \Response::redirect('files/edit?CF_FileNumber_pk='.$CF_FileNumber_pk );
    }
    
    /*
     * Upload main image of a quote
     * @return null
     * @author Namal/Sahan
     */
    public function action_upload_main_image()
    {
        $this->set_iframe_template('file_content_upload');

        $CF_FileNumber_pk = \Input::param('CF_FileNumber_pk');

        $path = Model_File::get_cb_file_path($CF_FileNumber_pk);
        
        if (!$path) {

            \Message::set('error', 'CB File not found.');
            return $this->template->content = null;
        
        }

        $fs = \Fieldset::forge('upload');
        $fs->add('image', 'image', array('type' => 'file'));
        $fs->add('CF_FileNumber_pk', 'CF_FileNumber_pk', array('type' => 'hidden'))->set_value($CF_FileNumber_pk);
        $fs->add('path', 'path', array('type' => 'hidden'))->set_value($path);
        
        if ($fs->validation()->run()) {

            $fields = $fs->validated();
            
            try {
                
                $path = \Config::get('cb_files_path').DS.$fields['path'];
                $file = \Nmi_File::upload_file('image', $path, array('new_name' => 'main_image', 'overwrite' => true), true);
                $path = $fields['path'].DS.$file['saved_as'];

                \NMI_Db::update('t_CbFile', array('CF_MainImagePath' => $path), array('CF_FileNumber_pk' => $CF_FileNumber_pk));
                \Message::set('success', 'File upload Success');
    
            } catch (\NMIUploadException $e) {
            
                \Message::set('error', $e->getMessage());
            
            }

        } else {
            
            \Message::set('error', $fs->validation()->error());
        
        }
        
        
        $view = \View::forge('upload');
        $view->set('form', $fs->form(), false);
        $this->template->content = $view;

    }

    /**
     * No file exists 
     */
    public function action_no_file_exists()
    {
        $data = Model_File::no_file_exists();
        return json_encode($data);
    }
    
    	function action_list_quote_files(){
		$cb_file_id = \Input::get('CF_FileNumber_pk');
		$this->set_iframe_template();
        $this->template->content = \Files\Subform_cbfileform::forge()->render(array('CF_FileNumber_pk'=>$cb_file_id));
	}
    
	
	function action_list_quote_files_sub(){		
		$cb_file_id = \Input::get('CF_FileNumber_pk');
		$this->set_iframe_template();
        $this->template->content = \Files\Subform_cbfilelocation::forge()->render(array('CF_FileNumber_pk'=>$cb_file_id));
	}

}