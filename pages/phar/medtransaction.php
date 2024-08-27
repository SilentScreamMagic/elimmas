<?php 
    include "../conn.php";
   // include "../nav.php";
   // include "../table.html";
    include "../tabs.html";
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
                    <h4 class='card-title'>Current Patients</h4>
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'consumption')" id="defaultOpen">Consumption</button>
                        <button class="tablinks" onclick="openTab(event, 'topup')">Top Up</button>
                    </div>
                    <div id="consumption" class="tabcontent">
                            <?php 
                            $sql = "SELECT medstock.t_date,medication.med_id, med_name, COALESCE(CONCAT(patient.FName, ' ', patient.LName), dispense_to)AS 'Dispense To',
                        medstock.quantity * -1 AS 'Stock'
                    FROM 
                        medication 
                    INNER JOIN 
                        medstock ON medstock.med_id = medication.med_id 
                    LEFT JOIN 
                        appointments ON medstock.apt_id = appointments.id 
                    LEFT JOIN 
                        patient ON patient.pat_id = appointments.patient_id 
                    WHERE 
                        medstock.quantity < 0 
                    ORDER BY 
                        t_date;;";
                            $result = $conn->query($sql);?>
                <div class='table-responsive'>
                    <table class ='table'>
                    <thead>
                        <tr>
                        <th>Date</th><th>Medication</th><th>Dispense To</th><th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $string = "<tr><td>".$row["t_date"]."</td><td>".$row["med_name"]."</td><td>".$row["Dispense To"]."</td><td>".$row["Stock"]."</td></tr>";
                            echo $string;
                            }
                        }
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div id="topup" class="tabcontent">
                <?php 
                $sql = "SELECT medstock.t_date, medication.med_id, med_name,medstock.quantity AS 'Stock' FROM medication 
                INNER JOIN medstock ON medstock.med_id = medication.med_id 
                WHERE medstock.quantity >0
                order by t_date;";
                $result = $conn->query($sql);
                ?>
                <div class='table-responsive'>
                    
                    <table class ='table'>
                    <thead>
                        <tr>
                            <th>Date</th><th>Medication</th><th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $string = "<tr><td>".$row["t_date"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
                            echo $string;
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
