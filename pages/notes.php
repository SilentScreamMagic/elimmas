<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scrollable Notes Box</title>
<style>
    /* Style for the container */
    .notes-container {
        width: 300px; /* Adjust width as needed */
        height: 300px; /* Adjust height as needed */
        overflow: auto; /* Enable scrolling */
        border: 1px solid #ccc;
        padding: 10px;
    }

    /* Style for the notes */
    .notes {
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.5;
    }
</style>
</head>
<body>

<div class="notes-container">
    <div class="notes">
        <p>This is a sample note.</p>
        <p>Here's another note.</p>
        <p>This is a longer note to demonstrate scrolling. This note will be repeated several times to fill the container.</p>
        <p>This is a longer note to demonstrate scrolling. This note will be repeated several times to fill the container.</p>
        <p>This is a longer note to demonstrate scrolling. This note will be repeated several times to fill the container.</p>
        <!-- Repeat the above line as many times as needed -->
    </div>
</div>

</body>
</html>
<?php
    $conn->close();
?>

<div class="form-group">
            <label for="bed">Accomodation</label>
                <select name='bed' id='bed'>
                <option value=''>Select a Room and Bed...</option>";
                <?php
                foreach ($rooms as $rid =>$beds):
                    foreach($beds as $bid)
                        echo "<option value='$bid'>Ward $rid Bed $bid </option>";
                    endforeach;
            ?>
                </select>
            </div>
            $sql = "INSERT INTO `patients_beds` ( `bed_id`, `apt_id`, `start_date`) 
                VALUES ( $bed,$apt_id, now())";
        $conn->query($sql);
        $sql = "update beds set status = 'occupied' where bed_id = $bed";