<?php
	$query = $_SERVER['PHP_SELF'];
	$path = pathinfo( $query );
	$what_you_want = $path['basename'];
	
	$url = site_url().'/probset';
	if($what_you_want=='probset')
	echo "<li class=\"active\"><a href=\"$url\">Home</a></li>";
	else
	echo "<li><a href=\"$url\">Home</a></li>";
	
	$url = site_url().'/probset/addContest';
	if($what_you_want=='addContest')
	echo "<li class=\"active\"><a href=\"$url\">Add New Contest</a></li>";
	else
	echo "<li><a href=\"$url\">Add New Contest</a></li>";
	
	$url = site_url().'/probset/addProblem';
	if($what_you_want=='addProblem')
	echo "<li class=\"active\"><a onclick=\"return confirm('are you sure?')\" href=\"$url\">Add New Problem</a></li>";
	else
	echo "<li><a onclick=\"return confirm('are you sure?')\" href=\"$url\">Add New Problem</a></li>";
	
	$url = site_url().'/probset/addParticipant';
	if($what_you_want=='addParticipant')
	echo "<li class=\"active\"><a href=\"$url\">Add Participant To Contest</a></li>";
	else
	echo "<li><a href=\"$url\">Add Participant To Contest</a></li>";

	$url = site_url().'/probset/changePass';
	if($what_you_want=='changePass')
	echo "<li class=\"active\"><a href=\"$url\">Change Password</a></li>";
	else
	echo "<li><a href=\"$url\">Change Password</a></li>";
?>
