<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	
	if( empty($_POST) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q = "update restaurants set rst_nm='".$_POST["rst_nm"]."', rst_pwd='".$_POST["rst_pwd"]."',rst_email='".$_POST["rst_email"]."',rst_phn1='".$_POST["rst_phn1"]."',rst_phn2='".$_POST["rst_phn2"]."',rst_addr='".$_POST["rst_addr"]."',rst_desc='".$_POST["rst_desc"]."' where rst_id='".$_SESSION["rid"]."' ";
	$db->dml($q);

	header("location:view_profile.php");

?>