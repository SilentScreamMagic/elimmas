<?php
    include "../conn.php";
    include "../nav.php";
    include "../table.html";
    include "../tabs.html";
    if(isset($_POST["id"])){
        $_SESSION["id"] = $_POST["id"];
        $sql ='SELECT patient.pat_id,concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
        where id = '.$_SESSION["id"];
        $result = $conn->query($sql)->fetch_assoc();
        $pname = $result["Patient Name"];
    }
    if(isset($_POST["med_id"])){
        $sql = "insert into medstock(med_id, quantity,apt_id,t_date) 
        values(".$_POST["med_id"].",-".$_POST["med_count"].",".$_POST["apt_id"].",now())";

        $result = $conn->query($sql);
    }
?>
<html>
    <body>
    
    <h1><?php echo $pname?></h1>
    <h3>Medications</h3>
    <?php 
        $sql = "SELECT pm.med_id, pm.apt_id, pm.date,
    m.med_name ,pm.per_dose,pm.per_day,sum(pm.num_days) 'num_days',sum(pm.num_months) 'num_months',
    sum(meds_requested.requested) AS 'Meds Requested',-1*COALESCE(meds_provided.provided, 0) AS 'Meds Provided',
    (sum(meds_requested.requested) + COALESCE(meds_provided.provided, 0)) AS 'Difference' FROM  patients_meds pm
JOIN medication m ON m.med_id = pm.med_id 
JOIN appointments a ON a.id = pm.apt_id
JOIN patient p ON p.pat_id = a.patient_id
LEFT JOIN (SELECT med_id, apt_id,per_dose * per_day * num_days AS requested FROM patients_meds 
GROUP BY med_id, apt_id) AS meds_requested ON pm.med_id = meds_requested.med_id AND pm.apt_id = meds_requested.apt_id
LEFT JOIN (SELECT med_id, apt_id, sum(quantity) AS provided FROM medstock 
GROUP BY med_id, apt_id ) AS meds_provided ON pm.med_id = meds_provided.med_id AND pm.apt_id = meds_provided.apt_id
WHERE pm.time_ad IS NULL and pm.apt_id=".$_SESSION["id"]."
GROUP BY med_id, apt_id
ORDER BY pm.date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Medication</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Meds Requested</th><th>Meds Provided</th><th>Remainder</th><th>Dispense</th><th></th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_dose"]*$row["per_day"]*$row["num_days"]."</td><td>".$row["num_months"]."</td><td>".$row["Meds Requested"]."</td><td>".$row["Meds Provided"]."</td><td>".$row["Difference"]."</td><td>
        <form action='' method='post'>
            
            <input type='hidden' name='med_id' value=".$row['med_id'].">
            <input type='hidden' name='apt_id' value=".$row['apt_id'].">
            <label for='med_count'>Quantity Provided: </label><br>
            <input type='integer' id ='med_count' name='med_count'>
            <input type='submit' value='Dispense'>
        </form>
       </td>
        </tr>";
            }
        }
        echo "</table>";
        $conn->close();
    ?>
    </body>
</html>
