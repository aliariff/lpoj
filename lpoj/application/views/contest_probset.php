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
          <h2>Add Problem Setter To Contest</h2>
		  <form method="post" action="<?php echo site_url("contest/getAddProbset");?>">
		  <table>
		  <tr>
			<td>Mode</td>
			<td>
			<select name="mode">
			<option value="1">Tambah</option>
			<?php if($probsetstatus==1) echo '<option value="2">Hapus</option>'?>
			</select>
			</td>
		  </tr>
		  <tr>
		  <td>Contest ID</td>
		  <td>
			<?php echo $this->session->userdata('contestid')." ".$this->Contestmodel->getContestName();?>
		  </td>
		  <td>
			<input type="submit" value="View Problem Setter" name="view"/>
		  </td>
		  </tr>
		  </table>
			<label>1 Username per Baris</label>
			<br/>
			<textarea name="user_names" rows="15" cols="50"></textarea><br/>
			<input type="submit"/>
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
