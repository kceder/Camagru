<?php
session_start();
require_once('connect.php');
require_once('send_email.php');
$username = $_SESSION['logged_in_user'];
$img_path = $_POST['img_path'];
$comment =  htmlspecialchars($_POST['comment']);
if($_POST['OK'] === 'Post' && $comment){
    try {
        $conn = connect();
        $stmt = $conn->prepare("INSERT INTO image_comments (username, img_path, comment)
        VALUES (:username, :img_path, :comment)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':img_path', $img_path, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
        
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
            email_sender1($email, $receiver);
        header('Location: home.php');
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

}
// function email_sender1($email, $name) {
        
//     $subject = 'Someone commented on your picture!';
//     $message = 'Hi '.$name.'!
//     You have just received a comment on your Camagru picture.
    
      
//     Go to Camagru and check it out!
//     http://localhost:8080/camagru/home.php
      
//     ';
                          
//     if(!mail($email, $subject, $message)){
//         echo 'MAIL NOT SENT!';
//     }
//     }
?>
