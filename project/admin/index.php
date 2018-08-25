<?php 
	session_start();
	if(!isset($_SESSION["aid"]))
	{
		header("location:login.php");
		exit;
	}
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
							<?php if(!isset($_SESSION["aid"])) { ?>
								<a href="login.php" class="mbox">Login</a>
							<?php } ?>
							
							<?php if(isset($_SESSION["aid"])) { ?>
								<a href="restaurant_verify.php" class="mbox">Restaurants</a>
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
