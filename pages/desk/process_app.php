<?php
 include "../conn.php";
 session_start();
// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $doctor_id  = $_POST["doc_id"];
    $date       = $_POST["date"];
    $time       = $_POST["time"];
    $type       = $_POST["type"];
    $created_by = $_SESSION["user"][0];

    // 1. Check if patient already has appointments
    $sql = "SELECT COUNT(id) as count FROM appointments WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // 2. Insert new appointment
    $sql = "INSERT INTO appointments (patient_id, doc_id, date, time, type)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $patient_id, $doctor_id, $date, $time, $type);
    
    if ($stmt->execute()) {
        // get the inserted appointment id
        $id = $stmt->insert_id;
        $stmt->close();

        // 3. If first appointment, insert default procedure
        if ($result["count"] == 0) {
            $sql = "INSERT INTO patients_proc (apt_id, proc_id, date, created_by)
                    VALUES (?, 74, NOW(), ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $id, $created_by);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect to appointment history
        header("Location: ./apthistory.php?id=$patient_id");
        exit;
    } else {
        $stmt->close();
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
