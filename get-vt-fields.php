<?php
/**
 * 
 * Function to get vtiger fields from the database
 */
function get_Vtiger_DB_Fields() {
	$config = get_option('smack_vtlc_settings');
if(isset($_POST['hostname']))
{
	$config['hostname'] = $_POST['hostname'];
	$config['dbuser'] = $_POST['dbuser'];
	$config['dbname'] = $_POST['dbname'];
	$config['dbpass'] = $_POST['dbpass'];
	$config['url'] = $_POST['url'];
	$config['appkey'] = $_POST['appkey'];
	update_option('smack_vtlc_settings', $config);
}
else
{
	$config = get_option('smack_vtlc_settings');
	$config_field = get_option("smack_vtlc_field_settings");
}
?>
<?php 
if(isset($_POST['field_posted']))
{
	$config_field['fieldlist'] = array();
	if(isset($_POST['no_of_vt_fields'])){
		$fieldArr = array();
		for($i=0; $i<=$_POST['no_of_vt_fields']; $i++){
			if(isset( $_POST["smack_vtlc_field$i"] )){
				array_push($fieldArr, $_POST["smack_vtlc_field_hidden$i"]);
			}
		}
		$config_field['fieldlist'] = $fieldArr;
	}
	update_option('smack_vtlc_field_settings', $config_field);
	settings_saved('<br/>Please paste the below short code at the page you want to display the contact form<br/><h3>[display_contact_page]</h3>');

}
?>
	<form id="smack_vtlc_field_form"
	action="<?php echo $_SERVER['REQUEST_URI']; ?>"
	method="post">
<?php
	if( !empty($config['hostname']) && !empty($config['dbuser']) ){
		$vtdb = new wpdb( $config['dbuser'], $config['dbpass'], $config['dbname'], $config['hostname'] );
		$allowedFields = $vtdb->get_results("SELECT fieldid, fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 ORDER BY block, sequence");

		if( !is_array($config_field['fieldlist']) ){
			$config_field['fieldlist'] = array();
		}
	}
	elseif( !empty($_POST['hostname']) && !empty($_POST['dbuser']) ){
		$vtdb = new wpdb( $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname'], $_POST['hostname'] );
		$allowedFields = $vtdb->get_results("SELECT fieldid, fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 ORDER BY block, sequence");

		if( !is_array($config_field['fieldlist']) ){
			$config_field['fieldlist'] = array();
		}
	}
	if(!empty($allowedFields)) { ?>
			<h3 class="title"><?php _e('Field settings')?></h3>
			<?php echo $output;?>
			<input type="hidden" name="posted" value="<?php echo 'posted';?>">
			<label for="smack_vtlc_fields"><?php _e('Choose the fields you want to display in Lead Capture page')?></label><br/>

			<table class="form-table">
				<tbody>
					<tr valign="top">

						<td>
							<input type="hidden" id="no_of_vt_fields" name="no_of_vt_fields" value="<?php echo sizeof($allowedFields)?>">
							<?php foreach ($allowedFields as $key=>$field) {?>
							<table>
								<tr>
									<?php $typeofdata = explode( '~', $field->typeofdata ); ?>
									<td width="85%"><?php echo $field->fieldlabel;if( $typeofdata[1] == 'M' ){ ?> 
										<span style="color:#FF4B33">&nbsp;*</span>
									<?php } ?></td>
									<td>
										<input type="hidden" value="<?php echo $field->fieldlabel;?>" id="field_label<?php echo $key;?>" >
										<input type="hidden" value="<?php echo $typeofdata[1];?>" id="field_type<?php echo $key;?>" >
										<input type="hidden" name="smack_vtlc_field_hidden<?php echo $key;?>" value="<?php echo $field->fieldid ;?>" />
										
										<?php if( in_array($field->fieldid, $config_field['fieldlist']) )
											$checked='checked="checked"';
										else 
											$checked = "";
											?>
										<input type="checkbox" value="<?php echo $field->fieldname;?>" id="smack_vtlc_field<?php echo $key;?>" name="smack_vtlc_field<?php echo $key;?>" <?php echo $checked;?>>
									</td>
								</tr>
							</table>
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="<?php  _e('Save Field Settings'); ?>" class="button-primary" name="Submit" onclick="smack_validateFields()">
			</p>
	<input type="hidden" name="field_posted" value="<?php echo 'posted';?>">

	</form>
	<?php } else{
		_e("Please enter a valid database setting");
	}
	die();
}?>
