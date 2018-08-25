<?php
	
	if( empty($_POST) ) { header("location:index.php"); exit; }

	$errors = array();

	if(empty($_POST["rst_nm"]))
		$errors[] = "Name Was Empty";
	if(empty($_POST["rst_pwd"]))
		$errors[] = "Password Was Empty";
	if(empty($_POST["rst_email"]))
		$errors[] = "Email Was Empty";
	elseif (!filter_var($_POST["rst_email"],FILTER_VALIDATE_EMAIL)) 
		$errors[] = "Enter Proper Email";
	if(empty($_POST["rst_phn1"]))
		$errors[] = "Phone1 Was Empty";
	elseif (strlen($_POST["rst_phn1"]) != 10 or !ctype_digit($_POST["rst_phn1"])) 
		$errors[] = "Phone1 Must Be 10 Digits";
	if(empty($_POST["rst_phn2"]))
		$errors[] = "Phone2 Was Empty";
	elseif (strlen($_POST["rst_phn2"]) != 10 or !ctype_digit($_POST["rst_phn2"])) 
		$errors[] = "Phone2 Must Be 10 Digits";
	if(empty($_POST["rst_addr"]))
		$errors[] = "Address Was Empty";
	if(empty($_POST["rst_desc"]))
		$errors[] = "Description Was Empty";
	if(!empty($_FILES["rst_img1"]["name"]))
	{
		if($_FILES["rst_img1"]["error"] != 0)
			$errors[] = "Image1 Uploading Error";
		$ext1 = strtolower(substr($_FILES["rst_img1"]["name"], -4));
		if($ext1 != '.jpg')
			$errors[] = "Image1 Only .jpg Format";
	}
	else
	{
		$errors[] = "Image1 Was Empty";
	}

	if(!empty($_FILES["rst_img2"]["name"]))
	{
		if($_FILES["rst_img2"]["error"] != 0)
			$errors[] = "Image2 Uploading Error";
		$ext2 = strtolower(substr($_FILES["rst_img2"]["name"], -4));
		if($ext2 != '.jpg')
			$errors[] = "Image2 Only .jpg Format";
	}
	else
	{
		$errors[] = "Image2 Was Empty";
	}

	if(!empty($_FILES["rst_img3"]["name"]))
	{
		if($_FILES["rst_img3"]["error"] != 0)
			$errors[] = "Image3 Uploading Error";
		$ext3 = strtolower(substr($_FILES["rst_img3"]["name"], -4));
		if($ext3 != '.jpg')
			$errors[] = "Image3 Only .jpg Format";
	}
	else
	{
		$errors[] = "Image3 Was Empty";
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

	$img1 = "";
	$img2 = "";
	$img3 = "";

	$img1 = time()."-".$_FILES["rst_img1"]["name"];
	$img2 = time()."-".$_FILES["rst_img2"]["name"];
	$img3 = time()."-".$_FILES["rst_img3"]["name"];

	move_uploaded_file($_FILES["rst_img1"]["tmp_name"], "uploads/".$img1);
	move_uploaded_file($_FILES["rst_img2"]["tmp_name"], "uploads/".$img2);
	move_uploaded_file($_FILES["rst_img3"]["tmp_name"], "uploads/".$img3);


	require_once("classes/dbo.class.php");
	$q = "insert into restaurants (rst_nm,rst_pwd,rst_email,rst_phn1,rst_phn2,rst_addr,rst_desc,rst_img1,rst_img2,rst_img3) values('".$_POST["rst_nm"]."','".$_POST["rst_pwd"]."','".$_POST["rst_email"]."','".$_POST["rst_phn1"]."','".$_POST["rst_phn2"]."','".$_POST["rst_addr"]."','".$_POST["rst_desc"]."','".$img1."','".$img2."','".$img3."')";
	$db->dml($q);

	header("location:register.php");

?>