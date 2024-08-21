<?php
include "../conn.php";
include "../nav.php";
//include "../table.html";

if(isset($_POST['id'])){
    $sql = "UPDATE `appointments` SET check_out = now() WHERE id = ".$_POST['id'];
    $result = $conn->query($sql);
    $sql = "SELECT * FROM `patients_beds` WHERE apt_id = ".$_POST['id']." and end_date is null";
    $result = $conn->query($sql)->fetch_assoc();
    $bid = $result["bed_id"];
    $sql = "UPDATE `patients_beds` SET end_date = now() WHERE apt_id = ".$_POST['id']." and end_date is null";
    $result = $conn->query($sql);
    $sql = "UPDATE `beds` SET `status`='dirty' WHERE `bed_id`=$bid";
    $result = $conn->query($sql);
}

$sql = "SELECT patient.pat_id, appointments.date,concat(Fname,' ',LName) 'Patient Name',appointments.type,
COALESCE(beds.room_id,'Accomodation Pending')'Room', COALESCE(beds.bed_id,'Accomodation Pending')'Bed',
appointments.id,appointments.check_in, 
case 
when dis_notes is null then 'Pending'
else 'Ready'
end as 'dis_notes'
FROM appointments 
INNER join patient on appointments.patient_id = patient.pat_id
left join (SELECT * from patients_beds WHERE end_date is null) pb on appointments.id = pb.apt_id 
Left join beds on beds.bed_id = pb.bed_id
 where type = 'In-Patient' and check_in is not null and check_out is null
 order by appointments.date;";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
  <div class="main-panel">
          <div class="content-wrapper">
            
            
            
            <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Revenue</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$32123</h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Sales</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$45850</h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Purchase</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$2039</h2>
                          <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                        </div>
                        <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Order Status</h4>
                    <div class="table-responsive">
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Type</th>
                                <th>Arrival</th>
                                <th>Ward</th>
                                <th>Bed</th>
                                <th>Discharge Notes</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result){ 
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                    <td>".$row["date"]."</td>
                                    <td>".$row["Patient Name"]."</td>
                                    <td>".$row["type"]."</td><td>".$row["check_in"]."</td>
                                    <td>".$row["Room"]."</td><td>".$row["Bed"]."</td>
                                    <td>".$row["dis_notes"]."</td>
                                <td> 
                                <div>
                                    <form action='viewpatient.php' method='post'>
                                        <input type='hidden' name='id' value=".$row['id'].">
                                        <input class = 'btn-info' type='submit' value='&#128065;'>
                                    </form>
                                </div>
                                </td>";
                                if($row["dis_notes"]=="Ready"){
                                    echo"<td><div>
                                        <form action='' method='post'>
                                            <input type='hidden' name='id' value=".$row['id'].">
                                            <input type='submit' value='Discharge'>
                                        </form>
                                    </div>
                                    </td>
                                    ";
                                        
                                }
                            
                                }
                                //echo "</tr></tbody></table></div></div>";
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
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>