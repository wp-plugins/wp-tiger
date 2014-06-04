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

add_filter('widget_text', 'do_shortcode');

add_shortcode('display_contact_page', array('SmackWPTigerShortcodes', 'display_page'));

add_shortcode('display_widget_area', array('SmackWPTigerShortcodes', 'display_widget'));

class SmackWPTigerShortcodes {
      public static function display_page($atts) { 
                $fields_string = "";
		$config = get_option("smack_vtlc_settings");
		$config_field = get_option("smack_vtlc_field_settings");
		$module = "Leads";
		$config_widget_field = get_option("smack_vtlc_widget_field_settings");
		if (!empty($config['hostname']) && !empty($config['dbuser'])) {
			if (!empty($config_field['fieldlist']) && is_array($config_field['fieldlist'])) {
				$field_list = implode(',', $config_field['fieldlist']);
			}
			$dbvalues = new wpdb($config['dbuser'], $config['dbpass'], $config['dbname'], $config['hostname']);
			$selectedFields = $dbvalues->get_results("SELECT fieldname, fieldlabel, typeofdata, uitype FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 AND fieldid in ({$field_list}) ORDER BY block, sequence");

		}

		$action = trim($config['url'], "/") . '/modules/Webforms/post.php';
		$content = "<form id='contactform' name='contactform' method='post'>";
		$content .= "<table>";

		$version_string = $config['version'];
		$version_array = explode('.', $version_string);
		$version = $version_array[0];
		$action = trim($config['url'], "/") . '/modules/Webforms/post.php';


		if (isset($_REQUEST['page_contactform'])) {
			extract($_POST);

			foreach ($_POST as $field => $value) {
				if ($version == 6) {
					$post_fields[$field] = $value;
				} else {
					$post_fields[$field] = urlencode($value);
				}
			}

			if ($version < 6) {
				if (!empty($config['appkey'])) {
					$post_fields['appKey'] = $config['appkey'];
				}
			}
			foreach ($post_fields as $key => $value) {
				$fields_string .= $key . '=' . $value . '&';
			}
			rtrim($fields_string, '&');

			if ($version == 6) {
				global $plugin_dir_wp_tiger;
				chdir($plugin_dir_wp_tiger);
				include_once($plugin_dir_wp_tiger . "vtwsclib/Vtiger/WSClient.php");
				$url = $config['url'];
				$username = $config['smack_host_username'];
				$accesskey = $config['smack_host_access_key'];
				$client = new Vtiger_WSClient($url);
				$login = $client->doLogin($username, $accesskey);
				if (!$login) {
 		return 'Login Failed';
                             
				} else {
					$record = $client->doCreate($module, $post_fields);
					if ($record) {
						$data = "/{$module} entry is added to vtiger CRM./";
					}
				}
			} else {
				$url = $action;
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$data =curl_exec($ch);
				curl_close($ch);
			}
			$successfulAtemptsOption = get_option("wp-tiger-contact-form-attempts");
			$total = $successfulAtemptsOption['total'];
			$success = $successfulAtemptsOption['success'];
			if ($data) {
				$total++;
				//$content.= $data;   //remove the comment to see the result from vtiger.
				if (preg_match("/$module entry is added to vtiger CRM./", $data)) {
					$success++;
					$content .= "<tr><td colspan='2' style='text-align:center;color:green;font-size: 1.2em;font-weight: bold;'>Thank you for submitting</td></tr>";
				} else {
					$content .= "<tr><td colspan='2' style='text-align:center;color:red;font-size: 1.2em;font-weight: bold;'>Submitting Failed</td></tr>";
				}
			}
			$successfulAtemptsOption['total'] = $total;
			$successfulAtemptsOption['success'] = $success;
			update_option('wp-tiger-contact-form-attempts', $successfulAtemptsOption);

		}
		if (is_array($config_field['fieldlist'])) {
			foreach ($selectedFields as $field) {
				$content1 = "<p>";
				$content1 .= "<tr>";
				$content1 .= "<td>";
				$content1 .= "<label for='" . $field->fieldname . "'>" . $field->fieldlabel . "</label>";
				$typeofdata = explode('~', $field->typeofdata);
				if ($typeofdata[1] == 'M') {
					$content1 .= "<span  style='color:red;'>*</span>";
				}
				$content1 .= "</td><td>";
				$content1 .= "<input type='hidden' value='" . $typeofdata[1] . "' id='" . $field->fieldname . "_type'>";
				if ($typeofdata[0] == 'E') {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='email' size='30' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='email' size='30' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				} elseif ($field->uitype == 11) {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='30' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='30' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				} elseif ($field->uitype == 17) {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='30' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='30' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}

				} else {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='30' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='30' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				}
				$content1 .= "</td></tr>";

				$content .= $content1;
			}
		}
		$content .= "<tr><td></td><td>";
		$content .= "<p>";
		$content .= "<input type='submit' value='Submit' id='submit' name='submit'></p><span style='font-size:11px;float:right;'>Generated by <a target='_blank' href='http://www.smackcoders.com/free-wordpress-vtiger-webforms-module.html'>WP-Tiger</a></td></tr></table>";
		$content .= "<input type='hidden' value='contactform' name='page_contactform'>";
		$content .= "<input type='hidden' value='Leads' name='moduleName' />
		</form>";
		return $content;
	}

    public static function display_widget($atts) {
               $fields_string="";
		$config = get_option("smack_vtlc_settings");
		$config_field = get_option("smack_vtlc_field_settings");
		$module = "Leads";
		$config_widget_field = get_option("smack_vtlc_widget_field_settings");
		if (!empty($config['hostname']) && !empty($config['dbuser'])) {
			if (!empty($config_widget_field['widgetfieldlist']) && is_array($config_widget_field['widgetfieldlist'])) {
				$field_list = implode(',', $config_widget_field['widgetfieldlist']);
			}
			$dbvalues = new wpdb($config['dbuser'], $config['dbpass'], $config['dbname'], $config['hostname']);
			$selectedFields = $dbvalues->get_results("SELECT fieldname, fieldlabel, typeofdata, uitype FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 AND fieldid in ({$field_list}) ORDER BY block, sequence");

		}

		$version_string = $config['version'];
		$version_array = explode('.', $version_string);
		$version = $version_array[0];
		$action = trim($config['url'], "/") . '/modules/Webforms/post.php';

		$content = "<form id='contactform' method='post'>";
		$content .= "<table>";
		if (isset($_REQUEST['widget_contactform'])) {
			extract($_POST);

			foreach ($_POST as $field => $value) {
				if ($version == 6) {
					$post_fields[$field] = $value;
				} else {
					$post_fields[$field] = urlencode($value);
				}
			}
			if ($version < 6) {
				if (!empty($config['appkey'])) {
					$post_fields['appKey'] = $config['appkey'];
				}
			}
			foreach ($post_fields as $key => $value) {
				$fields_string .= $key . '=' . $value . '&';
			}
			rtrim($fields_string, '&');
			if ($version == 6) {
				global $plugin_dir_wp_tiger;
				chdir($plugin_dir_wp_tiger);
				include_once($plugin_dir_wp_tiger . "vtwsclib/Vtiger/WSClient.php");

				$url = $config['url'];
				$username = $config['smack_host_username'];
				$accesskey = $config['smack_host_access_key'];
				$client = new Vtiger_WSClient($url);
				$login = $client->doLogin($username, $accesskey);
				if (!$login) {
					return 'Login Failed';
				} else {
					$record = $client->doCreate($module, $post_fields);
					if ($record) {
						$data = "/{$module} entry is added to vtiger CRM./";
					}
				}
			} else {
				$url = $action;
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$data =curl_exec($ch);
				curl_close($ch);
			}
			$successfulAtemptsOption = get_option("wp-tiger-contact-widget-form-attempts");

			$total = $successfulAtemptsOption['total'];
			$success = $successfulAtemptsOption['success'];
			if ($data) {
				//$content.= $data;   //remove the comment to see the result from vtiger.
				$total++;
				if (preg_match("/$module entry is added to vtiger CRM./", $data)) {
					$success++;
					$content .= "<tr><td colspan='2' style='text-align:center;color:green;font-size: 1.2em;font-weight: bold;'>Thank you for submitting</td></tr>";
				} else {
					$content .= "<tr><td colspan='2' style='text-align:center;color:red;font-size: 1.2em;font-weight: bold;'>Submitting Failed</td></tr>";
				}
			}
			$successfulAtemptsOption['total'] = $total;
			$successfulAtemptsOption['success'] = $success;
			update_option('wp-tiger-contact-widget-form-attempts', $successfulAtemptsOption);

		} // Fredrick Marks Code ends here
		if (is_array($config_widget_field['widgetfieldlist'])) {
			foreach ($selectedFields as $field) {

				$content1 = "<p>";
				$content1 .= "<tr>";
				$content1 .= "<td>";
				$content1 .= "<label for='" . $field->fieldname . "'>" . $field->fieldlabel . "</label>";
				$typeofdata = explode('~', $field->typeofdata);
				if ($typeofdata[1] == 'M') {
					$content1 .= "<span style='color:red;'>*</span>";
				}
				$content1 .= "</td><td>";
				$content1 .= "<input type='hidden' value='" . $typeofdata[1] . "' id='" . $field->fieldname . "_type'>";
				if ($typeofdata[0] == 'E') {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='email' size='20' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='email' size='20' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				} elseif ($field->uitype == 11) {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='20' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='20' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				} elseif ($field->uitype == 17) {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='20' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='20' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}

				} else {
					if ($typeofdata[1] == 'M') {
						$content1 .= "<input type='text' size='20' value='' required name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					} else {
						$content1 .= "<input type='text' size='20' value='' name='" . $field->fieldname . "' id='" . $field->fieldname . "'></p>";
					}
				}

				//			$content1.="<input type='text' class='wp-tiger-widget-area-text' size='20' value='' name='".$field->fieldname."' id='".$field->fieldname."'></p>";
				$content1 .= "</td></tr>";
				$content .= $content1;
			}
		}
		$content .= "<tr><td></td><td>";
		$content .= "<p>";
		$content .= "<input type='submit' class='wp-tiger-widget-area-submit' value='Submit' id='submit' name='submit'></p></td></tr>";
		$content .= "<tr><td></td><td style='font-size:9px;float:right;'>Generated by <a target='_blank' href='http://www.smackcoders.com/free-wordpress-vtiger-webforms-module.html'>WP-Tiger</a></td></tr></table>";
		$content .= "<input type='hidden' value='contactform' name='widget_contactform'>";
		$content .= "<input type='hidden' value='Leads' name='moduleName'/>
		</form>";
		return $content;
	}
}
