<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( ! isset($_GET["fcid"]) || ! ctype_digit($_GET["fcid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q = "select * from food_categories where fcat_id = '".$_GET["fcid"]."'";
	$res = $db->get($q);
	$row = mysqli_fetch_assoc($res);

	$id = $row["fcat_id"];

	$q1 = "delete from menu_items where mitm_cat_id = '".$id."'";
	$db->dml($q1);

	$q2 = "delete from food_categories where fcat_id = '".$_GET["fcid"]."'";
	$db->dml($q2);

	
	
	header("location:category.php");


?>