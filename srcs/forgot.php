<?php
	session_start();
    require_once('connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Camagru</title>
        <h1>RECOVER PASSWORD</h1>
	</head>
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
		width: 20vw;
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
	<div class="main">
			<form class="form" action="" method="POST">
				<br/>
				<br/>
				Give your email to recover password <br><br><input class="elem" type="text" name="email" value=""/>
				<input class="button" type="submit" name="submit" value="OK" id="submmit"/>
				<br/>
			</form>
			<br>
			<form class="form" action="../index.php">
                <input class="button" type="submit" value="Return"></input> 
            </form>
			<?php
			if (isset($_GET['error']))
            {
                if ($_GET['error'] == 1)
					echo "<p class='error'>Email not found. Please try again.</p>";
                if ($_GET['error'] == 2)
					echo '<p class="error">There was a problem sending the email. Try again</p>';
			}
			?>
	</div>
    <footer class="footer">
        <br>
        <span>kceder @ HIVE Helsinki 2022</span>
    </footer>
	</body>
</html>
<?php
    if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		try
		{
			$conn = connect();
			$sql = "SELECT username, passwd, email_verif_link FROM users WHERE `email`='$email'";
			$stmt = $conn->query($sql);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (isset($result[0]['username']))
				$username = $result[0]['username'];
			if (isset($result[0]['passwd']))
				$password = $result[0]['passwd'];
			if (isset($result[0]['email_verif_link']))
				$hash = $result[0]['email_verif_link'];
		}
		catch(PDOException $e)
		{
            echo $stmt . "<br>" . $e->getMessage();
		}
		if(!$result)
			header('Location: ./forgot.php?error=1');
		else {

			$subject = 'NEW PASSWORD';
			$message = '
			
			Please click this link to restrore your password:
			http://localhost:8080/camagru/srcs/restore.php?email='.$email.'&hash='.$hash.'&passwd='.$password.'
			
			';
			if(mail($email, $subject, $message))
				header('Location: ../index.php?message=4');
			else
				header('Location: ./forgot.php?error=2');
		}
    }
?>