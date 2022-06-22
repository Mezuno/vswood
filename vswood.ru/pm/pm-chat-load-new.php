<?php
	ob_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

	// Messages flag
	// 0 = unread
	// 1 = read
	// 2 = edit & unread
	// 3 = edit & read
	// Messages flag

	$id = $user['id'];
	if(isset($_GET['id'])) $selected_id = $_GET['id'];

	$result = $db->query("SELECT * FROM `pm-chat` WHERE ((`sender` = '$selected_id' AND `addressee` = '$id') OR (`sender` = '$id' AND `addressee` = '$selected_id')) AND (`id` > '".$_COOKIE['lastMess']."')");

	while ($message = $result->fetch_assoc()) {
		$messId = $message['id'];
		setcookie('lastMess', $messId, time()+60*60, '/');
		if (($message['sender_del_flag'] == 1 && $message['sender'] == $id) || ($message['addressee_del_flag'] == 1 && $message['addressee'] == $id)) {continue;}
		if ($message['sender'] == $id) {
			$messageSenderId = $id;
			// Непрочитанные отправленные тобой
			if ($message['flag'] == 0 || $message['flag'] == 2) $flag = 'message__unread';
			else $flag = '';
			$sender = 'message__item_you';
			// Крестик (удаление)
			$x = '<input type="radio" id="delete-mess-button'.$message['id'].'" name="delete-mess-button" value="'.$message['id'].'" class="delete-mess-radio invisible"></input>
			<label for="delete-mess-button'.$message['id'].'" name="delete-mess-button" value="'.$message['id'].'" class="delete-message-x"><i class="fas fa-times"></i></label>';
			// Pen (edit)
			$edit = '<input data="'.$message['message_body'].'" type="radio" id="edit-mess-button'.$message['id'].'" name="edit-mess-button" value="'.$message['id'].'" class="edit-mess-radio invisible"></input>
			<label for="edit-mess-button'.$message['id'].'" name="edit-mess-button" value="'.$message['id'].'" class="edit-message"><i class="fas fa-pen"></i></label>';
		}
		if ($message['sender'] == $selected_id) {
			$messageSenderId = $selected_id;
			// Сообщения для прочтения кем-то
			if ($message['flag'] == 0) $flagforreading = 'message__reading';
			else $flagforreading = '';
			// Смена флага в БД как "просмотрено"
			$message_id = $message['id'];
			if ($message['flag'] == 0) {$db->query("UPDATE `pm-chat` SET `flag` = '1' WHERE `id` = '$message_id'");}
			if ($message['flag'] == 2) {$db->query("UPDATE `pm-chat` SET `flag` = '3' WHERE `id` = '$message_id'");}
			$sender = 'message__item_another';
			$x = '';
			$edit = '';
		}

		// Проверка на дату
		$resultLastMessDate = $db->query("SELECT * FROM `pm-chat` WHERE ((`sender` = '$selected_id' AND `addressee` = '$id') OR (`sender` = '$id' AND `addressee` = '$selected_id')) AND (`id` = '".$_COOKIE['lastMess']."')");
		$resultLastDate = $resultLastMessDate->fetch_assoc();
		$currentMessageDate = $message['date'];
		if ($currentMessageDate != $previousMessageDate && $currentMessageDate != $resultLastDate['date']) $newDate = '<div class="message__item"><div class="gray-text small-text new-date-chat">'.$currentMessageDate.'</div></div>';
		else $newDate = '';
		$previousMessageDate = $message['date'];

		// Измененные
		if ($message['flag'] == 2 || $message['flag'] == 3) {
			$changed = '<i class="fas fa-pen"></i>';
		}


		$text =
		'<div class="message__body">'.$message['message_body'].'&nbsp'.
		'<div class="message__time">'.$changed.$message['time'].'</div></div>';


		echo $newDate;
		echo '<div class="message__item '.$sender.' '.$flagforreading.'">
				'.$x.$edit.'<div class="message__text_pm message__text '.$flag.'">'.$text.'</div>
			</div>';
			$flag = '';
			$changed = '';
	}
?>