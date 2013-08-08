<?php

namespace Users;

class Controller_Settings extends \Controller_Base
{
    function action_index()
    {
         $this->set_iframe_template();
         $view = \View::forge('settings');
         
         $data['branch']    = Model_Setting::get_branches();
         $data['section']   = Model_Setting::get_sections();
         $data['project']   = Model_Setting::get_projects();
         $data['area']      = Model_Setting::get_areas();
         
         $fs = \Fieldset::forge('settings');
         $fs->add('branch', 'Branches  :', array('type' => 'select', 'class' => 'select-1', 'options' => $data['branch'] ), array(array('required')));
         $fs->add('section', 'Sections :', array('type' => 'select', 'class' => 'select-1', 'options' => $data['section'] ), array(array('required')));
         $fs->add('project', 'Projects :', array('type' => 'select', 'class' => 'select-1', 'options' => $data['project'] ), array(array('required')));
         $fs->add('area', 'Areas       :', array('type' => 'select', 'class' => 'select-1', 'options' => $data['area'] ), array(array('required')));
        
         $view->set('form', $fs->form(), false);
         $this->template->content = $view;
  
    }

    
}