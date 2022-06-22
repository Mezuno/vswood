<?php 
	require_once 'links.php';

	$server = 'localhost';
	$user = 'u1714957_default';
	$password = '0ydQVhkX11zoOCn5';
	$db = 'u1714957_default';
	$db = mysqli_connect($server, $user, $password, $db);
	$db->query("SET NAMES 'utf8';");

	if (!$db){
		$dberror = 'Не удается подключиться к базе данных!';
		echo '<div class="dberror"><p>'.$dberror.'</p></div>';
		exit();
	}

	session_start();

	if (isset($_COOKIE['key'])) {
		$key = $_COOKIE['key'];
		$resultQuery = $db->query("SELECT * FROM `users` WHERE `key` = '$key'");
		$user = $resultQuery->fetch_assoc();
		$resultQuery = $db->query("SELECT * FROM `users-settings` WHERE `id` = '".$user['id']."'");
		$userSettings = $resultQuery->fetch_assoc();
	}

	// Подключение функций
	require $functionslink;

 ?>