<?php
include "../conn.php";
include "../searchbar2.php";
//include "../table.html";
$sql = "SELECT patient.pat_id,concat(Fname,' ',LName) 'Patient Name',patient.*, concat(emergency_fname,' ',emergency_lname)'Emergency Contact' FROM patient;";
$result = $conn->query($sql);
?>
<a href="./addpatient.html">Add Patient</a>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <div class="container-scroller">
    <?php include "../nav.php";?>
  <div class="main-panel">
        <div class="content-wrapper">
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">All Patients</h4>
                    <div class="table-responsive">
                      <input type="text" id='tableFilterInput' class="form-control dropdown-input" placeholder="Search Patients">
                
                        <table id='filterTable' class ='table'>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>DOB	</th>
                                <th>Gender	</th>
                                <th>Phone</th>	
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                          if ($result){ 
                              if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()) {
                                    echo "<tr><td> 
                                  <div>
                                      <form action='apthistory.php' method='post'>
                                          <input type='hidden' name='id' value=".$row['pat_id'].">
                                          <input class ='btn-md btn-primary' type='submit' value='&#128065;'>
                                      </form>
                                  </div>
                                  <div>
                                      <form action='Addappointment.php' method='post'>
                                          <input type='hidden' name='id' value='".$row['pat_id']."'>
                                          <input style = 'width: 30px' class ='btn-md btn-info' type='submit' value='+'>
                                      </form>
                                  </div>
                                  </td><td>".$row["registration_date"]."</td><td>".$row["Patient Name"]."</td>
                                    <td>".$row["DOB"]."</td><td>".$row["gender"]."</td><td>".$row["patient_phone"]."</td><td>".$row["patient_email"]."</td>
                                  
                                    
                                  
                                  </tr>";
                                  }
                                  echo "</tbody></table></div></div>";
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
          
          <!-- partial -->
        </div>

        <script>
    document.getElementById('create').innerHTML +=`<li class='nav-item dropdown d-none d-lg-block'>
                <a class='nav-link btn btn-success create-new-button' id='createbuttonDropdown' data-toggle='dropdown' aria-expanded='false' href='#'>+ Add ...</a>
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