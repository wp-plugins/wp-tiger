function smack_validate_Fields() {
	var no_of_fields = jQuery('#no_of_vt_fields').val();
	for ( var i = 0; i < no_of_fields; i++) {
		if (jQuery('#field_type' + i).val() == 'M'
				&& !jQuery('#smack_vtlc_field' + i).is(':checked')) {
			alert(jQuery('#field_label' + i).val() + ' is mandatory');
			try {
				jQuery('#smack_vtlc_field' + i).focus();
			} catch (e) {
			}
			return false;
		}
	}
	return true;
}

function captureAlreadyRegisteredUsersWpTiger() {
	document.getElementById('please-upgrade').style.fontSize = "14px";
	document.getElementById('please-upgrade').style.fontFamily = "Sans Serif";
	document.getElementById('please-upgrade').style.color = "red";
	document.getElementById('please-upgrade').innerHTML = "Please Upgrade to WP-Tiger-Pro for Sync feature";
}

function testDatabaseCredentials(siteurl) {
	var data = "";
	data += "hostname=" + jQuery("#hostname").val();
	data += "&dbuser=" + jQuery("#dbuser").val();
	data += "&dbpass=" + jQuery("#dbpass").val();
	data += "&dbname=" + jQuery("#dbname").val();
	data += "&check=checkdatabase";
	jQuery
			.ajax({
				url : siteurl + '/wp-content/plugins/wp-tiger/test-access.php',
				type : 'post',
				data : data,
				success : function(response) {
					if (response == 'Success') {
						document.getElementById('smack-database-test-results').style.fontWeight = "bold";
						document.getElementById('smack-database-test-results').style.color = "green";
						document.getElementById('smack-database-test-results').innerHTML = "Database connected successfully";
					} else {
						document.getElementById('smack-database-test-results').style.fontWeight = "bold";
						document.getElementById('smack-database-test-results').style.color = "red";
						document.getElementById('smack-database-test-results').innerHTML = "Database Credentials are wrong";
					}
				}
			});
}

function upgradetopro() {
	window.setTimeout("showmessage()", 100);
	window.setTimeout("hidemessage()", 5000);
}

function move(val) {
	window.setTimeout("showmessage()", 100);
	window.setTimeout("hidemessage()", 5000);
}

function showmessage() {
	document.getElementById('upgradetopro').style.display = "";
}

function hidemessage() {
	document.getElementById('upgradetopro').style.display = "none";
	document.getElementById('skipduplicate').checked = false;
	document.getElementById('generateshortcode').checked = false;
}

function select_allfields(formid, module) {
	var i;
	var data = "";
	var form = document.getElementById(formid);
	var chkall = form.elements['selectall'];
	var chkBx_count = form.elements['no_of_vt_fields'].value;
	if (chkall.checked == true) {
		for (i = 0; i < chkBx_count; i++) {
			if (document.getElementById('smack_vtlc_field' + i).disabled == false)
				document.getElementById('smack_vtlc_field' + i).checked = true;
		}
	} else {
		for (i = 0; i < chkBx_count; i++) {
			if (document.getElementById('smack_vtlc_field' + i).disabled == false)
				document.getElementById('smack_vtlc_field' + i).checked = false;
		}
	}
}

function saveSettings(){
        window.setTimeout("showSuccessMessage()", 100);
        window.setTimeout("hideSuccessMessage()", 10000);
}

function showSuccessMessage(){
        document.getElementById('message-box').style.display = '';
}

function hideSuccessMessage(){
        document.getElementById('message-box').style.display = 'none';
}

