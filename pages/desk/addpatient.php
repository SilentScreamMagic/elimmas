<!DOCTYPE html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <!-- End layout styles -->
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
    <style>
      .step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}
input.invalid {
  background-color: #ffdddd;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}
.tab {
  display: none;
}
    </style>
  </head>
  <body>
  <div class='container-scroller'>
  
    <?php 
    include "../conn.php";
    include '../nav.php';
    if (isset($_POST["edit"])) {
      $sql = "SELECT * FROM patient WHERE pat_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $_POST["edit"]); // "i" = integer
      $stmt->execute();
      $result = $stmt->get_result();
      $pat = $result->fetch_assoc();
      $stmt->close();
  }

      ?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h3 class='card-title'>Add Patients</h3>
                    
      
        <form id ="form" class="form-sample" action="process_form.php" method="post">
          <div class="tab">
          <h4 >Patients info</h4>
            <div class="form-group row">
            <label class="col-sm-3 col-form-label" class="col-sm-3 col-form-label" for="FName">First Name:</label>
              <div class="col-sm-9">
                <input class="form-control" class="form-control" type="text" id="FName" name="FName" required value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat['FName'])."'" ?> required> 
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="LName">Last Name:</label>
            <div class="col-sm-9">
              <input class="form-control" type="text" id="LName" name="LName" required value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["LName"])."'" ?> required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="DOB">Date of Birth:</label>
            <div class="col-sm-9">
              <input class="form-control" type="date" id="DOB" name="DOB" required value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["DOB"])."'" ?> required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Gender:</label>
            <div class="col-sm-9">
                <select class="js-example-basic-single" style="width:100%" id="gender" name="gender" required>
                <option value="" <?php if(!isset($_POST["edit"])) echo "selected disabled" ?> >Gender</option> 
                  <option value="Male" <?php if(isset($_POST["edit"])&& $pat["gender"]=="Male") echo "selected" ?>>Male</option>
                  <option value="Female" <?php if(isset($_POST["edit"])&& $pat["gender"]=="Female") echo "selected" ?>>Female</option>
                </select> 
              </div>   
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Marital Status:</label>
              <div class="col-sm-9">
                <select class="js-example-basic-single" style="width:100%" id="marital_status" name="marital_status" placeholder = "Marital Status" required>
                  <option value="" <?php if(!isset($_POST["edit"])) echo "selected disabled" ?>>Marital Status</option>  
                  <option value="Single" <?php if(isset($_POST["edit"])&& $pat["marital_status"]=="Single") echo "selected" ?>>Single</option>
                  <option value="Married"<?php if(isset($_POST["edit"])&& $pat["marital_status"]=="Married") echo "selected" ?>>Married</option>
                  <option value="Divorced"<?php if(isset($_POST["edit"])&& $pat["marital_status"]=="Divored") echo "selected" ?>>Divorced</option>
                  <option value="Widowed"<?php if(isset($_POST["edit"])&& $pat["marital_status"]=="Widowed") echo "selected" ?>>Widowed</option>
                </select>
              </div> 
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="address">Address:</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="address" name="address" rows="4" cols="50" value= required><?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["address"])."'" ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="patient_phone">Patient's Phone:</label>
              <div class="col-sm-9">
                <input class="form-control" type="tel" id="patient_phone" name="patient_phone" required value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["patient_phone"])."'" ?> >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="patient_email">Patient's Email:</label>
              <div class="col-sm-9">
                <input class="form-control" type="email" id="patient_email"  name="patient_email" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["patient_email"])."'" ?>>
              </div>
            </div> 
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="employment">Employment:</label>
                <div class="col-sm-9">
                  <input class="form-control" type="text" id="employment" name="employment" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["employment"])."'" ?>>
                </div>
              </div>
          </div>
          <div class="tab">
          <h4>Emergency Contact</h4>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="emergency_fname">Emergency's First Name:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="emergency_fname" name="emergency_fname" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["emergency_fname"])."'" ?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="emergency_lname">Emergency's Last Name:</label>
              <div class="col-sm-9">
                <input class="form-control" type="text" id="emergency_lname" name="emergency_lname" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["emergency_lname"])."'" ?> >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="emergency_phone">Emergency's Phone:</label>
              <div class="col-sm-9">
                <input class="form-control" type="tel" id="emergency_phone" name="emergency_phone" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["emergency_phone"])."'" ?>>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="emergency_email">Emergency's Email:</label>
              <div class="col-sm-9">
                <input class="form-control" type="email" id="emergency_email" name="emergency_email" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["emergency_email"])."'" ?>>
              </div>
            </div>
          </div >
            <div class="tab">
            <h4>Other Info</h4>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="referred_by">Referred By:</label>
                <div class="col-sm-9">
                  <input class="form-control" type="text" id="referred_by" name="referred_by" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars($pat["referred_by"])."'" ?>>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="special_codes">Special Codes:</label>
                <div class="col-sm-9">
                  <input class="form-control" type="text" id="special_codes" name="special_codes" value=<?php if(isset($_POST["edit"])) echo "'".htmlspecialchars( $pat["special_codes"])."'" ?>>
                  <input type="hidden" name="id" value =<?php if(isset($_POST["edit"])) echo $_POST["edit"] ?>>
                </div>    
              </div>
            </div>
          
            <div style="overflow:auto;">
              <div style="float:right;">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
              </div>
            </div>
            <div style="text-align:center;margin-top:40px;">
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div>
          </form>
         
        
      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- partial -->
        </div>
        <script src="../../assets/vendors/select2/select2.min.js"></script>
        <script src="../../assets/js/select2.js"></script>
        <script>
          var currentTab = 0; // Current tab is set to be the first tab (0)
          showTab(currentTab); // Display the current tab

          function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
              document.getElementById("prevBtn").style.display = "none";
            } else {
              document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
              document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
              document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
          }

          function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
              if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            if (currentTab >= x.length) {
              //...the form gets submitted:
              document.getElementById("form").submit();
              return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
          }

          function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
              x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
          }
          function validateForm() {
            // This function deals with validation of the form fields
            var w,x, y,z, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
              // If a field is empty...
              if (y[i].value == "" && y[i].required == true) {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false:
                valid = false;
              }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
              document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
          }
        </script>
    
</body>
</html>