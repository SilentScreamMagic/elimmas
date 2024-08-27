<?php
include "../conn.php";
require_once '../../packages/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$apt_id = $_POST['id'];

$sql ="SELECT concat(patient.FName,' ',patient.LName) 'Patient Name', check_in, check_out,dis_notes  FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = $apt_id";

    $result = $conn->query($sql)->fetch_assoc();

$patient_name = $result["Patient Name"];
$admission_date = $result["check_in"];
$discharge_date = $result["check_out"];

$sql_proc = "SELECT patients_proc.date,procedures.Prod_Name,COUNT(procedures.prod_id) 'Count' ,procedures.price,procedures.Price*COUNT(procedures.prod_id) 'Cost'  FROM procedures 
    JOIN patients_proc on patients_proc.proc_id = procedures.prod_id
    where patients_proc.apt_id =$apt_id
    GROUP by procedures.prod_id
    HAVING COUNT(patients_proc.proc_id) > 0
    order by date;";
$result_proc = $conn->query($sql_proc);
$procedures_done=[];
if ($result_proc->num_rows > 0) {
    while ($row = $result_proc->fetch_assoc()) {
        $procedures_done[] = ["date" => $row["date"], "procedure" => $row["Prod_Name"]." (".$row["Count"].")"];
    }
}

$doctor_notes = $result["dis_notes"];

$sql_meds = "SELECT patients_meds.date,medication.med_name,per_dose,per_day,sum(num_days),num_months,medication.price*sum(per_dose*per_day*num_days) 'Cost' FROM `patients_meds` 
    join medication on medication.med_id = patients_meds.med_id where apt_id = $apt_id 
    GROUP by patients_meds.med_id
    order by date;";
$result_meds = $conn->query($sql_meds);
$medications_prescribed =[];
if ($result_meds->num_rows > 0) {
    while ($row = $result_meds->fetch_assoc()) {
        $medications_prescribed[] =["name" => $row["med_name"], "per_dose" => $row["per_dose"], "per_day" => $row["per_day"]." time(s) daily", "num_days" => $row["per_dose"]." Day(s)", "num_months" => $row["num_months"]];
    }
}

$sql_labs = "SELECT date,labs.lab_name,count(patients_labs.lab_id) 'Count',labs.price,labs.price*count(patients_labs.lab_id) 'Cost' FROM `patients_labs` 
    join labs on labs.lab_id = patients_labs.lab_id where apt_id =$apt_id 
    GROUP by patients_labs.lab_id
    HAVING COUNT(patients_labs.lab_id) > 0
    order by date;";
$result_labs = $conn->query($sql_labs);
$labs_done =[];
if ($result_labs->num_rows > 0) {
    while ($row = $result_labs->fetch_assoc()) {
        $labs_done[] =["name" => $row["lab_name"],"count" => $row["Count"]];
    }
}
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .discharge-note {
            border: 2px solid #4CAF50;
            padding: 20px;
            background-color: white;
        }
        .header {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            background-color: #e9f5e9;
            padding: 10px;
            border: 1px solid #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #4CAF50;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="discharge-note">
    <div class="header">
        <h1>Discharge Note</h1>
    </div>
    <div class="section">
        <h2>Patient Information</h2>
        <p><strong>Patient Name:</strong> ' . $patient_name . '</p>
        <p><strong>Admission Date:</strong> ' . $admission_date . '</p>
        <p><strong>Discharge Date:</strong> ' . $discharge_date . '</p>
    </div>
    <div class="section">
        <h2>Procedures Done</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Procedure</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($procedures_done as $procedure) {
                $html.= '<tr>
                    <td>' . $procedure["date"] . '</td>
                    <td>' . $procedure["procedure"] . '</td>
                </tr>';
            }
            $html.= '</tbody>
        </table>
    </div>
    <div class="section">
        <h2>Doctor\'s Discharge Notes</h2>
        <p>' . $doctor_notes . '</p>
    </div>
    <div class="section">
        <h2>Medications Prescribed</h2>
        <table>
            <thead>
                <tr>
                    <th>Medication Name</th>
                    <th>Per Dose</th>
                    <th>Per Day</th>
                    <th>Number of Days</th>
                    <th>Number of Months of Refills</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($medications_prescribed as $medication) {
                $html.= '<tr>
                    <td>' . $medication["name"] . '</td>
                    <td>' . $medication["per_dose"] . '</td>
                    <td>' . $medication["per_day"] . '</td>
                    <td>' . $medication["num_days"] . '</td>
                    <td>' . $medication["num_months"] . '</td>
                </tr>';
            }
            $html.= '</tbody>
        </table>
    </div>
     <div class="section">
        <h2>Labs Done</h2>
        <table>
            <thead>
                <tr>
                    <th>Labs</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($labs_done as $lab) {
                $html.= '<tr>
                    <td>' . $lab["name"] . '</td>
                    <td>' . $lab["count"] . '</td>
                </tr>';
            }
            $html.= '</tbody>
        </table>
    </div>
</div>

</body>
</html>
';

$conn->close();
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
// Print the HTML content


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

$pdf = $dompdf->output();

$fname = "../../files/$patient_name discharge notes.pdf";
file_put_contents($fname, $pdf);

header("Location: $fname");
?>
