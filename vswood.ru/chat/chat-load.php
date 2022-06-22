<?php	

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;

	$result = $db->query("SELECT * FROM `chat` WHERE `id` > (SELECT MAX(ID)-100 FROM `chat`)");

	while ($message = $result->fetch_assoc()) {

		if ($message['senderid'] == $user['id']) $sender = 'message__item_you';
		else $sender = 'message__item_another';

		$message_cur = $message['senderid'];
		if ($message_prev == $message_cur) {
			$photo = '<div class="message__empty-photo"></div>';		
			$text = 
			'<div class="message__body">'.$message['message_body'].'&nbsp<div class="message__time">'.$message['time'].'</div></div>';
		} else {
			$resultLogin = $db->query("SELECT * FROM `users` WHERE `id` = '".$message['senderid']."'")->fetch_assoc();

			$photo = '<img class="message__user-photo" width="36px" height="36px" src="'.getImgUri($message['senderid'], 'avatar').'" alt="">';	
			$text = '	
			<div class="message__body">'.$message['message_body'].'
			<div class="message__time">'.$message['time'].'</div></div>
			';
		}
		$message_prev = $message['senderid'];

		if ($message['senderid'] == $user['id']) {
			echo '<div class="message__item '.$sender.'">
					<div class="message__text_chat message__text">'.$text.'</div>
					'.$photo.'
				</div>';
		} else {
			echo '<div class="message__item '.$sender.'">
					'.$photo.'
					<div class="message__text_chat message__text">'.$text.'</div>
				</div>';
		}
		
	}
?>