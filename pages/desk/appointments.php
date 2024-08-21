
<?php
require_once "../conn.php";
include "../nav.php";
include "../table.html";
$date = date("Y-m-d");

if (isset($_POST["appt_date"])){
    $date = date("Y-m-d",strtotime($_POST["appt_date"]));
}
if (isset($_POST['id'])){
    $date = $_POST["cdate"];
    $sql = "update appointments set check_in = now() where id =".$_POST["id"];
    $result = $conn->query($sql);
    if(isset($_POST["bed"])){
        $sql = "INSERT INTO `patients_beds` ( `bed_id`, `apt_id`, `start_date`) 
                VALUES ( $_POST[bed],$_POST[id], now())";
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

$sql = "SELECT pr.pat_id ,appointments.id,concat(pr.Fname,' ',pr.LName) as 'Patient Name',appointments.date,appointments.time,appointments.type, appointments.check_in
FROM patient pr 
join appointments on pr.pat_id = appointments.patient_id
where appointments.date = '$date' ;";

$result = $conn->query($sql);


echo "<table><tr><th>Date</th><th>Patient Name</th><th>Type</th><th>Time</th><th>Arrived</th></tr>";

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
        echo "</table>";
    } 
}
    
    $conn->close();
?>
