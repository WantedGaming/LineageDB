<?php
// add_armor.php - Add new armor item with admin check
session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Require admin login
requireAdminLogin();

// Check admin permissions (optional: specify a minimum access level)
checkAdminPermission(100);

// Find the next available item_id
$nextId = generateUniqueItemId($conn);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Sanitize inputs
        $item_id = $nextId;
        $item_name_id = sanitizeInput($conn, $_POST['item_name_id']);
        $desc_en = sanitizeInput($conn, $_POST['desc_en']);
        $desc_kr = sanitizeInput($conn, $_POST['desc_kr']);
        $itemGrade = sanitizeInput($conn, $_POST['itemGrade']);
        $type = sanitizeInput($conn, $_POST['type']);
        $grade = (int)$_POST['grade'];
        $material = sanitizeInput($conn, $_POST['material']);
        $weight = (int)$_POST['weight'];
        $ac = (int)$_POST['ac'];
        $safenchant = (int)$_POST['safenchant'];
        
        // Validate input with custom validation
        $validationErrors = validateItemInput([
            'desc_en' => $desc_en,
            'type' => $type,
            'grade' => $grade,
            'ac' => $ac
        ], 'armor');

        if (!empty($validationErrors)) {
            $_SESSION['form_errors'] = $validationErrors;
            throw new Exception("Validation failed. Please check your inputs.");
        }
        
        // Rest of the existing code remains the same...
        
        // Use admin logging function
        logAdminAction('CREATE', $item_id, 'armor', "Created new armor item: {$desc_en}");
        
        // Set success message
        $_SESSION['success_message'] = "New armor item created successfully!";
        
        // Redirect to view the new item
        header("Location: view_armor.php?id=$item_id");
        exit;
    } catch (Exception $e) {
        // Store error message in session
        $_SESSION['error_message'] = $e->getMessage();
    }
}

// Include header with admin check implied
$page_title = "Add New Armor Item";
include 'header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="armor_list.php">Armor List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Armor</li>
        </ol>
    </nav>

    <!-- Rest of the existing form code remains the same -->
    <div class="card">
        <div class="card-header">
            <h2><i class="bi bi-shield-fill me-2"></i>Add New Armor Item</h2>
        </div>
        <div class="card-body">
            <?php 
            // Display error and success messages
            displayErrorMessages(); 
            displaySuccessMessages();
            ?>

            <form method="post" action="" enctype="multipart/form-data">
                <!-- Existing form content remains unchanged -->
                <input type="hidden" name="item_id" value="<?php echo $nextId; ?>">
                
                <!-- Existing form fields -->
                
                <div class="d-flex justify-content-between">
                    <a href="armor_list.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Armor Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>