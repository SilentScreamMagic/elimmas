<?php
    require_once "../conn.php";
    $query = "INSERT INTO `patient`(`FName`, `LName`, `DOB`, `gender`, 
    `emergency_fname`, `emergency_lname`, `marital_status`, `address`, `patient_phone`, `patient_email`, `emergency_phone`,
     `emergency_email`, `referred_by`, `registration_date`, `employment`, `special_codes`) 
    VALUES ('$_POST[FName]','$_POST[LName]','$_POST[DOB]','$_POST[gender]',
    '$_POST[emergency_fname]','$_POST[emergency_lname]','$_POST[marital_status]','$_POST[address]','$_POST[patient_phone]',
    '$_POST[patient_email]','$_POST[emergency_phone]','$_POST[emergency_email]','$_POST[referred_by]',now(),
    '$_POST[employment]','$_POST[special_codes]');";
    echo $query;
    
    $result = mysqli_query($conn, $query);
    
    $conn->close();
    header('Location: appointments.php');