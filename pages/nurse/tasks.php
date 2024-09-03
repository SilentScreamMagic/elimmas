<?php 
     include "../conn.php";
     //include "../nav.php";
     //include "../table.html";
    include "../tabs.html";
    include "../accordian.php";
    if(isset($_POST["meal_id"])){
        $sql= "update patients_meals set served =now() where p_meal_id =".$_POST["meal_id"];
        $result = $conn->query($sql);
    }
    if(isset($_POST["med_id"])){
        $sql= "update patients_meds set time_ad =now() where p_med_id =".$_POST["med_id"];
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
                    <h4 class='card-title'>Current Patients</h4>
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'meals-pending')" id="defaultOpen">Meals</button>
                        <button class="tablinks" onclick="openTab(event, 'meds-pending')">Medications</button>

                    </div>


                    <div id="meals-pending" class="tabcontent">
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'meals-pending')">Pending</button>
                            <button class="tablinks" onclick="openTab(event, 'meals-completed')">Completed</button>
                        </div>
                        <?php 
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.bed_id, beds.room_id,`p_meal_id`, meals.meal_name, patients_meals.`date`, patients_meals.`apt_id`, `served` FROM `patients_meals`
                        INNER JOIN meals on patients_meals.meal_id = meals.meal_id
                        INNER JOIN appointments on appointments.id = patients_meals.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        where served is null and check_out is null;";
                        $result = $conn->query($sql);
                        ?>
                        <div class='table-responsive'>
    <table class='table'>
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Ward</th>
                <th>Meal</th>
                <th>Served</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $meals = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $meals[$row["Patient Name"]][] = [$row['p_meal_id'], $row["date"], $row["room_id"], $row["bed_id"], $row["meal_name"]];
                }
            }

            foreach ($meals as $name => $meal) {
                echo "<tr>
                        <td colspan='5'><button class='accordion' onclick='openAcc(`panel_$name`)'>".$name."</button></td>
                      </tr>
                      <tr id='panel_$name' class='panel' style='display: none;'>";
                foreach ($meal as $key => $dets) {
                    $string = "<td>".$dets[1]."</td>
                               <td> Ward: ".$dets[2]." Bed: ".$dets[3]."</td>
                               <td>".$dets[4]."</td>
                               <td>
                                   <form action='' method='post'>
                                       <input type='hidden' name='meal_id' value=".$dets[0].">
                                       <input type='submit' value='Served!'>
                                   </form>
                               </td>";
                    echo $string;
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
                 
                        
                    </div>
                    <div id="meals-completed" class="tabcontent">
                    <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'meals-pending')">Pending</button>
                            <button class="tablinks" onclick="openTab(event, 'meals-completed')">Completed</button>
                        </div>
                    <?php 
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, `p_meal_id`, meals.meal_name, patients_meals.`date`, patients_meals.`apt_id`, `served` FROM `patients_meals`
                        INNER JOIN meals on patients_meals.meal_id = meals.meal_id
                        INNER JOIN appointments on appointments.id = patients_meals.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        where served is not null and check_out is null;";
                        $result = $conn->query($sql);
                        ?>
                        <div class='table-responsive'>    
                            <table class ='table'>
                            <thead>
                                <tr>
                                    <th>Date</th><th>Patient Name</th><th>Ward</th><th>Meal</th><th>Served</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"] ."</td><td>".$row["meal_name"]."</td>
                                        <td> ".$row["served"]."</td></tr>";
                                    echo $string;
                                    }
                                    
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="meds-pending" class="tabcontent">
                    <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'meds-pending')">Pending</button>
                            <button class="tablinks" onclick="openTab(event, 'meds-completed')">Completed</button>

                        </div>
                        <?php 
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, `p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, patients_meds.`date`, patients_meds.`apt_id`, time_ad FROM `patients_meds`
                        INNER JOIN medication on patients_meds.med_id = medication.med_id
                        INNER JOIN appointments on appointments.id = patients_meds.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        where time_ad is null and check_out is null;";
                        $result = $conn->query($sql);
                        ?>
                        <div class='table-responsive'>
                            <table class ='table'>
                            <thead>
                                <tr>
                                    <th>Date</th><th>Patient Name</th><th>Ward</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Administered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"]."</td><td>".$row["med_name"]."</td>
                                            <td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_dose"]*$row["per_day"]*$row["num_days"]."</td><td>".$row["num_months"]."</td><td>
                                            <form action='' method='post'>
                                            <input type='hidden' name='med_id' value=".$row['p_med_id'].">
                                            <input type='submit' value='Served!'>
                                        </form></td></tr>";
                                        echo $string;
                                        }
                                        
                                    }
                            
                                ?>
                            </tbody>
                            </table>
                        </div>
                       
                    </div>  
                    <div id="meds-completed" class="tabcontent">
                    <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'meds-pending')">Pending</button>
                            <button class="tablinks" onclick="openTab(event, 'meds-completed')">Completed</button>

                        </div>
                    <?php 
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, 
                        `p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, patients_meds.`date`, patients_meds.`apt_id`, time_ad FROM `patients_meds`
                        INNER JOIN medication on patients_meds.med_id = medication.med_id
                        INNER JOIN appointments on appointments.id = patients_meds.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        where time_ad is not null and check_out is null;";?>
                        <div class='table-responsive'>
                            <table class ='table'>
                            <thead>
                                <tr>
                                    <th>Date</th><th>Patient Name</th><th>Ward</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Administered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"]."</td><td>".$row["med_name"]."</td>
                                        <td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_dose"]*$row["per_day"]*$row["num_days"]."</td><td>".$row["num_months"]."</td><td>".$row["time_ad"]."</td></tr>";
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


    <!-- Content for rooms tab -->






