<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <!-- <i class="fas fa-laugh-wink"></i> -->
          <i class="fas fa-money"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Send MAILS <!-- <sup>2</sup> --></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="home.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>
      <!-- Nav Item - Charts -->

   
      
      <li class="nav-item">
        <a class="nav-link" href="send_mail.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Send Mail</span></a>
      </li>

     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>My Sender IDs</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
     
            <a class="collapse-item" href="add_sender_emails.php">Add Sender ID(s)</a>    
       
            <a class="collapse-item" href="view_sender_ids.php">View Sender IDs</a>
          </div>
        </div>
        </li>


        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Users</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
         <?php if($email == 'admin@gmail.com'){ ?>
            <a class="collapse-item" href="create_users.php">Create Users</a>    
         <?php } ?>
            <a class="collapse-item" href="view_admin_users.php">View Users</a>
          </div>
        </div>
        </li>



      

       <li class="nav-item">
        <a class="nav-link" href="profile.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Profile</span></a>
      </li>

    
      <!-- Divider -->
      <hr class="sidebar-divider">

 

          <li class="nav-item">
        <a class="nav-link" href="./logout.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Logout</span></a>
      </li>


  

    </ul>