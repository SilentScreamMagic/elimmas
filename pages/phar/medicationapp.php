<?php
    
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
  
    <?php  
    include "../conn.php";
    
    include '../nav.php';
   
    //include "../nav.php";
    //include "../table.html";
    
    if(isset($_POST["id"])){
        $_SESSION["id"] = $_POST["id"];
        $sql ='SELECT patient.pat_id,concat(patient.FName," ",patient.LName) "Patient Name"FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
        where id = '.$_SESSION["id"];
        $result = $conn->query($sql)->fetch_assoc();
        $_SESSION["pname"] = $result["Patient Name"];
        
    }
    if(isset($_POST["med_id"])){
        $sql = "insert into medstock(med_id, quantity,apt_id,t_date) 
        values(".$_POST["med_id"].",-".$_POST["med_count"].",".$_POST["apt_id"].",now())";

        $result = $conn->query($sql);
    }?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'><?php echo $_SESSION["pname"]?></h4>
                    <div class='table-responsive'>
                    <?php 
                                $sql = "SELECT *
                        FROM (
                            SELECT pm.med_id, pm.apt_id,pm.date,m.med_name,pm.per_dose,pm.per_day,
                                SUM(pm.num_days) AS 'num_days',
                                SUM(pm.num_months) AS 'num_months',
                                SUM(meds_requested.requested) AS 'Meds Requested',
                                -1 * COALESCE(meds_provided.provided, 0) AS 'Meds Provided',
                                (SUM(meds_requested.requested) + COALESCE(meds_provided.provided, 0)) AS 'Difference' 
                            FROM  
                                patients_meds pm
                            JOIN 
                                medication m ON m.med_id = pm.med_id 
                            JOIN 
                                appointments a ON a.id = pm.apt_id
                            JOIN 
                                patient p ON p.pat_id = a.patient_id
                            LEFT JOIN 
                                (SELECT med_id, apt_id, per_dose * per_day * num_days AS requested FROM patients_meds 
                                GROUP BY med_id, apt_id) AS meds_requested 
                                ON pm.med_id = meds_requested.med_id AND pm.apt_id = meds_requested.apt_id
                            LEFT JOIN 
                                (SELECT med_id, apt_id, SUM(quantity) AS provided FROM medstock 
                                GROUP BY med_id, apt_id ) AS meds_provided 
                                ON pm.med_id = meds_provided.med_id AND pm.apt_id = meds_provided.apt_id
                            WHERE 
                                pm.time_ad IS NULL AND pm.apt_id = $_SESSION[id]
                            GROUP BY 
                                med_id, apt_id
                        ) AS subquery
                        WHERE 
                            Difference != 0
                        ORDER BY 
                            date;";
                                $result = $conn->query($sql);
                                ?>
                        <table class ='table'>
                        <thead>
                            <tr>
                            <th>Date</th><th>Medication</th><th>Per Dose</th><th>Per Day</th><th>Number of Days</th><th>Quantity</th><th>Refill for(Months)</th><th>Meds Requested</th><th>Meds Provided</th><th>Remainder</th><th>Dispense</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["date"]."</td><td>".$row["med_name"]."</td><td>".$row["per_dose"]."</td><td>".$row["per_day"]."</td><td>".$row["num_days"]."</td><td>".$row["per_dose"]*$row["per_day"]*$row["num_days"]."</td><td>".$row["num_months"]."</td><td>".$row["Meds Requested"]."</td><td>".$row["Meds Provided"]."</td><td>".$row["Difference"]."</td><td>
        <form action='' method='post'>
            
            <input type='hidden' name='med_id' value=".$row['med_id'].">
            <input type='hidden' name='apt_id' value=".$row['apt_id'].">
            <label for='med_count'>Quantity Provided: </label><br>
            <input type='integer' id ='med_count' name='med_count'>
            <input type='submit' value='Dispense'>
        </form>
       </td>
        </tr>";
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

