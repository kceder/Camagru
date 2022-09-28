<?php
session_start();
require_once('connect.php');
if (!isset($_SESSION['logged_in_user']))
    header('Location: home.php');
if (isset($_POST['delete_image'])) {
    $img = $_POST['delete_image'];
    $_POST = array();
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM user_images WHERE img_path = '$img'");
    $stmt->execute();
    $check = $stmt->fetch();

    if ($_SESSION['logged_in_user'] == $check['username']) {
        $stmt_del = $conn->prepare("DELETE FROM user_images WHERE img_path = '$img'");
        $stmt_del->execute();
        unlink($img);
    }
    header("Location: profile.php");
}
?>