<?php
	session_start();

	if(!isset($_SESSION["aid"]))
	{
		header("location:login.php");
		exit;
	}

	unset($_SESSION["aid"]);
	unset($_SESSION["anm"]);

	header("location:index.php");
?>