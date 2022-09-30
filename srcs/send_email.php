<?php
    session_start();
    
    function email_sender($email, $name, $hash) {
        
        $subject = 'Verification';
        $message = '        Thanks for signing up '.$name.'!
        Your account has been created. You can login after you have activated your account by pressing the link below.
        
          
        Please click this link to activate your account:
        http://localhost:8080/camagru/srcs/link.php?email='.$email.'&hash='.$hash.'
          
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
        http://localhost:8080/camagru/srcs/home.php
          
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
        http://localhost:8080/camagru/srcs/home.php
          
        ';
                              
        if(!mail($email, $subject, $message)){
            echo 'MAIL NOT SENT!';
        }
        }
?>