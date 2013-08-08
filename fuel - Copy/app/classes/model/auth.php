<?php

class Model_Auth extends \Controller_Base
{
	function action_index()
	{

	}
	
	public static function login($username, $password)
    {
		// This will get which db connection is set to 'active' in the db config
		//\Config::load('db', true);
		//$active_db = \Config::get('db.active');
		//print_r($active_db); 
		$call_to_db = \quotes\Model_Quote::get_nmi_section($username, $password);exit;
		$sql	=	"SELECT  EM1_Username, EM1_EmployeeID_pk from t_Employee1, EM1_Password where EM1_Username = ? and EM1_Password = ?";
        $sql = \NMI::Db()->prepare($sql);
		print_r($sql);log::error($sql); 
		
        $stmt->execute(array($username,$password));
        $meta = $stmt->fetch();
         print_r($meta);exit;
        foreach ($meta as $u)
        {
           $user_id = $u['EM1_EmployeeID_pk'];
           $user_name = $u['EM1_Username'];
		   $password = $u['EM1_Password'];
        }
		
        \Session::set('user_id', $user_id);
		\Session::set('username', $username);
		\Session::set('password', $password);
		\Session::set('authed', 'validated');
		
		if(count($user>0)){return 1;}else{return 0;}
    }

}