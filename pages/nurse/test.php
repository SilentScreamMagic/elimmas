<?php
// Assume $queryResults is the array from your SQL query
include "../conn.php";
$sql = "SELECT * FROM `patients_meds`
inner join medication on medication.med_id = patients_meds.med_id
INNER JOIN patients_meds_count on patients_meds_count.p_med_id = patients_meds.p_med_id;";

$result = $conn->query($sql);
$meds = [];
$adminDates = [];
while ($row =$result->fetch_assoc()) {
    $p_med_id = $row['p_med_id'];
    $issuedDate = $row['date']; // The date from the prescription
    
    // We need the date part of the administration timestamp
    // Assuming 'time_ad' contains both or you have a separate date_ad field
    $adDate = date('Y-m-d', strtotime($row['time_ad'])); 
    $adTime = date('H:i', strtotime($row['time_ad']));

    // 1. Collect all unique administration dates for the column headers
    if (!in_array($adDate, $adminDates)) {
        $adminDates[] = $adDate;
    }

    // 2. Build the medication row info
    if (!isset($meds[$p_med_id])) {
        $meds[$p_med_id] = [
            'name' => $row['med_name'],
            'issued' => $issuedDate,
            'freq' => $row['per_day'],
            'days' => $row['num_days'],
            'history' => [] // [Date => [Time1, Time2...]]
        ];
    }

    // 3. Add this specific administration time to that date
    $meds[$p_med_id]['history'][$adDate][] = $adTime;
}

// Sort dates so the table columns appear in chronological order
sort($adminDates);
?>
<html>
    <head>
        <style>
            .mar-table {
    width: 100%;
    border-collapse: collapse;
    color: #000;
}

.mar-table th, .mar-table td {
    border: 1px solid #000;
    vertical-align: top; /* Align times to the top of the cell */
    padding: 0; /* Remove default padding to allow mini-rows to fill */
}

/* First Column Styling */
.mar-table td:first-child {
    padding: 10px;
    background-color: #f9f9f9;
    min-width: 220px;
}

.meta-text {
    font-size: 0.85em;
    color: #444;
}

/* The "Smaller Rows" inside the cell */
.time-entry {
    padding: 6px 10px;
    border-bottom: 1px solid #eee; /* Light divider between times */
    font-family: monospace;
    font-size: 0.9em;
    text-align: center;
}

.time-entry:last-child {
    border-bottom: none;
}

.no-data {
    text-align: center;
    padding: 10px;
    color: #ccc;
}
        </style>
    </head>
    <table class="mar-table">
        <thead>
            <tr>
                <th>Medication Details<br><small>(Name, Issued, Freq, Duration)</small></th>
                <?php foreach ($adminDates as $date): ?>
                    <th><?php echo htmlspecialchars($date); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meds as $id => $data): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($data['name']); ?></strong><br>
                        <span class="meta-text">Issued: <?php echo htmlspecialchars($data['issued']); ?></span><br>
                        <span class="meta-text"><?php echo htmlspecialchars($data['freq']); ?>x Daily / <?php echo htmlspecialchars($data['days']); ?> Days</span>
                    </td>

                    <?php foreach ($adminDates as $date): ?>
                        <td class="time-cell">
                            <?php if (isset($data['history'][$date])): ?>
                                <?php foreach ($data['history'][$date] as $time): ?>
                                    <div class="time-entry"><?php echo htmlspecialchars($time); ?></div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="no-data">-</div>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</html>
