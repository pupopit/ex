12. 	Menu Driven Program 
Write a menu driven program to perform various file operations. - Display size of file - Display Last Access, changed, modified time of file - Display details about owner and user of File - Display type of file - Delete a file - Copy a file - Traverse a directory in hierarchy - Remove a directory

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>File Operations</title>
</head>
<body>
    <h1>File Operations</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Select an operation:</label>
        <select name="operation">
            <option value="size">Display file size</option>
            <option value="details">File details (size, type, timestamps)</option>
            <option value="delete">Delete a file</option>
            <option value="copy">Copy a file</option>
        </select>
        <br><br>

        <label>Upload a file:</label>
        <input type="file" name="uploadedFile" required>
        <br><br>

        <label>Destination path (for copy):</label>
        <input type="text" name="destination">
        <br><br>

        <button type="submit" name="submit">Perform Operation</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
        $operation = $_POST['operation'];
        $destination = $_POST['destination'] ?? '';

        // Ensure uploads directory exists
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create uploads directory
        }

        // Save the uploaded file in uploads directory
        $uploadedFileName = basename($_FILES['uploadedFile']['name']);
        $uploadedFilePath = $uploadDir . $uploadedFileName;

        if (move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $uploadedFilePath)) {
            echo "<p>File uploaded successfully to: $uploadedFilePath</p>";

            // Perform the selected operation
            switch ($operation) {
                case 'size':
                    echo "<p>File size: " . filesize($uploadedFilePath) . " bytes</p>";
                    break;

                case 'details':
                    echo "<p>Size: " . filesize($uploadedFilePath) . " bytes</p>";
                    echo "<p>Type: " . filetype($uploadedFilePath) . "</p>";
                    echo "<p>Last Access: " . date("Y-m-d H:i:s", fileatime($uploadedFilePath)) . "</p>";
                    echo "<p>Last Modified: " . date("Y-m-d H:i:s", filemtime($uploadedFilePath)) . "</p>";
                    break;

                case 'delete':
                    if (unlink($uploadedFilePath)) {
                        echo "<p>File deleted successfully.</p>";
                    } else {
                        echo "<p style='color: red;'>Failed to delete file.</p>";
                    }
                    break;

                case 'copy':
                    if (empty($destination)) {
                        echo "<p style='color: red;'>Please provide a destination path.</p>";
                    } else {
                        $destFilePath = $uploadDir . basename($destination);
                        if (copy($uploadedFilePath, $destFilePath)) {
                            echo "<p>File copied successfully to: $destFilePath</p>";
                        } else {
                            echo "<p style='color: red;'>Failed to copy file.</p>";
                        }
                    }
                    break;

                default:
                    echo "<p style='color: red;'>Invalid operation.</p>";
            }
        } else {
            echo "<p style='color: red;'>Failed to upload file.</p>";
        }
    }
    ?>
</body>
</html>
