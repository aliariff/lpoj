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
					<div id="article">
				<div id="content-top"></div>
				<div id="lista" class="box">
					<div id="content-text">
						<div id="title">
							<h2><?php echo $this->Problemmodel->getProblemTitle($problemid) ?></h2>
						</div>
						<p>
							<?php
								echo $this->Problemmodel->getProblemContent($problemid);
							?>
						</p>
						<hr /><hr />
						<p>
							<?php

								if($this->Contestmodel->isThisMyProblem($problemid) || $this->Adminmodel->checkSession() == true)
								{
									$data = array('problemid' => $problemid);
									$this->load->view('contest_editproblem',$data);
								}
								else
								{
									echo "<table border=\"1\" width=\"100%\">";
									echo "<h3>This is Not Your Problem, You Can't Edit This</h3>";
									echo "<br/>";
									echo "</table>";
								}
							?>
							<h3>Delete Problem From This Contest</h3>
							<table border="1" width="100%">
							<form method="post" action="<?php echo site_url('contest/deleteProblem'); ?>">
								<input type="hidden" name="probid" value="<?php echo $problemid; ?>" />
								<?php
									$quest1 = rand(1,10);
									$quest2 = rand(1,10);
									$answer = $quest1 + $quest2;
								?>
								<input type="hidden" name="probans" value="<?php echo $answer; ?>" />
								Answer to delete problem : <?php echo $quest1; ?> + <?php echo $quest2; ?> = <input type="text" name="deleteans" /> <input type="submit" value="Delete Problem From This Contest" />
							</form>
							</table>
							<form method="post" action="<?php echo site_url('contest/solutionAC'); ?>">
								<input type="hidden" name="probid" value="<?php echo $problemid; ?>"/>
								<input type="submit" value="Download All AC Submission on This Problem" />
							</form>
							<form method="post" action="<?php echo site_url('contest/rejudgeProblem'); ?>">
								<input type="hidden" name="probid" value="<?php echo $problemid; ?>" />
								<input type="submit" value="Rejudge Problem" />
							</form>
						</p>
					</div>
				</div>
				<div id="content-bottom"></div>
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
