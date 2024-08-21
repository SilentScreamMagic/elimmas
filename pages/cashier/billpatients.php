<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
$sql = "SELECT patient.pat_id, patient.registration_date 'date',concat(Fname,' ',LName) 'Patient Name' FROM patient 
 order by `Patient Name` ;";
$result = $conn->query($sql);
?>
<?php
echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Registration Date</th><th>Patient Name</th><th></th></tr>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td>
        <td> 
        <div style ='display: inline-block;'>
            <form action='patapthistory.php' method='post'>
                <input type='hidden' name='id' value=".$row['pat_id'].">
                <input style='width: 30px; height: 30px;' type='submit' value='&#128065;'>
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