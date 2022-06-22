<?php 
$title = 'Подверждение E-Mail';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;
// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    
    if ($result = mysqli_query($db, "SELECT `id`, `email_confirmed` FROM `users` WHERE `hash`='" . $hash . "'")) {
        while( $row = mysqli_fetch_assoc($result) ) { 
            if ($row['email_confirmed'] == 0) {
                // Если всё верно, то делаем подтверждение
                mysqli_query($db, "UPDATE `users` SET `email_confirmed`=1 WHERE `id`=". $row['id'] );
                echo "Email подтверждён";
            } else {
                echo "Эта почта уже подтверждена";
            }
        } 
    } else {
        echo "Что-то пошло не так";
    }
} else {
    echo "Что-то пошло не так";
}