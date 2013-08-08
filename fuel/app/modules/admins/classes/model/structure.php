<?php

namespace Admins;

/**
 * Structure Model
 * @author Namal 
 */

class Model_Structure extends \Model_Base
{
    public static function get_branches()
    {
        $sql = "SELECT B_BranchID_pk, B_Name_ind FROM t_Branch ORDER BY B_Name_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'B_BranchID_pk', 'B_Name_ind');
        
    }
    
    /**
     * Delete Branch 
     * @param type $B_BranchID_pk 
     * @author Namal
     */
    public static function delete_branch($B_BranchID_pk)
    {
        $sql = "DELETE from t_Branch where B_BranchID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $B_BranchID_pk);
        $stmt->execute();
    }
    
    /**
     * Get section list for branch form
     * @param $B_BranchID_pk
     * @author Namal
     */
    
    public static function get_sections($B_BranchID_pk)
    {
      
        $sql  = "SELECT * FROM t_Section WHERE S_BranchID_fk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $B_BranchID_pk);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Delete Section in Branch Form
     * @param $S_SectionID_pk
     * @author Namal
     */
     public static function delete_section($S_SectionID_pk)
    {
        $sql = "sp_delete_from_t_Section @S_SectionID_pk=?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $S_SectionID_pk);
        $stmt->execute();
    }
    
    /*
     * Get Projects in section form
     * @param $S_SectionID_pk
     * @author Namal
     */
    public static function get_projects($S_SectionID_pk)
    {
      
        $sql  = "SELECT * FROM t_Project WHERE P_SectionID_fk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $S_SectionID_pk);
        $stmt->execute();
        return $stmt->fetchAll();
       
    }
    
    /*
     * Get staff in project form
     * @param
     * @author Namal
     */ 
     public static function get_staff()
    {
        $sql  = "SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Lname_ind, S_SectionID_pk, SE_SectionEmployeeID_pk FROM t_Section INNER JOIN t_j_SectionEmployee ON S_SectionID_pk = SE_SectionID_ind_fk INNER JOIN t_Employee1 ON SE_EmployeeID_fk = EM1_EmployeeID_pk ORDER BY EM1_Lname_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        
    }
    
    /*
     * Delete Project
     * @param P_ProjectID_pk
     * @author Namal
     */
    public static function delete_project($P_ProjectID_pk)
    {
       
        $sql  = "sp_delete_from_t_Project @P_ProjectID_pk=?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $P_ProjectID_pk);
        $stmt->execute();
        
    }
    
    
    /**
     * Get area in project form
     * @param
     * @author Namal
     */ 
     public static function get_area($P_ProjectID_pk)
    {
       
        $sql  = "SELECT * FROM t_Area WHERE A_ProjectID_fk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $P_ProjectID_pk);
        $stmt->execute();
        return $stmt->fetchAll();
       
    }
    
    /**
     * Get fee area form
     * @author Namal
     */
    public static function get_fee()
    {
        $sql = "SELECT F_FeeID_pk, F_Code, F_Description, F_Fee, F_AreaID_ind_fk  FROM t_Fee ORDER BY F_Code ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get selected types for area form
     * @author Namal
     */
    public static function get_selected_types($A_AreaID_pk)
    {
        $sql = "SELECT AIT_AreaInstumentTypeID_pk, IT_Name_ind  FROM t_Area INNER JOIN t_j_AreaInstumentType ON A_AreaID_pk =  AIT_A_AreaID_ind_fk INNER JOIN t_InstrumentType ON AIT_IT_InstrumentTypeID_fk = IT_InstrumentTypeID_pk WHERE AIT_A_AreaID_ind_fk= ? ORDER BY IT_Name_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $A_AreaID_pk);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'AIT_AreaInstumentTypeID_pk', 'IT_Name_ind');
    }
    
    /**
     * Get available types for area form
     * @author Namal
     */
    public static function get_available_types()
    {
        $sql = "SELECT IT_InstrumentTypeID_pk, IT_Name_ind FROM t_InstrumentType ORDER BY IT_Name_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'IT_InstrumentTypeID_pk', 'IT_Name_ind');
    }
    
    /**
     * Add to selected types
     * @author Namal
     */
    public static function add_to_selected_type($lstAvailableInstruments, $A_AreaID_pk)
    {
        $sql = "DECLARE	@return_value int
                
                EXEC	@return_value = [dbo].[sp_insert_into_t_j_AreaInstumentType]
                        @AIT_IT_InstrumentTypeID_fk = ?,
                        @AIT_A_AreaID_ind_fk = ?
                
                SELECT	'return' = @return_value";
                
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue(1, $lstAvailableInstruments);
        $stmt->bindValue(2, $A_AreaID_pk);
        
        $stmt->execute();
        $rows = $stmt->fetch();
        
        return (int)$rows['return'];
    }
    
    /**
     * Insert new Available Type
     * @author Namal
     */
    public static function insert_new_available_type($IT_Name_ind)
    {
        $sql = "DECLARE	@return_value int,
		@IT_InstrumentTypeID_pk int

                EXEC	@return_value = [dbo].[sp_insert_into_t_InstrumentType]
                                @IT_Name_ind = ?,
                                @IT_InstrumentTypeID_pk = @IT_InstrumentTypeID_pk OUTPUT";
                
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $IT_Name_ind);
        return $stmt->execute();
    }
    
    /**
     * Update available type
     * @author Namal
     */
    public static function edit_available_type($IT_Name_ind, $IT_InstrumentTypeID_pk)
    {
        $sql = "UPDATE t_InstrumentType SET IT_Name_ind = ? WHERE IT_InstrumentTypeID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $IT_Name_ind);
        $stmt->bindParam(2, $IT_InstrumentTypeID_pk);
        $stmt->execute();
    }
    
    /**
     * Delete available tye
     * @author Namal
     */
    public static function delete_available_type($IT_InstrumentTypeID_pk)
    {
        $sql = "sp_delete_from_t_InstrumentType @IT_InstrumentTypeID_pk = ?";
         
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $IT_InstrumentTypeID_pk);
        $stmt->execute();
        $row = $stmt->fetch();   // TODO, fetch error
        return $row['return'];           
            
    }
    
    
    /**
     * Delete from selected types
     * @author Namal
     */
    public static function delete_from_selected_types($AIT_AreaInstumentTypeID_pk)
    {
        $sql = "sp_delete_from_t_j_AreaInstumentType @AIT_AreaInstumentTypeID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $AIT_AreaInstumentTypeID_pk);
        return $stmt->execute();
    }
    
    /**
     * Get staff for manage staff
     * @author Namal
     */
    public static function get_staff_for_manage()
    {
        $sql = "SELECT EM1_EmployeeID_pk, EM1_Lname_ind + ', ' + EM1_FName As Full_Name FROM t_Employee1 WHERE EM1_CurrencyStatus = 'CURRENT' ORDER BY EM1_Lname_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'EM1_EmployeeID_pk', 'Full_Name');
    }
    
    /**
     * Get section staff @ manage staff
     * @author Namal
     */
    public static function get_section_staff()
    {
        $sql  = "SELECT EM1_EmployeeID_pk, EM1_FullNameNoTitle, EM1_Lname_ind, S_SectionID_pk, SE_SectionEmployeeID_pk FROM t_Section INNER JOIN t_j_SectionEmployee ON S_SectionID_pk = SE_SectionID_ind_fk INNER JOIN t_Employee1 ON SE_EmployeeID_fk = EM1_EmployeeID_pk ORDER BY EM1_Lname_ind ASC";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Add staff
     * @author Namal
     */
    public static function add_staff($SE_EmployeeID_fk, $SE_SectionID_ind_fk)
    {
        $sql = "sp_insert_into_t_j_SectionEmployee @SE_EmployeeID_fk = ?, @SE_SectionID_ind_fk = ?";
        
        $sql =" DECLARE	@return_value int
                
                EXEC	@return_value = [sp_insert_into_t_j_SectionEmployee]
                                @SE_EmployeeID_fk = 1,
                                @SE_SectionID_ind_fk = 2
                
                SELECT	'return' = @return_value";
       
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $SE_EmployeeID_fk);
        $stmt->bindParam(2, $SE_SectionID_ind_fk);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['return'];
    }
    
    /**
     * Remove section staff
     * @author Namal
     */
    public static function remove_section_staff($SE_SectionEmployeeID_pk)
    {
        $sql = "sp_delete_from_t_j_SectionEmployee @SE_SectionEmployeeID_pk = ?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $SE_SectionEmployeeID_pk);
        return $stmt->execute();
    }
    
    /**
     * Insert Fee
     * @author Namal
     */
    public static function insert_fee($F_Code, $F_Description, $F_Fee, $F_AreaID_ind_fk)
    {
        $sql = "sp_insert_into_t_Fee @F_Code=:F_Code, @F_Description=:F_Description, @F_Fee=:F_Fee, @F_AreaID_ind_fk=:F_AreaID_ind_fk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(':F_Code', $F_Code);
        $stmt->bindParam(':F_Description', $F_Description);
        $stmt->bindParam(':F_Fee', $F_Fee);
        $stmt->bindParam(':F_AreaID_ind_fk', $F_AreaID_ind_fk);
        
        return $stmt->execute();
    }
    
    /**
     * Delete Fee
     * @author Namal
     */
     public static function delete_fee( $F_FeeID_pk )
     {
        $sql = "sp_delete_from_t_Fee @F_FeeID_pk = :F_FeeID_pk";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(':F_FeeID_pk', $F_FeeID_pk);
        return $stmt->execute();
     }
     
     
     /**
      * Delete Staff
      * @author Namal
      */
     public static function delete_staff($SE_SectionEmployeeID_pk)
     {
        $sql = "sp_delete_from_t_j_SectionEmployee @SE_SectionEmployeeID_pk=?";
        $stmt = \NMI::Db()->prepare($sql);
        $stmt->bindParam(1, $SE_SectionEmployeeID_pk);
        return $stmt->execute();
     }

     /**
      * Export PM Struture
      */
     public static function export_pm_structure()
     {
        $sql  = "SELECT B_Name_ind AS 'BRANCH', S_Name_ind AS 'SECTION', P_Name_ind AS 'PROJECT', ";
        $sql .= "A_Name_ind AS 'AREA' ";
        $sql .= "FROM t_Branch LEFT OUTER JOIN t_Section ON B_BranchID_pk = S_BranchID_fk ";
        $sql .= "LEFT OUTER JOIN t_Project ON S_SectionID_pk = P_SectionID_fk ";
        $sql .= "LEFT OUTER JOIN t_Area ON P_ProjectID_pk = A_ProjectID_fk ";
        $sql .= "WHERE B_Name_ind = 'Physical Metrology' ";
        $sql .= "ORDER BY B_Name_ind ASC, S_Name_ind ASC, P_Name_ind ASC, A_Name_ind ASC";
        
        $stmt = \Nmi::db()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
     }
}

