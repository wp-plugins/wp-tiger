<?php
/*********************************************************************************
 * Easy Lead capture Vtiger Webforms and Contacts synchronization is a tool 
 * for capturing leads and contacts to VtigerCRM from WordPress developed by 
 * Smackcoder. Copyright (C) 2013 Smackcoders.
 *
 * Easy Lead capture Vtiger Webforms and Contacts synchronization is free 
 * software; you can redistribute it and/or modify it under the terms of the GNU 
 * Affero General Public License version 3 as published by the Free Software 
 * Foundation with the addition of the following permission added to Section 15 
 * as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK IN WHICH THE 
 * COPYRIGHT IS OWNED BY Smackcoders, FEasy Lead capture Vtiger Webforms and 
 * Contacts synchronization  DISCLAIMS THE WARRANTY OF NON INFRINGEMENT OF THIRD
 * PARTY RIGHTS.
 *
 * Easy Lead capture Vtiger Webforms and Contacts synchronization is 
 * distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 * PURPOSE.  See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact Smackcoders at email address info@smackcoders.com.
 *
 * The interactive user interfaces in original and modified versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the Easy Lead capture 
 * Vtiger Webforms and Contacts synchronization copyright notice. If the
 * display of the logo is not reasonably feasible for technical reasons, the 
 * Appropriate Legal Notices must display the words "Copyright Smackcoders. 2013.
 * All rights reserved".
 ********************************************************************************/

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

                $version_string = $config['version'];
                $version_array = explode('.', $version_string);
                $version = $version_array[0];
		$module = "Contacts";

		if($version == 6)
		{
			global $plugin_dir_wp_tiger;
			chdir($plugin_dir_wp_tiger);
			include_once($plugin_dir_wp_tiger."vtwsclib/Vtiger/WSClient.php");

			$url = $config['url'];
			$username = $config['smack_host_username'];
			$accesskey = $config['smack_host_access_key'];
			$client = new Vtiger_WSClient($url);
			$login = $client->doLogin($username, $accesskey);
			if(!$login) return 'Login Failed';
			else {
				$record = $client->doCreate($module, $post);
				if($record)
				{
					$data = "/{$module} entry is added to vtiger CRM./";
				}
			}
		}
		else
		{
			$ch  = curl_init ($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec ($ch);
			curl_close ($ch);
		}

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
