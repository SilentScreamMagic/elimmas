<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
include "../tabs.html";

   
?>
<html>
    <body>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'cur_pat')" id="defaultOpen">Current Patient</button>
            <button class="tablinks" onclick="openTab(event, 'all_pat')" >All Patient</button>
        </div> 
        <div id="cur_pat" class="tabcontent">
            <?php
            $sql = "SELECT patient.pat_id, appointments.date,concat(Fname,' ',LName) 'Patient Name',appointments.type,COALESCE(beds.room_id,'Accomodation Pending')'Room', COALESCE(beds.bed_id,'Accomodation Pending')'Bed',appointments.id,appointments.check_in FROM appointments 
                INNER join patient on appointments.patient_id = patient.pat_id
                left join (SELECT * from patients_beds WHERE end_date is null) pb on appointments.id = pb.apt_id 
                Left join beds on beds.bed_id = pb.bed_id
                where check_in is not null and check_out is null
                order by appointments.date;";
            $result = $conn->query($sql);
            echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Date</th><th>Patient Name</th><th>Type</th><th>Arrival</th><th>Ward</th><th>Bed</th><th></th></tr>";
            if ($result->num_rows > 0) {
                echo "<tbody>";
                    while($row = $result->fetch_assoc()) {
                        $room =$row["Room"];
                        $bed = $row["Bed"];
                        if ($row['type'] =="Consultation"){
                            $room ="N/A";
                            $bed = "N/A";
                        }
                        $string = "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["type"]."</td><td>".$row["check_in"]."</td><td>".$room."</td><td>".$bed."</td>";
                    $string = $string . "<td><form action='docapthistory.php' method='post'>
                        <input type='hidden' name='id' value=".$row['pat_id'].">
                        <input type='submit' value='View Appointment History'>
                    </form></td>
                    </tr>";
                    
                    echo $string;
                    }
                    
                    echo "</tbody></table></div></div>";
                } 
            
            ?>

        </div>
        <div id="all_pat" class="tabcontent">
        <?php
            $sql = "SELECT registration_date,patient.pat_id, concat(Fname,' ',LName) 'Patient Name' FROM patient
            order by 'Patient Name';";
            $result = $conn->query($sql);
            echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Registration Date</th><th>Patient Name</th><th></th></tr>";
            if ($result->num_rows > 0) {
                echo "<tbody>";
                    while($row = $result->fetch_assoc()) {
                        $string = "<tbody><tr><td>".$row["registration_date"]."</td><td>".$row["Patient Name"]."</td>";
                    $string = $string . "<td><form action='docapthistory.php' method='post'>
                        <input type='hidden' name='id' value=".$row['pat_id'].">
                        <input type='submit' value='View Appointment History'>
                    </form></td>
                    </tr>";
                    
                    echo $string;
                    }
                    
                    echo "</tbody></table></div></div>";
                } 
                $conn->close();
            ?>   
        </div>
    </body>
   
</html>
