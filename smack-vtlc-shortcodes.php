<?php
add_filter('widget_text', 'do_shortcode');

add_shortcode('display_contact_page','display_page');

add_shortcode('display_widget_area','display_widget');



function display_page($atts)
{
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
$content = "<form id='contactform' name='contactform' method='post'>";
//$content = "<form id='contactform' name='contactform' method='post' action='".$action."'>";
$content.= "<table>";
// Success message Added by Fredrick Marks
if($_REQUEST['page_contactform'])
{
        extract($_POST);

        foreach($_POST as $field => $value)
        {
                $post_fields[$field]=urlencode($value);
        }
        if(!empty( $config['appkey'] )){
                $post_fields['appKey'] = $config['appkey'];
        }
        foreach($post_fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'&');

        $url = $action;
        $ch  = curl_init ($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);
        if($data) {
                //$content.= $data;   //remove the comment to see the result from vtiger.
                if(preg_match("/$module entry is added to vtiger CRM./",$data)) {
                        $content.= "<tr><td colspan='2' style='text-align:center;color:green;font-size: 1.2em;font-weight: bold;'>Thank you for submitting</td></tr>";
                } else{
                        $content.= "<tr><td colspan='2' style='text-align:center;color:red;font-size: 1.2em;font-weight: bold;'>Submitting Failed</td></tr>";
                }
        }

}// Fredrick Marks Code ends here
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
	$content.="<input type='submit' value='Submit' id='submit' name='submit'></p><span style='font-size:11px;float:right;'>Powered by <a target='_blank' href='http://www.smackcoders.com/pro-wordpress-vtiger-webforms-module.html'>WP-Tiger</a></td></tr></table>";
        $content.="<input type='hidden' value='contactform' name='page_contactform'>";
	$content.="<input type='hidden' value='Leads' name='moduleName' />
</form>";
//return $content;

return $content;
}

function display_widget($atts)
{
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
$content = "<form id='contactform' method='post'>";
$content.= "<table>";
// Success message for widget area -- Code added by Fredrick Marks
if($_REQUEST['widget_contactform'])
{
        extract($_POST);

        foreach($_POST as $field => $value)
        {
                $post_fields[$field]=urlencode($value);
        }
        if(!empty( $config['appkey'] )){
                $post_fields['appKey'] = $config['appkey'];
        }

        foreach($post_fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'&');
        $url = $action;
        $ch  = curl_init ($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);
        if($data) {
                //$content.= $data;   //remove the comment to see the result from vtiger.
                if(preg_match("/$module entry is added to vtiger CRM./",$data)) {
                        $content.= "<tr><td colspan='2' style='text-align:center;color:green;font-size: 1.2em;font-weight: bold;'>Thank you for submitting</td></tr>";
                } else{
                        $content.= "<tr><td colspan='2' style='text-align:center;color:red;font-size: 1.2em;font-weight: bold;'>Submitting Failed</td></tr>";
                }
        }

} // Fredrick Marks Code ends here
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
		$content1.="<input type='text' class='wp-tiger-widget-area-text' size='20' value='' name='".$field->fieldname."' id='".$field->fieldname."'></p>";
		$content1.="</td></tr>";
$content.=$content1;
	}
	$content.="<tr><td></td><td>";
	$content.="<p>";
	$content.="<input type='submit' class='wp-tiger-widget-area-submit' value='Submit' id='submit' name='submit'></p></td></tr>";
	$content.="<tr><td></td><td style='font-size:9px;float:right;'>Powered by <a target='_blank' href='http://www.smackcoders.com/pro-wordpress-vtiger-webforms-module.html'>WP-Tiger</a></td></tr></table>";
	$content.="<input type='hidden' value='contactform' name='widget_contactform'>";
	$content.="<input type='hidden' value='Leads' name='moduleName'/>
</form>";

//echo $content;
return $content;

}
?>
