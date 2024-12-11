<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label = $_POST['label'];
    $font_size = $_POST['font_size'];
    $color = $_POST['color'];

    $sql = "INSERT INTO events (label, font_size, color) VALUES ('$label', '$font_size', '$color')";
    $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel: Add Event</h1>
    <form method="POST" action="">
        <label for="label">Event Label:</label><br>
        <input type="text" id="label" name="label" required><br><br>

        <label for="font_size">Font Size:</label><br>
        <input type="text" id="font_size" name="font_size" placeholder="e.g., 20px" required><br><br>

        <label for="color">Font Color:</label><br>
        <input type="text" id="color" name="color" placeholder="e.g., red, #000" required><br><br>

        <button type="submit">Add Event</button>
    </form>
</body>
</html>
