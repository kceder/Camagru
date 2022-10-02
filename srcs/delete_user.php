<?php
    session_start();
    require_once('connect.php');
    require_once('verify_passwd.php');
    if (!isset($_SESSION['logged_in_user']))
        header('Location: ../index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru</title>
    <p class="login"><?php if($_SESSION['logged_in_user'])
            echo 'Logged in as: '.$_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">CAMERA</a> | 
        <a class="logout" href="logout.php">LOG OUT</a>
    </div>

</head>
<style>
    .confirm-form {
        text-align: center;
        margin-top: 10%;
        background: #f0ebe5;
        border-width: 4px;
        border-style: double;
        border-color: black;
        border-radius: 5px 5px 5px 5px;
        padding: 20px;
        width: 60%;
        margin-left: auto;
        margin-right: auto;
    }
    .login {
        font-style: italic;
        margin-left: 9px;
        font-size: 1.5vh;
    }
    .headers {
        font-size: 2.4vh;
        color: black;
        text-align: center;
        padding: 15px 25px;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: center;
    }
    body {
        background: rgb(94,190,196);
        background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
    }
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: underline; }
    a:active { text-decoration: underline; }
    a{ color: black;}
    .footer {
        font-style: italic;
        margin-right: 9px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
    }
    .confirm-button {
            background: #f0ebe5;
            border-width: 1px;
            border-radius: 5px 5px 5px 5px;
            cursor: pointer;
	        text-transform: uppercase;
	        box-shadow: 0px 2px 6px 0px rgba(0, 0, 0, 0.25);
        }
    .confirm-button:hover {
        background: #d4cbc1;
    }
    .message1 {
        text-align: center;
        font-style: bold;
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

</style>
<body>
    <div class="main">
        <p>Permanently delete your account and all the data?</p>
        <form class="form" action="delete_user.php" method="POST">
            Give password to confirm: <input class="" type="password" name="passwd" value=""/>
            <br><br>
            <input class="button" type="submit" name="YES" value="CONFIRM" style="background:#ffaeae;">
            <input class="button" type="submit" name="NO" value="GO BACK">
        </form>
    </div>
    <footer class="footer">
        <br>
        <span>kceder @ HIVE Helsinki 2022</span>
    </footer>
</body>
</html>
<?php
    if(!isset($_SESSION['logged_in_user']))
        header('Location: index.php');
    if (isset($_POST['YES']) &&$_POST['YES'] === 'CONFIRM'){
        $username = $_SESSION['logged_in_user'];
        $passwd = $_POST['passwd'];
        if(verify($username, $passwd)){
            $conn = connect();
            $stmt = $conn->prepare("DELETE FROM image_comments WHERE username = '$username';
            DELETE FROM image_likes WHERE username = '$username';
            DELETE FROM user_images WHERE username = '$username';
            DELETE FROM users WHERE username = '$username'");
            $stmt->execute();
            print_r($_POST['submit']);
            $_SESSION = array();
            header('Location: home.php');
        }
        else {
            echo "<html><p class='message1'>Incorrect Password!</p></html>";
        }
    }
    else if (isset($_POST['NO']) && $_POST['NO'] === 'GO BACK') {
        header('Location: edit.php');
    }
?>