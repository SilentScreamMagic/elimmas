<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
include "../searchbar2.php";
$sql = "SELECT patient.pat_id, patient.registration_date 'date',concat(Fname,' ',LName) 'Patient Name' FROM patient 
 order by `Patient Name` ;";
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
    <link rel="shortcut icon" href="../../elimmas-icon.png" />
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
                    <div class='table-responsive'>
                        <input type='text' id='tableFilterInput' class='form-control dropdown-input' placeholder='Filter by column value...'>
                        <table id='filterTable' class ='table'>
                        <thead>
                            <tr>
                                <th>Registration Date</th><th>Patient Name</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result){ 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td>
                                    <td> 
                                    <div style ='display: inline-block;'>
                                        <form action='patapthistory.php' method='post'>
                                            <input type='hidden' name='id' value=".$row['pat_id'].">
                                            <input style='width: 30px; height: 30px;' type='submit' value='&#128065;'>
                                        </form>
                                    </div>
                                    </td>
                                    
                                    </tr>";
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
