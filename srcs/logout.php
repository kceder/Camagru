<?php
session_start();
if(!$_SESSION['logged_in_user'])
    header('Location: ../index.php');
else {
    $_SESSION = array();
    session_destroy();
    header('Location: home.php');
}
?>