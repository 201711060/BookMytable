<?php
	session_start();

	if(!isset($_SESSION["rid"]))
	{
		header("location:login.php");
		exit;
	}

	require_once("classes/dbo.class.php");
	$catq = "select * from food_categories where fcat_rst_id='".$_SESSION["rid"]."' order by fcat_nm";
	$catres = $db->get($catq);

	$iq = "select * from menu_items , food_categories where mitm_rst_id='".$_SESSION["rid"]."' and fcat_id=	mitm_cat_id order by fcat_nm";
	$ires = $db->get($iq);

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
						<h2 class="title"><a href="#">Menu Items</a></h2>
						<div style="clear: both;">&nbsp;</div>
						<div class="entry">
							<div class="left">
								<form method="post" action="process_add_menu_items.php" enctype="multipart/form-data">
								<table  width="100%" bgcolor="#f1f1f1" align="center" >
									<tr >
										<td class="title1" > Category</td>
									</tr>
									<tr>
										<td >
											<select name="cat" class="full_width">
												<?php
													while($catrow = mysqli_fetch_assoc($catres))
													{
														echo '<option value="'.$catrow["fcat_id"].'">'.$catrow["fcat_nm"].'</option>';
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="title1"  >Title</td>
									</tr>
									<tr>
										<td><input type="text"  name="title" class="full_width"></td>
									</tr>
									<tr>
										<td class="title1"> Desc</td>
									</tr>
									<tr>
										<td><input type="text"  name="desc" class="full_width"></td>
									</tr>
									<tr>
										<td class="title1">Rate</td>
									</tr>
									<tr>
										<td><input type="text"  name="rate" class="full_width"></td>
									</tr>
									<tr>
										<td class="title1">Spicy</td>
									</tr>
									<tr>
										<td><input type="checkbox"  name="spicy" value="Y" ></td>
									</tr>
									<tr>
										<td class="title1">Jain</td>
									</tr>
									<tr>
										<td><input type="checkbox"  name="jain" value="Y" ></td>
									</tr>
									<tr>
										<td class="title1">Image1</td>
									</tr>
									<tr>
										<td><input type="file" name="mitm_img1" ></td>
									</tr>
									<tr>
										<td class="title1">Image2</td>
									</tr>
									<tr>
										<td><input type="file" name="mitm_img2" ></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" name="sbt" value="ADD &rarr;" class="full_width"></td>

									</tr>
								</table>
								</form>
							</div>
							<div class="right">
								<table width="100%" border="0" cellspacing="3">
									<tr>
										<td align="center" colspan="4"><span class="title1">Browse Menu Items</span><br><br></td>
									</tr>
									<tr>
										<td> </td>
										<td><b>Category</b></td>
										<td colspan="2"><b>Name </b></td>
										<td><b>Rate</b></td>
									</tr>
									<tr><td colspan="5"><hr size="1" color="#e1e1e1" /></td></tr>
									<tr>
									</tr>
									
									<?php
										while($irow = mysqli_fetch_assoc($ires)) {
											echo '
												<tr>
													<td width="5%">
														<a href="process_del_menu_items.php?miid='.$irow["mitm_id"].'"><img src="images/cross.png"></a>
													</td>
													<td>
														'.$irow["fcat_nm"].'
													</td>
													<td colspan="2">
														'.$irow["mitm_title"].'
													</td>
													<td>
														'.$irow["mitm_rate"].'
													</td>
												</tr>
												<tr><td colspan="5"><hr size="1" color="#e1e1e1" /></td></tr>
											';
										}
									?>
									
								</table>

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
