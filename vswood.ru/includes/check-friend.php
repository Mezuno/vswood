<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;
	
	$friendId = $_POST['friendId'];
	$id = $user['id'];

	$result = $db->query("SELECT * FROM `relation` WHERE (`user1` = '$id' AND `user2` = '$friendId') OR (`user1` = '$friendId' AND `user2` = '$id')");
	$friendStatusCheck = $result->fetch_assoc();

	if (!$friendStatusCheck) {
		$friendStatusCheckMessage = '
		
		<form id="add-friend-form" class="gray-text" method="post" action="javascript:addFriend();">
			<button class="profile__button profile__button_long flex-just-spbtw">Добавить в друзья</button>
		</form>


		';	
	} else {

		$isRelation = true;
		if ($friendStatusCheck['user1'] == $id) {
			if ($friendStatusCheck['confirmed1'] == 1 && $friendStatusCheck['confirmed2'] == 0) {
				$friendStatusCheckMessage = 'Заявка отправлена';
			}
			
		}
		if ($friendStatusCheck['user1'] == $friendId) {
			if ($friendStatusCheck['confirmed1'] == 1 && $friendStatusCheck['confirmed2'] == 0) {
				$friendStatusCheckMessage = '

				<form id="add-friend-form" class="gray-text" method="post" action="javascript:addFriend();">
					<button class="profile__button profile__button_long flex-just-spbtw">Принять заявку</button>
				</form>

				';
			}
		}
		
		
		if ($friendStatusCheck['confirmed1'] == 1 && $friendStatusCheck['confirmed2'] == 1) {
			$friendStatusCheckMessage = 'Дружище';
		}
	}
	echo $friendStatusCheckMessage;
 ?>