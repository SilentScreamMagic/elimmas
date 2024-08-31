<?php
 include "../conn.php";
 //include "../nav.php";
 //include "../table.html";
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
    width: auto;
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
<!DOCTYPE html>
<html lang='en'>
  <head>
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
  
    <?php include '../nav.php';?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
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
     <!-- Close container div -->
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