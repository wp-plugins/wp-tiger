<?php 
/*
*Plugin Name: WP Tiger
*Plugin URI: http://www.smackcoders.com
*Description: Easy Lead capture Vtiger Webforms and Contacts synchronization
*Version: 3.0.3
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

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/SmackWPVT.php");
require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/smack-vtlc-shortcodes.php");
require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/navMenu.php");
require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/SmackWPAdminPages.php");
require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/CaptureRegisteringUsers.php");

add_action('init',  array('SmackWPVT', 'init'));

register_deactivation_hook( __FILE__, 'wptiger_deactivate' );

// Admin menu settings
function wptigermenu() {
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

function SmackWPTigertestAccess()
{
	require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/test-access.php");
	die;
}

add_action('wp_ajax_SmackWPTigertestAccess', 'SmackWPTigertestAccess');

function wptiger_settings()
{
	$AdminPages = new SmackWPAdminPages();
        echo $AdminPages->topContent();
        $action = getActionWpTiger(); 
        ?>
        <div id="main-page">
                <?php echo topnavmenu(); ?>
                <div>
                        <?php $AdminPages->$action(); ?>
                </div>
        </div>
        <?php
}

?>
