<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <form method="POST">
        Name: <input type="text" name="name" required><br>
        Semester: <input type="text" name="semester"><br>
        Phone Number: <input type="text" name="phone_number"><br>
        Email: <input type="email" name="email"><br>
        Gender: 
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>
        Course: <input type="text" name="course"><br>
        <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "INSERT INTO students (name, semester, phone_number, email, gender, course) 
                VALUES ('{$_POST['name']}', '{$_POST['semester']}', '{$_POST['phone_number']}', '{$_POST['email']}', '{$_POST['gender']}', '{$_POST['course']}')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Student added!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    ?>

    <br><br>
    <a href="view_students.php"><button>View Students</button></a>
    
</body>
</html>