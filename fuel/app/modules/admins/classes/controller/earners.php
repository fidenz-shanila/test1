<?php

namespace Admins;

class Controller_Earners extends \Controller_Base
{
    public function action_index()
    {
        $view = \View::forge('admins/managers/top_earners');
        $this->template->content = $view;
    }
    
    public function action_listing()
    {
        $listing = new Model_Earner();
        $param = '';
        
        foreach (\Input::param() as $key => $value)
        {
            if(isset($value))
            {
                $drop_down = str_replace('filter_','', $key);
                $listing->filter[$drop_down] = $value; 
            }
        }
        
        if (\Input::get('iSortCol_0') !== false)
        {
            $sort_colomn = (int) \Input::get('iSortCol_0');
            
            switch ($sort_colomn)
            {
                case '0':
                    $param = "OrganisationTitle";
                    break;

                case '2':
                    $param = "Income";
                    break;
                
                case '3':
                    $param = "NoJobs";
                    break;
            }
        }
        
        $listing->sorting = \Input::param('sSortDir_0');
        $listing->order_by = $param;
        
        $data = $listing->listing_data();
        
        echo json_encode($data);
        exit;
    }
    
    public function action_dropdown_listing()
    {
        $drop_down['type']    = Model_Earner::dropdown_type();
        $drop_down['section'] = Model_Earner::dropdown_section();
        $drop_down['project'] = Model_Earner::dropdown_project();
        $drop_down['area']    = Model_Earner::dropdown_area();
        
        echo json_encode($drop_down);
        exit;
    }
}