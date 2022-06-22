<?php 
	session_start();
	session_unset();
	setcookie('key', '', time()-60*60*24*30, '/');
	header('Location: /');
 ?>