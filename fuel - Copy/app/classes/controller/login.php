<?php

class Controller_Login extends \Controller_Base
{
	function action_index()
	{
		if(\Input::post('password') == 'woodfindrew')
		{
			\Session::set('authed', 'validated');
			\Response::redirect('dashboard');
		}
		$this->template->content = \View::forge('temp_login');

	}

}