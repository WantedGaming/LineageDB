<?php
// database.php - Database Connection Configuration
session_start();

// Database connection settings
$host = "localhost";    // Database host
$username = "root";     // Database username
$password = "";         // Database password
$database = "l1j_remastered";  // Database name

// Enhanced error handling and logging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection with improved error handling
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set character set to handle special characters correctly
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    // Log the error
    error_log("Database Connection Error: " . $e->getMessage());

    // Display user-friendly error message
    $_SESSION['error_message'] = "A database connection error occurred. Please try again later.";
    
    // Redirect to error page or homepage
    header("Location: error.php");
    exit;
}

// Function to escape input data for security
function sanitize($conn, $data) {
    // Trim whitespace
    $data = trim($data);
    
    // Remove backslashes
    $data = stripslashes($data);
    
    // Escape special characters
    return $conn->real_escape_string($data);
}

// Function to get item icon HTML
function getItemIcon($iconId, $size = 32, $withFallback = false) {
    $iconPath = "icons/{$iconId}.png";
    
    if (!empty($iconId) && file_exists($iconPath)) {
        return "<img src='{$iconPath}' alt='Icon' width='{$size}' height='{$size}' class='item-icon'>";
    } else if ($withFallback) {
        return "<div class='no-icon' style='width:{$size}px;height:{$size}px;'><i class='bi bi-question-circle'></i></div>";
    }
    
    return "";
}

// Shutdown function to ensure database connection is closed
register_shutdown_function(function() {
    global $conn;
    if (isset($conn) && is_object($conn)) {
        $conn->close();
    }
});
?>