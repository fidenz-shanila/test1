<?php
/**
 * Handle all physical file related work
 */

class NMIUploadException extends \Exception {}

class Nmi_File
{

	/**
	 * Upload File
	 * @param  [type] $upload_key [description]
	 * @param  [type] $path       [description]
	 * @param  array  $config     [description]
	 * @return [type]             [description]
	 */
	public static function upload_file($upload_key, $path, $config = array(), $required = false)
	{

		$config = array_merge((array) $config, array('path' => $path, 'field' => $upload_key));
		// Custom configuration for this upload

		// process the uploaded files in $_FILES
		Upload::process($config);

		// if there are any valid files	
		if (Upload::is_valid()) {
		    // save them according to the config
		    Upload::save();

		    return Upload::get_files(0);

		} else {

			$errors = Upload::get_errors($upload_key);
			$errors = $errors['errors'];
			
			foreach ($errors as $error) {

				//if no file present
				if( $error['error'] == \Upload::UPLOAD_ERR_NO_FILE and $required == false) {
					break;
				}

				throw new NMIUploadException($error['message'], $error['error']);
			}

		}

	}

}
/* eof */