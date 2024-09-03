<?php
    
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
    if (isset($_POST["btemp"])) {
        $sql = "INSERT INTO `patients_vits` (`date`, `apt_id`, `vit_id`, `measure`,created_by) VALUES 
        (now(), $_POST[apt_id], 1, $_POST[btemp],'".$_SESSION["user"][0]."'), 
        (now(), $_POST[apt_id], 2, $_POST[pulRate],'".$_SESSION["user"][0]."'),
        (now(), $_POST[apt_id], 3, $_POST[respRate],'".$_SESSION["user"][0]."'), 
        (now(), $_POST[apt_id], 4, $_POST[dbloodPress],'".$_SESSION["user"][0]."'),
        (now(), $_POST[apt_id], 6, $_POST[oxysat],'".$_SESSION["user"][0]."'), 
        (now(), $_POST[apt_id], 5, $_POST[sbloodPress],'".$_SESSION["user"][0]."')";
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
                   
                  <div class="form-container">
            <form action="vitals.php" method="post">
                <div class="form-group">
                    <label for="apt_id">Patients Name:</label>
                    <select name="apt_id" id="apt_id">
                        <option value="">Select a patient...</option>
                        <?php foreach ($patients as $pid => $name): ?>
                            <option value="<?php echo $pid; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                                <label for="btemp">Body Temperature:</label>
                                <input type="text" id="btemp" name="btemp" required><br>
                                <label for="pulRate">Pulse Rate:</label>
                                <input type="text" id="pulRate" name="pulRate" required><br>
                                <label for="respRate">Respiration Rate:</label>
                                <input type="text" id="respRate" name="respRate" required><br>
                                <label for="dbloodPress">Diastolic Blood Pressure</label>
                                <input type="text" id="dbloodPress" name="dbloodPress" required ><br>
                                <label for="sbloodPress">Systolic Blood Pressure</label>
                                <input type="text" id="sbloodPress" name="sbloodPress" required ><br>
                                <label for="oxysat">Oxygen Saturation</label>
                                <input type="text" id="oxysat" name="oxysat" required ><br>
                                <input type="submit" value="Submit"><br><br>
                            </form>
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
        </div>";
