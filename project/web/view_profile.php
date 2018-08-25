<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	
	require_once("classes/dbo.class.php");
	$vq = "select * from restaurants where rst_id='".$_SESSION["rid"]."'";
	$vres = $db->get($vq);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once("include/head.inc.php"); ?>
</head>
<body>
<div id="menu-wrapper">
	<div id="menu">
		<?php require_once("include/menu.inc.php"); ?>
	</div>
</div>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<?php require_once("include/logo.inc.php"); ?>
		</div>
	</div>
</div>
<div id="wrapper">
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
					<div class="post">
						<h2 class="title"><a href="#">Profile </a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<div class="left">
								<form method="post" action="" >
									<table  width="100%" bgcolor="#f1f1f1" cellpadding="10">
										<?php
											while ($vrow = mysqli_fetch_assoc($vres)) {
												echo'
													<tr>
														<td><b>Name </b></td>
														<td colspan="3">: '.$vrow["rst_nm"].'</td> 
													</tr>
													<tr>
														<td><b>Password </b></td>
														<td colspan="3">: '.$vrow["rst_pwd"].'</td> 
													</tr>
													<tr>
														<td><b>Email </b></td>
														<td colspan="3">: '.$vrow["rst_email"].'</td>
													</tr>
													<tr>
														<td><b>Phone1 </b></td>
														<td colspan="3">: '.$vrow["rst_phn1"].'</td>
													</tr>
													<tr>
														<td><b>Phone2</b></td> 
														<td colspan="3">: '.$vrow["rst_phn2"].'</td>
													</tr>
													
												';
											

										?>									
									</table>
							</div>
							<div class="right">
								<table width="100%" border="0" bgcolor="#f1f1f1" cellpadding="10" >
									<?php
												echo'
													<tr>
														<td><b>Desc </b></td>
														<td colspan="3">: '.$vrow["rst_desc"].'</td>
													</tr>
													<tr>
														<td><b>Address </b></td>
														<td colspan="3">: '.$vrow["rst_addr"].'</td> 
													</tr>
													
													<tr>
														<td><b>Images </b></td>
														<td><img src="../web/uploads/'.$vrow["rst_img1"].'" height="50" width="50" /></td>
														<td> <img src="../web/uploads/'.$vrow["rst_img2"].'" height="50" width="50" /></td>
														<td> <img src="../web/uploads/'.$vrow["rst_img3"].'" height="50" width="50" /></td>
													</tr>
													<tr>
														<td colspan="4"><a href="edit_profile.php">Edit Profile</a></td>

													</tr>
													
												';
											}

										?>							
					
								</table>
							</div>
						</form>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</div>
			
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<?php require_once("include/footer.inc.php"); ?>
</div>
</body>
</html>
