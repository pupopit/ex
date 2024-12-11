<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
</head>
<body>
    <h2>Update Student</h2>
    <?php
    
    $id = $_GET['id'];
    
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
    $student = mysqli_fetch_assoc($result);

    
    if (!$student) {
        echo "Student not found!";
        exit;
    }

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $semester = $_POST['semester'];
        $phone_number = $_POST['phone_number'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $course = $_POST['course'];

        
        $sql = "UPDATE students SET 
                name='$name', 
                semester='$semester', 
                phone_number='$phone_number', 
                email='$email', 
                gender='$gender', 
                course='$course' 
                WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            echo "Student updated successfully!";
            echo "<br><a href='view_students.php'>View Students</a>";
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>

    <form method="POST">
        Name: <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
        Semester: <input type="text" name="semester" value="<?php echo $student['semester']; ?>"><br>
        Phone Number: <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $student['email']; ?>"><br>
        Gender: 
        <select name="gender">
            <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($student['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select><br>
        Course: <input type="text" name="course" value="<?php echo $student['course']; ?>"><br>
        <button type="submit">Save</button>
    </form>

    <br>
    <a href="view_students.php">Cancel</a>
</body>
</html>

<?php mysqli_close($conn); ?>