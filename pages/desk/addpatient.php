<!DOCTYPE html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <!-- End layout styles -->
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
  </head>
  <body>
  <div class='container-scroller'>
  
    <?php include '../nav.php';?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Current Patients</h4>
                    
    <div class="form-container">
        <h2>Patient Information Form</h2>
        <form action="process_form.php" method="post">
        
        <div class="form-group">
            <label for="FName">First Name:</label>
            <input type="text" id="FName" name="FName" required>
        </div>
        <div class="form-group">
        <label for="LName">Last Name:</label>
        <input type="text" id="LName" name="LName" required>
        </div>
        <div class="form-group">
        <label for="DOB">Date of Birth:</label>
        <input type="date" id="DOB" name="DOB" required>
</div>
<div class="form-group">
        <label>Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>     
</div>
<div class="form-group">
        <label for="financial_type">Financial Type:</label>
        <input type="text" id="financial_type" name="financial_type" required>
</div>

<div class="form-group">
        <label for="guardian_fname">Guardian's First Name:</label>
        <input type="text" id="guardian_fname" name="guardian_fname">
    </div>
    <div class="form-group">
        <label for="guardian_lname">Guardian's Last Name:</label>
        <input type="text" id="guardian_lname" name="guardian_lname" >
    </div>
    <div class="form-group">
        <label>Marital Status:</label>
        <select id="marital_status" name="marital_status" required>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
        </select>
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" cols="50" required></textarea>
    </div>
    <div class="form-group">
        <label for="patient_phone">Patient's Phone:</label>
        <input type="tel" id="patient_phone" name="patient_phone" required>
    </div>
    <div class="form-group">
        <label for="patient_email">Patient's Email:</label>
        <input type="email" id="patient_email" name="patient_email">
    </div>
    <div class="form-group">
        <label for="guardian_phone">Guardian's Phone:</label>
        <input type="tel" id="guardian_phone" name="guardian_phone">
    </div>
    <div class="form-group">
        <label for="guardian_email">Guardian's Email:</label>
        <input type="email" id="guardian_email" name="guardian_email" >
    </div>
    <div class="form-group">
        <label for="referred_by">Referred By:</label>
        <input type="text" id="referred_by" name="referred_by">
    </div>
    <div class="form-group">
        <label for="employment">Employment:</label>
        <input type="text" id="employment" name="employment" >
    </div>
    <div class="form-group">
        <label for="special_codes">Special Codes:</label>
        <input type="text" id="special_codes" name="special_codes">
    </div>
        <button class="form-button" type="submit" value="Submit">Submit</button>
    </form>
    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class='footer'>
            <div class='d-sm-flex justify-content-center justify-content-sm-between'>
              <span class='text-muted d-block text-center text-sm-left d-sm-inline-block'>Copyright © bootstrapdash.com 2020</span>
              <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'> Free <a href='https://www.bootstrapdash.com/bootstrap-admin-template/' target='_blank'>Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>

    
</body>
</html>