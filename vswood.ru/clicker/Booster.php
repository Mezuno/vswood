<?php

class Booster {
    public static $gain;
    public static $scale;
    public static $countScale;
    public $count;
}

class Hand extends Booster {
    public static $gain = 1;
    public static $scale = 1.15;
    public static $countScale = 0.05;
    public function setCount($count){
        $this->$count = $count;
    } 
}

class Player {

    function __construct($countHands) {
        public $hands = new Hand();
        $hands->setCount($countHands);
    }
}

echo Hand::$gain;



require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;
$id = $_POST['id'];
$clickerData = $db->query("SELECT * FROM `clicker` WHERE `playerId` = '$id'")->fetch_assoc();

$player = new Player($clickerData['hands']);
echo $player->$hands->count;

?>