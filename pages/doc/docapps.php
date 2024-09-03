<?php
require_once "../conn.php";
//include "../nav.php";
//include "../table.html";
$date = date("Y-m-d");

if (isset($_POST["appt_date"])){
    $date = date("Y-m-d",strtotime($_POST["appt_date"]));
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
                    <h3 class='card-title'>Appointments</h3>
                    <h5><?php echo $date; ?></h5>
                    <form action= "" method="post">
                    <label for="appt_date" >Date:</label>
                    <input type="date" id="appt_date" name="appt_date">
                    <input type="submit" value="Submit">
                    </form>
                    <div class='table-responsive'>
                    <?php
                        $sql = "SELECT appointments.id,concat(pr.Fname,' ',pr.LName) as 'Patient Name',users.Name 'Doctor',appointments.date,appointments.time, appointments.check_in 
                        FROM patient pr 
                        join appointments on pr.pat_id = appointments.patient_id 
                        join users on appointments.doc_id = users.username;
                        where appointments.date = '$date' and check_out is null";

                        $result = $conn->query($sql);
                        ?>
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Patient Name</th><th>Date</th><th>Doctor Assigned</th><th>Time</th><th>Arrived</th><th>Check In</th></tr></
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result){ 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo"<tr><td>".$row["Patient Name"]."</td><td>".$row["Doctor"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["check_in"]."</td>
                                        <td><form action='docprocs.php' method='post'>
                                            <input type='hidden' name='id' value=".$row['id'].">
                                            <input type='submit' value='View Patient'>
                                        </form></td></tr>";
                                        }
                                    }
                                } 
                                
                                $conn->close();
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
          <footer class='footer'>
            <div class='d-sm-flex justify-content-center justify-content-sm-between'>
              <span class='text-muted d-block text-center text-sm-left d-sm-inline-block'>Copyright © bootstrapdash.com 2020</span>
              <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'> Free <a href='https://www.bootstrapdash.com/bootstrap-admin-template/' target='_blank'>Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>


