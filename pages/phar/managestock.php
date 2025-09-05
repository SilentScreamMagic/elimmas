<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";
include "../searchbar2.php";



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
  
    <?php include '../nav.php';
    if(isset($_POST["med_name"])){
      $sql = "INSERT INTO `medication` ( `med_name`, `price`) 
      VALUES ('".$_POST["med_name"]."', ".$_POST["price"].")";
      $conn->query($sql);
    }
    if(isset($_POST["price"])){
      $sql = "UPDATE `medication` SET `price`= ".$_POST["price"]." WHERE `med_id`=".$_POST["med_id"].";";
      $conn->query($sql);
    }
    if(isset($_POST["stock"])){
      $sql = "UPDATE `medication` SET `in_stock`= ".$_POST["stock"]." WHERE `med_id`=".$_POST["med_id"].";";
      $conn->query($sql);
    }
      $sql = "SELECT medication.med_id,med_name , medication.price AS 'Price',in_stock	 
FROM medication
GROUP BY med_id;";
$result = $conn->query($sql);
?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Medication Prices</h4>
                    <div class='table-responsive'>
                    <input type='text' id='tableFilterInput' class=' form-control dropdown-input' placeholder='Search Medications...'>
                    <a href="editmed.php"><button>New Medication</button></a>
                        <table id='filterTable' class ='table'>
                        <thead>
                            <tr>
                                <th>ID Number</th><th>Medication</th><th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result){ 
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>".$row["med_id"]."</td><td>".$row["med_name"]."</td>
                                <td> 
                                <form action='' method='post'>
                                    <input type='hidden' name='med_id' value=".$row['med_id'].">
                                    
                                    <input type='integer' name='price' value=".$row["Price"].">
                                    <input type='submit' value='Change Price'>
                                    
                                </form>
                                </td>
                                 <td>
                                <form action='' method='post'>
                                    <input type='hidden' name='med_id' value=".$row['med_id'].">
                                    <input type='radio' name='stock' value= 0 ". (!$row['in_stock'] ? 'checked': "").">
                                    <input type='radio' name='stock' value= 1 ". ($row['in_stock'] ? "checked" : "")." >
                                    <input type='submit' value='Change Status'>
                                    
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

