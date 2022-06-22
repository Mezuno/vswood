<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

	// Функция вычисления time right now (сам написал!)
	function getTime($secs)
	{		
		$h = (($secs/ 3600 % 24)+3);
		$m = ($secs / 60 % 60);
		if ($h < 10) { $h = '0'.$h;	}
		if ($m < 10) { $m = '0'.$m;	}
		if ($h >= 24) { $h-=24; }
		$time = ($h.':'.$m);
		return $time;
	}

	if (!empty($_POST['mess']) && isset($_POST['mess']) && !ctype_space($_POST['mess'])) { $message_body = htmlspecialchars($_POST['mess']); } // Получение сообщения

	if (!empty($message_body) && isset($message_body) && !ctype_space($message_body) && $_POST['id'] != 0) {
		$id = $user['id'];
		$selected_id = $_POST['id'];
		$time = getTime(time()); // Получаем time
		$date = date("y.m.d"); // Получаем date


		$db->query("INSERT INTO `pm-chat` (`sender`, `addressee`, `message_body`, `date`, `time`) VALUES ('$id', '$selected_id', '$message_body', '$date', '$time')");

		$messages_count = $user['messages_count'] + 1;
		$db->query("UPDATE `users` SET `messages_count` = '$messages_count' WHERE `id` = '$id'");
	}

 ?>