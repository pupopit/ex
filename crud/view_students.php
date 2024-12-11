<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
</head>
<body>
    <h2>Student List</h2>
    <table border="1">

            <th>ID</th>
            <th>Name</th>
            <th>Semester</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Course</th>
            
            
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM students");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['semester']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['course']}</td>
                    <td>
                        <a href='update_student.php?id={$row['id']}'>Update</a> | 
                        <a href='delete_student.php?id={$row['id']}' onclick=\"return confirm('Delete this student?');\">Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>

    <a href="add_student.php"><button>Add Student</button></a>
</body>
</html>

<?php mysqli_close($conn); ?>