<?php
require_once 'config.php';

$playerManager = new PlayerManager();
$players = $playerManager->displaySortedPlayersList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Players List</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Players Sorted by Runs (Descending)</h2>
    <table>
        <tr>
            <th>Player Code</th>
            <th>Name</th>
            <th>Runs</th>
            <th>Innings Played</th>
            <th>Times Out</th>
        </tr>
        <?php while($row = $players->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['player_code']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['runs']; ?></td>
            <td><?php echo $row['innings_played']; ?></td>
            <td><?php echo $row['no_of_times_out']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.html">Back to Main Menu</a>
</body>
</html>