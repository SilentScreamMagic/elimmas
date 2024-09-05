<?php
 include "../conn.php";
// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor_name = $_POST["doc_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $type = $_POST["type"];
    $diet = $_POST["diet"];

    $sql = "INSERT INTO appointments (patient_id, doc_id, date, time, type, diet)
    VALUES ('$patient_id', '$doctor_name', '$date', '$time','$type', '$diet')";
        if ($conn->query($sql) === TRUE) {
            header("Location: ./apthistory.php?id=$patient_id");
        } 
     
    
}

// Close the connection
$conn->close();
