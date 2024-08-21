<?php 
    include "../conn.php";
    include "../nav.php";
    include "../table.html";
    include "../tabs.html";
?>

<!DOCTYPE html>
<html>
<body>
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'consumption')" id="defaultOpen">Consumption</button>
    <button class="tablinks" onclick="openTab(event, 'topup')">Top Up</button>

</div>


   
<div id="consumption" class="tabcontent">
        <?php 
        $sql = "SELECT medstock.t_date,medication.med_id, med_name, COALESCE(CONCAT(patient.FName, ' ', patient.LName), dispense_to)AS 'Dispense To',
    medstock.quantity * -1 AS 'Stock'
FROM 
    medication 
INNER JOIN 
    medstock ON medstock.med_id = medication.med_id 
LEFT JOIN 
    appointments ON medstock.apt_id = appointments.id 
LEFT JOIN 
    patient ON patient.pat_id = appointments.patient_id 
WHERE 
    medstock.quantity < 0 
ORDER BY 
    t_date;;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Medication</th><th>Dispense To</th><th>Quantity</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $string = "<tr><td>".$row["t_date"]."</td><td>".$row["med_name"]."</td><td>".$row["Dispense To"]."</td><td>".$row["Stock"]."</td></tr>";
            echo $string;
            }
        }
        echo "</table>";
    ?>
</div>

<div id="topup" class="tabcontent">
        <?php 
        $sql = "SELECT medstock.t_date, medication.med_id, med_name,medstock.quantity AS 'Stock' FROM medication 
        INNER JOIN medstock ON medstock.med_id = medication.med_id 
        WHERE medstock.quantity >0
        order by t_date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Medication</th><th>Quantity</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $string = "<tr><td>".$row["t_date"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
            echo $string;
            }     
        }
        echo "</table>";
    ?>
</div>
    
</body>
</html>
<?php
    $conn->close();
?>