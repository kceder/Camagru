<?php
	session_start();
	require_once('connect.php');
	$login = htmlspecialchars($_POST['login']);
	$passwd = htmlspecialchars($_POST['passwd']);
	$permission = verify($login, $passwd);
	if ($permission === 2) {
		$_SESSION['logged_in_user'] = $login;
        header('Location: home.php');
	}
    else if ($permission === 1) 
		header('Location: ../index.php?error=1');
	else if ($permission === 0)
		header('Location: ../index.php?error=2');
	function verify($login, $passwd)
	{
		$ret = 0;
		try
		{
			$con = connect();
			$sql = "SELECT username, passwd, active FROM users";
			$stmt = $con->query($sql);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($result)
			{
				foreach ($result as $key)
				{
					$input_passwd = hash('whirlpool', $passwd);
					if ($key['username'] == $login && $key['passwd'] == $input_passwd)
					{
						$ret = 1;
					}
                    if ($key['username'] == $login && $key['passwd'] == $input_passwd && $key['active'])
					{
						$ret = 2;
					}
				}
			}
		}
		catch(PDOException $e) {
            echo 'NO!'; }
		return $ret;
	}
?>