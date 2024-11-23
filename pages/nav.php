<?php
  session_start();
  $nav=[];
  if(isset($_SESSION["user"])){
    if ($_SESSION["user"][1]=="Doctor") {
    $nav =[["../doc/docapps.php","Appointments"],
          ["../doc/docpatients.php","Patients"]];
    $files = scandir("../doc");
    $files = array_diff($files, array('.', '..'));
    if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
    }
  }
  if ($_SESSION["user"][1]=="Nurse") {
    $nav =[["../nurse/viewpatients.php","Dashboard"],
    ["../nurse/rooms.php","Rooms"],
  ["../nurse/tasks.php","Tasks"],
  ["../nurse/medstock.php","Medications Stock"]];
  $files = scandir("../nurse");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Pharmacist") {
    $nav =[["../phar/dashboard.php","Dashboard"],
    ["../phar/pharmacy.php","Inventory"],
    ["../phar/medtransaction.php","Transaction History"],
    ["../phar/indispense.php","Dispense Inhouse"]];
    $files = scandir("../phar");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Lab Tech") {
    $nav =[["../lab/labs.php","Labs Requests"],["../lab/labhist.php","Labs History"]];
  $files = scandir("../lab");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Front Desk") {
    $nav =[["../desk/appointments.php","Appointments"],
  ["../desk/viewpatients.php","Patients"],
["../desk/vitals.php","Vitals"]];
  $files = scandir("../desk");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Cashier") {
    $nav =[["../cashier/billpatients.php","Patients"]];
  $files = scandir("../cashier");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  }else{
    echo "Test";
    header("Location: ../index.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Elimmas</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
</head>
<body>
  
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href=<?php $nav[0]?>><img src="../../assets/images/logo.svg" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini" href=<?php $nav[0]?>><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="profile-name">
              <h5 class="mb-0 font-weight-normal"><?php echo $_SESSION["user"][2]?></h5>
              <span><?php echo $_SESSION["user"][1]?></span>
            </div>
          </div>
          <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-settings text-primary"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small"> Change Password</p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-onepassword  text-info"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-calendar-today text-success"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
              </div>
            </a>
          </div>
        </div>
      </li>
      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>
      <?php  
    for ($i=0; $i < count($nav); $i++) { 
      echo " 
      <li class='nav-item menu-items'>
        <a class='nav-link' href='".$nav[$i][0]."'>
          <span class='menu-icon'>
            <i class='mdi mdi-speedometer'></i>
          </span>
          <span class='menu-title'>".$nav[$i][1]."</span>
        </a>
      </li>";
    }
  ?>
      
  </nav>

        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href=<?php $nav[0]?>><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            
            <ul class="navbar-nav navbar-nav-right">
              <div id ="create">

            </div>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $_SESSION["user"][2]?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href ="../signout.php">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        



<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    
<script>
   
  function openNav() {
    document.getElementById("mySidebar").style.left = "0";
    document.getElementById("openButton").style.visibility = "hidden";
  }

  function closeNav() {
    document.getElementById("mySidebar").style.left = "-200px";
    document.getElementById("openButton").style.visibility = "visible";
  }
  let inactivityTime = function () {
      let time;
      window.onload = resetTimer;
      window.onmousemove = resetTimer;
      window.onmousedown = resetTimer;  // catches touchscreen presses
      window.ontouchstart = resetTimer; // catches touchscreen swipes
      window.onclick = resetTimer;      // catches touchpad clicks
      window.onkeypress = resetTimer;   // catches keyboard activity
      window.addEventListener('scroll', resetTimer, true); // improved; see comments

      function logout() {
          // Redirect to logout URL or call a PHP script to destroy the session
          window.location.href = '../signout.php';
      }

      function resetTimer() {
          clearTimeout(time);
          time = setTimeout(logout, 1800000); // 30 minutes
      }
  };

  inactivityTime();
</script>

</body>
</html>
