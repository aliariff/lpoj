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
							<h2>Manage User</h2>
						</div>
						<p>
							<?php
								$detailok = $this->session->flashdata('detailok');
								if ($detailok)
								{
									echo "<table><tr><td bgcolor='#77ff77'>".$detailok."</td></tr></table>";
								}
							?>
							<?php
								$error = $this->session->flashdata('error');
								$success = $this->session->flashdata('success');
								if ($error)
								{
									echo "<table><tr><td bgcolor='#ff7777'>".$error."</td></tr></table>";
								}
								else if ($success)
								{
									echo "<table><tr><td bgcolor='#77ff77'>".$success."</td></tr></table>";
								}
							?>
							<form method='post' action='<?php echo site_url('password/editpass') ?>'>
								<table>
									<tr>
										<td colspan='2'><h3>Password Management</h3></td>
									</tr>
									<tr>
										<td>Old Password</td>
										<td>: <input type='password' name='oldpass' /></td>
									</tr>
									<tr>
										<td>New Password</td>
										<td>: <input type='password' name='newpass' /></td>
									</tr>
									<tr>
										<td>Confirm New Password</td>
										<td>: <input type='password' name='conpass' /></td>
									</tr>
									<tr>
										<td colspan='2'><input type='submit' value='Change Password' /></td>
									</tr>
								</table>
							</form>
							<hr />
							<!-- If you're forgot your password please contact administrator -->
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
