<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "test"; // Replace with your database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve search query
if (isset($_GET['q'])) {
    $query = $conn->real_escape_string($_GET['q']);

    // Query the database
    $sql = "SELECT name FROM users WHERE name LIKE '%$query%' LIMIT 5";
    $result = $conn->query($sql);

    // Return search results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="result-item">' . htmlspecialchars($row['name']) . '</div>';
        }
    } else {
        echo '<div class="result-item">No results found</div>';
    }
}

$conn->close();
?>
