<?php
	
	$output = array();

	if( ! isset($_GET["tbk_id"]) || ! ctype_digit($_GET["tbk_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "Booking ID not received not proper.";
		$output["data"] = array();

		die( json_encode($output) );

	}
	require_once("../admin/classes/dbo.class.php");

	$q = "select * from table_bookings, tables, restaurants where tbk_tbl_id = tbl_id and tbl_rst_id = rst_id and tbk_id ='".$_GET["tbk_id"]."'";
	$res = $db->get($q);

	if( mysqli_num_rows($res) == 0 ) {	

		$output["status"] = "success";
		$output["message"] = "No record found!";
		$output["data"] = array();

		die( json_encode($output) );

	}

	$output["status"] = "success";
	$output["message"] = "";
	$output["data"] = array();

	$row = mysqli_fetch_assoc($res);

	$output["data"] = $row;
	$output["data"]["booking_items"] = array();

	$q = "select * from table_booking_items, menu_items where tbi_mitm_id = mitm_id and tbi_tbk_id = '".$_GET["tbk_id"]."'";
	$res = $db->get($q);

	while($row = mysqli_fetch_assoc($res)) {
		$output["data"]["booking_items"][] = $row;
	}

	echo json_encode($output);

?>