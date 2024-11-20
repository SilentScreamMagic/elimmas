<?php
 include "../conn.php";
 session_start();
// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor_name = $_POST["doc_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $type = $_POST["type"];

    $sql ="SELECT COUNT(id) count from appointments WHERE patient_id = $patient_id;";
    $result = $conn->query($sql)->fetch_assoc();
    $sql = "INSERT INTO appointments (patient_id, doc_id, date, time, type)
    VALUES ('$patient_id', '$doctor_name', '$date', '$time','$type')";
        if ($conn->query($sql) === TRUE) {
            if ($result["count"] == 0){
                $id = $conn->insert_id;
                
                $sql = "INSERT INTO `patients_proc` (`apt_id`, `proc_id`, `date`, `created_by`) VALUES ('$id', '74', now(),'".$_SESSION["user"][0]."')";
                echo $sql;
                $conn->query($sql);
            }
            header("Location: ./apthistory.php?id=$patient_id");
        } 
     
    
}

// Close the connection
$conn->close();
