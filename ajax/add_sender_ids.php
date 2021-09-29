<?php session_start();
      require_once('../config/database_functions.php'); 
      $uid2 = $_SESSION['uid'];
                
                  for($i = 0; $i < $_POST['counterr']; $i++){
                     $sender_email = $_POST['sender_email_'.$i];
                     $sender_pass = $_POST['sender_pass_'.$i];
                    
                       $add_sender_emails = add_sender_emails($uid2,$sender_email,$sender_pass);
                       $add_sender_emails_dec = json_decode($add_sender_emails,true);

                       echo $add_sender_emails_dec['msg'].'<br>';
                     
                  }

?>