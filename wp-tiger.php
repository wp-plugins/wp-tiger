<?php 
/*
Plugin Name: Wordpress vTiger crm Lead Capture
Plugin URI: http://www.smackcoders.com
Description: A plugin that Captures the lead for vtigercrm
Version: 1.1.0
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
		'appkey' => __('Application Key')
	);	


require_once 'get-vt-fields.php';
require_once 'widget-fields.php';
require_once 'smack-vtlc-shortcodes.php';
require_once 'forms.php';
function setup_theme_admin_menus() {  
	add_menu_page('Theme settings', 'wp-tiger', 'manage_options',  
	       'plugin_settings', 'plugin_settings_page');
	add_submenu_page('plugin_settings',  
	       'Front Page Elements', 'Contact Form Fields', 'manage_options',  
	       'vtiger_db_fields', 'get_Vtiger_DB_Fields');
	add_submenu_page('plugin_settings',  
	       'Front Page Elements', 'Widget Area Fields', 'manage_options',  
	       'widget_fields', 'widget_Fields'); 
}  
   add_action("admin_menu", "setup_theme_admin_menus");  

wp_enqueue_script("plugin_settings_page", "/wp-content/plugins/smack-vtlc/js/smack-vtlc-scripts.js", array("jquery"));

function settings_saved($msg='')
{
	$output .= "<div id='setting-error-settings_updated' style='margin: 5px 0 15px;' class='updated settings-error'> \n";
	$output .= "<p><strong>Settings Saved</strong></p>$msg";
	$output .= "</div> \n";
	echo $output;
}
?>
