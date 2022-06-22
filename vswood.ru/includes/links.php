<?php
	//Подключаемые файлы
	$dblink = $_SERVER['DOCUMENT_ROOT'].'/includes/db-connect.php'; //Подключение к бд
	$headerlink = $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; //Шапка
	$checkauthlink = $_SERVER['DOCUMENT_ROOT'].'/includes/check-auth.php'; //Шапка
	$regjslink = '/js/reg.js'; //JS для работы AJAX регистрации
	$checkfriendlink = $_SERVER['DOCUMENT_ROOT'].'/includes/check-friend.php';
	$checkphotolink = $_SERVER['DOCUMENT_ROOT'].'/includes/check-photo.php';
	$functionslink = $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';

	// CSS
	$csslink = '/css/style.css';
	$profcsslink = '/css/profile.css';
	$chatcsslink = '/css/chat.css';
	$mediacsslink = '/css/media.css';
	$newscsslink = '/css/news.css';
	$friendscsslink = '/css/friends.css';
	$clickercsslink = '/css/clicker.css';

	//Страницы для юзера
	$authink = $_SERVER['DOCUMENT_ROOT'].'/auth/index.php'; //Регистрация и авторизация
	$emailverifylink = $_SERVER['DOCUMENT_ROOT'].'/email-verify.php'; //Подверждение почты
	$reg_checklink = $_SERVER['DOCUMENT_ROOT'].'/includes/check.php'; //Проверка данных регистрации
	$myprofilelink = $_SERVER['DOCUMENT_ROOT'].'/myprofile/index.php';