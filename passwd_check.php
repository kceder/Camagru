<?php
    session_start();
    function passwd_check($new_passwd){
        $uppercase = preg_match('@[A-Z]@', $new_passwd);
        $lowercase = preg_match('@[a-z]@', $new_passwd);
        $number    = preg_match('@[0-9]@', $new_passwd);
        $specials = preg_match('@[^\w]@', $new_passwd);

        if(!$uppercase || !$lowercase || !$number || !$specials || strlen($new_passwd) < 8) {
            return 0;
        }
        else
            return 1;
    }
?>