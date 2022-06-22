<?php
$title = 'Главная страница';
$page = 'main';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;

session_start();

?>
	


	<section class="login">
			<div class="login__row">

				<div class="login__container">
					<div class="login__content">
						<div class="login__description">
							<div class="login__hello">Добро пожаловать<br>на VSWOOD<?php if (isset($_COOKIE['key'])): ?>, <?= $user['login'] ?><?php endif ?>!</div>
							<div class="login__text">
							В будущем здесь будет какой-то текст описывающий проект, но пока что его нет. Расцветали яблони и груши, поплыли туманы над рекой. Холод стикса с хароном, горло стиснет гарротой. Если в небе красный закат, то бесспорно, значит перерезал небу кто-нибудь горло.
							</div>
						</div>
						<?php if (!isset($_COOKIE['key'])): ?>
						<div class="login__box">
							<p class="login__title">Вход</p>

							<form method="post" id="reg_form" action="login/login.php">
								<input class="input-text" type="text" onkeyup="checkParams()" id="login" name="login" placeholder="Логин" autocomplete="off"/><br>
								<input class="input-text"  type="password" onkeyup="checkParams()" id="password" name="password" placeholder="Пароль" autocomplete="off"/><br>
								<input class="input-button" type="submit" name="logbtn" id="logbtn" value="Войти">
							</form>

							<div id="message"></div>

							<div class="login__box-bottom">
								<p class="login__if">Не зарегестрированы?&nbsp</p>
								<a class="login__reglink" href="/register">Регистрация</a>
							</div>
						</div>
						<?php endif ?>

					</div>


				</div>

			</div>
	</section>
</div>





<!--
    <h2>Регистрация</h2>
    <form method="post" id="reg_form" action="" >
        <input type="text" onkeyup="checkParams()" id="login" name="login" placeholder="Логин" autocomplete="off"/><br>
        <input type="email" onkeyup="checkParams()" id="email" name="email" placeholder="E-Mail" autocomplete="off"/><br>
        <input type="password" onkeyup="checkParams()" id="password" name="password" placeholder="Пароль" autocomplete="off"/><br>
        <input type="password" onkeyup="checkParams()" id="password2" name="password2" placeholder="Подтверждение пароля" autocomplete="off"/><br>
        <input type="button" id="regbtn" value="Регистрация" disabled>
    </form>
    <br>

    <div id="message"></div> 
-->
</body>
</html>