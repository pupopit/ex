<?php

class SubjectMIS {
    private $conn;

    // Connect to the database
    public function connect($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connected successfully<br>";
    }

    // Disconnect from the database
    public function disconnect() {
        if ($this->conn) {
            $this->conn->close();
            echo "Disconnected successfully<br>";
        }
    }

    // Select subjects
    public function select($id = null) {
        $sql = "SELECT * FROM subjects" . ($id ? " WHERE id = ?" : "");
        $stmt = $this->conn->prepare($sql);

        if ($id) {
            $stmt->bind_param("i", $id);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    // Insert a new subject
    public function insert($name, $code, $credits) {
        $sql = "INSERT INTO subjects (name, code, credits) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $code, $credits);
        $stmt->execute();
        $stmt->close();

        echo "New subject inserted successfully<br>";
    }

    // Update an existing subject
    public function update($id, $name, $code, $credits) {
        $sql = "UPDATE subjects SET name = ?, code = ?, credits = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $name, $code, $credits, $id);
        $stmt->execute();
        $stmt->close();

        echo "Subject updated successfully<br>";
    }

    // Delete a subject
    public function delete($id) {
        $sql = "DELETE FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        echo "Subject deleted successfully<br>";
    }
}

// Example usage
$subjectMIS = new SubjectMIS();
$subjectMIS->connect('localhost', 'root', '', 'subject_mis');

// Insert a new subject
$subjectMIS->insert('Mathematics', 'MATH101', 3);

// Select all subjects
$subjects = $subjectMIS->select();
print_r($subjects);

// Update a subject (assuming id 1 exists)
$subjectMIS->update(1, 'Advanced Mathematics', 'MATH201', 4);

// Delete a subject (assuming id 1 exists)
$subjectMIS->delete(1);

// Disconnect from the database
$subjectMIS->disconnect();
?>