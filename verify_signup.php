<?php
	session_start();
    include('signup.php');
    require_once('send_email.php');
    require_once('connect.php');
    require_once('email_check.php');
    require_once('passwd_check.php');
    require_once('user_check.php');
    $new_user = htmlspecialchars($_POST['login']);
    $new_passwd = htmlspecialchars($_POST['passwd']);
    $new_passwd2 = htmlspecialchars($_POST['passwd2']);
    $new_email = htmlspecialchars($_POST['email']);

    if($_POST['login'] && $_POST['passwd'] && $_POST['passwd2'] === $_POST['passwd'] && $_POST['email'] && $_POST['submit'] && $_POST['submit'] === 'OK'){
        
        if (!user_check($new_user)) {
            return ;
        }
        else if (!passwd_check($new_passwd)){
            echo 'Password should be at least 8 characters and has to include at least one upper and lower case letter, one number, and one special character!';
        }
        else if (email_check($new_email)) {
            return ;
        }
        else {
            $new_passwd = hash('whirlpool', $new_passwd);
            try
            {
                $active = 0;
                $conn = connect();
                $stmt = $conn->prepare("INSERT INTO users (username, passwd, email, email_verif_link, active)
                                        VALUES (:new_user, :new_passwd, :new_email, :email_verif_link, :active)");
                $stmt->bindParam(':new_user', $new_user, PDO::PARAM_STR);
                $stmt->bindParam(':new_passwd', $new_passwd, PDO::PARAM_STR);
                $stmt->bindParam(':new_email', $new_email, PDO::PARAM_STR);
                $email_hash = md5(rand(0,1000));
                $stmt->bindParam(':email_verif_link', $email_hash, PDO::PARAM_STR);
                $stmt->bindParam(':active', $active, PDO::PARAM_STR);
                $stmt->execute();

                email_sender($new_email, $new_user, $email_hash);
                header('Location: ./email_verif.php');
            }
            catch(PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            $conn = null;
        }
    }
    else {
        echo 'NICE TRY!';
    }
?>