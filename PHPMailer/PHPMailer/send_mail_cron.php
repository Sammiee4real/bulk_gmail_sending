<?php    require_once('../../config/database_functions.php');         
         use PHPMailer\PHPMailer\PHPMailer;
         use PHPMailer\PHPMailer\Exception;
         //Load composer's autoloader
         require 'mailer/vendor/autoload.php';
         $mail = new PHPMailer(true); 
         cron_mail_sending($mail);

 ?>