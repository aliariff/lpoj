<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>BL.PC Login</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/login-style.css" >
  <link rel="icon" href="<?=base_url()?>/images/favicon.ico">
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to BL.PC</h1>
      <form method="post" action="<?php echo site_url('/session'); ?>">
        <p><input type="text" name="username" value="" placeholder="Username"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>

        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>
  </section>

  <!-- <section class="about">
    <p class="about-author">
      &copy; 2014 <a href="http://lp.if.its.ac.id/" target="_blank">Laboratorium Pemrograman</a> -
      <a href="http://if.its.ac.id/" target="_blank">Teknik Informatika</a><br>
      <a href="http://www.its.ac.id/" target="_blank">Institut Teknologi Sepuluh Nopember</a>
  </section> -->
</body>
</html>
