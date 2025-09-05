<?php 
     include "../conn.php";
     //include "../nav.php";
     //include "../table.html";
    include "../tabs.html";
    include "../accordian.php";
    
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
    if(isset($_POST["meal_id"])){
        $sql= "update patients_meals set served =now() where p_meal_id =".$_POST["meal_id"];
        $result = $conn->query($sql);
    }
    if(isset($_POST["med_id"])){
        $sql= "INSERT INTO `patients_meds_count` (`p_med_id`, `created_by`, `time_ad`) VALUES ( '$_POST[med_id]', '".$_SESSION["user"][0]."', now())";
        $result = $conn->query($sql);
    }
    ?>
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
                <th>Patients</th>
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
                                    <th>Date</th><th>Patient Name</th><th>Meal</th><th>Served</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["meal_name"]."</td>
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
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, patients_meds.`p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, cast(patients_meds.`date` as date)'date', patients_meds.`apt_id`, COUNT(med_count_id) 'a_given',Sum(cast(patients_meds_count.time_ad as date) = cast(now() as date)) 'a_given_today',max(patients_meds_count.time_ad) 'last_ad'  FROM `patients_meds`
                        INNER JOIN medication on patients_meds.med_id = medication.med_id
                        INNER JOIN appointments on appointments.id = patients_meds.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        left JOIN patients_meds_count on patients_meds_count.p_med_id = patients_meds.p_med_id 
                        where check_out is null
                        GROUP by patients_meds.med_id
                        HAVING (per_day * num_days) != a_given;";
                        $result = $conn->query($sql);
                        ?>
                        <div class='table-responsive'>
                            <table class ='table' style="display:inline-block; width:600px;">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Patient Name</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity(Dose)</th><th>Doses(Total)</th><th>Doses(Today)</th><th>Last Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["med_name"]."</td>
                                            <td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_day"]*$row["num_days"]."</td><td>".$row["a_given"]."</td><td>".$row["a_given_today"]."</td><td>".$row["last_ad"]."</td><td>
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
                        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, patients_meds.`p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, cast(patients_meds.`date` as date)'date', patients_meds.`apt_id`, COUNT(med_count_id) 'a_given',Sum(cast(patients_meds_count.time_ad as date) = cast(now() as date)) 'a_given_today',max(patients_meds_count.time_ad) 'last_ad'  FROM `patients_meds`
                        INNER JOIN medication on patients_meds.med_id = medication.med_id
                        INNER JOIN appointments on appointments.id = patients_meds.apt_id
                        INNER JOIN patient on patient.pat_id = appointments.patient_id
                        left join (SELECT * from patients_beds WHERE end_date is null) pb
                        on appointments.id = pb.apt_id 
                        LEFT JOIN beds on pb.bed_id =  beds.bed_id
                        left JOIN patients_meds_count on patients_meds_count.p_med_id = patients_meds.p_med_id 
                        where check_out is null
                        GROUP by patients_meds.med_id
                        HAVING (per_day * num_days) = a_given;";?>
                        <div class='table-responsive'>
                            <table class ='table' style="display:inline-block; width:600px;">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Patient Name</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity(Dose)</th><th>Doses(Total)</th><th>Doses(Today)</th><th>Last Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["med_name"]."</td>
                                            <td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_day"]*$row["num_days"]."</td><td>".$row["a_given"]."</td><td>".$row["a_given_today"]."</td><td>".$row["last_ad"]."</td>";
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
        
          <!-- partial -->
        </div>


    <!-- Content for rooms tab -->






