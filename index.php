<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
       
        $row = $result->fetch_assoc();
        $_SESSION['user'] = [$username,$row["user_type"]];
        if($row["user_type"]=="Doctor"){
            header("Location: ./doc/docapps.php");
        }
        if($row["user_type"]=="Nurse"){
            header("Location: ./nurse/viewpatients.php");
        }
        if($row["user_type"]=="Pharmacist"){
            header("Location: ./phar/dashboard.php");
        }
        if($row["user_type"]=="Lab Tech"){
            header("Location: ./lab/labs.php");
        }
        if($row["user_type"]=="Front Desk"){
            header("Location: ./desk/appointments.php");
        }
        if($row["user_type"]=="Cashier"){
            header("Location: ./cashier/billpatients.php");
        }

    } else {
        echo "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimmas Login</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

.login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    margin-bottom: 20px;
}

input[type="text"],
input[type="password"],
button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Welcome to Elimmas</h1>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    
</body>
</html>