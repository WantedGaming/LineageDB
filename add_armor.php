<?php
// add_armor.php - Add new armor item
session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Page setup
$page_title = "Add New Armor Item";
include 'header.php';

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
        
        // Validate input
        $validationErrors = validateArmorInput([
            'desc_en' => $desc_en,
            'type' => $type,
            'grade' => $grade,
            'ac' => $ac
        ]);

        if (!empty($validationErrors)) {
            $_SESSION['form_errors'] = $validationErrors;
            throw new Exception("Validation failed. Please check your inputs.");
        }
        
        // Class restrictions
        $use_royal = isset($_POST['use_royal']) ? 1 : 0;
        $use_knight = isset($_POST['use_knight']) ? 1 : 0;
        $use_mage = isset($_POST['use_mage']) ? 1 : 0;
        $use_elf = isset($_POST['use_elf']) ? 1 : 0;
        $use_darkelf = isset($_POST['use_darkelf']) ? 1 : 0;
        $use_dragonknight = isset($_POST['use_dragonknight']) ? 1 : 0;
        $use_illusionist = isset($_POST['use_illusionist']) ? 1 : 0;
        $use_warrior = isset($_POST['use_warrior']) ? 1 : 0;
        $use_fencer = isset($_POST['use_fencer']) ? 1 : 0;
        $use_lancer = isset($_POST['use_lancer']) ? 1 : 0;
        
        // Stat bonuses
        $add_str = (int)$_POST['add_str'];
        $add_con = (int)$_POST['add_con'];
        $add_dex = (int)$_POST['add_dex'];
        $add_int = (int)$_POST['add_int'];
        $add_wis = (int)$_POST['add_wis'];
        $add_cha = (int)$_POST['add_cha'];
        $add_hp = (int)$_POST['add_hp'];
        $add_mp = (int)$_POST['add_mp'];
        $add_hpr = (int)$_POST['add_hpr'];
        $add_mpr = (int)$_POST['add_mpr'];
        
        // Elemental resistances
        $defense_water = (int)$_POST['defense_water'];
        $defense_wind = (int)$_POST['defense_wind'];
        $defense_fire = (int)$_POST['defense_fire'];
        $defense_earth = (int)$_POST['defense_earth'];
        
        // Handle icon upload
        $iconId = null;
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadedIcon = handleUploadedIcon($_FILES['icon']);
                if ($uploadedIcon) {
                    $iconId = pathinfo($uploadedIcon, PATHINFO_FILENAME);
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }
        
        // Other fields
        $note = sanitizeInput($conn, $_POST['note']);
        
        // Prepare insert query
        $query = "INSERT INTO armor (
                  item_id, item_name_id, desc_en, desc_kr, itemGrade, type, 
                  grade, material, weight, ac, safenchant, iconId,
                  use_royal, use_knight, use_mage, use_elf, use_darkelf,
                  use_dragonknight, use_illusionist, use_warrior, use_fencer, use_lancer,
                  add_str, add_con, add_dex, add_int, add_wis, add_cha,
                  add_hp, add_mp, add_hpr, add_mpr,
                  defense_water, defense_wind, defense_fire, defense_earth,
                  note
                ) VALUES (
                  ?, ?, ?, ?, ?, ?, 
                  ?, ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?, ?,
                  ?, ?, ?, ?,
                  ?, ?, ?, ?,
                  ?
                )";
                
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param(
            "isssssisissiiiiiiiiiiiiiiiiiiiiiiiiis", 
            $item_id, $item_name_id, $desc_en, $desc_kr, $itemGrade, $type, 
            $grade, $material, $weight, $ac, $safenchant, $iconId,
            $use_royal, $use_knight, $use_mage, $use_elf, $use_darkelf,
            $use_dragonknight, $use_illusionist, $use_warrior, $use_fencer, $use_lancer,
            $add_str, $add_con, $add_dex, $add_int, $add_wis, $add_cha,
            $add_hp, $add_mp, $add_hpr, $add_mpr,
            $defense_water, $defense_wind, $defense_fire, $defense_earth,
            $note
        );
        
        // Execute query
        if ($stmt->execute()) {
            // Log the action
            logDatabaseAction($conn, 'CREATE', $item_id, "New armor item created");
            
            // Set success message
            $_SESSION['success_message'] = "New armor item created successfully!";
            
            // Redirect to view the new item
            header("Location: view_armor.php?id=$item_id");
            exit;
        } else {
            throw new Exception("Error adding record: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Store error message in session
        $_SESSION['error_message'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Armor Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Armor List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Armor</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <h2>Add New Armor Item</h2>
            </div>
            <div class="card-body">
                <?php 
                // Display error and success messages
                displayErrorMessages(); 
                displaySuccessMessages();
                ?>

                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="item_id" value="<?php echo $nextId; ?>">
                    
                    <!-- Form content remains the same as the original add_armor.php -->
                    <!-- Include your original form fields here -->
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Armor Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Close connection
$conn->close(); 
?>