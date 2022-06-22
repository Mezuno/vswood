<?php 
	if (file_exists('../img/users/'.$userNickname.'.jpg')) $photo = '<img class="rounded-photo" src="../img/users/'.$userNickname.'.jpg" alt="">';
	else $photo = '<img class="rounded-photo" src="../img/logo.png" alt="">';
 ?>