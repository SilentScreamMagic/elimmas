<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
include "../tabs.html";
//
   
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
  
    <?php include '../nav.php';
    include "../searchbar2.php";
    ?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'cur_pat')" id="defaultOpen">Current Patient</button>
                        <button class="tablinks" onclick="openTab(event, 'all_pat')" >All Patient</button>
                        
                    </div> 
                    
                    <div id="cur_pat" class="tabcontent">
                    <h4 class='card-title'>Current Patients</h4>
                    <input type='text' id='tableFilterInput' class=' form-control dropdown-input' placeholder='Search Patients...'>
                        <div class='table-responsive'>
                        
                            <?php
                            $sql = "SELECT patient.pat_id, appointments.date,concat(Fname,' ',LName) 'Patient Name',appointments.type,COALESCE(beds.room_id,'Accomodation Pending')'Room', COALESCE(beds.bed_id,'Accomodation Pending')'Bed',appointments.id,appointments.check_in FROM appointments 
                                INNER join patient on appointments.patient_id = patient.pat_id
                                left join (SELECT * from patients_beds WHERE end_date is null) pb on appointments.id = pb.apt_id 
                                Left join beds on beds.bed_id = pb.bed_id
                                where check_in is not null and check_out is null
                                order by appointments.date;";
                            $result = $conn->query($sql);?>

                             <table id="filterTable" class ='table'>
                        <thead>
                            <tr>
                                <th>Date</th><th>Patient Name</th><th>Type</th><th>Arrival</th><th>Ward</th><th>Bed</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                echo "<tbody>";
                                    while($row = $result->fetch_assoc()) {
                                        $room =$row["Room"];
                                        $bed = $row["Bed"];
                                        if ($row['type'] =="Consultation"){
                                            $room ="N/A";
                                            $bed = "N/A";
                                        }
                                        $string = "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["type"]."</td><td>".$row["check_in"]."</td><td>".$room."</td><td>".$bed."</td>";
                                    $string = $string . "<td><form action='docapthistory.php' method='post'>
                                        <input type='hidden' name='id' value=".$row['pat_id'].">
                                        <input type='submit' value='View Appointment History'>
                                    </form></td>
                                    </tr>";
                                    
                                    echo $string;
                                    }
                                } 
                            
                            ?>
                        </tbody>
                        </table>  
                        </div>
                    </div>
                   
                         
                        <div id="all_pat" class="tabcontent">

        <?php
            $sql = "SELECT registration_date,patient.pat_id, concat(Fname,' ',LName) 'Patient Name' FROM patient
            order by 'Patient Name';";
            $result = $conn->query($sql);?>
            <h4 class='card-title'>All Patients</h4>
            
                    <div class='table-responsive'>
                        <table id="filterTable" class ='table'>
                        <thead>
                            <tr>
                                <th>Registration Date</th><th>Patient Name</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                              <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $string = "<tr><td>".$row["registration_date"]."</td><td>".$row["Patient Name"]."</td>";
                                $string = $string . "<td><form action='docapthistory.php' method='post'>
                                    <input type='hidden' name='id' value=".$row['pat_id'].">
                                    <input type='submit' value='View Appointment History'>
                                </form></td>
                                </tr>";
                                
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
          
            </div>
           
          <!-- partial -->
          </div>
          
        </div>