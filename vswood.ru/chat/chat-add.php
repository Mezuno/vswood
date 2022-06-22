<?php 

	include '../includes/db-connect.php';

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

	if (!empty($message_body) && isset($message_body) && !ctype_space($message_body)) {
		$id = $user['id'];
		$time = getTime(time()); // Получаем time

		$db->query("INSERT INTO `chat` (`senderid`, `message_body`, `time`) VALUES ('$id', '$message_body', '$time')");

		$messages_count = $user['messages_count'] + 1;
		$login = $user['login'];
		$db->query("UPDATE `users` SET `messages_count` = '$messages_count' WHERE `id` = '$id'");
	}

 ?>