<?php 

if (isset($_POST['logbtn'])) {
	session_start();

	require_once '../includes/db-connect.php';

	if (isset($_POST['login']) && !empty($_POST['login'])) {
		$login = $_POST['login'];
	} else {		
		$logerror = 'Введите логин';
	}
	if (isset($_POST['password']) && !empty($_POST['password'])) {
		$password =  md5(md5($_POST['password']."yalublulipton"));
	} else {
		$logerror = 'Введите пароль';
	}

	if ((isset($login) && !empty($login)) && (isset($password) && !empty($password))) {

		$resultQuery = $db->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
		$user = $resultQuery->fetch_assoc();


		if (isset($user)) {

			if (!empty($user['key'])) {

				// Вот тут чел зашёл со старым ключом
				setcookie('key', $user['key'], time()+60*60*24*30, '/');
				$_SESSION["key"] = $user['key'];

				header('Location: ../myprofile/');

			} else {
				$uniqueKey = false;
				while (!$uniqueKey) {
					$key = md5(md5($password."jopachervya"));
					$resultQuery = $db->query("SELECT * FROM `users` WHERE `key` = '$key'");
					$userKey = $resultQuery->fetch_assoc();

					if (isset($userKey)) $uniqueKey = false;
					else {
						$uniqueKey = true;
						$db->query("UPDATE `users` SET `key` = '$key' WHERE `login` = '$login' AND `password` = '$password'");

						// Вот тут челу создался новый ключ и он зашёл с ним
						setcookie('key', $key, time()+60*60*24*30, '/');
						$_SESSION["key"] = $key;

						header('Location: ../myprofile/');
					}
				}
			}
			

			
		} else {
			$logerror = 'Неверный логин или пароль';
			header('Location: /');
		}

	} else {
		header('Location: /');
	}
}
	echo $logerror;
 ?>