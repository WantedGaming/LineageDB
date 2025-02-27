<?php
// add_weapon.php - Add new weapon item
session_start();
require_once 'database.php';
require_once 'crud_functions.php';

// Page setup
$page_title = "Add New Weapon Item";
include 'header.php';

// Find the next available item_id
$nextId = generateUniqueItemId($conn, 'weapon');

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
        $material = sanitizeInput($conn, $_POST['material']);
        $weight = (int)$_POST['weight'];
        $dmg_small = (int)$_POST['dmg_small'];
        $dmg_large = (int)$_POST['dmg_large'];
        $safenchant = (int)$_POST['safenchant'];
        $min_lvl = (int)$_POST['min_lvl'];
        $max_lvl = (int)$_POST['max_lvl'];
        
        // Validate input
        $validationErrors = validateWeaponInput([
            'desc_en' => $desc_en,
            'type' => $type,
            'dmg_small' => $dmg_small,
            'dmg_large' => $dmg_large
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
        
        // Combat stats
        $hitmodifier = (int)$_POST['hitmodifier'];
        $dmgmodifier = (int)$_POST['dmgmodifier'];
        $double_dmg_chance = (int)$_POST['double_dmg_chance'];
        
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
        $query = "INSERT INTO weapon (
                  item_id, item_name_id, desc_en, desc_kr, itemGrade, type, 
                  material, weight, dmg_small, dmg_large, safenchant, min_lvl, max_lvl, iconId,
                  use_royal, use_knight, use_mage, use_elf, use_darkelf,
                  use_dragonknight, use_illusionist, use_warrior, use_fencer, use_lancer,
                  add_str, add_con, add_dex, add_int, add_wis, add_cha,
                  add_hp, add_mp, add_hpr, add_mpr,
                  hitmodifier, dmgmodifier, double_dmg_chance,
                  note
                ) VALUES (
                  ?, ?, ?, ?, ?, ?, 
                  ?, ?, ?, ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?,
                  ?, ?, ?, ?, ?, ?,
                  ?, ?, ?, ?,
                  ?, ?, ?,
                  ?
                )";
                
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param(
            "issssssiiiiiiiiiiiiiiiiiiiiiiiiiiis", 
            $item_id, $item_name_id, $desc_en, $desc_kr, $itemGrade, $type, 
            $material, $weight, $dmg_small, $dmg_large, $safenchant, $min_lvl, $max_lvl, $iconId,
            $use_royal, $use_knight, $use_mage, $use_elf, $use_darkelf,
            $use_dragonknight, $use_illusionist, $use_warrior, $use_fencer, $use_lancer,
            $add_str, $add_con, $add_dex, $add_int, $add_wis, $add_cha,
            $add_hp, $add_mp, $add_hpr, $add_mpr,
            $hitmodifier, $dmgmodifier, $double_dmg_chance,
            $note
        );
        
        // Execute query
        if ($stmt->execute()) {
            // Log the action
            logDatabaseAction($conn, 'CREATE', $item_id, "New weapon item created");
            
            // Set success message
            $_SESSION['success_message'] = "New weapon item created successfully!";
            
            // Redirect to view the new item
            header("Location: view_weapon.php?id=$item_id");
            exit;
        } else {
            throw new Exception("Error adding record: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Store error message in session
        $_SESSION['error_message'] = $e->getMessage();
    }
}

// Add weapon validation function to crud_functions
if (!function_exists('validateWeaponInput')) {
    function validateWeaponInput($weaponData) {
        $errors = [];

        // Basic validation rules
        if (empty($weaponData['desc_en'])) {
            $errors[] = "English description is required.";
        }

        if (empty($weaponData['type'])) {
            $errors[] = "Weapon type is required.";
        }

        if (!is_numeric($weaponData['dmg_small']) || $weaponData['dmg_small'] < 0) {
            $errors[] = "Invalid minimum damage value.";
        }

        if (!is_numeric($weaponData['dmg_large']) || $weaponData['dmg_large'] < 0) {
            $errors[] = "Invalid maximum damage value.";
        }

        return $errors;
    }
}
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="weapon_list.php">Weapon List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Weapon</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h2><i class="bi bi-sword me-2"></i>Add New Weapon Item</h2>
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
                                <option value="SWORD">SWORD</option>
                                <option value="DAGGER">DAGGER</option>
                                <option value="TOHAND_SWORD">TOHAND_SWORD</option>
                                <option value="BOW">BOW</option>
                                <option value="SPEAR">SPEAR</option>
                                <option value="BLUNT">BLUNT</option>
                                <option value="STAFF">STAFF</option>
                                <option value="CLAW">CLAW</option>
                                <option value="AXE">AXE</option>
                                <option value="TOHAND_BLUNT">TOHAND_BLUNT</option>
                                <option value="TOHAND_STAFF">TOHAND_STAFF</option>
                                <option value="KIRINGKU">KIRINGKU</option>
                                <option value="CHAINSWORD">CHAINSWORD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="material" class="form-label">Material</label>
                            <select class="form-select" id="material" name="material" required>
                                <option value="NONE(-)">NONE(-)</option>
                                <option value="IRON(철)">IRON(철)</option>
                                <option value="STEEL(강철)">STEEL(강철)</option>
                                <option value="MITHRIL(미스릴)">MITHRIL(미스릴)</option>
                                <option value="ORIHARUKON(오리하르콘)">ORIHARUKON(오리하르콘)</option>
                                <option value="GOLD(금)">GOLD(금)</option>
                                <option value="SILVER(은)">SILVER(은)</option>
                                <option value="COPPER(구리)">COPPER(구리)</option>
                                <option value="WOOD(목재)">WOOD(목재)</option>
                                <option value="BONE(뼈)">BONE(뼈)</option>
                                <option value="PAPER(종이)">PAPER(종이)</option>
                                <option value="CLOTH(천)">CLOTH(천)</option>
                                <option value="LEATHER(가죽)">LEATHER(가죽)</option>
                                <option value="STONE(돌)">STONE(돌)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4>Weapon Properties</h4>
                        <div class="mb-3">
                            <label for="dmg_small" class="form-label">Minimum Damage</label>
                            <input type="number" class="form-control" id="dmg_small" name="dmg_small" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="dmg_large" class="form-label">Maximum Damage</label>
                            <input type="number" class="form-control" id="dmg_large" name="dmg_large" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" id="weight" name="weight" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="safenchant" class="form-label">Safe Enchant</label>
                            <input type="number" class="form-control" id="safenchant" name="safenchant" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="min_lvl" class="form-label">Minimum Level</label>
                            <input type="number" class="form-control" id="min_lvl" name="min_lvl" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="max_lvl" class="form-label">Maximum Level</label>
                            <input type="number" class="form-control" id="max_lvl" name="max_lvl" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4>Combat Stats</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="hitmodifier" class="form-label">Hit Modifier</label>
                                    <input type="number" class="form-control" id="hitmodifier" name="hitmodifier" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dmgmodifier" class="form-label">Damage Modifier</label>
                                    <input type="number" class="form-control" id="dmgmodifier" name="dmgmodifier" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="double_dmg_chance" class="form-label">Double Damage Chance</label>
                                    <input type="number" class="form-control" id="double_dmg_chance" name="double_dmg_chance" value="0">
                                </div>
                            </div>
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
                
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="file" class="form-control" id="icon" name="icon" accept="image/png,image/jpeg,image/gif">
                </div>
                
                <div class="mb-3">
                    <label for="note" class="form-label">Notes</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="weapon_list.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Weapon Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
