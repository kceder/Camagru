<?php
session_start();
require_once('connect.php');
require_once('passwd_check.php');
$message = 0;
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    try
    {
        $email = $_GET['email'];
        $hash = htmlspecialchars($_GET['hash']);
        $conn = connect();
        $sql = "SELECT email_verif_link FROM users WHERE BINARY email='$email'";
        $stmt = $conn->query($sql);
        $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    if (isset($_POST['submit_pw']) && $_POST['passwd'] === $_POST['passwd2']) {

        $passwd = $_POST['passwd'];

        if(passwd_check($passwd)) {    
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
                        header('Location: ../index.php?message=5');
                    }
                    catch(PDOException $e)
                    {
                        echo $stmt . "<br>" . $e->getMessage();
                    }
                    $conn = null;
                }
            }
        }
        else {
            $message = 1;
        }
    }
    else if (isset($_POST['submit_pw']) && $_POST['submit_pw'] === 'OK') {
        $message = 2;
    }
}
?>
<!DOCTYPE html>
<html>
<title>Camagru</title>
    <style>
    .error {
        text-align: center;
    }
    h1 {
        margin-top: 5vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: center;
    }
    body {
        background: rgb(94,190,196);
        background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
    }
    .main {
        margin-top: 10vh;
        margin-left: auto;
        margin-right: auto;
        width: 40vh;
        text-align: left;
        background: white;
        padding: 20px;
        border-radius: 24px;
        border-style: groove;
        border-color: #5EBEC4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.7vh;
        background: #FDF5DF;
    }
    .button {
        background: #f0ebe5;
        border-width: 1px;
        border-radius: 5px 5px 5px 5px;
        cursor: pointer;
        text-transform: uppercase;
        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.25);
    }
    .new {
        width: 20vh;
        display: inline-block;
    }
    form {
        text-align: center;
    }
    .footer {
        font-style: italic;
        margin-right: 9px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
    }
    </style>
<body>
<h1>C A M A G R U</h1>
<div class="main">
    <form class="form" action="" method="POST">
        <br/>
        <br/>
        New password<br><input class="new_password" type="password" name="passwd" value=""/>
        <br>
        <br>
        New password again<br><input class="new_password" type="password" name="passwd2" value=""/>
        <br>
        <br>
        <input class="button" type="submit" name="submit_pw" value="OK"/>
        <br/>
    </form>
    <br>
    <br>
    <form class="form" action="../index.php">
        <input class="button" type="submit" value="Return"></input> 
    </form>
    <?php
    if ($message == 1) {
        echo '<p class="error">Password should be at least 8 characters and has to include 
        at least one upper and lower case letter, one number, and one special character!</p>';
    }
    if ($message == 2)
        echo '<p class="error">Passwords do not match!</p>';
    ?>
</div>
<footer class="footer">
        <br>
        <span>kceder @ HIVE Helsinki 2022</span>
    </footer>
</body>
</html>