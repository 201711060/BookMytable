<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( ! isset($_GET["tcid"]) || ! ctype_digit($_GET["tcid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q = "delete from tables where tbl_id = '".$_GET["tcid"]."'";
	$db->dml($q);
	
	header("location:tables.php");


?>