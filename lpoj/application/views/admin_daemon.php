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
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/iphone-style-checkboxes.js"></script>
<link href="<?php echo base_url(); ?>css/button.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function() {
      $(':checkbox').iphoneStyle({
			onChange: function(elem, value) {
        if($(elem)[0].checked==true){
        		$url = window.location.origin + "/lpoj/index.php/admin/checkDaemon"; 
        		$.post($url,
					{ id: elem.attr('id'), stat : "on" }        		
        		);
        	}
        else {
				$.post($url,
					{ id: elem.attr('id'), stat : "off" }        		
        		);
			}
    	}      
      });
    });
</script>
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
			  <table>
				<tr>
					<td><h3>Daemon</h3></td>
					<td>
					<?php
						exec("ps aux | grep 'bots.py' | grep -v grep",$var,$retval1);
						exec("ps aux | grep 'rejudge.py' | grep -v grep",$var,$retval2);
						exec("ps aux | grep 'main.py' | grep -v grep",$var,$retval3);
						if($retval1==1 || $retval2==1 || $retval3==1)
						{
							echo "<input type=\"checkbox\" name=\"daemon\" id=\"daemon\" >";							
						}
						else 
						{
							echo "<input type=\"checkbox\" name=\"daemon\" id=\"daemon\" checked>";						
						}
					?>
					</td>
				</tr>
			  </table>
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
