<?php
  include "conn.php";
  session_start();
  if (isset($_POST["password"])) {
    $sql = "UPDATE `users` SET `password`='$_POST[new_password]' WHERE username = '".$_SESSION['user'][0]."' and password = '$_POST[password]';";
    if(!$conn->query($sql)){
      echo "Pasword Change Failed";
    }else{
      echo "Password Change Successful";
    }
    header("Location: ./index.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Change Password</h3>
                <form method="post">
                  <div class="form-group">
                    <label>Enter Current Password</label>
                    <input type="password" name = "password" class="form-control p_input">
                  </div>
                  <span id="error-message" style="display: none;">Passwords do not match</span>
                  <div class="form-group">
                    <label>Enter New Password</label>
                    <input type="password" name = "new_password" id="new-password" class="form-control p_input">
                  </div>
                  
                  <div class="form-group">
                    <label>Repeat New Password</label>
                    <input type="password" name = "confirm-password" id="confirm_password" class="form-control p_input">
                  </div>
                  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Confirm</button>
                  </div>
                  
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <script>
        let newpass = document.getElementById('new-password');
        let conpass = document.getElementById('confirm-password');
        let errmessage = document.getElementById('error-message');
        function checkpass() {
          errmessage.style.display="none";
          if(newpass.value!=conpass.value){
              errmessage.style.display="block";
          }
        }
        newpass.addEventListener('input',checkpass );
        conpass.addEventListener('input',checkpass );
    </script>
    <!-- endinject -->
  </body>
</html>