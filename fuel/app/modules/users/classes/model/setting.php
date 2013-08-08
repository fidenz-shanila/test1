<?php
namespace users;

class Model_Setting extends \Model_Base
{
    public static function get_branches()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT WDB_B_Name FROM vw_QuoteListing INNER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind WHERE Q_YearSeq_pk > 0 AND WDB_B_Name = 'Legal Metrology' ORDER BY WDB_B_Name ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_B_Name', 'WDB_B_Name');
    }
    
    public static function get_sections()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT WDB_S_Name FROM vw_QuoteListing INNER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind WHERE Q_YearSeq_pk > 0 AND WDB_B_Name = 'Legal Metrology' ORDER BY WDB_S_Name ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_S_Name', 'WDB_S_Name');
    }
    
    public static function get_projects()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT WDB_P_Name FROM vw_QuoteListing INNER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind WHERE Q_YearSeq_pk > 0 AND WDB_B_Name = 'Legal Metrology' ORDER BY WDB_P_Name ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_P_Name', 'WDB_P_Name');
    }
    
     public static function get_areas()
    {
        $rows = \NMI::Db()->query("SELECT DISTINCT WDB_A_Name FROM vw_QuoteListing INNER JOIN vw_WorkDoneBy ON Q_YearSeq_pk = WDB_YearSeq_fk_ind WHERE Q_YearSeq_pk > 0 AND WDB_B_Name = 'Legal Metrology' ORDER BY WDB_A_Name ASC")->fetchAll();
        return \Arr::assoc_to_keyval($rows, 'WDB_A_Name', 'WDB_A_Name');
    }
    
    
}