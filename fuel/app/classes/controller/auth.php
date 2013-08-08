<?php

class Controller_Auth extends \Controller_Template
{
	function action_index()
	{
		$this->action_login();
	}


	function action_login()
	{
		if (\Input::is_ajax()) {

			if (\Input::param('username') and \Input::param('password')) {

				$username = \Input::param('username');
				//$password = \Input::param('password');
				$password = md5(\Input::param('password'));

				try {

						$login = \Users\Model_User::login($username, $password);
						
						if($login==0){
							return $this->template->content = json_encode(array('status'=>'fail', 'msg' => 'User not found in NMI database or password mismatch..!'));	
						}else{

							if (!Nmi::set_current_user($username)) {
								return $this->template->content = json_encode(array('status'=>'fail', 'msg' => 'User not found in NMI database.'));
							}
	
							//create directory
							if (!is_dir(Nmi::current_user('directory'))) {
								if (!mkdir(Nmi::current_user('directory'), 0777, true)) {
									
									return $this->template->content = json_encode(array('status'=>'fail', 'msg' => 'Failed to create users directory or user directory doesn\'t exist.'));
	
								}
							}
	
							return $this->template->content = json_encode(array('status'=>'success', 'msg' => 'Logged in successfully.'));
						}
						
				} catch (\PDOException $e) {

					if ($e->getCode() == 28000){
						$msg = 'Login failed.';
					} else {
						$msg = 'Database server error.';
					}
					
					return $this->template->content = json_encode(array('status'=>'fail', 'msg' => $msg));
					
				}

			}
			else {
				return $this->template->content = json_encode(array('status'=>'fail', 'msg' => 'Username and Password is required.'));
			}
		}

		$view = \View::forge('login');
		$this->template->body_classes = array('login');
		$this->template->content = $view;
	}

	/**
	 * Logout a user
	 * @return [type] [description]
	 */
	function action_logout()
	{
		Message::set('success', 'You\'ve been logged out of the system.');
		Session::destroy();
		Response::redirect('auth/login');
	}
}