<?php
// database.php - Database connection configuration
$host = "localhost";    // Database host (usually localhost)
$username = "root";     // Database username (change as needed)
$password = "";         // Database password (change as needed)
$database = "l1j_remastered";  // Database name (change to your actual database name)

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to handle special characters correctly
$conn->set_charset("utf8");

// Function to escape input data for security
function sanitize($conn, $data) {
    return $conn->real_escape_string(trim($data));
}

// Function to get item icon HTML
function getItemIcon($iconId, $size = 32, $withFallback = false) {
    $iconPath = "icon/{$iconId}.png";
    
    if (!empty($iconId) && file_exists($iconPath)) {
        return "<img src='{$iconPath}' alt='Icon' width='{$size}' height='{$size}' class='item-icon'>";
    } else if ($withFallback) {
        return "<div class='no-icon' style='width:{$size}px;height:{$size}px;'><i class='bi bi-question-circle'></i></div>";
    }
    
    return "";
}
?>