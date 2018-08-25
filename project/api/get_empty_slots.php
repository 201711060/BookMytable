<?php
	
	$output = array();

	if( ! isset($_GET["tbl_id"]) || ! ctype_digit($_GET["tbl_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "Table ID not received / not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}

	if( ! isset($_GET["date"])) {
		
		$output["status"] = "error";
		$output["message"] = "Date not received / not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$slots = array("06:00 PM", "06:30 PM", "07:00 PM", "07:30 PM", "08:00 PM", "08:30 PM", "09:00 PM", "09:30 PM", "10:00 PM");

	$q = "select tbk_time_slot from table_bookings where tbk_tbl_id='".$_GET["tbl_id"]."' and tbk_date = '".$_GET["date"]."'";
	$res = $db->get($q);
	

	while($row = mysqli_fetch_assoc($res)) {

		if(in_array($row["tbk_time_slot"], $slots)) {
			$idx = array_search($row["tbk_time_slot"], $slots);
			unset($slots[$idx]);
		}
		
	}

	if( ! empty($slots)) {

		$output["status"] = "success";
		$output["message"] = "";
		$output["data"] = array_values($slots);

	} else {

		$output["status"] = "error";
		$output["message"] = "Sorry! All slots are booked.";
		$output["data"] = array();

	}

	die( json_encode($output) );

?>