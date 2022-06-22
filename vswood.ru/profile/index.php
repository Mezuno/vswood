<?php 

// Не в акке - пошёл нахуй
session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}

// Подключение ссылок на файлы
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;


$result = $db->query("SELECT * FROM `users` WHERE `id` = '".$_GET['id']."'"); // Ищем юзера с id из запроса
if (!isset($result)) {header('Location: ../');} // Если пользователя с таким id не существует
$userData = $result->fetch_assoc(); // Формируем массив с данными пользователя
if ($_GET['id'] == $user['id']) {header('Location: ../myprofile/');} // Если юз решил зайти к себе

$title = 'Профиль';
$page = 'login';




require_once $headerlink;
?>

<?php
    $userId = $user['id'];
    $likedUserId = $userData['id'];
    $isLikedUserData = $db->query("SELECT * FROM `profile-likes` WHERE (`like_user_id` = '$userId' AND `liked_user_id` = '$likedUserId')")->fetch_assoc();
    if ($isLikedUserData) {
        if ($isLikedUserData['is_like'] == 1) {
            echo '<input type="hidden" name="isLike" id="isLike" value="1"></input>';
        }
        if ($isLikedUserData['is_like'] == 0) {
            echo '<input type="hidden" name="isLike" id="isLike" value="0"></input>';
        }
    } else {
        echo '<input type="hidden" name="isLike" id="isLike" value="0"></input>';
    }
?>

<!-- НОВЫЙ ПРОФИЛЬ -->
<div class="profile">

    <div class="profile-header">
        <div class="profile-header__shadow"></div>
        <img src="<?= getImgUri($userData['id'], 'header') ?>" alt="">
        <div class="profile-header__status"><?= $userData['status'] ?></div>
    </div>

    <section class="profile__content">
        <div class="profile__row flex-row">
            <div class="profile__column profile__column_avatar">

				<img class="profile__img" width="200px" height="200px" src="<?= getImgUri($userData['id'], 'avatar'); ?>" alt="">


                <div class="profile__buttons flex-row flex-alit-center flex-just-spbtw">
                    <div class="small-text gray-text" id="friendStatus">	
					</div>
					<input type="hidden" name="friendId" id="friendId" value="<?= $userData['id'] ?>">

                    <form method="GET" id="toChat" action="../pm/">
					    <input type="hidden" name="id" id="friendId" value="<?= $userData['id'] ?>">
                        <button class="profile__button profile__button_short" type="submit"><i class="fa-solid fa-message"></i></button>
                    </form>
                </div>

            </div>
            <div class="profile__column flex-col profile-info w100 h100">
                <div class="profile-info__row w100 profile-info__row_top flex-row flex-just-spbtw">
                    <div class="flex-alit-center flex-row">
                        <div class="profile-info__name"><?= $userData['login'] ?></div>
                        &nbsp
                        <button class="flex-row flex-alit-center" id="profileLike"><i class="fa-solid fa-heart"></i>&nbsp<div id="likesCount"><?= $userData['profile_likes'] ?></div></button>
                    </div>
                    <div class="profile-info__lastseen gray-text"><?= getLastSeenById($userData['id']) ?></div>
                </div>
                <div class="profile-info__row">
                    <div class="profile-info__messages">Messages: <?= $userData['messages_count'] ?></div>
                </div>
                <div class="profile-info__row br10 profile-friends">
                    <!-- <div class="profile-friends__title">Друзья:</div> -->
                    <div class="profile-friends__list">

						<?php 
							$id = $userData['id'];
							$result = $db->query("SELECT * FROM `relation` WHERE (`user1` = '$id' OR `user2` = '$id') AND `confirmed1` = '1' AND `confirmed2` = '1'");
							
							if (check_mobile_device()) {$imax = 4;}
							else {$imax = 6;}

							while ($resultFriends = $result->fetch_assoc()) {
                                if ($i >= $imax) {
									continue;
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


</div> <!-- window close -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="../js/create.js"></script>

<script type="text/javascript">

function checkFriend() {
var friendId=$("#friendId").val();
  $.ajax ({
            type: "POST",
            url:  "../includes/check-friend.php",
            data: "friendId="+friendId,
          success: function(html){

		      	//Выводим что вернул нам php
		      	$("#friendStatus").append(html);
          }
  });
}

checkFriend();

function addFriend()
{
var friendId=$("#friendId").val();
  $.ajax ({
            type: "POST",
            url:  "../includes/add-friend.php",
            data: "friendId="+friendId,

          	success: function(response){
          		console.log('Запрос отправлен');
		      	$("#friendStatus").empty();
				checkFriend();
          }
  });
}


// Функция получения $_GET параметров
function $_GET(key) {
  var p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

var likeClicked;

likeClicked = document.getElementById('isLike').getAttribute('value');
if (likeClicked == 1) {
    document.getElementById('profileLike').style.color = '#f03c24';
} else {
    document.getElementById('profileLike').style.color = 'white';
}

$(document).on('click', '#profileLike', function() {
var id = $_GET('id');
$.ajax({
            type: "POST",
            url: "profile-add-like.php",
            data: {"id": id},
            success: function(html) {
                var newLikesCount = Number($("#likesCount").text());
                if (likeClicked == 1) {
                    newLikesCount -= 1;
                    likeClicked = false;
                    document.getElementById('profileLike').style.color = 'white';
                }
                else {
                    document.getElementById('profileLike').style.color = '#f03c24';
                    newLikesCount += 1;
                    likeClicked = true;
                }
		      	$("#likesCount").empty();
		      	$("#likesCount").append(newLikesCount);
            }
    });
});


</script>