<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $counter = 0;
       $msgupdate = "";

      $my_sender_emails = get_rows_from_one_table_by_id('sender_ids_tbl','master_user_id',$email,'date_added');


       if(isset($_POST['cmd_schedule_mail'])){

            $recipient_emails = $_POST['recipient_emails'];
            $sender_emails = $_POST['sender_emails'];   
           
            $schedule_mail_sending = schedule_mail_sending($sender_emails,$recipient_emails);
            $dec = json_decode($schedule_mail_sending,true);
            $msgupdate .= "".$dec['msg']."<a href='send_mail.php'>refresh</a>";
            // $msgupdate .= ";
            $counter = $dec['counter'];
       }


?>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php include('inc/sidebar.php'); ?>
    <!-- Sidebar -->
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
       
          <?php include('inc/top_nav.php'); ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Send a Mail</h1>
            <!-- <a href="view_all_sns.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>All my sent mails</a> -->
          </div>

      



    

        <div class="row">

          <div class="col-md-9">
            
              <p class="mb-4">You can send mails here</p>

              <hr>
              
              <div class="row">
              <div class="col-md-12">
              <?php if(!empty($msgupdate)){

              echo "<span style='color:green;'>Schedule Results:&nbsp;".$counter." successful entries below</strong>&nbsp;|<a href='send_mail.php'> refresh</a>".$msgupdate."<hr>";

              }?>
              </div>
              </div>

              <form method="post" enctype="multipart/form-data" class="user" action="">
              <h6 class="m-0 font-weight-bold text-primary">Send a Mail (select from a list of your sender ids)</h6>
              <div class="form-group">
                                        
              
              <select required="" multiple="multiple" class="form-control form-control-sm js-example-basic-multiple2" name="sender_emails[]" id="sender_emails">
                     <?php 
                     if($my_sender_emails == null){
                        echo 'No record found';
                     }else{ 
                        // echo "<option value=''>select a Sender ID</option>";  
                        foreach($my_sender_emails as $my_sender_email){
                      ?>
                       <option value="<?php echo $my_sender_email['sender_email']; ?>"><?php echo $my_sender_email['sender_email']; ?></option>
                    <?php
                        }
                     } ?>
              </select>
              </div>
              
              <div class="form-group">
              <label>Enter Recipients' Emails(Copy and Paste with a line separation)</label>                                
                  <textarea required="" id="recipient_emails" name="recipient_emails" class="form-control form-control-sm" cols="50" rows="10"></textarea>
              </div>

              <input type="submit" value="Schedule Mail Sending Now" name="cmd_schedule_mail" class="btn btn-primary btn-sm btn-block"/>
              </a>
              </form>


          </div>
          
              


        </div>


      



          <!-- Content Row -->


          <!-- Content Row -->
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
    <?php include('inc/footer.php'); ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 <?php include('inc/scripts.php'); ?>
