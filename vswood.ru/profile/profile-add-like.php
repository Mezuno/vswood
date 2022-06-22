<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;

$id = $user['id'];
$likedUserId = $_POST['id'];

$likedUserData = $db->query("SELECT * FROM `users` WHERE `id` = '$likedUserId'")->fetch_assoc();
$incrementUserLike = $likedUserData['profile_likes'] + 1;
$decrementUserLike = $likedUserData['profile_likes'] - 1;

$isLikedUserData = $db->query("SELECT * FROM `profile-likes` WHERE (`like_user_id` = '$id' AND `liked_user_id` = '$likedUserId')")->fetch_assoc();

if ($isLikedUserData) {
    
    if ($isLikedUserData['is_like'] == 1) {
        $db->query("UPDATE `profile-likes` SET `is_like` = '0' WHERE ('$id' = `like_user_id` AND '$likedUserId' = `liked_user_id`)");
        $db->query("UPDATE `users` SET `profile_likes` = '$decrementUserLike' WHERE `id` = '$likedUserId'");
    }
    if ($isLikedUserData['is_like'] == 0) {
        $db->query("UPDATE `profile-likes` SET `is_like` = '1' WHERE ('$id' = `like_user_id` AND '$likedUserId' = `liked_user_id`)");
        $db->query("UPDATE `users` SET `profile_likes` = '$incrementUserLike' WHERE `id` = '$likedUserId'");
    }


} else {
    $db->query("INSERT `profile-likes` (`like_user_id`, `liked_user_id`, `is_like`) VALUES ('$id', '$likedUserId', '1')");
    $db->query("UPDATE `users` SET `profile_likes` = '$incrementUserLike' WHERE `id` = '$likedUserId'");
}



?>