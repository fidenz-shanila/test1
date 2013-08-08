<?php

/**
 * APP Class
 */

class NMI 
{
	protected static $db = false;

	public static function DB()
	{
		
		if(static::$db)
		{
			return static::$db;
		}
		else
		{
			//TODO too many references to the original connection
			static::$db = \NMI_Db::$connection;
			return static::$db;
		}
	}

	/**
	 * Format a date, time to australian format
	 * @param  $string string daate
	 * @param  $time bool show_time ?
	 * @return string
	 */
	public static function date($string, $time = true)
	{
		return date("d/m/Y", strtotime($string));
	}

	/**
	 * Get current user details
	 * @return [type] [description]
	 */
	public static function current_user($key = null)
	{
		$user = \Session::get('current_user');

		if (empty($user)) {
			return false;
		}

		//$user['directory'] = realpath(\Config::get('users_assets_directory').DS.$user['username']);
		$user['directory'] = \Config::get('users_assets_directory').DS.$user['username'];
		
		if($key != null and isset($user[$key]))
			return $user[$key];
		elseif($key == null)
			return $user;
		else
			return false;
	}
	
	


	/**
	 * Set current user
	 * @param Username
	 */
	public static function set_current_user($username)
	{
		//$current_user = \Employees\Model_Employee::get_employee_by_username($username);
		
		$current_user = \Users\Model_User::get_current_user_info($username);
		
		//$current_user = \Users\Model_User::load_user($username);

		if (empty($current_user)) {
			return false;
		}

		$data = array(
			'id'        => $current_user['EM1_EmployeeID_pk'],
			'username'  => $current_user['EM1_Username'],
			'full_name' => $current_user['EM1_Fullname'],
			'full_name_no_title' => $current_user['EM1_FullNameNoTitle'],
			'email'     => $current_user['EM1_Email'],
		);

		\Session::set('current_user', $data);
		
		return true;
	}

	/**
	 * Convert an array to a excel file and return to the browser as a download
	 * @param  [type] $data           [description]
	 * @param  [type] $file_name=null [description]
	 * @param  Array  $columns        [description]
	 * @return [type]                 [description]
	 */
	public static function send_excel(Array $data, $filename = null, Array $columns=array())
	{
		$content = \Format::forge($data)->to_csv();
		
		if(!isset($filename))
			$filename = "export_".date("Y-m-d_H-i",time());
	    
	    header("Content-Type: application/octet-stream");
	    header("Content-disposition: attachment; filename=".$filename.".csv");
		exit($content);
	}


}