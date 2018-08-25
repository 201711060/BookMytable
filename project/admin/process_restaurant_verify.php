<?php
	
	session_start();

	if( ! isset($_GET["rid"]) || ! ctype_digit($_GET["rid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q = "update restaurants set rst_is_verified = 1 where rst_id = '".$_GET["rid"]."'";
	$db->dml($q);
	
	header("location: restaurant_verify.php");


?>