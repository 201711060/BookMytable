<?php
	
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}
	require_once("classes/dbo.class.php");
	$bq = "select * from tables where tbl_rst_id='".$_SESSION["rid"]."'order by tbl_nm";
	$bres = $db->get($bq);
	
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
						<h2 class="title" align="center"><a href="#">Table Booking </a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
														
							<?php
							while($brow = mysqli_fetch_assoc($bres)) {
								echo'
										
										<a href="table_details.php?tbl_id='.$brow["tbl_id"].'" class="mbox"><b>'.$brow["tbl_nm"].'</b></a>
										
									';
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
