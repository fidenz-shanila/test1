<?php 
/**
 * Used to set version numbers
 */
class Controller_Deployment extends Controller_Template
{
	function action_index()
	{
		$data = file_get_contents('php://input');
		$data = json_decode($data);

		Config::load('deployment', true);
		Config::save('deployment', array('version_number' => Config::get('deployment.version_number'), 'version'=>substr($data->revision, 0, 7), 'timestamp' => date('d/m/Y H:i:s')));
	}
}