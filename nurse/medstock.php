<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
include "../tabs.html";

    ?>
<html>
    <body>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'nurse')" id="defaultOpen"> Nurse</button>
            <button class="tablinks" onclick="openTab(event, 'theatre')"> Theatre</button>
        </div>
        <div id="nurse" class="tabcontent">
            <?php
                $sql = "SELECT medication.med_id, med_name, -1*COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
                FROM medication
                LEFT JOIN medstock ON medstock.med_id = medication.med_id
                where quantity <0 and dispense_to = 'Nurses'
                GROUP BY med_id;";
                $result = $conn->query($sql);
                
                echo "<table><tr><th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th></tr>";
                
                if ($result){ 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
                        }
                        echo "</table>";
                    } 
                }else {
                    echo "</table>";
                }
            ?>
        </div>
        <div id="theatre" class="tabcontent">
            <?php
                $sql = "SELECT medication.med_id, med_name, -1*COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
                FROM medication
                LEFT JOIN medstock ON medstock.med_id = medication.med_id
                where quantity <0 and dispense_to = 'Theatre'
                GROUP BY med_id;";
                $result = $conn->query($sql);
                
                echo "<table><tr><th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th></tr>";
                
                if ($result){ 
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td></tr>";
                        }
                        echo "</table>";
                    } 
                }else {
                    echo "</table>";
                }
            ?>
        </div>
    </body>
    
</div>