
    <!DOCTYPE html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
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
    require_once "../conn.php";
    //include "../nav.php";
    //include "../table.html";
    $date = date("Y-m-d");
    
    if (isset($_POST["appt_date"])){
        $date = date("Y-m-d",strtotime($_POST["appt_date"]));
    }
    if (isset($_POST['id'])){
        $date = $_POST["cdate"];
        $sql = "update appointments set check_in = now() where id =".$_POST["id"];
        $result = $conn->query($sql);
        if(isset($_POST["bed"])){
            $sql = "INSERT INTO `patients_beds` ( `bed_id`, `apt_id`, `start_date`,created_by) 
                    VALUES ( $_POST[bed],$_POST[id], now(),'".$_SESSION["user"][0]."')";
            $conn->query($sql);
            $sql = "update beds set status = 'occupied' where bed_id = $_POST[bed]";
        }
    }
    $sql = "SELECT room_id, bed_id,status FROM `beds` 
        where status = 'clean'
        order by beds.bed_id;";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
        $rooms = array();
        while ($row = $result->fetch_assoc()) {
            $rooms[$row["room_id"]][] = $row["bed_id"];
        }
    }
    $sql = "SELECT pr.pat_id ,appointments.id,concat(pr.Fname,' ',pr.LName) as 'Patient Name',appointments.date,appointments.time,appointments.type, appointments.check_in
    FROM patient pr 
    join appointments on pr.pat_id = appointments.patient_id
    where appointments.date = '$date' and check_out is null;";
    
    $result = $conn->query($sql);?>
    
    
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                <h1><?php echo $date; ?></h1>
                <form action= "" method="post">
    <label for="appt_date" >Date:</label>
    <input type="date" id="appt_date" name="appt_date">
    <input type="submit" value="Submit"><br><br>
    </form>
                  <div class='card-body'>
                    <h4 class='card-title'>Appointments</h4>
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Date</th>
                            <th>Patient Name</th>
                            <th>Type</th>
                            <th>Time</th>
                            <th>Arrived</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $string="";
                            if ($result){ 
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["type"]."</td><td>".$row["time"]."</td>";
                                        $sel="";
                                        if ($row["type"]=="In-Patient"){
                                            $sel = "
                                            <select name='bed' id='bed' required>
                                            <option value='' disabled selected>Select a Room and Bed...</option>";
                                            foreach ($rooms as $rid =>$beds):
                                                foreach($beds as $bid)
                                                $sel = $sel. "<option value='$bid'>Ward $rid Bed $bid </option>";
                                                endforeach;
                                                $sel = $sel.'</select>';
                                            }else{
                                                $sel = $sel."N/A";
                                            }
                                        if ($row["check_in"]!= null){
                                            $string = $string. "<td>".$row["check_in"]." 
                                            <form class ='display: inline-block;' action='apthistory.php' method='post'>
                                                <input type='hidden' name='id' value=".$row['pat_id'].">
                                                <input type='submit' value='&#128065;'>
                                            </form></td><td><form class ='display: inline-block;' action='vitals.php' method='post'>
                                                <input type='hidden' name='id' value=".$row['id'].">
                                                <input type='submit' value='Take Vitals'>
                                            </form></td></tr>";
                                        }else{
                                            $string = $string . "<td><form action='' method='post'>
                                            <input type='hidden' name='id' value=".$row['id'].">
                                            <input type='hidden' name='cdate' value=$date>
                                            $sel
                                            <input type='submit' value='Arrival Time'>
                                        </form></td></tr>";
                                        }
                                        echo $string;
                                    }
                                    //echo "</table>";
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
    </body>
</html>
<script>
    document.getElementById('create').innerHTML +=`<li class='nav-item dropdown d-none d-lg-block'>
                <a class='nav-link btn btn-success create-new-button' id='createbuttonDropdown' data-toggle='dropdown' aria-expanded='false' href='#'>+ Add ...</a>
                <div class='dropdown-menu dropdown-menu-right navbar-dropdown preview-list' aria-labelledby='createbuttonDropdown'>
                  <h6 class='p-3 mb-0'>Projects</h6>
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


