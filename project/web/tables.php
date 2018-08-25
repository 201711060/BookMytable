<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	require_once("classes/dbo.class.php");
	$tq = "select * from tables where tbl_rst_id='".$_SESSION["rid"]."'order by tbl_nm";
	$tres = $db->get($tq);

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
								<form action="process_add_table.php" method="post">
									<table width="100%" bgcolor="#f1f1f1" cellspacing="10">
										<tr>
											<td align="center"><span class="title1">Add Tables</span><br><br></td>
										</tr>
										<tr>
											<td>
												Table Name <br> <input type="text" name="tbl_nm" class="full_width" />
											</td>
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
										<td align="center" colspan="2"><span class="title1">Browse Tables</span><br><br></td>
									</tr>
									
									<?php
										while($trow = mysqli_fetch_assoc($tres)) {
											echo '
												<tr>
													<td width="5%">
														<a href="process_del_table.php?tcid='.$trow["tbl_id"].'"><img src="images/cross.png"></a>
													</td>
													<td>
														'.$trow["tbl_nm"].'
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
