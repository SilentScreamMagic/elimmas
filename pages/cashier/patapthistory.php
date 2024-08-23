<?php
 include "../conn.php";
 //include "../nav.php";
 //include "../table.html";
$pat_id = $_POST["id"];
$sql = "SELECT concat(patient.FName,' ', patient.LName)'Patient Name' FROM patient where pat_id = $_POST[id]";
$result = $conn->query($sql)->fetch_assoc();
$pname =$result['Patient Name'];

$sql = "SELECT patient_id, concat(patient.FName,' ', patient.LName)'Patient Name',appointments.*, users.Name FROM `appointments`
 inner join patient on patient.pat_id = appointments.patient_id
 INNER join users on users.username = appointments.doc_id
 WHERE patient_id = $pat_id;";
$result = $conn->query($sql);
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
                    <h4 class='card-title'><?php echo $pname?></h4>
                    <h2></h2>
                    <div class='table-responsive'>
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Doctor Name</th><th>Date</th><th>Time</th><th>Type</th><th>Check in</th><th>Check out</th><th></th><th></th></tr>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["Name"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["type"].
                            "</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td>";
                            
                            if ($row["check_out"]){
                                echo "<td>
                            <form action='discharge.php' target='_blank' method='post'>
                            <input type='hidden' name='id' value=".$row["id"].">
                            <input type='submit' value='Create Bill'>
                        </form></td>
                        <td> 
                            <form action='discharge notes.php' target='_blank' method='post'>
                            <input type='hidden' name='id' value=".$row["id"].">
                            <input type='submit' value='Create Discharge Notes'>
                        </form></td></tr>";
                            }
                }
                }
                else {
                    echo "0 results";
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


    
            </div>
</div>

	
    