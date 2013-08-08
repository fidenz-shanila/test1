<?php

namespace Users;

class Controller_Users extends \Controller_Base
{
    function action_index()
    {
        $view       = \View::forge('login');
        $this->template->content = $view;
        
        $username   = \Input::post('username');
        $password   = \Input::post('password');
        
        Model_User::login($username, $password);
        
    }

    function action_scheduler()
    {
        $this->set_iframe_template();
    	$view       = \View::forge('scheduler');
        $this->template->content = $view;
    }
    
}