<?php
require_once "../conn.php";
//include "../nav.php";
//include "../table.html";



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
                    <h4 class='card-title'>Medication Requests</h4>
                    <?php
                    $date = date("Y-m-d");
                        $sql = "SELECT 
ab.`Patient Name`,ab.apt_id ,COUNT(ab.med_id) 'Requests Pending'
from (SELECT patients_meds.apt_id,concat(patient.FName,' ',patient.LName) 'Patient Name',patients_meds.med_id,sum(`per_dose`*`per_day`*`num_days`) 'requested' , 
sum(medstock.quantity) 'given'
FROM `patients_meds` 
INNER JOIN appointments on appointments.id = patients_meds.apt_id
INNER JOIN patient on patient.pat_id = appointments.patient_id
LEFT join medstock on medstock.apt_id = patients_meds.apt_id AND medstock.med_id = patients_meds.med_id 
      where appointments.check_out is null
group by patients_meds.apt_id,patients_meds.med_id) as ab
where ab.`requested` > COALESCE((ab.`given`*-1),0);";
                        $result = $conn->query($sql);
                        ?>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Patient Name</th><th>Medication Requests Pending</th><th>Requests</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $string = "<tr><td>".$row["Patient Name"]."</td><td>".$row["Requests Pending"]."</td>
            <td><form action='medicationapp.php' method='post'>
                <input type='hidden' name='id' value=".$row['apt_id'].">
                <input type='submit' value='View Requests'>
            </form></td></tr>";
           echo $string;
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



