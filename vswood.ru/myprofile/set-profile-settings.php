<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
	require_once $dblink;

    $id = $user['id'];
    $setting = $_POST['setting'];
    $checked = $_POST['checked'];
    $choice = $_POST['choice'];
    
    if ($setting == 'display_bg_pm' && $checked == '') {$db->query("INSERT `users-settings` (`id`, `display_bg_pm`) VALUES ('$id', '1')");}
    if ($setting == 'display_bg_pm' && $checked == '0') {$db->query("UPDATE `users-settings` SET `display_bg_pm` = '1' WHERE `id` = '$id'");}
    if ($setting == 'display_bg_pm' && $checked == '1') {$db->query("UPDATE `users-settings` SET `display_bg_pm` = '0' WHERE `id` = '$id'");}

    if ($setting == 'sex' && $choice == '') {$db->query("INSERT `users-settings` (`id`, `sex`) VALUES ('$id', 'NULL')");}
    if ($setting == 'sex' && $choice == 'male') {$db->query("UPDATE `users-settings` SET `sex` = '0' WHERE `id` = '$id'");}
    if ($setting == 'sex' && $choice == 'female') {$db->query("UPDATE `users-settings` SET `sex` = '1' WHERE `id` = '$id'");}
    

 ?>