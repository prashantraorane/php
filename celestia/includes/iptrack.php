<?php
// Combined file: index.php

// Database connection and insertion functions
$host = 'localhost'; // Database host
$dbname = 'celestia'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}

/**
 * Function to insert tracking data into the database
 *
 * @param string $ip Address of the user
 * @param string $referer Referring URL
 * @param string $url Current URL
 * @param string $browser Browser details
 * @param string $device Device type
 * @param string $latitude Latitude from geolocation
 * @param string $longitude Longitude from geolocation
 * @param string $city City from geolocation
 * @param string $country Country from geolocation
 */
function insertTrackingData($ip, $referer, $url, $browser, $device, $latitude, $longitude, $city, $country) {
    global $pdo;

    $sql = "INSERT INTO tbluser_tracking (ip_address, referer_url, current_url, browser_details, device_type, latitude, longitude, city, country) 
            VALUES (:ip, :referer, :url, :browser, :device, :latitude, :longitude, :city, :country)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':referer', $referer);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':browser', $browser);
    $stmt->bindParam(':device', $device);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':country', $country);
    
    $stmt->execute();
}

/**
 * Function to get user IP address
 */
function getUserIP() {
    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
}

/**
 * Function to get the browser information
 */
function getBrowser() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (strpos($user_agent, 'MSIE') !== false) return 'Internet Explorer';
    if (strpos($user_agent, 'Trident') !== false) return 'Internet Explorer';
    if (strpos($user_agent, 'Firefox') !== false) return 'Firefox';
    if (strpos($user_agent, 'Chrome') !== false) return 'Chrome';
    if (strpos($user_agent, 'Safari') !== false) return 'Safari';
    if (strpos($user_agent, 'Opera') !== false) return 'Opera';
    
    return 'Unknown Browser';
}

/**
 * Function to get device type
 */
function getDevice() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (strpos($user_agent, 'Mobile') !== false) return 'Mobile';
    if (strpos($user_agent, 'Tablet') !== false) return 'Tablet';
    
    return 'Desktop';
}

/**
 * Function to get geolocation from IP
 */
function getGeolocation($ip) {
    // Replace with your actual geolocation API endpoint
    $api_url = "https://api.ipgeolocation.io/ipgeo?apiKey=ff2662b3fb95495ba82f247ee0781c0a&ip=$ip";
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    return [
        'latitude' => $data['latitude'] ?? 'Unknown',
        'longitude' => $data['longitude'] ?? 'Unknown',
        'city' => $data['city'] ?? 'Unknown',
        'country' => $data['country_name'] ?? 'Unknown'
    ];
}

// Collect user data
$ip = getUserIP();
$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct Access';
$url = $_SERVER['REQUEST_URI'] ?? 'Unknown URL';
$browser = getBrowser();
$device = getDevice();
$geolocation = getGeolocation($ip);

// Insert data into database
insertTrackingData(
    $ip, 
    $referer, 
    $url, 
    $browser, 
    $device, 
    $geolocation['latitude'], 
    $geolocation['longitude'], 
    $geolocation['city'], 
    $geolocation['country']
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Project</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>User Tracking</h1>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
