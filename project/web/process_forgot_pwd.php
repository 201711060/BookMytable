<?php
	session_start();
	require_once("classes/dbo.class.php");

	if(empty($_POST["email"]))
	{
		header("location:forgot_pwd.php");
		exit;
	}

	$q = "select * from restaurants where rst_email = '".$_POST["email"]."'";
	$res = $db->get($q);
	$row = mysqli_fetch_assoc($res);

	if(mysqli_num_rows($res) == 0)
	{
		echo "Restaurants Not Registered";
		exit;
	}

	require_once("classes/class.phpmailer.php");
	send_email($_POST["email"],"Password","Password : ".$row["rst_pwd"]);
	
	header("location:login.php");
?>