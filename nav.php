<?php
  session_start();
  $nav=[];
  if(isset($_SESSION["user"])){

    if ($_SESSION["user"][1]=="Doctor") {
    $nav =[["../doc/docapps.php","Appointments"],
          ["../doc/docpatients.php","Patients"]];
    $files = scandir("../doc");
    $files = array_diff($files, array('.', '..'));
    if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
    }
  }
  if ($_SESSION["user"][1]=="Nurse") {
    $nav =[["../nurse/viewpatients.php","Dashboard"],
    ["../nurse/rooms.php","Rooms"],
  ["../nurse/tasks.php","Tasks"],
  ["../nurse/medstock.php","Medications Stock"]];
  $files = scandir("../nurse");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Pharmacist") {
    $nav =[["../phar/dashboard.php","Dashboard"],
    ["../phar/pharmacy.php","Inventory"],
    ["../phar/medtransaction.php","Transaction History"],
    ["../phar/indispense.php","Dispense Inhouse"]];
    $files = scandir("../phar");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Lab Tech") {
    $nav =[["../lab/labs.php","Labs Requests"]];
  $files = scandir("../lab");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Front Desk") {
    $nav =[["../desk/appointments.php","Appointments"],
  ["../desk/viewpatients.php","Patients"]];
  $files = scandir("../desk");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  if ($_SESSION["user"][1]=="Cashier") {
    $nav =[["../cashier/billpatients.php","Patients"]];
  $files = scandir("../cashier");
    $files = array_diff($files, array('.', '..'));
      if(!in_array(basename($_SERVER['PHP_SELF']),$files)){
        header("Location: ".$nav[0][0]);
      }
  }
  }else{
    header("Location: ../index.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elimmas Navigation</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .sidebar {
      height: 100%;
      width: 200px;
      position: fixed;
      top: 0;
      left: -200px; /* Initially hidden */
      background-color: #4CAF50; /* Green background */
      overflow-x: hidden;
      transition: 0.5s;
      padding-top: 60px;
    }
    .sidebar a {
      padding: 10px 15px;
      text-decoration: none;
      font-size: 20px;
      color: white;
      display: block;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background-color: #45a049; /* Darker green on hover */
    }
    .content {
      margin-left: 0;
      padding: 16px;
    }
    .logo {
      padding: 10px 15px;
      text-decoration: none;
      font-size: 24px;
      color: green;
      display: block;
      text-align: center;
    }
    .sidebar .closebtn {
      position: absolute;
      top: 0;
      right: 10px;
      font-size: 36px;
      margin-left: 50px;
      z-index: 1;
    }
    .openbtn {
      position: fixed;
      top: 5px;
      left: 20px;
      font-size: 30px;
      cursor: pointer;
    }
    @media screen and (max-height: 450px) {
      .sidebar {padding-top: 15px;}
      .sidebar a {font-size: 18px;}
    }
    .header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            padding: 10px 20px;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
        }
        .sign-out-button {
            position: absolute;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .sign-out-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Elimmas</h1>
    <a href="../signout.php" class="sign-out-button"><?php echo "Sign Out: ".$_SESSION['user'][0];?></a>
</div>
<div class="sidebar" id="mySidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php  
    for ($i=0; $i < count($nav); $i++) { 
      echo "<a href='".$nav[$i][0]."'>".$nav[$i][1]."</a>"; 
    }
  ?>
</div>



<button class="openbtn" id="openButton" onclick="openNav()">&#9776;</button>

<script>
  function openNav() {
    document.getElementById("mySidebar").style.left = "0";
    document.getElementById("openButton").style.visibility = "hidden";
  }

  function closeNav() {
    document.getElementById("mySidebar").style.left = "-200px";
    document.getElementById("openButton").style.visibility = "visible";
  }
  let inactivityTime = function () {
      let time;
      window.onload = resetTimer;
      window.onmousemove = resetTimer;
      window.onmousedown = resetTimer;  // catches touchscreen presses
      window.ontouchstart = resetTimer; // catches touchscreen swipes
      window.onclick = resetTimer;      // catches touchpad clicks
      window.onkeypress = resetTimer;   // catches keyboard activity
      window.addEventListener('scroll', resetTimer, true); // improved; see comments

      function logout() {
          // Redirect to logout URL or call a PHP script to destroy the session
          window.location.href = '../signout.php';
      }

      function resetTimer() {
          clearTimeout(time);
          time = setTimeout(logout, 1800000); // 30 minutes
      }
  };

  inactivityTime();
</script>

</body>
</html>
