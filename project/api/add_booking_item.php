<?php
	
	$errors = array();

	if( ! isset($_GET["tbk_id"]) || empty($_GET["tbk_id"]) )
		$errors[] = "Table Booking ID was empty.";

	if( ! isset($_GET["mitm_id"]) || empty($_GET["mitm_id"]) )
		$errors[] = "Menu Item ID was empty.";

	if( ! isset($_GET["mitm_qty"]) || empty($_GET["mitm_qty"]) )
		$errors[] = "Menu Item Qty was empty.";

	if( ! ctype_digit($_GET["mitm_qty"]))
		$errors[] = "Menu Item Qty must be digits only.";

	if( ! empty($errors)) {
		
		$output["status"] = "error";
		$output["message"] = $errors;
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$q = "insert into table_booking_items(tbi_tbk_id, tbi_mitm_id, tbi_mitm_qty) values ('".$_GET["tbk_id"]."','".$_GET["mitm_id"]."','".$_GET["mitm_qty"]."')";

	$db->dml($q);

	$output["status"] = "success";
	$output["message"] = "";
	$output["data"] = "";

	die( json_encode($output) );
?>