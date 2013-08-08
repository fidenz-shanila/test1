<?php

class Helper_App
{
	/**
	 * Replacement for pfBuildSearchString
	 * @param  [type] $sAndOrF1        [description]
	 * @param  [type] $sAndOrF2        [description]
	 * @param  [type] $sAndOrD3        [description]
	 * @param  [type] $sFieldCriteria1 [description]
	 * @param  [type] $sFieldCriteria2 [description]
	 * @param  [type] $sDateCriteria3  [description]
	 * @return [type]                  [description]
	 */
	public static function build_search_string($sAndOrF1, $sAndOrF2, $sAndOrD3, $sFieldCriteria1, $sFieldCriteria2 = null, $sDateCriteria3 = null)
	{
		$aAndOr = $sCriteria1 = array();
		$i = 0;

		if(($sAndOrF1 != "N/A" and $sAndOrF1 != "") and $sFieldCriteria1 != "")
		{
			$i++;

	        $aAndOr[$i] = $sAndOrF1;
	        $sCriteria1[$i] = $sFieldCriteria1;
		}

		if(($sAndOrF2 != "N/A" and $sAndOrF2 != "") and $sFieldCriteria2 != "")
		{
			$i++;
			$aAndOr[$i] = $sAndOrF2;
	        $sCriteria1[$i] = $sFieldCriteria2;
		}

		if(($sAndOrD3 != "N/A" and $sAndOrD3 != "") and $sDateCriteria3 != "")
		{
			$i++;
			$aAndOr[$i] = $sAndOrD3;
	        $sCriteria1[$i] = $sDateCriteria3;
		}

		$pfBuildSearchString = null;

		switch($i)
		{
			case 1:
				$pfBuildSearchString = "AND {$sCriteria1[1]}";
			break;

			case 2:
                            $no1=$aAndOr[1];
                            $no2=$aAndOr[2];
                            
                            //print_r($no2);exit;
				if($no1 == "AND" && $no2 == "AND")
				{
					$pfBuildSearchString = "AND ".implode('AND ', $sCriteria1);
				}
				elseif($no1 == "OR" && $no2 == "AND")
				{
					$pfBuildSearchString = "AND ( " .implode('OR ', array_reverse($sCriteria1)) . ") ";
				}
		        elseif($no1 == "AND" && $no2 == "OR")
		        {
		        	$pfBuildSearchString = "AND ( " . implode('OR ', $sCriteria1) . ") ";
		        }
		        elseif($aAndOr[1] == "OR" && $aAndOr[2] == "OR")
		        {
		        	$pfBuildSearchString = "AND ( " . implode('OR ', $sCriteria1) . ") ";
		        }	
			break;

			case 3:
				if($aAndOr[1] == "AND" && $aAndOr[2] == "AND" && $aAndOr[3] == "AND")
				{
					$pfBuildSearchString = "AND" . implode('AND ', $sCriteria1);
				}

				if($aAndOr[1] == "OR" && $aAndOr[2] == "AND" && $aAndOr[3] == "AND")
				{
					$pfBuildSearchString = "AND ((" .$sCriteria1[2]."AND ".$sCriteria1[3]." ) OR " .$sCriteria1[1]. ") ";
				}	

				if($aAndOr[1] == "AND" && $aAndOr[2] == "OR" && $aAndOr[3] == "AND")
				{
					$pfBuildSearchString = "AND ((" .$sCriteria1[1]. "AND " .$sCriteria1[3]. " ) OR " .$sCriteria1[2]. ") ";
				}

				if($aAndOr[1] == "AND" && $aAndOr[2] == "AND" && $aAndOr[3] == "OR")
				{
					$pfBuildSearchString = "AND ((" .$sCriteria1[1]. "AND " .$sCriteria1[2]. " ) OR " .$sCriteria1[3]. ") ";
				}

				if($aAndOr[1] == "OR" && $aAndOr[2] == "OR" && $aAndOr[3] == "AND")
				{
					$pfBuildSearchString = "AND ((" .$sCriteria1[1]. "OR " .$sCriteria1[2]. " ) AND " .$sCriteria1[3]. ") ";
				}

				if($aAndOr[1] == "OR" && $aAndOr[2] == "AND" && $aAndOr[3] == "OR")
				{
					$pfBuildSearchString = "AND ((" .$sCriteria1[1]. "OR " .$sCriteria1[3]. " ) AND " .$sCriteria1[2]. ") ";
				}

				if($aAndOr[1] == "AND" && $aAndOr[2] == "OR" && $aAndOr[3] == "OR")
				{
					$pfBuildSearchString = "AND ((" . $sCriteria1[2] . "OR " .$sCriteria1[3]. " ) AND " .$sCriteria1[1]. ") ";
				}   

				if($aAndOr[1] == "OR" && $aAndOr[2] == "OR" && $aAndOr[3] == "OR")
				{
					$pfBuildSearchString = "AND (" .$sCriteria1[1]. "OR " .$sCriteria1[2]. " OR " .$sCriteria1[3]. ") ";
				}
			break;	
		}

		return $pfBuildSearchString;
		
	}
        
        
        
    public static function FormatDateForSql($date)
    {
        //**** 2012/12/12 => 2012-12-12 conversion
        $data =  str_replace('/', '-', $date);
	
	return $data .= ' 00:00:00'; //TODO, timestamp
    }

    /*
      * Format Time - formats time from minutes into hh:mm
      * @param int hours, int minutes
      * @return String formattered time
      * @author Namal
      */
     
    public static function format_time($hours, $minutes)
    {
        $time = null;
        
        //defining hours format and converting string
        if($hours == 0)
        {
            $time = '0:';
        }
        else
        {
            $time = $hours.':';
        }
        
        //defining minutes format and converting string
        if($minutes == 0)
        {
            $time .= '00';
            
        }elseif($minutes < 10)
        {
            $time .= '0'.$minutes;
        }
        else
        {
            $time  .=  $minutes;
        }
        
        return $time;
    }
	
	/*
	 * function ReturnTemplatePathBasedOnContractType - template path
	 * @param $arg
	 * @return null
	 * @author Namal
	 */
	public static function ReturnTemplatePathBasedOnContractType($contract_type)
	{
		$type = explode(':', $contract_type);
		
		$template_path = '';
		
		switch($type[1])
		{
				case 'HIRE WITH CERT CONTRACT':
						$template_path = 'HireContract.dotx';
						break;
				
				case 'HIRE WITH CERT NON-CONTRACT':
						$template_path = 'HireContract.dotx';
						break;
				
				case 'HIRE WITHOUT CERT CONTRACT':
						$template_path = 'HireContract.dotx';
						break;
				
				case 'HIRE WITHOUT CERT NON-CONTRACT':
						$template_path = 'HireContract.dotx';
						break;
				
				case 'STD-CONTRACT': 
						$template_path = 'Quote_OngoingContract.dotx';
						break;
				
				case 'STD-NON-CONTRACT': 
						$template_path = 'QuoteStandard.dotx';
						break;
		}
		
		return $template_path;
	}
	
	/*
	 * function GetContractType_v2 - description
	 * @param $arg
	 * @return null
	 * @author Namal
	 */
	public static function GetContractType_v2($bMode, $mYearSeq, $sA_Name, $iOrgID)
	{
		$sql  = "EXEC sp_tm_ClientContractType_v2 @x_Mode=:x_Mode, @x_YearSeq_pk=:x_YearSeq_pk, @A_Name=:A_Name, @OrgID_pk=:OrgID_pk, @x_ContractType=:x_ContractType";
        
		$stmt = \NMI::Db()->prepare($sql);
        $stmt->bindValue('x_Mode', $bMode);
        $stmt->bindValue('x_YearSeq_pk', $mYearSeq);
        $stmt->bindValue('A_Name', $sA_Name);
        $stmt->bindValue('OrgID_pk', $iOrgID);
        $stmt->bindParam('x_ContractType', $x_ContractType, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 25);
		$stmt->execute();

		return $x_ContractType;
	}
	
	/*
	 * function GetPath - description
	 * @param $P_PathName_pk
	 * @return $P_Path
	 * @author Namal
	 */
	public static function GetPath($id)
	{
		$paths = array(
			'Billing Info template' => 'BillingInformation.dotx'
		);

		if (!isset($paths)) {
			throw new \OutOfBoundsException('Template not found');
		}

		return $paths[$id];
	}
	
	/*
	 * function format_array - format the array according to the template
	 * @param Array $data
	 * @return $new_data_array
	 * @author Namal
	 */
	public function format_array(Array $data)
	{
		$new_data_array = array();
        
		foreach ($data as $key => $val) {
					
		    if ($key%2 == 0) {
			$new_data_array[$val] = $data[++$key];
			}
			
		}
		
		return $new_data_array;
	}

	/**
	 * Get listing url from tab id of main form
	 * @return [type] [description]
	 */
	public static function url_from_tab($id)
	{
		$tabs = array(1 => 'quotes', 'receipts', 'jobs', 'invoices', 'files');
		return Uri::create(isset($tabs[$id]) ? $tabs[$id] : 'quotes');
	}
}
/* eof */

