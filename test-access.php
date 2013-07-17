<?php
if (isset ( $_REQUEST ['check'] ) && $_REQUEST ['check'] == "checkdatabase") {
	require_once (getcwd () . '/../../../wp-load.php');
	$mydb = new wpdb ( $_REQUEST ['dbuser'], $_REQUEST ['dbpass'], $_REQUEST ['dbname'], $_REQUEST ['hostname'] );
	$rows = $mydb->get_results ( "select * from vtiger_users" ); // This vtiger's user table used only for test purpose
	if (isset ( $rows ))
		echo "Success";
	else
		echo "Failed";
}
?>