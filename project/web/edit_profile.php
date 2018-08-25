<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	require_once("classes/dbo.class.php");
	$eq = "select * from restaurants where rst_id='".$_SESSION["rid"]."'";
	$eres = $db->get($eq);


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
						<h2 class="title"><a href="#">Edit Profile </a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<div class="left">
								<form method="post" action="process_edit_profile.php" enctype="multipart/form-data">
									<table  width="100%" bgcolor="#f1f1f1" cellpadding="10">
										<?php
											while ($erow = mysqli_fetch_assoc($eres)) {
													echo'
														<tr>
															<td align="center"><span class="title1"> Name </span> <br/>
															<input type="text"  name="rst_nm" class="full_width" value="'.$erow["rst_nm"].'"><br/></td>
														</tr>
														<tr>
															<td align="center"><span class="title1">Password</span><br/>
															<input type="password"  name="rst_pwd" class="full_width" value="'.$erow["rst_pwd"].'"><br/></td>
														</tr>
														<tr>
															<td align="center"> <span class="title1">Email</span><br/>
															<input type="text"  name="rst_email" class="full_width" value="'.$erow["rst_email"].'"><br/></td>
														</tr>
														<tr>
															<td align="center"><span class="title1">Phone1</span><br/>
															<input type="text"  name="rst_phn1" class="full_width" value="'.$erow["rst_phn1"].'"><br/></td>
														</tr>
														<tr>
															<td align="center"><span class="title1">Phone2</span><br/>
															<input type="text"  name="rst_phn2" class="full_width" value="'.$erow["rst_phn2"].'"><br/></td>
														</tr>
														<tr>
													';
										?>		
																		
									</table>
							</div>
							<div class="right">
							<table width="100%" border="0" bgcolor="#f1f1f1" cellpadding="10">
								<?php
									echo'
										<tr>
											<td align="center"><span class="title1">Address</span><br/>
											<textarea  name="rst_addr" rows="6" class="full_width" >'.$erow["rst_desc"].'</textarea><br/></td>
										</tr>
										<tr>
											<td align="center"><span class="title1">Desc</span><br/>
											<textarea  name="rst_desc" rows="5" class="full_width" >'.$erow["rst_addr"].'</textarea><br/></td>
										</tr>								
										<tr align="center">
											<td colspan="2"><input type="submit" name="sbt" value="Save &rarr;" class="full_width" ></td>
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
