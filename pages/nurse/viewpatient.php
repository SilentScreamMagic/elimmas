
<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../elimmas-icon.png" />
    <style>
   .scroll-box {
      width: 300px;
      height: 200px;
      border: 1px solid #ccc;
      padding: 10px;
      overflow-y: auto;
      background-color: #f9f9f9;
    }

    .item {
      position: relative;
      padding: 8px;
      margin-bottom: 5px;
      background-color: #000;
      border-radius: 4px;
      cursor: pointer;
    }

    .preview {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      width: 250px;
      padding: 8px;
      background: #333;
      color: white;
      border-radius: 4px;
      font-size: 14px;
      z-index: 10;
      white-space: normal;
    }

    .item:hover .preview {
      display: block;
    }
    
  </style>
 <style>
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup-box {
      background: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      position: relative;
    }

    .popup-box p {
      margin: 10 0 10px;
      color: black;
      overflow-y: auto;
      max-height: 300px;
    }

    .popup-close {
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 18px;
      background: none;
      border: none;
      cursor: pointer;
    }
    #popupContent {
    white-space: pre-wrap; /* Preserves line breaks and spacing */
    }
  </style>
  </head>

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
    if (isset($_GET["id"])){
        $apt_id = $_GET["id"];
    }
    if(isset($_POST["date"])){
        $date = $_POST["date"];
        $ids = ["","","","","","","defaultOpen"];
    }
    $sql ='SELECT concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = '.$apt_id;
    $result = $conn->query($sql)->fetch_assoc();
    $pname = $result["Patient Name"];
    if (isset($_POST["bed"])){
        $sql = "insert into patients_beds (apt_id,bed_id,start_date)
        values(".$apt_id.",".$_POST["bed"].",now())";
        $result = $conn->query($sql);
        $sql = "update beds set beds.status = 'occupied' where bed_id = ".$_POST["bed"];
        $result = $conn->query($sql);
        $ids = ["defaultOpen","","","","","",""];
    }
  
    
    if (isset($_POST["cons"])){
        $sql = "insert into patients_cons(apt_id,con_id,count,date,created_by) 
        values(".$apt_id.",".$_POST["cons"].",".$_POST["con_count"].",now(),'".$_SESSION["user"][0]."')";;
        $result = $conn->query($sql);
        
        $ids = ["","","","","defaultOpen","",""];
    }
    if (isset($_POST["meals"])){
        $sql = "insert into patients_meals(apt_id,meal_id,date,created_by) 
        values(".$apt_id.",".$_POST["meals"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        
        $ids = ["","","","","","defaultOpen",""];
    }

    if (isset($_POST["btemp"])) {
        $bp = explode("/",$_POST["bloodPress"]);
        $sql = "INSERT INTO `patients_vits`( `date`, `apt_id`, `created_by`, `body_temp`, `pulse_rate`, `respiration_rate`, `systolic_bp`, `dystolic_bp`, `oxygen_sat`, `weight`) 
        VALUES (now(),$apt_id,'".$_SESSION["user"][0]."','$_POST[btemp]','$_POST[pulRate]','$_POST[respRate]','$bp[0]','$bp[1]','$_POST[oxysat]',0)";
        $result = $conn->query($sql);
        $ids = ["","defaultOpen","","","","",""];
    }
    if (isset($_POST["nur_notes"])){
        $sql = "INSERT INTO notes (type, apt_id, notes, date, created_by) 
                VALUES ('nur_notes', ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $apt_id, $_POST["nur_notes"], $_SESSION["user"][0]);
        $stmt->execute();
        $stmt->close();
        
         
         $ids = ["","","defaultOpen","","","",""];
     }
     if (isset($_POST["con_notes"])){
        $sql = "INSERT INTO notes (type, apt_id, notes, date, created_by) 
                VALUES ('con_notes', ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $apt_id, $_POST["con_notes"], $_SESSION["user"][0]);
        $stmt->execute();
        $stmt->close();
        
     }
     if (isset($_POST["meds"])){
        $sql = "insert into patients_procmeds(apt_id,med_id,quantity,date,created_by) 
        values(".$apt_id.",".$_POST["meds"].",".$_POST["med_count"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","defaultOpen","","",""];
    }
    if (isset($_POST["oral_type"])){
        $sql = "insert into fluid_intake ( oral_type, apt_id,amount, iv_type, iv_amount, date,created_by) 
        values('".$_POST["oral_type"]."',".$apt_id.",".$_POST["o_amount"].",'".$_POST["iv_type"]."',".$_POST["iv_amount"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","","","","defaultOpen"];
    }
    if (isset($_POST["u_amount"])){
        $sql = "insert into fluid_output ( apt_id, u_amount,e_amount, d_amount, date,created_by) 
        values(".$apt_id.",".$_POST["u_amount"].",'".$_POST["e_amount"]."',".$_POST["d_amount"].",now(),'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","","","","","defaultOpen"];
    }
    if (isset($_POST["deltable"])){
        $sql = "UPDATE $_POST[deltable] SET `deleted`=1 WHERE $_POST[idtype] = $_POST[delid]";
        $result = $conn->query($sql);
    
     } 
     if (isset($_POST["presmed"])){
       $sql = "INSERT INTO `patients_meds_count`( `p_med_id`, `created_by`, `time_ad`) VALUES ('$_POST[presmed]','".$_SESSION["user"][0]."','$_POST[time_ad]')";
        $result = $conn->query($sql);
        $ids = ["","","","defaultOpen","","",""];
    
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

    $sql = "SELECT 
    medication.med_name,
    (patients_meds.per_day * patients_meds.num_days) AS num_dose,
    patients_meds.p_med_id, 
    COUNT(patients_meds_count.med_count_id) AS num_dose_given 
    FROM `patients_meds` 
    INNER JOIN medication ON patients_meds.med_id = medication.med_id
    LEFT JOIN patients_meds_count ON patients_meds_count.p_med_id = patients_meds.p_med_id
    WHERE patients_meds.apt_id =$apt_id
    GROUP BY patients_meds.p_med_id
    HAVING num_dose > COUNT(patients_meds_count.med_count_id);";
    $result = $conn->query($sql);
    $presmed = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $presmed[$row["p_med_id"]] = $row["med_name"];
        }
    }

   $sql = "SELECT id FROM `baby_head_ticket` WHERE apt_id = $apt_id;";
   $result = $conn->query($sql);
   $bht = $result->fetch_assoc();

   $sql = "SELECT * FROM `patients_meds`
    inner join medication on medication.med_id = patients_meds.med_id
    Left JOIN patients_meds_count on patients_meds_count.p_med_id = patients_meds.p_med_id
    where apt_id = $apt_id;";

    $result = $conn->query($sql);
    $medpres = [];
    $adminDates = [];
    $grid = [];
    while ($row =$result->fetch_assoc()) {
       $p_med_id = $row['p_med_id'];
        $issuedDate = $row['date'];
        
        // Extract Admin Date and Time
        $adDate = date('Y-m-d', strtotime($row['time_ad']));
        $adTime = date('H:i', strtotime($row['time_ad']));

        // 1. Build unique Medication Headers
        if (!isset($medpres[$p_med_id])) {
            $medpres[$p_med_id] = [
                'name'   => $row['med_name'],
                'issued' => $issuedDate,
                'freq'   => $row['per_day'],
                'days'   => $row['num_days']
            ];
        }

        // 2. Track unique Administration Dates (Rows)
        if (!in_array($adDate, $adminDates)) {
            $adminDates[] = $adDate;
        }

        // 3. Map times to the Date/Medication intersection
        $grid[$adDate][$p_med_id][] = $adTime;
    }
    sort($adminDates);
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
                            <button class="tablinks" onclick="openTab(event, 'meds')"  >Medication</button>
                            <button class="tablinks" onclick="openTab(event, 'fluid')"  <?php if('defaultOpen'==$ids[6]) echo 'id ="'.$ids[6].'"';?>>Fluids</button>
                            <button class="tablinks" onclick="openTab(event, 'con_notes')"  >Continuation</button>
                            <button class="tablinks" onclick="openTab(event, 'proc_meds')"  <?php if('defaultOpen'==$ids[3]) echo 'id ="'.$ids[3].'"';?>>Procedural Medications</button>
                            

                        </div>
                        <div id="notes" class="tabcontent">
                            <h3>Notes</h3>
                            <form action= "" method="post">
                                <textarea name="nur_notes" cols="50" rows="10"></textarea>
                                <input type="submit" value="Submit"><br><br>
                            </form>                                        
                        </div>   
                         <div id="meds" class="tabcontent">
                            <h3>Prescibed Medication</h3>
                            <form action= "viewpatient.php?id=<?= $apt_id ?>" method="post">
                                <label for="presmed">Select an Option:</label>
                                <select class="js-example-basic-single" name="presmed" id="presmed" required>
                                    <option value="">Select a Prescribed Medication...</option>
                                    <?php foreach ($presmed as $mid => $dets): ?>
                                        <option value="<?php echo $mid; ?>"><?php echo $dets; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                <input type="datetime-local" name="time_ad" id="time_ad" required>
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <div class="wrapper">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Administration Date</th>
                                            <?php foreach ($medpres as $id => $info): ?>
                                                <th>
                                                    <strong><?php echo htmlspecialchars($info['name']); ?></strong><br>
                                                    <small><?php echo htmlspecialchars($info['issued']); ?></small><br>
                                                    <small><?php echo htmlspecialchars($info['freq']); ?>x Daily / <?php echo htmlspecialchars($info['days']); ?> Days</small>
                                                </th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($adminDates as $date): ?>
                                            <tr>
                                                <td >
                                                    <strong><?php echo htmlspecialchars($date); ?></strong>
                                                </td>

                                                <?php foreach ($medpres as $id => $info): ?>
                                                    <td >
                                                        <?php if (isset($grid[$date][$id])): ?>
                                                            <?php foreach ($grid[$date][$id] as $time): ?>
                                                                <div ><?php echo htmlspecialchars($time); ?></div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div>-</div>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>                              
                        </div>   
                        <div id="con_notes" class="tabcontent">
                            <h3>Notes</h3>
                            <form action= "" method="post">
                                <textarea name="con_notes" cols="50" rows="10"></textarea>
                                <input type="submit" value="Submit"><br><br>
                            </form>  
                        </div>   
                        <div id="rooms" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h4 class='card-title'>Rooms</h4>
                            
                            <form action= "viewpatient.php?id=<?= $apt_id ?>" method="post">
                                <label for="bed">Select an Option:</label>
                                <select class="js-example-basic-single" name="bed" id="bed" required>
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
                                join rooms on rooms.room_id = beds.room_id where apt_id = ".$apt_id." order by start_date;";

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
                            <h4 class='card-title'>Consumables</h4>
                            
                            <form action= "viewpatient.php?id=<?= $apt_id ?>" method="post">
                            <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="cons">Consumable</label>
                                <div class="col-sm-9">
                                <select class="js-example-basic-single" style="width:100%" name="cons" id="cons">
                                    <option value="" disabled selected>Select a consumable...</option>
                                    <?php 
                                        foreach ($cons as $cid => $dets): ?>
                                            <option value="<?php echo $cid; ?>"><?php echo $dets[1]." - ".$dets[0]; ?></option>
                                        <?php 
                                        endforeach;?>
                                    </select>
                                </div>
                                
                                </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="con_count">Count</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="con_count" id = "con_count">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <?php 
                                $sql = "SELECT p_cons_id,date,consumables.con_name,consumables.type,consumables.price,patients_cons.count FROM `patients_cons` 
                                join consumables on consumables.con_id = patients_cons.con_id where apt_id = ".$apt_id." and deleted = 0 order by date;";
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
                        <h4 class='card-title'>Meals</h4>
                        
                        <form action= "viewpatient.php?id=<?= $apt_id ?>" method="post">
                            <label for="meals">Select an Option:</label>
                            <select class="js-example-basic-single" name="meals" id="meals">
                                <option value="">Select a Meals...</option>
                                <?php foreach ($meals as $mid => $dets): ?>
                                    <option value="<?php echo $mid; ?>"><?php echo $dets[0]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" value="Submit"><br><br>
                        </form>
                        <?php 
                            $sql = "SELECT p_meal_id,date,meals.meal_name,meals.price FROM `patients_meals` 
                            join meals on meals.meal_id = patients_meals.meal_id where apt_id = ".$apt_id." and deleted = 0 order by date;";
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
                        <div id="proc_meds" class="tabcontent">
                        <!-- Content for rooms tab -->
                        <h4 class='card-title'>Medications</h4>
                        <form action= "" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="meds">Medication</label>
                                <div class="col-sm-9">
                                <select class="js-example-basic-single" style="width:100%" name="meds" id="meds">
                                    <option value="" disabled selected>Select a medication...</option>
                                    <?php 
                                        foreach ($meds as $mid => $dets): ?>
                                            <option value="<?php echo $mid; ?>"><?php echo $dets; ?></option>
                                        <?php 
                                        endforeach;?>
                                    </select>
                                </div>
                                
                                </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="med_count">Quantity</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="med_count" id = "med_count">
                                        </div>
                                    </div>
                                </div>
                                </div>

                            <input type="submit" value="Submit"><br><br>    
                        </form>
                        
                        <?php 
                            $sql = "SELECT p_ppmeds_id,patients_procmeds.date,medication.med_name,medication.price,patients_procmeds.quantity FROM `patients_procmeds` 
                            join medication on medication.med_id = patients_procmeds.med_id where apt_id = ".$apt_id." and deleted = 0 order by date;";
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
                            <h4 class='card-title'>Vitals</h4>
                            
                            <form action= "viewpatient.php?id=<?= $apt_id ?>" method="post">
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="btemp">Body Temp.</label>
                                        <div class="col-sm-9">  
                                            <input type="text" id="btemp" name="btemp" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="pulRate">Pulse Rate</label>
                                        <div class="col-sm-9">  
                                            <input type="text" id="pulRate" name="pulRate" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="respRate">Resp. Rate</label>
                                        <div class="col-sm-9">  
                                            <input type="text" id="respRate" name="respRate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="oxysat">Oxygen Sat.</label>
                                        <div class="col-sm-9">  
                                            <input type="text" id="oxysat" name="oxysat" required >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="respRate">Blood Pressure</label>
                                        <div class="col-sm-9">  
                                            <input type="text" id="bloodPress" name="bloodPress" pattern="^[0-9]+/[0-9]+$">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <input type="submit" value="Submit"><br><br>
                            </form>
                            <?php 
                                $sql = "SELECT * FROM `patients_vits` where apt_id = ".$apt_id." and deleted = 0 order by date;";
                                $result = $conn->query($sql); 
                                ?>
                                <div class='table-responsive'>
                                    <table class ='table'>
                                    <thead>
                                        <tr>
                                            <th>Date</th><th>Body Temp (<sup>o</sup>C)</th><th>Pulse Rate (bpm)</th><th>Resp. Rate (<sub>cycles/min</sub>)</th><th>Blood Pressure</th><th>Oxygen Saturation (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                             if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr><td>".$row["date"]."</td><td>".$row["body_temp"]."</td><td>".$row["pulse_rate"]."</td><td>".$row["respiration_rate"]."</td><td>".$row["systolic_bp"]."/".$row["dystolic_bp"]."</td><td>".$row["oxygen_sat"]."</td></tr>";
                                                }
                                              }
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
                        </div>
                        <div id="fluid" class="tabcontent">
                            <!-- Content for rooms tab -->
                            <h4 class='card-title'>Fluids</h4>
                            <h3>Fluid Intake</h3>
                            <form action= "" method="post">
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="oral_type">Oral Type</label>
                                        <div class="col-sm-9">  
                                            <input type="text" name="oral_type" id = "oral_type" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"for="o_amount">Oral Amount</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="o_amount" id = "o_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="iv_type">IV Type</label>
                                        <div class="col-sm-9">  
                                            <input type="text" name="iv_type" id = "iv_type" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="iv_amount">IV Amount</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="iv_amount" id = "iv_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               
                                <input type="submit" value="Submit"><br><br>    
                            </form>
                            <h3>Fluid Output</h3>
                            <form action= "" method="post">
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="u_amount">Urine Amount</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="u_amount" id = "U_amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="o_amount">Emesis Amount</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="e_amount" id = "e_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="d_amount">Drainage Amount</label>
                                        <div class="col-sm-9">  
                                            <input type="number" name="d_amount" id = "d_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <div id="doc_notes"  class="scroll-box">
                                <h1></h1>
                                <?php
                                $sql = "SELECT users.Name,notes.date,notes.notes notes FROM `notes` 
                                INNER join users on users.username = created_by where type ='doc_notes' and apt_id =$apt_id 
                                order by notes.date DESC;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class="text-box">';
                                        echo '<div class="item" data-full-text="'.htmlspecialchars($row["notes"]).'">'. $row["Name"].'| '. $row["date"];
                                        echo '<div class="preview"></div></div></div>';
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
                        <div id="nur_notes" class="scroll-box">
                                <?php
                                $sql = "SELECT users.Name,notes.date,notes.notes notes FROM `notes` 
                                INNER join users on users.username = created_by where (type ='nur_notes' or type ='con_notes') and apt_id =$apt_id 
                                order by notes.date DESC;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class="text-box">';
                                        echo '<div class="item" data-full-text="'.htmlspecialchars($row["notes"]).'">'. $row["Name"].'| '. $row["date"];
                                        echo '<div class="preview"></div></div></div>';
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
       <div id="popup" class="popup-overlay">
    <div class="popup-box">
      <button class="popup-close" id="closePopup">&times;</button>
      <p id="popupContent"></p>
    </div>
  </div>
  <div>
        <a href='#' id='profile-dropdown' data-toggle='dropdown'><button>Baby Head Ticket</button></a>
        <a target="_blank" href=<?php echo "./rbs_mon_chart.php?apt_id=$apt_id"?>><button>RBS Chart</button></a>
        <div class='dropdown-menu dropdown-menu-right sidebar-dropdown preview-list' aria-labelledby='profile-dropdown'>
            <?php 
            foreach ( $bht as $key=>$row) {
                
                echo " <a target='_blank' href='./baby_head_ticket.php?id=$row'><button>Baby Head Ticket </button></a>
                <div class='dropdown-divider'>               
                </div>";
            }
                
            
        ?>
        <a target="_blank" href="./baby_head_ticket.php?apt_id=<?=  $apt_id;?>" ><button>New Baby Head Ticket </button></a>
                <div class='dropdown-divider'>               
                
                                  
    </div>

          <script src="../../assets/vendors/select2/select2.min.js"></script>
<script src="../../assets/js/select2.js"></script>
<script>
    const WORD_LIMIT = 5;
    document.querySelectorAll('.item').forEach(item => {
      const fullText = item.getAttribute('data-full-text');
      const words = fullText.split(' ').slice(0, WORD_LIMIT).join(' ');
      const preview = item.querySelector('.preview');
      preview.textContent = words + (fullText.split(' ').length > WORD_LIMIT ? '...' : '');
    });
  </script>
  
  <script>
     const popup = document.getElementById('popup');
    const popupContent = document.getElementById('popupContent');
    const closeBtn = document.getElementById('closePopup');

    document.querySelectorAll('.item').forEach(item => {
      item.addEventListener('click', () => {
        const fullText = item.getAttribute('data-full-text');
        popupContent.textContent = fullText;
        popup.style.display = 'flex';
      });
    });

    closeBtn.addEventListener('click', () => {
      popup.style.display = 'none';
    });

    popup.addEventListener('click', (e) => {
      if (e.target === popup) {
        popup.style.display = 'none';
      }
    });
  </script>










<?php
    $conn->close();
?>