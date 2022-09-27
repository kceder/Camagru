<?php
    require_once("config/setup.php");
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CAMAAN</title>
	    <a class="camagru" href="main_page.php">C A M A G R U</a>
	</head>
	<style>
		.camagru{
			color: black;
			font-size: 40;
		}
	</style>
	<body>
	<div class="">
			<form class="form" action="login.php" method="POST">
				<br/>
				<br/>
				Username: <input class="user" type="text" name="login" value=""/>
				<br/>
				<br/>
				Password: <input class="passwd" type="password" name="passwd" value=""/>
				<input class="form submit" type="submit" name="submit" value="OK"/>
				<br/>
			</form>
		<a class="create_user" id="create_user" href="signup.php">SIGN UP</a>
        </br>
        </br>
        <a class="forgotpw" href="forgot.php">Forgot your password?</a>
	</div>

	</body>
</html>
