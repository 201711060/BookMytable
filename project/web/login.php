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
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<form method="post" action="process_login.php">
							<table bgcolor="#f1f1f1" align="center" class="logintbkg" width="40%" cellspacing="10">
								<tr>
									<td align="center" class="title1">Email</td>
								</tr>
								<tr>
									<td><input type="text" name="email" class="full_width"></td>
								</tr>
								<tr>
									<td align="center" class="title1">Password</td>
								</tr>
								<tr>
									<td><input type="password" name="pwd" class="full_width"><br><br></td>
								</tr>
								
								<tr >
									<td colspan="2"><input type="submit" value="Login &rarr;" class="full_width"></td>

								</tr>
								<tr>
									<td> <a href="forgot_pwd.php">Forgot Password</a> </td>
								</tr>
							</table>
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
