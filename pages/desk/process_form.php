<?php
    require_once "../conn.php";
    if($_POST["id"]==""){
        $stmt = $conn->prepare("
    INSERT INTO patient (
        FName, LName, DOB, gender, 
        emergency_fname, emergency_lname, marital_status, address, 
        patient_phone, patient_email, emergency_phone, emergency_email, 
        referred_by, registration_date, employment, special_codes
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?
    )
");
$stmt->bind_param(
    "sssssssssssssss", // 15 placeholders, all strings
    $_POST['FName'],
    $_POST['LName'],
    $_POST['DOB'],
    $_POST['gender'],
    $_POST['emergency_fname'],
    $_POST['emergency_lname'],
    $_POST['marital_status'],
    $_POST['address'],
    $_POST['patient_phone'],
    $_POST['patient_email'],
    $_POST['emergency_phone'],
    $_POST['emergency_email'],
    $_POST['referred_by'],
    $_POST['employment'],
    $_POST['special_codes']
);

$stmt->execute();
$stmt->close();
    }else{


$stmt = $conn->prepare("
    UPDATE patient SET 
        FName = ?, 
        LName = ?, 
        DOB = ?, 
        gender = ?, 
        emergency_fname = ?, 
        emergency_lname = ?, 
        marital_status = ?, 
        address = ?, 
        patient_phone = ?, 
        patient_email = ?, 
        emergency_phone = ?, 
        emergency_email = ?, 
        referred_by = ?, 
        employment = ?, 
        special_codes = ?
    WHERE pat_id = ?
");

$stmt->bind_param(
    "sssssssssssssssi", // 15 strings + 1 integer
    $_POST['FName'],
    $_POST['LName'],
    $_POST['DOB'],
    $_POST['gender'],
    $_POST['emergency_fname'],
    $_POST['emergency_lname'],
    $_POST['marital_status'],
    $_POST['address'],
    $_POST['patient_phone'],
    $_POST['patient_email'],
    $_POST['emergency_phone'],
    $_POST['emergency_email'],
    $_POST['referred_by'],
    $_POST['employment'],
    $_POST['special_codes'],
    $_POST['id'] // assumed to be an integer
);

$stmt->execute();
$stmt->close();

    }
    

    
    $conn->close();
    header('Location: appointments.php');