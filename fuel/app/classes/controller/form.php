<?php

class Controller_Form extends Controller
{
     function action_index() 
    {
       
    }
	
	//Set form Lock
	public static function  FormLock($username,$controlVal)
	{
		//'This sub enables or disable controls, performed by locking the form
		$ObjectCurrentUser = \Session::get('current_user'); 
		
		if($controlVal ==1)
			{
				$AdminEdit              = '';
				$AdminButtonFunction	= '';
				$Admintype              = "select";
			}else{
				$AdminEdit 		= "readonly";
				$AdminButtonFunction 	= 'disabled';
				$Admintype      	= 'text';
			}
		
		// Admin and User can edit 
			if($ObjectCurrentUser['username']==$username || $controlVal ==1)
			{
				$AdminUserEdit           = '';
				$AdminUserButtonFunction = '';
				$AdminUserType           = 'select';
			}else{
				$AdminUserEdit           = 'readonly';
				$AdminUserButtonFunction = "disabled";
				$AdminUserType           = 'text';
			}
			
		//make required 
		if($AdminEdit==''){
			$AdminRequired = 'required';
		}else{
			$AdminRequired = '';
		}
		
		if($AdminUserEdit==''){
			$AdminUserRequired = 'required';
		}else{
			$AdminUserRequired = '';
		}
		
                    $return = array(
                            'AdminEdit'                 =>$AdminEdit,
                            'AdminUserEdit'             =>$AdminUserEdit,
                            'AdminButtonFunction'       =>$AdminButtonFunction,
                            'AdminUserButtonFunction'   =>$AdminUserButtonFunction,
                            'AdminRequired'             =>$AdminRequired,
                            'AdminUserRequired'         =>$AdminUserRequired,
                            'Admintype'                 =>$Admintype,
                            'AdminUserType'             =>$AdminUserType
                    );
			
		return $return;
	}
	
	


        //Set form Lock
	public static function  OfficeFormLock($controlVal)
	{
		//'This sub enables or disable controls, performed by locking the form
		
		
		if($controlVal ==0)
			{
				$AdminEdit              = '';
				$AdminButtonFunction	= '';
				$Admintype              = "select";
			}else{
				$AdminEdit 		= "disabled";
				$AdminButtonFunction 	= 'disabled';
				$Admintype      	=  "select";
			}
		
		
		//make required 
		if($AdminEdit==''){
			$AdminRequired = 'required';
		}else{
			$AdminRequired = '';
		}

		
                    $return = array(
                            'AdminEdit'                 =>$AdminEdit,
                            'AdminButtonFunction'       =>$AdminButtonFunction,
                            'AdminRequired'             =>$AdminRequired,
                            'Admintype'                 =>$Admintype
                            
                    );
			
		return $return;
	}
        
	
}