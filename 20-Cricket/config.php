<?php
class DatabaseConnection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'cricket_management';
    public $connection;

    public function __construct() {
        // Create connection
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function __destruct() {
        $this->connection->close();
    }
}

// Interface for Cricket Game Activities
interface CricketGameActivities {
    public function enterPlayerDetails($name, $runs, $innings_played, $no_of_times_out);
    public function calculatePlayerAverage($player_code);
    public function calculateOverallAverage();
    public function displaySortedPlayersList();
}