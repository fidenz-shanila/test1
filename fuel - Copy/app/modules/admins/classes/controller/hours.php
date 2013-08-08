<?php

namespace Admins;

class Controller_Hours extends \Controller_Base
{
    public function action_index()
    {
        $view = \View::forge('hours_analysis');
        $this->template->content = $view;
    }
    
    public function action_listing()
    {
        $listing = new Model_Hour();
        $param = '';
        
        foreach (\Input::param() as $key => $value)
        {
            if(isset($value))
            {
                $drop_down = str_replace('filter_','', $key);
                $listing->filter[$drop_down] = $value; 
            }
        }
        
        $data = $listing->listing_data();
        
        echo json_encode($data);
        exit;
    }
    
    public function action_dropdown_listing()
    {
        $drop_down['branch']  = Model_Hour::dropdown_branch();
        $drop_down['section'] = Model_Hour::dropdown_section();
        $drop_down['project'] = Model_Hour::dropdown_project();
        $drop_down['area']    = Model_Hour::dropdown_area();
        $drop_down['officer'] = Model_Hour::dropdown_officer();
        
        echo json_encode($drop_down);
        exit;
    }
}