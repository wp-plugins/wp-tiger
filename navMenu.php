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

global $wptigermenus;
$wptigermenus = array('vtiger_db_fields' => __('Lead Form Fields'), 'widget_fields' => __('Widget Form Fields'), 'capture_wp_users' => __('Sync WP Users'), 'plugin_settings' => __('Settings'), 'wptiger_listShortcodes' => __('List Shortcodes'));

function topnavmenu() {
	global $wptigermenus;
	$class = "";
	$top_nav_menu = "<div class='nav-pills-div'>";
	$top_nav_menu .= '<ul class="nav nav-pills">';
	$top_nav_menu .= '       <ul class="nav nav-tabs">';
	if (is_array($wptigermenus)) {
		foreach ($wptigermenus as $links => $text) {
			if (!isset ($_REQUEST ['action']) && ($links == "plugin_settings")) {
				$class = 'button button-default';
			} elseif (isset($_REQUEST['action']) && ($_REQUEST ['action'] == $links)) {
				$class = "button button-default";
			}
                              else
                                 $class="button button-primary";
			$top_nav_menu .= '<li > <a href="?page=wp-tiger&action=' . $links . '" class = "saio_nav_smartbot"><button class="'.$class.'" type="button">' . $text . '</button></a> </li>';
			$class = "";
		}
	}
	$top_nav_menu .= '        </ul>
                        </ul>';
	$top_nav_menu .= '</div>';
	return $top_nav_menu;
}

function getActionWpTiger() {
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
	} else {
		$action = 'plugin_settings';
	}
	return $action;
}

function displaySettings() {
	echo "<h3>Please save the settings first</h3>";
}
