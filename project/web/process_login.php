<?php
	session_start();
	if(empty($_POST))
	{
		header("location:index.php");exit;
	}
	$errors = array();

	if(empty($_POST["email"]))
		$errors[] = "Email Was Empty";
	if(empty($_POST["pwd"]))
		$errors[] = "Password Was Empty";

	if(!empty($errors))
	{
		echo '<b>Errors</b><hr>';
		foreach ($errors as $e) {
			echo $e."<br>";
		}
		exit;
	}

	require_once("classes/dbo.class.php");
	$q = "select * from restaurants where rst_email = '".$_POST["email"]."' and rst_pwd = '".$_POST["pwd"]."' and rst_is_verified = 1";
	$res = $db->get($q);

	if(mysqli_num_rows($res) != 0)
	{
		$row = mysqli_fetch_assoc($res);
		$_SESSION["rid"] = $row["rst_id"];
		$_SESSION["rnm"] = $row["rst_nm"];

		header("location:index.php");
		exit;
	}
	else
	{
		echo "Invalid Email Or Password";
	}
?>