<?php
// credentials
$valid_username = "admin";
$valid_password = "password123";
$valid_secret_key = "abc123xyz";

// Get the credentials from the request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$secret_key = $_POST['secret_key'] ?? '';

// Validate the credentials
if ($username === $valid_username && $password === $valid_password && $secret_key === $valid_secret_key) {
    // Authentication successful
    $response = [
        'username' => 'admin',
        'password' => 'e10adc3949ba59abbe56e057f20f883e',
		'type' => 'md5'
    ];
} else {
    // Authentication failed
    $response = [
      //   'username' => 'admin',
        // 'password' => 'e10adc3949ba59abbe56e057f20f883e',
		 //type' => 'md5'
    ];
}

// Set header to return JSON response
//header('Content-Type: application/json');
echo json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celestia Computer Institute | API Authentication Form</title>
</head>
<body>
    <h2>API Authentication Form</h2>
    <form  method="post">
        <!-- Hidden fields for username, password, and secret key -->
        <input type="hidden" name="username" value="admin">
        <input type="hidden" name="password" value="password123">
        <input type="hidden" name="secret_key" value="abc123xyz">

        <!-- Submit button -->
        <input type="submit" value="Authenticate">
    </form>
</body>
</html>

<?php
// API script (api.php) should be placed in the same directory
// The PHP code provided earlier should be in the 'api.php' file
?>


