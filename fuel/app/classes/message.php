<?php
/**
 * Message helper class
 */
class Message
{
	static $messages = array();
	
	function __construct()
	{
		//\Session::set('_message', array());
	}
	
	static function get_session()
	{
		return \Session::get('_message');
	}
	
	static function set_session($m=null)
	{
		if($m == null)
			\Session::set('_message', self::$messages);
		else
			\Session::set('_message', $m);
	}	
	
	static function set_single($group, $message)
	{
		self::$messages = self::get_session();
		
		//echo $group,' ', $message,"\n";
		
			
		if(!isset(self::$messages[$group]))
		{
			self::$messages[$group] = array();
		}
		self::$messages[$group][] = $message;
		self::set_session();

	}
	
	static function set($groups, $message = null)
	{
		self::$messages = self::get_session();
		
		$tmessages = array();
		
		//if message is a string, group also a string
		if(is_string($message) and is_string($groups))
		{
			self::set_single($groups, $message);
		}
		
		//message array, group string
		if(is_array($message) and is_string($groups))
		{
			if(!isset($tmessages[$groups]))
				$tmessages[$groups] = array();
			
			foreach($message as $m)
			{
				$tmessages[$groups][] = $m;
				//self::set_single($groups, $m);
			}
		}
		
		//assoc array
		if(empty($message) and is_array($groups))
		{
			foreach($groups as $group=>$message)
			{
				if(!isset($tmessages[$group])) //check and set default
					$tmessages[$group] = array();
					
				if(is_array($message))
				{
					foreach($message as $m)
					{
						$tmessages[$group][] = $m;
						//self::set_single($group, $m);
					}
				}
				else
					$tmessages[$group][] = $message;
			}
		}
		
		self::$messages = (array) self::$messages + (array) $tmessages;
		
		self::set_session();
		
	}
	
	static function get($group=null)
	{
		self::$messages = \Session::get('_message');
		
		if($group == null)
		{
			$ret = self::$messages;
			self::$messages = null;
			self::set_session();
			return $ret;
		}
		elseif(isset(self::$messages[$group]))
		{
			$ret = self::$messages[$group];
			self::$messages[$group] = null;
			self::set_session();
			return $ret;
		}
		else
		{
			return false;
		}
	}
	
	static function display($groups=null)
	{
		$messages = self::get_session();
		$o = null;
		
		if(!empty($groups) and isset($messages[$groups]))
				return self::format_group($group);
		
		if(count($messages)>0)		
		foreach($messages as $group=>$messages)
		{
			$o .= self::format_group($group);
		}
		
		return $o;
	}
	
	static function format_group($group)
	{
		$messages = self::get($group);
		
		$output = '';
		
		if($messages)
		{
			// does a view partial exist?
			if ( file_exists(APPPATH.'views/messages/'.$group.'_view.php') )
			{
				$view = \View::forge('messages/'.$group.'_view', '', TRUE);
				$view->set('messages', $messages, false);
				$output .= $view;
			}
			// does a default view partial exist?
			elseif ( file_exists(APPPATH.'views/messages/default_view.php') )
			{
				$output .= \View::forge('messages/default_view', array('messages'=>$messages), TRUE);
			}
			// fallback to default values (possibly set by config)
			else
			{
				//$output .= $this->wrapper_prefix . PHP_EOL;

				foreach ( $messages as $msg )
				{
					$output .= $msg . PHP_EOL;
				}

				//$output .= $this->wrapper_suffix . PHP_EOL;
			}
			return $output;
		}
		else
		{
			return false;
		}
	}
}

/* End of file Message.php */