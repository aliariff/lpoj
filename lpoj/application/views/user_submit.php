<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PC.LP</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo base_url(); ?>style.css" rel="stylesheet" type="text/css" />
<!-- EditArea Plugin -->
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/editarea/edit_area_full.js"></script>
<script language="javascript" type="text/javascript">
editAreaLoader.init({
	id : "textarea_1"		// textarea id
	,syntax: "css"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
});

</script>
<!-- EditArea Plugin Ends -->
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
							<h2>Submit Solution</h2>
						</div>
						<p>
							<?php
								if ($this->session->flashdata('uploaderror'))
								{
									echo "<table bgcolor='#ff7777' width='100%'><tr><td>";
									echo $this->session->flashdata('uploaderror');
									echo "</td></tr></table>";
									echo "<br />";
								}

								if ($this->session->flashdata('fileexist'))
								{
									echo "<table bgcolor='#ff7777' width='100%'><tr><td>";
									echo "The File already Exist";
									echo "</td></tr></table>";
									echo "<br />";
								}

								if ($this->session->flashdata('uploadok'))
								{
									echo "<table bgcolor='#77ff77' width='100%'><tr><td>";
									echo $this->session->flashdata('uploadok');
									echo "</td></tr></table>";
									echo "<br />";
								}
							?>
							<form id="form" method='post' action="<?php echo site_url('/upload'); ?>" enctype="multipart/form-data">
								<td style="color:#000">Select Problem</td>
								<td style="color:#000">: <?php $this->Problemmodel->getNonAcceptedProblem(); ?></td>
								<br /><br />
								<!--
								<td>Language: <select name="lang">
									<option value="cpp">C++ (g++ 4.8.2)</option>
									<option value="c">C (gcc 4.8.2)</option>
									<option value="pas">Pascal (fpc 2.6.2-8)</option>
								</select></td>
								<p>Place your code here :</p>
								<br />
								<textarea id="textarea_1" style="height:320px;width:600px;" name="usercode"></textarea>
								<br />-->
								<table>
									<tr>
										<!--<td style="color:#000">Or choose file </td>-->
										<td><input type="file" name="userfile" id="userfile" style="color:#000"/></td>
									</tr>
								</table>
								<br />
								<input type='submit' value='Submit Solution' />
							</form>
						</p>
						<?php echo $this->Rootmodel->getValue('submit_content'); ?>
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
