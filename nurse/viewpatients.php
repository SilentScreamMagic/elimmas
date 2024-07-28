<?php
include "../conn.php";
include "../nav.php";
include "../table.html";

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
<?php
echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Date</th><th>Patient Name</th><th>Type</th><th>Arrival</th><th>Ward</th><th>Bed</th><th>Discharge Notes</th><th></th><th></th></tr>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["type"]."</td><td>".$row["check_in"]."</td><td>".$row["Room"]."</td><td>".$row["Bed"]."</td><td>".$row["dis_notes"]."</td>
        <td> 
        <div>
            <form action='viewpatient.php' method='post'>
                <input type='hidden' name='id' value=".$row['id'].">
                <input style='width: 30px; height: 30px;' type='submit' value='&#128065;'>
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
        echo "</tr></tbody></table></div></div>";
    } 
}
    $conn->close();
?>