<?php
// logout.php - Logout script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log logout action if admin was logged in
if (isset($_SESSION['admin_username'])) {
    require_once 'database.php';
    require_once 'security_functions.php'; // Add this line to include the security functions
    securityLog('LOGOUT', $_SESSION['admin_username'], $_SERVER['REMOTE_ADDR'], 
                "Admin logged out");
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page
header("Location: login.php");
exit();
?>