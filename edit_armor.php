<?php
// edit_armor.php - Edit armor item with dark theme
session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Page setup
$page_title = "Edit Armor Item";
include 'header.php';

// Validate and sanitize input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Invalid armor item ID.";
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Sanitize inputs
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
        
        // Dynamically bind parameters
        $stmt->bind_param($bindTypes, ...$bindParams);
        
        // Execute query
        if ($stmt->execute()) {
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
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Armor Item</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Include your custom styles here */
        :root {
            --primary-bg: #121212;
            --secondary-bg: #1e1e1e;
            --card-bg: #252525;
            --accent-color: #B07A45;
            --accent-hover: #C18A55;
            --text-primary: #e0e0e0;
            --text-secondary: #aaaaaa;
            --border-color: #333333;
        }
        
        body {
            background-color: var(--primary-bg);
            color: var(--text-primary);
        }
        
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }
        
        .form-control, .form-select {
            background-color: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus, .form-select:focus {
            background-color: var(--secondary-bg);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(176, 122, 69, 0.25);
            color: var(--text-primary);
        }
        
        /* ... (include the rest of your custom styles) */
    </style>
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
                displayErrorMessages(); 
                displaySuccessMessages();
                ?>
				<!-- ... -->
<form method="post" action="" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Basic Information</h4>
            <div class="mb-3">
                <label for="item_id" class="form-label">Item ID</label>
                <input type="text" class="form-control" id="item_id" name="item_id" value="<?php echo htmlspecialchars($armor['item_id']); ?>" readonly>
                <div class="form-text">ID cannot be changed</div>
            </div>
            <div class="mb-3">
                <label for="item_name_id" class="form-label">Item Name ID</label>
                <input type="text" class="form-control" id="item_name_id" name="item_name_id" value="<?php echo htmlspecialchars($armor['item_name_id']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="desc_en" class="form-label">Description (EN)</label>
                <input type="text" class="form-control" id="desc_en" name="desc_en" value="<?php echo htmlspecialchars($armor['desc_en']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="desc_kr" class="form-label">Description (KR)</label>
                <input type="text" class="form-control" id="desc_kr" name="desc_kr" value="<?php echo htmlspecialchars($armor['desc_kr']); ?>">
            </div>
            <div class="mb-3">
                <label for="itemGrade" class="form-label">Item Grade</label>
                <select class="form-select" id="itemGrade" name="itemGrade" required>
                    <option value="NORMAL" <?php echo $armor['itemGrade'] == 'NORMAL' ? 'selected' : ''; ?>>NORMAL</option>
                    <option value="ADVANC" <?php echo $armor['itemGrade'] == 'ADVANC' ? 'selected' : ''; ?>>ADVANC</option>
                    <option value="RARE" <?php echo $armor['itemGrade'] == 'RARE' ? 'selected' : ''; ?>>RARE</option>
                    <option value="HERO" <?php echo $armor['itemGrade'] == 'HERO' ? 'selected' : ''; ?>>HERO</option>
                    <option value="LEGEND" <?php echo $armor['itemGrade'] == 'LEGEND' ? 'selected' : ''; ?>>LEGEND</option>
                    <option value="MYTH" <?php echo $armor['itemGrade'] == 'MYTH' ? 'selected' : ''; ?>>MYTH</option>
                    <option value="ONLY" <?php echo $armor['itemGrade'] == 'ONLY' ? 'selected' : ''; ?>>ONLY</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="NONE" <?php echo $armor['type'] == 'NONE' ? 'selected' : ''; ?>>NONE</option>
                    <option value="HELMET" <?php echo $armor['type'] == 'HELMET' ? 'selected' : ''; ?>>HELMET</option>
                    <option value="ARMOR" <?php echo $armor['type'] == 'ARMOR' ? 'selected' : ''; ?>>ARMOR</option>
                    <option value="T_SHIRT" <?php echo $armor['type'] == 'T_SHIRT' ? 'selected' : ''; ?>>T_SHIRT</option>
                    <option value="CLOAK" <?php echo $armor['type'] == 'CLOAK' ? 'selected' : ''; ?>>CLOAK</option>
                    <option value="GLOVE" <?php echo $armor['type'] == 'GLOVE' ? 'selected' : ''; ?>>GLOVE</option>
                    <option value="BOOTS" <?php echo $armor['type'] == 'BOOTS' ? 'selected' : ''; ?>>BOOTS</option>
                    <option value="SHIELD" <?php echo $armor['type'] == 'SHIELD' ? 'selected' : ''; ?>>SHIELD</option>
                    <option value="AMULET" <?php echo $armor['type'] == 'AMULET' ? 'selected' : ''; ?>>AMULET</option>
                    <option value="RING" <?php echo $armor['type'] == 'RING' ? 'selected' : ''; ?>>RING</option>
                    <option value="BELT" <?php echo $armor['type'] == 'BELT' ? 'selected' : ''; ?>>BELT</option>
                    <option value="RING_2" <?php echo $armor['type'] == 'RING_2' ? 'selected' : ''; ?>>RING_2</option>
                    <option value="EARRING" <?php echo $armor['type'] == 'EARRING' ? 'selected' : ''; ?>>EARRING</option>
                    <option value="GARDER" <?php echo $armor['type'] == 'GARDER' ? 'selected' : ''; ?>>GARDER</option>
                    <option value="PENDANT" <?php echo $armor['type'] == 'PENDANT' ? 'selected' : ''; ?>>PENDANT</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <input type="number" class="form-control" id="grade" name="grade" value="<?php echo htmlspecialchars($armor['grade']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="material" class="form-label">Material</label>
                <select class="form-select" id="material" name="material" required>
                    <option value="NONE(-)" <?php echo $armor['material'] == 'NONE(-)' ? 'selected' : ''; ?>>NONE(-)</option>
                    <option value="CLOTH(천)" <?php echo $armor['material'] == 'CLOTH(천)' ? 'selected' : ''; ?>>CLOTH(천)</option>
                    <option value="LEATHER(가죽)" <?php echo $armor['material'] == 'LEATHER(가죽)' ? 'selected' : ''; ?>>LEATHER(가죽)</option>
                    <option value="IRON(철)" <?php echo $armor['material'] == 'IRON(철)' ? 'selected' : ''; ?>>IRON(철)</option>
                    <option value="METAL(금속)" <?php echo $armor['material'] == 'METAL(금속)' ? 'selected' : ''; ?>>METAL(금속)</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <h4>Armor Properties</h4>
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="number" class="form-control" id="weight" name="weight" value="<?php echo htmlspecialchars($armor['weight']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ac" class="form-label">AC</label>
                <input type="number" class="form-control" id="ac" name="ac" value="<?php echo htmlspecialchars($armor['ac']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="safenchant" class="form-label">Safe Enchant</label>
                <input type="number" class="form-control" id="safenchant" name="safenchant" value="<?php echo htmlspecialchars($armor['safenchant']); ?>" required>
            </div>
            
            <h5>Class Restrictions</h5>
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_royal" name="use_royal" <?php echo $armor['use_royal'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_royal">Royal</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_knight" name="use_knight" <?php echo $armor['use_knight'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_knight">Knight</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_mage" name="use_mage" <?php echo $armor['use_mage'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_mage">Mage</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_elf" name="use_elf" <?php echo $armor['use_elf'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_elf">Elf</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_darkelf" name="use_darkelf" <?php echo $armor['use_darkelf'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_darkelf">Dark Elf</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_dragonknight" name="use_dragonknight" <?php echo $armor['use_dragonknight'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_dragonknight">Dragon Knight</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_illusionist" name="use_illusionist" <?php echo $armor['use_illusionist'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_illusionist">Illusionist</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_warrior" name="use_warrior" <?php echo $armor['use_warrior'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_warrior">Warrior</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_fencer" name="use_fencer" <?php echo $armor['use_fencer'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_fencer">Fencer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="use_lancer" name="use_lancer" <?php echo $armor['use_lancer'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="use_lancer">Lancer</label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-12">
            <h4>Stat Bonuses</h4>
            <div class="row">
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_str" class="form-label">STR</label>
                        <input type="number" class="form-control" id="add_str" name="add_str" value="<?php echo htmlspecialchars($armor['add_str']); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_dex" class="form-label">DEX</label>
                        <input type="number" class="form-control" id="add_dex" name="add_dex" value="<?php echo htmlspecialchars($armor['add_dex']); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_con" class="form-label">CON</label>
                        <input type="number" class="form-control" id="add_con" name="add_con" value="<?php echo htmlspecialchars($armor['add_con']); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_int" class="form-label">INT</label>
                        <input type="number" class="form-control" id="add_int" name="add_int" value="<?php echo htmlspecialchars($armor['add_int']); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_wis" class="form-label">WIS</label>
                        <input type="number" class="form-control" id="add_wis" name="add_wis" value="<?php echo htmlspecialchars($armor['add_wis']); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label for="add_cha" class="form-label">CHA</label>
                        <input type="number" class="form-control" id="add_cha" name="add_cha" value="<?php echo htmlspecialchars($armor['add_cha']); ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="add_hp" class="form-label">HP</label>
                        <input type="number" class="form-control" id="add_hp" name="add_hp" value="<?php echo htmlspecialchars($armor['add_hp']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="add_mp" class="form-label">MP</label>
                        <input type="number" class="form-control" id="add_mp" name="add_mp" value="<?php echo htmlspecialchars($armor['add_mp']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="add_hpr" class="form-label">HP Regen</label>
                        <input type="number" class="form-control" id="add_hpr" name="add_hpr" value="<?php echo htmlspecialchars($armor['add_hpr']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="add_mpr" class="form-label">MP Regen</label>
                        <input type="number" class="form-control" id="add_mpr" name="add_mpr" value="<?php echo htmlspecialchars($armor['add_mpr']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-md-12">
            <h4>Elemental Resistances</h4>
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="defense_water" class="form-label">Water</label>
                        <input type="number" class="form-control" id="defense_water" name="defense_water" value="<?php echo htmlspecialchars($armor['defense_water']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="defense_wind" class="form-label">Wind</label>
                        <input type="number" class="form-control" id="defense_wind" name="defense_wind" value="<?php echo htmlspecialchars($armor['defense_wind']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="defense_fire" class="form-label">Fire</label>
                        <input type="number" class="form-control" id="defense_fire" name="defense_fire" value="<?php echo htmlspecialchars($armor['defense_fire']); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="defense_earth" class="form-label">Earth</label>
                        <input type="number" class="form-control" id="defense_earth" name="defense_earth" value="<?php echo htmlspecialchars($armor['defense_earth']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="note" class="form-label">Notes</label>
        <textarea class="form-control" id="note" name="note" rows="3"><?php echo htmlspecialchars($armor['note']); ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="icon" class="form-label">Update Icon (Optional)</label>
        <input type="file" class="form-control" id="icon" name="icon" accept="image/png,image/jpeg,image/gif">
        <?php 
        $currentIconPath = "icons/{$armor['iconId']}.png";
        if (!empty($armor['iconId']) && file_exists($currentIconPath)): 
        ?>
            <div class="mt-2">
                <small>Current Icon:</small>
                <img src="<?php echo $currentIconPath; ?>" alt="Current Icon" style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="view_armor.php?id=<?php echo $id; ?>" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Close connection
$stmt->close();
$conn->close(); 
?>