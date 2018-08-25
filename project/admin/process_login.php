<?php
	session_start();
	if(empty($_POST))
	{
		header("location:index.php");exit;
	}
	$errors = array();

	if(empty($_POST["nm"]))
		$errors[] = "Name Was Empty";
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
	$q = "select * from admins where  ad_nm= '".$_POST["nm"]."' and ad_pwd = '".$_POST["pwd"]."'";
	$res = $db->get($q);

	if(mysqli_num_rows($res) != 0)
	{
		$row = mysqli_fetch_assoc($res);
		$_SESSION["aid"] = $row["ad_id"];
		$_SESSION["anm"] = $row["ad_nm"];

		header("location:index.php");
		exit;
	}
	else
	{
		echo "Invalid Email Or Password";
	}
?>