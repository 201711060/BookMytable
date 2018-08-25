<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	require_once("classes/dbo.class.php");
	$cq = "select * from food_categories where fcat_rst_id='".$_SESSION["rid"]."'order by fcat_nm";
	$cres = $db->get($cq);

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
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<div class="left">
								<form action="process_add_category.php" method="post" enctype="multipart/form-data">
									<table bgcolor="#f1f1f1" width="100%" cellspacing="10">
										<tr>
											<td align="center"><span class="title1">Add Category</span><br><br></td>
										</tr>
										<tr>
											<td >
												Category Name <br> <input type="text" name="fcat_nm" class="full_width" />
											</td>
										</tr>
										<tr>
											<td >Image<br/>
												<input type="file" name="fcat_img"><br/></td>
										</tr>
										<tr>
											<td>
												<br/><input type="submit" value="Save &rarr;" class="full_width">
											</td>
										</tr>
									</table>								
								</form>
							</div>
							<div class="right">
								<table width="100%" border="0" cellspacing="3">
									<tr>
										<td align="center" colspan="2"><span class="title1">Browse Categories</span><br><br></td>
									</tr>
									
									<?php
										while($crow = mysqli_fetch_assoc($cres)) {
											echo '
												<tr>
													<td width="5%">
														<a href="process_del_category.php?fcid='.$crow["fcat_id"].'"><img src="images/cross.png"></a>
													</td>
													<td>
														'.$crow["fcat_nm"].'
													</td>
													<td>
														<img src="../web/uploads/'.$crow["fcat_img"].'" height="40" width="40" />
													</td>
												</tr>
												<tr><td colspan="3"><hr size="1" color="#e1e1e1" /></td></tr>
											';
										}
									?>
									
								</table>
							</div>
						</div>
							
							
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
