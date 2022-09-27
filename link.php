<?php
    session_start();
    require_once('connect.php');
    
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        try
        {
            $email = $_GET['email'];
            $hash = $_GET['hash'];
            $conn = connect();
            $sql = "SELECT email_verif_link FROM users WHERE BINARY email_verif_link='$hash'";
            $stmt = $conn->query($sql);
            $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($match > 0) {
                foreach($match as $k)
				{
                    if($hash == $k['email_verif_link'])
					{
                        try
                        {
                            $conn = connect();
                            $active = 1;
                            $stmt = $conn->prepare("UPDATE users SET active=:active WHERE email_verif_link=:email_verif_link");
                            $stmt-> bindParam(':email_verif_link', $hash, PDO::PARAM_STR);
                            $stmt-> bindParam(':active', $active, PDO::PARAM_STR);
                            $stmt->execute();
                        }
                        catch(PDOException $e)
                        {
                            echo $stmt . "<br>" . $e->getMessage();
                        }
		                $conn = null;
	                }
                        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
					}
			}else{
                echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
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
    <a class="" href="index.php">Go to login</a>