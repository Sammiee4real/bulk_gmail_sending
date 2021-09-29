<?php  require_once('config/instantiated_files.php');
       include('inc/header.php'); 

      
      if(isset($_POST['cmd_create_user'])){

            $fname22 = $_POST['fname'];
            $lname22 = $_POST['lname'];
            $email22 = $_POST['email'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
          
            $create_admin_user =  create_admin_user($uid,$fname22,$lname22,$email22,$password,$cpassword);
            $create_admin_user_dec = json_decode($create_admin_user,true);
            if($create_admin_user_dec['status'] == 111){
                $msgp = "<div class='alert alert-success' >".$create_admin_user_dec['msg']."</div><br>";
              // $msg = "success";
            }else{
                  $msgp = "<div class='alert alert-danger' >".$create_admin_user_dec['msg']."</div><br>";
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
            <h1 class="h3 mb-0 text-gray-800">Add Admin User</h1>
             <a href="view_admin_users.php"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>All Users</a>
          </div>

      



    

        <div class="row">

          <div class="col-md-6">
              <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msgp)){

                echo $msgp;

                }?>
                </div>
                </div>
            <h6 class="m-0 font-weight-bold text-primary">Add Admin User</h6>
              <p class="mb-4">Create an admin user here</p>

           

              <form method="post" enctype="multipart/form-data" class="user" action="">
              <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
              
              <div class="form-group">
              <label>First Name</label>                                
              <input type="text" required="" class="form-control form-control-sm" value="" id="fname" name="fname">      
              </div>

              <div class="form-group">
              <label>Last Name</label>                                
              <input type="text" required="" class="form-control form-control-sm" value="" id="lname" name="lname">      
              </div>

              <div class="form-group">
              <label>Email(GMAIL)</label>                                
              <input type="email" required="" class="form-control form-control-sm" value="" id="email" name="email">      
              </div>

              <div class="form-group">
              <label>Password(GMAIL Password)</label>                                
              <input type="password" required="" class="form-control form-control-sm" value="" id="password" name="password">      
              </div>

              <div class="form-group">
              <label>Confirm Password(GMAIL Password)</label>                                
              <input type="password" required="" class="form-control form-control-sm" value="" id="cpassword" name="cpassword">      
              </div>

              <input type="submit" value="Create User" name="cmd_create_user" class="btn btn-danger btn-sm btn-block"/>
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
