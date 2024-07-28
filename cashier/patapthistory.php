<?php
 include "../conn.php";
 include "../nav.php";
 include "../table.html";
$pat_id = $_POST["id"];
$sql = "SELECT concat(patient.FName,' ', patient.LName)'Patient Name' FROM patient where pat_id = $_POST[id]";
$result = $conn->query($sql)->fetch_assoc();
echo "<h2>".$result['Patient Name']."</h2>";
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Patient Details</title>
</head>
<body>


    <?php
$sql = "SELECT patient_id, concat(patient.FName,' ', patient.LName)'Patient Name',appointments.*, users.Name FROM `appointments`
 inner join patient on patient.pat_id = appointments.patient_id
 INNER join users on users.username = appointments.doc_id
 WHERE patient_id = $pat_id;";
$result = $conn->query($sql);

echo "<div class='container'> <div class='table-wrapper'><thead>";
echo "<table><tr><th>Doctor Name</th><th>Date</th><th>Time</th><th>Type</th><th>Check in</th><th>Check out</th><th></th><th></th></tr></thead>";
 if ($result->num_rows > 0) {
     echo "<tbody>";
     while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["Name"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["type"].
            "</td><td>".$row["check_in"]."</td><td>".$row["check_out"]."</td>";
            
            if ($row["check_out"]){
                echo "<td>
            <form action='discharge.php' target='_blank' method='post'>
            <input type='hidden' name='id' value=".$row["id"].">
            <input type='submit' value='Create Bill'>
        </form></td>
        <td> 
            <form action='discharge notes.php' target='_blank' method='post'>
            <input type='hidden' name='id' value=".$row["id"].">
            <input type='submit' value='Create Discharge Notes'>
        </form></td></tr>";
            }
 }
 echo "</tbody></table>";
}
  else {
     echo "0 results";
 }
            $conn->close();
            ?>
            </div>
</div>

	
    