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
        <div id="content">
				<div id="content-top"></div>
				<div id="lista" class="box">
					<div id="content-text">
						<div id="title">
							<h2>Clarification</h2>
						</div>
						<p>
							<?php 							
								if ($this->session->flashdata('clarificationok'))
								{
									echo "<table bgcolor='#F77A0C' width='100%'><tr><td>";
									echo $this->session->flashdata('clarificationok');
									echo "</td></tr></table>";
									echo "<br />";
								}
							?>
							<form method='post' action="<?php echo site_url('/clarificationsend'); ?>" >
								<table border='1' width='100%' bgcolor='#F77A0C'><tr><td>
								<table>								
									<tr>
										<td style="color:#000">Clarification Title</td>
										<td><input type="text" name="ctitle" size="50" /></td>
									</tr>
									<tr>
										<td style="color:#000">Clarification Content</td>
										<td><textarea name="ccontent" rows="5" cols="50" ></textarea></td>
									</tr>
								</table>
								</td></tr></table>
								<br />
								<input type='submit' value='Submit Clarification' />
							</form>
						</p>
						<br /><hr />
						Show Clarification : <a href="<?php echo site_url('clarification'); ?>">Only Me</a> - <a href="<?php echo site_url('clarification/all'); ?>">Show All</a>
						<br /><br />
						<?php echo $this->Clarificationmodel->getAllClarification(); ?>
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
