<?php
include 'connect.php'; 


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id); 

        if (mysqli_stmt_execute($stmt)) {
           
            header("Location: index.php");
            exit(); 
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

       
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "No student ID specified.";
}


mysqli_close($conn);
?>