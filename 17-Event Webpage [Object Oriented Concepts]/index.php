<?php
require 'Event.php';

$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
</head>
<body>
    <h1>Upcoming Events</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $event = new Event($row['label'], $row['font_size'], $row['color']);
            $event->show_event();
        }
    } else {
        echo "No events found!";
    }
    ?>
</body>
</html>
