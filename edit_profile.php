<?php
    session_start();
    if(!$_SESSION['logged_in_user'])
        header('Location: index.php');
    require_once('email_check.php');
    require_once('passwd_check.php');
    require_once('verify_passwd.php');
    require_once('user_check.php');
    $new_user = $_POST['new_username'];
    $old_passwd = $_POST['passwd'];
    $new_passwd = $_POST['new_passwd'];
    $new_passwd2 = $_POST['new_passwd2'];
    $new_email = $_POST['new_email'];
    $old_user = $_SESSION['logged_in_user'];
    if($new_user || $new_email || $new_passwd || $_POST['notif'] && $_POST['submit'] && $_POST['submit'] === 'SAVE' 
        && verify($old_user, $old_passwd)){
        if (!$new_email)
            $new_email = $_SESSION['email'];
        if (!empty($new_user)){
            if (!user_check($new_user) && $new_user !== $_SESSION['logged_in_user'])
                return ;
        }
        if ($new_passwd && $new_passwd != $new_passwd2) {
            include("edit.php");
            echo '<p class="error">New password and confirmation password do not match!</p>';
            return ;
        }
        if (!passwd_check($new_passwd) && $new_passwd) {
            include("edit.php");
            echo '<p class="error">Password should be at least 8 characters and has to include at least one upper and lower case letter, one number, and one special character!</p>';
        }
        else if (email_check($new_email) && (!$new_email == $_SESSION['email'])) {
            if (email_check($new_email == 2  && !$new_email == $_SESSION['email'])){
                include("edit.php");
                echo '<p class="error">This email address is alredy connected with Camagru!</p>';
            }
            return ;
        }
        else {
            if($_POST['notif'] == 'ON')
            $notif = '1';
            else
            $notif = '0';
            if (!$new_user)
                $new_user = $old_user;
            if (empty($new_passwd))
                $new_passwd = hash('whirlpool', $old_passwd);
            else
                $new_passwd = hash('whirlpool', $new_passwd);
            try {
                $conn = connect();
                $stmt = $conn->prepare("UPDATE users SET username=:new_user, passwd=:new_passwd, email=:new_email, noti_status=:noti_status
                                        WHERE username=:old_user");
                $stmt->bindParam(':new_user', $new_user, PDO::PARAM_STR);
                $stmt->bindParam(':new_passwd', $new_passwd, PDO::PARAM_STR);
                $stmt->bindParam(':new_email', $new_email, PDO::PARAM_STR);
                $stmt->bindParam(':old_user', $old_user, PDO::PARAM_STR);
                $stmt->bindParam(':noti_status', $notif, PDO::PARAM_STR);
                $stmt->execute();
                $_SESSION['username'] = $new_user;
                $_SESSION['passwd'] = $new_passwd;
                $_SESSION['email'] = $new_email;
                $_SESSION['logged_in_user'] = $new_user;
                update_tables($new_user, $old_user);
                header('Location: profile.php');

            }
            catch(PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            $conn = null;
        }
    }
    else {
        header('Location: edit.php');
    }

    function update_tables($new_user, $old_user) {
        $conn = connect();
        $stmt = $conn->prepare("UPDATE user_images
                                SET username=:new_user
                                WHERE username=:old_user");
        $stmt->bindParam(':new_user', $new_user, PDO::PARAM_STR);
        $stmt->bindParam(':old_user', $old_user, PDO::PARAM_STR);
        $stmt->execute();
        $conn = connect();
        $stmt = $conn->prepare("UPDATE image_comments
                                SET username=:new_user
                                WHERE username=:old_user");
        $stmt->bindParam(':new_user', $new_user, PDO::PARAM_STR);
        $stmt->bindParam(':old_user', $old_user, PDO::PARAM_STR);
        $stmt->execute();
        $conn = connect();
        $stmt = $conn->prepare("UPDATE image_likes
                                SET username=:new_user
                                WHERE username=:old_user");
        $stmt->bindParam(':new_user', $new_user, PDO::PARAM_STR);
        $stmt->bindParam(':old_user', $old_user, PDO::PARAM_STR);
        $stmt->execute();
    }
?>