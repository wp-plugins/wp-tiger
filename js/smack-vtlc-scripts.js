function smack_validateFields() {
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
