<?php
    session_start();
    require_once('connect.php');

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'] && $_GET['passwd'])){
        try
        {
            $email = htmlspecialchar($_GET['email']);
            $hash = htmlspecialchars($_GET['hash']);
            $old_passwd = htmlspecialchars($_GET['passwd']);
            $conn = connect();
            $sql = "SELECT email_verif_link FROM users WHERE BINARY email_verif_link='$hash'";
            $stmt = $conn->query($sql);
            $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if($match > 0) { ?>
                <!DOCTYPE html>
                <html>
                <body>
                <h1>C A M A G R U</h1>
                <div class="">
			        <form class="form" action="" method="POST">
                        <br/>
                        <br/>
                        New password: <input class="new_password" type="password" name="passwd" value=""/>
                        <br>
                        <br>
                        New password again: <input class="new_password" type="password" name="passwd2" value=""/>
                        <input class="form submit" type="submit" name="submit_pw" value="OK"/>
                        <br/>
			        </form>
		                <a class="return" id="return" href="index.php">Return</a>
                </div>
                </body>
                </html>
                <?php
                if (isset($_POST['submit_pw']) && $_POST['passwd'] == $_POST['passwd2']) {
                    $passwd = $_POST['passwd'];
                    $uppercase = preg_match('@[A-Z]@', $passwd);
                    $lowercase = preg_match('@[a-z]@', $passwd);
                    $number    = preg_match('@[0-9]@', $passwd);
                    $specials = preg_match('@[^\w]@', $passwd);
                    
                    if($uppercase && $lowercase && $number && $specials && strlen($passwd) >= 8) {
                        
                    foreach($match as $k)
                    {
                        if($hash == $k['email_verif_link'])
                        {
                            try
                            {
                                $passwd = hash('whirlpool', $passwd);
                                $conn = connect();
                                $stmt = $conn->prepare("UPDATE users SET passwd=:passwd WHERE email_verif_link=:email_verif_link");
                                $stmt-> bindParam(':email_verif_link', $hash, PDO::PARAM_STR);
                                $stmt-> bindParam(':passwd', $passwd, PDO::PARAM_STR);
                                $stmt->execute();
                                echo 'Your password has been succesfully reset!';
                                header( "refresh:5;url=index.php" );
                            }
                            catch(PDOException $e)
                            {
                                echo $stmt . "<br>" . $e->getMessage();
                            }
                            $conn = null;
                        }
                    }
                }else{
                    echo 'Password should be at least 8 characters and has to include at least one upper and lower case letter, one number, and one special character!'; }
                }
            }
        }
            catch(PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage();
            }
            $conn = null;
                        
        } else {
            echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
    }
?>