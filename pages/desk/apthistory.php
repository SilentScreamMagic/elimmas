<?php
 include "../conn.php";
 //include "../nav.php";
 //include "../table.html";
if(isset($_POST["id"])){
    $pat_id = $_POST["id"];
}
if(isset($_GET["id"])){
    $pat_id = $_GET["id"];
}
 

 $sql = "SELECT patient_id,
               CONCAT(patient.FName,' ', patient.LName) AS `Patient Name`,
               appointments.*,
               users.Name
        FROM appointments
        INNER JOIN patient ON patient.pat_id = appointments.patient_id
        INNER JOIN users   ON users.username = appointments.doc_id
        WHERE patient_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pat_id); // patient_id is integer
$stmt->execute();
$result = $stmt->get_result();

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
                    <h4 class='card-title'>Appointment History</h4>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>ID</th><th>Patient Name</th><th>Doctor Name</th><th>Type</th><th>Date</th><th>Time</th><th>Diagnosis</th>
 <th>Check in</th><th>Check out</th><th>Resuscitation Status</th><th>Diet</th><th>Medical History</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
           echo "<tr><td>".$row["patient_id"]."</td><td>".$row["Patient Name"]."</td><td>".$row["Name"]."</td><td>".$row["type"]."</td><td>".$row["date"]."</td><td>".$row["time"].
           "</td><td>".$row["diagnosis"]."</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td><td>".
           $row["resuscitation_status"]."</td><td>".$row["diet"]."</td><td>".
           $row["medical_history"]."</td></tr>"; 
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
          <!-- partial -->
        </div>
        <script>
    document.getElementById('create').innerHTML +=`<li class='nav-item dropdown d-none d-lg-block'>
                <a class='nav-link btn btn-success create-new-button' id='createbuttonDropdown' data-toggle='dropdown' aria-expanded='false' href='#'>+ Create ...</a>
                <div class='dropdown-menu dropdown-menu-right navbar-dropdown preview-list' aria-labelledby='createbuttonDropdown'>
                  <div class='dropdown-divider'></div>
                  <a class='dropdown-item preview-item' href ="./addpatient.php">
                    <div class='preview-thumbnail'>
                      <div class='preview-icon bg-dark rounded-circle'>
                        <i class='mdi mdi-file-outline text-primary'></i>
                      </div>
                    </div>
                    <div class='preview-item-content'>
                      <p class='preview-subject ellipsis mb-1'>Add Patient</p>
                    </div>
                  </a>
                  <div class='dropdown-divider'></div>
                  <a class='dropdown-item preview-item' href ="./Addappointment.php">
                    <div class='preview-thumbnail'>
                      <div class='preview-icon bg-dark rounded-circle'>
                        <i class='mdi mdi-web text-info'></i>
                      </div>
                    </div>
                    <div class='preview-item-content'>
                      <p class='preview-subject ellipsis mb-1'>Add Appointment</p>
                    </div>
                  </a>
                </div>
              </li>`;
</script>

    