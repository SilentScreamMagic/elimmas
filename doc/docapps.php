<?php
require_once "../conn.php";
include "../nav.php";
include "../table.html";
$date = date("Y-m-d");

if (isset($_POST["appt_date"])){
    $date = date("Y-m-d",strtotime($_POST["appt_date"]));
}
?>

<html>
    <body>
        <h1><?php echo $date; ?></h1>
    <form action= "" method="post">
    <label for="appt_date" >Date:</label>
    <input type="date" id="appt_date" name="appt_date">
    <input type="submit" value="Submit"><br><br>
    </form>
    </body>
</html>

<?php

$sql = "SELECT appointments.id,concat(pr.Fname,' ',pr.LName) as 'Patient Name',appointments.date,appointments.time, appointments.check_in
FROM patient pr 
join appointments on pr.pat_id = appointments.patient_id
where appointments.date = '$date' and doc_id = '".$_SESSION["user"][0]."'";

$result = $conn->query($sql);

echo "<div class='container'> <div class='table-wrapper'><thead>";
echo "<table><tr><th>Patient Name</th><th>Date</th><th>Time</th><th>Arrived</th><th>Check In</th></tr></thead>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $string = "<tr><td>".$row["Patient Name"]."</td><td>".$row["date"]."</td><td>".$row["time"]."</td><td>".$row["check_in"]."</td>
            <td><form action='docprocs.php' method='post'>
                <input type='hidden' name='id' value=".$row['id'].">
                <input type='submit' value='View Patient'>
            </form></td></tr>";
            }
            echo $string;
        }
        echo "</tbody></table></div></di>";
    } 
    
    $conn->close();
?>
