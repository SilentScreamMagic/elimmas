<?php
 include "../conn.php";
 //include "../nav.php";
 //include "../table.html";
 if (isset($_POST["id"])){
    $pat_id = $_POST["id"];
    $sql = "SELECT * FROM patient WHERE pat_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST["id"]); // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $stmt->close();

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
                  
                  <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<h4 class='card-title'>$row[FName] $row[LName]</h4>";
            echo "<div class='row'>
                    <div class='col-md-4'>
                        <div class='row'>
                            <span>Date of Birth: </span>  $row[DOB]
                        </div>
                        <div class='row'>
                            <span>Gender:</span> $row[gender]
                        </div>
                        <div class='row'>
                            <span>Marital Status:</span> $row[marital_status]
                        </div>
                        <div class='row'>
                            <span>Patient Phone:</span>$row[patient_phone]
                        </div>
                        <div class='row'>
                            <span>Patient Email:</span>$row[patient_email]
                        </div>
                        
                        <div class='row'>
                            <span>Employment:</span> $row[employment]
                        </div>
                        <div class='row'>
                            <span>Registration Date:</span> $row[registration_date]
                        </div>
                    </div>
                    
                    <div class='col-md-4'>
                        <div class='row'>
                            <span>Emergency First Name:</span>  $row[emergency_fname]
                        </div>
                        <div class='row'>
                             <span>Emergency Last Name:</span>  $row[emergency_lname]
                        </div>
                        <div class='row'>
                            <span>Emergency Phone:</span> $row[emergency_phone]
                        </div>
                        <div class='row'>
                            <span>Emergency Email:</span> $row[emergency_email]
                        </div>
                        <div class='row'>
                            <span>Referred By:</span>  $row[referred_by]
                        </div>
                        <div class='row'>
                           <span>Special Codes:</span> $row[special_codes]
                        </div>
                        
                            
                        </div>";
           
          
           
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }?>
                    
                  </div>
                </div>
           
            
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Current Patients</h4>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Doctor Name</th><th>Date</th><th>Time</th><th>Type</th><th>Check in</th><th>Check out</th><th>Resuscitation Status</th><th>Diet</th><th></th>
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
                                        "</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td><td>".$row["resuscitation_status"]."</td><td>".$row["diet"]."</td><td> 
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
          <!-- partial -->
        </div>
</div>

	
    