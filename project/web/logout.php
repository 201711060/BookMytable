<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	unset($_SESSION["rid"]);
	unset($_SESSION["rnm"]);

	header("location:index.php");
?>