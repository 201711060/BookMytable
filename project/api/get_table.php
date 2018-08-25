<?php

	$output = array();

	if( ! isset($_GET["rst_id"]) || ! ctype_digit($_GET["rst_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "TID not received / not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}

	require_once("../admin/classes/dbo.class.php");

	$q = "select * from tables where tbl_rst_id = '".$_GET["rst_id"]."' order by tbl_nm";
	$res = $db->get($q);

	if(mysqli_num_rows($res) == 0)
	{
		$output["status"] = "success";
		$output["message"] = "No Table Found";
		$output["data"] = array();

		die( json_encode($output) );
	}

	$output["status"] = "success";
	$output["message"] = "";
	$output["data"] = array();

	while($row = mysqli_fetch_assoc($res)) {

		$output["data"][] = array(
			"tblid" => $row["tbl_id"],
			"tblnm" => $row["tbl_nm"]
		);

	}

	echo json_encode($output);

?>