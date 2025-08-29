<?php
include "../conn.php";
//include "../nav.php";
//include "../table.html";

    ?>
    <!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' href='../../assets/vendors/mdi/css/materialdesignicons.min.css'>
    <link rel='stylesheet' href='../../assets/css/style.css'>
    
    <link rel='stylesheet' href='../../assets/vendors/select2/select2.min.css'>
    <link rel='stylesheet' href='../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css'>
    
    <link rel='stylesheet' href='../../assets/vendors/css/vendor.bundle.base.css'>
    <link rel='shortcut icon' href='../../assets/images/favicon.png' />
   
  </head>
  <body>
  <div class='container-scroller'>
    <?php 
      include '../nav.php';
    ?>
  <div class='main-panel'>
        <div class='content-wrapper'>
            <div class='row '>
              <div class='col-12 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Current Patients</h4>
                    <h4 class='card-title'>Medications</h4>
                        <form action= "managestock.php" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="med_name">Medication</label>
                                <div class="col-sm-9">
                                    <input type="text" name="med_name" id = "med_name" class="form-control" required>
                                </div>                            
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">Price</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="price" id = "price" class="form-control" required>
                                    </div>
                                </div>
                        <input type="submit" value="Submit"><br><br> 
                  </form>
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