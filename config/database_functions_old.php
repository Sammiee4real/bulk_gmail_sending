<?php
$table = "";
$app_name = 'BULK';
require_once("db_connect.php");
require_once("config.php");
global $dbc;

// schedule_mail_sending.id

function delete_entry($entry_id){
    global $dbc;
    $sql = "DELETE FROM `sender_ids_tbl` WHERE `entry_id`='$entry_id'";
        $qry = mysqli_query($dbc,$sql);
        if($qry){
          return json_encode(array( "status"=>200, "msg"=>"Deletion of Sender ID was successful" ));
        }else{
          return json_encode(array( "status"=>102, "msg"=>"Failure" ));
        }
    
}


function add_sender_emails($uid,$new_sender_email,$new_sender_password){
  global $dbc;

  if($uid == "" ||  $new_sender_email == "" || $new_sender_password == "" ){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
  }else{
          $entry_id = unique_id_generator($uid.$new_sender_email.rand(111111,999999));
          $user_details = get_one_row_from_one_table_by_id('users','unique_id',$uid,'date_created');
          $email = $user_details['email'];
          $sql = "INSERT INTO `sender_ids_tbl` SET
                `entry_id` = '$entry_id',
                `master_user_id` = '$email',
                `sender_email` = '$new_sender_email',
                `sender_password` = '$new_sender_password',
                `date_added` = now()    
                ";
                $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
        
              if($query){
                     return json_encode(array( "status"=>200, "msg"=>"successful entry"));
                }else{
                     return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));
                }
  }
}

function get_total_rows_users($table){
    global $dbc;
    $total_pages_sql = "SELECT COUNT(id) FROM  `$table` WHERE `access_status`=1 ";
    mysqli_set_charset($dbc,'utf8');
    mysqli_query($dbc, "SET NAMES 'utf8'");
    mysqli_query($dbc, 'SET CHARACTER SET utf8');
    $result = mysqli_query($dbc,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    //$total_pages = ceil($total_rows / $no_per_page);
    return $total_rows;
}

//saves in the db with a status of 0
function schedule_mail_sending_v2($sender_emails,$recipient_emails,$added_by,$batch_value){
        global $dbc;
        $msg = "<hr>";
        $recipient_emails_arr = explode(PHP_EOL, $recipient_emails);
        $recipient_emails_arr2 =  array_map('trim', $recipient_emails_arr);
        $checker_counter = 0;

        // $steps
        //loop trhoug the sender_emails.
        //at the first senderemail loop, 
        //first check if count(numberofreceipient) <= 900, if so { loop throgh all receipients and end the entire loop process}
        //do count(numberofreceipient)/900 get possibile divisibles and then remainder e.g if 99000/900 equals 110(equivalent sender ids)

     if( count($recipient_emails_arr2) == 0 ){
             ///the whole process ends here
           $msg .= "No record found<br>";
     }else{

           //means this is count($recipient_emails_arr2) is greater than 900
            for($p = 0; $p < count($recipient_emails_arr2); $p++){
   
                $current_recipient_email = $recipient_emails_arr2[$p];
                $counttt = $p + 1;


                //step 1 which must run and checker_counter == 0 here
                if( $counttt <= $batch_value ){
                    $current_sender_email = $sender_emails[$checker_counter];
                    //then insert
                        $schedule_id =  unique_id_generator($current_sender_email.rand(111111111,999999999));
                                        $sql_insert = "INSERT INTO `schedule_mail_sending` SET
                                        `schedule_id`='$schedule_id',
                                        `sender_id`='$current_sender_email',
                                        `recipient_email`='$current_recipient_email',
                                        `sending_status`=0,
                                        `entered_by`='$added_by',
                                        `date_entered`=now()
                                    ";
                                    $qry_insert = mysqli_query($dbc,$sql_insert);
                                    if($qry_insert){
                                        $msg .= "schedule was successful:  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                        
                                    }else{
                                        $msg .= "schedule failed for  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                    }
                }


                //step 2
                else if( ($counttt > $batch_value) &&  ( ($counttt%$batch_value) == 1 )  ){
                    $checker_counter++;
                    $current_sender_email = $sender_emails[$checker_counter];
                    //then insert
                     $schedule_id = unique_id_generator($current_sender_email.rand(111111111,999999999));
                                        $sql_insert = "INSERT INTO `schedule_mail_sending` SET
                                        `schedule_id`='$schedule_id',
                                        `sender_id`='$current_sender_email',
                                        `recipient_email`='$current_recipient_email',
                                        `sending_status`=0,
                                        `entered_by`='$added_by',
                                        `date_entered`=now()
                                    ";
                                    $qry_insert = mysqli_query($dbc,$sql_insert);
                                    if($qry_insert){
                                        $msg .= "schedule was successful:  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                   
                                    }else{
                                        $msg .= "schedule failed for  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                    }
                }
                
             // total - current count  < batch(no increament)
             //default part i.e greater than 900, and not a multiple of 900 e.g 901,1001,1002,etc
             // else if( ($counttt > $batch_value) &&  ( ($counttt%$batch_value) != 0 )   ){
             else {
                  
                    $current_sender_email = $sender_emails[$checker_counter];
                    //then insert
                     $schedule_id = unique_id_generator($current_sender_email.rand(111111111,999999999));
                                        $sql_insert = "INSERT INTO `schedule_mail_sending` SET
                                        `schedule_id`='$schedule_id',
                                        `sender_id`='$current_sender_email',
                                        `recipient_email`='$current_recipient_email',
                                        `sending_status`=0,
                                        `entered_by`='$added_by',
                                        `date_entered`=now()
                                    ";
                                    $qry_insert = mysqli_query($dbc,$sql_insert);
                                    if($qry_insert){
                                        $msg .= "schedule was successful:  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                     
                                    }else{
                                        $msg .= "schedule failed for  Sender:".$current_sender_email.": Recipient:".$current_recipient_email."<br>";
                                    }
                }


               ////once all the sender ids are filled the loop is exited
               if(  ($counttt/$batch_value) == count($sender_emails)    ){
                      break;
                }




            }
     }


                    return json_encode(["status"=>200,"msg"=>$msg,"counter"=>$counttt ]);

       
 
        
   
}


//saves in the db with a status of 0
function schedule_mail_sending($sender_emails,$recipient_emails){
        global $dbc;
        $msg = "";
        $recipient_emails_arr = explode(PHP_EOL, $recipient_emails);
        $recipient_emails_arr2 =  array_map('trim', $recipient_emails_arr);
        $counter = 0;
       

    //check if sender id is o
        if(count($sender_emails) <= 0){
                   ///loop for each sender emails
          $msg .= "<div class='alert alert-danger'>No sender email was selected</div>";
       
        }else{
         
        $msg .= "<div class='alert alert-primary'>";
        ///loop for each sender emails
        for($k = 0 ; $k < count($sender_emails); $k++){

            for ($i = 0; $i < count($recipient_emails_arr2); $i++) {
                    $recipient_email = $recipient_emails_arr2[$i];
                    $this_sender_email =  $sender_emails[$k];
                    $schedule_id = unique_id_generator($recipient_emails.rand(111111111,999999999));
                    $sql_insert = "INSERT INTO `schedule_mail_sending` SET
                    `schedule_id`='$schedule_id',
                    `sender_id`='$this_sender_email',
                    `recipient_email`='$recipient_email',
                    `sending_status`=0,
                    `entered_by`='$this_sender_email',
                    `date_entered`=now()
                ";
                $qry_insert = mysqli_query($dbc,$sql_insert);
                if($qry_insert){
                    $msg .= "schedule was successful:  Sender:".$sender_emails[$k].": Recipient:".$recipient_email."<br>";
                     $counter++;
                }else{
                    $msg .= "schedule failed for ".$recipient_email."<br>";
                }
               
             }

         }
        

         $msg .= "</div>";  
        }

  
        
        return json_encode(["status"=>200,"msg"=>$msg,"counter"=>$counter]);
}




// function get_email_list($mail){
//     global $dbc;
//     $sql_get_senders = "SELECT * FROM `schedule_mail_sending` WHERE `sending_status`=0 GROUP BY `sender_id`";
//     $qry_get_senders = mysqli_query($dbc,$sql_get_senders) or die(mysqli_error($dbc));
//     $counter = 0;
//     $all_recipients_email_build = "";
//     while($row_senders = mysqli_fetch_array($qry_get_senders)){
//             //this is for each sender now
//             $sender_id = $row_senders['sender_id']; //i.e email which is gmail
//             $get_sender_det =   get_one_row_from_one_table_by_id('sender_ids_tbl','sender_email',$sender_id,'date_added');
//             //$sender_full_name = $get_sender_det['fname'].' '.$get_sender_det['lname'];       
//             $sender_password = $get_sender_det['sender_password']; //gmail password


//             $sql_get_recipients_per_sender = "SELECT * FROM `schedule_mail_sending` WHERE sender_id='$sender_id' AND `sending_status`= 0 LIMIT 100";
//             $qry_get_recipients_per_sender = mysqli_query($dbc,$sql_get_recipients_per_sender) or die(mysqli_error($dbc));
//             $count_recipients = mysqli_num_rows($qry_get_recipients_per_sender);
//             while($row_send = mysqli_fetch_array($qry_get_recipients_per_sender)){
//                  $counter++;
//                  $schedule_id = $row_send['schedule_id'];
//                  $each_recipient_email = $row_send['recipient_email'];

//                  if($counter == $count_recipients){
//                     $all_recipients_email_build .= $each_recipient_email;
//                  }else{
//                     $all_recipients_email_build .= $each_recipient_email.',';
//                  }
//             }

//           return $all_recipients_email_build;

//     } 
// }


///batches of 100 per hour i.e 9hours
function cron_mail_sending($mail){
    global $dbc;
    $sql_get_senders = "SELECT * FROM `schedule_mail_sending` WHERE `sending_status`=0 GROUP BY `sender_id`";
    $qry_get_senders = mysqli_query($dbc,$sql_get_senders) or die(mysqli_error($dbc));
    $ct_get_senders = mysqli_num_rows($qry_get_senders);
    $counter = 0;
    $all_recipients_email_build = "";
    if( $ct_get_senders == 0 ){
            echo json_encode(["status"=>103,"msg"=>'sorry, no record found at this moment']);
            echo "<br>";
    }else{
            while($row_senders = mysqli_fetch_array($qry_get_senders)){
            //this is for each sender now
            $sender_id = $row_senders['sender_id']; //i.e email which is gmail
            $get_sender_det =   get_one_row_from_one_table_by_id('sender_ids_tbl','sender_email',$sender_id,'date_added');
            $sender_password = $get_sender_det['sender_password']; //gmail password

            $sql_get_recipients_per_sender = "SELECT * FROM `schedule_mail_sending` WHERE sender_id='$sender_id' AND `sending_status`=0 LIMIT 100";
            $qry_get_recipients_per_sender = mysqli_query($dbc,$sql_get_recipients_per_sender) or die(mysqli_error($dbc));
            $count_recipients = mysqli_num_rows($qry_get_recipients_per_sender);
            while($row_send = mysqli_fetch_array($qry_get_recipients_per_sender)){
                 $counter++;
                 $schedule_id = $row_send['schedule_id'];
                 $each_recipient_email = $row_send['recipient_email'];
                 //$all_recipients_email_build = get_email_list($mail);

                  if($counter == $count_recipients){
                    $all_recipients_email_build .= $each_recipient_email.'_'.$schedule_id;
                 }else{
                    $all_recipients_email_build .= $each_recipient_email.'_'.$schedule_id.',';
                 }
            }


            $rand = rand(111111111111,99999999999);
                 $send_mail_to_a_recipient = send_mail_to_a_recipient($mail,$sender_id,$sender_id,$sender_password,$each_recipient_email,$each_recipient_email,$all_recipients_email_build);
                 $dec = json_decode($send_mail_to_a_recipient,true);
                 $dec_msg = $dec['msg'];
                 if($dec['status'] == 200){
                      echo json_encode(["status"=>200,"msg"=>'success']);
                      echo "<br>";

                 }else{
                     echo json_encode(["status"=>104,"msg"=>$dec_msg]);
                     echo "<br>";
                 }
         } 

    }
   
}


function send_mail_to_a_recipient($mail,$sender_full_name,$sender_gmail,$sender_password,$current_recipient_email,$recipient_name,$all_recipients_email){    
    global $dbc;                       
    try {
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = $sender_gmail;     
        $mail->Password = $sender_password;             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
 
        //Send Email
        $mail->setFrom($sender_gmail,$sender_full_name);
 
        //Recipients ///once this user gets mails, it means that sender mail is not yet blocked
        $mail->addAddress('aceviews@gmail.com');  

        //there will be a loop here
        $all_recipients_email_arr = explode(',',$all_recipients_email);
        $counter = 0;
        for($p=0; $p < count($all_recipients_email_arr); $p++){

           $counter++;
           $each_recipients_email = explode('_',$all_recipients_email_arr[$p])[0];
           $schedule_id = explode('_',$all_recipients_email_arr[$p])[1];
           $mail->addBCC($each_recipients_email);   
           $sqlupdate = "UPDATE `schedule_mail_sending` SET `sending_status`=1 WHERE `schedule_id`='$schedule_id'";
           $qryupdate = mysqli_query($dbc,$sqlupdate) or die(mysqli_error($dbc));

           // $sqllog = "UPDATE `schedule_mail_sending` SET `sending_status`=1 WHERE `schedule_id`='$schedule_id'";
           // $qryupdate = mysqli_query($dbc,$sqlupdate) or die(mysqli_error($dbc));

          
        }
        
        // $mail->addReplyTo('adebsholey4real@gmail.com', "John Peters");

        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = 'Welcome to Testing Subject New';
        $mail->Body    = '<p>This is a default body <b>in bold!</b> with an image below</p>'
                     .'<img width="70px" width="80px" src="cid:mail_image">';

        // $mail->addEmbeddedImage(dirname(__FILE__).'/banana.jpg','banana');
        $mail->addEmbeddedImage('../PHPMailer/mail_image.jpg','mail_image');

        $mail->send();
        
        $msg = "Message sent for ".$current_recipient_email;
        return json_encode(["status"=>200,"msg"=>$msg]);


    
    } catch (Exception $e) {
       // $msg =  'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
       $msg =  'Message could not be sent';
       return json_encode(["status"=>105,"msg"=>$msg]);
     }
 
}



function user_login($email,$password){
   global $dbc;
   $email = secure_database($email);
   $password = secure_database($password);
   $hashpassword = md5($password);

   $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$hashpassword' AND `role`=1";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   if($count === 1){
      $row = mysqli_fetch_array($query);
      $fname = $row['fname'];
      $lname = $row['lname'];
      $phone = $row['phone'];
      $email = $row['email'];
      $unique_id = $row['unique_id'];
      $access_status = $row['access_status'];

      if($access_status != 1){
                return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
      }else{
                return json_encode(array( 
                    "status"=>111, 
                    "user_id"=>$unique_id, 
                    "fname"=>$fname, 
                    "lname"=>$lname, 
                    "phone"=>$phone, 
                    "email"=>$email 
                  )
                 );

      }
    
   }else{
                return json_encode(array( "status"=>102, "msg"=>"Wrong username or password!" ));

   }
 

}


///////////////////
  function create_admin_user($uid,$fname,$lname,$email,$password,$cpassword){
        global $dbc;
        $table = 'users';
        $uid = secure_database($uid);
        $fname = secure_database($fname);
        $lname = secure_database($lname);
        $email = secure_database($email);
        $password = secure_database($password);
        $hashed_password = md5($password);
        //$img_url = "profiles/avatar.png";
       
        $unique_id = unique_id_generator($fname.$email);
        $unique_id2 = unique_id_generator($lname.$fname);
        $check_exist = check_record_by_one_param($table,'email',$email);

         // if($password != $cpassword){
         //        return json_encode(array( "status"=>103, "msg"=>"Password mismatch" ));
         // }

         if($check_exist){
                return json_encode(array( "status"=>109, "msg"=>"This email address exists" ));
         }
         else{
                if( $uid == "" || $fname == "" ||  $lname == "" || $email == "" || $password == "" || $cpassword == ""){
                  return json_encode(array( "status"=>101, "msg"=>"Empty field(s) found" ));
                }
                else if($password != $cpassword){
                  return json_encode(array( "status"=>104, "msg"=>"Password mismatch found" ));
                 }
                else{
                $sql = "INSERT INTO `users` SET
                `unique_id` = '$unique_id',
                `fname` = '$fname',
                `lname` = '$lname',   
                `email` = '$email',
                `role` = 1,
                `img_url`='profiles/default.jpg',
                `password_bare`= '$password',
                `password`= '$hashed_password',
                `date_created` = now()
                ";
                $query = mysqli_query($dbc, $sql);

                
                $sql2 = "INSERT INTO `sender_ids_tbl` SET
                `entry_id` = '$unique_id2',
                `master_user_id` = '$email',
                `sender_email` = '$email',   
                `sender_password` = '$password',
                `date_added` = now()
                ";
                $query2 = mysqli_query($dbc, $sql2);
            
              if($query == true && $query2 == true){
         

                 return json_encode(array( "status"=>111, "msg"=>"You have successfully added a new user"));

                }else{

                return json_encode(array( "status"=>100, "msg"=>"Something went wrong"));

                }


                }

         }


        
}

function secure_database($value){
    global $dbc;
    $new_value = mysqli_real_escape_string($dbc,$value);
    return $new_value;
}


function check_record_by_one_param($table,$param,$value){
    global $dbc;
    $sql = "SELECT id FROM `$table` WHERE `$param`='$value'";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
}  


function check_record_by_one_paramv2($table,$sql_param,$param,$value){
    global $dbc;
    $sql = "SELECT `$sql_param` FROM `$table` WHERE `$param`='$value'";
    $query = mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($query);
    if($count > 0){
      return true; ///exists
    }else{
      return false; //does not exist
    }
    
}  


function email_function($email, $subject, $content){
  $headers = "From: SOCU UPLOAD\r\n";
  @$mail = mail($email, $subject, $content, $headers);
  return $mail;
}


function unique_id_generator($data){
    $data = secure_database($data);
    $newid = md5(uniqid().time().rand(11111,99999).rand(11111,99999).$data);
    return $newid;
}

function update_profile($uid,$fname,$lname,$email){
     global $dbc;

     if ($fname == "" || $lname == "" ||  $email == "" ||  $uid == "") {

          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
     
     }else{

        $sql = "UPDATE `users` SET `fname`='$fname',`lname`='$lname',`email`='$email' WHERE `unique_id`='$uid'";
        $qry = mysqli_query($dbc,$sql);
        if($qry){
        return json_encode(array( "status"=>111, "msg"=>"Profile update was successful" ));

        }else{

        return json_encode(array( "status"=>102, "msg"=>"failure" ));

        }

     }
}

function update_password($uid,$password,$cpassword){
     global $dbc;

     if ($password == "" || $cpassword == "" || $uid == "") {

          return json_encode(array( "status"=>103, "msg"=>"Empty field(s) found" ));
     
     }

     else if($password != $cpassword){
          return json_encode(array( "status"=>103, "msg"=>"Password mismatch found" ));
     }

     else{
        $enc_password = md5($password);
        $sql = "UPDATE `users` SET `password`='$enc_password',`password_bare`='$password' WHERE `unique_id`='$uid'";
        $qry = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
        if($qry){

          $get_user_info =   get_one_row_from_one_table_by_id('users','unique_id',$uid,'date_created');
          $user_username = $get_user_info['username'];
          $user_email = $get_user_info['email'];

        return json_encode(array( "status"=>111, "msg"=>"Password reset was successful" ));

        }else{

        return json_encode(array( "status"=>102, "msg"=>"Password reset failed" ));

        }

     }
}


function get_rows_from_one_table($table,$order_option){
         global $dbc;
       
        $sql = "SELECT * FROM `$table` ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
           while($row = mysqli_fetch_array($query)){
             $row_display[] = $row;
           }
                          
            return $row_display;
          }
          else{
             return null;
          }
}

function get_rows_from_one_table_by_id($table,$param,$value,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             while($row = mysqli_fetch_array($query)){
                $display[] = $row;
             }              
             return $display;
          }
          else{
             return null;
          }
}


function check_profile_update($uid,$bank_name,$account_name,$account_no,$update_option){
   global $dbc;
   $sql = "SELECT * FROM users WHERE `unique_id`='$uid'";
   $qry = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($qry);
   if($count >= 1){
         
         if( ($bank_name == NULL || $account_name == NULL || $account_no == NULL) && $update_option == 0 ){
                return json_encode(array( "status"=>101, "msg"=>"To continue, kindly update your profile..." ));
         }else{
                return json_encode(array( "status"=>111, "msg"=>"Good Standing" ));

         }
   }  
}





function admin_login($email,$password){
   global $dbc;
   $email = secure_database($email);
   $password = secure_database($password);
   $hashpassword = md5($password);

   $sql = "SELECT * FROM users WHERE `email`='$email' AND `password`='$hashpassword' AND `role`=1";
   $query = mysqli_query($dbc,$sql);
   $count = mysqli_num_rows($query);
   if($count === 1){
      $row = mysqli_fetch_array($query);
      $fname = $row['fname'];
      $lname = $row['lname'];
      $phone = $row['phone'];
      $email = $row['email'];
      $unique_id = $row['unique_id'];
      $access_status = $row['access_status'];

      if($access_status != 1){
                return json_encode(array( "status"=>101, "msg"=>"Sorry, you currently do not have access. Contact Admin!" ));
      }else{
                return json_encode(array( 
                    "status"=>111, 
                    "user_id"=>$unique_id, 
                    "fname"=>$fname, 
                    "lname"=>$lname, 
                    "phone"=>$phone, 
                    "email"=>$email 
                  )
                 );

      }
    
   }else{
                return json_encode(array( "status"=>102, "msg"=>"Wrong username and password!" ));

   }
 

}


function get_one_row_from_one_table_by_id($table,$param,$value,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' ORDER BY `$order_option` DESC";
        mysqli_set_charset($dbc,'utf8');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        mysqli_query($dbc, 'SET CHARACTER SET utf8');
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }

function get_one_row_from_one_table_by_two_params($table,$param,$value,$param2,$value2,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }


    function get_one_row_from_one_table_by_three_params($table,$param,$value,$param2,$value2,$param3,$value3,$order_option){
         global $dbc;
        $table = secure_database($table);
        $sql = "SELECT * FROM `$table` WHERE `$param`='$value' AND `$param2`='$value2' AND `$param3`='$value3' ORDER BY `$order_option` DESC";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
             $row = mysqli_fetch_array($query);              
             return $row;
          }
          else{
             return null;
        }
    }




function  delete_record($table,$param,$value){
    global $dbc;
    $sql = "DELETE FROM `$table` WHERE `$param`='$value'";
    $query = mysqli_query($dbc,$sql);
    if($query){
      return true;
    }else{
      return false;
    }
}


function get_visible_rows_from_events_with_pagination($table,$offset,$no_per_page){
         global $dbc;
        $table = secure_database($table);
        $offset = secure_database($offset);
        $no_per_page = secure_database($no_per_page);
        $sql = "SELECT * FROM `events_tbl` WHERE visibility = 1 ORDER BY date_added DESC LIMIT $offset,$no_per_page ";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}

function get_visible_rows_from_events_with_limit($table,$limit){
         global $dbc;
        $table = secure_database($table);
       
        $sql = "SELECT * FROM `events_tbl` WHERE visibility = 1 ORDER BY date_added DESC LIMIT $limit";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}



function get_rows_from_one_table_with_pagination($table,$offset,$no_per_page){
         global $dbc;
        $table = secure_database($table);
        $offset = secure_database($offset);
        $no_per_page = secure_database($no_per_page);
        $sql = "SELECT * FROM `$table` ORDER BY date_added DESC LIMIT $offset,$no_per_page ";
        $query = mysqli_query($dbc, $sql);
        $num = mysqli_num_rows($query);
       if($num > 0){
            while($row = mysqli_fetch_array($query)){
                $row_display[] = $row;
                }
            return $row_display;
          }
          else{
             return null;
          }
}


function update_by_one_param($table,$param,$value,$condition,$condition_value){
  global $dbc;
  $sql = "UPDATE `$table` SET `$param`='$value' WHERE `$condition`='$condition_value'";
  $qry = mysqli_query($dbc,$sql);
  if($qry){
     return true;
  }else{
      return false;
  }
}