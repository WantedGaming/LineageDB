<?php
// error.php - Generic error handling page
session_start();
$page_title = "Error Occurred";
include 'header.php';
?>

<div class="container mt-5">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h2><i class="bi bi-exclamation-triangle me-2"></i>An Error Occurred</h2>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo htmlspecialchars($_SESSION['error_message']); 
                    unset($_SESSION['error_message']); 
                    ?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    An unexpected error has occurred. Please try again later.
                </div>
            <?php endif; ?>

            <div class="text-center">
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-house me-2"></i>Return to Home
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
