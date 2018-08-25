<?php

	$output = array();

	if( ! isset($_GET["cat_id"]) || ! ctype_digit($_GET["cat_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "CID not received / not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$q = "select * from menu_items, restaurants, food_categories where mitm_rst_id = rst_id and mitm_cat_id = fcat_id and mitm_cat_id ='".$_GET["cat_id"]."'";
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
			"rstid" => $row["rst_id"],
			"rstnm" => $row["rst_nm"],
			"fcatid" => $row["fcat_id"],
			"fcatnm" => $row["fcat_nm"],
			"mitmid" => $row["mitm_id"],
			"mitmtitle" => $row["mitm_title"],
			"mitmdesc" => $row["mitm_desc"],
			"mitmimg1" => $uploads_path.$row["mitm_img1"],
			"mitmimg2" => $uploads_path.$row["mitm_img2"],
			"mitmrate" => $row["mitm_rate"],
			"mitmisspicy" => $row["mitm_is_spicy"],
			"mitmisjain" => $row["mitm_is_jain"]
		);

	}

	echo json_encode($output);

?>