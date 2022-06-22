<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

    $messId = $_POST['id'];
    $message = $_POST['mess'];
    $db->query("UPDATE `pm-chat` SET `message_body` = '$message' WHERE `id` = '$messId'");
    $resultMess = $db->query("SELECT * FROM `pm-chat` WHERE `id` = '$messId'");
    $resultMessData = $resultMess->fetch_assoc();
    if ($resultMessData['flag'] == 0)
    $db->query("UPDATE `pm-chat` SET `flag` = '2' WHERE `id` = '$messId'");
    if ($resultMessData['flag'] == 1)
    $db->query("UPDATE `pm-chat` SET `flag` = '3' WHERE `id` = '$messId'");

 ?>