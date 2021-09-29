<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
     
      $my_sender_emails = get_rows_from_one_table_by_id('sender_ids_tbl','master_user_id',$email,'date_added');


        if(isset($_GET['entry_id'])){
             $entry_id = $_GET['entry_id'];
           
            $delete_entry =  delete_entry($entry_id);
            $delete_entry_dec = json_decode($delete_entry,true);
            if($delete_entry_dec['status'] == 200){
            $msg = "<div class='alert alert-success' >".$delete_entry_dec['msg'].". Redirecting shortly...</div><br>";
            header('Refresh: 3; url=view_sender_ids.php');
            }else{
            $msg = "<div class='alert alert-danger' >".$delete_entry_dec['msg']."</div><br>";
            // $msg = "failed";
            }
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
            <h1 class="h3 mb-0 text-gray-800">My Sender IDs: (<?php echo  $my_sender_emails == null ? '0': count($my_sender_emails); ?>)</h1>
           <a href="add_sender_emails.php"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Add Sender ID(s)</a>
       
          </div>

        



        <div class="row">
        <div class="col-md-12">
        <?php if(!empty($msg)){

        echo $msg;

        }?>
        </div>
        </div>


        

          <h6 class="m-0 font-weight-bold text-primary">My Sender IDs</h6>
          <p class="mb-4">Below is a list of all admin users</p>

            <div class="card shadow mb-4">
            <!-- <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered example" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Sender Email</th>
                      <th>Sender Password</th>
                      <th>Date Added</th>
                      <th></th>
                    </tr>
                  </thead>
                
                  <tbody>
                   
                    <?php
                     $sn = 1; 
                    
                     if($my_sender_emails == null){
                        echo 'No record found';
                     }else{
                    foreach($my_sender_emails as $my_sender_email){
                        $entry_id = $my_sender_email['entry_id'];
                        $sender_email = $my_sender_email['sender_email'];
                        $sender_password = $my_sender_email['sender_password'];
                        $date_created = $my_sender_email['date_added'];
                       ?>
                    <tr>

                      <td><?php echo $sn; ?></td>
                      <td><?php echo $sender_email; ?></td>
                      <td><?php echo $sender_password; ?></td>
                      <td><?php echo $date_created; ?></td>
                      <td><a href="view_sender_ids.php?entry_id=<?php echo $entry_id; ?>" class="btn btn-danger btn-sm">delete</a></td>
                              
                    
                     </tr>
                  <?php  $sn++;  }

                  } ?>
                 
                </tbody>
                </table>
              </div>
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
