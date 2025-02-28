<?php
// login.php - Comprehensive Admin Login Page
session_start();
require_once 'database.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $username = sanitize($conn, $_POST['username']);
    $password = $_POST['password'];

    try {
        // Prepare statement to prevent SQL injection
        $query = "SELECT * FROM accounts WHERE login = ? AND access_level >= 100";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password 
            $passwordVerified = false;

            // Check hashed password first
            if (strpos($user['password'], '$argon2') === 0) {
                $passwordVerified = password_verify($password, $user['password']);
            } 
            // Fallback to plain text comparison
            else {
                $passwordVerified = ($password === $user['password']);
            }

            if ($passwordVerified) {
                // Successful login
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                $_SESSION['admin_user_id'] = $user['item_id'];
                $_SESSION['admin_access_level'] = $user['access_level'];

                // Log login attempt
                securityLog('LOGIN_SUCCESSFUL', $username, $_SERVER['REMOTE_ADDR'], 
                            "Admin login successful");

                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit;
            } else {
                // Invalid password
                securityLog('LOGIN_FAILED', $username, $_SERVER['REMOTE_ADDR'], 
                            "Invalid password attempt");
                
                $_SESSION['login_error'] = "Invalid username or password.";
            }
        } else {
            // User not found or insufficient access level
            securityLog('LOGIN_FAILED', $username, $_SERVER['REMOTE_ADDR'], 
                        "Non-existent admin account or insufficient permissions");
            
            $_SESSION['login_error'] = "Invalid username or insufficient permissions.";
        }
    } catch (Exception $e) {
        // Log error
        error_log("Login error: " . $e->getMessage());
        $_SESSION['login_error'] = "An unexpected error occurred. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>
                            <i class="bi bi-shield-lock me-2"></i>
                            Admin Login
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        // Display login errors
                        if (isset($_SESSION['login_error'])) {
                            echo '<div class="alert alert-danger">' . 
                                 htmlspecialchars($_SESSION['login_error']) . 
                                 '</div>';
                            unset($_SESSION['login_error']);
                        }
                        ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" required 
                                           placeholder="Enter your username">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required 
                                           placeholder="Enter your password">
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="password_reset.php" class="text-muted text-decoration-none">
                                <i class="bi bi-shield-lock me-2"></i>Forgot Password?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>