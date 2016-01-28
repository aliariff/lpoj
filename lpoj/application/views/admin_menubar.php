<?php
	$query = $_SERVER['PHP_SELF'];
	$path = pathinfo( $query );
	$what_you_want = $path['basename'];

	$url = site_url().'/admin';
	if($what_you_want=='admin')
	echo "<li class=\"active\"><a href=\"$url\">Home</a></li>";
	else
	echo "<li><a href=\"$url\">Home</a></li>";

	$url = site_url().'/admin/addContest';
	if($what_you_want=='addContest')
	echo "<li class=\"active\"><a href=\"$url\">Add/Delete Contest</a></li>";
	else
	echo "<li><a href=\"$url\">Add/Delete Contest</a></li>";

	$url = site_url().'/admin/addProblem';
	if($what_you_want=='addProblem')
	echo "<li class=\"active\"><a onClick=\"return confirm('are you sure?')\" href=\"$url\">Add New Problem</a></li>";
	else
	echo "<li><a onClick=\"return confirm('are you sure?')\" href=\"$url\">Add New Problem</a></li>";

	$url = site_url().'/admin/addParticipant';
	if($what_you_want=='addParticipant')
	echo "<li class=\"active\"><a href=\"$url\">Add Participant</a></li>";
	else
	echo "<li><a href=\"$url\">Add Participant</a></li>";

	$url = site_url().'/admin/userPrivilege';
	if($what_you_want=='userPrivilege')
	echo "<li class=\"active\"><a href=\"$url\">User</a></li>";
	else
	echo "<li><a href=\"$url\">User</a></li>";

	// $url = site_url().'/admin/daemon';
	// if($what_you_want=='daemon')
	// echo "<li class=\"active\"><a href=\"$url\">Daemon</a></li>";
	// else
	// echo "<li><a href=\"$url\">Daemon</a></li>";

?>
