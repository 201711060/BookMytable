<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	if( empty($_POST) ) { header("location:index.php"); exit; }

	$errors = array();

	if(empty($_POST["title"]))
		$errors[] = "Title Was Empty";
	if(empty($_POST["desc"]))
		$errors[] = "Description Was Empty";
	if(!empty($_FILES["mitm_img1"]["name"]))
	{
		if($_FILES["mitm_img1"]["error"] != 0)
			$errors[] = "Image1 Uploading Error";
		$ext1 = strtolower(substr($_FILES["mitm_img1"]["name"], -4));
		if($ext1 != '.jpg')
			$errors[] = "Image1 Only .jpg Format";
	}
	else
	{
		$errors[] = "Image1 Was Empty";
	}
	if(!empty($_FILES["mitm_img2"]["name"]))
	{
		if($_FILES["mitm_img2"]["error"] != 0)
			$errors[] = "Image2 Uploading Error";
		$ext2 = strtolower(substr($_FILES["mitm_img2"]["name"], -4));
		if($ext2 != '.jpg')
			$errors[] = "Image2 Only .jpg Format";
	}
	else
	{
		$errors[] = "Image2 Was Empty";
	}
	if(empty($_POST["rate"]))
		$errors[] = "Rate Was Empty";
	elseif (!ctype_digit($_POST["rate"]))  
		$errors[] = "Rate Must Be in Digits";

	if(!empty($errors))
	{
		echo '<b>Errors</b><hr>';
		foreach($errors as $e)
		{
			echo $e."<br>";
		}
		exit;
	}

	$img1 = "";
	$img2 = "";
	

	$img1 = time()."-".$_FILES["mitm_img1"]["name"];
	$img2 = time()."-".$_FILES["mitm_img2"]["name"];
	

	move_uploaded_file($_FILES["mitm_img1"]["tmp_name"], "uploads/".$img1);
	move_uploaded_file($_FILES["mitm_img2"]["tmp_name"], "uploads/".$img2);
	

	require_once("classes/dbo.class.php");
	$q = "insert into menu_items (mitm_rst_id ,mitm_cat_id , mitm_title ,mitm_desc ,mitm_rate ,mitm_img1 ,mitm_img2 ,mitm_is_spicy ,mitm_is_jain ) values('".$_SESSION["rid"]."','".$_POST["cat"]."','".$_POST["title"]."','".$_POST["desc"]."','".$_POST["rate"]."','".$img1."','".$img2."','".$_POST["spicy"]."','".$_POST["jain"]."')";
	$db->dml($q);

	header("location:menu_items.php");

?>