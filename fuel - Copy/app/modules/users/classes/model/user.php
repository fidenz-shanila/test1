<?php

namespace Users;

class Model_User extends \Model_Base
{
    public static function login($username, $password)
    {
        $sql = "SELECT  EM1_Password, EM1_Username, EM1_EmployeeID_pk from t_Employee1 where EM1_Username = '$username' and EM1_Password = '$password'";
        $db = \MSSQL\Db::forge();
		$user = $db->fetchArray($db->query($sql));
       
	    if(count($user)>0){
			foreach ($user as $u)
			{
			   $user_id = $u['EM1_EmployeeID_pk'];
			   $user_name = $u['EM1_Username'];
			   $password = $u['EM1_Password'];
			}
			
			
			\Session::set('authed', 'validated');
			\Session::set('username', $user_name);
			
			return 1;
		}else{
			return 0;	
		}
   }
   
      /**
     * Get employee by username
     * @return void
     * @author Namal
     **/
    public static function get_current_user_info($EM1_Username)
    {
        $sql  = "SELECT * FROM t_Employee1 WHERE EM1_Username = '$EM1_Username'";
		$db = \MSSQL\Db::forge();
		$user = $db->fetchArray($db->query($sql));
		$user = $user[0];
		return $user;
    }


   /**
     * Run SP sp_UserDetails_v4
     * @param  Array  $data [description]
     * @return [type]       [description]
     * @author Sahan <[email]>
     */
    public static function load_user($username)
    {
		$data  = \Session::get('current_user');
	try{
        $sql = "
		DECLARE	@return_value int,
		@UserFullname varchar(60),
		@UserFullNameNoTitle varchar(60),
		@UserLastNameFirst varchar(60),
		@UserInitials varchar(6),
		@UserPhone varchar(25),
		@UserFax varchar(25),
		@UserEmail varchar(40),
		@UserID_pk int,
		@EM1_BranchPreference varchar(80),
		@EM1_SectionPreference varchar(80),
		@EM1_ProjectPreference varchar(80),
		@EM1_AreaPreference varchar(80),
		@EM1_DisplayTopPreference varchar(6),
		@EM1_SD_SiteName_fk varchar(100),
		@EM1_Username varchar(20),
		@EM1_BranchFlag bit,
		@EM1_SectionFlag bit,
		@EM1_ProjectFlag bit,
		@EM1_AreaFlag bit,
		@EM1_QuickQuoteFlag bit

EXEC	@return_value = [dbo].[sp_UserDetails_v4_web]
		@username = ?,
		@UserFullname = @UserFullname OUTPUT,
		@UserFullNameNoTitle = @UserFullNameNoTitle OUTPUT,
		@UserLastNameFirst = @UserLastNameFirst OUTPUT,
		@UserInitials = @UserInitials OUTPUT,
		@UserPhone = @UserPhone OUTPUT,
		@UserFax = @UserFax OUTPUT,
		@UserEmail = @UserEmail OUTPUT,
		@UserID_pk = @UserID_pk OUTPUT,
		@EM1_BranchPreference = @EM1_BranchPreference OUTPUT,
		@EM1_SectionPreference = @EM1_SectionPreference OUTPUT,
		@EM1_ProjectPreference = @EM1_ProjectPreference OUTPUT,
		@EM1_AreaPreference = @EM1_AreaPreference OUTPUT,
		@EM1_DisplayTopPreference = @EM1_DisplayTopPreference OUTPUT,
		@EM1_SD_SiteName_fk = @EM1_SD_SiteName_fk OUTPUT,
		@EM1_Username = @EM1_Username OUTPUT,
		@EM1_BranchFlag = @EM1_BranchFlag OUTPUT,
		@EM1_SectionFlag = @EM1_SectionFlag OUTPUT,
		@EM1_ProjectFlag = @EM1_ProjectFlag OUTPUT,
		@EM1_AreaFlag = @EM1_AreaFlag OUTPUT,
		@EM1_QuickQuoteFlag = @EM1_QuickQuoteFlag OUTPUT

SELECT	@UserFullname as N'UserFullname',
		@UserFullNameNoTitle as N'UserFullNameNoTitle',
		@UserLastNameFirst as N'UserLastNameFirst',
		@UserInitials as N'UserInitials',
		@UserPhone as N'UserPhone',
		@UserFax as N'UserFax',
		@UserEmail as N'UserEmail',
		@UserID_pk as N'UserID_pk',
		
		@EM1_BranchPreference as N'EM1_BranchPreference',
		@EM1_SectionPreference as N'EM1_SectionPreference',
		@EM1_ProjectPreference as N'EM1_ProjectPreference',
		@EM1_AreaPreference as N'EM1_AreaPreference',
		@EM1_DisplayTopPreference as N'EM1_DisplayTopPreference',
		@EM1_SD_SiteName_fk as N'EM1_SD_SiteName_fk',
		@EM1_Username as N'EM1_Username',
		
		@EM1_BranchFlag as N'EM1_BranchFlag',
		@EM1_SectionFlag as N'EM1_SectionFlag',
		@EM1_ProjectFlag as N'EM1_ProjectFlag',
		@EM1_AreaFlag as N'EM1_AreaFlag',
		@EM1_QuickQuoteFlag as N'EM1_QuickQuoteFlag'

SELECT	'Return Value' = @return_value
			";

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $data['username']);
        $stmt->execute();
		$return = $stmt->fetch();

		
	} catch (\PDOException $e) {

			//TODO Log the server error
			\Log::error($e->getMessage());
			\Message::set('error', 'Database error occured, try login again.');
			\Response::redirect('auth');
		
		}
	
	//set current user object in session 
	if($return['EM1_BranchFlag']==''){
		$EM1_BranchEnabled = 0;
	}else{
		$EM1_BranchEnabled = $return['EM1_BranchFlag'];
	}
	
	if($return['EM1_SectionFlag']==''){
		$EM1_SectionEnabled = 0;
	}else{
		$EM1_SectionEnabled = $return['EM1_SectionFlag'];
	}
	
	if($return['EM1_ProjectFlag']==''){
		$EM1_ProjectEnabled = 0;
	}else{
		$EM1_ProjectEnabled = $return['EM1_ProjectFlag'];
	}
	
	if($return['EM1_AreaFlag']==''){
		$EM1_AreaEnabled = 0;
	}else{
		$EM1_AreaEnabled = $return['EM1_AreaFlag'];
	}
	
	if($return['EM1_QuickQuoteFlag']==''){
		$EM1_QuickQuoteEnabled = 0;
	}else{
		$EM1_QuickQuoteEnabled = $return['EM1_QuickQuoteFlag'];
	}
	
	if($return['EM1_DisplayTopPreference']==''){
		$EM1_DisplayTopPreference = 500;
	}else{
		$EM1_DisplayTopPreference = $return['EM1_DisplayTopPreference'];
	}
	
	$data = array(
			'id'        => $data['id'],
			'username'  => $data['username'],
			"full_name"=>$return['UserFullname'], "full_name_no_title"=>$return['UserFullNameNoTitle'], "last_name_first"=>$return['UserLastNameFirst'], "initials"=>$return['UserInitials'], "phone"=>$return['UserPhone'], "fax"=>$return['UserFax'], "email"=>$return['UserEmail'], "user_id_pk"=>$return['UserID_pk'], "EM1_BranchPreference"=>$return['EM1_BranchPreference'], "EM1_SectionPreference"=>$return['EM1_SectionPreference'], "EM1_ProjectPreference"=>$return['EM1_ProjectPreference'], "EM1_AreaPreference"=>$return['EM1_AreaPreference'], "EM1_DisplayTopPreference"=>$EM1_DisplayTopPreference, "EM1_Username"=>$return['EM1_Username'], "EM1_SD_SiteName_fk"=>$return['EM1_SD_SiteName_fk'], "EM1_BranchEnabled"=>$EM1_BranchEnabled, "EM1_SectionEnabled"=>$EM1_SectionEnabled, "EM1_ProjectEnabled"=>$EM1_ProjectEnabled, "EM1_AreaEnabled"=>$EM1_AreaEnabled, "EM1_QuickQuoteEnabled"=>$EM1_QuickQuoteEnabled);
			
		\Session::set('current_user', $data);
		$module	=	new Model_User;
		$set_what_can_do = $module->CanDoFunctions();
		return true;
    }
	
	
	
	
	
	public function CanDoFunctions(){
		$thismodule	=	new Model_User;
		$data = \Session::get('current_user');
		//'Set 'Can Do' globals
    //QUOTE ADMINISTRATOR
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Quote", "Q_CheckedByEmployeeID");
            If($Msg == "Granted")
			{
				$data['CanLockQuote'] = 1;
			}else{
                $data['CanLockQuote'] = 0;
			}
    //JOB ADMINISTRATOR
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Job", "J_LockForm");
            if($Msg == "Granted")
			{
                $data['CanLockJob'] = 1;
			}else{
                $data['CanLockJob'] = 0;
			}
    //REPORT ADMINISTRATOR
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Report", "R_LockForm");
        $Msg2 = $thismodule->PermissionGranted("UpdateColumn", "t_Report", "R_DateReportSent");
            If($Msg == "Granted" && $Msg2 == "Granted" )
			{
               $data['CanLockAndSendReport'] = 1;
			}else{
                 $data['CanLockAndSendReport'] = 0;
			}
    //INVOICE ADMINISTRATOR
        //Fee Due Locked
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Job", "J_FeeDueLocked");
            if($Msg == "Granted")
			{
                $data['CanChangeFeeDueLocked'] = 1;
			}else{
                 $data['CanChangeFeeDueLocked'] = 0;
			}
        //Update invoice data
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Job", "J_PaymentMethod");
            if($Msg == "Granted")
			{
                $data['CanUpdateInvoiceData'] =1; 
			}else{
                $data['CanUpdateInvoiceData'] = 0;
			}
            

        $data['CbFileAdmin'] = $data['CanLockQuote'];
    //CONTACT ADMINISTRATOR
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Organisation1", "OR1_InternalOrExternal");
        $Msg2 = $thismodule->PermissionGranted("UpdateColumn", "t_Organisation1", "OR1_ContractExpiryDate");
        $Msg3 = $thismodule->PermissionGranted("UpdateColumn", "t_Organisation1", "OR1_ContractID");
        $Msg4 = $thismodule->PermissionGranted("UpdateColumn", "t_Organisation1", "OR1_LockForm");
        $Msg5 = $thismodule->PermissionGranted("UpdateColumn", "t_Contact", "CO_ApprovedByEmployeeID");
        $Msg6 = $thismodule->PermissionGranted("UpdateColumn", "t_Contact", "CO_LockForm");
            if($Msg == "Granted" && $Msg2 == "Granted" && $Msg3 == "Granted" && $Msg4 == "Granted" && $Msg5 == "Granted" && $Msg6 == "Granted"){
                $data['IsContactAdmin']=1;
			}else{
                $data['IsContactAdmin']=0;
			}
    //CAN VIEW REPORT DATA
        $Msg = $thismodule->PermissionGranted("SelectColumn", "t_MonthlySummary", "MS_MthlySumID_pk");
            if($Msg == "Granted")
			{
                $data['CanViewReportData'] = 1;
			}else{
                $data['CanViewReportData'] = 0;
			}
    //Can delete contact - generally all can do this, but you can't delete a linked contact - DON'T WORK?
        $data['CanDeleteContact'] = false;
        $Msg = $thismodule->PermissionGranted("DeleteFromTable", "t_Contact",'');
            if($Msg == "Granted")
			{
                $data['CanDeleteContact'] = 1;
			}else{
                $data['CanDeleteContact'] = 0;
			}
            
    //Can Create Quote
        $data['CanCreateQuote'] = false;
        $Msg = $thismodule->PermissionGranted("InsertIntoTable", "t_Quote", "");
        if($Msg == "Granted" )
		{
            $data['CanCreateQuote'] = 1;
		}else{
            $data['CanCreateQuote'] = 0;
		}
    //gCanChangeEmployeeRecords
        $data['CanChangeEmployeeRecords'] = false;
        $Msg = $thismodule->PermissionGranted("UpdateColumn", "t_Employee1", "EM1_Username");
        if($Msg == "Granted")
		{
            $data['CanChangeEmployeeRecords'] = 1;
		}else{
            $data['CanChangeEmployeeRecords'] = 0;
		}	
		
		\Session::set('current_user', $data);
		return true;
	}
	
	
	
	
	
	
	public static function PermissionGranted($TypeOfPermission , $TableOrSpName, $ColumnName){
		
		//This function runs an sp and determines if the user has permission to carry out the desired operation
		//If permission is granted, "Granted' is returned otherwise "Denied" is returned.
		//Check data integrity
		
		$data = \Session::get('current_user');
		
	
		If($TypeOfPermission == "UpdateColumn" || $TypeOfPermission == "SelectColumn" || $TypeOfPermission == "InsertIntoTable" || $TypeOfPermission == "DeleteFromTable" || $TypeOfPermission == "ExecuteSp" )
		{
			$error_count = 0;
		}else{
			$fIsPermissionGranted = "Invalid permission type";
			\Message::set('error', $fIsPermissionGranted);
			\Log::error($fIsPermissionGranted);
			$error_count = 1;
		}
		
		If($TableOrSpName == "" || $TableOrSpName=='') 
		{
			$fIsPermissionGranted = "Invalid table name";
			\Message::set('error', $fIsPermissionGranted);
			\Log::error($fIsPermissionGranted);
			$error_count = 1;
		}elseif($ColumnName=='') 
		{
			$ColumnName = "";
		}
		
		If(strlen($TableOrSpName) > 80)
		{
			$fIsPermissionGranted = "Table name too long";
			\Message::set('error', $fIsPermissionGranted);
			\Log::error($fIsPermissionGranted);
			$error_count = 1;
		}
		
		if(strlen($TableOrSpName) > 80)
		{
			$fIsPermissionGranted = "Column name too long";
			\Message::set('error', $fIsPermissionGranted);
			\Log::error($fIsPermissionGranted);
			$error_count = 1;
		}
			
		if($error_count ==0)
		{
			try{
				$sql = "
				DECLARE	@return_value int
		EXEC	@return_value = [dbo].[sp_IsPermissionGranted_Web]
				@user_name=?,
				@TypeOfPermission = ?,
				@TableOrSpName = ?,
				@ColumnName = ?
		
		SELECT	'Return Value' = @return_value";
		
				$stmt = \NMI::Db()->prepare($sql);
				$stmt->bindValue(1,$data['username']);
				$stmt->bindValue(2, $TypeOfPermission);
				$stmt->bindValue(3, $TableOrSpName);
				$stmt->bindValue(4, $ColumnName);
				$stmt->execute();
				$return = $stmt->fetch();
				
				if($return['Return Value'] == 0 )
				{
        			$fIsPermissionGranted = "Denied";
				}elseif($return['Return Value']  == 1 )
				{
					$fIsPermissionGranted = "Granted";
				}
	
				return $fIsPermissionGranted;
			
		} catch (\PDOException $e) {
	
				//TODO Log the server error
				\Log::error($e->getMessage());
				\Message::set('error', 'Database error occured, try login again.');
				\Response::redirect('auth');
				return true;
			}
		}else{
			$fIsPermissionGranted = 'Permission error occured';
			\Message::set('error', $fIsPermissionGranted);
			\Log::error($fIsPermissionGranted);	
			return true;
		}
	
	}
	
	
	
    
    function hash($str)
    {
        
    }
    
  
    
    
    
    
    
}