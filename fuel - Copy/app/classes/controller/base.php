<?php

class Controller_Base extends Controller_Template
{
	public function before()
	{
		parent::before();

		try {
			

			if (\Session::get('authed') != 'validated' and Request::active()->controller != 'Controller_Auth') {
				\Response::redirect('auth');
			}

			if (!\Nmi::current_user()) {
				\Response::redirect('auth');
			}
			


			\NMI_Db::connect(array('username'=>\Config::get('user'), \Config::get('password')));
			
			$session = \Session::get('current_user');
			if(!isset($session['EM1_DisplayTopPreference']))
			{
				$current_user = \Users\Model_User::load_user(\Session::get('username'));
			}
			
		} catch (\PDOException $e) {

			//TODO Log the server error
			\Log::error($e->getMessage());
			\Message::set('error', $e->getMessage());
			\Message::set('error', 'Database error occured, try login again.');
			\Response::redirect('auth');
		
		}

		if (Input::get('modal')) {
			$this->set_iframe_template();
		} else {
			$this->template_init();
		}
		
	}


	/**
	 * Set the template to iframe based, hide footer etc.
	 */
	public function set_iframe_template()
	{
		$body_classes = func_get_args();

		$this->template = \View::forge('template_strip');
        $this->template->body_classes = (array) $body_classes;
        $this->template_init();
	}


	public function template_init()
	{
		//-----------------------------------------------------------
		// Load Module Based JS
		//-----------------------------------------------------------
		$controller = Str::lower(substr(Inflector::denamespace(Request::active()->controller), 11));
		$this->template->template_js = array();
		
		//load js
		if(\Asset::forge()->find_file("modules/{$controller}.js", 'js'))
		{
			$this->template->template_js[] = "modules/{$controller}.js";
		}

		//global DB object
		$this->db = NMI::DB();

		//current user
		\View::set_global('current_user', \NMI::current_user());
	}

	/**
	 * Close iframe if it's an iframe
	 * @param  [type] $url URL can be passed for redirect
	 * @return [type]      [description]
	 */
	public function close_iframe($url = null, $reload_parent = false)
	{
		$code = null;
		
		if ($reload_parent) 
			$code = 'parent.location.reload();';
		else
			$code = 'parent.$(\'.cb\').colorbox.close();';	

		return '<script type="text/javascript">'.$code.'</script>';
	}
}
/* EOF */