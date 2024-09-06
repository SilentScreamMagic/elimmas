<th?php
    
?>
<!DOCTYPE html>
<html>

<body>
    <script> 
        function toggleTransparency(input) {
            if(document.getElementById(input).style.visibility == "visible"){
                document.getElementById(input).style.visibility = "hidden";
            }else{
                document.getElementById(input).style.visibility = "visible"
            }
        }
        function toggleExpand() {
            var div = document.getElementById('expandableDiv');
            div.classList.toggle('expanded');
        }
    </script>

<!DOCTYPE html>
<html lang='en'>
  
  <body>
  
  <div class='container-scroller'>
    <?php 
    include '../nav.php';
    include "../conn.php";
    //include "../nav.php";
    //include "../table.html";
    include "../tabs.html";
    include "../test.php";
    $date = date("y-m-d");
    $ids=["","","defaultOpen","","","",""];
    if (isset($_POST["id"])){
        $_SESSION["apt_id"] = $_POST["id"];
        
    }
    if(isset($_POST["date"])){
        $date = $_POST["date"];
        $ids = ["","","","","","","defaultOpen"];
    }
    $sql ='SELECT concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = '.$_SESSION["apt_id"];
    $result = $conn->query($sql)->fetch_assoc();
    $pname = $result["Patient Name"];
    if (isset($_POST["bed"])){
        $sql = "insert into patients_beds (apt_id,bed_id,start_date)
        values(".$_SESSION['apt_id'].",".$_POST["bed"].",now())";
        $result = $conn->query($sql);
        $sql = "update beds set beds.status = 'occupied' where bed_id = ".$_POST["bed"];
        $result = $conn->query($sql);
        $ids = ["defaultOpen","","","","","",""];
    }
  
    
    if (isset($_POST["cons"])){
        $sql = "insert into patients_cons(apt_id,con_id,count,date,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["cons"].",".$_POST["con_count"].",now(),'".$_SESSION["user"][0]."')";;
        $result = $conn->query($sql);
        
        $ids = ["","","","","defaultOpen","",""];
    }
    if (isset($_POST["meals"])){
        $sql = "insert into patients_meals(apt_id,meal_id,date,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["meals"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        
        $ids = ["","","","","","defaultOpen",""];
    }

    if (isset($_POST["btemp"])) {
        $sql = "INSERT INTO `patients_vits`( `date`, `apt_id`, `created_by`, `body_temp`, `pulse_rate`, `respiration_rate`, `systolic_bp`, `dystolic_bp`, `oxygen_sat`, `weight`) 
        VALUES (now(),$_SESSION[apt_id],'".$_SESSION["user"][0]."','$_POST[btemp]','$_POST[pulRate]','$_POST[respRate]','$_POST[sbloodPress]','$_POST[dbloodPress]','$_POST[oxysat]','$_POST[weight]')";
        $result = $conn->query($sql);
        $ids = ["","defaultOpen","","","","",""];
    }
    if (isset($_POST["nur_notes"])){
        $sql ="INSERT INTO `notes`( `type`, `apt_id`, `notes`, `date`,created_by) VALUES ('nur_notes',".$_SESSION['apt_id'].",'".$_POST['nur_notes']."',now(),'".$_SESSION["user"][0]."')";
         $result = $conn->query($sql);
         
         $ids = ["","","defaultOpen","","","",""];
     }
     if (isset($_POST["meds"])){
        $sql = "insert into patients_procmeds(apt_id,med_id,quantity,date,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["meds"].",".$_POST["med_count"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","defaultOpen","","",""];
    }
    if (isset($_POST["oral_type"])){
        $sql = "insert into fluid_intake ( oral_type, apt_id,amount, iv_type, iv_amount, date,created_by) 
        values('".$_POST["oral_type"]."',".$_SESSION['apt_id'].",".$_POST["o_amount"].",'".$_POST["iv_type"]."',".$_POST["iv_amount"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","","","","defaultOpen"];
    }
    if (isset($_POST["u_amount"])){
        $sql = "insert into fluid_output ( apt_id, u_amount,e_amount, d_amount, date,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["u_amount"].",'".$_POST["e_amount"]."',".$_POST["d_amount"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","","","","defaultOpen"];
    }
    if (isset($_POST["deltable"])){
        $sql = "UPDATE $_POST[deltable] SET `deleted`=1 WHERE $_POST[idtype] = $_POST[delid]";
        $result = $conn->query($sql);
    
     } 
    $sql = "SELECT b.bed_id, r.* FROM beds b JOIN rooms r ON b.room_id = r.room_id WHERE b.status = 'clean';";
    $result = $conn->query($sql);
    $wards = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $wards[$row["bed_id"]] = [$row["room_id"],$row["capacity"],$row["price"]];
        }
    }
    $sql = "SELECT * FROM consumables";
    $result = $conn->query($sql);
    $cons = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $cons[$row["con_id"]] = [$row["con_name"],$row["type"],$row["price"]];
        }
    }
    $sql = "SELECT * FROM meals";
    $result = $conn->query($sql);
    $meals = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $meals[$row["meal_id"]] = [$row["meal_name"],$row["price"]];
        }
    }
    $sql = "SELECT * FROM medication";
    $result = $conn->query($sql);
    $meds = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $meds[$row["med_id"]] = $row["med_name"];
        }
    }
   
   //* <button class="tablinks" onclick="openTab(event, 'rooms')" <?php if('defaultOpen'==$ids[0]) echo 'id ="'.$ids[0].'"';>Wards</button>
   ?>
  <script src="../../assets/vendors/chart.js/Chart.min.js"></script>
  
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
          <div class="col-md-9 grid-margin">
                <div class="card">
                <div class='card-body'>
                    <h4 class='card-title'><?php echo $pname?></h4>
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'notes')"  <?php if('defaultOpen'==$ids[2]) echo 'id ="'.$ids[2].'"';?>>Notes</button>
                            
                            <button class="tablinks" onclick="openTab(event, 'consumables')"  <?php if('defaultOpen'==$ids[4]) echo 'id ="'.$ids[4].'"';?>>Consumables</button>
                            <button class="tablinks" onclick="openTab(event, 'meal')"  <?php if('defaultOpen'==$ids[5]) echo 'id ="'.$ids[5].'"';?>>Meals</button>
                            <button class="tablinks" onclick="openTab(event, 'vitals')"  <?php if('defaultOpen'==$ids[1]) echo 'id ="'.$ids[1].'"';?>>Vitals</button>
                            <button class="tablinks" onclick="openTab(event, 'meds')"  <?php if('defaultOpen'==$ids[3]) echo 'id ="'.$ids[3].'"';?>>Procedural Medications</button>
                            <button class="tablinks" onclick="openTab(event, 'fluid')"  <?php if('defaultOpen'==$ids[6]) echo 'id ="'.$ids[6].'"';?>>Fluids</button>
                            <button class="tablinks" onclick=<?php echo "window.open('pregprogress.php?id=$_SESSION[apt_id]','_blank')";?>>Pregnancy Progress</button>

                        </div>
                        <div id="notes" class="tabcontent">
                                <h3>Notes</h3>
                                <form action= "" method="post">
                                    <textarea name="nur_notes" cols="50" rows="10"></textarea>
                                    <input type="submit" value="Submit"><br><br>
                                </form>
                                
                                
                        </div>   
                        <div id="rooms" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h3>Rooms</h3>
                            <p>List of rooms...</p>
                            
                            <form action= "viewpatient.php" method="post">
                                <label for="bed">Select an Option:</label>
                                <select name="bed" id="bed" required>
                                    <option value="">Select a accomodation...</option>
                                    <?php foreach ($wards as $bid => $dets): ?>
                                        <option value="<?php echo $bid; ?>"><?php echo "Ward ".$dets[0]." Bed ".$bid." - ".$dets[1]." in a room"; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <?php 
                                $sql = "SELECT assign_id,patients_beds.start_date,beds.bed_id ,rooms.room_id,rooms.capacity,patients_beds.start_date,patients_beds.end_date FROM `patients_beds` 
                                JOIN beds on beds.bed_id = patients_beds.bed_id 
                                join rooms on rooms.room_id = beds.room_id where apt_id = ".$_SESSION["apt_id"]." order by start_date;";

                                $result = $conn->query($sql);
                                ?>
                                <div class='table-responsive'>
                                
                                    <table class ='table'>
                                    <thead>
                                        <tr>
                                        <th></th><th>Date</th><th>Room No.</th><th>Bed No.</th><th>Start Date</th><th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['assign_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_bds'>
                                                <input type='hidden' name='idtype' value= 'assign_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["start_date"]."</td><td>".$row["room_id"]."</td><td>".$row["bed_id"]."</td><td>".$row["start_date"]."</td><td>".$row["end_date"]."</td></tr>";
                                                }
                                                
                                            }
                                        ?>

                                    </tbody>
                                    </table>
                                </div>
                        </div>
                        <div id="consumables" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h3>Cons</h3>
                            <p>List of Consumables...</p>
                            
                            <form action= "viewpatient.php" method="post">
                                <label for="cons">Select an Option:</label>
                                <div class="dropdown" id="dropdown3">
                                    <input type="text" placeholder="Search.." class="dropdown-input" data-dropdown="dropdown3">
                                    <div class="dropdown-content">
                                        <?php foreach ($cons as $cid => $dets): ?>
                                            <div data-value="<?php echo $cid; ?>"><?php echo $dets[1]." - ".$dets[0]; ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                </div>
                                <input type="hidden" name = "cons" id="selectedValue3">
                                <label for="con_count">Count</label>
                                <input type="number" name="con_count" id = "con_count">
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <?php 
                                $sql = "SELECT p_cons_id,date,consumables.con_name,consumables.type,consumables.price,patients_cons.count FROM `patients_cons` 
                                join consumables on consumables.con_id = patients_cons.con_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
                                $result = $conn->query($sql);?>
                                <div class='table-responsive'>
                                
                                    <table class ='table'>
                                        <thead>
                                            <tr>
                                                <th></th><th>Date</th><th>Type</th><th>Consumables Name</th><th>Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_cons_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_cons'>
                                                <input type='hidden' name='idtype' value= 'p_cons_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["date"]."</td><td>".$row["type"]."</td><td>".$row["con_name"]."</td><td>".$row["count"]."</td></tr>";
                                                }
                                                
                                            }
                                            echo "</table>";
                                        ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <div id="meal" class="tabcontent">
                        <!-- Content for rooms tab -->
                        <h3>Meals</h3>
                        <p>List of Meals...</p>
                        
                        <form action= "viewpatient.php" method="post">
                            <label for="meals">Select an Option:</label>
                            <select name="meals" id="meals">
                                <option value="">Select a Meals...</option>
                                <?php foreach ($meals as $mid => $dets): ?>
                                    <option value="<?php echo $mid; ?>"><?php echo $dets[0]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" value="Submit"><br><br>
                        </form>
                        <?php 
                            $sql = "SELECT p_meal_id,date,meals.meal_name,meals.price FROM `patients_meals` 
                            join meals on meals.meal_id = patients_meals.meal_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
                            $result = $conn->query($sql);?>
                            <div class='table-responsive'>
                    
                                <table class ='table'>
                                    <thead>
                                        <tr>
                                        <th></th><th>Date</th><th>Meals Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_meal_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_meals'>
                                                <input type='hidden' name='idtype' value= 'p_meal_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["date"]."</td><td>".$row["meal_name"]."</td></tr>";
                                        }
             
                                    }
                                ?>
                                    </tbody>
                                </table>
                            </div>      
                        </div>
                        <div id="meds" class="tabcontent">
                        <!-- Content for rooms tab -->
                        <h3>Medications</h3>
                        <p>List of Medications...</p>
                        <form action= "" method="post">
                        <label>Medication:</label>
                        <div class="dropdown" id="dropdown2">
                            <input type="text" placeholder="Search.." class="dropdown-input" data-dropdown="dropdown2">
                            <div class="dropdown-content">
                                <?php 
                                    foreach ($meds as $mid => $det): ?>
                                        <div data-value="<?php echo $mid; ?>"><?php echo $det; ?></div>
                                    <?php 
                                    endforeach;?>
                                </div>
                            </div>
                            <input type="hidden" name = "meds" id="selectedValue2">
                            <label for="med_count">Quantity</label>
                            <input type="number" name="med_count" id = "med_count" required>

                            <input type="submit" value="Submit"><br><br>    
                        </form>
                        
                        <?php 
                            $sql = "SELECT p_ppmeds_id,patients_procmeds.date,medication.med_name,medication.price,patients_procmeds.quantity FROM `patients_procmeds` 
                            join medication on medication.med_id = patients_procmeds.med_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
                            $result = $conn->query($sql);
                            ?>
                            <div class='table-responsive'>
                                <table class ='table'>
                                <thead>
                                    <tr>
                                        <th></th><th>Date</th><th>Medication Name</th><th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_ppmeds_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_procmeds'>
                                                <input type='hidden' name='idtype' value= 'p_ppmeds_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["quantity"]."</td></tr>";
                                }   
                            }
                        ?>
                                </tbody>
                                </table>
                            </div>
                           
                        </div>
                        <div id="vitals" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h3>Vitals</h3>
                            
                            <form action= "viewpatient.php" method="post">
                                <label for="btemp">Body Temperature:</label>
                                <input type="text" id="btemp" name="btemp" required>
                                <label for="pulRate">Pulse Rate:</label>
                                <input type="text" id="pulRate" name="pulRate" required><br>
                                <label for="respRate">Respiration Rate:</label>
                                <input type="text" id="respRate" name="respRate" required>
                                <label for="oxysat">Oxygen Saturation</label>
                                <input type="text" id="oxysat" name="oxysat" required ><br>
                                
                                <label for="sbloodPress">Systolic Blood Pressure</label>
                                <input type="text" id="sbloodPress" name="sbloodPress" required >
                                <label for="dbloodPress">Diastolic Blood Pressure</label>
                                <input type="text" id="dbloodPress" name="dbloodPress" required ><br>
                                <label for="weight">Weight</label>
                                <input type="text" id="weight" name="weight" required >
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <?php 
                                $sql = "SELECT * FROM `patients_vits` where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
                                $result = $conn->query($sql); 
                                ?>
                                <div class='table-responsive'>
                                    <table class ='table'>
                                    <thead>
                                        <tr>
                                            <th>Date</th><th>Body Temperature</th><th>Pulse Rate</th><th>Respiration Rate</th><th>Blood Pressure</th><th>Oxygen Saturation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                             if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>".$row["date"]."</td><td>".$row["body_temp"]."</td><td>".$row["pulse_rate"]."</td><td>".$row["respiration_rate"]."</td><td>".$row["systolic_bp"]."/".$row["dystolic_bp"]."</td><td>".$row["oxygen_sat"]."</td><td>".$row["weight"]."</td></tr>";
                                                }
                                              }
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
                        </div>
                        <div id="fluid" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h2>Fluid</h2>
                            <h3>Fluid Intake</h3>
                            <form action= "" method="post">
                                <label for="oral_type">Oral Type</label>
                                <input type="text" name="oral_type" id = "oral_type" required>
                                <label for="o_amount">Amount</label>
                                <input type="number" name="o_amount" id = "o_amount" required>
                                <label for="iv_type">IV Type</label>
                                <input type="text" name="iv_type" id = "iv_type" required>
                                <label for="iv_amount">amount</label>
                                <input type="number" name="iv_amount" id = "iv_amount" required>

                                <input type="submit" value="Submit"><br><br>    
                            </form>
                            <h3>Fluid Output</h3>
                            <form action= "" method="post">
                                <label for="u_amount">Urine Amount</label>
                                <input type="number" name="u_amount" id = "U_amount" required>
                                <label for="o_amount">Emesis Amount</label>
                                <input type="number" name="e_amount" id = "e_amount" required>
                                <label for="d_amount">Drainage Amount</label>
                                <input type="number" name="d_amount" id = "d_amount" required>

                                <input type="submit" value="Submit"><br><br>    
                            </form>
                            <?php
                            // Fetch fluid intake data
                                $sql_intake = "SELECT apt_id, oral_type, amount, iv_type, iv_amount, date,
                                CASE
                                    WHEN HOUR(date) < 12 THEN 'Morning'
                                    WHEN HOUR(date) < 18 THEN 'Afternoon'
                                    ELSE 'Evening'
                                END as time_of_day
                                FROM fluid_intake
                                where CAST(date as date) = '$date'";
                                $result_intake = $conn->query($sql_intake);

                                // Fetch fluid output data
                                $sql_output = "SELECT apt_id, u_amount, e_amount, d_amount, date,
                                CASE
                                    WHEN HOUR(date) < 12 THEN 'Morning'
                                    WHEN HOUR(date) < 18 THEN 'Afternoon'
                                    ELSE 'Evening'
                                END as time_of_day
                                FROM fluid_output
                                where CAST(date as date) = '$date'";
                                $result_output = $conn->query($sql_output);

                                $intake_data = [];
                                $output_data = [];
                                $combined_data = [];

                                // Store intake data
                                if ($result_intake->num_rows > 0) {
                                while($row = $result_intake->fetch_assoc()) {
                                $intake_data[$row['apt_id']][$row['time_of_day']][] = $row;
                                }
                                }

                                // Store output data
                                if ($result_output->num_rows > 0) {
                                while($row = $result_output->fetch_assoc()) {
                                $output_data[$row['apt_id']][$row['time_of_day']][] = $row;
                                }
                                }

                                // Combine intake and output data
                                $all_apt_ids = array_unique(array_merge(array_keys($intake_data), array_keys($output_data)));
                                $times_of_day = ['Morning', 'Afternoon', 'Evening'];

                                foreach ($all_apt_ids as $apt_id) {
                                    foreach ($times_of_day as $time) {
                                        $combined_data[$apt_id][$time] = [
                                        'intake' => isset($intake_data[$apt_id][$time]) ? $intake_data[$apt_id][$time] : [],
                                        'output' => isset($output_data[$apt_id][$time]) ? $output_data[$apt_id][$time] : [],
                                        ];
                                    }
                                }
                            
                                    
                            ?>
                            <h3><?php echo $date?></h3>
                            <form action= "" method="post">
                                <input type="date" name="date">
                                <input type="submit" value="Submit"><br><br>    
                            </form>
                            
                            <div class='table-responsive'>                
                            <table class ='table'>
                                <thead>
                                    <tr>
                                        <th style=" border-right: 1px solid #000;">Time of Day</th>
                                        <th>Intake Date</th>
                                        <th>Oral Type</th>
                                        <th>Amount</th>
                                        <th>IV Type</th>
                                        <th style=" border-right: 1px solid #000;">IV Amount</th>
                                        <th>Output Date</th>
                                        <th>Urine Amount</th>
                                        <th>Emesis Amount</th>
                                        <th>Drainage Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($combined_data as $apt_id => $data_by_time) {
                                        foreach ($data_by_time as $time => $data) {
                                            $max_rows = max(count($data['intake']), count($data['output']));
                                            $intake_total =0;
                                            $output_total =0;
                                            for ($i = 0; $i < $max_rows; $i++) {
                                                $intake = isset($data['intake'][$i]) ? $data['intake'][$i] : null;
                                                $output = isset($data['output'][$i]) ? $data['output'][$i] : null;
                                                echo "<tr>";
                                                
                                                if ($i == 0):
                                                echo "<td style=' border-right: 1px solid #000;'rowspan= $max_rows>$time</td>";
                                                endif;
                                                echo "<td>".($intake ? $intake['date'] : '')."</td>";
                                                echo "<td>".($intake ? $intake['oral_type'] : '')."</td>";
                                                echo "<td>".($intake ? $intake['amount'] : '')."</td>";
                                                echo "<td>".($intake ? $intake['iv_type'] : '')."</td>";
                                                echo "<td style = ' border-right: 1px solid #000;'>".($intake ? $intake['iv_amount'] : '')."</td>";
                                                echo "<td>".($output ? $output['date'] : '')."</td>";
                                                echo "<td>".($output ? $output['u_amount'] : '')."</td>";
                                                echo "<td>".($output ? $output['e_amount'] : '')."</td>";
                                                echo "<td>".($output ? $output['d_amount'] : '')."</td>";
                                                echo "</tr>";
                                                $intake_total +=  ($intake ? $intake['iv_amount'] : 0)+($intake ? $intake['amount'] : 0);
                                                $output_total +=  ($output ? $output['u_amount'] : 0) + ($output ? $output['e_amount'] : 0) + ($output ? $output['d_amount'] : 0);
                                            }
                                            if ($max_rows!=0){
                                                
                                                echo "<tr><td style=' border-right: 1px solid #000;'>Subtotal</td><td>$intake_total</td><td></td><td></td><td></td><td style=' border-right: 1px solid #000;'></td><td>$output_total</td></tr>";
                                            }
                                            
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
              </div>
              <div class="col-md-3 d-flex align-items-stretch">
                <div class="row">
                  <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Doctor's Notes</h4>
                        <div id="doc_notes"  class="scrollable-container">
                                <h1></h1>
                                <?php
                                $sql = "SELECT cast(notes.date as date) date,GROUP_CONCAT(cast(notes.date as time),'<br>',notes.notes,'<br>' SEPARATOR '<br>') notes FROM `notes`
                                    where type ='doc_notes' and apt_id = $_SESSION[apt_id]
                                    GROUP by cast(notes.date as date)
                                    order by notes.date;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                    echo '<div id="expandableDiv" class="text-box expandable" onclick="toggleExpand()">';
                                echo '<div class="date">' . $row["date"] . '</div>';
                                echo $row["notes"];
                                echo '</div>';
                                    }
                                }
                            
                                ?>
                        </div>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Nurses's Notes</h4>
                        <div id="nur_notes" style=overflow-y:auto>
                                <?php
                                $sql = "SELECT cast(notes.date as date) date,GROUP_CONCAT(cast(notes.date as time),'<blockqoute class=blockqoute><p>',notes.notes SEPARATOR '</p></blockqoute>') notes FROM `notes`
                                    where type ='nur_notes' and apt_id = $_SESSION[apt_id]
                                    GROUP by cast(notes.date as date)
                                    order by notes.date;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                    echo '<div class="text-box">';
                                echo '<div class="date">' . $row["date"] . '</div>';
                                echo $row["notes"];
                                echo '</div>';
                                    }
                                }
                            
                                ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>   
       <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class='footer'>
            <div class='d-sm-flex justify-content-center justify-content-sm-between'>
              <span class='text-muted d-block text-center text-sm-left d-sm-inline-block'>Copyright © bootstrapdash.com 2020</span>
              <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'> Free <a href='https://www.bootstrapdash.com/bootstrap-admin-template/' target='_blank'>Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->











<?php
    $conn->close();
?>