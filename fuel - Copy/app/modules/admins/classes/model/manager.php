<?php

/**
 * Model for manager module db stuff
 * @author Niroshana <[email]>
 */

namespace Admins;

class Model_Manager extends \Model_Base 
{
	/**
	 * For add_or_remove_signatory parameters
	 * Keys - String s_mode, boolean b_is_signatory, int iEM1_EmployeeID_pk
	 * @author Namal
	 */
	public $signatory = array();
	    
	public static function get_statistics()
	{
		$sql = "EXECUTE sp_Query_t_MonthlySummary_July2010 2, 7, 2005, ".date("d, Y");
		$stmt = \NMI::Db()->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();        
	}
	
	public function add_or_remove_signatory()
	{
		$sql  = "sp_ManageEmployeeSignatoryStatus @Mode=?, @IsSignatory=?, @EM1_EmployeeID_pk=?";
		$stmt = \NMI::Db()->prepare($sql);
		$stmt->bindValue(1, $this->signatory['s_mode']);
		$stmt->bindValue(2, $this->signatory['b_is_signatory']);
		$stmt->bindValue(3, $this->signatory['iEM1_EmployeeID_pk']);
		$stmt->execute();
	}
	
	public static function get_nmi_signatories()
	{
		$sql = "SELECT EM1_EmployeeID_pk, EM1_Lname_ind + ', ' + EM1_FName as EM1_LastNameFirst FROM  t_Employee1 WHERE EM1_IsNmiSignatory = 1 ORDER BY EM1_FName ASC";
		$stmt = \NMI::Db()->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
	}
	
	public static function get_nata_signatories()
	{
		$sql = "SELECT EM1_EmployeeID_pk, EM1_Lname_ind + ', ' + EM1_FName as EM1_LastNameFirst FROM t_Employee1 WHERE EM1_IsNataSignatory = 1 ORDER BY EM1_FName ASC";
		$stmt = \NMI::Db()->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
	}
	
	public static function get_staff()
	{
		$sql = "SELECT EM1_EmployeeID_pk, EM1_Lname_ind + ', ' + EM1_FName as EM1_LastNameFirst FROM t_Employee1 WHERE EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_FName ASC";
		$stmt = \NMI::Db()->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'EM1_LastNameFirst');
	}
}