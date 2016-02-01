<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
	<head>
		<title>BL.PC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="<?php echo base_url(); ?>style.css" rel="stylesheet" type="text/css" />
		<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section
		<script type="text/javascript" src="js/cufon-yui.js"></script>
		<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
		<script type="text/javascript" src="js/cuf_run.js"></script>
		CuFon ends -->

		<!-- TinyMCE -->
		<script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
		<script>
        tinymce.init({selector:'textarea', plugins: "image"});
		</script>
		<!-- /TinyMCE -->
	</head>
	<body>
	<div class="main">
		<!-- header -->
		<?php $this->load->view('contest_header'); ?>
		<!-- end #header -->
		<div class="hbg">
		<div class="hbg_resize">
		</div>
		</div>
		<div class="content">
			<div class="content_resize">
				<div class="mainbar">
					<!-- content -->
					<div class="article">
							<h2>Contest Dashboard</h2>
							<form method="post" action="<?php echo site_url('/contest/updatedetail') ?>">
								<table>
								<tr>
									<td>Contest Name</td>
									<td>: <input type="text" name="conname" size="66" value="<?php echo $this->Contestmodel->getContestName(); ?>" /></td>
								</tr>
								<tr>
									<td>Contest Description</td>
									<td><textarea name="condesc" rows="20" cols="50"><?php echo $this->Contestmodel->getContestDescription(); ?></textarea></td>
								</tr>
								<tr>
									<td>Contest Start Time</td>
									<td>: <input type="text" name="constart" size="40" value="<?php echo $this->Contestmodel->getContestStart(); ?>" /></td>
								</tr>
								<tr>
									<td>Contest Freeze Time</td>
									<td>: <input type="text" name="confreeze" size="40" value="<?php echo $this->Contestmodel->getContestFreeze(); ?>" /></td>
								</tr>
								<tr>
									<td>Contest End Time</td>
									<td>: <input type="text" name="conend" size="40" value="<?php echo $this->Contestmodel->getContestEnd(); ?>" /></td>
								</tr>
								<!-- <tr>
									<td>Contest Penalty</td>
									<td>: <input type="text" name="conpenalty" size="40" value="<?php echo $this->Contestmodel->getContestPenalty(); ?>" /></td>
								</tr> -->
								<tr>
									<td colspan="2"><input type="submit" value="Update Contest Details" /></td>
								</tr>
								</table>
							</form>
					</div>
				<!-- end #content -->
				</div>
				<div class="sidebar">
				<!-- sidebar -->
				<?php $this->load->view('sidebar_problem'); ?>
				<?php $this->load->view('sidebar_contest'); ?>
				<!-- end #sidebar -->
				</div>
				<div class="clr"></div>
			</div>
		</div>
			<div class="fbg">
				<div class="fbg_resize">
					<div class="clr"></div>
				</div>
			</div>
		<!-- footer -->
		<?php $this->load->view('footer'); ?>
		<!-- end #footer -->
	</div>
</body>
</html>
