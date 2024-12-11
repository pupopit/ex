<?php
require_once 'config.php';

class PlayerManager implements CricketGameActivities {
    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection();
    }

    public function enterPlayerDetails($name, $runs, $innings_played, $no_of_times_out) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO players (name, runs, innings_played, no_of_times_out) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $name, $runs, $innings_played, $no_of_times_out);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function calculatePlayerAverage($player_code) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT runs, no_of_times_out FROM players WHERE player_code = ?");
        $stmt->bind_param("i", $player_code);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['no_of_times_out'] > 0 ? $row['runs'] / $row['no_of_times_out'] : 0;
        }
        return 0;
    }

    public function calculateOverallAverage() {
        $conn = $this->db->getConnection();
        $result = $conn->query("SELECT AVG(runs / no_of_times_out) as overall_avg FROM players");
        $row = $result->fetch_assoc();
        return $row['overall_avg'];
    }

    public function displaySortedPlayersList() {
        $conn = $this->db->getConnection();
        $result = $conn->query("SELECT * FROM players ORDER BY runs DESC");
        return $result;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerManager = new PlayerManager();
    $result = $playerManager->enterPlayerDetails(
        $_POST['name'], 
        $_POST['runs'], 
        $_POST['innings_played'], 
        $_POST['no_of_times_out']
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Player</title>
</head>
<body>
    <h2>Add New Player</h2>
    <?php if (isset($result) && $result): ?>
        <p style="color: green;">Player added successfully!</p>
    <?php endif; ?>
    <form method="POST">
        <label>Name: <input type="text" name="name" required></label><br>
        <label>Runs: <input type="number" name="runs" required></label><br>
        <label>Innings Played: <input type="number" name="innings_played" required></label><br>
        <label>Number of Times Out: <input type="number" name="no_of_times_out" required></label><br>
        <input type="submit" value="Add Player">
    </form>
    <a href="index.html">Back to Main Menu</a>
</body>
</html>