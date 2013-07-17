<?php
global $menus;
$menus = array (
		'vtiger_db_fields' => __ ( 'Lead Form Fields' ),
		'widget_fields' => __ ( 'Widget Form Fields' ),
		'capture_wp_users' => __ ( 'Sync WP Users' ),
		'plugin_settings' => __ ( 'Settings' ),
		'wptiger_listShortcodes' => __ ( 'List Shortcodes' )
);

function topnavmenu() {
	global $menus;
	$class = "";
	$top_nav_menu = "<div id='top-navigation' class= 'top-navigation-wrapper'>";
	$top_nav_menu .= "<ul class='Navigation-menu-bar'>";
	if (is_array ( $menus )) {
		foreach ( $menus as $links => $text ) {
			if ($_REQUEST ['action'] == $links) {
				$class = "navigation-menu-link-active";
			} elseif (! isset ( $_REQUEST ['action'] ) && ($links == "plugin_settings")) {
				$class = "navigation-menu-link-active";
			}
			$top_nav_menu .= "<li class='navigation-menu'><a class='nav-menu-link $class' href='?page=wp-tiger&action={$links}'>{$text}</a></li>";
			$class = "";
		}
	}
	$top_nav_menu .= "</ul>";
	$top_nav_menu .= "</div>";
	return $top_nav_menu;
}

function getActionWpTiger()
{
        if(isset($_REQUEST['action']))
        {
                $action = $_REQUEST['action'];
        }
        else
        {
                $action = 'plugin_settings';
        }
        return $action;
}

function displaySettings()
{
        echo "<h3>Please save the settings first</h3>";
}

?>
