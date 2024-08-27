<?php
 include "../conn.php";
 //include "../nav.php";
 //include "../table.html";
 if (isset($_POST["id"])){
    $pat_id = $_POST["id"];
    $sql = "SELECT * FROM patient where pat_id = $_POST[id]";
    $result = $conn->query($sql);
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
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .patient-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .patient-card h2 {
            margin-top: 0;
        }
        .patient-info {
            display: flex;
            flex-wrap: wrap;
        }
        .patient-info div {
            flex: 1 1 50%;
            margin-bottom: 10px;
        }
        .patient-info div span {
            font-weight: bold;
        }
    </style>
</head>
  <body>
  <div class='container-scroller'>
  
    <?php include '../nav.php';?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
            <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='patient-card'>";
            echo "<h2>$row[FName] $row[LName]</h2>";
            echo "<div class='patient-info'>";
            echo "<div><span>Date of Birth:</span> " . $row["DOB"] . "</div>";
            echo "<div><span>Gender:</span> " . $row["gender"] . "</div>";
            echo "<div><span>Financial Type:</span> " . $row["financial_type"] . "</div>";
            echo "<div><span>Guardian First Name:</span> " . $row["guardian_fname"] . "</div>";
            echo "<div><span>Guardian Last Name:</span> " . $row["guardian_lname"] . "</div>";
            echo "<div><span>Marital Status:</span> " . $row["marital_status"] . "</div>";
            echo "<div><span>Address:</span> " . $row["address"] . "</div>";
            echo "<div><span>Patient Phone:</span> " . $row["patient_phone"] . "</div>";
            echo "<div><span>Patient Email:</span> " . $row["patient_email"] . "</div>";
            echo "<div><span>Guardian Phone:</span> " . $row["guardian_phone"] . "</div>";
            echo "<div><span>Guardian Email:</span> " . $row["guardian_email"] . "</div>";
            echo "<div><span>Referred By:</span> " . $row["referred_by"] . "</div>";
            echo "<div><span>Registration Date:</span> " . $row["registration_date"] . "</div>";
            echo "<div><span>Employment:</span> " . $row["employment"] . "</div>";
            echo "<div><span>Special Codes:</span> " . $row["special_codes"] . "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }?>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Current Patients</h4>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Doctor Name</th><th>Date</th><th>Time</th><th>Type</th><th>Diagnosis</th><th>Check in</th><th>Check out</th><th>Patient Condition</th><th>Resuscitation Status</th><th>Diet</th><th>Medical History</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                                
                        <?Php
                            $sql = "SELECT patient_id, concat(patient.FName,' ', patient.LName)'Patient Name',appointments.*, users.Name FROM `appointments`
                            inner join patient on patient.pat_id = appointments.patient_id
                            INNER join users on users.username = appointments.doc_id
                            WHERE patient_id = $pat_id;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>".$row["Name"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["type"].
                                        "</td><td>".$row["diagnosis"]."</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td><td>".
                                        $row["patient_condition"]."</td><td>".$row["resuscitation_status"]."</td><td>".$row["diet"]."</td><td>".
                                        $row["medical_history"]."</td><td> 
                                        <form action='docprocs.php' method='post'>
                                        <input type='hidden' name='id' value=".$row["id"].">
                                        <input type='submit' value='View Appointment Details'>
                                    </form></td></tr>";
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
</div>

	
    