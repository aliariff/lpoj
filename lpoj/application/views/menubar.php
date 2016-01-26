<?php
	$query = $_SERVER['PHP_SELF'];
	$path = pathinfo( $query );
	$what_you_want = $path['basename'];
	
	$url = site_url().'/home';
	if($what_you_want=='home')
	echo "<li class=\"active\"><a href=\"$url\">Home</a></li>";
	else
	echo "<li><a href=\"$url\">Home</a></li>";
	
	$participant = $this->session->userdata('participantid');
	if ($participant == -1) return;
	
	$url = site_url().'/submit';
	if($what_you_want=='submit')
	echo "<li class=\"active\"><a href=\"$url\">Submit</a></li>";
	else
	echo "<li><a href=\"$url\">Submit</a></li>";
	
	$url = site_url().'/solution';
	if($what_you_want=='solution')
	echo "<li class=\"active\"><a href=\"$url\">My Solution</a></li>";
	else
	echo "<li><a href=\"$url\">My Solution</a></li>";
	
	$url = site_url().'/rank';
	if($what_you_want=='rank')
	echo "<li class=\"active\"><a href=\"$url\">Contest Rank</a></li>";
	else
	echo "<li><a href=\"$url\">Contest Rank</a></li>";
	
	$url = site_url().'/clarification';
	if($what_you_want=='clarification')
	echo "<li class=\"active\"><a href=\"$url\">Clarification</a></li>";
	else
	echo "<li><a href=\"$url\">Clarification</a></li>";
?>