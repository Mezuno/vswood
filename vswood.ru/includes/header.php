<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>VSWOOD | <? echo $title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<? if ($page = 'auth'){
    echo '<script src="' .$regjslink. '"></script>';
    } ?>
    <?php echo '<link rel="stylesheet" href="'.$csslink.'?v='.time().'">'; ?>
	<?php echo '<link rel="stylesheet" href="'.$chatcsslink.'?v='.time().'">'; ?>
    <?php echo '<link rel="stylesheet" href="'.$profcsslink.'?v='.time().'">'; ?>
    <?php echo '<link rel="stylesheet" href="'.$newscsslink.'?v='.time().'">'; ?>
    <?php echo '<link rel="stylesheet" href="'.$friendscsslink.'?v='.time().'">'; ?>
    <?php echo '<link rel="stylesheet" href="'.$clickercsslink.'?v='.time().'">'; ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/9982e2a196.js" crossorigin="anonymous"></script>
	<link rel="shortcut icon" href="/img/logo.png" type="image/png">
    <?php echo '<link rel="stylesheet" href="'.$mediacsslink.'?v='.time().'">'; ?>
</head>
<body>


<aside class="aside">
<?php if (!check_mobile_device()): ?>
    <div class="container">
	<?php endif ?>
		<div class="aside__column">
			<div class="aside__top flex-center">
				<a href="../">VSWOOD</a>
			</div>
			<ul class="aside__menu">
				<a href="http://vswood.ru/news/" class="aside__link button"><i class="fas fa-newspaper"></i>&nbsp Новости</a>
				<?php if (isset($_COOKIE['key'])): ?>
				<a href="http://vswood.ru/friends/?id=<?= $user['id'] ?>" class="aside__link button"><i class="fa-solid fa-user-group"></i>&nbsp Друзья</a>
				<a href="http://vswood.ru/chat/" class="aside__link button"><i class="far fa-comments"></i>&nbsp Общий чат</a>
				<a href="http://vswood.ru/pm/" class="aside__link button"><i class="far fa-comment"></i>&nbsp Сообщения</a>
				<?php else: ?>
				<a href="http://vswood.ru/register/" class="aside__link button">Регистрация</a>
				<?php endif ?>
				
			</ul>
			<!-- <ul class="aside__bottom">
			</ul> -->
		</div>
	</div>
</aside>
	
<div class="wrapper">



	<header class="header">
        <div class="container">
			<div class="header__row  flex-row flex-alit-center flex-just-spbtw">
				<div class="burger-menu">
						<span></span>
				</div>
				<div class="header__column flex-row">
					<div class="header__page-title">
						<? echo $title ?>
					</div>
				</div>
				<div class="header__column flex-row flex-alit-center">
					<?php if (isset($_COOKIE['key'])) {if ($page == 'main') $avatarImgUri = '/img/users/'.$user['id'].'/avatar.jpg';
					else $avatarImgUri = getImgUri($user['id'], 'avatar'); }?>
					<?php if (isset($_COOKIE['key']) && !check_mobile_device()): ?>
						<div class="header__button">
							<a href="http://vswood.ru/myprofile/" class="header__link header__link_profile flex-alit-center"><img src="<?= $avatarImgUri ?>" alt=""><p><?= $user['login'] ?></p></a>
						</div>
						<div class=""><a href="http://vswood.ru/myprofile/exit.php" class="header__link header__link_exit flex-alit-center">Выйти</a></div>
					<?php elseif (isset($_COOKIE['key'])): ?>
						<div class="header__button">
							<a href="http://vswood.ru/myprofile/" class="header__link header__link_profile flex-alit-center"><img src="<?= $avatarImgUri ?>" alt=""></a>
						</div>
					<?php endif ?>
				</div>	

				
			</div>
		</div>
	</header>

	
<div class="container">
<div class="window">
<script src="../js/burger.js?v=<?= time() ?>"></script>