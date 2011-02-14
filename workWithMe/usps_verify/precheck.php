<?php
	require_once dirname(__FILE__).'/libs/json.php';

	$version = phpversion();
	$version_arr = explode('.',$version);
	
	$response['msg'] = "The following need to be fixed before you can continue:\n\n";
	
	if ($version_arr[0] <= 4)
	{
		$response['status'] = 'error';
		$response['msg'] .= "-You are currently running PHP version: ".$version.".  PHP 5 and above is required\n";
	}
	
	
	
	if(!function_exists('zend_optimizer_version'))
	{
		$response['status'] = 'error';
		$response['msg'] .= "-Zend Optimizer is not installed on your server.  Please contact your server administrater";
	}
	
	
	//if there wasn't an error, it must be a success
	if ($response['status'] != 'error')
		$response['status'] = 'success';
		
	$jsonobj = new Services_JSON();
	echo $jsonobj->encode($response);
?>