<?php 
    include "../conn.php";
    include "../nav.php";
    include "../table.html";
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
        $sql = "insert into patients_proc(apt_id,proc_id,date) 
        values(".$_SESSION['apt_id'].",".$_POST["proc_id"].",now())";
        $result = $conn->query($sql);
        
        $ids = ["","defaultOpen","","","",""];
    }
 
    if (isset($_POST["meds"])){
        $sql = "insert into patients_meds(apt_id,med_id,per_dose,per_day,num_days,num_months,date) 
        values(".$_SESSION['apt_id'].",".$_POST["meds"].",".$_POST["per_dose"].",".$_POST["per_day"].",".$_POST["num_days"].",'".$_POST["num_months"]."',now())";
        $result = $conn->query($sql);
        $ids = ["","","defaultOpen","","",""];
    }
    if (isset($_POST["labs"])){
        $sql = "insert into patients_labs(apt_id,lab_id,date) 
        values(".$_SESSION['apt_id'].",".$_POST["labs"].",now())";
        $result = $conn->query($sql);
        
        $ids = ["","","","defaultOpen","",""];
    }
    if (isset($_POST["notes"])){
       $sql = "INSERT INTO `notes`( `apt_id`, `notes`, `date`) VALUES ($_SESSION[apt_id],'$_POST[notes]',now())";
        $result = $conn->query($sql);
        
        $ids = ["","","","","defaultOpen",""];
    }
    if (isset($_POST["dis_notes"])){
        $sql = "UPDATE `appointments` SET `dis_notes`='".$_POST['dis_notes']."' , check_out = now() WHERE id = ".$_POST['apt_id'];
        echo $sql;
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

<!DOCTYPE html>
<html>
<head>
    <style>
          body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2; /* Light gray background */
    margin: 0; /* Remove default margin */
}
.contain {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
.header-container {
    display: flex;
    justify-content: center;
    padding: 20px;
    background-color: #fff; /* Background color for the header */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a shadow to the header */
}

.header2 {
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header h1 {
    margin: 0;
}

.patient-card {
    width: auto; /* Adjust the width as needed */
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background-color: #fff; /* White background for the card */
    overflow-x: auto; /* Allow horizontal scrolling if needed */
}

.patient-info {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap; /* Ensure items don't wrap */
}

.patient-info div {
    flex: 0 0 auto; /* Make each div take only its content width */
    margin-bottom: 10px;
    padding-right: 20px; /* Add some spacing between items */
}

.patient-info div span {
    font-weight: bold;
}
/* Styles for the main notes tab content */
.tabcontent {
    padding: 20px;
}

/* Styles for the scrollable container */
.scrollable-container {
    max-height: 200px; /* Adjust the height as needed */
    max-width: 500px;
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
    
}

/* Styles for each box of text */
.text-box {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    background-color: #fff;
}

.text-box:last-child {
    margin-bottom: 0; /* Remove margin from the last box */
}
.text-box .date {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }
        .expandable {
            overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: block;
    transition: all 0.3s ease;
        }
        .expanded {
            white-space: normal;
            max-height: none;
        }
    </style>
</head>
<body>
<div class="header-container">
        <header class="header2">
    <h1><?php echo $pname?></h1>
    <?php
     $sql = "SELECT date,vitals.vital_name,patients_vits.vit_id,patients_vits.measure FROM `patients_vits` 
     INNER JOIN vitals on vitals.vit_id = patients_vits.vit_id 
     where apt_id = ".$_SESSION["apt_id"]." order by date
      LIMIT 4 ;";
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
            echo "<div><span>Blood Pressure </span> $dets[4]</div>";
            echo "</div>";
            echo "</div>";
            
            
        }
     }
     echo "</div>";
?>
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'notes')" <?php if('defaultOpen'==$ids[4]) echo 'id ="'.$ids[4].'"';?>>Notes</button>
    <button class="tablinks" onclick="openTab(event, 'procs')" <?php if('defaultOpen'==$ids[1]) echo 'id ="'.$ids[1].'"';?>>Procedures</button>
    <button class="tablinks" onclick="openTab(event, 'meds')"  <?php if('defaultOpen'==$ids[2]) echo 'id ="'.$ids[2].'"';?>>Medications</button>
    <button class="tablinks" onclick="openTab(event, 'labs')"  <?php if('defaultOpen'==$ids[3]) echo 'id ="'.$ids[3].'"';?>>Labs</button>
    <button class="tablinks" onclick="openTab(event, 'dis_notes')"> Discharge</button>
    
</div>

<div id="procs" class="tabcontent">
    <!-- Content for beds tab -->
    <h3>Procedures</h3>
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
    <?php 
    $sql = "SELECT patients_proc.date,procedures.Prod_Name, procedures.Price FROM procedures 
    JOIN patients_proc on patients_proc.proc_id = procedures.prod_id
    where patients_proc.apt_id =".$_SESSION["apt_id"]." order by date;";
    $result = $conn->query($sql);
   echo "<table><tr><th>Date</th><th>Procedure</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["date"]."</td><td>".$row["Prod_Name"]."</td></tr>";
        }
        
    }
    echo "</table>";
    ?>
</div>

<div id="meds" class="tabcontent">
    <!-- Content for rooms tab -->
    <h3>Medications</h3>
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
        $sql = "SELECT patients_meds.date,medication.med_name,medication.price,per_dose,per_day,num_days,num_months FROM `patients_meds` 
        join medication on medication.med_id = patients_meds.med_id where apt_id = ".$_SESSION["apt_id"]." order by date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Medication Name</th><th>Per Dose</th><th>Per Day</th><th>Number Of Days</th><th>Number Of Months</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["num_months"]."</td></tr>";
            }   
        }
        echo "</table>";
    ?>
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
        $sql = "SELECT date,labs.lab_name,lab_results,lab_date FROM `patients_labs` 
        join labs on labs.lab_id = patients_labs.lab_id where apt_id = ".$_SESSION["apt_id"]." order by date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Labs Name</th><th></th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["lab_name"]."</td>";
                if ($row["lab_results"]!= null){
                      echo "<td><a href='../open_pdf.php?file=./uploads/$row[lab_results]' target='_blank'>Open PDF</a></td></tr>";  
                }
            }
            
        }
        echo "</table>";
    ?>
</div>
<div id="notes" class="tabcontent">
    <div class ="contain">
        <!-- Content for rooms tab -->
    <div>
        <button  onclick="toggleTransparency('nur_notes')">Nurse's Notes</button>
        <button onclick="toggleTransparency('doc_notes')">Doctor's Notes</button>
        <h3>Notes</h3>
    <form action= "" method="post">
        <textarea name="notes" cols="70" rows="10"></textarea>
        <input type="submit" value="Submit"><br><br>
    </form>
    </div>     
    
    <div id="nur_notes" style="visibility: hidden;" class="scrollable-container">
            <h1>Nurses's Notes</h1>
            <?php
            $sql = "SELECT date,nur_notes FROM `appointments` WHERE patient_id = ".$_SESSION["apt_id"]." order by date;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                echo '<div class="text-box">';
            echo '<div class="date">' . $row["date"] . '</div>';
            echo $row["nur_notes"];
            echo '</div>';
                }
            }
           
            ?>
    </div>
    
    <div id="doc_notes" style="visibility: hidden;" class="scrollable-container">
            <h1>Doctor's Notes</h1>
            <?php
            $sql = "SELECT cast(notes.date as date) date,GROUP_CONCAT(cast(notes.date as time),'<br>',notes.notes,'<br>' SEPARATOR '<br><br>') notes FROM `notes`
                inner join appointments on notes.apt_id = appointments.id
                where appointments.patient_id =$pat_id
                GROUP by cast(notes.date as date)
                order by notes.date;;";
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
<div id="dis_notes" class="tabcontent">
    <div class ="contain">
        <!-- Content for rooms tab -->
        <div>
            <h3>Discharge Notes</h3>
            <?php
        $sql = "SELECT `dis_notes` FROM `appointments` WHERE id =".$_SESSION["apt_id"];
        $result = $conn->query($sql);
        $dis_notes = $result->fetch_assoc();?>
            <form action= "" method="post">
                <input type="hidden" name="apt_id" value = <?php echo $_SESSION['apt_id']?>>
                <textarea name="dis_notes" cols="70" rows="10"><?php if ($dis_notes["dis_notes"]) echo $dis_notes["dis_notes"];?></textarea>
                <input type="submit" value="Submit"><br><br>
        </form>
    </div>        
    </div>
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