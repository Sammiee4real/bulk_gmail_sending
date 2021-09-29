<?php $sms_sender_id = 'Acespot';//values in this script should be changed by app configureation
$app_domain = $_SERVER['HTTP_HOST'];
$app_name = 'Acespot';
$app_slug = 'Acespot';
$app_link = $_SERVER['HTTP_HOST'];
$app_domain_root= $_SERVER['HTTP_HOST'];
date_default_timezone_set('Africa/Lagos');


define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB_NAME", "bulk_email_sending_db");

$gmail_smtp_server = "smtp.gmail.com";
$gmail_smtp_name = "theloggedinname";
$gmail_smtp_server = "theloggedinuseremail";
$gmail_smtp_server = "theloggedinusergmailpassword";
$gmail_smtp_tls = 587;
$gmail_smtp_ssl = 465;


// $uploads_path = "C:/wamp64/www/eac/api/";

?>
