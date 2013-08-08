<?php

namespace Admins;

class Controller_Managers extends \Controller_Base
{
    function action_index()
    {
        $this->set_iframe_template();
		$view = \View::forge('manager/home');
		$this->template->body_classes = array('clr_administration');
		$this->template->content = $view;
    }
    
    function action_stats_bl()
    {
		$this->set_iframe_template('statisticsat');
		$view = \View::forge('manager/statistics/statistics_at_branch_level');
		$view->set('statistics', Model_Manager::get_statistics(), false);
		$this->template->content = $view;
    }
    
    function action_top_earners()
    {
        $this->set_iframe_template('top_earning_filter');
    	$view = \View::forge('manager/income/top_earners');
    	$this->template->content = $view;
    }
    
    function action_fee_listing()
    {
        $this->set_iframe_template('fee_listing');
    	$view = \View::forge('manager/fee/fee_listing');
    	$this->template->content = $view;
    }
    
    function action_search_for_servers()
    {
         $this->set_iframe_template();
    	$view = \View::forge('manager/contact/search_for_servers');
    	$this->template->content = $view;
    }
    
    function action_insert_contact_survey()
    {
        $this->set_iframe_template();
    	$view = \View::forge('manager/contact/insert_contact_survey');
    	$this->template->content = $view;
    }

    function action_hours_analysis()
    {
        $this->set_iframe_template('hour_analysis');
    	$view = \View::forge('manager/hours');
    	$this->template->content = $view;
    }

    /**
     * 
     */
    function action_pm_structure()
    {
        $data = Model_Structure::export_pm_structure();
        \Nmi::send_excel((array) $data, 'pm_structure');
        exit;
    }
    
}