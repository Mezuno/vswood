<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

    $id = $user['id'];
    $friendId = $_POST['id'];
    $db->query("UPDATE `pm-chat` SET `sender_del_flag` = '1' WHERE (`sender` = '$id' AND `addressee` = '$friendId')");
    $db->query("UPDATE `pm-chat` SET `addressee_del_flag` = '1' WHERE (`sender` = '$friendId' AND `addressee` = '$id')");

    $db->query("DELETE FROM `pm-chat` WHERE `sender_del_flag` = '1' AND `addressee_del_flag` = '1'");
 ?>