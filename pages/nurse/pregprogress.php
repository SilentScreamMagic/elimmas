<?php
    include "../conn.php";
    include "../nav.php";
    include "../table.html";
    include "../tabs.html";
    include "../test.php";
    
    if (isset($_POST["preg"])){
        $sql = "INSERT INTO `patient_prog`(`prog_id`, `apt_id`, `measure`, `date`) 
        VALUES ('".$_POST["preg"]."','".$_SESSION['apt_id']."','".$_POST['measure']."',now())";
        $result = $conn->query($sql);
        $ids = ["","","","","","","defaultOpen"];
    }
    $sql = "SELECT * FROM preg_progress";
    $result = $conn->query($sql);
    $prog = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $prog[$row["prog_id"]] = $row["prog_name"];
        }
    }
    echo $_GET["id"];
    $sql ='SELECT concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = '.$_SESSION["apt_id"];
    $result = $conn->query($sql)->fetch_assoc();
    $pname = $result["Patient Name"];
?>
<!DOCTYPE html>
<html>

<body>
<h1><?php echo $pname?></h1>
<form action= "" method="post">
        <label for="preg">Select a Pregnancy Progress value:</label>
        <select name="preg" id="preg" required>
            <option value="">Select an Option...</option>
            <?php foreach ($prog as $pid => $dets): ?>
                <option value="<?php echo $pid; ?>"><?php echo $dets; ?></option>
            <?php endforeach; ?>
            </select>
        <input type="text" name="measure" id = "measure" required>
        <input type="submit" value="Submit"><br><br>
    </form>

    <div class="tab">
        <?php
            foreach ($prog as $pid => $dets):?>
                <button class='tablinks' onclick='openTab(event, "<?php echo $dets; ?>")'><?php echo $dets; ?></button>  
            <?php endforeach?>
         </div>
<?php
    foreach ($prog as $pid => $dets):
        echo "<div id='$dets' class='tabcontent'>
        <h3>$dets</h3>";
        $sql = "SELECT prog_name, `measure`, `date` FROM `patient_prog` 
        INNER JOIN preg_progress on preg_progress.prog_id = patient_prog.prog_id
        where apt_id = ".$_SESSION["apt_id"]." and preg_progress.prog_id = $pid order by date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>$dets</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["measure"]."</td></tr>";
            }
            
        }
        echo "</table></div>";
    endforeach;
?>
<div id="fetalbr" class="tabcontent">
    <!-- Content for rooms tab -->
    <h3>Fetal Birth Rate</h3>
    <?php 
        $sql = "SELECT prog_name, `measure`, `date` FROM `patient_prog` 
        INNER JOIN preg_progress on preg_progress.prog_id = patient_prog.prog_id
        where apt_id = ".$_SESSION["apt_id"]." and preg_progress.prog_id = 9 order by date;";
        $result = $conn->query($sql);
        echo "<table><tr><th>Date</th><th>Fetal Birth Rate</th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["measure"]."</td></tr>";
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