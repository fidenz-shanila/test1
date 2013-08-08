<?php 
/**
 * Document generator helper
 */

class NMIDocException extends \Exception {}

class NMI_Doc
{
	protected static $phpdoc;

	/**
	 * New PHPWord object
	 * @return [type] [description]
	 */
	public static function phpdoc()
	{	
		if (empty(static::$phpdoc)) {
			static::$phpdoc = new PHPWord();
		}

		return static::$phpdoc;
			
	}
        
        
        /*
         * Open Document
         * code by Sri
         * $app_type = [can be 'msword','pdf']
         */
        
        public static function open_document($path,$app_type){
            if (file_exists($path)) {                
                header('Content-Description: File Transfer');
                header('Content-Type: application/'.$app_type);
                if($app_type!='pdf'){
                    header('Content-Disposition: attachment; filename='.basename($path));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($path));
                }
                  ob_clean();
                  flush();
                  readfile($path);                  
                exit;
            }else{
                echo 'Invalid path.';
            }
        }

        
	/**
	 * Generate a document and pass array of data
	 * @param  [type] $document [description]
	 * @param  Array  $data     [description]
	 * @return [type]           [description]
	 */
	public static function generate_template($template, Array $data = array()) 
	{
		$url = \Config::get('document_generator_url');
		
		foreach ($data as $key=>$value) {

			if (empty($key) or empty($value)) {
				unset($data[$key]);
			}	
		
		}
		
		$query = array(
                        //word file template name
			'file' => $template,
                        //keys tags
			'keys'     => implode(',', array_keys($data)), 
                        //key values tag value  (keys=>values)
			'values'   => implode(',', array_values($data)),
                    
			'isFile'   => 'false'
		);
               
                //here build query will create data sheet 
		$body = http_build_query($query);
                  //print_r($query); exit;     
                //here set to witch url to send data
		$c = curl_init ($url); //print_r($body);exit;
                // 
                //do just like normal post request send data
		curl_setopt ($c, CURLOPT_POST, true);
                 
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. 
                //The filetype can be explicitly specified by following the filename with the type in the format ';type=mimetype'. 
                //This parameter can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the 
                //field name as key and field data as value. If value is an array, the Content-Type header will be set to multipart/form-data. 
                //As of PHP 5.2.0, value must be an array if files are passed to this option with the @ prefix. 
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		curl_setopt ($c, CURLOPT_POSTFIELDS, $body);
               
                //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly. 
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, true); 
                
		$return = curl_exec ($c);
		curl_close ($c);
                
            
     print_r($return); exit;            
                //here just read the xml
		$return = simplexml_load_string($return);

		if ($return->ErrorMessage != 'Success') {
			throw new NMIDocException($return->ErrorMessage);
		} else {
			return base64_decode($return->FileContent);
		}

	}

	/**
	 * Mailmerge document for contact
	 * Array
	 *(
	 *    [DbDateAndTime] => 23 October 2012
	 *    [ContactFullName] => ContactFullName
	 *    [CO_Fullname] => sdsd sdsd sdsd
	 *    [ContactFirstName] => ContactFirstName
	 *    [CO_Fname] => sdsd
	 *    [ContactPosition] => ContactPosition
	 *    [CO_Pos] => 
	 *    [ContactPhone] => ContactPhone
	 *    [CO_Phone] => 
	 *    [ContactMobile] => ContactMobile
	 *    [CO_Mobile] => 
	 *    [ContactFax] => ContactFax
	 *    [CO_Fax] => 
	 *    [ContactEmail] => ContactEmail
	 *    [CO_Email] => 
	 *    [OrganisationName] => OrganisationName
	 *    [OR1_Name_ind] => sdsd
	 *    [OrganisationSection] => OrganisationSection
	 *    [OR1_Section] => sdsd
	 *    [OrganisationPhone] => OrganisationPhone
	 *    [OR2_Phone] => 
	 *    [OrganisationFax] => OrganisationFax
	 *    [OR2_Fax] => 
	 *    [OrganisationEmail] => OrganisationEmail
	 *    [OR2_Email] => 
	 *    [OrganisationWeb] => OrganisationWeb
	 *    [OR2_Web] => 
	 *    [OrganisationCountry] => OrganisationCountry
	 *    [OR2_Country] => 
	 *    [OrganisationPostalAddress1] => OrganisationPostalAddress1
	 *    [OR2_Postal1] => 
	 *    [OrganisationPostalAddress2] => OrganisationPostalAddress2
	 *    [OR2_Postal2] => 
	 *    [OrganisationPostalAddress3] => OrganisationPostalAddress3
	 *    [OR2_Postal3] => 
	 *    [OrganisationPostalAddress4] => OrganisationPostalAddress4
	 *    [OR2_Postal4] => 
	 *    [OrganisationPhysicalAddress1] => OrganisationPhysicalAddress1
	 *    [OR2_Physical1] => 
	 *    [OrganisationPhysicalAddress2] => OrganisationPhysicalAddress2
	 *    [OR2_Physical2] => 
	 *    [OrganisationPhysicalAddress3] => OrganisationPhysicalAddress3
	 *    [OR2_Physical3] => 
	 *    [OrganisationPhysicalAddress4] => OrganisationPhysicalAddress4
	 *    [OR2_Physical4] => 
	 *    [OrganisationInvoiceContactFullName] => OrganisationInvoiceContactFullName
	 *    [OR2_InvoiceContactFullname] => 
	 *    [OrganisationInvoiceAddress1] => OrganisationInvoiceAddress1
	 *    [OR2_Invoice1] => 
	 *    [OrganisationInvoiceAddress2] => OrganisationInvoiceAddress2
	 *    [OR2_Invoice2] => 
	 *    [OrganisationInvoiceAddress3] => OrganisationInvoiceAddress3
	 *    [OR2_Invoice3] => 
	 *    [OrganisationInvoiceAddress4] => OrganisationInvoiceAddress4
	 *    [OR2_Invoice4] => 
	 *    [SenderFullNameNoTitle] => SenderFullNameNoTitle
	 *    [EM1_FullNameNoTitle] => Simon Seitam
	 *    [SenderFullName] => SenderFullName
	 *    [EM1_Fullname] => Mr Simon Seitam
	 *    [SenderInitials] => SenderInitials
	 *    [EM1_Initials_unq] => SD
	 *    [SenderPositionDescriptor1] => SenderPositionDescriptor1
	 *    [EM1_PositionDescriptor1] => Mechanical Engineer
	 *    [SenderPositionDescriptor2] => SenderPositionDescriptor2
	 *    [EM1_PositionDescriptor2] => Length
	 *    [SenderPositionDescriptor3] => SenderPositionDescriptor3
	 *    [EM1_PositionDescriptor3] => National Measurement Institute
	 *    [SenderPhone] => SenderPhone
	 *    [EM1_Phone] => 0411 623 553
	 *    [SenderFax] => SenderFax
	 *    [EM1_Fax] => 0411 623 553
	 *    [SenderEmail] => SenderEmail
	 *    [EM1_Email] => drew.seitam@woodfinconsulting.com
	 *    [SenderSiteName] => SenderSiteName
	 *    [EM1_SD_SiteName_fk] => NMI Lindfield
	 *    [SenderPhysicalAddress1] => SenderPhysicalAddress1
	 *    [SD_PhysicalAddress1] => Bradfield Road
	 *    [SenderPhysicalAddress2] => SenderPhysicalAddress2
	 *    [SD_PhysicalAddress2] => West Lindfield  NSW  2070
	 *    [SenderPhysicalAddress3] => SenderPhysicalAddress3
	 *    [SD_PhysicalAddress3] => Australia
	 *    [SenderPostalAddress1] => SenderPostalAddress1
	 *    [SD_PostalAddress1] => PO Box 264
	 *    [SenderPostalAddress2] => SenderPostalAddress2
	 *    [SD_PostalAddress2] => Lindfield  NSW  2070
	 *    [SenderPostalAddress3] => SenderPostalAddress3
	 *    [SD_PostalAddress3] => Australia
	 *    [SenderMainPhone] => SenderMainPhone
	 *    [SD_MainPhone] => +61 2 8467 3600
	 *    [SenderMainFax] => SenderMainFax
	 *    [SD_MainFax] => +61 2 8467 3610
	 *)
	 * @return [type] [description]
	 */
	public static function contact_mailmerge($contact_id, $type)
	{

		$stmt = \NMI::Db()->prepare("EXEC sp_ContactMergeData @CO_ContactID_pk = ?");
		$stmt->execute(array($contact_id));

		$results = array();
		
		do {
		    $results[]= $stmt->fetchAll();
		} while ($stmt->nextRowset());

		$mailmerge_data = $results[0][0];
		
		// $mailmerge = array();

		// foreach ($mailmerge_data as $key => $value) {
			
		// 	if ($key != $value and !empty($value)) {
		// 		$mailmerge[$key] = $value; 
		// 	}
		
		// }

		// $mailmerge_data = $mailmerge;

		$mailmerge_data_redsgn = array(
			'DbDateAndTime' 			 => $mailmerge_data['DbDateAndTime'],	
			'ContactFullName' 		 	 => $mailmerge_data['CO_Fullname'],	
			'ContactPosition' 			 => $mailmerge_data['CO_Pos'],	
			'OrganisationName' 			 => $mailmerge_data['OR1_Name_ind'],	
			'OrganisationSection' 		 => $mailmerge_data['OR1_Section'],	
			'OrganisationPostalAddress1' => $mailmerge_data['OR2_Postal1'],	
			'OrganisationPostalAddress2' => $mailmerge_data['OR2_Postal2'],	
			'OrganisationPostalAddress3' => $mailmerge_data['OR2_Postal3'],	
			'OrganisationPostalAddress4' => $mailmerge_data['OR2_Postal4'],	
			'SenderSiteName' 			 => $mailmerge_data['EM1_SD_SiteName_fk'],	
			'SenderPhysicalAddress1' 	 => $mailmerge_data['SD_PhysicalAddress1'],	
			'SenderPhysicalAddress2' 	 => $mailmerge_data['SD_PhysicalAddress2'],	
			'SenderPhysicalAddress3' 	 => $mailmerge_data['SD_PhysicalAddress3'],	
			'SenderPostalAddress1' 		 => $mailmerge_data['SD_PostalAddress1'],	
			'SenderPostalAddress2' 		 => $mailmerge_data['SD_PostalAddress2'],	
			'SenderPostalAddress3' 		 => $mailmerge_data['SD_PostalAddress3'],	
			'SenderMainPhone' 			 => $mailmerge_data['SD_MainPhone'],	
			'SenderMainFax' 			 => $mailmerge_data['SD_MainFax'],	
			'ContactFirstName' 			 => $mailmerge_data['CO_Fname'],	
			'SenderFullName' 			 => $mailmerge_data['EM1_FullNameNoTitle'],	
			'SenderPositionDescriptor1'  => $mailmerge_data['EM1_PositionDescriptor1'],	
			'SenderPositionDescriptor2'  => $mailmerge_data['EM1_PositionDescriptor2'],	
			'SenderPositionDescriptor3'  => $mailmerge_data['EM1_PositionDescriptor3'],	
		);

		switch ($type) {

			case 'letter':
				$doc = static::generate_template('ContactLetter.dotx', $mailmerge_data_redsgn);
			break;

			case 'fax':
				$doc = static::generate_template('ContactFax.dotx', $mailmerge_data_redsgn);
			break;

			case 'label':
				$doc = static::generate_template('ContactLabel.dotx', $mailmerge_data_redsgn);
			break;

			case 'banner':
				$doc = static::generate_template('ContactBanner.dotx', $mailmerge_data_redsgn);
			break;
		}

		static::save($doc, "contact_{$type}.doc", 'D');

	}

	/**
	 * Output a binary string as a docment
	 * @param  flag  D = Download
	 * @return [type] [description]
	 */
	public static function save($content, $filename, $flag = 'D')
	{
		header("Content-Type: application/octet-stream");
		header("Content-disposition: attachment; filename={$filename}");
		header('Content-Length: '.strlen($content));
		echo $content;
		exit;
	}
}