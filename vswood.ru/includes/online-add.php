<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require $dblink;

	$time = time();
	$id = $user['id'];
	$db->query("UPDATE `users` SET `lastseen` = '$time' WHERE `id` = '$id'");
 ?>