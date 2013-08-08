<?php

namespace Artefacts;

class Controller_Artefacts extends \Controller_Base
{
    function action_index() 
    {
       
    }
    
    function action_build_description()
    {
        $A_Type         = \Input::param('A_Type');
        $A_Make         = \Input::param('A_Make');
        $A_Model        = \Input::param('A_Model');
        $A_SerialNumber = \Input::param('A_SerialNumber');
        $A_PerformanceRange = \Input::param('A_PerformanceRange');
        $A_Description  = \Input::param('A_Description');
        
        $description = Model_Artefact::build_artifact_description($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange, $A_Description);
        echo json_encode($description);
        exit;
    }
    
    function action_art_description($A_YearSeq_pk) 
    {
        $artifact = Model_Artefact::get_artefact($A_YearSeq_pk); 
        
        $types = Model_Artefact::get_types($A_YearSeq_pk);
        
        $fs = \Fieldset::forge('insert_work_group');
        $fs->add('A_Type', 'A_Type :', array('value' => $artifact['A_Type'] ,'id' => 'A_Type', 'type' => 'select', 'class' => 'select-1', 'options' => $types), array(array('required')));
        $fs->add('A_Make', 'A_Make :', array('value' => $artifact['A_Make'], 'id' => 'A_Make','type' => 'text', 'class' => 'textarea-1'), array(array('required')));
        $fs->add('A_Model', 'A_Model :', array('value' => $artifact['A_Model'], 'id' => 'A_Model','type' => 'text', 'class' => 'text-1'), array());
        $fs->add('A_SerialNumber', 'A_SerialNumber :', array('value' => $artifact['A_SerialNumber'], 'id' => 'A_SerialNumber','type' => 'text', 'class' => 'textbox-2'), array(array('required')));
        $fs->add('A_PerformanceRange', 'A_PerformanceRange :', array('value' => $artifact['A_PerformanceRange'],'id' => 'A_PerformanceRange', 'type' => 'text', 'class' => 'textbox-1'), array(array('required')));
        $fs->add('A_Description', 'A_Description :', array('value' => $artifact['A_Description'], 'id' => 'A_Description', 'type' => 'textarea', 'class' => 'textarea-1'), array(array('required','max_length[10]')));
        $fs->add('Save', 'Save :', array('type'=>'submit', 'value'=>'Save','class'=>'button2'));
        
        if($fs->validation()->run())
        { 
            $fields = $fs->validated();
            extract($fields);
            
           $save_data =  Model_Artefact::update_artifact_description($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange, $A_Description, $A_YearSeq_pk);
          echo "<script type='text/javascript'>parent.location.reload();parent.jQuery.fn.colorbox.close();</script>";
            //Save data

        }else{
                
        }
    	$this->template = \View::forge('template_strip');

        $view = \View::forge('art_decription');
        $view->set('form', $fs->form(), false);
        $this->template->body_classes = array('artefact_des');
        $this->template->content = $view;
    }
    

}