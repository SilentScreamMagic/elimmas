
<!DOCTYPE html>
<html lang='en'>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    
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
    /* Darken the icons (the lines and shapes) */
.ql-toolbar .ql-stroke {
    stroke: #000 !important;
    stroke-width: 2px; /* Makes them slightly thicker/bolder */
}

/* Darken the filled-in parts of icons */
.ql-toolbar .ql-fill {
    fill: #000 !important;
}

/* Darken the text labels (like 'Normal', 'Heading 1') */
.ql-toolbar .ql-picker-label, 
.ql-toolbar .ql-picker-item {
    color: #000 !important;
    font-weight: bold;
}

/* Darken the toolbar background slightly to make it pop */
.ql-toolbar {
    background-color: #f8f8f8;
    border-bottom: none !important;
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
         color: black;
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
        .popup-content, 
        .popup-content table, 
        .popup-content th, 
        .popup-content td {
        color: #000 !important;                /* make text black */
        background-color: #fff !important;    /* white background for cells */
        }

    </style>
    
  </head>
  <body>
  <div class='container-scroller'>
  
    <?php 
    include "../conn.php";
    include '../nav.php';
    
    //include "../nav.php";
    //include "../table.html";
    include "../tabs.html";
    include "../test.php";
    
    $notes = "";
    $ndate = "";
  
    if (isset($_GET["id"])){
        $apt_id = $_GET["id"];
        $sql ='SELECT patient.pat_id,concat(patient.FName," ",patient.LName) "Patient Name" ,appointments.type,appointments.diagnosis, DOB,check_out FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
        where id = '.$apt_id;
        $result = $conn->query($sql)->fetch_assoc();
        $pat_id=$result["pat_id"];
        $pname = $result["Patient Name"];
        $checkout = $result["check_out"];
        $type = $result["type"];
        $diag = $result["diagnosis"];
        $dateOfBirth = date("d-m-Y", strtotime($result["DOB"]));
        $today = date("d-m-Y");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $age = "";
        $age = $diff->format("%y") !=0 ?  $diff->format("%y")." years ": "";
        if($diff->format("%y") <3 ){
            $age.= $diff->format("%m") !=0 ?  $diff->format("%m")." months ": "";
            $age.= $diff->format("%d") !=0 ?  $diff->format("%d"). " days ": "";
        }
    
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
           $meds[$row["med_id"]] = [$row["med_name"],$row["in_stock"]];
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
                        if($checkout==null and $diag !=null){
                            echo "<form action='docapps.php' method='post'>
                                <input type='hidden' name='end' value= $apt_id>
                                <input type='submit' value='End Appointment'>
                            </form>";
                        }
                        
                    ?>
                    <?php 
                            echo "<form action='rec_apt.php' method='post'>
                                <input type='hidden' name='apt_type' value= $apt_id>
                                <input type='hidden' name='type' value= '$type'>
                                <input type='submit' value='Current Appointment type: $type'>
                            </form>";
                        
                    ?>
                    <div class="tab">
                        <a href="#notes"><button class="tablinks" onclick="openTab(event, 'notestab')" id ="tabnotes" >Notes</button></a>
                        <a href="#procs"><button class="tablinks" onclick="openTab(event, 'procs')" id ="tabprocs" >Procedures</button></a>
                        <a href="#meds"><button class="tablinks" onclick="openTab(event, 'meds')"  id ="tabmeds">Medications</button></a>
                        <a href="#labs"><button class="tablinks" onclick="openTab(event, 'labs')"  id ="tablabs">Labs</button></a>
                        <a href="#dis_notes"><button class="tablinks" onclick="openTab(event, 'dis_notes')" id ="tabdis_notes">Discharge</button></a> 
                    </div>
                    <div id="procs" class="tabcontent">
                        <!-- Content for beds tab -->
                        <h4 class='card-title'>Procedures</h4>
                         <div class="table-actions">
                            <button type="button" class="add-btn" onclick="addVitalsRow('procs_table',proc_row)">+ Add Entry</button>
                        </div>
    
                        <div class='table-responsive'>
                        <?php 
                            $sql = "SELECT p_proc_id, patients_proc.date,procedures.Prod_Name, procedures.Price FROM procedures 
                            JOIN patients_proc on patients_proc.proc_id = procedures.prod_id
                            where patients_proc.apt_id =".$apt_id." and deleted = 0 order by date;";
                            $result = $conn->query($sql);?>
                            <form action="rec_apt.php?tab=procs" method="post">
                                <input type='hidden' name='proc_apt' value= '<?= $apt_id?>'>
                                <table id="procs_table"  class ='table'>
                                <thead>
                                    <tr>
                                    <th></th><th>Date</th><th>Procedure</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>    
                                                    <button type='button' onclick=deleteRow('proc',$row[p_proc_id],'patients_proc','p_proc_id','$apt_id')>Delete</button>
                                                    </td><td>".$row["date"]."</td><td>".$row["Prod_Name"]."</td></tr>";
                                    }
                                    
                                }
                                ?>
                                <tr id="og_row"><td></td><td id="select-td" colspan="2">
                                    
                                    <select class="js-example-basic-single" style="width:80%" name="proc_id[]" id="proc_id">
                                    <option value="" disabled selected>Select a Procedure...</option>
                                    <?php 
                                        foreach ($proc as $pid => $det): ?>
                                            <option value="<?php echo $pid; ?>"><?php echo $det; ?></option>
                                        <?php 
                                        endforeach;?>
                                    </select>
                                    
                                </td><td></td></tr>
                                
                                </tbody>
                            </table>
                            <input type="submit" value="Submit"><br><br>
                            </form>
                            
                        </div>
                        
                    </div>

<div id="meds" class="tabcontent">
    <!-- Content for rooms tab -->
    <h4 class='card-title'>Medications</h4>
    <div class="table-actions">
        <button type="button" class="add-btn" onclick="addVitalsRow('meds_table',med_row)">+ Add Entry</button>
    </div>
    <?php 
        $sql = "SELECT p_med_id,patients_meds.date,medication.med_name,medication.price,per_dose,per_day,num_days FROM `patients_meds` 
        join medication on medication.med_id = patients_meds.med_id where apt_id = ".$apt_id." and deleted = 0 order by date;";
        $result = $conn->query($sql);?>
        
                    <div class='table-responsive'>
                        <form action="rec_apt.php?tab=meds" method="post">
                        <table id="meds_table" class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Medication Name</th><th>Dosage</th><th>Dose Frequency</th><th>Number Of Days</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td> 
                                                    <button type='button' onclick=deleteRow('med',$row[p_med_id],'patients_meds','p_med_id','$apt_id')>Delete</button>
                                                    </td>
                                    <td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td></tr>";
                                }   
                            }
                        ?>
                        <tr id="og_row"><td></td><td id="select-td" colspan="2">
                                    <input type='hidden' name='med_apt' value= '<?= $apt_id?>'>
                                    <select class="js-example-basic-single" style="width:80%" name="med[]" id="med">
                                        <option value="" disabled selected>Select a Medication...</option>
                                        <?php 
                                            foreach ($meds as $mid => $det): ?>
                                                <option value=<?php echo "'".$mid."' ".(!$det[1]? 'disabled': "") ?> ><?php echo $det[0]; ?></option>
                                            <?php 
                                            endforeach;?>
                                        </select></td>
                                    <td><input type="number" name="per_dose[]" id = "med_count" class="form-control" required></td>
                                    <td><input type="number" name="per_day[]" id = "per_day" class="form-control" required></td>
                                    <td><input type="number" name="num_days[]" id = "num_days" class="form-control" required></td>
                                </tr>
                        </tbody>
                        </table>
                        <input type='hidden' name='med_apt' value= '<?= $apt_id?>'>         
                        <input type="submit" value="Submit"><br><br>    
                                    </form>
                    </div>
    
</div>

<div id="labs" class="tabcontent">
    <!-- Content for rooms tab -->
    <h3>Labs</h3>
    <div class="table-actions">
        <button type="button" class="add-btn" onclick="addVitalsRow('labs_table',lab_row)">+ Add Entry</button>
    </div>
    
    
    <?php 
        $sql = "SELECT p_lab_id,date,labs.lab_name,lab_results,lab_date FROM `patients_labs` 
        join labs on labs.lab_id = patients_labs.lab_id where apt_id = ".$apt_id." and deleted = 0 order by date;";
        $result = $conn->query($sql);?>
        
                    <div class='table-responsive'>
                    <form action="rec_apt.php?tab=labs" method="post">
                        <table id="labs_table" class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Labs Name</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>    
                                                    <button type='button' onclick=deleteRow('lab',$row[p_lab_id],'patients_labs','p_lab_id','$apt_id')>Delete</button>
                                                    </td><td>".$row["date"]."</td><td>".$row["lab_name"]."</td>";
                if ($row["lab_results"]!= null){
                      echo "<td><a href='../open_pdf.php?file=../files/$row[lab_results]' target='_blank'>Open PDF</a></td></tr>";  
                }
            }
            
        }
    ?>
    <tr id="og_row"><td></td><td id="select-td" colspan="2">
                                    
                <select class="js-example-basic-single" style="width:80%" name="labs[]" id="labs">
                <option value="" disabled selected>Select a Labs...</option>
                <?php 
                    foreach ($labs as $lid => $det): ?>
                        <option value="<?php echo $lid; ?>"><?php echo $det; ?></option>
                    <?php 
                    endforeach;?>
                </select>
                
            </td><td></td></tr>
    </tbody>
    </table>
    <input type='hidden' name='lab_apt' value= '<?= $apt_id?>'>
    <input type="submit" value="Submit"><br><br>
    </form>
</div>
    
</div>
<div id="notestab" class="tabcontent">
    <div class ="contain">
        <h3>Notes</h3>
        <div class="icd-search-container">
            <?php 
            if($diag){
                echo "Diagnosis: $diag";

            }else{
                echo "<form action='./rec_apt.php?tab=notes' method='post'>
                <label for='icdSearchSelect'>Diagnosis: </label>
                <select class='js-example-basic-single' id='icdSearchSelect'  name='diag'>
                    <option value='' disabled selected>Search ICD-10 code or term (e.g., A15.0 or Tuberculosis)</option>
                </select>
                <input type='hidden' name='diag_apt' value= '$apt_id'>
                <input type='submit' value='Record Diagnosis'>
            </form >";
            }
            
            ?>
            
                
            </div>
        <div>
        
    <form id="notesForm" action="rec_apt.php?tab=notes" method="post">
        <!--<textarea style="max-width: 100%; " autofocus id="note" name="notes" cols="70" rows="10"><?php //echo $notes?></textarea><br><br>-->
         <div autofocus id="note">
            <p></p>
        </div>
        <input type="hidden" name="notes" id="notes">
        <span id="lastsaved"></span><br>
        <input name = "save_notes" id="save_notes" type="submit" value="Submit"><br><br>
        <input type='hidden' name='notes_apt' value= '<?= $apt_id?>'>
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
        $sql = "SELECT GROUP_CONCAT(notes SEPARATOR ' ')'notes' FROM `notes` WHERE apt_id =".$apt_id ." and type = 'dis_notes' and deleted = 0;";
        $result = $conn->query($sql);
        $dis_notes = $result->fetch_assoc();?>
            <form action="rec_apt.php?tab=dis_notes" method="post">
                <input type="hidden" name="disnotes_apt" value = <?php echo $apt_id?>>
                <textarea style="max-width: 100%; " name="dis_notes" cols="70" rows="10"><?php  echo $dis_notes["notes"];?></textarea>
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
                        <h4 class="item card-title" data-type="table" data-title="Vitals" data-table-id="vitalsTable">Vitals</h4>
                           
                            <?php
                            $sql = "SELECT patients_vits.* FROM `patients_vits` 
                            where apt_id = $apt_id  and deleted = 0 order by date DESC;";
                            $result = $conn->query($sql);
                            $vitals = [];

                            if ($row = $result->fetch_assoc()) {
                                $vitals[] = $row; 
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
                                    $vitals[] =$row;
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
                                order by notes.date DESC;";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<div class="text-box">';
                                        echo '<div class="item" data-type="text" data-id="'.$row["apt_id"].'" data-title="'.$row["apt_id"].' - '. $row["Name"].' | '. $row["date"].'" data-full-text="'.htmlspecialchars($row["notes"]).'">'.$row["apt_id"].' - '. $row["Name"].' | '. $row["date"];
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
                                        echo '<div class="item"  data-apt="'.$row["apt_id"].'" data-title="'.$row["apt_id"].' - ' .$row["Name"].' | '. $row["date"].'" data-full-text="'.htmlspecialchars($row["notes"]).'">'.$row["apt_id"].' -' .$row["Name"].' | '. $row["date"];
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
<div id="vitalsTable" style="display:none; color: #000000; ">
  <table style="width:100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th>Time</th>
        <th>Body Temp (°C)</th>
        <th>Pulse Rate (bpm)</th>
        <th>Respiration Rate (bpm)</th>
        <th>Blood Pressure (mmHg)</th>
        <th>Oxygen Saturation (%)</th>
        <th>Weight (kg)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($vitals as $v): ?>
        <tr>
          <td><?= htmlspecialchars($v['date']) ?></td>
          <td><?= htmlspecialchars($v['body_temp']) ?></td>
          <td><?= htmlspecialchars($v['pulse_rate']) ?></td>
          <td><?= htmlspecialchars($v['respiration_rate']) ?></td>
          <td><?= htmlspecialchars($v['systolic_bp']) . '/' . htmlspecialchars($v['dystolic_bp']) ?></td>
          <td><?= htmlspecialchars($v['oxygen_sat']) ?></td>
          <td><?= htmlspecialchars($v['weight']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


</table>
<div id="popup" class="popup-overlay">
    <div class="popup-box">
      <button id="apt-btn" >Open Appointment</button>
      <button class="popup-close" id="closePopup">&times;</button>
      <h4 id="popupTitle"> </h4> 
      <div id="popupContent" style="max-height: 300px; overflow-y: auto;"></div>
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
            let notesField = document.querySelector('#note');
            let quill = Quill.find(notesField);
            notesField.focus();
            if(localStorage.getItem(<?= $apt_id?>)){
                    
                     let notesField = document.getElementById('note');
                     let lastsaved = document.getElementById('lastsaved');
                     let stored_notes = JSON.parse(localStorage.getItem(<?= $apt_id?>));

                    //console.log(time.toLocaleString());

                     //notesField.value = stored_notes["note"];
                     quill.insertText(0, stored_notes["note"]);
                     let time =new Date(stored_notes["time"]);
                     lastsaved.innerHTML=time.toLocaleString();


            }
            
           
            
        })
        
        document.addEventListener('DOMContentLoaded', function() {
            const urlHash = window.location.hash;
            if(urlHash){
                document.getElementById("tab"+urlHash.substring(1)).click();
            }else{
                document.getElementById("tabnotes").click();
            }



            let notesField = document.getElementById('note');
            let submitButton = document.getElementById('save_notes');
            let timeoutId;
            let hasChanges = false;
            notesField.addEventListener('input', function() {
                hasChanges=true;
                let lastsaved = document.getElementById('lastsaved'); 
                    let time; 
                    //console.log(time.toLocaleString());

                clearTimeout(timeoutId); 
                timeoutId = setTimeout(function() {
                    //cursor.value = notesField.selectionStart;
                    //submitButton.click(); 
                    let quill = Quill.find(notesField);
                    let savedNotes = quill.getText();
                    time = new Date(Date.now());
                    lastsaved.innerHTML=time.toLocaleString();
                    let note_dict = JSON.stringify({"note": savedNotes,"time":time});
                    localStorage.setItem(<?= $apt_id?>,note_dict);
                    
                    hasChanges = false;
                }, 20000); 

            });
            submitButton.addEventListener('click',function(){
                localStorage.removeItem(<?= $apt_id?>);
            });
            document.querySelectorAll('.tablinks').forEach(button => {
            button.addEventListener('click', () => {
                if(hasChanges){
                    let notesField = document.querySelector('#note');
                    let quill = Quill.find(notesField);
                    let savedNotes = quill.getText();
                    time = new Date(Date.now());
                    lastsaved.innerHTML=time.toLocaleString();
                    
                    let note_dict = JSON.stringify({"note": savedNotes,"time":time});
                    localStorage.setItem(<?= $apt_id?>,note_dict);
                    clearTimeout(timeoutId);
                }
            });
        })});
    </script>
<script>
    const WORD_LIMIT = 5;
    document.querySelectorAll('.item').forEach(item => {
      const fullText = item.getAttribute('data-full-text');
      if(fullText){
        const words = fullText.split(' ').slice(0, WORD_LIMIT).join(' ');
        const preview = item.querySelector('.preview');
        preview.textContent = words + (fullText.split(' ').length > WORD_LIMIT ? '...' : '');
      }
      
    });
  </script>
  <script>
    let selectCount = 1;
    let proc_row;
    let med_row;
    let lab_row;
    window.addEventListener('DOMContentLoaded', (event) =>{
       proc_row = document.querySelector("#procs_table tbody #og_row").cloneNode(true);
       med_row = document.querySelector("#meds_table tbody #og_row").cloneNode(true);
       lab_row = document.querySelector("#labs_table tbody #og_row").cloneNode(true);
    });


    function addVitalsRow(table,df_row) {
        if(selectCount >= 5){
            document.querySelector(".add-btn").style="display:none";
        }
      const tbody = document.querySelector(`#${table} tbody`);
      //const template_row =tbody.querySelector("#og_row");
      //const row = document.createElement('tr');
      const row = df_row.cloneNode(true);
      row.removeAttribute("id")
      const select = row.querySelector("select");
      select.removeAttribute("id");
      select.removeAttribute("data-select2-id");
      select.removeAttribute("tabindex");
      select.removeAttribute("aria-hidden");
      select.id="new-select-"+selectCount;
      select.removeAttribute("class");
      select.class="js-example-basic-single";
      row.querySelector("span").remove()


      tbody.appendChild(row);
      // scroll to newly added row
      row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      
    $("#new-select-"+selectCount).select2();
    selectCount++;
    }

    // simple form submit handler (prevents default for demo)
  
  </script>
  <script>
    const popup = document.getElementById('popup');
    const popupContent = document.getElementById('popupContent');
    const popupTitle = document.getElementById('popupTitle');
    const closeBtn = document.getElementById('closePopup');
    const aptBtn = document.getElementById('apt-btn');

    document.querySelectorAll('.item').forEach(item => {
    item.addEventListener('click', () => {
        const type = item.getAttribute('data-type');
        const titleText = item.getAttribute('data-title');
        popupTitle.textContent = titleText;
        aptBtn.addEventListener('click',()=>{
                window.open(`./docprocs.php?id=${item.getAttribute('data-id')}`,"_blank")
            });
        // Clear previous content
        popupContent.innerHTML = '';

        if (type === 'text') {
            
            const fullText = item.getAttribute('data-full-text');
            popupContent.innerHTML = "<p>"+fullText+"</p>";
            
        } else if (type === 'table') {
            aptBtn.style="display:none";
            const tableId = item.getAttribute('data-table-id');
            const table = document.getElementById(tableId);
            if (table) {
                // Clone the table and show it inside the popup
                const clone = table.cloneNode(true);
                clone.style.display = 'table';
                popupContent.appendChild(clone);
            }
        }

        popup.style.display = 'flex';
    });
    });

    closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
    });

    popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.style.display = 'none';
    });

    async function deleteRow(tab,id, table ,idtype,aptId) {
        if (!confirm('Delete this row?')) return;

  const formData = new URLSearchParams();
  formData.append('delid', id);
  formData.append('deltable', table);
  formData.append('idtype', idtype);
  formData.append('del_apt', aptId);

  const response = await fetch('rec_apt.php?tab='+tab, {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: formData
  });

  // If the server returned success → remove row
  if (response.ok) {
    location.reload();
  } else {
    alert('Delete failed');
  }
}
      
</script>

<script>
        var quill = new Quill('#note', {
            theme: 'snow',
            modules: {
    // 1. Enable the table module
    table: true, 
    toolbar: [
        [{ 'header': [1, 2, false] }],
      ['bold', 'italic', 'underline'],
      [{ 'color': [] }, { 'background': [] }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['clean']
    ]
  }
});
var form = document.querySelector('#notesForm');
var hiddenInput = document.querySelector('#notes');

form.onsubmit = function() {
  // 1. Get the HTML from the editor
  var html = quill.root.innerHTML;
  //html = html.replace(/^<p>/, '').replace(/<\/p>$/, '');
  // 2. Put that HTML into the hidden input
  hiddenInput.value = html;
  return true;
};

// 3. Add a helper to make the table button actually insert a table
const table = quill.getModule('table');
    </script>
<script src="../ICD10.js"></script>
</body>
</html>
<?php
include "../test.php";
    $conn->close();
?>