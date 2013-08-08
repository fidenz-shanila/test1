<?php

/**
 * Model for manager module db stuff
 * @author Niroshana <[email]>
 */

namespace Admins;

class Model_Admin extends \Model_Base 
{
	public static function get_contact_categories()
    {
        $sql = "SELECT COC_Code_ind, COC_Name FROM t_ContactCategory ORDER BY COC_Code_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();        
    }
		
	public static function update_contact_category($id, $cat_name)
    {
		$sql = "UPDATE t_ContactCategory SET COC_Name = ? WHERE COC_Code_ind = ?";
        $stmt = \NMI::Db()->prepare($sql);
		$stmt->bindValue(1, $cat_name);
		$stmt->bindValue(2, $id);
        $stmt->execute();        
    }
	
	public static function get_organisation_categories()
    {
        $sql = "SELECT ORGC_Code_ind, ORGC_Name FROM t_OrganisationCategory ORDER BY ORGC_Code_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();        
    }
	
    public static function update_organisation_category($id, $cat_name)
    {
		$sql = "UPDATE t_OrganisationCategory SET ORGC_Name = ? WHERE ORGC_Code_ind = ?";
        $stmt = \NMI::Db()->prepare($sql);
		$stmt->bindValue(1, $cat_name);
		$stmt->bindValue(2, $id);
        $stmt->execute();        
    }
    
    public static function site_detail_listing()
    {
	$sql = "SELECT * from t_SiteDetails";
	$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
	return $stmt->fetchAll();
    }
    
    public static function add_site_detail($data)
    {
	$sql  = "INSERT INTO t_SiteDetails VALUES(?,?,?,?,?,?,?,?,?,?)";
	$stmt = \NMI::Db()->prepare($sql);
	
	$i=1;
	foreach ($data as $d)
	{
	    $stmt->bindValue($i, $d);
	    $i++;
	}
       return $stmt->execute();
    }
	
	/**
	 * File storage locations
	 * @author Namal
	 */
	public static function view_file_storage_table()
	{
		$sql  = "SELECT * FROM t_FileStorageLocations";
		$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
		return $stmt->fetchAll();
	}
	
	/**
	 * Get certificate offered table
	 * @author Namal
	 */
	public static function view_certificates_offered_table()
	{
		$sql  = "SELECT * FROM t_CertificateOffered";
		$stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
		return $stmt->fetchAll();
	}
	
}