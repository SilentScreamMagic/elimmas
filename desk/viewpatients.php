<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
$sql = "SELECT patient.pat_id,concat(Fname,' ',LName) 'Patient Name' FROM patient";
$result = $conn->query($sql);
?>
<a href="./addpatient.html">Add Patient</a>
<?php
echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Patient ID</th><th>Patient Name</th><th></th></tr>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           echo "<tbody><tr><td>".$row["pat_id"]."</td><td>".$row["Patient Name"]."</td></td>
        <td> 
        <div style ='display: inline-block; '>
            <form action='apthistory.php' method='post'>
                <input type='hidden' name='id' value=".$row['pat_id'].">
                <input style='width: 30px; height: 30px;' type='submit' value='&#128065;'>
            </form>
        </div>
        <div style ='display: inline-block;'>
            <form action='Addappointment.php' method='post'>
                <input type='hidden' name='id' value='".$row['pat_id']."'>
                <input style='width: 30px; height: 30px;' type='submit' value='+'>
            </form>
        </div>
        </td>
        
        </tr>";
        }
        echo "</tbody></table></div></div>";
    } 
}
    $conn->close();
?>