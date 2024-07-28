<?php
 include "../conn.php";
 include "../nav.php";
 include "../table.html";
if(isset($_POST["bed_id"])){
    if(isset($_POST["new_bed"])&&$_POST["new_bed"]!=''){
        
        $sql = "update beds set status = 'dirty' where bed_id = ".$_POST["bed_id"];
        $result = $conn->query($sql);
        if($conn->affected_rows==1){
            $sql = "update patients_beds set end_date = now() where bed_id = ".$_POST["bed_id"];
            $result = $conn->query($sql);
            $sql = "INSERT INTO `patients_beds` ( `bed_id`, `apt_id`, `start_date`) 
            VALUES ( ".$_POST["new_bed"].",".$_POST["id"].", now())";
            $result = $conn->query($sql);
            $sql = "update beds set status = 'occupied' where bed_id = ".$_POST["new_bed"];
            $result = $conn->query($sql);
        }
        
        
    }elseif ($_POST["status"]=="dirty"){
        $sql = "update beds set status = 'clean' where bed_id = ".$_POST["bed_id"];
        $result = $conn->query($sql);
        
    }
 }
 
 $sql = "SELECT concat(Fname,' ',LName) 'Patient Name',beds.room_id, beds.bed_id,beds.status,pb.apt_id FROM `beds` 
 left join (SELECT * from patients_beds WHERE end_date is null) pb
 on beds.bed_id = pb.bed_id 
 LEFT join appointments on appointments.id = pb.apt_id
 Left join patient on appointments.patient_id = patient.pat_id
 order by beds.bed_id;";
 $result = $conn->query($sql);
 
 if ($result->num_rows > 0) {
    $bedsArray = array();
    $bedsArray2 = array();
    while ($row = $result->fetch_assoc()) {
        $bedsArray[$row["room_id"]][] = array(
            "bed_id" => $row["bed_id"],
            "status" => $row["status"],
            "apt_id" =>$row["apt_id"],
            "p_name" =>$row["Patient Name"]
        );
        $bedsArray2[$row["bed_id"]] = array(
            "bed_id" => $row["room_id"],
            "status" => $row["status"],
            "apt_id" =>$row["apt_id"],
            "p_name" =>$row["Patient Name"]
        );

    }

} else {
    echo "0 results";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 10px;
}

.room {
    margin-bottom: 20px;
}

.beds {
    display: flex;
    flex-wrap: wrap;
}

.bed {
    display: block;
    width: 150px;
    height: 50px;
    background-color: lightblue;
    margin: 5px;
    text-align: center;
    line-height: 50px;
    text-decoration: none;
    color: black;
}

.bed:hover {
    background-color: skyblue;
}
.clean {
    background-color: green;
    color: white;
}

.dirty {
    background-color: red;
    color: white;
}

.occupied {
    background-color: grey;
    color: white;
}

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms and Beds</title>
</head>
<body>
    <div class="container">
    <h1>Rooms and Beds</h1>
    <div class="rooms">
    <?php
    $count = 0;
    for ($i=1; $i < sizeof($bedsArray)+1; $i++) { 
        echo '<div class="room">';
        echo '<h2>Room ' . $i . '</h2>';
        echo '<div class="beds">';
        foreach ($bedsArray[$i] as $bed) {
            $statusClass = $bed['status'] === 'occupied' ? $bed["p_name"]: ($bed['status'] === 'clean' ? 'clean' : 'dirty');
            echo '<div>';
            if($statusClass ==$bed["p_name"]){
                echo " <form action= 'viewpatient.php' method='post'>";
            }else{
                echo " <form action= 'rooms.php' method='post'>";
            }
            
            echo "<input type='hidden' name='id' value=".$bed['apt_id'].">";
            echo "<input type='hidden' name='status' value=".$bed['status'].">";
            echo "<input type='hidden' name='bed_id' value=".$bed['bed_id'].">";
            echo "<input type ='submit' class='bed ".$bed['status']."' value = 'Bed ".$bed['bed_id'].": $statusClass'>";
            echo "</form>";
            if($statusClass == $bed["p_name"]){
                echo "<button onclick='openOption(".$bed['bed_id'].")'>Transfer</button>";
                echo "<form action= 'rooms.php' method='post'>";
                echo "<div id = 'transferBed".$bed['bed_id']."' style='visibility: hidden;'>";
                echo "<select name='new_bed' id='new_bed' required>
                <option value='' disabled selected>Select a new Bed...</option>";
                foreach ($bedsArray2 as $bid =>$dets):
                    if($dets["status"]== "clean"){
                        echo "<option value='$bid'>Bed $bid </option>";
                    }
                    endforeach;
                    echo "<input type ='submit'>";
                    echo "</form>";
                    echo "</div>";
            }
            
            
            
            echo '</div>';
        }
        
        echo '</div>'; // Close beds div
        echo '</div>'; // Close room div
    }?>
        </div> <!-- Close rooms div -->
    </div> <!-- Close container div -->
<script>
function openOption(id) {
    let bed = "transferBed" +id;
    if(document.getElementById(bed).style.visibility == "visible"){
        document.getElementById(bed).style.visibility = "hidden";
    }else{
        document.getElementById(bed).style.visibility = "visible"
    }
  ;
}
</script>
</body>
</html>
<?php
    $conn->close();
?>