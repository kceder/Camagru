<?php
session_start();
require_once('connect.php');
if (!isset($_SESSION['logged_in_user']))
    header('Location: ../index.php');
if (isset($_POST['delete_image'])) {
    try {

        $img = $_POST['delete_image'];
        $_POST = array();
        $conn = connect();
        $stmt = $conn->prepare("SELECT * FROM user_images WHERE img_path = '$img'");
        $stmt->execute();
        $check = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($_SESSION['logged_in_user'] == $check['username']) {
            $stmt_del = $conn->prepare("DELETE FROM user_images WHERE img_path = '$img'");
            $stmt_del->execute();
            unlink($img);
        }
        header("Location: profile.php");
    }
    catch(PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }
}
?>