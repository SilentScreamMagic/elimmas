<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
include "../searchbar2.php";
if(isset($_POST["med_id"])){
    $sql = "insert into medstock(med_id, quantity,t_date,dispense_to) 
    values(".$_POST["med_id"].",-".$_POST["med_count"].",now(),'".$_POST["to"]."')";
    $result = $conn->query($sql);
}

$sql = "SELECT medication.med_id, med_name, COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
FROM medication
LEFT JOIN medstock ON medstock.med_id = medication.med_id
GROUP BY med_id;";
$result = $conn->query($sql);
echo "<input type='text' id='tableFilterInput' class='dropdown-input' placeholder='Filter by column value...'>";
echo "<table id='filterTable'><tr><th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th></tr>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td>
        <td> 
        <form action='' method='post'>
            <input type='hidden' name='med_id' value=".$row['med_id'].">
            
            <input type='integer' name='med_count'>
            <input type='submit' value='Dispense To'>
            <select name='to' required>
                <option value = ''>Select who to dispense to</option>
                <option value = 'Theatre'>Theatre</option>
                <option value = 'Nurses'>Nurses</option>
            </select>
        </form>
       </td>
        </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}else {
    echo "0 results";
}
    $conn->close();
