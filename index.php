<?php
	session_start();
    require_once("./config/setup.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Camagru</title>
	</head>
	<style>
    .error {
        text-align: center;
    }
    .guest-link {
		margin-top: 2vh;
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
		font-size: 3.5vh;
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
    .footer {
        font-style: italic;
        margin-right: 20px;
        font-size: 1.5vh;
        text-align: right;
        color: #9ec2bd;
        position: absolute;
        bottom: 0;
        width: 99%;
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
        font-size: 1.9vh;
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
    .elem {
		width: 20vh;
		display: inline-block;
	}
	form {
		text-align: center;
	}
	</style>
    <h1>C A M A G R U</h1>
    <div class="headers">
    </div>
	<body>
	<div class="main">
			<form class="form" action="./srcs/login.php" method="POST">
				<br/>
				<br/>
				Username<br><input class="elem" type="text" name="login" value=""/>
				<br/>
				<br/>
				Password<br><input class="elem" type="password" name="passwd" value=""/>
				<br>
				<br>
				<input class="button" type="submit" name="submit" value="OK"/>
				<br/>
				<br>
				<br>
			</form>
			<form action="srcs/signup.php">
				<input class="button" type="submit" value="SIGN UP"></input>
			</form>
			<form action="srcs/forgot.php">
				<input style="font-size:x-small;" class="button" type="submit" value="Forgot your password?"></input>
			</form>
            <?php
            if (isset($_GET['error']))
            {
                if ($_GET['error'] == 1)
                    echo "<p class='error'>Please verify your email address!</p>";
                if ($_GET['error'] == 2)
                    echo "<p class='error'>Wrong password or username!</p>";
            }
            if (isset($_GET['message']))
            {
                if ($_GET['message'] == 1)
                    echo "<p class='error'>Verification email has been sent to your email!</p>";
                if ($_GET['message'] == 2)
                    echo "<p class='error'>Your account has been activated.</p>";
                if ($_GET['message'] == 3)
                    echo "<p class='error'>Invalid approach, please use the link that has been send to your email.</p>";
                if ($_GET['message'] == 4){
                    echo '<p class="error">An email has been sent to you. 
                    Please follow the link in the email to restore your password.</p>';
                    }
                if ($_GET['message'] == 5)
                    echo "<p class='error'>Your password has been succesfully reset!</p>";
            }
            ?>
	</div>
	<div class="guest-link">
		<a href="srcs/home.php">Browse Camagru as a guest</a>
	</div>
    <footer class="footer">
        <span>kceder @ HIVE Helsinki 2022</span>
    </footer>
</body>
</html>
