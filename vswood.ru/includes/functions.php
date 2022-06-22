<?php

    function getSexById($id) {
        global $db;
        $resultGuest = $db->query("SELECT * FROM `users-settings` WHERE `id` = '$id'");
        $guestData = $resultGuest->fetch_assoc();

        if ($guestData['sex'] === NULL) {
            return;
        } else if ($guestData['sex'] == 0) {
            return 0;
        } else if ($guestData['sex'] == 1) {
            return 1;
        }
    }

    function getFormatLastSeen($num, $kind) {
        if ($kind === 'минута') {
            if ($num == 1 || $num == 21 || $num == 31 || $num == 41 || $num == 51) return 'минуту';
            if (($num >= 2 && $num <= 4) || ($num >= 22 && $num <= 24) || ($num >= 32 && $num <= 34) || ($num >= 42 && $num <= 44) || ($num >= 52 && $num <= 54)) return 'минуты';
            if (($num >= 5 && $num <= 20) || ($num >= 25 && $num <= 30) || ($num >= 35 && $num <= 40) || ($num >= 45 && $num <= 50) || ($num >= 55 && $num <= 60)) return 'минут';
        }
        if ($kind === 'час') {
            if ($num == 1 || $num == 21) return 'час';
            if ($num == 2 || $num == 3 || $num == 4 || $num == 22 || $num == 23) return 'часа';
            if ($num >= 5 && $num <= 20) return 'часов';
        }
        if ($kind === 'день') {
            if ($num == 1 || $num == 21) return 'день';
            if ($num == 2 || $num == 3 || $num == 4 || $num == 22 || $num == 23 || $num == 24) return 'дня';
            if (($num >= 5 && $num <= 20) || ($num >= 25 && $num <= 30)) return 'дней';
        }
        if ($kind === 'месяц') {
            if ($num == 1 || $num == 21) return 'месяц';
            if ($num == 2 || $num == 3 || $num == 4 || $num == 22 || $num == 23) return 'месяца';
            if ($num >= 5 && $num <= 20) return 'месяцев';
        }
    }

    function getLastSeenById($id) {
        global $db;
        $resultGuest = $db->query("SELECT * FROM `users` WHERE `id` = '$id'");
        $guestData = $resultGuest->fetch_assoc();

        // Проверка на пол
        if (getSexById($id) === 0) $was = 'был';
        else if (getSexById($id) === 1) $was = 'была';
        else $was = 'был(а)';

        $seen = true;
        if ($guestData['lastseen'] == 0) {
            return 'не входил в чаты';
        } else {
            $lastSeenTime = floor((time() - $guestData['lastseen']) / 60);
            $lastSeenTimePhrase = $lastSeenTime.' '.getFormatLastSeen($lastSeenTime, 'минута').' назад';
            if ($lastSeenTime >= 60) {
                $lastSeenTime = floor($lastSeenTime / 60);
                $lastSeenTimePhrase = $lastSeenTime.' '.getFormatLastSeen($lastSeenTime, 'час').' назад';
                if ($lastSeenTime >= 24) {
                    $lastSeenTime = floor($lastSeenTime / 24);
                    $lastSeenTimePhrase = $lastSeenTime.' '.getFormatLastSeen($lastSeenTime, 'день').' назад';
                    if ($lastSeenTime >= 30) {
                        $lastSeenTime = floor($lastSeenTime / 30);
                        $lastSeenTimePhrase = $lastSeenTime.' '.getFormatLastSeen($lastSeenTime, 'месяц').' назад';
                    }
                }
            }
            if ($lastSeenTime == 0 && $seen == true) { return '<span>Online</span>'; }
            if ($lastSeenTime > 0 && $seen == true) { return $was.' в сети '.$lastSeenTimePhrase; }
        }
    }

	function getImgUri($id, $type) {
        if (file_exists("../img/users/".$id."/".$type.".jpg")) {
            $filemtime = filemtime('../img/users/'.$id.'/'.$type.'.jpg');
            $resultAvatarUrl = "../img/users/".$id."/".$type.".jpg?t=".$filemtime;
            return $resultAvatarUrl;
        } else if (file_exists("../img/".$type.".jpg")) {
            $filemtime = filemtime('../img/'.$type.'.jpg');
            $resultAvatarUrl = "../img/".$type.".jpg?t=".$filemtime;
            return $resultAvatarUrl;
        }
    }

    function getLogin($id) {
        global $db;
		$result = $db->query("SELECT * FROM `users` WHERE `id` = '$id'");
		$resultLogin = $result->fetch_assoc();
		$login = $resultLogin['login'];
		return $login;
	}

    function check_mobile_device() { 
		$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
		// var_dump($agent);exit;
		foreach ($mobile_agent_array as $value) {    
			if (strpos($agent, $value) !== false) return true;   
		}       
		return false; 
	}

    function getFormatDate($date) {
        $currentDate = date("y.m.d");
        if (mb_substr($date, 0, 2) == mb_substr($currentDate, 0, 2)-1) return 'вчера';

        if (mb_substr($date, 8, 2) == '01') $day = 1;
        if (mb_substr($date, 8, 2) == '02') $day = 2;
        if (mb_substr($date, 8, 2) == '03') $day = 3;
        if (mb_substr($date, 8, 2) == '04') $day = 4;
        if (mb_substr($date, 8, 2) == '05') $day = 5;
        if (mb_substr($date, 8, 2) == '06') $day = 6;
        if (mb_substr($date, 8, 2) == '07') $day = 7;
        if (mb_substr($date, 8, 2) == '08') $day = 8;
        if (mb_substr($date, 8, 2) == '09') $day = 9;
        if (mb_substr($date, 8, 2) == 10) $day = 10;
        if (mb_substr($date, 8, 2) == 11) $day = 11;
        if (mb_substr($date, 8, 2) == 12) $day = 12;
        if (mb_substr($date, 8, 2) == 13) $day = 13;
        if (mb_substr($date, 8, 2) == 14) $day = 14;
        if (mb_substr($date, 8, 2) == 15) $day = 15;
        if (mb_substr($date, 8, 2) == 16) $day = 16;
        if (mb_substr($date, 8, 2) == 17) $day = 17;
        if (mb_substr($date, 8, 2) == 18) $day = 18;
        if (mb_substr($date, 8, 2) == 19) $day = 19;
        if (mb_substr($date, 8, 2) == 20) $day = 20;
        if (mb_substr($date, 8, 2) == 21) $day = 21;
        if (mb_substr($date, 8, 2) == 22) $day = 22;
        if (mb_substr($date, 8, 2) == 23) $day = 23;
        if (mb_substr($date, 8, 2) == 24) $day = 24;
        if (mb_substr($date, 8, 2) == 25) $day = 25;
        if (mb_substr($date, 8, 2) == 26) $day = 26;
        if (mb_substr($date, 8, 2) == 27) $day = 27;
        if (mb_substr($date, 8, 2) == 28) $day = 28;
        if (mb_substr($date, 8, 2) == 29) $day = 29;
        if (mb_substr($date, 8, 2) == 30) $day = 30;
        if (mb_substr($date, 8, 2) == 31) $day = 31;

        if (mb_substr($date, 5, 2) == 1) $month = 'января';
        if (mb_substr($date, 5, 2) == 2) $month = 'февраля';
        if (mb_substr($date, 5, 2) == 3) $month = 'марта';
        if (mb_substr($date, 5, 2) == 4) $month = 'апреля';
        if (mb_substr($date, 5, 2) == 5) $month = 'мая';
        if (mb_substr($date, 5, 2) == 6) $month = 'июня';
        if (mb_substr($date, 5, 2) == 7) $month = 'июля';
        if (mb_substr($date, 5, 2) == 8) $month = 'августа';
        if (mb_substr($date, 5, 2) == 9) $month = 'сентября';
        if (mb_substr($date, 5, 2) == 10) $month = 'октября';
        if (mb_substr($date, 5, 2) == 11) $month = 'ноября';
        if (mb_substr($date, 5, 2) == 12) $month = 'декабря';

        return $day.' '.$month;
    }

    

?>