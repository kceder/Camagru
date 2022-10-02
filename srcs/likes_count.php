<?php
session_start();
require_once('connect.php');
require_once('send_email.php');

if(!isset($_SESSION['logged_in_user']))
    header('Location: ../index.php');
else {
$user = $_SESSION['logged_in_user'];
$like_status = 0;
if (isset($_POST['like']))
{
    $img_path = $_POST['liked_img'];
    try
    {
        $conn = connect();
        $stmt = $conn->query("SELECT username FROM user_images WHERE img_path='$img_path'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $picture_owner = $result[0]['username'];

        $conn = connect();
        $sql = "SELECT username FROM image_likes WHERE img_path='$img_path'";
        $stmt= $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $k) {
            if($k['username'] == $user)
                $like_status = 1;
        }
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

    if($like_status == 0)
    {
        try
        {
            $conn = connect();
            $sql = $conn->prepare("INSERT INTO image_likes (img_path, username, like_status)
                                        VALUES (:img_path, :username, :like_status)");
            $sql->bindParam(':img_path', $img_path, PDO::PARAM_STR);
            $sql->bindParam(':username', $user, PDO::PARAM_STR);
            $sql->bindParam(':like_status', $user, PDO::PARAM_STR);
            $sql->execute();

            $conn = connect();
            $stmt = $conn->query("SELECT username FROM user_images WHERE img_path='$img_path'");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $receiver = $result[0]['username'];
            
            $conn = connect();
            $stmt = $conn->query("SELECT email, noti_status FROM users WHERE username = '$receiver'");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $email = $result[0]['email'];
            $notification_satus = $result[0]['noti_status'];
            if($notification_satus)
                email_sender2($email, $receiver);
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
    else if ($like_status == 1)
    {
        try
        {
            $conn = connect();
            $sql = "DELETE FROM image_likes WHERE img_path ='$img_path' AND username = '$user'";
            $conn->exec($sql);
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
}
else
{
    header('Location: home.php');
}
header('Location: home.php');
}
?>