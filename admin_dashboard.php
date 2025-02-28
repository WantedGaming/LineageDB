<?php
// admin_dashboard.php - Admin Dashboard
session_start();
require_once 'database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Verify admin access level
$requiredAccessLevel = 100;
if ($_SESSION['admin_access_level'] < $requiredAccessLevel) {
    $_SESSION['error_message'] = "Insufficient permissions.";
    header("Location: index.php");
    exit;
}

// Fetch database statistics
function getDatabaseStats($conn) {
    $stats = [];
    $tables = ['armor', 'weapon', 'npc', 'mapids', 'droplist'];
    
    foreach ($tables as $table) {
        $query = "SELECT COUNT(*) as count FROM $table";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $stats[$table] = $row['count'];
    }
    
    return $stats;
}

$stats = getDatabaseStats($conn);

$page_title = "Admin Dashboard";
include 'header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>
                        <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                    </h2>
                    <div>
                        <span class="me-3">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                        <a href="logout.php" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Dashboard card content similar to previous implementation -->
                        <div class="col-md-4 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Armor Items</h5>
                                        <p class="card-text display-6"><?php echo number_format($stats['armor']); ?></p>
                                    </div>
                                    <i class="bi bi-shield-fill fs-2"></i>
                                </div>
                                <div class="card-footer">
                                    <a href="armor_list.php" class="text-white text-decoration-none">
                                        Manage Armor <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Additional cards for other database tables -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'footer.php'; 
?>