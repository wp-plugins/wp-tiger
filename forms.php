<?
function plugin_settings() {
	$siteurl = site_url ();
	$config = get_option ( 'smack_vtlc_settings' );
	$config_field = get_option ( "smack_vtlc_field_settings" );
	
	$content = '<div style="width:95%">
			<div style="float:left">';
	
	if (! isset ( $config_field ['fieldlist'] )) {
		$content .= '<form class="left-side-content" id="smack_vtlc_form"
						action="' . $siteurl . '/wp-admin/admin.php?page=wp-tiger&action=vtiger_db_fields" 
						method="post">';
	} else {
		$content .= '<form class="left-side-content" id="smack_vtlc_form" 
						action="' . $_SERVER ['REQUEST_URI'] . '" method="post">';
	}
                if(isset($_POST['Submit']) && $_POST['Submit'] == 'Save Settings'){ ?>
                        <script>
                        saveSettings();
                        </script>
                <?php }	
	$content .= '<input type="hidden" name="page_options" value="smack_vtlc_settings" />
					<input type="hidden" name="smack_vtlc_hidden" value="1" />
					<h2>VtigerCRM Contact Form Settings</h2>
					<br />
					<div class="messageBox" id="message-box" style="display:none;" ><b>Settings Successfully Saved!</b></div>
					<h3>Database settings</h3>
					<div id="dbfields">
						<table>
							<tr>
								<td class="smack_settings_smack_settings_td_label"><label>Database
										hostname</label></td>
								<td><input class="smack_settings_input_text" type="text"
									id="hostname" name="hostname"
									value="' . $config ['hostname'] . '" /></td>
							</tr>
							<tr>
								<td class="smack_settings_td_label"><label>Database username</label>
								</td>
								<td><input class="smack_settings_input_text" type="text" id="dbuser"
									name="dbuser" value="' . $config ['dbuser'] . '" /></td>
							</tr>
							<tr>
								<td class="smack_settings_td_label"><label>Database password</label>
								</td>
								<td><input class="smack_settings_input_text" type="text" id="dbpass"
									name="dbpass" value="' . $config ['dbpass'] . '" /><br /></td>
							</tr>
							<tr>
								<td class="smack_settings_td_label"><label>Database name</label></td>
								<td><input class="smack_settings_input_text" type="text" id="dbname"
									name="dbname" value="' . $config ['dbname'] . '" /></td>
							</tr>
						</table>
					</div>
					<table>
						<tr>
							<td class="smack_settings_td_label"><input type="button"
								class="button" value="Test database connection"
								onclick="testDatabaseCredentials(\'' . $siteurl . '\');" /></td>
							<td id="smack-database-test-results"></td>
						</tr>
					
					</table>
					<h3>VtigerCRM settings</h3>
					<div id=vtigersettings>
						<table>
							<tr>
								<td class="smack_settings_td_label"><label>Vtiger URL</label></td>
								<td><input class="smack_settings_input_text" type="text" id="url"
									name="url" value="' . $config ['url'] . '" /></td>
							</tr>
							<tr>
								<td class="smack_settings_td_label"><label>Application Key</label></td>
								<td><input class="smack_settings_input_text" type="text" id="appkey"
									name="appkey" value="' . $config ['appkey'] . '" /></td>
							</tr>
						</table>
						<br />
						<h3>Capturing WordPress users</h3>
						<table>
							<tr>
								<td><br /> <label>
										<div style="float: left">Do you need to capture the registering
											users</div>
										<div style="float: right; padding-left: 5px;">:</div>
								</label></td>
								<td><br /> <input type="checkbox"
									class="smack-vtiger-settings-user-capture"
									name="wp_tiger_smack_user_capture" id="wp_tiger_smack_user_capture"';
	
	if ($config ['wp_tiger_smack_user_capture'] == 'on') {
		$content .= "checked";
	}
	$content .= '>
					</td>
					</tr>
					<!--<tr>
						<td>
							<div style="float: left">Sync WP members to VtigerCRM contacts</div>
							<div style="float: right; padding-left: 5px;">:</div>
						</td>
						<td><input type="button" value="Sync"
							class="button-secondary submit-add-to-menu"
							onclick="captureAlreadyRegisteredUsersWpTiger();" />
							<div id="please-upgrade" style="position: absolute; z-index: 100;"></div>
						</td>
					</tr>-->
					
					</table>
					
					</div>
					<input type="hidden" name="posted" value="Posted">
					<p class="submit">
						<input name="Submit" type="submit" value="Save Settings" class="button-primary" />
					</p>
					<div id="vt_fields_container"></div>
					</form></div>
<div style="float:right;">
<p><h3>How To Configure WP-Tiger in wordpress?</h3></p>
<iframe width="560" height="315" src="//www.youtube.com/embed/lX0evNGL5tc?list=PL2k3Ck1bFtbR7d8nRq-oc5iMDBm2ITWuX" frameborder="0" allowfullscreen></iframe>
</div>
</div>';
	echo $content;
//	echo rightSideContent ();
}

if (sizeof ( $_POST ) && isset ( $_POST ["smack_vtlc_hidden"] )) {
	
	foreach ( $fieldNames as $field => $value ) {
		$config [$field] = $_POST [$field];
	}
	
	update_option ( 'smack_vtlc_settings', $config );
}

?>
