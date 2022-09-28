<?php
    session_start();
    
    function email_sender($email, $name, $hash) {
        
        $subject = 'Verification';
        $message = '        Thanks for signing up '.$name.'!
        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
        
          
        Please click this link to activate your account:
        http://localhost:8080/camagru/link.php?email='.$email.'&hash='.$hash.'
          
        ';
                              
        if(!mail($email, $subject, $message)){
            echo 'MAIL NOT SENT!';
        }
        }
    function email_sender1($email, $name) {
        
        $subject = 'Someone commented on your picture!';
        $message = '        Hi '.$name.'!
        You have just received a comment on your Camagru picture.
        
          
        Go to Camagru and check it out!
        http://localhost:8080/camagru/home.php
          
        ';
                              
        if(!mail($email, $subject, $message)){
            echo 'MAIL NOT SENT!';
        }
        }
    function email_sender2($email, $name) {
        
        $subject = 'Someone liked your picture!';
        $message = '        Hi '.$name.'!
        Someone just liked your picture on Camagru.
        
          
        Go to Camagru and check it out!
        http://localhost:8080/camagru/home.php
          
        ';
                              
        if(!mail($email, $subject, $message)){
            echo 'MAIL NOT SENT!';
        }
        }
?>