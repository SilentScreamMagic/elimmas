<?php 
include "../conn.php";

if(isset($_GET['id'])){
  $sql = "SELECT CONCAT(`FName`,' ' ,`LName`) mother_name, `address` mother_address,baby_head_ticket.* FROM `patient` 
  INNER JOIN appointments on patient.pat_id = appointments.patient_id 
  INNER JOIN baby_head_ticket on baby_head_ticket.apt_id = appointments.id 
  WHERE baby_head_ticket.id= $_GET[id];";
  $results = $conn->query($sql);
  $result = $results->fetch_assoc();
  $jsonData =json_encode($result);
}
if(isset($_GET['apt_id'])){
  $apt_id = $_GET['apt_id'];
  $sql = "SELECT CONCAT(`FName`,' ' ,`LName`) mother_name,id `apt_id`,pat_id, `address` mother_address FROM `patient` 
  INNER JOIN appointments on patient.pat_id = appointments.patient_id 
  WHERE appointments.id= $_GET[apt_id];";
  $results = $conn->query($sql);
  $result = $results->fetch_assoc();
  $jsonData =json_encode($result);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Baby Head Ticket</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8fafc;
      margin: 30px;
    }
    h2 {
      text-align: center;
      background: #005a8d;
      color: white;
      padding: 10px;
      border-radius: 8px;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    fieldset {
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      padding: 15px;
    }
    legend {
      font-weight: bold;
      color: #005a8d;
    }
    label {
      display: block;
      margin-top: 8px;
    }
    input, textarea, select {
      width: 90%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      margin-top: 4px;
    }
    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px;
      text-align: center;
    }
    th {
      background: #eef3f7;
    }
    .submit-btn {
      background: #005a8d;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .submit-btn:hover {
      background: #00406b;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
const apgarFields = document.querySelectorAll('input[name^="apgar"]');

apgarFields.forEach(input => input.addEventListener('input', updateTotals));

function updateTotals() {
  const mins = [1, 5];
  
  mins.forEach(min => {
    let total = 0;
    document.querySelectorAll(`input[name^="apgar${min}_"]`).forEach(i => {
      total += parseInt(i.value) || 0;
    });
    document.getElementById(`apgar${min}_total`).textContent = total;
  });
}
const targetForm = document.getElementById('myForm');
    const fieldsets = targetForm.querySelectorAll('fieldset');

    // Disable each fieldset
    //fieldsets.forEach(fieldset => {
      //  fieldset.disabled = ;
    //});

  
  const formData = <?php echo $jsonData ?: '{}'; ?>;
    
    // 2. Function to populate the form
    function populateForm(data) {
        Object.keys(data).forEach(key => {
            // Find the input, select, or textarea with the matching name
            let field = document.querySelector(`[name="${key}"]`);
            
            if (field) {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = (field.value == data[key]);
                } else {
                    field.value = data[key];
                }
                field.disabled=1;
            }
        });
        
        // If you have a total APGAR calculation function, call it here
        updateTotals(); 
    }

    // 3. Run it when the page loads
    window.onload = () => populateForm(formData);
  }
);
    // 1. Get the data from PHP
    
</script>
</head>
<body>

<h2>Baby Head Ticket</h2>

<form id="myForm", action="./process_bh_ticket.php" method="POST">

  <fieldset>
    <legend>Patient Information</legend>
    <div class="grid-2" required>
      <input type="hidden"  required name="apt_id">
      <input type="hidden"  required name="id">
      <input type="hidden"  required name="pat_id">
      <label>Mother's Name: <input type="text" required name="mother_name"  readonly></label>
      <label>Mother's Address: <input type="text" required name="mother_address" readonly></label>
      <label>Father's Name: <input type="text" required name="father_name"></label>
      <label>Father's Address: <input type="text" required name="father_address"></label>
      <label>Mode Of Delivery:
        <select required name="type_labour">
          <option>Assisted</option>
          <option>Spontaneous</option>
          <option>Induced</option>
          <option>Elective CS</option>
          <option>Emergency CS</option>
        </select>
      </label>
      <label>Duration of Labour: <input type="number" required name="duration_labour"></label>
      <label>Labour Complication(s): <textarea required name="complications"></textarea></label>
      <label>Indication(s) if Operative Delivery: <textarea required name="indications"></textarea></label>
      <label>Gestational Age (weeks): <input type="number" required name="gest_age"></label>
    </div>
  </fieldset>

  <fieldset>
    <legend>Baby Details</legend>
    <div class="grid-2" required>
      <label>Date of Delivery: <input type="date" required name="date_delivery"></label>
      <label>Time of Delivery: <input type="time" required name="time_delivery"></label>
      <label>Birth Weight (kg): <input type="number" step="0.01" required name="birth_weight"></label>
      <label>Presentation: <input type="text" required name="presentation"></label>
      <label>Full Length (cm): <input type="number" required name="full_length"></label>
      <label>Chest Length (cm): <input type="number" required name="chest_length"></label>
      <label>Head Circumference (cm): <input type="number" required name="head_circumference"></label>
      <label>Urine Passed: <input type="text" required name="urine_passed"></label>
      <label>Meconium Passed: <input type="text" required name="meconium_passed"></label>
      <label>RBS Checked: <input type="text" required name="rbs_checked"></label>
      <label>Abnormalities / Treatments: <textarea required name="abnormalities"></textarea></label>
      <label>Time of Placenta Delivery: <input type="time" required name="time_placenta"></label>
    </div>
  </fieldset>

  <fieldset>
    <legend>APGAR Score</legend>
    <table>
      <thead>
        <tr>
          <th>Parameter</th>
          <th>1 Min</th>
          <th>5 Min</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Appearance (Colour)</td><td><input type="number" name="apgar1_colour" min="0" max="2" required></td><td><input type="number"  name="apgar5_colour" min="0" max="2" required></td></tr>
        <tr><td>Pulse (Heart Rate)</td><td><input type="number" name="apgar1_pulse" min="0" max="2" required></td><td><input type="number" name="apgar5_pulse" min="0" max="2" required></td></tr>
        <tr><td>Grimace (Reflex)</td><td><input type="number" name="apgar1_reflex" min="0" max="2" required></td><td><input type="number" name="apgar5_reflex" min="0" max="2" required></td></tr>
        <tr><td>Activity (Tone)</td><td><input type="number" name="apgar1_tone" min="0" max="2" required></td><td><input type="number" name="apgar5_tone" min="0" max="2" required></td></tr>
        <tr><td>Respiration (Breathing Rate)</td><td><input type="number" name="apgar1_resp" min="0" max="2" required></td><td><input type="number" name="apgar5_resp" min="0" max="2" required></td></tr>
        <tr><th>Total</th><th id="apgar1_total">0</th><th id="apgar5_total">0</th></tr>
      </tbody>
    </table>
  </fieldset>

  <?= isset($_GET['apt_id'])? "<button type='submit' name='save' class='submit-btn'>Save Record</button>" : '';?>

</form>

<script>
// Automatically sum APGAR scores
</script>

  
</body>
</html>
