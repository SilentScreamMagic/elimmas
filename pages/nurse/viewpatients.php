<?php
include "../conn.php";
include "../searchbar2.php";
//include "../table.html";


?>
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
    <?php include "../nav.php";
    if(isset($_POST["bed"])){
      $sql = "INSERT INTO `patients_beds` ( `bed_id`, `apt_id`, `start_date`,created_by) 
              VALUES ( $_POST[bed],$_POST[apt_id], now(),'".$_SESSION["user"][0]."')";
      $conn->query($sql);
      $sql = "update beds set status = 'occupied' where bed_id = $_POST[bed]";
      $conn->query($sql);
  }
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
  
$sql = "SELECT patient.pat_id, appointments.date,concat(Fname,' ',LName) 'Patient Name',appointments.type,
COALESCE(beds.room_id,'N/A')'Room', COALESCE(beds.bed_id,'N/A')'Bed',
appointments.id,appointments.check_in, 
case 
when nt.notes is null then 'Pending'
else 'Ready'
end as 'dis_notes'
FROM appointments 
INNER join patient on appointments.patient_id = patient.pat_id
Left JOIN (SELECT apt_id,notes from notes WHERE type = 'dis_notes') nt on nt.apt_id = appointments.id
left join patients_beds pb on appointments.id = pb.apt_id 
Left join beds on beds.bed_id = pb.bed_id
 where type = 'In-Patient' and check_in is not null and check_out is null
 order by appointments.date;";
$result = $conn->query($sql);
    ?>
  <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Appointments</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">

                        <?php 
                        $sql = "SELECT COUNT(*) AS total_app, COALESCE(SUM(CASE WHEN check_in is not null THEN 1 ELSE 0 END),0) AS arrived_app FROM appointments where check_out is null and date = 'date(Y-m-d)';";
                        $app = $conn->query($sql)->fetch_assoc();
                        ?>
                          <h2 class="mb-0"><?php echo $app["total_app"]?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo "Arrivals: $app[arrived_app]"?></h6>
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
                    <h5>Current Patients</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                        <?php 
                        $sql = "SELECT COUNT(DISTINCT id) AS tot_patients,COALESCE(SUM(CASE WHEN notes.type = 'dis_notes'  THEN 1 ELSE 0 END),0) AS dis_ready FROM appointments 
left JOIN notes on notes.apt_id = appointments.id
where check_in is not null and check_out is null and appointments.type = 'In-Patient';";
                        $app = $conn->query($sql)->fetch_assoc();
                        ?>
                          <h2 class="mb-0"><?php echo $app["tot_patients"]?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo "Discharge Ready: $app[dis_ready]"?></h6>
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
                    <h5>Tasks</h5>
                    <div class="row">
                      <div class="col-10 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <?php 
                          $sql ="SELECT 
                                (tasks.total_meds + tasks.total_meals) AS total_tasks,
                                tasks.total_meds,
                                tasks.total_meals 
                            FROM (
                                SELECT
                                    (SELECT COUNT(*) FROM patients_meds pm
                                    JOIN appointments a ON pm.apt_id = a.id
                                    WHERE pm.time_ad IS NULL AND a.check_out IS NULL) AS total_meds,

                                    (SELECT COUNT(*) FROM patients_meals pml
                                    JOIN appointments a ON pml.apt_id = a.id
                                    WHERE pml.served IS NULL AND a.check_out IS NULL) AS total_meals
                            ) AS tasks
                            LIMIT 1;";
                            $task = $conn->query($sql)->fetch_assoc();
                          ?>

                          <h2 class="mb-0"><?php echo $task["total_tasks"]?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo "Meds Pending: ".$task["total_meds"] ."<br> Meals Pending: ".$task["total_meals"]?></h6>
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
                    <h4 class="card-title">Current Patients</h4>
                    
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
                                $sel="";
                                if ($row["Room"]=="N/A"){
                                  $sel = "<td><form action='' method='post'>
                                  <select name='bed' id='bed' required>
                                  <option value='' disabled selected>Select a Room and Bed...</option>";
                                  foreach ($rooms as $rid =>$beds):
                                      foreach($beds as $bid)
                                      $sel = $sel. "<option value='$bid'>Ward $rid Bed $bid </option>";
                                      endforeach;
                                      $sel = $sel.'</select>
                                       <input type="hidden" name ="apt_id" value='.$row['id'].'>
                                      <input type="submit" value="Arrival Time">
                                      </form></td>';
                                  }
                                  echo $sel;
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
          
        </div>
