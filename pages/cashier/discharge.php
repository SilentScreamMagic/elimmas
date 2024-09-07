<?php
include "../conn.php";
require_once '../../packages/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Fetching the data from the database
$apt_id = $_POST['id'];



// Fetch Ward Accommodation
$sql ="SELECT concat(patient.FName,' ',patient.LName) 'Patient Name' FROM `appointments` inner join patient on patient.pat_id = appointments.patient_id
    where id = $apt_id";

    $result = $conn->query($sql)->fetch_assoc();
    $pname = $result["Patient Name"];

$sql_wards = "SELECT patients_beds.start_date,patients_beds.end_date,rooms.price 'Unit Price',COUNT(rooms.room_id) 'num_beds',
    rooms.room_id,datediff(patients_beds.end_date,patients_beds.start_date) 'Duration', 
    rooms.price*COUNT(rooms.room_id)*datediff(patients_beds.end_date,patients_beds.start_date) 'Cost' FROM `patients_beds` 
    JOIN beds on beds.bed_id = patients_beds.bed_id 
    join rooms on rooms.room_id = beds.room_id where deleted = 0 and apt_id = $apt_id 
    GROUP by rooms.room_id
    HAVING COUNT(patients_beds.bed_id) > 0
    order by start_date;";
$result_wards = $conn->query($sql_wards);

// Fetch Labs
$sql_labs = "SELECT date,labs.lab_name,count(patients_labs.lab_id) 'Count',labs.price,labs.price*count(patients_labs.lab_id) 'Cost' FROM `patients_labs` 
    join labs on labs.lab_id = patients_labs.lab_id where deleted = 0 and apt_id =$apt_id 
    GROUP by patients_labs.lab_id
    HAVING COUNT(patients_labs.lab_id) > 0
    order by date;";
$result_labs = $conn->query($sql_labs);

// Fetch Medications
$sql_meds = "SELECT patients_meds.date,medication.med_name,medication.price,sum(per_dose*per_day*num_days) 'Count',medication.price*sum(per_dose*per_day*num_days) 'Cost' FROM `patients_meds` 
    join medication on medication.med_id = patients_meds.med_id where deleted = 0 and apt_id = $apt_id 
    GROUP by patients_meds.med_id
    order by date;";
$result_meds = $conn->query($sql_meds);

// Fetch Meals
$sql_meals = "SELECT date, meals.meal_name, COUNT(patients_meals.meal_id) AS 'Count', meals.price, (meals.price * COUNT(patients_meals.meal_id)) AS 'Cost' FROM patients_meals
    JOIN meals ON meals.meal_id = patients_meals.meal_id
    WHERE deleted = 0 and apt_id = $apt_id
    GROUP BY meals.meal_id
    HAVING COUNT(patients_meals.meal_id) > 0
    ORDER BY date;";
$result_meals = $conn->query($sql_meals);

// Fetch Theatre Procedures
$sql_proc = "SELECT patients_proc.date,procedures.Prod_Name,COUNT(procedures.prod_id) 'Count' ,procedures.price,procedures.Price*COUNT(procedures.prod_id) 'Cost'  FROM procedures 
    JOIN patients_proc on patients_proc.proc_id = procedures.prod_id
    where deleted = 0 and patients_proc.apt_id =$apt_id
    GROUP by procedures.prod_id
    HAVING COUNT(patients_proc.proc_id) > 0
    order by date;";
$result_proc = $conn->query($sql_proc);

// Fetch Consumables
$sql_con = "SELECT date,consumables.con_name,consumables.price,sum(patients_cons.count)'Count',price*sum(patients_cons.count) 'Cost' FROM `patients_cons` 
    join consumables on consumables.con_id = patients_cons.con_id where deleted = 0 and apt_id = $apt_id
    GROUP by patients_cons.con_id
    HAVING COUNT(patients_cons.con_id) > 0
    order by date;";
$result_con = $conn->query($sql_con);
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
// Initialize the HTML variable
$html = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Hospital Bill</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .bill-section { margin-bottom: 20px; }
        .bill-section h2 { background-color: #f2f2f2; padding: 10px; border: 1px solid #ddd; }
        .bill-summary { border-top: 2px solid #000; margin-top: 20px; padding-top: 10px; }
        .bill-summary h2 { background-color: #4CAF50; color: white; padding: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #4CAF50; color: white; }
        .summary-table th, .summary-table td { text-align: right; }
    </style>
</head>
<body>
    <h1>$pname's Bill</h1>
    <div class='bill-section' id='ward-accommodation'>
        <h2>Ward Accommodation</h2>
        <table>
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Ward</th>
                    <th>Number Of Beds</th>
                    <th>Stay Duration (days)</th>
                    <th>Unit Price ($)</th>
                    <th>Cost ($)</th>
                </tr>
            </thead>
            <tbody>";
            
$total_ward_cost = 0;
if ($result_wards->num_rows > 0) {
    while ($row = $result_wards->fetch_assoc()) {
        $html .= "<tr><td>" . $row['start_date'] . "</td><td>" . $row['end_date'] . "</td><td> Ward " . $row['room_id'] . "</td><td>" . $row['num_beds'] . "</td><td>" . $row['Duration'] . "</td><td>" . $row['Unit Price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_ward_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_ward_cost</td></tr>";
}

$html .= "</tbody>
        </table>
    </div>
    <div class='bill-section' id='labs'>
        <h2>Labs</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Lab Name</th>
                    <th>Count</th>
                    <th>Unit Price</th>
                    <th>Cost ($)</th>
                </tr>
            </thead>
            <tbody>";

$total_lab_cost = 0;
if ($result_labs->num_rows > 0) {
    while ($row = $result_labs->fetch_assoc()) {
        $html .= "<tr><td>" . $row['date'] . "</td><td>" . $row['lab_name'] . "</td><td>" . $row['Count'] . "</td><td>" . $row['price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_lab_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_ward_cost</td></tr>";
}

$html .= "</tbody>
        </table>
    </div>
    <div class='bill-section' id='medications'>
        <h2>Medications</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Medication Name</th>
                    <th>Quantity</th>
                    <th>Unit Price ($)</th>
                    <th>Total Cost ($)</th>
                </tr>
            </thead>
            <tbody>";

$total_meds_cost = 0;
if ($result_meds->num_rows > 0) {
    while ($row = $result_meds->fetch_assoc()) {
        $html .= "<tr><td>" . $row['date'] . "</td><td>" . $row['med_name'] . "</td><td>" . $row['Count'] . "</td><td>" . $row['price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_meds_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_meds_cost</td></tr>";
}

$html .= "</tbody>
        </table>
    </div>
    <div class='bill-section' id='meals'>
        <h2>Meals</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Meal Type</th>
                    <th>Meal Date</th>
                    <th>Unit Price ($)</th>
                    <th>Cost ($)</th>
                </tr>
            </thead>
            <tbody>";

$total_meal_cost = 0;
if ($result_meals->num_rows > 0) {
    while ($row = $result_meals->fetch_assoc()) {
        $html .= "<tr><td>" . $row['date'] . "</td><td>" . $row['meal_name'] . "</td><td>" . $row['Count'] . "</td><td>" . $row['price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_meal_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_meal_cost</td></tr>";
}
$html .= "</tbody>
        </table>
    </div>
    <div class='bill-section' id='theatre-procedures'>
        <h2>Theatre Procedures</h2>
        <table>
            <thead>
                <tr>
                    <th>Procedure Date</th>
                    <th>Procedure Name</th>
                    <th>Count</th>
                    <th>Unit Price ($)</th>
                    <th>Cost ($)</th>
                </tr>
            </thead>
            <tbody>";

$total_proc_cost = 0;
if ($result_proc->num_rows > 0) {
    while ($row = $result_proc->fetch_assoc()) {
        $html .= "<tr><td>" . $row['date'] . "</td><td>" . $row['Prod_Name'] . "</td><td>" . $row['Count'] . "</td><td>" . $row['price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_proc_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_proc_cost</td></tr>";
}

$html .= "</tbody>
        </table>
    </div>
    <div class='bill-section' id='consumables'>
        <h2>Consumables</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Consumable</th>
                    <th>Count</th>
                    <th>Unit Price ($)</th>
                    <th>Cost ($)</th>
                </tr>
            </thead>
            <tbody>";

$total_con_cost = 0;
if ($result_con->num_rows > 0) {
    while ($row = $result_con->fetch_assoc()) {
        $html .= "<tr><td>" . $row['date'] . "</td><td>" . $row['con_name'] . "</td><td>" . $row['Count'] . "</td><td>" . $row['price'] . "</td><td>" . $row['Cost'] . "</td></tr>";
        $total_con_cost += $row['Cost'];
    }
    $html.="<tr><td></td><td></td><td></td><td><strong>Total</strong></td><td>$total_con_cost</td></tr>";
}

$html .= "</tbody>
        </table>
    </div>
    <div class='bill-summary'>
        <h2>Summary</h2>
        <table class='summary-table'>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ward Accommodation</td>
                    <td>" . $total_ward_cost . "</td>
                </tr>
                <tr>
                    <td>Labs</td>
                    <td>" . $total_lab_cost . "</td>
                </tr>
                <tr>
                    <td>Medications</td>
                    <td>" . $total_meds_cost . "</td>
                </tr>
                <tr>
                    <td>Meals</td>
                    <td>" . $total_meal_cost . "</td>
                </tr>
                <tr>
                    <td>Theatre Procedures</td>
                    <td>" . $total_proc_cost . "</td>
                </tr>
                <tr>
                    <td>Consumables</td>
                    <td>" . $total_con_cost . "</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td>" . ($total_ward_cost + $total_lab_cost + $total_meds_cost + $total_meal_cost + $total_proc_cost + $total_con_cost) . "</td>
                </tr>
            </tbody>
        </table>
        <form action=''>
    </div>
</body>
</html>";

// Close the database connection
$conn->close();

// Print the HTML content


$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

$pdf = $dompdf->output();

$fname = "../../files/$pname bill.pdf";
file_put_contents($fname, $pdf);

header("Location: $fname");
// Output the generated PDF to Browser
//$dompdf->stream("hospital_bill.pdf", ["Attachment" => 0]);

