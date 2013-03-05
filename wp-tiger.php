<?php 
/*
Plugin Name: WordPress VtigerCRM Lead/Contact Capture
Plugin URI: http://www.smackcoders.com
Description: A plugin that captures the lead for VtigerCRM
Version: 2.5.0
Author: smackcoders.com
Author URI: http://www.smackcoders.com
*/


register_deactivation_hook( __FILE__, 'myplugin_deactivate' );


function myplugin_deactivate()
{
	delete_option( 'smack_vtlc_settings' );
	delete_option( 'smack_vtlc_field_settings' );
	delete_option( 'smack_vtlc_widget_field_settings' );
}

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
function setup_theme_admin_menus() { 
	$contentUrl = WP_CONTENT_URL; 
	add_menu_page('Plugin settings', 'WP-Tiger', 'manage_options',  
	       'plugin_settings', 'plugin_settings_page', "$contentUrl/plugins/wp-tiger/images/icon.png");
	add_submenu_page('plugin_settings',  
	       'Contact Form Fields', 'Contact Form Fields', 'manage_options',  
	       'vtiger_db_fields', 'get_Vtiger_DB_Fields');
	add_submenu_page('plugin_settings',  
	       'Widget Area Fields', 'Widget Area Fields', 'manage_options',  
	       'widget_fields', 'widget_Fields'); 
}  
   add_action("admin_menu", "setup_theme_admin_menus");  

wp_enqueue_script("wp-tiger-script", "/wp-content/plugins/wp-tiger/js/smack-vtlc-scripts.js", array("jquery"));
wp_enqueue_style("wp-tiger-css", site_url().'/wp-content/plugins/wp-tiger/css/smack-vtlc-css.css');
add_action( 'user_register', 'wp_tiger_capture_registering_users' );

function rightSideContent()
{
$contentUrl = WP_CONTENT_URL;
$content = "<div class='right-side-content'>
<p>WP-Tiger plugin helps to easily capture leads to VtigerCRM from your WordPress through a contact form. Short code can used in page, post and separate short code for widgets as well.</p> 
<p>
*    Admin can fetch VtigerCRM lead/contact fields directly to WordPress forms.
</p>
<p>
*    Options to enable/disable.
</p>
<p>
*    Short code to integrate form in post / page.
</p>
<p>
*    Separate short code to integrate form even as widget in sidebar.
</p>
<p>
*    Captures WP members to VtigerCRM Contacts.
</p>
<p>Configuring our plugin is as simple as that. If you have any questions, issues and request on new features, plaese visit <a href='http://www.smackcoders.com/blog/category/free-wordpress-plugins' target='_blank'>Smackcoders.com blog </a></p>

<p style = 'color:#FC0000;'>
 Important Note : Access key of VtigerCRM My preferences and \"yourvtiger/modules/Webforms/Webforms.config.php\" should be same. If not please update it in Webforms.config.php.
</p>
<div>
<p style='font-size:14px; font-weight:bold; '><a href='http://www.smackcoders.com/connectors/wp-vtiger-pro.html' target='_blank'>Pro version</a> (wp-tiger-pro) Features</p>

<p>*    Unlike free version, the pro version uses Web services to communicate with VtigerCRM.</p>
<p>*    Capture both lead and contacts from WordPress to VtigerCRM.</p>
<p>*    Change the position order of the fields from wp dashboard itself.</p>
<p>*    Change the display label of the fields</p>
<p>*    Set mandatory fields using wp-tiger pro options.</p>
<p>*    Add Captcha feature to reduce risk of spam bots.</p>
<p>*    Can generate shortcodes separately for page/post and mini widget forms to accommodate within any theme sidebar. So no design modification needed.</p>
<p>*    Capture WP members to VtigerCRM contacts.</p>
<p>*    Syncs already registered users to VtigerCRM contacts.</p>
<p>To upgrade to pro version contact us at <a href='mailto:sales@smackcoders.com'>sales@smackcoders.com</a></p>
</div>

	<div align='center' style='margin-top:40px;'> 'While the scripts on this site are free, donations are greatly appreciated. '<br/><br/><a href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fenzik@gmail.com&lc=JP&item_name=WordPress%20Plugins&item_number=wp%2dplugins&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted' target='_blank'><img src='$contentUrl/plugins/wp-tiger/images/paypal_donate_button.png' /></a><br/><br/><a href='http://www.smackcoders.com/' target='_blank'><img src='http://www.smackcoders.com/wp-content/uploads/2012/09/Smack_poweredby_200.png'></a>
	</div><br/>
</div>
";

return $content;

}


function topContent()
{
	return '<div style="background-color: #FFFFE0;border-color: #E6DB55;border-radius: 3px 3px 3px 3px;border-style: solid;border-width: 1px;margin: 5px 15px 2px; margin-top:15px;padding: 5px;text-align:center"> Please check out <a href="http://www.smackcoders.com/blog/category/free-wordpress-plugins" target="_blank">www.smackcoders.com</a> for the latest news and details of other great plugins and tools. </div><br/>';
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
	// firstname  lastname  email
	}
}

function settings_saved($msg='')
{
	$output .= "<div id='setting-error-settings_updated' style='margin: 5px 0 15px;' class='updated settings-error'> \n";
	$output .= "<p><strong>Settings Saved</strong></p>$msg";
	$output .= "</div> \n";
	echo $output;
}
?>
