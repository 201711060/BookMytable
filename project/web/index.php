<?php
	session_start();

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
							<?php if(!isset($_SESSION["rid"])) { ?>
								<a href="register.php" class="mbox">Register</a>
								<a href="login.php" class="mbox">Login</a>
							<?php } ?>
							
							<?php if(isset($_SESSION["rid"])) { ?>
								<a href="category.php" class="mbox">Food Category</a>
								<a href="menu_items.php" class="mbox">Menu Items</a>
								<a href="tables.php" class="mbox">Tables</a>
								<a href="table_booking.php" class="mbox">Table Booking</a>
								<a href="view_profile.php" class="mbox">View Profile</a>
								<a href="today_booking.php" class="mbox">Today's Booking</a>
								<a href="logout.php" class="mbox">Logout</a>
							<?php } ?>

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
