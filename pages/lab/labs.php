<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "../../uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) { // Limit size to 5MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $sql ="update patients_labs set lab_date =now(), lab_results ='".basename( $_FILES["fileToUpload"]["name"])."'
            where p_lab_id = ".$_POST["id"];
           $result = $conn->query($sql);
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<body>
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
                    <h4 class='card-title'>Lab Requests</h4>
                    <?php 
    $sql = "SELECT patients_labs.p_lab_id,patients_labs.date, CONCAT(patient.FName, ' ', patient.LName) AS 'Patient Name', DOB,
labs.lab_name, patients_labs.lab_results, patients_labs.lab_date, appointments.check_in, appointments.check_out FROM patients_labs 
INNER JOIN appointments ON patients_labs.apt_id = appointments.id 
INNER JOIN patient ON patient.pat_id = appointments.patient_id 
INNER JOIN labs ON patients_labs.lab_id = labs.lab_id
WHERE appointments.date = CURRENT_DATE
ORDER by patients_labs.date;";
    $result = $conn->query($sql);?>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                                <th>Date</th><th>Patient Name</th><th>Lab Name</th><th>Results</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $dateOfBirth = date("d-m-Y", strtotime($row["DOB"]));
    $today = date("d-m-Y");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $age = $diff->format("%y");
            $string = "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]." (Age: ".$age.")"."</td><td>".$row["lab_name"]."</td>";
            if (is_null($row["lab_results"])) {
                $string =$string ."
                <td><form action='labs.php' method='post' enctype='multipart/form-data'>
                 <input type='hidden' name='id' value=".$row['p_lab_id'].">
                <input type='file' name='fileToUpload' id='fileToUpload' required>
                <input type='submit' value='Upload File' name='submit'>
                </form></td></tr>
                ";
            }else{
                $string = $string."<td>".$row["lab_results"]."</td><tr>";
            }
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
<div id="lab_id">
   
   
</div>

</body>
</html>

