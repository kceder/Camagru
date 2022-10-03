<?php
session_start();
if(!isset($_SESSION['logged_in_user']))
    header('Location: ../index.php');
else {
    session_destroy();
    header('Location: home.php');
}
?>