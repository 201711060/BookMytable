<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( ! isset($_GET["tcid"]) || ! ctype_digit($_GET["tcid"]) ) { header("location:index.php"); exit; }

	require_once("classes/dbo.class.php");
	$q = "select * from table_bookings where tbk_id = '".$_GET["tcid"]."'";
	$res = $db->get($q);
	$row = mysqli_fetch_assoc($res);

	$id = $row["tbk_id"];

	$q1 = "delete from table_booking_items where tbi_tbk_id = '".$id."'";
	$db->dml($q1);

	$q2 = "delete from table_bookings where tbk_id = '".$_GET["tcid"]."'";
	$db->dml($q2);
	
	header("location:table_booking.php");


?>