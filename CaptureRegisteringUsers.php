<?php

function wp_tiger_capture_registering_users($user_id)
{
	$siteurl=site_url();
	$config = get_option('smack_vtlc_settings');
	if($config['wp_tiger_smack_user_capture'] =='on')
	{
		$user_data = get_userdata( $user_id );
		$user_email = $user_data->data->user_email;
		$user_lastname = get_user_meta( $user_id, 'last_name', 'true' );
		$user_firstname = get_user_meta( $user_id, 'first_name', 'true' );
		if(empty($user_lastname))
		{
			$user_lastname = $user_data->data->display_name;
		}
                $post['firstname'] = $user_firstname;
                $post['lastname'] = $user_lastname;
		$post['email'] = $user_email;
		$post['moduleName'] = 'Contacts';
		if(!empty( $config['appkey'] )){
			$post['appKey'] = $config['appkey'];
		}
		foreach($post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		$url=trim($config['url'], "/").'/modules/Webforms/post.php';
		$ch  = curl_init ($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec ($ch);
		curl_close ($ch);

		if($data) {
		        if(preg_match("/$module entry is added to vtiger CRM./",$data)) {
		                $content= "<span style='color:green'>Thank you for submitting</span>";
		        } else{
		                $content= "<span style='color:red'>Submitting Failed</span>";
		        }
		}
	}
}
?>
