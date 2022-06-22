<?php 

session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}
$title = 'Профиль';
$page = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;

$id = $user['id'];
 ?>

<!-- НОВЫЙ ПРОФИЛЬ -->
<div class="profile">

    <div class="profile-header">
        <div class="profile-header__shadow"></div>
        <img src="<?= getImgUri($user['id'], 'header') ?>" alt="">
        <div id="profile-header__status" class="profile-header__status">
			<?php if (isset($user['status'])): ?>
				<?= $user['status'] ?>
			<?php endif ?>
		</div>
		<!-- Change header -->
		<form class="profile-info__form change-header flex-row" enctype="multipart/form-data" method="POST" action="../includes/user-header-upload.php">
			<input name="photo" type="file" name="file" id="change-header__input" class="change-header__input" multiple>
			<label class="change-header__label" for="change-header__input"> 
				<div class="gray-text"><i class="fas fa-pen"></i></div>
			</label>
			<button class="change-header__button" type="submit"><i class="fas fa-check"></i></button>
		</form> <!-- Change header end -->
    </div>

    <section class="profile__content">
        <div class="profile__row flex-row">
            <div class="profile__column profile__column_avatar">

				<form class="field__wrapper" enctype="multipart/form-data" method="POST" action="../includes/user-photo-upload.php">
					<input name="photo" type="file" name="file" id="field__file-2" class="field field__file" multiple>
					<label class="field__file-wrapper overflow-hidden" for="field__file-2">
						<img class="profile__img profile__img_hover" src="<?= getImgUri($user['id'], 'avatar') ?>" alt="">
					</label>
					<button class="pers__upload-button upload-button" type="submit"><i class="fas fa-pen-square"></i></button>
				</form>

				<div class="profile__buttons flex-row flex-alit-center flex-just-spbtw">
					<form method="POST" action="../includes/change-status.php" class="flex-row flex-alit-center w100 profile__status">
						<?php if (!empty($user['status'])): ?>
						<div class="flex-row flex-just-spbtw flex-alit-center" value="<?= $user['status'] ?>" id="status">
						<div class="profile__status-text gray-text"><?= mb_strimwidth($user['status'], 0, 10, '..') ?></div>
						<button class="profile__button-input" id="button-swap-text"><i class="fas fa-pen"></i></button>
						</div>
						<?php else: ?>
						<input placeholder="Придумай годный статус" class="profile__text-input" name="status" type="search" autocomplete="off">
						<button class="profile__button-input" type="submit"><i class="far fa-save"></i></button>
						<?php endif ?>
					</form>
                </div>

            </div>
            <div class="profile__column flex-col profile-info w100 h100">
                <div class="profile-info__row profile-info__row_myprofile w100 profile-info__row_top flex-row flex-just-spbtw">
                    <div class="profile-info__name"><?= $user['login'] ?>
					<?php if (check_mobile_device()): ?>
					<a class="gray-text small-text button" href="http://vswood.ru/myprofile/exit.php"><i class="fas fa-sign-out-alt"></i></a>
					<?php endif ?>
					</div>
					<div class="profile-info__settings gray-text upload-button">
						<i class="fas fa-cog"></i>
						<form action="" class="settings">
							<div class="settings__item flex-row flex-alit-center">
								<div class="settings__name">Отображать фоны в сообщениях</div>
								<input value="display_bg_pm" type="checkbox" class="settings__check" id="bg-off" data-checked="<?= $userSettings['display_bg_pm'] ?>" <?php if($userSettings['display_bg_pm'] == 1) echo 'checked'; ?>>
							</div>
							<br>
							<div>
							Мужской&nbsp<input name="sex" value="male" type="radio" class="settings__check" id="sex-male" data-checked="<?= $userSettings['sex'] ?>" <?php if ($userSettings['sex'] !== NULL && $userSettings['sex'] == 0) echo 'checked'; ?>>
							Женский&nbsp<input name="sex" value="female" type="radio" class="settings__check" id="sex-female" data-checked="<?= $userSettings['sex'] ?>" <?php if ($userSettings['sex'] !== NULL && $userSettings['sex'] == 1) echo 'checked'; ?>>
							</div>
						</form>
					</div>
					

                </div>
                <div class="profile-info__row">
                    <div class="profile-info__messages">Messages: <?= $user['messages_count'] ?></div>
                </div>
                <div class="profile-info__row br10 profile-friends">
                    <!-- <div class="profile-friends__title">Друзья:</div> -->
                    <div class="profile-friends__list">

						<?php 
							$id = $user['id'];
							$result = $db->query("SELECT * FROM `relation` WHERE (`user1` = '$id' OR `user2` = '$id') AND `confirmed1` = '1' AND `confirmed2` = '1'");
							
							
							$imax = 0;
							if (check_mobile_device()) {$imax = 3;}
							else {$imax = 4;}


							while ($resultFriends = $result->fetch_assoc()) {
								if ($i > $imax) {
									echo '<a href="../friends/?id='.$user['id'].'" class="profile-friends__item">
											<img width="50px" height="50px" class="rounded profile-friends__img" src="../img/more.png" alt="">
											<div class="profile-friends__name">Друзья</div>
										</a>';
									break;
								}
								if ($resultFriends['user1'] == $id) {$friendId = $resultFriends['user2'];}
								if ($resultFriends['user2'] == $id) {$friendId = $resultFriends['user1'];}

									$resultNick = $db->query("SELECT * FROM `users` WHERE `id` = '$friendId'")->fetch_assoc();
									echo '<a href="../profile/?id='.$friendId.'" class="profile-friends__item">
											<img width="50px" height="50px" class="rounded profile-friends__img" src="'.getImgUri($resultNick['id'], 'avatar').'" alt="">
											<div class="profile-friends__name">'.mb_strimwidth($resultNick['login'], 0, 7, '..').'</div>
										</a>';
								$i++;
							}
							if ($i == 0) {
								echo '<div class="profile-friends__item">У этого пользователя пока нет друзей</div>';
							}
						?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- КОНЕЦ ПРОФИЛЯ -->


<script src="../js/create.js"></script>
<script src="../js/header-upload.js"></script>
<script type="text/javascript">

$(document).on('click', '#button-swap-text', function() {
	var status = $('#status').attr('value');
	$('#status').empty();
	$('#status').append('<input placeholder="Придумай годный статус" value="'+status+'" class="profile__text-input" name="status" type="search" autocomplete="off"><button class="profile__button-input" type="submit"><i class="far fa-save"></i></button>');
});


$(document).on('click', '#bg-off', function() {
	setting = $('#bg-off').val();
	checked = $('#bg-off').attr('data-checked');
	console.log(checked);
$.ajax({
		 type: "POST",
		 url: "set-profile-settings.php",
		 data: {"setting": setting, 'checked': checked},
		 success: function(html)
		 {
			 if (checked == '') {checked = $('#bg-off').attr('data-checked', 1);}
			 if (checked == '1') {checked = $('#bg-off').attr('data-checked', 0);}
			 if (checked == '0') {checked = $('#bg-off').attr('data-checked', 1);}
		 }
 });
});


$(document).on('click', 'input:radio[name=sex]', function() {
	setting = 'sex';
	choice = $('input:radio[name=sex]:checked').val();
	console.log(choice);
$.ajax({
		 type: "POST",
		 url: "set-profile-settings.php",
		 data: {"setting": setting, 'choice': choice},
		 success: function(html)
		 {
			console.log('changed to '+choice);
		 }
 });
});
</script>