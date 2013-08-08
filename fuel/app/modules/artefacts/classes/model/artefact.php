<?php
namespace Artefacts;
/**
 * Artefact model
 * @author Sahan <[email]>
 */

class Model_Artefact extends \Model_Base
{

    /**
     * Get artefact details for a specific job, qureied using quote pk
     * @param  int $id quote id
     * @return Array
     */
    public static function get_artefact($id)
    {
        $sql = "SELECT 
        A_YearSeq_pk, 
        A_Type, 
        A_Make, 
        A_Model, 
        A_SerialNumber, 
        A_PerformanceRange, 
        A_Description,
        A_ContactID,
        A_Comment, 
        A_TestMethodUsed, 
        A_CF_FileNumber_fk FROM t_Artefact WHERE A_YearSeq_pk = ?";

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    /**
     * Get artefact types
     * @author  Sahan <[email]>
     * @param  [A_YearSeq_pk] [quote table pk]
     * @return Array [description]
     */
    public static function get_types($A_YearSeq_pk)
    {
        $sql = "SELECT DISTINCT IT_Name_ind FROM t_InstrumentType INNER JOIN t_j_AreaInstumentType ";
        $sql .= "ON IT_InstrumentTypeID_pk = AIT_IT_InstrumentTypeID_fk INNER JOIN t_Area ";
        $sql .= "ON AIT_A_AreaID_ind_fk = A_AreaID_pk ";
        $sql .= "INNER JOIN t_Project ON A_ProjectID_fk = P_ProjectID_pk ";
        $sql .= "INNER JOIN t_Section ON P_SectionID_fk = S_SectionID_pk ";
        $sql .= "INNER JOIN t_WorkDoneBy t1 ON A_Name_ind = t1.WDB_A_Name ";
        $sql .= "INNER JOIN t_WorkDoneBy t2 ON P_Name_ind = t1.WDB_P_Name ";
        $sql .= "INNER JOIN t_WorkDoneBy t3 ON S_Name_ind = t1.WDB_S_Name ";
        $sql .= " WHERE t1.WDB_YearSeq_fk_ind = ?";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($A_YearSeq_pk));
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'IT_Name_ind', 'IT_Name_ind');
    }

    /**
     * Get owner
     * @author Sahan <[email]>
     * @param   Quote ID [description]
     * @return Array [description]
     */
    public static function get_owner($quote_id)
    {
        $sql = "SELECT A_YearSeq_pk, 
        OR1_OrgID_pk, 
        OR1_FullName, 
        A_ContactID, 
        OR1_InternalOrExternal, 
        'CLIENT / OWNER: '+OR1_InternalOrExternal + ' ORGANISATION' AS OrgTitle, 

        ContactName = 
            CASE OR1_InternalOrExternal 
            WHEN 'EXTERNAL' 
                THEN (SELECT CO_Fullname FROM t_Contact WHERE CO_ContactID_pk = A_ContactID) 
            WHEN 'NMI' 
                THEN (SELECT EM1_FullNameNoTitle FROM t_Employee1 WHERE EM1_EmployeeID_pk = A_ContactID) 
                ELSE 'Error' END, 

        ContactPhone = 
            CASE OR1_InternalOrExternal 
            WHEN 'EXTERNAL' 
                THEN (SELECT CO_Phone FROM t_Contact WHERE CO_ContactID_pk = A_ContactID) 
            WHEN 'NMI' 
                THEN (SELECT EM1_Phone FROM t_Employee1 WHERE EM1_EmployeeID_pk = A_ContactID) 
                ELSE 'Error' END,  

            ContactEmail = 
            CASE OR1_InternalOrExternal 
            WHEN 'EXTERNAL' 
                THEN (SELECT CO_Email FROM t_Contact WHERE CO_ContactID_pk = A_ContactID) 
            WHEN 'NMI' 
                THEN (SELECT EM1_Email FROM t_Employee1 WHERE EM1_EmployeeID_pk = A_ContactID) 
                ELSE 'Error' END 

            FROM t_Artefact INNER JOIN t_Organisation1 ON A_OR1_OrgID_fk = OR1_OrgID_pk WHERE A_YearSeq_pk = ?";
       
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($quote_id));
        return $stmt->fetch();
    }

    /**
     * Update owner
     * @param  [type] $quote_id   [description]
     * @param  [type] $contact_id [description]
     * @param  [type] $org_id     [description]
     * @return [type]             [description]
     */
    public static function update_owner($quote_id, $contact_id, $org_id)
    {
        $stmt = \NMI::Db()->prepare("UPDATE t_Artefact SET A_ContactID = ?, A_OR1_OrgID_fk = ? WHERE A_YearSeq_pk = ?");
        return $stmt->execute(array($contact_id, $org_id, $quote_id));
    }
    
    /**
     * Build Artifact description
     * @author Namal
     */
    public static function build_artifact_description($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange, $A_Description)
    {
        $sql = "
            DECLARE	@return_value int,
            @A_Description varchar(400)
    
            EXEC	@return_value = [sp_BuildArtefactDescription]
                    @A_Type = ?,
                    @A_Make = ?,
                    @A_Model = ?,
                    @A_SerialNumber = ?,
                    @A_PerformanceRange = ?,
                    @A_Description = @A_Description OUTPUT
            
            SELECT	@A_Description as 'A_Description'
            
            SELECT	'Return Value' = @return_value";
        
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $A_Type);
        $stmt->bindValue(2, $A_Make);
        $stmt->bindValue(3, $A_Model);
        $stmt->bindValue(4, $A_SerialNumber);
        $stmt->bindValue(5, $A_PerformanceRange);
        $stmt->bindParam(6, $A_Description, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 400);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Update artifact description
     * @author Namal
     */
    public static function update_artifact_description($A_Type, $A_Make, $A_Model, $A_SerialNumber, $A_PerformanceRange, $A_Description, $A_YearSeq_pk)
    {
        $sql = "UPDATE t_Artefact SET A_Type = :A_Type, A_Make = :A_Make, A_Model = :A_Model, A_SerialNumber = :A_SerialNumber, A_PerformanceRange = :A_PerformanceRange, A_Description = :A_Description WHERE A_YearSeq_pk = :A_YearSeq_pk";
        $stmt = \NMI::Db()->prepare($sql);
        
        $stmt->bindValue('A_Type', $A_Type);
        $stmt->bindValue('A_Make', $A_Make);
        $stmt->bindValue('A_Model', $A_Model);
        $stmt->bindValue('A_SerialNumber', $A_SerialNumber);
        $stmt->bindValue('A_PerformanceRange', $A_PerformanceRange);
        $stmt->bindValue('A_Description', $A_Description);
        $stmt->bindParam('A_YearSeq_pk', $A_YearSeq_pk);
        $stmt->execute();
        
    }
    
    /*
     * Get Artifact info
     */
    public static function get_artifact_info($A_YearSeq_pk)
    {
        $sql = " SELECT * FROM t_Artefact WHERE A_YearSeq_pk = '" . $A_YearSeq_pk . "'";
        $stmt = \NMI::Db()->query($sql)->fetchAll();
        return $stmt[0];
    }
    
    /**
     * Get artefact details for a specific job, qureied using quote pk
     * @param  int $id quote id
     * @return Array
     */
    public static function get_artefact_all_info($id)
    {
        $sql = "SELECT * FROM t_Artefact WHERE A_YearSeq_pk = ?";

        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetchAll();
    }
    
}
/*eof*/