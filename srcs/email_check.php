<?php
    function email_check($email) {
        $conn = connect();
        $sql = "SELECT email FROM users WHERE BINARY email='$email'";
        $stmt = $conn->query($sql);
        $match = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($match) {
            return 2;
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }
        else {return 0;}
    }
?>