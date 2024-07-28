<?php 
     include "../conn.php";
     include "../nav.php";
     include "../table.html";
    include "../tabs.html";
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
<html>
<body>
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'meals')" id="defaultOpen">Meals</button>
    <button class="tablinks" onclick="openTab(event, 'meds')">Medications</button>

</div>

<div id="meals" class="tabcontent">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'meals-pending')">Pending</button>
        <button class="tablinks" onclick="openTab(event, 'meals-completed')">Completed</button>

    </div>
</div>
<div id="meds" class="tabcontent">
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'meds-pending')">Pending</button>
        <button class="tablinks" onclick="openTab(event, 'meds-completed')">Completed</button>

    </div>
</div>

    <!-- Content for rooms tab -->
<div id="meals-pending" class="tabcontent">
        <?php 
        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.bed_id, beds.room_id,`p_meal_id`, meals.meal_name, patients_meals.`date`, patients_meals.`apt_id`, `served` FROM `patients_meals`
INNER JOIN meals on patients_meals.meal_id = meals.meal_id
INNER JOIN appointments on appointments.id = patients_meals.apt_id
INNER JOIN patient on patient.pat_id = appointments.patient_id
left join (SELECT * from patients_beds WHERE end_date is null) pb
 on appointments.id = pb.apt_id 
LEFT JOIN beds on pb.bed_id =  beds.bed_id
where served is null;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Patient Name</th><th>Ward</th><th>Meal</th><th>Served</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"]."</td><td>".$row["meal_name"]."</td>
                <td><form action='' method='post'>
                <input type='hidden' name='meal_id' value=".$row['p_meal_id'].">
                <input type='submit' value='Served!'>
            </form></td></tr>";
            echo $string;
            }
            
        }
        echo "</table>";
    ?>
</div>
<div id="meals-completed" class="tabcontent">
        <?php 
        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, `p_meal_id`, meals.meal_name, patients_meals.`date`, patients_meals.`apt_id`, `served` FROM `patients_meals`
INNER JOIN meals on patients_meals.meal_id = meals.meal_id
INNER JOIN appointments on appointments.id = patients_meals.apt_id
INNER JOIN patient on patient.pat_id = appointments.patient_id
left join (SELECT * from patients_beds WHERE end_date is null) pb
 on appointments.id = pb.apt_id 
LEFT JOIN beds on pb.bed_id =  beds.bed_id
where served is not null;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Patient Name</th><th>Ward</th><th>Meal</th><th>Served</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"] ."</td><td>".$row["meal_name"]."</td>
                <td> ".$row["served"]."</td></tr>";
            echo $string;
            }
            
        }
        echo "</table>";
    ?>
</div>

<div id="meds-pending" class="tabcontent">
        <?php 
        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, `p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, patients_meds.`date`, patients_meds.`apt_id`, time_ad FROM `patients_meds`
INNER JOIN medication on patients_meds.med_id = medication.med_id
INNER JOIN appointments on appointments.id = patients_meds.apt_id
INNER JOIN patient on patient.pat_id = appointments.patient_id
left join (SELECT * from patients_beds WHERE end_date is null) pb
 on appointments.id = pb.apt_id 
LEFT JOIN beds on pb.bed_id =  beds.bed_id
where time_ad is null;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Patient Name</th><th>Ward</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Administered</th></tr>";
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
        echo "</table>";
    ?>
</div>


<div id="meds-completed" class="tabcontent">
        <?php 
        $sql = "SELECT concat(patient.FName,' ',patient.LName) 'Patient Name',beds.room_id,beds.bed_id, 
        `p_med_id`,per_dose,per_day,num_days,num_months, medication.med_name, patients_meds.`date`, patients_meds.`apt_id`, time_ad FROM `patients_meds`
INNER JOIN medication on patients_meds.med_id = medication.med_id
INNER JOIN appointments on appointments.id = patients_meds.apt_id
INNER JOIN patient on patient.pat_id = appointments.patient_id
left join (SELECT * from patients_beds WHERE end_date is null) pb
 on appointments.id = pb.apt_id 
LEFT JOIN beds on pb.bed_id =  beds.bed_id
where time_ad is not null;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Patient Name</th><th>Ward</th><th>Medications</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Administered</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $string = "<tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td> Ward: ".$row["room_id"]." Bed ".$row["bed_id"]."</td><td>".$row["med_name"]."</td>
                <td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_dose"]*$row["per_day"]*$row["num_days"]."</td><td>".$row["num_months"]."</td><td>".$row["time_ad"]."</td></tr>";
            echo $string;
            }
            
        }
        echo "</table>";
    ?>
</div>
    
</body>
</html>
<?php
    $conn->close();
?>