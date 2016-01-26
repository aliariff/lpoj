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
		<!-- TinyMCE -->
		<script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
		<script>
        tinymce.init({selector:'textarea'});
		</script>
		<!-- /TinyMCE -->
</head>
<body>
<div class="main">

	<!-- header -->
	<?php $this->load->view('probset_header'); ?>
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
							<h3>Edit Problem</h3>
							<table border="1" width="100%"><tr><td>
							<?php $pdet = $this->Problemmodel->getProblem($problemid); ?>
							<form method="post" action="<?php echo site_url('probset/editProblem'); ?>" enctype="multipart/form-data">
								<table>
									<tr>
										<td>Problem Id</td>
										<td>: <?php echo $problemid; ?><input name="pid" type="hidden" value="<?php echo $problemid; ?>" /></td>
									</tr>
									<tr>
										<td>Problem Title</td>
										<td>: <input size="60" name="ptitle" type="text" value="<?php echo $pdet->problem_title; ?>" /> </td>
									</tr>
									<tr>
										<td>Problem Creator</td>
										<td>: <input size="60" name="pcreator" type="text" value="<?php echo $pdet->problem_creator; ?>" /> </td>
									</tr>
									<tr>
										<td>Problem Content</td>
										<td><textarea name="pcontent" rows="20" cols="50" class="mce"><?php echo $pdet->problem_content; ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td><a href="<?php echo site_url('uploadtestcase/prob/'.$problemid); ?>"> Upload Test Case</a></td>
									</tr>
									<tr>
										<td>Running Time Limit</td>
										<td>: <input name="prunning" type="text" value="<?php echo $pdet->problem_runtime; ?>" /> second</td>
									</tr>
									<tr>
										<td>Memory Limit</td>
										<td>: <input name="pmemory" type="text" value="<?php echo $pdet->problem_memory; ?>" /> bytes</td>
									</tr>
									<tr>
										<td colspan="2"><input type="submit" value="Update Problem" /></td>
									</tr>
								</table>
							</form>
							</td></tr></table>
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
