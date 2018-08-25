<?php
	session_start();
	require_once("classes/dbo.class.php");
	$rvq = "select * from restaurants where rst_is_verified = 0 order by rst_id";
	$rvres = $db->get($rvq);

	$rivq = "select * from restaurants where rst_is_verified = 1 order by rst_id";
	$rivres = $db->get($rivq);


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

							<b>Restaurants which are yet to be verified.</b>
							<table width="100%" cellspacing="3" border="0">
								<tr>
									<td width="10%"></td>
									<td width="20%"><b>Restaurant_name</b></td>
									<td width="20%"><b>Address</b></td>
									<td width="20%"><b>Photo</b></td>
									<td><b>Desc</b></td>
								</tr>
								<tr><td colspan="5"><hr size="2" color="black" /><br /></td></tr>
								<?php
									while($rvrow = mysqli_fetch_assoc($rvres)) {
										echo '
												
												<tr>
													<td valign="top">
														<a href="process_restaurant_verify.php?rid='.$rvrow["rst_id"].'"><img src="images/tick.png"></a> <br />
														<a href="process_restaurant_del.php?rid='.$rvrow["rst_id"].'"><img src="images/cross.png"></a>
													</td>
													<td valign="top">
														<b>'.$rvrow["rst_nm"].'</b> <br />
														'.$rvrow["rst_email"].'<br />
														'.$rvrow["rst_phn1"].'
													</td>
													<td valign="top">
														'.$rvrow["rst_addr"].'
													</td>
													<td>
														<img src="../web/uploads/'.$rvrow["rst_img1"].'" height="50" width="50" />
													</td>
													<td valign="top">
														'.$rvrow["rst_desc"].'
													</td>
												</tr>
												<tr><td colspan="5"><br /><hr size="1" 0color="#e1e1e1" /></td></tr>
										';
									}
								?>
								
							</table>
							<br/><br/><br/><br/><br/><br/><br/>


							<b>Restaurants which are already verified.</b>
							<table width="100%" cellspacing="3" border="0">
								<tr>
									<td width="10%"></td>
									<td width="20%"><b>Restaurant_name</b></td>
									<td width="20%" ><b>Address</b></td>
									<td width="20%"><b>Photo</b></td>
									<td><b>Desc</b></td>
								</tr>
								<tr><td colspan="5"><hr size="2" color="black" /><br /></td></tr>
								<?php
									while($rivrow = mysqli_fetch_assoc($rivres)) {
										echo '
												
												<tr>
													<td valign="top">
														
														<a href="process_restaurant_del.php?rid='.$rivrow["rst_id"].'"><img src="images/cross.png"></a>
													</td>
													<td valign="top">
														<b>'.$rivrow["rst_nm"].'</b> <br />
														'.$rivrow["rst_email"].'<br />
														'.$rivrow["rst_phn1"].'
													</td>
													<td valign="top">
														'.$rivrow["rst_addr"].'
													</td>
													<td>
														<img src="../web/uploads/'.$rivrow["rst_img1"].'" height="50" width="50" />
													</td>
													<td valign="top">
														'.$rivrow["rst_desc"].'
													</td>
												</tr>
												<tr><td colspan="5"><br /><hr size="1" color="#e1e1e1" /></td></tr>
										';
									}
								?>
								
							</table>
							
							
							
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
