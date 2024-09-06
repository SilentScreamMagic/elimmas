<?php  
    $pat_id ="unchanged";
    if (isset($_POST['id'])){
        $pat_id = $_POST['id'];
    }
    include "../conn.php";
    //include "../nav.php";
    //include "../table.html";
    $sql = "SELECT pat_id,concat(Fname,' ',LName) as 'Patient Name' FROM patient;";
    $result = $conn->query($sql);
    $patients = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[$row["pat_id"]] = $row["Patient Name"];
        }
    
    }
    $sql = "SELECT username,Name,user_type FROM users
    where user_type = 'Doctor';";
    $result = $conn->query($sql);
    $docs = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $docs[$row["username"]] = $row["Name"];
        }
    
    }
    
 
 
    $conn->close();
?>
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
                    <h4 class="card-title">Add Appointment</h4>
                    <form class="form-sample" action="process_app.php" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="patient_id">Patients Name:</label>
                            <div class="col-sm-9">
                            <select class="js-example-basic-single" style="width:100%" name="patient_id" id="patient_id">
                                <option value="" disabled <?php if(!isset($_POST["id"])) echo "selected" ; ?>>Select a patient...</option>
                                <?php foreach ($patients as $pid => $name): ?>
                                    <option value=<?php echo "'$pid' "; 
                                if($pid == $pat_id){
                                  echo "selected";
                              }?>><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="doc_id">Doctor Name:</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single" style="width:100%" name="doc_id" id="doc_id">
                                    <option value="">Select a Doctor...</option>
                                    <?php foreach ($docs as $did => $name): ?>
                                        <option value="<?php echo $did; ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label" >Date:</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="date" id="date" name="date" required>
                            </div>
                            
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="time">Time:</label>
                            <div class="col-sm-9">
                                <input  class="form-control" type="time" id="time" name="time" required>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"  for="type">Appointment Type:</label>
                            <div class="col-sm-9">
                                <select id="type" name="type" class="js-example-basic-single" style="width:100%" required>
                                <option value="In-Patient">In-Patient</option>
                                <option value="Consultation">Consultation</option>
                                </select>
                            </div>
                            
                        </div>
                        
                        <button  class="btn btn-primary mr-2" type="submit" value="Submit">Submit</button>
                    </form>
            
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
        </div>
        <script src="../../assets/vendors/select2/select2.min.js"></script>
        <script src="../../assets/js/select2.js"></script>
   
</body>
</html>
