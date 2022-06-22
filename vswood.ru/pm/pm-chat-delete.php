<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

    $messId = $_POST['id'];
    $db->query("DELETE FROM `pm-chat` WHERE `id` = '$messId'");

 ?>