<?php
// edit_armor.php - Edit armor item with enhanced debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Page setup
$page_title = "Edit Armor Item";
include 'header.php';

// Debug: Print all incoming data
function debugPrintData() {
    echo "<pre>";
    echo "GET Data:\n";
    print_r($_GET);
    echo "\nPOST Data:\n";
    print_r($_POST);
    echo "\nFILES Data:\n";
    print_r($_FILES);
    echo "</pre>";
}

// Validate and sanitize input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid armor item ID.";
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Debugging: print all incoming data
        // Uncomment the next line to see all submitted data
        // debugPrintData();

        // Sanitize inputs
        $item_name_id = sanitizeInput($conn, $_POST['item_name_id']);
        $desc_en = sanitizeInput($conn, $_POST['desc_en']);
        $desc_kr = sanitizeInput($conn, $_POST['desc_kr'] ?? '');
        $itemGrade = sanitizeInput($conn, $_POST['itemGrade']);
        $type = sanitizeInput($conn, $_POST['type']);
        $grade = (int)($_POST['grade'] ?? 0);
        $material = sanitizeInput($conn, $_POST['material']);
        $weight = (int)($_POST['weight'] ?? 0);
        $ac = (int)($_POST['ac'] ?? 0);
        $safenchant = (int)($_POST['safenchant'] ?? 0);
        
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
        
        // Class restrictions with null coalescing
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
        
        // Stat bonuses with null coalescing
        $add_str = (int)($_POST['add_str'] ?? 0);
        $add_con = (int)($_POST['add_con'] ?? 0);
        $add_dex = (int)($_POST['add_dex'] ?? 0);
        $add_int = (int)($_POST['add_int'] ?? 0);
        $add_wis = (int)($_POST['add_wis'] ?? 0);
        $add_cha = (int)($_POST['add_cha'] ?? 0);
        $add_hp = (int)($_POST['add_hp'] ?? 0);
        $add_mp = (int)($_POST['add_mp'] ?? 0);
        $add_hpr = (int)($_POST['add_hpr'] ?? 0);
        $add_mpr = (int)($_POST['add_mpr'] ?? 0);
        
        // Elemental resistances with null coalescing
        $defense_water = (int)($_POST['defense_water'] ?? 0);
        $defense_wind = (int)($_POST['defense_wind'] ?? 0);
        $defense_fire = (int)($_POST['defense_fire'] ?? 0);
        $defense_earth = (int)($_POST['defense_earth'] ?? 0);
        
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
        $note = sanitizeInput($conn, $_POST['note'] ?? '');
        
        // Prepare update query
        $query = "UPDATE armor SET 
                  item_name_id = ?, 
                  desc_en = ?, 
                  desc_kr = ?, 
                  itemGrade = ?, 
                  type = ?, 
                  grade = ?, 
                  material = ?, 
                  weight = ?, 
                  ac = ?, 
                  safenchant = ?, 
                  use_royal = ?,
                  use_knight = ?,
                  use_mage = ?,
                  use_elf = ?,
                  use_darkelf = ?,
                  use_dragonknight = ?,
                  use_illusionist = ?,
                  use_warrior = ?,
                  use_fencer = ?,
                  use_lancer = ?,
                  add_str = ?,
                  add_con = ?,
                  add_dex = ?,
                  add_int = ?,
                  add_wis = ?,
                  add_cha = ?,
                  add_hp = ?,
                  add_mp = ?,
                  add_hpr = ?,
                  add_mpr = ?,
                  defense_water = ?,
                  defense_wind = ?,
                  defense_fire = ?,
                  defense_earth = ?,
                  note = ?";
        
        // Add iconId to update if a new icon was uploaded
        if ($iconId !== null) {
            $query .= ", iconId = ?";
        }
        
        $query .= " WHERE item_id = ?";
                
        $stmt = $conn->prepare($query);
        
        // Prepare bind parameters
        $bindTypes = "sssssissiiiiiiiiiiiiiiiiiiiiiiiisis";
        $bindParams = [
            $item_name_id, $desc_en, $desc_kr, $itemGrade, $type, 
            $grade, $material, $weight, $ac, $safenchant,
            $use_royal, $use_knight, $use_mage, $use_elf, $use_darkelf,
            $use_dragonknight, $use_illusionist, $use_warrior, $use_fencer, $use_lancer,
            $add_str, $add_con, $add_dex, $add_int, $add_wis, $add_cha,
            $add_hp, $add_mp, $add_hpr, $add_mpr,
            $defense_water, $defense_wind, $defense_fire, $defense_earth,
            $note, $id
        ];
        
        // Add iconId to bind parameters if new icon uploaded
        if ($iconId !== null) {
            $bindTypes .= "i";
            $bindParams = array_merge(
                array_slice($bindParams, 0, -1), 
                [$iconId, $bindParams[count($bindParams) - 1]]
            );
        }
        
        // Debug: Print bind types and parameters
        // echo "Bind Types: $bindTypes<br>";
        // echo "Bind Params: <pre>" . print_r($bindParams, true) . "</pre>";
        
        // Dynamically bind parameters
        $bindResult = $stmt->bind_param($bindTypes, ...$bindParams);
        
        // Check binding result
        if ($bindResult === false) {
            throw new Exception("Parameter binding failed: " . $stmt->error);
        }
        
        // Execute query
        $executeResult = $stmt->execute();
        
        if ($executeResult) {
            // Log the action
            logDatabaseAction($conn, 'UPDATE', $id, "Armor item updated");
            
            // Set success message
            $_SESSION['success_message'] = "Armor item updated successfully!";
            
            // Redirect to view the updated item
            header("Location: view_armor.php?id=$id");
            exit;
        } else {
            throw new Exception("Error updating record: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Store error message in session
        $_SESSION['error_message'] = $e->getMessage();
        
        // Optional: Log the full error for debugging
        error_log("Edit Armor Error: " . $e->getMessage());
    }
}

// Fetch existing armor data
$query = "SELECT * FROM armor WHERE item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "No armor item found with the specified ID.";
    header('Location: index.php');
    exit;
}

$armor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Armor Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Armor List</a></li>
                <li class="breadcrumb-item"><a href="view_armor.php?id=<?php echo $id; ?>">View Armor</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Armor</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <h2>Edit Armor: <?php echo htmlspecialchars($armor['desc_en']); ?></h2>
            </div>
            <div class="card-body">
                <?php 
                // Display error and success messages
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . 
                         htmlspecialchars($_SESSION['error_message']) . 
                         '</div>';
                    unset($_SESSION['error_message']);
                }

                if (isset($_SESSION['form_errors']) && is_array($_SESSION['form_errors'])) {
                    echo '<div class="alert alert-warning">';
                    echo '<ul>';
                    foreach ($_SESSION['form_errors'] as $error) {
                        echo '<li>' . htmlspecialchars($error) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    unset($_SESSION['form_errors']);
                }
                ?>

                <form method="post" action="" enctype="multipart/form-data">
                    <!-- Rest of the form remains the same as in the previous version -->

                    <div class="d-flex justify-content-between">
                        <a href="view_armor.php?id=<?php echo $id; ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
$stmt->close();
$conn->close(); 
?>