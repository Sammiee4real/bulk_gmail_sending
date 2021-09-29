<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
      $users = get_rows_from_one_table('users','date_created');
      
       if(isset($_POST['cmd_upload'])){
            //var_dump($_POST);
            $file_name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $tmpName = $_FILES['file']['tmp_name'];
            $type = $_FILES['file']['type'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $coverage = $_POST['coverage'];
            $version = $_POST['version'];
       

          $add_cleaned_data =  add_cleaned_data($uid,$file_name,$size,$tmpName,$type,$title,$description,$coverage,$version);
          $add_cleaned_data_dec = json_decode($add_cleaned_data,true);
          if($add_cleaned_data_dec['status'] == 111){
              $msg = "<div class='alert alert-success' >".$add_cleaned_data_dec['msg']."</div><br>";
            // $msg = "success";
          }else{
                $msg = "<div class='alert alert-danger' >".$add_cleaned_data_dec['msg']."</div><br>";
            // $msg = "failed";
          }


       }



        if(isset($_POST['cmd_delete'])){
             $unique_id = $_POST['unique_id'];
           
            $delete_upload =  delete_upload($unique_id);
            $delete_upload_dec = json_decode($delete_upload,true);
            if($delete_upload_dec['status'] == 111){
            $msg = "<div class='alert alert-success' >".$delete_upload_dec['msg'].". Redirecting shortly...</div><br>";
            // $msg = "success";
            header('Refresh: 3; url=all_my_uploads.php');
            }else{
            $msg = "<div class='alert alert-danger' >".$delete_upload_dec['msg']."</div><br>";
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
            <h1 class="h3 mb-0 text-gray-800">All Admin Users: (<?php echo count($users); ?>)</h1>
            <?php if($email == 'admin@gmail.com'){ ?><a href="create_users.php"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Create a User</a>
          <?php } ?>
          </div>

        



        <div class="row">
        <div class="col-md-12">
        <?php if(!empty($msg)){

        echo $msg;

        }?>
        </div>
        </div>


        

          <h6 class="m-0 font-weight-bold text-primary">All Admin Users</h6>
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
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Date Created</th>
                      <th></th>

                    </tr>
                  </thead>
                
                  <tbody>
                   
                    <?php
                     $sn = 1; 
                    
                     if($users == null){
                        echo 'No record found';
                     }else{
                    foreach($users as $user){
                        $fname = $user['fname'];
                        $email_user = $user['email'];
                        $admin_id2 = $user['unique_id'];
                        $lname = $user['lname'];
                        $date_created = $user['date_created'];
                       ?>
                    <tr>

                      <td><?php echo $sn; ?></td>
                      <td><?php echo $fname; ?></td>
                      <td><?php echo $lname; ?></td>
                      <td><?php echo $email_user; ?></td>
                      <td><?php echo $date_created; ?></td>
                      <td> <?php if($email == 'admin@gmail.com'){ ?> <a href="edit_user.php?usid=<?php echo $admin_id2; ?>">edit user</a><?php } ?></td>                  
                    
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
