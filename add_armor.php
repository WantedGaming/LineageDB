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
            "isssssisissiiiiiiiiiiiiiiiiiiiiiiis", 
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

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="armor_list.php">Armor List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Armor</li>
        </ol>
    </nav>

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
                <input type="hidden" name="item_id" value="<?php echo $nextId; ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4>Basic Information</h4>
                        <div class="mb-3">
                            <label for="item_name_id" class="form-label">Item Name ID</label>
                            <input type="text" class="form-control" id="item_name_id" name="item_name_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="desc_en" class="form-label">Description (EN)</label>
                            <input type="text" class="form-control" id="desc_en" name="desc_en" required>
                        </div>
                        <div class="mb-3">
                            <label for="desc_kr" class="form-label">Description (KR)</label>
                            <input type="text" class="form-control" id="desc_kr" name="desc_kr">
                        </div>
                        <div class="mb-3">
                            <label for="itemGrade" class="form-label">Item Grade</label>
                            <select class="form-select" id="itemGrade" name="itemGrade" required>
                                <option value="NORMAL">NORMAL</option>
                                <option value="ADVANC">ADVANC</option>
                                <option value="RARE">RARE</option>
                                <option value="HERO">HERO</option>
                                <option value="LEGEND">LEGEND</option>
                                <option value="MYTH">MYTH</option>
                                <option value="ONLY">ONLY</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="NONE">NONE</option>
                                <option value="HELMET">HELMET</option>
                                <option value="ARMOR">ARMOR</option>
                                <option value="T_SHIRT">T_SHIRT</option>
                                <option value="CLOAK">CLOAK</option>
                                <option value="GLOVE">GLOVE</option>
                                <option value="BOOTS">BOOTS</option>
                                <option value="SHIELD">SHIELD</option>
                                <option value="AMULET">AMULET</option>
                                <option value="RING">RING</option>
                                <option value="BELT">BELT</option>
                                <option value="RING_2">RING_2</option>
                                <option value="EARRING">EARRING</option>
                                <option value="GARDER">GARDER</option>
                                <option value="PENDANT">PENDANT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="material" class="form-label">Material</label>
                            <select class="form-select" id="material" name="material" required>
                                <option value="NONE(-)">NONE(-)</option>
                                <option value="CLOTH(천)">CLOTH(천)</option>
                                <option value="LEATHER(가죽)">LEATHER(가죽)</option>
                                <option value="IRON(철)">IRON(철)</option>
                                <option value="METAL(금속)">METAL(금속)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>Armor Properties</h4>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Level</label>
                            <input type="number" class="form-control" id="grade" name="grade" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="ac" class="form-label">AC</label>
                            <input type="number" class="form-control" id="ac" name="ac" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="safenchant" class="form-label">Safe Enchant</label>
                            <input type="number" class="form-control" id="safenchant" name="safenchant" value="0" required>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4>Class Restrictions</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_royal" name="use_royal">
                                    <label class="form-check-label" for="use_royal">Royal</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_knight" name="use_knight">
                                    <label class="form-check-label" for="use_knight">Knight</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_mage" name="use_mage">
                                    <label class="form-check-label" for="use_mage">Mage</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_elf" name="use_elf">
                                    <label class="form-check-label" for="use_elf">Elf</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_darkelf" name="use_darkelf">
                                    <label class="form-check-label" for="use_darkelf">Dark Elf</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_dragonknight" name="use_dragonknight">
                                    <label class="form-check-label" for="use_dragonknight">Dragon Knight</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_illusionist" name="use_illusionist">
                                    <label class="form-check-label" for="use_illusionist">Illusionist</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_warrior" name="use_warrior">
                                    <label class="form-check-label" for="use_warrior">Warrior</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_fencer" name="use_fencer">
                                    <label class="form-check-label" for="use_fencer">Fencer</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="use_lancer" name="use_lancer">
                                    <label class="form-check-label" for="use_lancer">Lancer</label>
                                </div>
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
                                    <input type="number" class="form-control" id="add_str" name="add_str" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="add_dex" class="form-label">DEX</label>
                                    <input type="number" class="form-control" id="add_dex" name="add_dex" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="add_con" class="form-label">CON</label>
                                    <input type="number" class="form-control" id="add_con" name="add_con" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="add_int" class="form-label">INT</label>
                                    <input type="number" class="form-control" id="add_int" name="add_int" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="add_wis" class="form-label">WIS</label>
                                    <input type="number" class="form-control" id="add_wis" name="add_wis" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="add_cha" class="form-label">CHA</label>
                                    <input type="number" class="form-control" id="add_cha" name="add_cha" value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="add_hp" class="form-label">HP</label>
                                    <input type="number" class="form-control" id="add_hp" name="add_hp" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="add_mp" class="form-label">MP</label>
                                    <input type="number" class="form-control" id="add_mp" name="add_mp" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="add_hpr" class="form-label">HP Regen</label>
                                    <input type="number" class="form-control" id="add_hpr" name="add_hpr" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="add_mpr" class="form-label">MP Regen</label>
                                    <input type="number" class="form-control" id="add_mpr" name="add_mpr" value="0">
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
                                    <input type="number" class="form-control" id="defense_water" name="defense_water" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="defense_wind" class="form-label">Wind</label>
                                    <input type="number" class="form-control" id="defense_wind" name="defense_wind" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="defense_fire" class="form-label">Fire</label>
                                    <input type="number" class="form-control" id="defense_fire" name="defense_fire" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="defense_earth" class="form-label">Earth</label>
                                    <input type="number" class="form-control" id="defense_earth" name="defense_earth" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="file" class="form-control" id="icon" name="icon" accept="image/png,image/jpeg,image/gif">
                </div>
                
                <div class="mb-3">
                    <label for="note" class="form-label">Notes</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="armor_list.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Armor Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>