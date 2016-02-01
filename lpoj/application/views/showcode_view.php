<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PC.LP</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo base_url(); ?>style.css" rel="stylesheet" type="text/css" />
<!-- CuFon: Enables smooth pretty custom font rendering. 100% SEO friendly. To disable, remove this section
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/droid_sans_400-droid_sans_700.font.js"></script>
<script type="text/javascript" src="js/cuf_run.js"></script>
CuFon ends -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/shCore.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/shBrushJScript.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/shBrushCpp.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/shBrushDelphi.js"></script>
<link href="<?php echo base_url(); ?>css/shCore.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/shThemeDefault.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main">

	<!-- header -->
	<?php if($this->Usermodel->checkSessionProbset() || $this->Adminmodel->checkSession()) $this->load->view('contest_header');
		else $this->load->view('header');
	?>
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
							<h2>Solution</h2>
						</div>
							<h4>Result</h4>
							<script type="syntaxhighlighter" class="brush: <?php echo $lang;?> "><![CDATA[
								<?php $this->Showcodemodel->showVerdictDetail($submitid); ?>
							]]></script>
							<h4>Code</h4>
							<script type="syntaxhighlighter" class="brush: <?php echo $lang; ?>"><![CDATA[
								<?php $this->Showcodemodel->showSubmitedCode($path, $fileName); ?>
							]]></script>

						<br /><hr />
						<?php echo $this->Rootmodel->getValue('solution_content'); ?>
					</div>
				</div>
				<div id="content-bottom"></div>
			</div>
		<!-- end #content -->
      </div>
      <script type="text/javascript">
    	 SyntaxHighlighter.all()
	  </script>
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
