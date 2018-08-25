<?php
	
	$errors = array();

	if( ! isset($_GET["tbl_id"]) || empty($_GET["tbl_id"]) )
		$errors[] = "Table ID was empty.";
	if( ! isset($_GET["date"]) || empty($_GET["date"]) )
		$errors[] = "Date was empty.";
	if( ! isset($_GET["slot"]) || empty($_GET["slot"]) )
		$errors[] = "Slot was empty.";
	if( ! isset($_GET["nm"]) || empty($_GET["nm"]) )
		$errors[] = "Name was empty.";
	if( ! isset($_GET["phn"]) || empty($_GET["phn"]) )
		$errors[] = "Phone was empty.";
	if( ! isset($_GET["members"]) || empty($_GET["members"]) )
		$errors[] = "Members was empty.";

	if( ! empty($errors)) {
		
		$output["status"] = "error";
		$output["message"] = $errors;
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$q = "insert into table_bookings(tbk_tbl_id, tbk_date, tbk_time_slot, tbk_nm, tbk_phn, tbk_members) values ('".$_GET["tbl_id"]."','".$_GET["date"]."','".$_GET["slot"]."','".$_GET["nm"]."','".$_GET["phn"]."','".$_GET["members"]."')";

	$db->dml($q);

	$output["status"] = "success";
	$output["message"] = "";
	$output["data"] = array();

	die( json_encode($output) );
?>