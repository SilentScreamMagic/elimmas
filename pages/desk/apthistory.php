<?php
 include "../conn.php";
 include "../nav.php";
 include "../table.html";
if(isset($_POST["id"])){
    $pat_id = $_POST["id"];
}
if(isset($_GET["id"])){
    $pat_id = $_GET["id"];
}
 

 $sql = "SELECT patient_id, concat(patient.FName,' ', patient.LName)'Patient Name',appointments.*, users.Name FROM `appointments`
 inner join patient on patient.pat_id = appointments.patient_id
 INNER join users on users.username = appointments.doc_id
 WHERE patient_id = $pat_id;";
 $result = $conn->query($sql);
 echo "<table><tr><th>ID</th><th>Patient Name</th><th>Doctor Name</th><th>Date</th><th>Time</th><th>Diagnosis</th>
 <th>Check in</th><th>Check out</th><th>Patient Condition</th><th>Resuscitation Status</th><th>Diet</th><th>Medication Prescribed</th><th></th></tr>";
 if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
            echo "<td>".$row["patient_id"]."</td><td>".$row["Patient Name"]."</td><td>".$row["Name"]."</td><td>".$row["date"]."</td><td>".$row["time"].
            "</td><td>".$row["diagnosis"]."</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td><td>".
            $row["patient_condition"]."</td><td>".$row["resuscitation_status"]."</td><td>".$row["diet"]."</td><td>".
            $row["medication_prescribed"]."</td></tr>"; 
            /*<form action='viewpatient.php' method='post'>
            <input type='hidden' name='id' value=".$row["id"].">
            <input type='submit' value='View Appointment Details'>
        </form></td>";*/
 }
}

 $conn->close();


    