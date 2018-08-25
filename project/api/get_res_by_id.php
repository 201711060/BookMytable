<?php
	
	$output = array();

	if( ! isset($_GET["rst_id"]) || ! ctype_digit($_GET["rst_id"])) {
		
		$output["status"] = "error";
		$output["message"] = "IID not received not proper.";
		$output["data"] = array();

		die( json_encode($output) );
	}
	require_once("../admin/classes/dbo.class.php");

	$q = "select * from restaurants where rst_id='".$_GET["rst_id"]."'";
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

	$uploads_path = "http://www.aisomex.net/trainee_projects/table_booking/web/uploads/";
	$row = mysqli_fetch_assoc($res);

	$output["data"] = array(
			"rstID" => $row["rst_id"],
			"rstname" => $row["rst_nm"],
			"rstpwd" => $row["rst_pwd"],
			"rstemail" => $row["rst_email"],
			"rstphn1" => $row["rst_phn1"],
			"rstphn2" => $row["rst_phn2"],
			"rstaddr" => $row["rst_addr"],
			"rstdesc" => $row["rst_desc"],
			"rstimg1" => $uploads_path.$row["rst_img1"],
			"rstimg2" => $uploads_path.$row["rst_img2"],
			"rstimg3" => $uploads_path.$row["rst_img3"],
		);


	

	echo json_encode($output);

?>