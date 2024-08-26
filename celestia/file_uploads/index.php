<?php
// Database connection settings
$host = 'localhost'; // Change if needed
$db = 'shine';
$user = 'root'; // Change if needed
$pass = ''; // Change if needed

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check if the file was uploaded without errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = $file['name'];
        $filepath = 'uploads/' . $filename; // Vulnerable to directory traversal

        // Move uploaded file to target directory
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO uploads (filename, filepath) VALUES (?, ?)");
            $stmt->bind_param("ss", $filename, $filepath);

            // Execute the query
            if ($stmt->execute()) {
                echo "File uploaded and data stored successfully.";
            } else {
                echo "Error storing file data in database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . $file['error'];
    }
}

// HTML form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable File Upload</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Choose a file:</label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
