<link rel="icon" href="<?=base_url()?>/images/favicon.ico">
<div class="header">
    <div class="header_resize">
      <div class="logo"><h1><a href="">&nbsp;&nbsp;BL.PC</a></h1></div>
      <div class="menu_nav">
        <div class="searchform">
        <div id="formsearch">
            <span>
				<a style="color:#000" href="<?php echo site_url('/password') ?>"><?php echo $this->session->userdata('username'); ?></a>
				&nbsp;
				<a href="<?php echo site_url().'/logout'; ?>" style="color:#000">Logout</a>
			</span>
          </div>
        </div>
        <div class="clr"></div>
        <ul>
          <?php $this->load->view('menubar'); ?>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
