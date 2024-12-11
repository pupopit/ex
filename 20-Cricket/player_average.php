<?php
require_once 'config.php';

// $playerManager = new PlayerManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_code = $_POST['player_code'];
    $average = $playerManager->calculatePlayerAverage($player_code);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Average</title>
</head>
<body>
    <h2>Player Average Calculation</h2>
    <form method="POST">
        <label>Player Code: <input type="number" name="player_code" required></label>
        <input type="submit" value="Calculate Average">
    </form>

    <?php if (isset($average)): ?>
        <h3>Average Runs: <?php echo number_format($average, 2); ?></h3>
    <?php endif; ?>

    <h3>Overall Team Average: <?php echo number_format($playerManager->calculateOverallAverage(), 2); ?></h3>
    <a href="index.html">Back to Main Menu</a>
</body>
</html>