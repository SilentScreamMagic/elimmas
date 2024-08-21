<?php
require_once "../conn.php";
include "../nav.php";
include "../table.html";
$date = date("Y-m-d");


?>


<?php

$sql = "SELECT apt_id,concat(Fname,' ',LName) 'Patient Name',COUNT(DISTINCT med_id)'Requests Pending' FROM `patients_meds` 
inner join appointments on patients_meds.apt_id = appointments.id
INNER join patient on appointments.patient_id =patient.pat_id
where patients_meds.time_ad is null
GROUP by apt_id;";

$result = $conn->query($sql);

echo "<div class='container'> <div class='table-wrapper'><thead>";
echo "<table><tr><th>Patient Name</th><th>Medication Requests Pending</th><th>Requests</th></tr></thead>";
 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $string = "<tr><td>".$row["Patient Name"]."</td><td>".$row["Requests Pending"]."</td>
            <td><form action='medicationapp.php' method='post'>
                <input type='hidden' name='id' value=".$row['apt_id'].">
                <input type='submit' value='View Requests'>
            </form></td></tr>";
           echo $string;
        }

            
        }
        echo "</tbody></table></div></di>";
    $conn->close();
?>

