<?php
$id ="unchanged";
    if (isset($_POST["id"])){
      $id = $_POST["id"];
    }
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <!-- Required meta tags -->
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <!-- plugins:css -->
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    
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
  
    <?php include '../nav.php';
    include "../conn.php";
    

// Now you can access the data
     if (isset($_GET["id"])){
      $id = $_GET['id'] ?? null;
      $column = (int)$_GET['column'] ?? null;
      $value = $_GET['value'] ?? null;
      $columns = ['body_temp', 'pulse_rate', 'respiration_rate', 'bp', 'oxygen_sat', 'weight'];
      $col=$columns[$column-2]; 
      if ($id && $column && $value !== null) {
        if($column-2 == 3){
          $bp = explode("/",$value);
          $sql = "UPDATE `patients_vits` SET systolic_bp = $bp[0], dystolic_bp =$bp[1] where `p_vit_id`='$id'";
          $conn->query($sql);
        }else{
          $sql = "UPDATE `patients_vits` SET $col = $value where `p_vit_id`='$id'";
      $conn->query($sql);
        }
    
}
    }
    
    if (isset($_POST["bloodPress"])){
      $bp = explode("/",$_POST["bloodPress"]);

    }
    
    if (isset($_POST["btemp"])) {
        if (isset($_POST["apt_id"])) {
    $sql = "INSERT INTO patients_vits 
            (date, apt_id, created_by, body_temp, pulse_rate, respiration_rate, systolic_bp, dystolic_bp, oxygen_sat, weight) 
            VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isddddddd", 
        $_POST["apt_id"],           // i = integer
        $_SESSION["user"][0],       // s = string (if numeric user_id, use "i" instead of "s")
        $_POST["btemp"],            // d = double/float
        $_POST["pulRate"],          // d
        $_POST["respRate"],         // d
        $bp[0],                     // d (systolic)
        $bp[1],                     // d (diastolic)
        $_POST["oxysat"],           // d
        $_POST["weight"]            // d
    );

    $stmt->execute();
    $stmt->close();
}

    }

    $sql ="SELECT id, concat(patient.FName,' ', patient.LName)'Patient Name' from appointments
    INNER JOIN patient ON appointments.patient_id = patient.pat_id
    WHERE appointments.check_in is not null and appointments.check_out is null";
    $result = $conn->query($sql);
    $patients = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[$row["id"]] = $row["Patient Name"];
        }
    };?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                  <h4 class="card-title">Patient Vitals</h4>
                <form class = "form-sample" action="vitals.php" method="post">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="apt_id">Patients Name:</label>
                        <div class="col-sm-9">
                          <select class="js-example-basic-single" style="width:20%" name="apt_id" id="apt_id" required>
                            <option value="" disabled <?php if(!isset($_POST["id"])) echo "selected" ; ?>>Select a patient...</option>
                            <?php foreach ($patients as $pid => $name): ?>
                                <option value=<?php echo "'$pid' "; 
                                if($pid == $id){
                                  echo "selected";
                              }?>><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                      <label for="btemp" class="col-sm-3 col-form-label">Body Temperature:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="btemp" name="btemp" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="pulRate" class="col-sm-3 col-form-label">Pulse Rate:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="pulRate" name="pulRate" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="respRate" class="col-sm-3 col-form-label">Respiration Rate:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="respRate" name="respRate" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="bloodPress" class="col-sm-3 col-form-label">Blood Pressure</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="bloodPress" name="bloodPress" pattern="^[0-9]+/[0-9]+$"required >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="oxysat" class="col-sm-3 col-form-label">Oxygen Saturation</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="oxysat" name="oxysat" required >
                      </div>
                      
                    </div>
                    <div class="form-group row">
                      <label for="weight" class="col-sm-3 col-form-label" >Weight</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="weight" name="weight" required >
                      </div>
                    
                    </div>
                      <input type="submit" value="Submit">
                    </form>             
                  </div>
                </div>
              </div>
            </div>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                  <h4 class="card-title">Today's Vitals</h4>
                  <?php 
                               if (isset($_POST["btemp"])) {
    $sql = "INSERT INTO patients_vits 
            (date, apt_id, created_by, body_temp, pulse_rate, respiration_rate, systolic_bp, dystolic_bp, oxygen_sat, weight) 
            VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isddddddd", 
        $_POST["apt_id"],            // i = integer
        $_SESSION["user"][0],        // s = string (if it's numeric user_id, switch to i)
        $_POST["btemp"],             // d = double/float
        $_POST["pulRate"],           // d
        $_POST["respRate"],          // d
        $bp[0],                      // d (systolic)
        $bp[1],                      // d (diastolic)
        $_POST["oxysat"],            // d
        $_POST["weight"]             // d
    );
    
    $stmt->execute();
    $stmt->close();
}
 
                                ?>
                                <div class='table-responsive'>
                                    <table id="editable-table" class ='table'>
                                    <thead>
                                        <tr>
                                            <th>Date</th><th>Patient Name</th><th>Body Temperature</th><th>Pulse Rate</th><th>Respiration Rate</th><th>Blood Pressure</th><th>Oxygen Saturation</th><th>Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($result->num_rows > 0) {
                                              while($row = $result->fetch_assoc()) {
                                                  echo "<tr data-id = '$row[p_vit_id]'><td>".$row["date"]."</td><td>".$row["Patient Name"]."</td><td>".$row["body_temp"]."</td><td>".$row["pulse_rate"]."</td><td>".$row["respiration_rate"]."</td><td>".$row["systolic_bp"]."/".$row["dystolic_bp"]."</td><td>".$row["oxygen_sat"]."</td><td>".$row["weight"]."</td></tr>";
                                              }
                                            }
                                        ?>
                                    </tbody>
                                    </table>
                                </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
        
          <!-- partial -->
        </div>
         <script src="../../assets/vendors/select2/select2.min.js"></script>
        <script src="../../assets/js/select2.js"></script>
        <script>
  const table = document.getElementById("editable-table");
  const changes = new Set();
  // Make cell editable on click
  table.addEventListener("click", function (e) {
    const target = e.target;
   
    console.log("Parent row:", target.parentElement.rowIndex - 1);
    console.log("Row dataset:", target.parentElement.dataset);
    if (target.tagName === "TD" && !target.querySelector("input")) {
      const colIndex = target.cellIndex;

      if (colIndex < 2) return;
      const originalValue = target.textContent;
      const input = document.createElement("input");
      input.type = "text";
      input.value = originalValue;
      target.textContent = '';
      target.appendChild(input);
      input.focus();

      input.addEventListener("blur", () => {
        const newValue = input.value.trim();
        const row = target.parentElement; // Adjust for header
        const rowId = row.dataset.id;
        const col = target.cellIndex;

        target.textContent = newValue;
         console.log(newValue != originalValue);
        if (newValue != originalValue) {
          // Send POST request with change
          const params = new URLSearchParams({id:rowId,column:col,value: newValue}).toString();
          window.location.href = `${window.location.pathname}?${params}`;
        } else {
          target.textContent = originalValue;
        }
      });


      input.addEventListener("keydown", (e) => {
        if (e.key === "Enter") input.blur();
        if (e.key === "Escape") {
          target.textContent = originalValue;
        }
      });
    }
  });

 
</script>
   
