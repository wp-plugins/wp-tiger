<?php


add_filter('widget_text', 'do_shortcode');

add_shortcode('display_contact_page','display_page');

add_shortcode('display_widget_area','display_widget');



function display_page($atts)
{
if(isset($_GET['result']))
{
	if($_GET['result']=="success")
	{
		echo "<h3>Your contact Successfully added</h3>";
	}
	elseif($_GET['result']=="failure")
	{
		echo "<h3>Error in adding your contact</h3>";
	}
}

$config = get_option("smack_vtlc_settings");
$config_field = get_option("smack_vtlc_field_settings");
$config_widget_field = get_option("smack_vtlc_widget_field_settings");
if(!empty($config['hostname']) && !empty($config['dbuser'])){
	if( !empty($config_field['fieldlist']) && is_array($config_field['fieldlist']) ){
		$field_list = implode(',', $config_field['fieldlist']);
	}
	$dbvalues = new wpdb($config['dbuser'], $config['dbpass'], $config['dbname'], $config['hostname']);
	$selectedFields = $dbvalues->get_results("SELECT fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 AND fieldid in ({$field_list}) ORDER BY block, sequence");
	
}

$action=trim($config['url'], "/").'/modules/Webforms/post.php';
$content = "<form id='contactform' method='post' action='".$action."'>";
$content.= "<table>";
	if( is_array( $config_field['fieldlist'] ) ) foreach ($selectedFields as $field) {

		$content1="<p>";
		$content1.="<tr>";
		$content1.="<td>";
		$content1.="<label for='".$field->fieldname."'>".$field->fieldlabel."</label>";
		$typeofdata = explode('~', $field->typeofdata);
		if( $typeofdata[1] == 'M' ){
		$content1.="<span  style='color:red;'>*</span>";
		}
		$content1.="</td><td>";
		$content1.="<input type='hidden' value='".$typeofdata[1]."' id='".$field->fieldname."_type'>";
		$content1.="<input type='text' size='30' value='' name='".$field->fieldname."' id='".$field->fieldname."'></p>";
		$content1.="</td></tr>";

$content.=$content1;
	}
	$content.="<tr><td></td><td>";
	$content.="<p>";
	$content.="<input type='submit' value='Submit' id='submit' name='submit'></p>";
	if(!empty( $config['appkey'] )){
	$content.="<input type='hidden' value='".$config['appkey']."' name='appKey' />";
	}
	$content.="</td></tr></table>";
	$content.="<input type='hidden' value='Leads' name='moduleName' />
</form>";
echo $content;
}

function display_widget($atts)
{
if(isset($_GET['result']))
{
	if($_GET['result']=="success")
	{
		echo "<h3>Your contact Successfully added</h3>";
	}
	elseif($_GET['result']=="failure")
	{
		echo "<h3>Error in adding your contact</h3>";
	}
}
$config = get_option("smack_vtlc_settings");
$config_field = get_option("smack_vtlc_field_settings");
$config_widget_field = get_option("smack_vtlc_widget_field_settings");
if(!empty($config['hostname']) && !empty($config['dbuser'])){
	if( !empty($config_widget_field['widgetfieldlist']) && is_array($config_widget_field['widgetfieldlist']) ){
		$field_list = implode(',', $config_widget_field['widgetfieldlist']);
	}
	$dbvalues = new wpdb($config['dbuser'], $config['dbpass'], $config['dbname'], $config['hostname']);
	$selectedFields = $dbvalues->get_results("SELECT fieldname, fieldlabel, typeofdata FROM vtiger_field WHERE tabid = 7 AND tablename != 'vtiger_crmentity' AND uitype != 4 AND fieldid in ({$field_list}) ORDER BY block, sequence");
	
}

$action=trim($config['url'], "/").'/modules/Webforms/post.php';
$content = "<form id='contactform' method='post' action='".$action."'>";
$content.= "<table>";
	if( is_array( $config_widget_field['widgetfieldlist'] ) ) foreach ($selectedFields as $field) {

		$content1="<p >";
		$content1.="<tr>";
		$content1.="<td>";
		$content1.="<label for='".$field->fieldname."'>".$field->fieldlabel."</label>";
		$typeofdata = explode('~', $field->typeofdata);
		if( $typeofdata[1] == 'M' ){
		$content1.="<span style='color:red;'>*</span>";
		}
		$content1.="</td><td>";
		$content1.="<input type='hidden' value='".$typeofdata[1]."' id='".$field->fieldname."_type'>";
		$content1.="<input type='text' style=' border: 1px solid #CCCCCC; background-color: #FFFFFF; color: #000000; font: 10px verdana,sans-serif;padding: 3px 5px; width: 176px;' size='20' value='' name='".$field->fieldname."' id='".$field->fieldname."'></p>";
		$content1.="</td></tr>";

$content.=$content1;
	}
	$content.="<tr><td></td><td>";
	$content.="<p>";
	$content.="<input type='submit' style='background: none repeat scroll 0 0 #E3E3DB; border-color: #FFFFFF #D8D8D0 #D8D8D0 #FFFFFF; border-style: solid; border-width: 2px; color: #000000; font-family: Arial,Helvetica,sans-serif; font-size: 10px; font-weight: bold; margin-left: 0; text-decoration: none; text-transform: uppercase;' value='Submit' id='submit' name='submit'></p>";
	if(!empty( $config['appkey'] )){
	$content.="<input type='hidden' value='".$config['appkey']."' name='appKey' />";
	}
	$content.="</td></tr></table>";
	$content.="<input type='hidden' value='Leads' name='moduleName' />
</form>";

echo $content;
}
?>
