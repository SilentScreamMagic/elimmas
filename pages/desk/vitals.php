<?php
    include "../conn.php";
    include "../nav.php";
    include "../table.html";
    if (isset($_POST["apt_id"])) {
        $sql = "INSERT INTO `patients_vits` (`date`, `apt_id`, `vit_id`, `measure`) VALUES 
        (now(), $_POST[apt_id], 1, $_POST[btemp]), 
        (now(), $_POST[apt_id], 2, $_POST[pulRate]),
        (now(), $_POST[apt_id], 3, $_POST[respRate]), 
        (now(), $_POST[apt_id], 4, $_POST[bloodPress])";
        $result = $conn->query($sql);
    }

    $sql ="SELECT id, concat(patient.FName,' ', patient.LName)'Patient Name' from appointments
    INNER JOIN patients_beds on patients_beds.apt_id = appointments.id
    INNER JOIN patient ON appointments.patient_id = patient.pat_id
    WHERE appointments.check_in is not null and appointments.check_out is null and appointments.type = 'Consultation';";
    $result = $conn->query($sql);
    $patients = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patients[$row["id"]] = $row["Patient Name"];
        }
    }
?>
<html>
    <head>
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
        <div class="form-container">
            <form action="vitals.php" method="post">
                <div class="form-group">
                    <label for="apt_id">Patients Name:</label>
                    <select name="apt_id" id="apt_id">
                        <option value="">Select a patient...</option>
                        <?php foreach ($patients as $pid => $name): ?>
                            <option value="<?php echo $pid; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="btemp">Body Temperature:</label>
                    <input type="text" id="btemp" name="btemp" required>
                </div>
                <div class="form-group">
                    <label for="pulRate">Pulse Rate:</label>
                    <input type="text" id="pulRate" name="pulRate" required>
                </div>
                <div class="form-group">
                    <label for="respRate">Respiration Rate:</label>
                    <input type="text" id="respRate" name="respRate" required>
                </div>
                <div class="form-group">
                    <label for="bloodPress">Blood Pressure</label>
                    <input type="text" id="bloodPress" name="bloodPress" required >
                </div>
                <button class="form-button" type="submit" value="Submit">Submit</button>
            </form>
        </div>
    </body>
</html>