<?php  
    $pat_id ="";
    if (isset($_POST['id'])){
        $pat_id = $_POST['id'];
    }
    include "../conn.php";
    //include "../nav.php";
    //include "../table.html";
    $sql = "SELECT pat_id,concat(Fname,' ',LName) as 'Patient Name' FROM patient;";
    $result = $conn->query($sql);
    $patients = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[$row["pat_id"]] = $row["Patient Name"];
        }
    
    }
    $sql = "SELECT username,Name,user_type FROM users
    where user_type = 'Doctor';";
    $result = $conn->query($sql);
    $docs = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $docs[$row["username"]] = $row["Name"];
        }
    
    }
    
 
 
    $conn->close();
?>
<!DOCTYPE html>
<head>
    <title>Patient Record Form</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    justify-content: center;
    align-items: center;
    margin: 0;
}

.form-container {
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.form-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input, .form-group textarea, .form-group select{
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus, .form-group textarea:focus select:focus{
    border-color: #007bff;
    outline: none;
}

.form-button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <!-- End layout styles -->
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
  </head>
  <body>
  <div class='container-scroller'>
  
    <?php include '../nav.php';?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                  <div class="form-container">
        <h2>Patient Record Form</h2>
        <form action="process_app.php" method="post">
            <div class="form-group">
                <label for="patient_id">Patients Name:</label>
                <select name="patient_id" id="patient_id">
                    <option value="">Select a patient...</option>
                    <?php foreach ($patients as $pid => $name): ?>
                        <option value="<?php echo $pid; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="doc_id">Doctor Name:</label>
                <select name="doc_id" id="doc_id">
                    <option value="">Select a Doctor...</option>
                    <?php foreach ($docs as $did => $name): ?>
                        <option value="<?php echo $did; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="type">Appointment Type:</label>
                <select id="type" name="type" required>
                <option value="In-Patient">In-Patient</option>
                <option value="Consultation">Consultation</option>
                </select>
            </div>
            <div class="form-group">
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis">
            </div>
            <div class="form-group">
                <label for="patient_condition">Patient Condition:</label>
                <input type="text" id="patient_condition" name="patient_condition" required>
            </div>
            
            <div class="form-group">
                <label for="diet">Diet:</label>
                <select id="diet" name="diet" required>
                    <option value="regular">Regular Diet</option>
                    <option value="mechanical_soft">Mechanical Soft Diet</option>
                    <option value="puree">Puree Diet</option>
                    <option value="low_fiber">Low Fiber/“GI Soft” Diet</option>
                    <option value="carbohydrate_controlled">Carbohydrate Controlled Diet</option>
                    <option value="cardiac">Cardiac Diet</option>
                    <option value="thickened_liquids">Thickened Liquids Restrictions</option>
                </select>
            </div>

            <div class="form-group">
                <label for="resuscitation_status">Resuscitation Status:</label>
                <select id="resuscitation_status" name="resuscitation_status" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="medical_history">Medical History</label>
                <textarea id="medical_history" name="medical_history" rows="4" cols="50"></textarea>
            </div>
        
            <button class="form-button" type="submit" value="Submit">Submit</button>
        </form>
    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class='footer'>
            <div class='d-sm-flex justify-content-center justify-content-sm-between'>
              <span class='text-muted d-block text-center text-sm-left d-sm-inline-block'>Copyright © bootstrapdash.com 2020</span>
              <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'> Free <a href='https://www.bootstrapdash.com/bootstrap-admin-template/' target='_blank'>Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
    
   
</body>
</html>
