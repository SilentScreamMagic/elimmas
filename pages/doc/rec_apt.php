<?php 
include "../conn.php";
session_start();
if ($_GET["tab"]) {
    $tab = $_GET["tab"];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["apt_type"])){
        $apt_id =$_POST["apt_type"];
        if($_POST["type"]=="In-Patient"){
            $sql = "update appointments set type = 'Consultation' where id =$_POST[apt_type]";
            $result = $conn->query($sql);
        }else{
            $sql = "update appointments set type = 'In-Patient' where id =$_POST[apt_type]";
            $result = $conn->query($sql);
        }
        
      }
    
    
    if (isset($_POST["proc_id"])) {
        $apt_id =$_POST["proc_apt"];
        
    
    foreach ($_POST["proc_id"] as $proc_id) {
        $sql = "INSERT INTO patients_proc (apt_id, proc_id, date, created_by) 
        VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $_POST["proc_apt"], $proc_id, $_SESSION["user"][0]);
        $stmt->execute();
        $stmt->close();
    }
    


}

// Insert into patients_meds
if (isset($_POST["med"])) {
    $apt_id =$_POST["med_apt"];
    for ($i=0; $i < count($_POST["med"]); $i++) { 
        $sql = "INSERT INTO patients_meds 
                (apt_id, med_id, per_dose, per_day, num_days, date, created_by, ad_by) 
                VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiss", 
            $_POST["med_apt"], 
            $_POST["med"][$i], 
            $_POST["per_dose"][$i], 
            $_POST["per_day"][$i], 
            $_POST["num_days"][$i], 
            $_SESSION["user"][0], 
            $_SESSION["user"][0]
        );
        $stmt->execute();
    }
    $stmt->close();

   
}

// Insert into patients_labs
if (isset($_POST["labs"])) {
    $apt_id =$_POST["lab_apt"];
    foreach ($_POST["labs"] as $lab) {
        $sql = "INSERT INTO patients_labs (apt_id, lab_id, date, created_by) 
            VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $_POST['lab_apt'], $lab, $_SESSION["user"][0]);
        $stmt->execute();
    }
    $stmt->close();

}

// Notes
if (isset($_POST["save_notes"])) {
        $sql = "INSERT INTO notes (type, apt_id, notes, date, created_by) 
                VALUES ('doc_notes', ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $_POST["notes_apt"], $_POST["notes"], $_SESSION["user"][0]);
        $stmt->execute();
        $stmt->close();

    
    $apt_id =$_POST["notes_apt"];
}
if (isset($_POST["diag"])) {
        $sql = "UPDATE `appointments` SET `diagnosis`=? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $_POST["diag"], $_POST["diag_apt"]);
        $stmt->execute();
        $stmt->close();


    
    $apt_id =$_POST["diag_apt"];
}

// Keep session notes


// Discharge notes
if (isset($_POST["dis_notes"])) {
    // Delete old discharge notes
    $sql = "DELETE FROM notes WHERE apt_id = ? AND type = 'dis_notes'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST["disnotes_apt"]);
    $stmt->execute();
    $stmt->close();

    // Insert new discharge notes
    $sql = "INSERT INTO notes (type, apt_id, notes, date, created_by) 
            VALUES ('dis_notes', ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $_POST["disnotes_apt"], $_POST["dis_notes"], $_SESSION["user"][0]);
    $stmt->execute();
    $stmt->close();
    $apt_id =$_POST["disnotes_apt"];
    
}
     if (isset($_POST["deltable"])){
        $sql = "UPDATE $_POST[deltable] SET `deleted`=1 WHERE $_POST[idtype] = $_POST[delid]";
        $result = $conn->query($sql);
        $apt_id =$_POST["del_apt"];
    
    
     } 
   
   
    header("Location: docprocs.php?id=$apt_id#$tab"); 

}?>