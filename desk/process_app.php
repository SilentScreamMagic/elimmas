<?php
 include "../conn.php";
// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor_name = $_POST["doc_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $diagnosis = $_POST["diagnosis"];
    $type = $_POST["type"];
    $patient_condition = $_POST["patient_condition"];
    $diet = $_POST["diet"];
    $resuscitation_status = $_POST["resuscitation_status"];
    $medication_prescribed = $_POST["medication_prescribed"];

    $sql = "INSERT INTO appointments (patient_id, doc_id, date, time, diagnosis,type, patient_condition, resuscitation_status, diet, medication_prescribed)
    VALUES ('$patient_id', '$doctor_name', '$date', '$time', '$diagnosis','$type', '$patient_condition', '$resuscitation_status', '$diet', '$medication_prescribed')";
        if ($conn->query($sql) === TRUE) {
            header("Location: ./apthistory.php?id=$patient_id");
        } 
     
    
}

// Close the connection
$conn->close();
