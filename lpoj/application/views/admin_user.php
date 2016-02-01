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
	<?php $this->load->view('admin_header'); ?>
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
          <h2>Add User</h2>
		  <form method="post" action="<?php echo site_url("admin/addUser");?>">
		  <table>
		  <tr>
			<td>Username</td>
			<td>
			<input type="text" name="username" />
			</td>
		  </tr>
		  <tr>
		  <td>Password</td>
		  <td>
			<input type="text" name="password" />
		  </td>
		  </tr>
		  <tr>
		  <td>Status</td>
		  <td>
			<select name="status">
			<option value="1">Admin</option>
			<option value="2">Problem Setter</option>
			<option value="3">User</option>
			</select>
		  </td>
		  </tr>
		  </table>
			<input type="submit"/>
			</form>
		<h2>Edit User</h2>
		<form method="post" action="<?php echo site_url("admin/editUser");?>">
		  <table>
		  <tr>
			<td>Username</td>
			<td>
				<select name="usernameid">
				<?php foreach($alluser as $i):?>
				<option value="<?php echo $i->user_name;?>"><?php echo $i->user_name?></option>
				<?php endforeach;?>
				</select>
			</td>
		  </tr>
		  <tr>
		  <td>New Password</td>
		  <td>
			<input type="text" name="new-password" />
		  </td>
		  </tr>
		  <tr>
		  <td>Retype New Password</td>
		  <td>
			<input type="text" name="re-password" />
		  </td>
		  </tr>
		  <tr>
		  <td>Status</td>
		  <td>
			<select name="edit-status">
			<option value="1">Admin</option>
			<option value="2">Problem Setter</option>
			<option value="3">User</option>
			</select>
		  </td>
		  </tr>
		  </table>
			<input type="submit"/>
			</form>
		<h2>Delete User</h2>
		<form method="post" action="<?php echo site_url("admin/deleteUser");?>">
		  <table>
		  <tr>
			<td>Username</td>
			<td>
				<select name="usernameid1">
				<?php foreach($alluser as $i):?>
				<option value="<?php echo $i->user_name;?>"><?php echo $i->user_name?></option>
				<?php endforeach;?>
				</select>
			</td>
		  </tr>
		  </table>
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
