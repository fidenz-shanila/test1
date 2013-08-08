<?php

namespace Quotes;

class Model_Owner extends \Model_Base 
{
	
	/**
     * Get NMI Projects
     * @param
     * @return array
     * @author Niroshana
     */
    public static function get_nmi_projects()
    {	
        $sql = "SELECT OR1_OrgID_pk, OR1_FullName FROM t_Organisation1 WHERE OR1_InternalOrExternal = 'NMI' AND OR1_CurrencyStatus = 'CURRENT' ORDER BY OR1_Name_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }
	
	/**
     * Get NMI Contacts
     * @param
     * @return array
     * @author Niroshana
     */
    public static function get_nmi_contacts()
    {	
        $sql = "SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Lname_ind + ', ' + EM1_FName FROM t_Employee1 WHERE EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_Lname_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();  
    }
    
    
}
/* eof */
