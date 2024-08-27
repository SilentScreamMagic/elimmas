<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
include "../searchbar2.php";
if(isset($_POST["med_id"])){
    $sql = "insert into medstock(med_id, quantity,t_date) 
    values(".$_POST["med_id"].",".$_POST["med_count"].",now())";
    $result = $conn->query($sql);
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
                    <h4 class='card-title'>Current Patients</h4>
                    <input type='text' id='tableFilterInput' class='form-control dropdown-input' placeholder='Search Medication'>
                    <?php
$sql = "SELECT medication.med_id, med_name, COALESCE(SUM(medstock.quantity), 0) AS 'Stock'
FROM medication
LEFT JOIN medstock ON medstock.med_id = medication.med_id
GROUP BY med_id;";
$result = $conn->query($sql);
?>
                    <div class='table-responsive'>
                    
                        <table id='filterTable' class ='table'>
                        <thead>
                            <tr>
                            <th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        if ($result){ 
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td><td>".$row["Stock"]."</td>
        <td> 
        <form action='' method='post'>
            <input type='hidden' name='med_id' value=".$row['med_id'].">
            <input type='integer' name='med_count'>
            <input type='submit' value='Top Up'>
        </form>
       </td>
        </tr>";
        }
       
    } 
}
    $conn->close();
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
          <footer class='footer'>
            <div class='d-sm-flex justify-content-center justify-content-sm-between'>
              <span class='text-muted d-block text-center text-sm-left d-sm-inline-block'>Copyright © bootstrapdash.com 2020</span>
              <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'> Free <a href='https://www.bootstrapdash.com/bootstrap-admin-template/' target='_blank'>Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>

<?php
echo "";
echo "<table id='filterTable'><tr><th>ID Number</th><th>Medication</th><th>Stock Quantity</th><th></th></tr>";

