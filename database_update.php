<?php
// database.php - Database connection configuration
session_start(); // Start session for error/success message handling

// Database connection settings
$host = "localhost";    // Database host (usually localhost)
$username = "root";     // Database username (change as needed)
$password = "";         // Database password (change as needed)
$database = "l1j_remastered";  // Database name (change to your actual database name)

// Enhanced error handling
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
    error_log($e->getMessage());

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

// Error handling middleware
function handleDatabaseError($e) {
    // Log the full error
    error_log($e->getMessage());
    
    // Set a user-friendly error message
    $_SESSION['error_message'] = "An unexpected database error occurred. Please try again.";
    
    // You can customize error handling based on the type of error
    if ($e instanceof mysqli_sql_exception) {
        // Handle specific MySQL errors
        switch ($e->getCode()) {
            case 1062: // Duplicate entry
                $_SESSION['error_message'] = "This item already exists. Please use a unique identifier.";
                break;
            case 1452: // Foreign key constraint fails
                $_SESSION['error_message'] = "Related record not found. Check your input.";
                break;
        }
    }
}

// Optional: Create a simple logging mechanism
function logAction($action, $details = '') {
    global $conn;
    
    try {
        $query = "INSERT INTO system_log (action, details, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $action, $details);
        $stmt->execute();
    } catch (Exception $e) {
        // Silent fail or log to error log
        error_log("Logging failed: " . $e->getMessage());
    }
}

// Shutdown function to ensure database connection is closed
register_shutdown_function(function() {
    global $conn;
    if (isset($conn) && is_object($conn)) {
        $conn->close();
    }
});
?>