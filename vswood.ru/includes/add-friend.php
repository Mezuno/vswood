<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;



	$friendId = $_POST['friendId'];
	$id = $user['id'];


	$resultStatus = $db->query("SELECT * FROM `relation` WHERE (`user1` = '$id' AND `user2` = '$friendId') OR (`user1` = '$friendId' AND `user2` = '$id')");
	$friendStatus = $resultStatus->fetch_assoc();
	if (!$friendStatus) {
		$db->query("INSERT INTO `relation` (`user1`,`user2`,`confirmed1`) VALUES ('$id','$friendId','1')");
	} else {
		if ($friendStatus['confirmed1'] == 1 && $friendStatus['confirmed2'] == 0) {
			$db->query("UPDATE `relation` SET `confirmed2` = '1' WHERE (`user1` = '$friendId' AND `user2` = '$id')");
		}
	}

 ?>