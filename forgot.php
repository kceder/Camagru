<?php
	session_start();
    require_once('connect.php');
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CAMAAN</title>
        <h1>FORGOT PASSWORD</h1>
	</head>
	<body>
	<div class="">
			<form class="form" action="" method="POST">
				<br/>
				<br/>
				Email: <input class="new_user" type="text" name="email" value=""/>
				<input class="form submit" type="submit" name="submit" value="OK" id="submmit"/>
				<br/>
			</form>
		<a class="return" id="return" href="index.php">Return</a>
	</div>

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
			$username = $result[0]['username'];
			$password = $result[0]['passwd'];
			$hash = $result[0]['email_verif_link'];
		}
		catch(PDOException $e)
		{
            echo $stmt . "<br>" . $e->getMessage();
		}
		if(!$result)
			echo 'Email not found. Please try again.';
		else {

			$subject = 'NEW PASSWORD';
			$message = '
			
			Please click this link to restrore your password:
			http://localhost:8080/camagru/restore.php?email='.$email.'&hash='.$hash.'&passwd='.$password.'
			
			';
			if(mail($email, $subject, $message))
			echo 'An email has been sent to you. Please follow the link in the email to restore your password.';
			else
			echo 'There was a problem sending the email. Please try again or contact support.';
		}
    }
?>