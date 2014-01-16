<?php
	if($_REQUEST['check'] = "checkVtigerWebservice")
	{
		global $plugin_dir_wp_tiger;
		chdir($plugin_dir_wp_tiger);
		include_once($plugin_dir_wp_tiger."vtwsclib/Vtiger/WSClient.php");
		$url = $_REQUEST['url'];
		$username = $_REQUEST['smack_host_username'];
		$accessKey = $_REQUEST['smack_host_access_key'];
		$client = new Vtiger_WSClient($url);

		$login = $client->doLogin($username, $accessKey);
		if($login)
		{
			echo "success";
		}
		else
		{
			echo "failure";
		}
	}
?>
