<?php
    require_once "../conn.php";
    $query = "INSERT INTO `patient`(`FName`, `LName`, `DOB`, `gender`, `financial_type`, 
    `guardian_fname`, `guardian_lname`, `marital_status`, `address`, `patient_phone`, `patient_email`, `guardian_phone`,
     `guardian_email`, `referred_by`, `registration_date`, `employment`, `special_codes`) 
    VALUES ('$_POST[FName]','$_POST[LName]','$_POST[DOB]','$_POST[gender]','$_POST[financial_type]',
    '$_POST[guardian_fname]','$_POST[guardian_lname]','$_POST[marital_status]','$_POST[address]','$_POST[patient_phone]',
    '$_POST[patient_email]','$_POST[guardian_phone]','$_POST[guardian_email]','$_POST[referred_by]',now(),
    '$_POST[employment]','$_POST[special_codes]');";
    echo $query;
    
    $result = mysqli_query($conn, $query);
    
    $conn->close();
    header('Location: appointments.php');