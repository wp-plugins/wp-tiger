<?php

function wptiger_listShortcodes(){
?>
	<div class="upgradetopro" id="upgradetopro" style="display:none;">This feature is only available in Pro Version, Please <a href="http://www.smackcoders.com/wp-vtiger-pro.html">UPGRADE TO PRO</a></div>
        <table>
                <tr>
                        <h2>List of Shortcodes</h2>
                </tr>
                <tr class='smack_alt'>
                        <th class='list-view-th' style='width: 50px;'>#</th>
                        <th class='list-view-th' style='width: 450px;'>Shortcodes</th>
                        <th class='list-view-th' style='width: 90px;'>VT Module</th>
                        <th class='list-view-th' style='width: 150px;'>Assigned To</th>
                        <th class='list-view-th' style='width: 90px;'>IsWidget</th>
                        <th class='list-view-th' style='width: 150px;'>Action</th>
                </tr>
		<tr class='smack_highlight'>
		<td style='text-align:center;'>1</td>
                <td style='text-align:center;'>[wp-tiger-pro-form name="4YTcK"]</td>
                <td style='text-align:center;'>Contacts</td>
		<td style='text-align:center;'>Administrator</td>
		<td style='text-align:center;'>Yes</td>
                <td style='text-align:center;'>
                <select id='shortcode' name='shortcode' onchange='upgradetopro()'>
                <option value='Select Action'>Select Action</option>
                <option value='edit'>Edit</option>
                <option value='delete'>Delete</option>
                </select>
                </td>
                </tr>
		<tr class='smack_highlight smack_alt'>
		<td style='text-align:center;'>2</td>
                <td style='text-align:center;'>[wp-tiger-pro-form name="SX8ru"]</td>
                <td style='text-align:center;'>Leads</td>
		<td style='text-align:center;'>Administrator</td>
		<td style='text-align:center;'>No</td>
                <td style='text-align:center;'>
                <select id='shortcode' name='shortcode' onchange='upgradetopro()'>
                <option value='Select Action'>Select Action</option>
                <option value='edit'>Edit</option>
                <option value='delete'>Delete</option>
                </select>
                </td>
                </tr>
        	</table>

<?php
}

function capture_wp_users(){ ?>
<div class="upgradetopro" id="upgradetopro" style="display:none;">This feature is only available in Pro Version, Please <a href="http://www.smackcoders.com/wp-vtiger-pro.html">UPGRADE TO PRO</a></div>
<div style="width:90%;margin-top:15px;">
<div style="float:left">
<form id="smack-vtiger-user-capture-settings-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="smack-vtiger-user-capture-settings-form" value="smack-vtiger-user-capture-settings-form" />
<h3>Capture WordPress users</h3>
<table>
        <tr>
                <td><br/>
                        <label><div style='float:left;padding-right: 5px;'>Sync New Registration to VT Contacts </div> <div style='float:right;'>:</div> </label>
                </td>
                <td><br/>
                        <input type='checkbox' class='smack-vtiger-settings-user-capture' name='smack_user_capture' id='smack_user_capture' 
<?php
if($config['smack_user_capture']=='on')
{
        echo "checked";
}
?>
>
                </td>
        </tr>
        <tr>
                <td>
                        <label><div style='float:left;padding-right: 5px;'>Skip Duplicates</div><div style='float:right;'>:</div> </label>
                </td>
                <td>
                        <input type='checkbox' class='smack-vtiger-settings-capture-duplicates' name='smack_capture_duplicates' id='smack_capture_duplicates' 
<?php
if($config['smack_capture_duplicates']=='on')
{
        echo "checked";
}
$contentUrl = WP_CONTENT_URL;
$imagepath = $contentUrl.'/plugins/wp-tiger/images/'; 
?>
>
                </td>
        </tr>

</table>
<table>
        <tr>
                <td>
                        <input type="hidden" name="posted" value="<?php echo 'posted';?>">
                        <p class="submit">
                                <input type="button" value="<?php _e('Save Settings');?>" class="button-primary" onclick="upgradetopro();"/>
                        </p>
                </td>
                <td>
                <input type="button" style="float:left;" value="<?php _e('Sync Now');?>" class="button-secondary submit-add-to-menu" onclick="upgradetopro();"/>
                <img style="display:none; float:left; padding-top:5px; padding-left:5px;" id="loading-image" src="<?php echo $imagepath.'loading-indicator.gif';?>" />
                </td>

        </tr>
</table>
</form>
</div>
<div style="float:right;">
<p><h3>How to sync wp users and registrations as Contacts WP Tiger Pro?</h3></p>
<iframe width="560" height="315" src="//www.youtube.com/embed/pEeL8sKgSv0?list=PL2k3Ck1bFtbR7d8nRq-oc5iMDBm2ITWuX" frameborder="0" allowfullscreen></iframe>
</div>
</div>
<?php
}

?>
