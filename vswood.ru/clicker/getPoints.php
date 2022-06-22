<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;



	$id = $_POST['id'];

    $clickerData = $db->query("SELECT * FROM `clicker` WHERE `playerId` = '$id'")->fetch_assoc();
    
    if (!$clickerData) {
        $db->query("INSERT INTO `clicker` (`playerId`, `points`) VALUES ('$id', '0')");
    }
    $response = json_encode($clickerData);

    echo $response;

 ?>