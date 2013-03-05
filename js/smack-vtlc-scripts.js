function smack_validate_Fields() {
	var no_of_fields = jQuery('#no_of_vt_fields').val();
	for ( var i = 0; i < no_of_fields; i++ ) {
		if( jQuery('#field_type'+i).val() == 'M' && !jQuery('#smack_vtlc_field'+i).is(':checked') ) {
			alert(jQuery('#field_label'+i).val() + ' is mandatory');
			try{
				jQuery('#smack_vtlc_field'+i).focus();
			}catch(e){}
			return false;
		}
	}
	return true;
}

function captureAlreadyRegisteredUsersWpTiger()
{
	document.getElementById('please-upgrade').style.fontSize = "14px";
	document.getElementById('please-upgrade').style.fontFamily = "Sans Serif";
	document.getElementById('please-upgrade').style.color = "red";
	document.getElementById('please-upgrade').innerHTML = "Please Upgrade to WP-Tiger-Pro for Sync feature";
}

function testDatabaseCredentials(siteurl)
{
	var data="";
	data+= "hostname="+jQuery("#hostname").val();
	data+= "&dbuser="+jQuery("#dbuser").val();
	data+= "&dbpass="+jQuery("#dbpass").val();
	data+= "&dbname="+jQuery("#dbname").val();
	data+= "&check=checkdatabase";
	jQuery.ajax({
                url: siteurl+'/wp-content/plugins/wp-tiger/test-access.php',
                type: 'post',
                data: data,
                success: function(response){
       			if(response == 'Success')
			{
				document.getElementById('smack-database-test-results').style.fontWeight = "bold";
				document.getElementById('smack-database-test-results').style.color = "green";
				document.getElementById('smack-database-test-results').innerHTML = "Database connected successfully";
			}
			else
			{
				document.getElementById('smack-database-test-results').style.fontWeight = "bold";
				document.getElementById('smack-database-test-results').style.color = "red";
				document.getElementById('smack-database-test-results').innerHTML = "Database Credentials are wrong";
			}
                }
        });
}

