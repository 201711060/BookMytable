<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( ! isset($_GET["miid"]) || ! ctype_digit($_GET["miid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	
	$q = "delete from menu_items where mitm_id='".$_GET["miid"]."'";
	$db->dml($q);
	
	header("location:menu_items.php");


?>