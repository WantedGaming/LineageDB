<?php
// delete_weapon.php - Delete a weapon item
session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Validate input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid weapon item ID.";
    header('Location: weapon_list.php');
    exit;
}

$id = (int)$_GET['id'];

// Handle confirmation
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    try {
        // Start transaction
        $conn->begin_transaction();

        // First, log the action before deletion
        logDatabaseAction($conn, 'DELETE', $id, "Preparing to delete weapon item");

        // Fetch item details before deletion for logging
        $fetchQuery = "SELECT desc_en FROM weapon WHERE item_id = ?";
        $fetchStmt = $conn->prepare($fetchQuery);
        $fetchStmt->bind_param("i", $id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        $item = $result->fetch_assoc();

        // Delete the item
        $deleteQuery = "DELETE FROM weapon WHERE item_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
        
        if ($deleteStmt->execute()) {
            // Log successful deletion
            logDatabaseAction($conn, 'DELETE', $id, "Deleted weapon item: " . $item['desc_en']);
            
            // Commit transaction
            $conn->commit();

            // Set success message
            $_SESSION['success_message'] = "Weapon item deleted successfully!";
            
            // Redirect to weapon list
            header('Location: weapon_list.php');
            exit;
        } else {
            // Rollback transaction
            $conn->rollback();
            throw new Exception("Error deleting record: " . $deleteStmt->error);
        }
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();

        // Set error message
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: view_weapon.php?id=$id");
        exit;
    }
}

// Get item information for confirmation
$query = "SELECT item_id, desc_en FROM weapon WHERE item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "No weapon item found with the specified ID.";
    header('Location: weapon_list.php');
    exit;
}

$weapon = $result->fetch_assoc();

// Page setup
$page_title = "Delete Weapon Item";
include 'header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="weapon_list.php">Weapon List</a></li>
            <li class="breadcrumb-item"><a href="view_weapon.php?id=<?php echo $id; ?>">View Weapon</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Weapon</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-danger text-white">
            <h2><i class="bi bi-trash me-2"></i>Delete Weapon Item</h2>
        </div>
        <div class="card-body">
            <?php 
            // Display any error messages
            displayErrorMessages(); 
            ?>

            <div class="alert alert-warning">
                <h4 class="alert-heading">Warning!</h4>
                <p>You are about to delete the following weapon item:</p>
                <p>
                    <strong>ID:</strong> <?php echo htmlspecialchars($weapon['item_id']); ?><br>
                    <strong>Name:</strong> <?php echo htmlspecialchars($weapon['desc_en']); ?>
                </p>
                <p>This action cannot be undone. Are you sure you want to proceed?</p>
            </div>

            <div class="d-flex justify-content-between">
                <a href="view_weapon.php?id=<?php echo $id; ?>" class="btn btn-secondary">Cancel</a>
                <a href="delete_weapon.php?id=<?php echo $id; ?>&confirm=yes" class="btn btn-danger">Yes, Delete This Item</a>
            </div>
        </div>
    </div>
</div>

<?php 
// Close connection
$stmt->close();
$conn->close(); 
include 'footer.php';
?>