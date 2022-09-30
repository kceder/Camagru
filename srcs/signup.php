<!DOCTYPE html>
<html>
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
        position: absolute;
        bottom: 0;
        width: 99%;
    }
	</style>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Camagru</title>
        <h1>NEW USER</h1>
	</head>
	<body>
	<div class="main">
			<form class="form" action="verify_signup.php" method="POST">
				<br/>
				<br/>
				New username<br><input class="new" type="text" name="login" value=""/>
				<br/>
				<br/>
				Password<br><input class="new" type="password" name="passwd" value=""/>
                <br>
                <br>
				Password again<br><input class="new" type="password" name="passwd2" value=""/>
                <br>
                <br>
				Email<br><input class="new" type="text" name="email" value=""/>
				<br>
				<br>
				<input class="button" type="submit" name="submit" value="OK"/>
				<br/>
			</form>
			<br>
			<form class="form" action="../index.php">
                <input class="button" type="submit" value="Return"></input> 
            </form>
	</div>
    <footer class="footer">
        <br><hr>
        <span>Author: kceder @ HIVE Helsinki 2022</span>
    </footer>
	</body>
</html>
