<?php
	$participant = $this->session->userdata('contestid');
	if ($participant == -1)
	{
		redirect(site_url('/contest'));
	}
	$query = $_SERVER['PHP_SELF'];
	$path = pathinfo( $query );
	$what_you_want = $path['basename'];

	$url = site_url().'/contest/dashboard';
	if($what_you_want=='dashboard')
	echo "<li class=\"active\"><a href=\"$url\">Dashboard</a></li>";
	else
	echo "<li><a href=\"$url\">Dashboard</a></li>";

	$url = site_url().'/contest/solution';
	if($what_you_want=='solution')
	echo "<li class=\"active\"><a href=\"$url\">All Solution</a></li>";
	else
	echo "<li><a href=\"$url\">All Solution</a></li>";

	$url = site_url().'/contest/rank';
	if($what_you_want=='rank')
	echo "<li class=\"active\"><a href=\"$url\">Contest Rank</a></li>";
	else
	echo "<li><a href=\"$url\">Contest Rank</a></li>";

	$url = site_url().'/contest/clarification';
	if($what_you_want=='clarification')
	echo "<li class=\"active\"><a href=\"$url\">Clarification</a></li>";
	else
	echo "<li><a href=\"$url\">Clarification</a></li>";

	$url = site_url().'/contest/addProblem';
	if($what_you_want=='addProblem')
	echo "<li class=\"active\"><a href=\"$url\">Add Problem</a></li>";
	else
	echo "<li><a href=\"$url\">Add Problem</a></li>";

	// $url = site_url().'/contest/editProbset';
	// if($what_you_want=='editProbset')
	// echo "<li class=\"active\"><a href=\"$url\">Problem Setter</a></li>";
	// else
	// echo "<li><a href=\"$url\">Problem Setter</a></li>";

	$url = site_url().'/probset';
	echo "<li><a href=\"$url\">Back</a></li>";
?>
