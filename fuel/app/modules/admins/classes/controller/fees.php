<?php

namespace Admins;

class Controller_Fees extends \Controller_Base
{
    public function action_index()
    {
        $view = \View::forge('admins/managers/fee_listing');
        $this->template->content = $view;
    }
    
    public function action_listing()
    {
        $listing = new Model_Fee();
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
        $listing = new Model_Fee();
        
        $drop_down['branch']  = $listing->dropdown_branch();
        $drop_down['section'] = $listing->dropdown_section();
        $drop_down['project'] = $listing->dropdown_project();
        $drop_down['area']    = $listing->dropdown_area();
        
        echo json_encode($drop_down);
        exit;
    }
}