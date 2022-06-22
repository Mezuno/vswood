<?php
session_start();
if (isset($_COOKIE['key'])) {
    header('Location: ../myprofile/');
}
$title = 'Регистрация';
$page = 'register';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;
?>

<section class="register">
        <div class="register__row">
            <div class="login__description">
                <div class="login__hello">Регистрация на VSWOOD<?php if (isset($_COOKIE['key'])): ?>, <?= $user['login'] ?><?php endif ?>!</div>
                <div class="login__text">
                Длина логина 4-20 символов<br>
                Длина пароля 8-35 символов<br>
                В логине и пароле разрешены только латинские символы, цифры и символы - и _<br>
                Логин и пароль не могут быть одинаковыми<br>
                Проверьте правильность E-Mail<br>
                </div>
            </div>
            <div class="login__box">
                <div class="login__back"><a href="../"><i class="fas fa-arrow-left"></i>&nbsp На главную</a></div>
                <form method="post" id="reg_form" action="" >
                    <input class="input-text" type="text" onkeyup="checkParams()" id="login" name="login" placeholder="Логин" autocomplete="off"/><br>
                    <input class="input-text" type="email" onkeyup="checkParams()" id="email" name="email" placeholder="E-Mail" autocomplete="off"/><br>
                    <input class="input-text" type="password" onkeyup="checkParams()" id="password" name="password" placeholder="Пароль" autocomplete="off"/><br>
                    <input class="input-text" type="password" onkeyup="checkParams()" id="password2" name="password2" placeholder="Подтверждение пароля" autocomplete="off"/><br>
                    <input class="input-button" type="button" id="regbtn" value="Регистрация" disabled>
                </form>
                <br>
                <div id="message"></div> 
            </div>
        </div>  
</section>
</div>