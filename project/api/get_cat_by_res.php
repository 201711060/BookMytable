<?php

	$output = array();

	if( ! isset($_GET["rst_id"]) || ! ctype_digit($_GET["rst_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "CID not received / not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$q = "select * from  food_categories where fcat_rst_id ='".$_GET["rst_id"]."'";
	$res = $db->get($q);

	if( mysqli_num_rows($res) == 0 ) {

		$output["status"] = "success";
		$output["message"] = "No records found!";
		$output["data"] = array();

		die( json_encode($output) );

	}

	$output["status"] = "success";
	$output["message"] = "";
	$output["data"] = array();

	$uploads_path = "http://www.aisomex.net/trainee_projects/table_booking/web/uploads/";

	while($row = mysqli_fetch_assoc($res)) {

		$output["data"][] = array(
			"fcatid" => $row["fcat_id"],
			"fcatrstid" => $row["fcat_rst_id"],
			"fcatnm" => $row["fcat_nm"],
			"fcatimg" => $uploads_path.$row["fcat_img"]
		);

	}

	echo json_encode($output);

?>