<?php
    require_once('connect.php');

    function user_check($user) {
        $conn = connect();
        $sql = "SELECT username FROM users WHERE BINARY username='$user'";
        $stmt = $conn->query($sql);
        $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($match) {
            return 'This username is already taken!';
        }
        else if (!preg_match('/^[A-Za-z0-9]{4,13}$/', $user) ) {
            $message = 'Username can only include letters and numbers, and it must be 4 - 13 characters long';
            return $message;
        }
        else
            return 0;
    }
?>