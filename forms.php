<?
function plugin_settings_page() {  

$config = get_option('smack_vtlc_settings');
$config_field = get_option("smack_vtlc_field_settings");

if(isset($_POST['posted']))
{
		settings_saved();
}
if(!isset($config_field['fieldlist']))
{
?>

	<form id="smack_vtlc_form"
	action="<?php echo site_url().'/wp-admin/admin.php?page=vtiger_db_fields';?>"
	method="post">
<?php 
}
else
{
?>

	<form id="smack_vtlc_form"
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
<td>
<label>Database Host</label>
</td>
<td>
<input type="text" id="hostname" name="hostname" value="<?php echo $config['hostname'];?>"/>
</td>
</tr>
<tr>
<td>
<label>Database User</label>
</td>
<td>
<input type="text" id="dbuser" name="dbuser" value="<?php echo $config['dbuser'];?>"/>
</td>
</tr>
<tr>
<td>
<label>Database Password</label>
</td>
<td>
<input type="text" id="dbpass" name="dbpass" value="<?php echo $config['dbpass'];?>"/><br/>
</td>
</tr>
<tr>
<td>
<label>Database Name</label>
</td>
<td>
<input type="text" id="dbname" name="dbname" value="<?php echo $config['dbname'];?>"/>
</td>
</tr>
</table>
</div>

<h3>Vtiger Settings</h3>
<div id=vtigersettings>
<table>
<tr>
<td>
<label>Vtiger URL</label>
</td>
<td>
<input style="width:300px;" type="text" name="url" value="<?php echo $config['url'];?>"/>
</td>
</tr>
<tr>
<td>
<label>Application Key</label>
</td>
<td>
<input style="width:250px;" type="text" name="appkey" value="<?php echo $config['appkey'];?>"/>
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
}

if( sizeof($_POST) && isset($_POST["smack_vtlc_hidden"]) ) {

		foreach ($fieldNames as $field=>$value){
			$config[$field] = $_POST[$field];
		}

	update_option('smack_vtlc_settings', $config);

}

?>
