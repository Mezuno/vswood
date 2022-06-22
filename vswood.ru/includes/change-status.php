<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $dblink;


if (isset($_POST['status'])) {
    $status = $_POST['status'];
    $id = $user['id'];
    $db->query("UPDATE `users` SET `status` = '$status' WHERE `id` = '$id' ");
    header('Location: ../myprofile/');
} else {
    header('Location: ../myprofile/');
}

?>