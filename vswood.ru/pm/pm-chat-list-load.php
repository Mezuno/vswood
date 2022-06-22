<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;


	$id = $user['id'];
	$result = $db->query("SELECT * FROM `relation` WHERE (`user1` = '$id' OR `user2` = '$id') AND `confirmed1` = '1' AND `confirmed2` = '1' ORDER BY `last_mess_date` DESC, `last_mess_time` DESC");
	
	echo '<div id="pm__list" class="pm__list"">';
	while ($resultFriends = $result->fetch_assoc()) {
		if ($resultFriends['user1'] == $id) {$friendId = (int)$resultFriends['user2'];}
		if ($resultFriends['user2'] == $id) {$friendId = (int)$resultFriends['user1'];}

		$resultNick = $db->query("SELECT * FROM `users` WHERE `id` = '$friendId'")->fetch_assoc();

	// Проверка на новые сообщения
		$resultNew = $db->query("SELECT * FROM `pm-chat` WHERE (`sender` = '$friendId' AND `addressee` = '$id') AND ((`flag` = '0') OR (`flag` = '2'))");
		$newMessCount = 0;
		while ($resultNewMess = $resultNew->fetch_assoc()) {
			$newMessCount++;
		}
		if ($newMessCount > 0) {
			$notification = '<div class="notification">'.$newMessCount.'</div>';
		} else { $notification = ''; }

	// Проверка на просмотр сообщений другом
		$resultUnchecked = $db->query("SELECT * FROM `pm-chat` WHERE (`sender` = '$id' AND `addressee` = '$friendId') AND ((`flag` = '0') OR (`flag` = '2'))");
		$newUncheckedCount = 0;
		while ($resultUncheckedMess = $resultUnchecked->fetch_assoc()) {
			$newUncheckedCount++;
		}			
		if ($newUncheckedCount > 0) {
			$flag = '<div class="message__unread_circle"></div>';
		} else { $flag = ''; }


	// Проверка на checked
		if (isset($_POST['id']) && $_POST['id'] == $friendId) {
			$checked = 'checked';
		}

	// Проверка на онлайн
		if ($resultNick['lastseen'] > time()-30) {
			$online = '<div class="online-circle"></div>';
		}

	// Поиск последнего сообщения
		$resultLastMess = $db->query("SELECT * FROM `pm-chat` WHERE ((`sender` = '$id' AND `sender_del_flag` != 1) AND `addressee` = '$friendId') OR (`sender` = '$friendId' AND (`addressee` = '$id' AND `addressee_del_flag` != 1))");
		
		$isLast = false;
		while ($resultLastMessage = $resultLastMess->fetch_assoc()) {
			if ($resultLastMessage['sender'] == $user['id']) {
				$lastMess = 'Вы: '.$resultLastMessage['message_body'];
			} else {
				$lastMess = $resultLastMessage['message_body'];
			}
			$lastTime = $resultLastMessage['time'];
			if ($resultLastMessage['date'] != date("Y-m-d")) {
				 $lastTime = getFormatDate($resultLastMessage['date']);
			}
			$lastDateToRelation = $resultLastMessage['date'];
			$lastTimeToRelation = $resultLastMessage['time'];
			
			$db->query("UPDATE `relation` SET `last_mess_date` = '$lastDateToRelation' WHERE ((`user1` = '$id' AND `user2` = '$friendId') OR (`user1` = '$friendId' AND `user2` = '$id')) AND `confirmed1` = '1' AND `confirmed2` = '1'");
			$db->query("UPDATE `relation` SET `last_mess_time` = '$lastTimeToRelation' WHERE ((`user1` = '$id' AND `user2` = '$friendId') OR (`user1` = '$friendId' AND `user2` = '$id')) AND `confirmed1` = '1' AND `confirmed2` = '1'");
			
			$isLast = true;
		}
		if (!$isLast) {$lastMess = 'Нет сообщений'; $lastTime = '';}

		
	
	// Проверка на настройку пользователя отображение фонов в сообщениях
		if ($userSettings['display_bg_pm'] == 1) {
			$background = '<div class="pm__item-background-shadow"></div>
				<div class="pm__img-box"><img class="pm__item-background" src="'.getImgUri($resultNick['id'], 'header').'"></img></div>';
			$pmHover = '';
		} else {
			$background = '';
			$pmHover = 'pm__item-hover';
		}
		

		echo'<input data-value="'.$resultNick['login'].'" class="pm__radio" name="id" value="'.$friendId.'" id="pm-item'.$friendId.'" type="radio" '.$checked.'>
			<label name="'.$resultNick['login'].'" for="pm-item'.$friendId.'" class="pm__item '.$pmHover.'">
				<img class="pm__img rounded" src="'.getImgUri($resultNick['id'], 'avatar').'" alt="">'.$online.'
				<div class="pm__body flex-col">
					<div class="pm__name-time">
						<div class="small-text">'.mb_strimwidth($resultNick['login'], 0, 20, '...').'</div>
						<div class="pm__time">'.$lastTime.'</div>
					</div>
					<p class="small-text light-gray-text">'.mb_strimwidth($lastMess, 0, 25, '...').'</p>
				</div>'.$notification.$flag.'
				'.$background.'
			</label>';

		$online = '';
		$checked = '';
		$notification = '';
		$i++;
		$lastMess = '';
	}
	echo '</div>';
	if ($i == 0) {
		echo '<li class="profile__item">Добавьте друзей чтобы общаться с ними в личных сообщениях</li>';
	}
 ?>