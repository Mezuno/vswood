<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
    require_once $dblink;

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $password2 = filter_var(trim($_POST['password2']), FILTER_SANITIZE_STRING);

    $logres = mysqli_query($db, "SELECT `id` FROM `users` WHERE `login`='" .$login. "'");
    while( $row = mysqli_fetch_assoc($logres) ) { 
        if ($row['id']) {
        $mess = 'Пользователь с таким логином уже существует<br>';
        $result = array(
        'message' => $mess
        ); 
        echo json_encode($result); 
        DIE();
            }
        } 
    $mailres = mysqli_query($db, "SELECT `id` FROM `users` WHERE `email`='" .$email. "'");
    while( $row = mysqli_fetch_assoc($mailres) ) { 
        if ($row['id']) {
        $mess = 'Пользователь с таким E-Mail уже существует<br>';
        $result = array(
        'message' => $mess
        ); 
        echo json_encode($result); 
        DIE();
            }
        } 

    if (strlen($login) < 4){
        $mess = 'Минимальная длина логина 4 символа<br>';
        $error = '1';
    } else if (strlen($login) > 20){
        $mess = 'Максимальная длина логина 20 символов<br>';
        $error = '1';
    } else if (!preg_match("/^[a-zA-Z0-9\-_]+$/", $login)){
        $mess = 'В логине разрешены только латинские символы, цифры и символы - и _<br>';
        $error = '1'; 
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
        $mess = 'Проверьте правильность E-Mail<br>';
        $error = '1';
    } else if (strlen($password) < 8){
        $mess = 'Минимальная длина пароля 8 символов' .$num;
        $error = '1';
    } else if (strlen($password) > 35){
        $mess = 'Максимальная длина пароля 35 символов<br>';
        $error = '1';
    } else if (!preg_match("/^[a-zA-Z0-9\-_]+$/", $password)){
        $mess = 'В пароле разрешены только латинские символы, цифры и символы - и _<br>';
        $error = '1';
    } else if ($password == $login){
        $mess = 'Логин и пароль не могут быть одинаковыми<br>';
        $error = '1';
    } else if (!$error){
        $hash = md5(md5($login . time() . 'morzhikiikorzhiki'));
        $pass = $pass = md5(md5($password."yalublulipton"));
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$email>\r\n";
        $headers .= "From: <admin@vswood.ru>\r\n";
        $message = '
                <html>
                <head>
                <title>Подтвердите Email</title>
                </head>
                <body>
                <p>Что бы подтвердить Email, перейдите по <a href="https://vswood.ru/register/email-verify.php?hash=' . $hash . '">ссылке</a></p>
                </body>
                </html>
                ';
        mysqli_query($db, "INSERT INTO `users` (`login`, `email`, `password`, `hash`, `email_confirmed`) VALUES ('" . $login . "','" . $email . "','" . $pass . "', '" . $hash . "', 0)");
        if (mail($email, "Подтвердите Email", $message, $headers)) {
            $mess = 'Письмо со ссылкой подверждения отправлено на вашу почту, если вы не можете найти его - попробуйте проверить папку спам';
        } else {
            $mess = 'Не удалось отправить письмо со ссылкой для подверждения :(';
        }
    } 

        $result = array(
        'message' => $mess
        ); 
        echo json_encode($result); 
?>