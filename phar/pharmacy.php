<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
if(isset($_POST["med_id"])){
    $sql = "insert into medstock(med_id, quantity,t_date) 
    values(".$_POST["med_id"].",".$_POST["med_count"].",now())";
    $result = $conn->query($sql);
}

$sql = "SELECT medication.med_id, med_name, COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
FROM medication
LEFT JOIN medstock ON medstock.med_id = medication.med_id
GROUP BY med_id;";
$result = $conn->query($sql);

echo "<table><tr><th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th></tr>";

if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td>
        <td> 
        <form action='' method='post'>
            <input type='hidden' name='med_id' value=".$row['med_id'].">
            <input type='integer' name='med_count'>
            <input type='submit' value='Top Up'>
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