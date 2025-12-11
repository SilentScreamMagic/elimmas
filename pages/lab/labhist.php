<?php
require_once "../conn.php";
//include "../nav.php";
//include "../table.html";
$date = date("Y-m-d");

if (isset($_GET["appt_date"])){
    $date = date("Y-m-d",strtotime($_GET["appt_date"]));
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
                    <h3 class='card-title'>Lab History</h3>
                    <h5><?php echo $date; ?></h5>
                    <form action= "" method="get">
                    <label for="appt_date" >Date:</label>
                    <input type="date" id="appt_date" name="appt_date">
                    <input type="submit" value="Submit">
                    </form>
                    <div class='table-responsive'>
                    <?php
                        $sql = "SELECT patients_labs.p_lab_id,patients_labs.date, CONCAT(patient.FName, ' ', patient.LName) AS 'Patient Name', DOB,
labs.lab_name, patients_labs.lab_results, patients_labs.lab_date, appointments.check_in, appointments.check_out,users.Name 'Doctor' FROM patients_labs 
INNER JOIN appointments ON patients_labs.apt_id = appointments.id 
INNER JOIN users on users.username = appointments.doc_id
INNER JOIN patient ON patient.pat_id = appointments.patient_id 
INNER JOIN labs ON patients_labs.lab_id = labs.lab_id
WHERE cast(patients_labs.date as date) = '$date'
ORDER by patients_labs.date;";

                        $result = $conn->query($sql);
                        ?>
                         <table class ='table'>
                        <thead>
                            <tr>
                                <th>Date</th><th>Patient Name</th><th>Lab Name</th><th>Doctor</th><th>Results</th>
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
                                  $string = "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]." (Age: ".$age.")"."</td><td>".$row["lab_name"]."</td><td>".$row["Doctor"]."</td>";
                                  if (is_null($row["lab_results"])) {
                                      $string =$string ."
                                      <td><form action='lab_upload.php' method='post' enctype='multipart/form-data'>
                                       <input type='hidden' name='id' value=".$row['p_lab_id'].">
                                      <input type='file' name='fileToUpload' id='fileToUpload' required>
                                      <input type='submit' value='Upload File' name='submit'>
                                      </form></td></tr>
                                      ";
                                  }else{
                                      $string = $string."<td>".$row["lab_results"]."</td><td><td><a href='../open_pdf.php?file=../files/$row[lab_results]' target='_blank'>Open PDF</a></td><tr>";

                                  }
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
          <!-- partial -->
        </div>


