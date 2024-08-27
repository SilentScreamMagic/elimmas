<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
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
                        <button class="tablinks" onclick="openTab(event, 'nurse')" id="defaultOpen"> Nurse</button>
                        <button class="tablinks" onclick="openTab(event, 'theatre')"> Theatre</button>
                    </div>
                    
                    <div id="nurse" class="tabcontent">
                        <?php
                            $sql = "SELECT medication.med_id, med_name, -1*COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
                            FROM medication
                            LEFT JOIN medstock ON medstock.med_id = medication.med_id
                            where quantity <0 and dispense_to = 'Nurses'
                            GROUP BY med_id;";
                            $result = $conn->query($sql);?>
                            <div class='table-responsive'>
                            <table class ='table'>
                                <thead>
                                    <tr>
                                        <th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                            
                            if ($result){ 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
                                    }
                                   
                                } 
                            }
                        ?>
                                </tbody>
                                </table>
                            </div>
                           
                    </div>
                    <div id="theatre" class="tabcontent">
                        <?php
                            $sql = "SELECT medication.med_id, med_name, -1*COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
                            FROM medication
                            LEFT JOIN medstock ON medstock.med_id = medication.med_id
                            where quantity <0 and dispense_to = 'Theatre'
                            GROUP BY med_id;";
                            $result = $conn->query($sql);
                            ?>
                            <div class='table-responsive'>
                            <table class ='table'>
                                <thead>
                                    <tr>
                                        <th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        
                                        if ($result){ 
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
                                                }
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
<html>
    <body>
        
        
        
    </body>
    
</div>