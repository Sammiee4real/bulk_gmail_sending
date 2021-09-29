<?php    require_once('config/database_functions.php');         
         use PHPMailer\PHPMailer\PHPMailer;
         use PHPMailer\PHPMailer\Exception;
         //Load composer's autoloader
         require 'PHPMailer/PHPMailer/mailer/vendor/autoload.php';
         $mail = new PHPMailer(true); 
         // echo send_mail_to_a_recipient($mail,$sender_full_name,$sender_gmail,$sender_password,$recipient_email,$recipient_name);
         cron_mail_sending($mail);

 ?>