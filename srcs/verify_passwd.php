<?php
	if(!isset($_SESSION['logged_in_user']))
    	header('Location: ../index.php');
    require_once('connect.php');
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
					$passwd_hash = hash('whirlpool', $passwd);
					if ($key['username'] == $login && $key['passwd'] == $passwd_hash)
					{
						$ret = 1;
					}
                    if ($key['username'] == $login && $key['passwd'] == $passwd_hash && $key['active'])
					{
						$ret = 2;
					}
				}
			}
		}
		catch(PDOException $e) {
            echo 'Incorrect password!'; }
		return $ret;
	}
?>