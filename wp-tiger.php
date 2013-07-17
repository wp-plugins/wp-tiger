<?php 
/*
*Plugin Name: WP Tiger
*Plugin URI: http://www.smackcoders.com
*Description: Easy Lead capture Vtiger Webforms and Contacts synchronization
*Version: 3.0.0
*Author: smackcoders.com
*Author URI: http://www.smackcoders.com
*
* Copyright (C) 2013 Smackcoders (www.smackcoders.com)
*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*
* @link http://www.smackcoders.com/blog/category/free-wordpress-plugins
***********************************************************************************************
*/
require_once (dirname ( __FILE__ ) . '/../../../wp-load.php');

$fieldNames = array(
		'hostname' => __('Database Host'),
		'dbuser' => __('Database User'),
		'dbpass' => __('Database Password'),
		'dbname' => __('Database Name'),
		'url' => __('URL'),
		'appkey' => __('Application Key'),
		'wp_tiger_smack_user_capture' => __('Capture User'),
	);	


require_once 'get-vt-fields.php';
require_once 'widget-fields.php';
require_once 'smack-vtlc-shortcodes.php';
require_once 'forms.php';
require_once 'navMenu.php';
require_once 'pro-features.php';

add_action ( 'admin_enqueue_scripts', 'LoadWpTigerScript' );
add_action ( "admin_menu", "wptiger" );
add_action( 'user_register', 'wp_tiger_capture_registering_users' );

register_deactivation_hook( __FILE__, 'wptiger_deactivate' );

// Admin menu settings
function wptiger() {
	add_menu_page('WPTiger Settings', 'WP-Tiger', 'manage_options', 'wp-tiger', 'wptiger_settings', WP_CONTENT_URL."/plugins/wp-tiger/images/icon.png");
}

function LoadWpTigerScript() {
	wp_enqueue_script("wp-tiger-script", "/wp-content/plugins/wp-tiger/js/smack-vtlc-scripts.js", array("jquery"));
	wp_enqueue_style("wp-tiger-css", site_url().'/wp-content/plugins/wp-tiger/css/smack-vtlc-css.css');
}

function wptiger_deactivate()
{
	delete_option( 'smack_vtlc_settings' );
	delete_option( 'smack_vtlc_field_settings' );
	delete_option( 'smack_vtlc_widget_field_settings' );
}

function wptiger_settings()
{
        echo topContent();
        $action = getActionWpTiger(); 
        ?>
        <div id="main-page">
                <?php echo topnavmenu(); ?>
                <div>
                        <?php $action(); ?>
                </div>
        </div>
        <?php
}

function wptiger_rightContent(){
	$rightContent = '<div class="wptiger-plugindetail-box" id="wptiger-pluginDetails"><h3>Plugin Details</h3>
		<div class="wptiger-box-inside wptiger-plugin-details">
		<table>	<tbody>
		<tr><td><b>Plugin Name</b></td><td>WP Tiger</td></tr>
		<tr><td><b>Version</b></td><td>3.0.0 <a style="text-decoration:none" href="http://www.smackcoders.com/free-wordpress-vtiger-webforms-module.html" target="_blank">( Update Now )</a></td></tr>
		</tbody></table>
		<div class="company-detials" id="company-detials">
		<div class="wptiger-rateus"><img width="70px" height="40px" style="margin-top:10px;" src="'.WP_CONTENT_URL.'/plugins/wp-tiger/images/SubscribeViaEmail.gif"><a style="margin-left:15px;margin-top:-10px;" class="dash-action" target="_blank" href="http://www.smackcoders.com/free-wordpress-vtiger-webforms-module.html">Rate Us</a></div>
		<div class="sociallinks">
		<label>Social Links :</label>
		<span><a target="_blank" href="https://plus.google.com/106094602431590125432"><img src="'.WP_CONTENT_URL.'/plugins/wp-tiger/images/googleplus.png"></a></span>
		<span><a target="_blank" href="https://www.facebook.com/smackcoders"><img src="'.WP_CONTENT_URL.'/plugins/wp-tiger/images/facebook.png"></a></span>
		<span><a target="_blank" href="https://twitter.com/smackcoders"><img src="'.WP_CONTENT_URL.'/plugins/wp-tiger/images/twitter.png"></a></span>
		<span><a target="_blank" href="http://www.linkedin.com/company/smackcoders"><img src="'.WP_CONTENT_URL.'/plugins/wp-tiger/images/linkedin.png"></a></span>
		</div>
		<div class="poweredby" id="poweredby"><a target="_blank" href="http://www.smackcoders.com/"><img src="http://www.smackcoders.com/wp-content/uploads/2012/09/Smack_poweredby_200.png"></a></div>
		</div>
		</div><!-- end inside div -->
		</div>';
		return $rightContent;
}

function topContent()
{ //wptiger_topContent
	$header_content = '<div style="background-color: #FFFFE0;border-color: #E6DB55;border-radius: 3px 3px 3px 3px;border-style: solid;border-width: 1px;margin: 5px 15px 2px; margin-top:15px;padding: 5px;text-align:center"> Please check out <a href="http://www.smackcoders.com/blog/category/free-wordpress-plugins" target="_blank">www.smackcoders.com</a> for the latest news and details of other great plugins and tools. </div><br/>';
	return $header_content;
}

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
