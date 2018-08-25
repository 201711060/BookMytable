<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	require_once("classes/dbo.class.php");
	$biq = "select * from  table_booking_items, menu_items where mitm_id = tbi_mitm_id and tbi_tbk_id='".$_GET["tbl_id"]."'";
	$bires = $db->get($biq);

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
						<h2 class="title"><a href="#"><center>Table Booking Items</center></a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							
								<table width="65%" align="center" bgcolor="#f1f1f1" >
									<?php

										while($birow = mysqli_fetch_assoc($bires)) {
											echo'
												<tr>
													<td>'.$birow["mitm_title"].' </td>
												</tr>
												<tr>
													<td>Qty: '.$birow["tbi_mitm_qty"].' </td>
												</tr>
												<tr>
													<td><hr></td>
												</tr>			
										
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
