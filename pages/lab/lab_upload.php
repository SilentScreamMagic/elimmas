<?php 
require_once "../conn.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "../../files/";
    $fileName = $_FILES["fileToUpload"]["name"];
    $targetFile = $targetDir . basename($fileName);
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
            $stmt = $conn->prepare("UPDATE patients_labs SET lab_date = NOW(), lab_results = ? WHERE p_lab_id = ?");
            $stmt->bind_param("si", $fileName, $_POST["id"]);
            echo $_POST["p_lab_id"];
           $stmt->execute();
           $stmt->close();
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
header("Location: labs.php"); 
?>