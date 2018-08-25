<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( empty($_POST) ) { header("location:index.php"); exit; }

	$errors = array();

	if(empty($_POST["fcat_nm"])or !ctype_alpha($_POST["fcat_nm"]))
		$errors[] = "food category name not found properly";
	
	if(!empty($_FILES["fcat_img"]["name"]))
	{
		if($_FILES["fcat_img"]["error"] != 0)
			$errors[] = "Image Uploading Error";
		$ext1 = strtolower(substr($_FILES["fcat_img"]["name"], -4));
		if($ext1 != '.jpg')
			$errors[] = "Image Only .jpg Format";
	}
	else
	{
		$errors[] = "Image Was Empty";
	}

	if(!empty($errors))
	{
		echo '<b>Errors</b><hr>';
		foreach($errors as $e)
		{
			echo $e."<br>";
		}
		exit;
	}
	$img="";

	$img=time()."-".$_FILES["fcat_img"]["name"];

	move_uploaded_file($_FILES["fcat_img"]["tmp_name"], "uploads/".$img);


	require_once("classes/dbo.class.php");
	$q = "insert into food_categories (fcat_rst_id,fcat_nm,fcat_img) values('".$_SESSION["rid"]."','".$_POST["fcat_nm"]."','".$img."')";
	$db->dml($q);

	header("location:category.php");

?>