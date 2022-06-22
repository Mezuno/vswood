<?php
session_start();
if (isset($_SESSION['key'])) {
	header('Location: ../myprofile/');
}
$title = 'Вход';
$page = 'login';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;
?>

    <h2>Вход</h2>
    <form method="post" id="reg_form" action="login.php" >
        <input type="text" onkeyup="checkParams()" id="login" name="login" placeholder="Egor" autocomplete="off"/><br>
        <input type="password" onkeyup="checkParams()" id="password" name="password" placeholder="не не Петух" autocomplete="off"/><br>
        <input type="submit" name="logbtn" id="logbtn" value="АТВИЧАЮ">
    </form>
    <br>

    <div id="message"></div> 