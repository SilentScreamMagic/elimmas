<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";

$sql = "SELECT * FROM medication order by med_id";
    $result = $conn->query($sql);
    $meds = [];
    $m_price = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $meds[$row["med_id"]] = $row["med_name"];
           $m_price[$row["med_id"]] = $row["price"];
        }
    }
    
    ?>
    <!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/css/style.css'>
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
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
                    <h4 class='card-title'>Medications</h4>
                        <form action= "" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="med">Medication:</label>
                            <div class="col-sm-9">
                                <datalist class="js-example-basic-single" style="width:80%" name="med" id="med">
                                    <option value="" disabled selected>Select a Medication...</option>
                                    <?php 
                                        foreach ($meds as $mid => $det): ?>
                                            <option value="<?php echo $mid; ?>"><?php echo $det; ?></option>
                                        <?php 
                                        endforeach;?>
                                  </datalist>
                                </div>
                            </div>  
                             <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group row">
                                  <label class="col-sm-3 col-form-label" for="med_count">Per Dose:</label>
                                      <div class="col-sm-9">
                                      <input type="number" name="m_price" id = "m_price" class="form-control" required>
                                      </div>
                                  </div>
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
<html>
    <body>
        
        
        
    </body>
    
</div>
<script src="../../assets/vendors/select2/select2.min.js"></script>
<script src="../../assets/js/select2.js"></script>
 <!--<script>
      const m_price = <?php echo json_encode($m_price); ?>;
      var price = document.getElementById("m_price");
      var med = document.getElementById("med");
      price.value =  m_price[med.value];
    </script> -->