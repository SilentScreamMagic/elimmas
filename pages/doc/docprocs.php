
<!DOCTYPE html>
<html lang='en'>
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
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
    <style>
        .scroll-box {
      width: 300px;
      height: 200px;
      border: 1px solid #ccc;
      padding: 10px;
      overflow-y: auto;
      background-color: #f9f9f9;
      padding-bottom: 60px;
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

    .popup-box p{
      margin: 10 0 10px;
      color: black;
      overflow-y: auto;
      max-height: 300px;
    }
    .popup-box h4{
        color: black;
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
  <div class='container-scroller'>
  
    <?php 
    include '../nav.php';
    include "../conn.php";
    //include "../nav.php";
    //include "../table.html";
    include "../tabs.html";
    include "../test.php";
    
    $notes = "";
    $ndate = "";
    $ids=["","","","","defaultOpen",""];
    if (isset($_POST["id"])){
        $_SESSION["apt_id"] = $_POST["id"];
        
    }
    if (isset($_POST["apt_id"])){
        if($_POST["type"]=="In-Patient"){
            $sql = "update appointments set type = 'Consultation' where id =$_POST[apt_id]";
            $result = $conn->query($sql);
        }else{
            $sql = "update appointments set type = 'In-Patient' where id =$_POST[apt_id]";
            $result = $conn->query($sql);
        }
        
      }
    
    $sql ='SELECT patient.pat_id,concat(patient.FName," ",patient.LName) "Patient Name", appointments.type, DOB,check_out FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = '.$_SESSION["apt_id"];
    $result = $conn->query($sql)->fetch_assoc();
    $pat_id=$result["pat_id"];
    $pname = $result["Patient Name"];
    $checkout = $result["check_out"];
    $type = $result["type"];
    $dateOfBirth = date("d-m-Y", strtotime($result["DOB"]));
    $today = date("d-m-Y");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $age = $diff->format("%y");
    
    
    
    if (isset($_POST["proc_id"])){
        $sql = "insert into patients_proc(apt_id,proc_id,date ,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["proc_id"].",now() ,'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","defaultOpen","","","",""];
    }
 
    if (isset($_POST["med"])){
        $sql = "insert into patients_meds(apt_id,med_id,per_dose,per_day,num_days,date ,created_by,ad_by) 
        values(".$_SESSION['apt_id'].",".$_POST["med"].",".$_POST["per_dose"].",".$_POST["per_day"].",".$_POST["num_days"].",now() ,'".$_SESSION["user"][0]."','".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","defaultOpen","","",""];
    }
    if (isset($_POST["labs"])){
        $sql = "insert into patients_labs(apt_id,lab_id,date ,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["labs"].",now() ,'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        
        $ids = ["","","","defaultOpen","",""];
    }
    if(isset($_POST["button"])){
         if ($_POST["button"]=="Submit"){
            $sql = "INSERT INTO `notes`( `type`,`apt_id`, `notes`, `date`,created_by) VALUES ('doc_notes',$_SESSION[apt_id],'$_POST[notes]',now() ,'".$_SESSION["user"][0]."')";
            $result = $conn->query($sql);
            unset($_SESSION["notes"]);
            unset($_SESSION["ndate"]);
            $ids = ["","","","","defaultOpen",""];
        }else{
            $_SESSION["notes"] = $_POST["notes"];
            $_SESSION["ndate"]=date("d/m/y h:i:s");
        }
    }
   if(isset($_SESSION["notes"])){
    $notes = $_SESSION["notes"];
    $ndate = $_SESSION["ndate"];
   }
    if (isset($_POST["dis_notes"])){
        $sql = "DELETE FROM `notes` WHERE $_SESSION[apt_id] and type = 'dis_notes';";
        $result = $conn->query($sql);
        $sql = "INSERT INTO `notes`( `type`,`apt_id`, `notes`, `date`,created_by) VALUES ('dis_notes',$_SESSION[apt_id],'$_POST[dis_notes]',now() ,'".$_SESSION["user"][0]."')";
         $result = $conn->query($sql);
         $ids = ["","","","","","defaultOpen"];
     } 
     if (isset($_POST["deltable"])){
        $sql = "UPDATE $_POST[deltable] SET `deleted`=1 WHERE $_POST[idtype] = $_POST[delid]";
        $result = $conn->query($sql);
    
     } 
   
    $sql = "SELECT * FROM `procedures`;";
    $result = $conn->query($sql);
    $proc = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $proc[$row["prod_id"]] = $row["Prod_Name"];
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
    $sql = "SELECT * FROM labs";
    $result = $conn->query($sql);
    $labs = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $labs[$row["lab_id"]] = $row["lab_name"];
        }
    }
  

    ?>
    <div class='main-panel'>
        <div class='content-wrapper'>
        <div class="header-container">
        <header class="header2">
 
            <div class='row '>
          <div class="col-md-9 grid-margin">
                <div class="card">
                <div class='card-body'>
                    <h4 class='card-title'><?php echo $pname. " (Age: " .$age.")"?></h4>
                    <?php 
                        if($checkout==null){
                            echo "<form action='docapps.php' method='post'>
                                <input type='hidden' name='apt_id' value= $_SESSION[apt_id]>
                                <input type='submit' value='End Appointment'>
                            </form>";
                        }
                        
                    ?>
                    <?php 
                            echo "<form action='docprocs.php' method='post'>
                                <input type='hidden' name='apt_id' value= $_SESSION[apt_id]>
                                <input type='hidden' name='type' value= '$type'>
                                <input type='submit' value='Current Appointment type: $type'>
                            </form>";
                        
                    ?>
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'notes')" <?php if('defaultOpen'==$ids[4]) echo 'id ="'.$ids[4].'"';?>>Notes</button>
                        <button class="tablinks" onclick="openTab(event, 'procs')" <?php if('defaultOpen'==$ids[1]) echo 'id ="'.$ids[1].'"';?>>Procedures</button>
                        <button class="tablinks" onclick="openTab(event, 'meds')"  <?php if('defaultOpen'==$ids[2]) echo 'id ="'.$ids[2].'"';?>>Medications</button>
                        <button class="tablinks" onclick="openTab(event, 'labs')"  <?php if('defaultOpen'==$ids[3]) echo 'id ="'.$ids[3].'"';?>>Labs</button>
                        <button class="tablinks" onclick="openTab(event, 'dis_notes')" <?php if('defaultOpen'==$ids[5]) echo 'id ="'.$ids[5].'"';?>>Discharge</button>   
                    </div>
<div id="procs" class="tabcontent">
    <!-- Content for beds tab -->
     <h4 class='card-title'>Procedures</h4>
    <form action= "" method="post">
        <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="proc_id">Procedure Name:</label>
        <div class="col-sm-9">
            <select class="js-example-basic-single" style="width:80%" name="proc_id" id="proc_id">
                <option value="" disabled selected>Select a Procedure...</option>
                <?php 
                    foreach ($proc as $pid => $det): ?>
                        <option value="<?php echo $pid; ?>"><?php echo $det; ?></option>
                    <?php 
                    endforeach;?>
                </select>
            </div>
        <input type="submit" value="Submit"><br><br>
        </div>
    </form> 
    
                    <div class='table-responsive'>
                     <?php 
    $sql = "SELECT p_proc_id, patients_proc.date,procedures.Prod_Name, procedures.Price FROM procedures 
    JOIN patients_proc on patients_proc.proc_id = procedures.prod_id
    where patients_proc.apt_id =".$_SESSION["apt_id"]." and deleted = 0 order by date;";
    $result = $conn->query($sql);?>
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Procedure</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_proc_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_proc'>
                                                <input type='hidden' name='idtype' value= 'p_proc_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["date"]."</td><td>".$row["Prod_Name"]."</td></tr>";
                            }
                            
                        }
                    
                        ?>
                        </tbody>
                        </table>
                    </div>
   
    
</div>

<div id="meds" class="tabcontent">
    <!-- Content for rooms tab -->
    <h4 class='card-title'>Medications</h4>
    <form action= "" method="post">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="med">Medication:</label>
        <div class="col-sm-9">
            <select class="js-example-basic-single" style="width:80%" name="med" id="med">
                <option value="" disabled selected>Select a Medication...</option>
                <?php 
                    foreach ($meds as $mid => $det): ?>
                        <option value="<?php echo $mid; ?>"><?php echo $det; ?></option>
                    <?php 
                    endforeach;?>
                </select>
            </div>
        </div>          
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="med_count">Per Dose:</label>
                    <div class="col-sm-9">
                    <input type="number" name="per_dose" id = "med_count" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="per_day">Per Day:</label>
                    <div class="col-sm-9">
                    <input type="number" name="per_day" id = "per_day" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="num_days">No. Of Days:</label>
                    <div class="col-sm-9">
                    <input type="number" name="num_days" id = "num_days" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>          
        <input type="submit" value="Submit"><br><br>    
    </form>
    <?php 
        $sql = "SELECT p_med_id,patients_meds.date,medication.med_name,medication.price,per_dose,per_day,num_days FROM `patients_meds` 
        join medication on medication.med_id = patients_meds.med_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
        $result = $conn->query($sql);?>
        
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Medication Name</th><th>Per Dose</th><th>Per Day</th><th>Number Of Days</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_med_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_meds'>
                                                <input type='hidden' name='idtype' value= 'p_med_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td>
                                    <td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td></tr>";
                                }   
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
    
</div>

<div id="labs" class="tabcontent">
    <!-- Content for rooms tab -->
    <h3>Labs</h3>
    
    <form action= "" method="post">
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="lab">Labs:</label>
        <div class="col-sm-9">
            <select class="js-example-basic-single" style="width:80%" name="labs" id="lab">
                <option value="" disabled selected>Select a Lab...</option>
                <?php 
                foreach ($labs as $lid => $det): ?>
                    <option value="<?php echo $lid; ?>"><?php echo $det; ?></option>
                <?php 
                endforeach;?>
            </select>
        </div>    
        <input type="submit" value="Submit"><br><br>
        </div>
    </form>
    
    <?php 
        $sql = "SELECT p_lab_id,date,labs.lab_name,lab_results,lab_date FROM `patients_labs` 
        join labs on labs.lab_id = patients_labs.lab_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
        $result = $conn->query($sql);?>
        
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Labs Name</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td><form action='' method='post'>
                                                <input type='hidden' name='delid' value=".$row['p_lab_id'].">
                                                <input type='hidden' name='deltable' value= 'patients_labs'>
                                                <input type='hidden' name='idtype' value= 'p_lab_id'>
                                                <input type='submit' value='Delete'>
                                            </form></td><td>".$row["date"]."</td><td>".$row["lab_name"]."</td>";
                if ($row["lab_results"]!= null){
                      echo "<td><a href='../open_pdf.php?file=./uploads/$row[lab_results]' target='_blank'>Open PDF</a></td></tr>";  
                }
            }
            
        }
    ?>
                        </tbody>
                        </table>
                    </div>
    
</div>
<div id="notes" class="tabcontent">
    <div class ="contain">
        <!-- Content for rooms tab -->
    <div>
        <h3>Notes</h3>
    <form action= "" method="post">
        <textarea autofocus id="note" name="notes" cols="70" rows="10"><?php echo $notes?></textarea><br><br>
        <?php if($ndate !=""){
            echo "Last Saved $ndate";
        }  ?><br>
        <input name = "button" type="submit" value="Submit"><br><br>
        <input name = "cursor" id="cursor" type="hidden" value="0">
        <input name = "button" id="submit-btn" type="submit" style="display: none;" value="Autosave">
    </form>
    </div>     
    
  

</div>
</div>
<div id="dis_notes" class="tabcontent">
    <div class ="contain">
        <!-- Content for rooms tab -->
        <div>
            <h3>Discharge Notes</h3>
            <?php
        $sql = "SELECT GROUP_CONCAT(notes SEPARATOR ' ')'notes' FROM `notes` WHERE apt_id =".$_SESSION["apt_id"] ." and type = 'dis_notes' and deleted = 0;";
        $result = $conn->query($sql);
        $dis_notes = $result->fetch_assoc();?>
            <form action= "" method="post">
                <input type="hidden" name="apt_id" value = <?php echo $_SESSION['apt_id']?>>
                <textarea name="dis_notes" cols="70" rows="10"><?php  echo $dis_notes["notes"];?></textarea>
                <input type="submit" value="Submit"><br><br>
        </form>
    </div>        
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
                        <h4 class="card-title">Vitals</h4>
                            <?php
                            $sql = "SELECT patients_vits.* FROM `patients_vits` 
                            where apt_id = $_SESSION[apt_id] and date = (SELECT MAX(date) from patients_vits WHERE apt_id =$_SESSION[apt_id]) and deleted = 0 order by date;";
                            $result = $conn->query($sql);
                            $vitals = [];

                            if ($row = $result->fetch_assoc()) {
                                echo "<div class='patient-card'>";
                                    echo "<h4>$row[date]</h4>";
                                    echo "<div class='patient-info'>";
                                    echo "<div><span><strong>Weight: </strong>$row[weight] kg</span>|<span>  <strong>BT:</strong>  $row[body_temp]<sup>o</sup>C</span> </div>";
                                    echo "<div><span><strong>PR:</strong> $row[pulse_rate]<sub>bpm</sub></span> |<span>    <strong>BP:</strong> $row[systolic_bp]/$row[dystolic_bp]<sub>mmhg</sub></span> </div>";
                                    echo "<div><span><strong>RR:</strong> $row[respiration_rate] <sub>cycles/min</sub></span>| <span>     <strong>SpO2:</strong> $row[oxygen_sat]%</span></div>";
                                    echo "<div></div>";
                                    echo "<div> </div>";
                                   
                                    echo "</div>";
                                    echo "</div>";
                                while($row = $result->fetch_assoc()) {
                                    $vitals[$row["date"]][$row["vit_id"]] =$row["measure"];
                                }
                                foreach($vitals as $date=> $dets){
                                    
                                }
                            }
                        ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Doctor's Notes</h4>
                        <div id="doc_notes"  class="scroll-box">
                                <h1></h1>
                                <?php
                                $sql = "SELECT users.Name,notes.apt_id,notes.date,notes.notes notes FROM `notes` 
                                INNER join users on users.username = created_by 
                                inner join appointments on appointments.id = notes.apt_id
                                where notes.type ='doc_notes' and appointments.patient_id = $pat_id
                                order by apt_id DESC,notes.date;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class="text-box">';
                                        echo '<div class="item" data-full-text="'.htmlspecialchars($row["notes"]).'">'.$row["apt_id"].'-'. $row["Name"].'| '. $row["date"];
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
                                $sql = "SELECT users.Name,notes.apt_id,notes.date,notes.notes notes FROM `notes` 
                                INNER join users on users.username = created_by 
                                inner join appointments on appointments.id = notes.apt_id
                                where notes.type ='nur_notes' and appointments.patient_id = $pat_id
                                order by apt_id DESC,notes.date;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class="text-box">';
                                        echo '<div class="item" data-title="'.$row["apt_id"].'-' .$row["Name"].'| '. $row["date"].'" data-full-text="'.htmlspecialchars($row["notes"]).'">'.$row["apt_id"].'-' .$row["Name"].'| '. $row["date"];
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
        </div>  
        <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         
          <!-- partial -->
</div>
<div id="popup" class="popup-overlay">
    <div class="popup-box">
      <button class="popup-close" id="closePopup">&times;</button>
      <h4 id="popuptitle"> </h4>    
      <p id="popupContent"></p>
    </div>
  </div>
<script src="../../assets/vendors/select2/select2.min.js"></script>
<script src="../../assets/js/select2.js"></script>

<script>
    function openOption() {
        if(document.getElementById("refill").style.visibility == "visible"){
            document.getElementById("refill").style.visibility = "hidden";
        }else{
            document.getElementById("refill").style.visibility = "visible"
        }
    }
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
<script>
       window.addEventListener("load",(event) =>{
            let notesField = document.getElementById('note');
            console.log(notesField.innerHTML);
            notesField.focus();
           
            
        })
        
        document.addEventListener('DOMContentLoaded', function() {
            let notesField = document.getElementById('note');
            let submitButton = document.getElementById('submit-btn');
            let timeoutId;
            let hasChanges = false;
            let cursor = document.getElementById("cursor");
            let sessionSet ="<?php echo isset($_SESSION["notes"])?>";
            if (sessionSet ==1){
                notesField.focus();
                let length = "<?php echo $_POST["cursor"] ?? 0 ?>";
                if (length == 0){
                    length = notesField.value.length;
                }
                notesField.setSelectionRange(length, length);
            }  
            notesField.addEventListener('input', function() {
                hasChanges=true;
                clearTimeout(timeoutId); 
                timeoutId = setTimeout(function() {
                    cursor.value = notesField.selectionStart;
                    submitButton.click(); 
                    hasChanges = false;
                }, 5000); 

            });
            document.querySelectorAll('.tablinks').forEach(button => {
  button.addEventListener('click', () => {
    if(hasChanges){
        submitButton.click();
        clearTimeout(timeoutId);
    }
  });
        })});
    </script>
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
    const popupTitle = document.getElementById('popuptitle');
    const closeBtn = document.getElementById('closePopup');

    document.querySelectorAll('.item').forEach(item => {
      item.addEventListener('click', () => {
        const fullText = item.getAttribute('data-full-text');
        const titleText = item.getAttribute('data-title');
        popupContent.textContent = fullText;
        popupTitle.textContent = titleText;
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



</body>
</html>
<?php
include "../test.php";
    $conn->close();
?>