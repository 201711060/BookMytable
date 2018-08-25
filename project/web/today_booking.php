<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	require_once("classes/dbo.class.php");
	$bdq = "select * from  table_bookings,tables where tbk_date='".date("Y-m-d")."' and tbl_id= tbk_tbl_id order by tbk_time_slot";
	$bdres = $db->get($bdq);

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
						<h2 class="title"><a href="#"><center>Table Details</center> </a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
									<?php

										while ($bdrow = mysqli_fetch_assoc($bdres)) {
											echo '
											<div class="left">
												<table width="100%"  bgcolor="#f1f1f1" >
													<tr>
														<td ><b><center>'.$bdrow["tbl_nm"].'</center></b></td>
													</tr>											

													<tr>
														<td >Date:  '.$bdrow["tbk_date"].'</td>
													</tr>
													<tr>
														<td width="40"><b>Name:  '.$bdrow["tbk_nm"].'</b></td>
													</tr>
													<tr>
														<td>Time Slot:  '.$bdrow["tbk_time_slot"].'</td>
													</tr>
													<tr>
														<td><hr></td>
													</tr>
												</table>
											</div>
																					
											<div class="right">
												<table width="100%"  bgcolor="#f1f1f1" >
													<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
																				
													<tr>
														<td>Phone:  '.$bdrow["tbk_phn"].'</td>
													</tr>
													<tr>
														<td>Number of Person:  '.$bdrow["tbk_members"].'</td>
													</tr>
													<tr>
														<td><a href="table_booking_items.php?tbl_id='.$bdrow["tbk_id"].'">more</a> &nbsp;&nbsp;&nbsp;&nbsp;
															<a href="process_del_table_details.php?tcid='.$bdrow["tbk_id"].'">delete</a></td>
													</tr>
													<tr>
														<td><hr></td>
													</tr>
												</table>	
											</div>	

											';	
											echo '<div style="clear:both;"></div>';
											echo '<br><br>';
										
										}
									?>
																	
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
