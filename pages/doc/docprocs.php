<?php 
    
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
  []
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <!-- End layout styles -->
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
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
    
    $ids=["","","","","defaultOpen",""];
    if (isset($_POST["id"])){
        $_SESSION["apt_id"] = $_POST["id"];
        
    }
    
    $sql ='SELECT patient.pat_id,concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = '.$_SESSION["apt_id"];
    $result = $conn->query($sql)->fetch_assoc();
    $pat_id=$result["pat_id"];
    $pname = $result["Patient Name"];
    
    if (isset($_POST["proc_id"])){
        $sql = "insert into patients_proc(apt_id,proc_id,date ,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["proc_id"].",now() ,'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","defaultOpen","","","",""];
    }
 
    if (isset($_POST["meds"])){
        $sql = "insert into patients_meds(apt_id,med_id,per_dose,per_day,num_days,num_months,date ,created_by,ad_by) 
        values(".$_SESSION['apt_id'].",".$_POST["meds"].",".$_POST["per_dose"].",".$_POST["per_day"].",".$_POST["num_days"].",'".$_POST["num_months"]."',now() ,'".$_SESSION["user"][0]."','".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        $ids = ["","","defaultOpen","","",""];
    }
    if (isset($_POST["labs"])){
        $sql = "insert into patients_labs(apt_id,lab_id,date ,created_by) 
        values(".$_SESSION['apt_id'].",".$_POST["labs"].",now() ,'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        
        $ids = ["","","","defaultOpen","",""];
    }
    if (isset($_POST["notes"])){
       $sql = "INSERT INTO `notes`( `type`,`apt_id`, `notes`, `date`,created_by) VALUES ('doc_notes',$_SESSION[apt_id],'$_POST[notes]',now() ,'".$_SESSION["user"][0]."')";
        $result = $conn->query($sql);
        
        $ids = ["","","","","defaultOpen",""];
    }
    if (isset($_POST["dis_notes"])){
        $sql = "DELETE FROM `notes` WHERE apt_id =20 and type = 'dis_notes';";
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
                    <h4 class='card-title'><?php echo $pname?></h4>
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'notes')" <?php if('defaultOpen'==$ids[4]) echo 'id ="'.$ids[4].'"';?>>Notes</button>
                        <button class="tablinks" onclick="openTab(event, 'procs')" <?php if('defaultOpen'==$ids[1]) echo 'id ="'.$ids[1].'"';?>>Procedures</button>
                        <button class="tablinks" onclick="openTab(event, 'meds')"  <?php if('defaultOpen'==$ids[2]) echo 'id ="'.$ids[2].'"';?>>Medications</button>
                        <button class="tablinks" onclick="openTab(event, 'labs')"  <?php if('defaultOpen'==$ids[3]) echo 'id ="'.$ids[3].'"';?>>Labs</button>
                        <button class="tablinks" onclick="openTab(event, 'dis_notes')" <?php if('defaultOpen'==$ids[5]) echo 'id ="'.$ids[5].'"';?>> Discharge</button>   
                    </div>
<div id="procs" class="tabcontent">
    <!-- Content for beds tab -->
     <h4 class='card-title'>Procedures</h4>
    <p>List of Procedures...</p>
    <form action= "" method="post">
        <label>Procedure Name:</label>
        <div class="dropdown" id="dropdown1">
        <input type="text" placeholder="Search.." class="dropdown-input" data-dropdown="dropdown1">
        <div class="dropdown-content">
            <?php 
                foreach ($proc as $pid => $det): ?>
                    <div data-value="<?php echo $pid; ?>"><?php echo $det; ?></div>
                <?php 
                endforeach;?>
            </div>
        </div>
        <input type="hidden" name = "proc_id" id="selectedValue1">
    
        <input type="submit" value="Submit"><br><br>
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
    <p>List of Medications...</p>
    <button onclick='openOption()'>Refill?</button>
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
        <label for="med_count">Per Dose</label>
        <input type="number" name="per_dose" id = "med_count" required>
        <label for="per_day">Per Day</label>
        <input type="number" name="per_day" id = "per_day" required>
        <label for="num_days">Number Of Days</label>
        <input type="number" name="num_days" id = "num_days" required>
        <div id = 'refill' style='display: inline-block; visibility: hidden;'>
            <label for="num_months">Number Of Months</label>
            <input type="number" name="num_months" id = "num_months" >
        </div>
        <input type="submit" value="Submit"><br><br>    
    </form>
    <?php 
        $sql = "SELECT p_med_id,patients_meds.date,medication.med_name,medication.price,per_dose,per_day,num_days,num_months FROM `patients_meds` 
        join medication on medication.med_id = patients_meds.med_id where apt_id = ".$_SESSION["apt_id"]." and deleted = 0 order by date;";
        $result = $conn->query($sql);?>
        
                    <div class='table-responsive'>
                    
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th></th><th>Date</th><th>Medication Name</th><th>Per Dose</th><th>Per Day</th><th>Number Of Days</th><th>Number Of Months</th>
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
                                    <td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["num_months"]."</td></tr>";
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
    <p>List of Labs...</p>
    
    <form action= "" method="post">
        <label>Select an Option:</label>
        <div class="dropdown" id="dropdown3">
        <input type="text" placeholder="Search.." class="dropdown-input" data-dropdown="dropdown3">
        <div class="dropdown-content">
            <?php 
                foreach ($labs as $lid => $det): ?>
                    <div data-value="<?php echo $lid; ?>"><?php echo $det; ?></div>
                <?php 
                endforeach;?>
            </div>
        </div>
        <input type="hidden" name = "labs" id="selectedValue3">
        <input type="submit" value="Submit"><br><br>
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
        <textarea name="notes" cols="70" rows="10"></textarea>
        <input type="submit" value="Submit"><br><br>
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
                            $sql = "SELECT date,vitals.vital_name,patients_vits.vit_id,patients_vits.measure FROM `patients_vits` 
                            INNER JOIN vitals on vitals.vit_id = patients_vits.vit_id 
                            where apt_id = $_SESSION[apt_id] and date = (SELECT MAX(date) from patients_vits WHERE apt_id = $_SESSION[apt_id]) and deleted = 0
                            order by date;";
                            $result = $conn->query($sql);
                            $vitals = [];

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $vitals[$row["date"]][$row["vit_id"]] =$row["measure"];
                                }
                                foreach($vitals as $date=> $dets){
                                    echo "<div class='patient-card'>";
                                    echo "<h2>$date</h2>";
                                    echo "<div class='patient-info'>";
                                    echo "<div><span>Body Temperature </span> $dets[1]</div>";
                                    echo "<div><span>Pulse Rate </span> $dets[2]</div>";
                                    echo "<div><span>Respiration Rate </span> $dets[3]</div>";
                                    echo "<div><span>Diastolic Blood Pressure </span> $dets[4]</div>";
                                    echo "<div><span>Systolic Blood Pressure </span> $dets[5]</div>";
                                    echo "<div><span>Oxygen Saturation </span> $dets[4]</div>";
                                    echo "</div>";
                                    echo "</div>";
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
                        <div id="doc_notes"  class="scrollable-container">
                                <h1></h1>
                                <?php
                                $sql = "SELECT cast(notes.date as date) date,GROUP_CONCAT(cast(notes.date as time),'<br>',notes.notes,'<br>' SEPARATOR '<br>') notes FROM `notes`
                                    where type ='doc_notes' and apt_id = $_SESSION[apt_id] and deleted = 0
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
                                    where type ='nur_notes' and apt_id = $_SESSION[apt_id] and deleted = 0
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
</div>
        

       


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
</body>
</html>
<?php
include "../test.php";
    $conn->close();
?>