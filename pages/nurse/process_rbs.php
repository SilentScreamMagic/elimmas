<?php
include '../conn.php'; // use your actual connection file name


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Use '?' instead of ':name'
    $sql = "INSERT INTO baby_head_ticket (
        apt_id, mother_name, mother_address, father_name, father_address, 
        type_labour, duration_labour, complications, indications, gest_age, 
        date_delivery, time_delivery, birth_weight, presentation, full_length, 
        chest_length, head_circumference, urine_passed, meconium_passed, 
        rbs_checked, abnormalities, time_placenta,
        apgar1_colour, apgar5_colour, apgar1_pulse, apgar5_pulse, 
        apgar1_reflex, apgar5_reflex, apgar1_tone, apgar5_tone, 
        apgar1_resp, apgar5_resp
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?
    )";

    $stmt = $conn->prepare($sql);

    // 3. Create a flat array of values in the EXACT order of the '?' above
    $values = [
        $_POST['apt_id'] ?? null,
        $_POST['mother_name'] ?? '',
        $_POST['mother_address'] ?? '',
        $_POST['father_name'] ?? '',
        $_POST['father_address'] ?? '',
        $_POST['type_labour'] ?? '',
        $_POST['duration_labour'] ?? 0,
        $_POST['complications'] ?? '',
        $_POST['indications'] ?? '',
        $_POST['gest_age'] ?? 0,
        $_POST['date_delivery'] ?? null,
        $_POST['time_delivery'] ?? null,
        $_POST['birth_weight'] ?? 0.00,
        $_POST['presentation'] ?? '',
        $_POST['full_length'] ?? 0,
        $_POST['chest_length'] ?? 0,
        $_POST['head_circumference'] ?? 0,
        $_POST['urine_passed'] ?? '',
        $_POST['meconium_passed'] ?? '',
        $_POST['rbs_checked'] ?? '',
        $_POST['abnormalities'] ?? '',
        $_POST['time_placenta'] ?? null,
        $_POST['apgar1_colour'] ?? 0,
        $_POST['apgar5_colour'] ?? 0,
        $_POST['apgar1_pulse'] ?? 0,
        $_POST['apgar5_pulse'] ?? 0,
        $_POST['apgar1_reflex'] ?? 0,
        $_POST['apgar5_reflex'] ?? 0,
        $_POST['apgar1_tone'] ?? 0,
        $_POST['apgar5_tone'] ?? 0,
        $_POST['apgar1_resp'] ?? 0,
        $_POST['apgar5_resp'] ?? 0
    ];

    // 4. Execute passing the array (Requires PHP 8.1+)
    try {
        $stmt->execute($values);
        echo "Record saved successfully!";
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>