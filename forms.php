<?


function plugin_settings_page() {  

$siteurl = site_url();
$config = get_option('smack_vtlc_settings');
$config_field = get_option("smack_vtlc_field_settings");

$topContent = topContent();
echo $topContent;
?>

<?php
if(isset($_POST['posted']))
{
		settings_saved();
}
if(!isset($config_field['fieldlist']))
{
?>

	<form class="left-side-content" id="smack_vtlc_form"
	action="<?php echo $siteurl.'/wp-admin/admin.php?page=vtiger_db_fields';?>"
	method="post">
<?php 
}
else
{
?>
	<form class="left-side-content" id="smack_vtlc_form"
	action="<?php echo $_SERVER['REQUEST_URI']; ?>"
	method="post">
<?php
}

?>
		<input type="hidden" name="page_options" value="smack_vtlc_settings" />
		<input type="hidden" name="smack_vtlc_hidden" value="1" />
<h2>Vtiger Contact Form Settings</h2><br/>
<h3>DB Settings</h3>
<div id="dbfields">
	<table>
		<tr>
			<td class="smack_settings_smack_settings_td_label" >
				<label>Database Host</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="hostname" name="hostname" value="<?php echo $config['hostname'];?>"/>
			</td>
		</tr>
		<tr>
			<td class="smack_settings_td_label">
				<label>Database User</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="dbuser" name="dbuser" value="<?php echo $config['dbuser'];?>"/>
			</td>
		</tr>
		<tr>
			<td class="smack_settings_td_label">
				<label>Database Password</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="dbpass" name="dbpass" value="<?php echo $config['dbpass'];?>"/><br/>
			</td>
		</tr>
		<tr>
			<td class="smack_settings_td_label">
				<label>Database Name</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="dbname" name="dbname" value="<?php echo $config['dbname'];?>"/>
			</td>
		</tr>
	</table>
</div>
<table>
	<tr>
		<td class="smack_settings_td_label">
			<input type="button" class="button" value="Test Database Credentials" onclick="testDatabaseCredentials('<?php echo $siteurl;?>');"/>
		</td>
		<td id="smack-database-test-results">
			
		</td>
	</tr>

</table>
<h3>Vtiger Settings</h3>
<div id=vtigersettings>
	<table>
		<tr>
			<td class="smack_settings_td_label">
				<label>Vtiger URL</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="url" name="url" value="<?php echo $config['url'];?>"/>
			</td>
		</tr>
		<tr>
			<td class="smack_settings_td_label">
				<label>Application Key</label>
			</td>
			<td>
				<input class="smack_settings_input_text" type="text" id="appkey" name="appkey" value="<?php echo $config['appkey'];?>"/>
			</td>
		</tr>
	</table>
<br/>
<h3>Capturing Wordpress users</h3>
<table>
	<tr>
		<td><br/>
			<label>Do you need to capture the registering users : </label>
		</td>
		<td><br/>
			<input type='checkbox' class='smack-vtiger-settings-user-capture' name='wp_tiger_smack_user_capture' id='wp_tiger_smack_user_capture' 
<?php
if($config['wp_tiger_smack_user_capture']=='on')
{
	echo "checked";
}
?>
>
		</td>
	</tr>
	<tr>
		<td>
			Sync WP members to vTiger Contacts:
		</td>
		<td>
			<input type="button" value="<?php _e('Sync');?>" class="button-secondary submit-add-to-menu" onclick="captureAlreadyRegisteredUsersWpTiger();"/>
			<div id="please-upgrade" style="position: absolute; z-index: 100;"></div>
		</td>
	</tr>

</table>

</div>
<input type="hidden" name="posted" value="<?php echo 'posted';?>">
		<p class="submit">
			<input type="submit" value="<?php _e('Save Vtiger Settings');?>" class="button-primary"/>
		</p>
		<div id="vt_fields_container">
		</div>
	</form>

<?php
$content = rightSideContent();
echo $content;

}

if( sizeof($_POST) && isset($_POST["smack_vtlc_hidden"]) ) {

		foreach ($fieldNames as $field=>$value){
			$config[$field] = $_POST[$field];
		}

	update_option('smack_vtlc_settings', $config);

}

?>
