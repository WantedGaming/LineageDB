<?php
// logout.php - Enhanced Logout Script with Website Design
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log logout action if admin was logged in
if (isset($_SESSION['admin_username'])) {
    require_once 'database.php';
    require_once 'security_functions.php';
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

// Page title
$page_title = "Logged Out";
include 'header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="bi bi-box-arrow-right me-2"></i>You Have Been Logged Out
                    </h2>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-3">Logout Successful</h4>
                    <p class="text-muted mb-4">
                        You have been securely logged out of the admin panel. 
                        Your session has been terminated.
                    </p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="login.php" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Again
                        </a>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-database me-2"></i>Return to Database
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-lock me-2"></i>
                        Your admin session has ended. Please log in again to access admin features.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>