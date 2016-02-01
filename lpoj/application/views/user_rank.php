<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>BL.PC</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo base_url(); ?>style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
CuFon ends -->
</head>
<body>
<div class="main">

	<!-- header -->
	<?php $this->load->view('header'); ?>
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
							<h2>Contest Rank</h2>
						</div>
						<p>
							<?php
								$defaultHeight = 50;
								$height = $defaultHeight + ($this->Contestmodel->getParticipantNumber() * $defaultHeight);
								if ($height > 500) $height = 500;

								$cid = $this->Participantmodel->getMyContestId();
							?>
							<iframe frameborder='0' src="<?php echo site_url('/publicrank/contest/'.$cid); ?>" width='100%' height="<?php echo $height; ?>" border='0' ></iframe>

							Contest rank page also can be viewed anonymously at :<br /><a href="<?php echo site_url('publicrank/contest/'.$cid); ?>" target="_blank"><?php echo site_url('publicrank/contest/'.$cid); ?></a>

						</p>
						<br /><hr /><br />
						<?php echo $this->Rootmodel->getValue('rank_content'); ?>
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
