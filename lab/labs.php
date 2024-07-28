<?php
include "../conn.php";
include "../nav.php";
include "../table.html";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) { // Limit size to 5MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $sql ="update patients_labs set lab_date =now(), lab_results ='".basename( $_FILES["fileToUpload"]["name"])."'
            where p_lab_id = ".$_POST["id"];
           $result = $conn->query($sql);
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<body>

<h2>Upload File</h2>
<div id="lab_id">
    <?php 
    $sql = "SELECT patients_labs.p_lab_id,patients_labs.date, appointments.patient_id, CONCAT(patient.FName, ' ', patient.LName) AS 'Patient Name', labs.lab_name,patients_labs.type, patients_labs.lab_results, patients_labs.lab_date FROM patients_labs 
INNER JOIN appointments ON patients_labs.apt_id = appointments.id 
INNER JOIN patient ON patient.pat_id = appointments.patient_id 
INNER JOIN labs ON patients_labs.lab_id = labs.lab_id;";
    $result = $conn->query($sql);
   echo "<div class='container'><div class='table-wrapper'><table><thead><tr><th>Date</th><th>Patient Name</th><th>Type</th><th>Results</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $string = "<tbody><tr><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["type"]."</td>";
            if (is_null($row["lab_results"])) {
                $string =$string ."
                <td><form action='labs.php' method='post' enctype='multipart/form-data'>
                 <input type='hidden' name='id' value=".$row['p_lab_id'].">
                <input type='file' name='fileToUpload' id='fileToUpload' required>
                <input type='submit' value='Upload File' name='submit'>
                </form></td></tr>
                ";
            }else{
                $string = $string."<td>".$row["lab_results"]."</td><tr>";
            }
            echo $string;
        }
        
    }
    echo "</tbody></table></div></div>";
    ?>
</div>

</body>
</html>

