<?php
	
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( empty($_POST) ) { header("location:index.php"); exit; }

	$errors = array();

	if(empty($_POST["tbl_nm"]))
		$errors[] = "table name not found";

	if(!empty($errors))
	{
		echo '<b>Errors</b><hr>';
		foreach($errors as $e)
		{
			echo $e."<br>";
		}
		exit;
	}

	
	require_once("classes/dbo.class.php");
	$q = "insert into tables (tbl_rst_id,tbl_nm) values('".$_SESSION["rid"]."','".$_POST["tbl_nm"]."')";
	$db->dml($q);

	header("location:tables.php");

?>