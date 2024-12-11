
 <!--8.Student Result Generation System  Develop a Student Result Generation System. Provide following facilities: - Students Exam Detail Entry - Marks entry - Result Generation - Marksheet and Result Analysis -->


<?php
// Start session to store and retrieve student data across form submissions
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Function to calculate result and analysis
function calculateResult($marks) {
    $total = array_sum($marks);
    $percentage = $total / count($marks);
    $result = $percentage >= 40 ? 'Pass' : 'Fail';
    return [
        'total' => $total,
        'percentage' => round($percentage, 2),
        'result' => $result
    ];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addStudent'])) {
        // Add student details
        $studentId = uniqid();
        $studentName = $_POST['studentName'];
        $examDetails = $_POST['examDetails'];
        $_SESSION['students'][$studentId] = [
            'name' => $studentName,
            'examDetails' => $examDetails,
            'marks' => [],
            'result' => []
        ];
    } elseif (isset($_POST['addMarks'])) {
        // Add marks for a student
        $studentId = $_POST['studentId'];
        $marks = array_map('intval', $_POST['marks']);
        $result = calculateResult($marks);
        $_SESSION['students'][$studentId]['marks'] = $marks;
        $_SESSION['students'][$studentId]['result'] = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Generation System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: left;
            padding: 10px;
        }

        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Student Result Generation System</h1>

    <!-- Add Student Form -->
    <h2>Add Student</h2>
    <form method="POST">
        <label for="studentName">Student Name:</label>
        <input type="text" id="studentName" name="studentName" required>
        <label for="examDetails">Exam Details (e.g., Semester 1, Final Exam):</label>
        <input type="text" id="examDetails" name="examDetails" required>
        <button type="submit" name="addStudent">Add Student</button>
    </form>

    <!-- Add Marks Form -->
    <?php if (!empty($_SESSION['students'])): ?>
        <h2>Enter Marks</h2>
        <form method="POST">
            <label for="studentId">Select Student:</label>
            <select id="studentId" name="studentId" required>
                <option value="">Select</option>
                <?php foreach ($_SESSION['students'] as $id => $student): ?>
                    <option value="<?= $id ?>"><?= $student['name'] ?> (<?= $student['examDetails'] ?>)</option>
                <?php endforeach; ?>
            </select>
            <label for="marks">Enter Marks (comma-separated):</label>
            <input type="text" id="marks" name="marks[]" placeholder="e.g., 50, 60, 70" required>
            <button type="submit" name="addMarks">Submit Marks</button>
        </form>
    <?php endif; ?>

    <!-- Display Students and Results -->
    <?php if (!empty($_SESSION['students'])): ?>
        <h2>Student Results</h2>
        <table>
            <thead>
            <tr>
                <th>Student Name</th>
                <th>Exam Details</th>
                <th>Total Marks</th>
                <th>Percentage</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['students'] as $student): ?>
                <tr>
                    <td><?= $student['name'] ?></td>
                    <td><?= $student['examDetails'] ?></td>
                    <td><?= !empty($student['result']) ? $student['result']['total'] : 'N/A' ?></td>
                    <td><?= !empty($student['result']) ? $student['result']['percentage'] . '%' : 'N/A' ?></td>
                    <td><?= !empty($student['result']) ? $student['result']['result'] : 'N/A' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
