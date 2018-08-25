<?php
	
	require_once("classes/dbo.class.php");
	$rq = "select * from restaurants";
	$rres = $db->get($rq);

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
						<h2 class="title"><a href="#">Registration </a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<div class="left">
								<form method="post" action="process_add_register.php" enctype="multipart/form-data">
									<table  width="100%" bgcolor="#f1f1f1" cellpadding="10">
										<tr>
											<td align="center"><span class="title1"> Name </span> <br/>
											<input type="text"  name="rst_nm" class="full_width"><br/></td>
										</tr>
										<tr>
											<td align="center"><span class="title1">Password</span><br/>
											<input type="password"  name="rst_pwd" class="full_width"><br/></td>
										</tr>
										<tr>
											<td align="center"> <span class="title1">Email</span><br/>
											<input type="text"  name="rst_email" class="full_width"><br/></td>
										</tr>
										<tr>
											<td align="center"><span class="title1">Phone1</span><br/>
											<input type="text"  name="rst_phn1" class="full_width"><br/></td>
										</tr>
										<tr>
											<td align="center"><span class="title1">Phone2</span><br/>
											<input type="text"  name="rst_phn2" class="full_width"><br/></td>
										</tr>
									<tr>
									<td align="center"><span class="title1">Image1</span><br/>
									<input type="file" name="rst_img1" ><br/></td>
								</tr>
								<tr>
									<td align="center"><span class="title1">Image2</span><br/>
									<input type="file" name="rst_img2" ><br/></td>
								</tr>	
										
									</table>
							</div>
							<div class="right">
							<table width="100%" border="0" bgcolor="#f1f1f1" cellpadding="10">
									<tr>
									<td align="center"><span class="title1">Address</span><br/>
									<textarea  name="rst_addr" rows="7" class="full_width"></textarea><br/></td>
								</tr>
								<tr>
									<td align="center"><span class="title1">Desc</span><br/>
									<textarea  name="rst_desc" rows="7" class="full_width"></textarea><br/></td>
								</tr>
								
								<tr>
									<td align="center"><span class="title1">Image3</span><br/>
									<input type="file" name="rst_img3"  ><br/></td>
								</tr>
								
								<tr align="center">
									<td colspan="2"><input type="submit" name="sbt" value="ADD &rarr;" class="full_width"></td>

								</tr>
						
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
