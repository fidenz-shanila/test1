<?php

class Controller_Dashboard extends Controller_Base
{
	function action_index()
	{	
		$this->template = View::forge('dashboard');
		
	}
}