<?php

	session_start();

	if( ! isset($_GET["rid"]) || ! ctype_digit($_GET["rid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q1 = "delete from food_categories where fcat_rst_id = '".$_GET["rid"]."'";
	$db->dml($q1);

	$q2 = "delete from menu_items where mitm_rst_id = '".$_GET["rid"]."'";
	$db->dml($q2);

	$q3 ="delete from table_booking_items where tbi_tbk_id in ( select tbk_id from table_bookings where tbk_tbl_id in ( select tbl_id from tables where tbl_rst_id = '".$_GET["rid"]."' )  )";
	$db->dml($q3);

	$q4 ="delete from table_bookings where tbk_tbl_id in ( select tbl_id from tables where tbl_rst_id = '".$_GET["rid"]."'  )";
	$db->dml($q4);

	$q5 = "delete from tables where tbl_rst_id = '".$_GET["rid"]."'";
	$db->dml($q5);

	$q6 = "delete from restaurants where rst_id = '".$_GET["rid"]."'";
	$db->dml($q6);
	
	header("location: restaurant_verify.php");


?>