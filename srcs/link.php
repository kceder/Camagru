<?php
    session_start();
    require_once('connect.php');
    
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        try
        {
            $email = $_GET['email'];
            $hash = $_GET['hash'];
            $conn = connect();
            $sql = "SELECT email_verif_link FROM users WHERE BINARY email='$email'";
            $stmt = $conn->query($sql);
            print_r($email);
            print_r($hash);
            $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($match)) {
                print_r($match);
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
                        header('Location: ../index.php?message=2');
					}
			} else {
                header('Location: ../index.php?message=3');
            }
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
                    
    } else {
        header('Location: ../index.php?message=3');
    }
    ?>