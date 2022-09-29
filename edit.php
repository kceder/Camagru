<?php
    session_start();
    if(!$_SESSION['logged_in_user'])
        header('Location: index.php');
    require_once('connect.php');

    $conn = connect();
    $sql = "SELECT username, passwd, email FROM users WHERE BINARY username='$_SESSION[logged_in_user]'";
    $stmt = $conn->query($sql);
    $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['username'] = $match[0]['username'];
    $_SESSION['passwd'] = $match[0]['passwd'];
    $_SESSION['email'] = $match[0]['email'];
    $user = $_SESSION['username'];

?>
<html>
    <style>
    .error {
        text-align: center;
    }
    .login {
        font-size: 2.4vh;
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
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: underline; }
    a:active { text-decoration: underline; }
    a {
        color: black;
    }
    h1 {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: center;
    }
    body {
        background: rgb(94,190,196);
        background: radial-gradient(circle, rgba(94,190,196,1) 0%, rgba(253,245,223,1) 87%);
    }
    .main {
        margin-left: auto;
        margin-right: auto;
        width: 80vw;
        max-width: 700px;
        text-align: left;
        background: white;
        padding: 20px;
        border-radius: 24px;
        border-style: groove;
        border-color: #5EBEC4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.7vh;
        /* background: rgb(253,245,223);
        background: linear-gradient(138deg, rgba(253,245,223,1) 42%, rgba(94,190,196,1) 98%); */
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
    .input {
		width: 20vh;
		display: inline-block;
	}
    .footer {
        font-style: italic;
        margin-right: 9px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
    }
</style>
    <p class="login"><?php if($_SESSION['logged_in_user'])
            echo 'Logged in as: '.$_SESSION['logged_in_user'];?></p>
    <h1>C A M A G R U</h1>
    <div class="headers">
        <a href="home.php">HOME</a> | 
        <a href="profile.php">PROFILE</a> | 
        <a href="camera.php">CAMERA</a> | 
        <a class="logout" href="logout.php">LOG OUT</a>
    </div>
    <body>
        <br><br>
        <div class="main">
            <br>
            <form class="form" action="edit_profile.php" method="POST">
            <label class="switch">
            <label>Notifications:</label><br>
					<?php
                        $conn = connect();
						$stmt = $conn->query("SELECT noti_status FROM users WHERE username = '$user'");
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$noti_status = $result[0]['noti_status'];

						if ($noti_status == '1')
							echo '<input type="radio" class="notifications" name="notif" value="ON" checked/> ON  
							<br>
							<input type="radio" class="notifications" name="notif" value="OFF"/> OFF <br/>';
						else
							echo '</label>  <br>
							<input type="radio" class="notifications" name="notif" value="ON"/> ON
							<br>
							<input type="radio" class="notifications" name="notif" value="OFF" checked/> OFF <br/>';
					?>
            </label>
            <br>
           <p style="">Fill in information you wish to change</p>
           <br>
				New username <br><input class="" type="text" name="new_username" value=""/>
				<br/>
				<br/>
				New password <br><input class="" type="password" name="new_passwd" value=""/>
                <br>
                <br>
				Password again <br><input class="" type="password" name="new_passwd2" value=""/>
                <br>
                <br>
				New email <br><input class="" type="text" name="new_email" value=""/>
				<br/>
                <br/>
                <br/>
                <br/>
                Confirm changes by giving the old password <br><input class="" type="password" name="passwd" value=""/>
                <br><br>
				<input class="button" type="submit" name="submit" value="SAVE" style="background:#77efad;"/>
			</form>
			<form class="form" action="delete_user.php" method="POST">
                <input class="button" type="submit" name="submit" value="DELETE USER" style="background:#ffaeae;"/>
			</form>
            <form class="form" action="profile.php">
                <input class="button" type="submit" value="Return"></input> 
            </form>
    </div>
    <footer class="footer">
        <br><hr>
        <span>Author: kceder @ HIVE Helsinki 2022</span>
    </footer>
    </body>
</html>