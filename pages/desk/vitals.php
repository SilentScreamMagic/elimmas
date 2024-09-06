<?php
$id ="unchanged";
    if (isset($_POST["id"])){
      $id = $_POST["id"];
    }
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
  
    <?php include '../nav.php';
    include "../conn.php";
    if (isset($_POST["bloodPress"])){
      $bp = explode("/",$_POST["bloodPress"]);

    }
    
    if (isset($_POST["btemp"])) {
        $sql = "INSERT INTO `patients_vits`( `date`, `apt_id`, `created_by`, `body_temp`, `pulse_rate`, `respiration_rate`, `systolic_bp`, `dystolic_bp`, `oxygen_sat`, `weight`) 
        VALUES (now(),$_POST[apt_id],'".$_SESSION["user"][0]."','$_POST[btemp]','$_POST[pulRate]','$_POST[respRate]','$bp[0]','$bp[1]','$_POST[oxysat]','$_POST[weight]')";
        $result = $conn->query($sql);
    }

    $sql ="SELECT id, concat(patient.FName,' ', patient.LName)'Patient Name' from appointments
    INNER JOIN patient ON appointments.patient_id = patient.pat_id
    WHERE appointments.check_in is not null and appointments.check_out is null";
    $result = $conn->query($sql);
    $patients = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[$row["id"]] = $row["Patient Name"];
        }
    };?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                  <h4 class="card-title">Patient Vitals</h4>
                <form class = "form-sample" action="vitals.php" method="post">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="apt_id">Patients Name:</label>
                        <div class="col-sm-9">
                          <select class="js-example-basic-single" style="width:20%" name="apt_id" id="apt_id" required>
                            <option value="" disabled <?php if(!isset($_POST["id"])) echo "selected" ; ?>>Select a patient...</option>
                            <?php foreach ($patients as $pid => $name): ?>
                                <option value=<?php echo "'$pid' "; 
                                if($pid == $id){
                                  echo "selected";
                              }?>><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                      <label for="btemp" class="col-sm-3 col-form-label">Body Temperature:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="btemp" name="btemp" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="pulRate" class="col-sm-3 col-form-label">Pulse Rate:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="pulRate" name="pulRate" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="respRate" class="col-sm-3 col-form-label">Respiration Rate:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="respRate" name="respRate" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="bloodPress" class="col-sm-3 col-form-label">Blood Pressure</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="bloodPress" name="bloodPress" pattern="^[0-9]+/[0-9]+$"required >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="oxysat" class="col-sm-3 col-form-label">Oxygen Saturation</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="oxysat" name="oxysat" required >
                      </div>
                      
                    </div>
                    <div class="form-group row">
                      <label for="weight" class="col-sm-3 col-form-label" >Weight</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="weight" name="weight" required >
                      </div>
                    
                    </div>
                      <input type="submit" value="Submit">
                    </form>             
                  </div>
                </div>
              </div>
            </div>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                  <h4 class="card-title">Today's Vitals</h4>
                  <?php 
                                $sql = "SELECT concat(patient.FName,' ', patient.LName)'Patient Name',patients_vits.* FROM `patients_vits` 
                            INNER JOIN appointments on appointments.id = patients_vits.apt_id
                            INNER JOIN patient on appointments.patient_id = patient.pat_id
                            inner JOIN users on users.username = patients_vits.created_by
                            where  cast(patients_vits.date as date)= '".date("Y-m-d")."' and deleted = 0 and users.user_type = 'Front Desk'
                            GROUP by apt_id
                            order by date;";
                                $result = $conn->query($sql); 
                                ?>
                                <div class='table-responsive'>
                                    <table class ='table'>
                                    <thead>
                                        <tr>
                                            <th>Date</th><th>Patient Name</th><th>Body Temperature</th><th>Pulse Rate</th><th>Respiration Rate</th><th>Blood Pressure</th><th>Oxygen Saturation</th><th>Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($result->num_rows > 0) {
                                              while($row = $result->fetch_assoc()) {
                                                  echo "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["body_temp"]."</td><td>".$row["pulse_rate"]."</td><td>".$row["respiration_rate"]."</td><td>".$row["systolic_bp"]."/".$row["dystolic_bp"]."</td><td>".$row["oxygen_sat"]."</td><td>".$row["weight"]."</td></tr>";
                                              }
                                            }
                                        ?>
                                    </tbody>
                                    </table>
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
   
