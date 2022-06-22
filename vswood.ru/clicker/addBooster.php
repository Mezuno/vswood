<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;


    function getPrice($price, $multiply, $countBooster, $boosterMultiply) {
		if ($countBooster == 0) return $price; 
        for ($i = $countBooster-1; $i > 0; $i--) {
            $price = $price * $multiply;
        }
        return $price + $countBooster*$boosterMultiply;
    }

	$id = $_POST['id'];
	$boosterType = $_POST['boosterType'];

    $clickerData = $db->query("SELECT * FROM `clicker` WHERE `playerId` = '$id'")->fetch_assoc();
    if (!$clickerData) {
        $db->query("INSERT INTO `clicker` (`playerId`, `points`) VALUES ('$id', '0')");
    }

	if ($boosterType == 'hand') {
		if ($clickerData['points'] >= getPrice(100, 1.15, $clickerData['hands'], 0.05)) {
			$handsIncriment = ++$clickerData['hands'];
			$pointsDecriment = $clickerData['points'] - getPrice(100, 1.15, $clickerData['hands'], 0.05);
			$db->query("UPDATE `clicker` SET `hands` = '$handsIncriment' WHERE `playerId` = '$id'");
			$db->query("UPDATE `clicker` SET `points` = '$pointsDecriment' WHERE `playerId` = '$id'");
		}
	}

	if ($boosterType == 'friend') {
		if ($clickerData['points'] >= getPrice(1000, 1.2, $clickerData['friends'], 0.1)) {
			$friendsIncriment = ++$clickerData['friends'];
			$pointsDecriment = $clickerData['points'] - getPrice(1000, 1.2, $clickerData['friends'], 0.1);
			$db->query("UPDATE `clicker` SET `friends` = '$friendsIncriment' WHERE `playerId` = '$id'");
			$db->query("UPDATE `clicker` SET `points` = '$pointsDecriment' WHERE `playerId` = '$id'");
		}
	}



    $clickerData = $db->query("SELECT * FROM `clicker` WHERE `playerId` = '$id'")->fetch_assoc();
    $response = json_encode($clickerData);

    echo $response;

 ?>