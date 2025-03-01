<?php
// admin_users.php - Admin User Management
if (session_status() == PHP_SESSION_NONE) {
    session_start();

// Fetch admin users
$adminQuery = "SELECT item_id, login, email, access_level, created_at 
               FROM accounts 
               WHERE access_level >= 100 
               ORDER BY access_level DESC, created_at DESC";
$adminResult = $conn->query($adminQuery);

$page_title = "Admin User Management";
include 'header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Create Admin User
                    </h5>
                </div>
                <div class="card-body">
                    <?php 
                    // Display any form errors
                    if (isset($_SESSION['form_errors'])) {
                        echo '<div class="alert alert-danger">';
                        foreach ($_SESSION['form_errors'] as $error) {
                            echo htmlspecialchars($error) . '<br>';
                        }
                        echo '</div>';
                        unset($_SESSION['form_errors']);
                    }
                    ?>
                    <form method="post" action="">
                        <input type="hidden" name="action" value="create_user">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="access_level" class="form-label">Access Level</label>
                            <select class="form-select" id="access_level" name="access_level" required>
                                <option value="100">Standard Admin (100)</option>
                                <option value="200">Super Admin (200)</option>
                                <option value="9999">System Administrator (250)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus me-2"></i>Create Admin User
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-people me-2"></i>Existing Admin Users
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if ($adminResult && $adminResult->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Access Level</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($admin = $adminResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($admin['login']); ?></td>
                                            <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                            <td>
                                                <span class="badge 
                                                    <?php 
                                                    if ($admin['access_level'] >= 250) echo 'bg-danger';
                                                    elseif ($admin['access_level'] >= 200) echo 'bg-warning';
                                                    else echo 'bg-primary';
                                                    ?>
                                                ">
                                                    <?php echo htmlspecialchars($admin['access_level']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                                            <td>
                                                <form method="post" action="" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin user?');">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="user_id" value="<?php echo $admin['item_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info m-3 text-center">
                            No admin users found.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

require_once 'database.php';
require_once 'crud_functions.php';

// Require high-level admin access
checkAdminPermission(200); // Super admin level

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create new admin user
    if (isset($_POST['action']) && $_POST['action'] == 'create_user') {
        try {
            $username = sanitize($conn, $_POST['username']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $access_level = intval($_POST['access_level']);

            // Validate inputs
            $errors = [];
            if (empty($username)) {
                $errors[] = "Username is required.";
            }
            if (!$email) {
                $errors[] = "Invalid email address.";
            }
            if (empty($password) || $password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }
            if ($access_level < 100) {
                $errors[] = "Invalid access level.";
            }

            if (empty($errors)) {
                // Check if username or email already exists
                $checkQuery = "SELECT * FROM accounts WHERE login = ? OR email = ?";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bind_param("ss", $username, $email);
                $checkStmt->execute();
                $result = $checkStmt->get_result();

                if ($result->num_rows > 0) {
                    $errors[] = "Username or email already exists.";
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);

                    // Insert new admin user
                    $insertQuery = "INSERT INTO accounts (login, password, email, access_level, created_at) 
                                    VALUES (?, ?, ?, ?, NOW())";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("sssi", $username, $hashed_password, $email, $access_level);
                    
                    if ($insertStmt->execute()) {
                        // Log admin creation
                        securityLog('ADMIN_CREATED', $_SESSION['admin_username'], $_SERVER['REMOTE_ADDR'], 
                                    "Created new admin user: {$username} with access level {$access_level}");
                        
                        $_SESSION['success_message'] = "Admin user created successfully!";
                    } else {
                        $errors[] = "Failed to create admin user.";
                    }
                }
            }

            if (!empty($errors)) {
                $_SESSION['form_errors'] = $errors;
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    }

    // Delete admin user
    if (isset($_POST['action']) && $_POST['action'] == 'delete_user') {
        try {
            $user_id = intval($_POST['user_id']);
            
            // Prevent deleting the current user
            if ($user_id == $_SESSION['admin_user_id']) {
                throw new Exception("You cannot delete your own account.");
            }

            $deleteQuery = "DELETE FROM accounts WHERE item_id = ? AND access_level >= 100";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $user_id);
            
            if ($deleteStmt->execute()) {
                // Log admin deletion
                securityLog('ADMIN_DELETED', $_SESSION['admin_username'], $_SERVER['REMOTE_ADDR'], 
                            "Deleted admin user with ID: {$user_id}");
                
                $_SESSION['success_message'] = "Admin user deleted successfully!";
            } else {
                throw new Exception("Failed to delete admin user.");
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }
    }
}