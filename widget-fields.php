<?php
function widget_fields() {
	$config = get_option ( 'smack_vtlc_settings' );
	$config_widget_field = get_option ( "smack_vtlc_widget_field_settings" );
	$topContent = topContent ();
	$imagepath = WP_CONTENT_URL . '/plugins/wp-tiger/images/';
	
	if (isset ( $_POST ['widget_field_posted'] )) {
		$config_widget_field ['widgetfieldlist'] = array ();
		if (isset ( $_POST ['no_of_vt_fields'] )) {
			$fieldArr = array ();
			for($i = 0; $i <= $_POST ['no_of_vt_fields']; $i ++) {
				if (isset ( $_POST ["smack_vtlc_field$i"] )) {
					array_push ( $fieldArr, $_POST ["smack_vtlc_field_hidden$i"] );
				}
			}
			$config_widget_field ['widgetfieldlist'] = $fieldArr;
		}
		update_option ( 'smack_vtlc_widget_field_settings', $config_widget_field );
	}
	
	$widgetContent = '<div class="left-side-content">
				 <div class="upgradetopro" id="upgradetopro" style="display:none;">This feature is only available in Pro Version, Please <a href="http://www.smackcoders.com/wp-vtiger-pro.html">UPGRADE TO PRO</a> </div>
				<div class="messageBox" id="message-box" style="display:none;" ><b>Successfully Saved!</b></div>
			       	<form id="smack_vtlc_field_form" action="' . $_SERVER ['REQUEST_URI'] . '" method="post">';
	
	if (! empty ( $config ['hostname'] ) && ! empty ( $config ['dbuser'] )) {
		$vtdb = new wpdb ( $config ['dbuser'], $config ['dbpass'], $config ['dbname'], $config ['hostname'] );
		$allowedFields = $vtdb->get_results ( "SELECT fieldid, fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 ORDER BY block, sequence" );
		
		if (! is_array ( $config_widget_field ['widgetfieldlist'] )) {
			$config_widget_field ['widgetfieldlist'] = array ();
		}
	} elseif (! empty ( $_POST ['hostname'] ) && ! empty ( $_POST ['dbuser'] )) {
		$vtdb = new wpdb ( $_POST ['dbuser'], $_POST ['dbpass'], $_POST ['dbname'], $_POST ['hostname'] );
		$allowedFields = $vtdb->get_results ( "SELECT fieldid, fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 ORDER BY block, sequence" );
		
		if (! is_array ( $config_widget_field ['widgetfieldlist'] )) {
			$config_widget_field ['widgetfieldlist'] = array ();
		}
	}
	if (! empty ( $allowedFields )) {
                if(isset($_POST['Submit']) && $_POST['Submit'] == 'Save Field Settings'){ ?>
                        <script>
                        saveSettings();
                        </script>
                <?php }
		$widgetContent .= '<div style="width:25%;float:left;"><h3 class="title">Widget Field settings</h3></div><div style="width:75%;float:right;"><p>( Please use the short code <b> [display_widget_area]</b> in widgets )</p></div><br/><br/>
						<div style="margin-top:10px;">
		                        <div style="padding:2px;"><input type="checkbox" id="skipduplicate" onclick="upgradetopro()" /> Skip Duplicates. Note: Email should be mandatory and enabled to make this work. </div>
                		        <div style="padding:2px;"><input type="checkbox" id="generateshortcode" onclick="upgradetopro()" /> Generate this Shortcode for widget form. </div>
		                        <div style="padding:2px;">Assign Leads to User: <select id="assignto" onclick="upgradetopro()" ><option>Administrator</option><option>Standard User</option></select></div>
		                   </div><br/>
						<input type="hidden" name="posted" value="Posted"> 
						<label for="smack_vtlc_fields">Choose the fields you want to display in Widget Lead Capture page , Choose minimum fields</label><br/><br/>
						<input type="button" class="button-secondary submit-add-to-menu" name="sync_crm_fields" value="Fetch CRM Fields"
						onclick="upgradetopro()" />
						<input type="submit" value="Save Field Settings" class="button-secondary submit-add-to-menu" 
							name="Submit" />
						<input type="button" class="button-secondary submit-add-to-menu" name="make_mandatory" 
							id="make_mandatory" value="Save Mandatory Fields" onclick="upgradetopro()" /> 
						<input type="button" class="button-secondary submit-add-to-menu" name="save_display_name" 
							id="save_display_name" value="Save Labels" onclick="upgradetopro()" /> 
						<input type="button" class="button-create-shortcode" name="create_shortcode" id="create_shortcode" 
							value="Generate Shortcode" onclick="upgradetopro()" /><br/></br>

						<table class="tableborder">
							<tr class="smack_alt">
								<th style="width: 50px;"><input type="checkbox" name="selectall" id="selectall"
									onclick="select_allfields(\'smack_vtlc_field_form\',\'widget\')" /></th>
								<th style="width: 200px;"><h5>Field Name</h5></th>
								<th style="width: 100px;"><h5>Show Field</h5></th>
								<th style="width: 100px;"><h5>Order</h5></th>
								<th style="width: 120px;"><h5>Mandatory Fields</h5></th>
								<th style="width: 200px;"><h5>Field Label Display</h5></th>
							</tr>

							<tbody>
							<tr valign="top">
								<td><input type="hidden" id="no_of_vt_fields" name="no_of_vt_fields" value="' . sizeof ( $allowedFields ) . '">';
		
		$nooffields = count ( $allowedFields );
		$inc = 1;
		foreach ( $allowedFields as $key => $field ) {
			if($inc % 2 == 1){ 
				$widgetContent .= '<tr class="smack_highlight">';
			}else{
				$widgetContent .= '<tr class="smack_highlight smack_alt">';
			}
			$typeofdata = explode ( '~', $field->typeofdata );
			$widgetContent .= '<td class="smack-field-td-middleit">
								<input type="hidden" value="' . $field->fieldlabel . '"id="field_label' . $key . '"> 
								<input type="hidden" value="' . $typeofdata [1] . '" id="field_type' . $key . '"> 
								<input type="hidden" name="smack_vtlc_field_hidden' . $key . '"value="' . $field->fieldid . '" />';
			
			if ($typeofdata [1] == 'M')
				$checked = 'checked="checked" disabled';
			else
				$checked = "";
			
			if ($typeofdata [1] == 'M') {
				$widgetContent .= '<input type="hidden" value="' . $field->fieldname . '"id="smack_vtlc_field' . $key . '"
									name="smack_vtlc_field' . $key . '" /> 
								<input type="checkbox" value="' . $field->fieldname . '"' . $checked . '>';
			} else {
				$widgetContent .= '<input type="checkbox" value="' . $field->fieldname . '"id="smack_vtlc_field' . $key . '"
								name="smack_vtlc_field' . $key . '" ' . $checked . '>';
			}
			
			$widgetContent .= '</td>
							<td>' . $field->fieldlabel;
			if ($typeofdata [1] == 'M') {
				$widgetContent .= '<span style="color: #FF4B33">&nbsp;*</span>';
			}
			
			$widgetContent .= '</td>
							<td class="smack-field-td-middleit">';
			
			if (in_array ( $field->fieldid, $config_widget_field ['widgetfieldlist'] )) {
				if ($typeofdata [1] == 'M') {
					$widgetContent .= '<img src="' . $imagepath . 'tick_strict.png" onclick="upgradetopro()" />';
				} else {
					$widgetContent .= '<img src="' . $imagepath . 'tick.png" onclick="upgradetopro()" />';
				}
			} else {
				$widgetContent .= '<img src="' . $imagepath . 'publish_x.png" onclick="upgradetopro()" />';
			}
			
			$widgetContent .= '</td>	<td class="smack-field-td-middleit">';
			
			if ($inc == 1) {
				$widgetContent .= '<a class="smack_pointer" id="down' . $i . '" onclick="move(\'down\');">
								<img src="' . $imagepath . 'downarrow.png" /></a>';
			} elseif ($inc == $nooffields) {
				$widgetContent .= '<a class="smack_pointer" id="up' . $i . '" onclick="move(\'up\');">
								<img src="' . $imagepath . 'uparrow.png" /></a>';
			} else {
				$widgetContent .= '<a class="smack_pointer" id="down' . $i . '" onclick="move(\'down\');">
								<img src="' . $imagepath . 'downarrow.png" /></a> 
								<a class="smack_pointer" id="up' . $i . '" onclick="move(\'up\');">
								<img src="' . $imagepath . 'uparrow.png" /></a>';
			}
			
			$widgetContent .= '</td>	<td class="smack-field-td-middleit">
							<input type="checkbox" name="check' . $i . '" id="check' . $i . '"';
			
			if ($typeofdata [1] == 'M') {
				$widgetContent .= ' checked="checked" disabled ';
			}
			
			$widgetContent .= '/></td>	<td class="smack-field-td-middleit" id="field_label_display_td' . $i . '">
							<input type="text" id="field_label_display_textbox' . $i . '" class="readonly-text" onclick="upgradetopro()" 
									value="' . $field->fieldlabel . '" readonly /></td>
							</tr>';
			$inc ++;
		}
		
		$widgetContent .= '</td>
									</tr>
								</tbody>
							</table>
							<p class="submit">Please use the short code <b> [display_widget_area]</b> in widgets
							</p>
							<input type="hidden" name="widget_field_posted" value="Posted" />
							</form>
						</div>
						<div class="right-side-content" >'.wptiger_rightContent().'					
						</div>';
		
		echo $widgetContent;
	} else {
		$widgetContent = "<div style='margin-top:20px;font-weight:bold;'>
				Please enter a valid database <a href=".admin_url()."admin.php?page=wp-tiger&action=plugin_settings>settings</a>
				</div>";
		echo $widgetContent;
	}
}
?>
