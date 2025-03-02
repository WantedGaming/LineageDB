<?php
// view_polymorph.php - Detailed view of a specific polymorph
require_once 'database.php';

// Get polymorph ID from URL
$polymorph_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($polymorph_id <= 0) {
    // Redirect to list if no valid ID provided
    header('Location: polymorph_list.php');
    exit;
}

// Query to get polymorph details
$query = "SELECT p.*, 
                 pi.itemId, pi.duration, pi.type as poly_type, pi.delete as is_delete,
                 pw.weapon as weapon_restriction, 
                 ei.item_name_id, ei.iconId as item_icon, ei.desc_kr as item_desc
          FROM polymorphs p
          LEFT JOIN polyitems pi ON p.polyid = pi.polyId
          LEFT JOIN polyweapon pw ON p.polyid = pw.polyId
          LEFT JOIN etcitem ei ON pi.itemId = ei.item_id
          WHERE p.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $polymorph_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Polymorph not found, redirect to list
    header('Location: polymorph_list.php');
    exit;
}

$polymorph = $result->fetch_assoc();
$page_title = "{$polymorph['name']} - Polymorph Details";
include 'header.php';

// Decode weapon equipment restrictions
$weapon_bit_values = array(
    0 => 'None',
    1 => 'Sword',
    2 => 'Dagger',
    4 => 'Two-Handed Sword',
    8 => 'Staff',
    16 => 'Spear',
    32 => 'Axe',
    64 => 'Lance',
    128 => 'Claw',
    256 => 'Bow',
    512 => 'Gauntlets',
    1024 => 'Shield',
    2048 => 'Unused',
    4096 => 'Unused'
);

$weapons_allowed = [];
$weapon_value = $polymorph['weaponequip'];
foreach ($weapon_bit_values as $bit => $name) {
    if ($bit > 0 && ($weapon_value & $bit)) {
        $weapons_allowed[] = $name;
    }
}

// Decode armor equipment restrictions
$armor_bit_values = array(
    0 => 'None',
    1 => 'Helmet',
    2 => 'Armor',
    4 => 'T-Shirt',
    8 => 'Cloak',
    16 => 'Gloves',
    32 => 'Boots',
    64 => 'Shield',
    128 => 'Amulet',
    256 => 'Ring',
    512 => 'Belt',
    1024 => 'Ring2',
    2048 => 'Earring',
    4096 => 'Unused'
);

$armor_allowed = [];
$armor_value = $polymorph['armorequip'];
foreach ($armor_bit_values as $bit => $name) {
    if ($bit > 0 && ($armor_value & $bit)) {
        $armor_allowed[] = $name;
    }
}

// Function to get polymorph stats based on ID or level/tier
function getPolymorphStats($polyid, $minlevel) {
    // Base stats - these would typically be stored in a database or config file
    // For this example, we'll use placeholder logic
    $base_stats = [
        'str' => 0,
        'dex' => 0,
        'con' => 0,
        'int' => 0,
        'wis' => 0,
        'cha' => 0,
        'hp' => 0,
        'mp' => 0,
        'ac' => 0,
        'mr' => 0,
        'damage_reduction' => 0,
        'hit_bonus' => 0
    ];
    
    // Adjust stats based on level tier
    if ($minlevel >= 90) {
        $base_stats['str'] += 5;
        $base_stats['dex'] += 5;
        $base_stats['con'] += 5;
        $base_stats['hp'] += 300;
        $base_stats['damage_reduction'] += 15;
        $base_stats['hit_bonus'] += 15;
    } elseif ($minlevel >= 80) {
        $base_stats['str'] += 4;
        $base_stats['dex'] += 4;
        $base_stats['con'] += 4;
        $base_stats['hp'] += 250;
        $base_stats['damage_reduction'] += 12;
        $base_stats['hit_bonus'] += 12;
    } elseif ($minlevel >= 70) {
        $base_stats['str'] += 3;
        $base_stats['dex'] += 3;
        $base_stats['con'] += 3;
        $base_stats['hp'] += 200;
        $base_stats['damage_reduction'] += 10;
        $base_stats['hit_bonus'] += 10;
    } elseif ($minlevel >= 60) {
        $base_stats['str'] += 2;
        $base_stats['dex'] += 2;
        $base_stats['con'] += 2;
        $base_stats['hp'] += 150;
        $base_stats['damage_reduction'] += 8;
        $base_stats['hit_bonus'] += 8;
    } elseif ($minlevel >= 50) {
        $base_stats['str'] += 1;
        $base_stats['dex'] += 1;
        $base_stats['con'] += 1;
        $base_stats['hp'] += 100;
        $base_stats['damage_reduction'] += 5;
        $base_stats['hit_bonus'] += 5;
    }
    
    // PVP bonus for certain polymorphs
    if (strpos($polyid, 'jin') !== false || stripos($polyid, 'pvp') !== false) {
        $base_stats['damage_reduction'] += 5;
        $base_stats['hit_bonus'] += 5;
    }
    
    return $base_stats;
}

// Get estimated stats - in a real implementation, these would be pulled from a database
$estimated_stats = getPolymorphStats($polymorph['name'], $polymorph['minlevel']);

// Fetch related polymorphs in the same series
$related_query = "SELECT id, name, polyid, minlevel 
                  FROM polymorphs 
                  WHERE (name LIKE ? OR 
                        (name LIKE ? AND name LIKE ?))
                  AND id != ?
                  ORDER BY minlevel ASC
                  LIMIT 6";

// Create search patterns
$basic_name = preg_replace('/^(lv\d+\s+|lv\d+)/i', '', $polymorph['name']);
$basic_name = trim(preg_replace('/\s+(knight|assassin|ranger|magister|scouter|shadow|master).*$/i', '', $basic_name));

$stmt = $conn->prepare($related_query);
$pattern1 = "%" . $basic_name . "%";
$pattern2 = "%lv%";
$pattern3 = "%" . $basic_name . "%";
$stmt->bind_param('sssi', $pattern1, $pattern2, $pattern3, $polymorph_id);
$stmt->execute();
$related_result = $stmt->get_result();
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="polymorph_list.php">Polymorphs</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($polymorph['name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Polymorph Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <?php echo htmlspecialchars($polymorph['name']); ?>
                    </h4>
                    <span class="badge bg-light text-dark">
                        ID: <?php echo htmlspecialchars($polymorph['polyid']); ?>
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-5 text-center">
                            <?php 
                            // Check for item icon
                            $iconPath = !empty($polymorph['item_icon']) 
                                ? "icons/icon_{$polymorph['item_icon']}.png" 
                                : null;
                            
                            // Check for sprite image
                            $spritePath = "icons/ms{$polymorph['polyid']}.png";
                            
                            if ($iconPath && file_exists($iconPath)): 
                            ?>
                                <img src="<?php echo $iconPath; ?>" 
                                     alt="<?php echo htmlspecialchars($polymorph['name']); ?>" 
                                     class="img-fluid mx-auto d-block" 
                                     style="max-height: 200px; max-width: 200px;">
                            <?php elseif (file_exists($spritePath)): ?>
                                <img src="<?php echo $spritePath; ?>" 
                                     alt="<?php echo htmlspecialchars($polymorph['name']); ?>" 
                                     class="img-fluid mx-auto d-block" 
                                     style="max-height: 200px; max-width: 200px;">
                            <?php else: ?>
                                <div class="text-muted text-center p-5">
                                    <i class="bi bi-person-fill" style="font-size: 5rem;"></i>
                                    <p class="mt-2">No image available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 40%;">Minimum Level</th>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $polymorph['minlevel'] >= 80 ? 'danger' : 
                                                    ($polymorph['minlevel'] >= 50 ? 'warning' : 'success'); 
                                            ?>">
                                                <?php echo htmlspecialchars($polymorph['minlevel']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Skills Usable</th>
                                        <td>
                                            <?php if ($polymorph['isSkillUse'] == 1): ?>
                                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Yes</span>
                                            <?php else: ?>
                                                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> No</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Long Range Attacks</th>
                                        <td>
                                            <?php if ($polymorph['formLongEnable'] == 'true'): ?>
                                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Enabled</span>
                                            <?php else: ?>
                                                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Disabled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PVP Bonus</th>
                                        <td>
                                            <?php if ($polymorph['bonusPVP'] == 'true'): ?>
                                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Yes</span>
                                            <?php else: ?>
                                                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> No</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Weapon Restriction</th>
                                        <td>
                                            <?php 
                                            if (!empty($polymorph['weapon_restriction'])) {
                                                echo htmlspecialchars(ucfirst($polymorph['weapon_restriction']));
                                            } elseif (!empty($weapons_allowed)) {
                                                echo implode(', ', $weapons_allowed);
                                            } else {
                                                echo 'None';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Equipment & Stats Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-shield-fill me-2"></i>Equipment Restrictions
                            </h5>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold">Weapon Equip Value: <?php echo $polymorph['weaponequip']; ?></h6>
                                <?php if (!empty($weapons_allowed)): ?>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <?php foreach ($weapons_allowed as $weapon): ?>
                                        <span class="badge bg-secondary"><?php echo $weapon; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                    <p class="text-muted">No weapons can be equipped</p>
                                <?php endif; ?>
                            </div>
                            
                            <div>
                                <h6 class="fw-bold">Armor Equip Value: <?php echo $polymorph['armorequip']; ?></h6>
                                <?php if (!empty($armor_allowed)): ?>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    <?php foreach ($armor_allowed as $armor): ?>
                                        <span class="badge bg-secondary"><?php echo $armor; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                    <p class="text-muted">No armor can be equipped</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-graph-up me-2"></i>Estimated Stats
                            </h5>
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <small class="text-muted">STR</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" style="width: <?php echo min(100, $estimated_stats['str'] * 5); ?>%"></div>
                                        </div>
                                        <small class="float-end"><?php echo $estimated_stats['str']; ?></small>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">DEX</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: <?php echo min(100, $estimated_stats['dex'] * 5); ?>%"></div>
                                        </div>
                                        <small class="float-end"><?php echo $estimated_stats['dex']; ?></small>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">CON</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: <?php echo min(100, $estimated_stats['con'] * 5); ?>%"></div>
                                        </div>
                                        <small class="float-end"><?php echo $estimated_stats['con']; ?></small>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="mb-2">
                                        <small class="text-muted">HP Bonus</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" style="width: <?php echo min(100, $estimated_stats['hp'] / 5); ?>%"></div>
                                        </div>
                                        <small class="float-end">+<?php echo $estimated_stats['hp']; ?></small>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">Damage Reduction</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-info" style="width: <?php echo min(100, $estimated_stats['damage_reduction'] * 4); ?>%"></div>
                                        </div>
                                        <small class="float-end"><?php echo $estimated_stats['damage_reduction']; ?>%</small>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">Hit Bonus</small>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: <?php echo min(100, $estimated_stats['hit_bonus'] * 4); ?>%"></div>
                                        </div>
                                        <small class="float-end">+<?php echo $estimated_stats['hit_bonus']; ?></small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="small text-muted mt-2">
                                <i class="bi bi-info-circle"></i> 
                                These are estimated stats based on polymorph level and type.
                                Actual in-game values may vary.
                            </div>
                        </div>
                    </div>

                    <!-- Polymorph Source Section -->
                    <?php if (!empty($polymorph['itemId'])): ?>
                    <div class="mt-4">
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="bi bi-box me-2"></i>Polymorph Source
                        </h5>
                        
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <?php 
                                        $item_icon = "icons/icon_{$polymorph['item_icon']}.png";
                                        if (file_exists($item_icon)): 
                                        ?>
                                            <img src="<?php echo $item_icon; ?>" 
                                                alt="Item Icon" 
                                                class="img-fluid" 
                                                style="max-width: 64px;">
                                        <?php else: ?>
                                            <div class="text-muted">
                                                <i class="bi bi-question-circle" style="font-size: 3rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="col-md-7">
                                        <h6 class="mb-1">Item ID: <?php echo $polymorph['itemId']; ?></h6>
                                        <p class="mb-0">
                                            <?php echo !empty($polymorph['item_desc']) ? 
                                                htmlspecialchars($polymorph['item_desc']) : 
                                                'Polymorph scroll or item'; ?>
                                        </p>
                                        
                                        <div class="small text-muted mt-2">
                                            <div><strong>Duration:</strong> <?php echo $polymorph['duration'] ?? 1800; ?> seconds</div>
                                            <div><strong>Type:</strong> <?php echo ucfirst($polymorph['poly_type'] ?? 'normal'); ?></div>
                                            <div><strong>Consumed on use:</strong> 
                                                <?php echo ($polymorph['is_delete'] ?? 'true') === 'true' ? 'Yes' : 'No'; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 text-end">
                                        <a href="items.php?id=<?php echo $polymorph['itemId']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-search me-1"></i>View Item
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Related Polymorphs -->
            <?php if ($related_result->num_rows > 0): ?>
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Related Polymorphs</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while($related = $related_result->fetch_assoc()): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <?php 
                                        $rel_sprite = "icons/ms{$related['polyid']}.png";
                                        if (file_exists($rel_sprite)): 
                                        ?>
                                            <img src="<?php echo $rel_sprite; ?>" 
                                                alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                                class="me-3" 
                                                style="width: 40px; height: 40px;">
                                        <?php else: ?>
                                            <div class="me-3 text-center" style="width: 40px;">
                                                <i class="bi bi-person-fill text-secondary" style="font-size: 1.8rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($related['name']); ?></h6>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-<?php 
                                                    echo $related['minlevel'] >= 80 ? 'danger' : 
                                                        ($related['minlevel'] >= 50 ? 'warning' : 'success'); 
                                                ?> me-2">
                                                    Lv.<?php echo $related['minlevel']; ?>
                                                </span>
                                                <small class="text-muted">ID: <?php echo $related['polyid']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer p-0 bg-transparent border-0">
                                    <a href="view_polymorph.php?id=<?php echo $related['id']; ?>" class="btn btn-sm btn-link w-100">
                                        View Details <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="col-lg-4">
            <!-- Polymorph Series Card (if applicable) -->
            <?php
            $tier_indicators = [
                'black' => 'Dark',
                'dark' => 'Dark',
                'silver' => 'Silver',
                'gold' => 'Gold',
                'platinum' => 'Platinum',
                'arch' => 'Arch'
            ];
            
            $series_type = null;
            foreach(['knight', 'shadow', 'scouter', 'magister', 'assassin', 'ranger', 'death knight', 'lance master'] as $type) {
                if (stripos($polymorph['name'], $type) !== false) {
                    $series_type = $type;
                    break;
                }
            }
            
            $tier = null;
            foreach($tier_indicators as $key => $value) {
                if (stripos($polymorph['name'], $key) !== false) {
                    $tier = $value;
                    break;
                }
            }
            
            if ($series_type && $tier):
            ?>
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Polymorph Series Information</h5>
                </div>
                <div class="card-body">
                    <h6 class="border-bottom pb-2"><?php echo ucfirst($series_type); ?> Series</h6>
                    
                    <div class="mb-3">
                        <p>
                            The <?php echo ucfirst($series_type); ?> series includes various level tiers
                            that offer progressively better stats and abilities.
                        </p>
                        
                        <div class="d-flex flex-column">
                            <div class="badge bg-dark mb-2 p-2 text-start">
                                <i class="bi bi-shield-fill me-2"></i>Dark Tier (Level 52-55)
                            </div>
                            <div class="badge bg-secondary mb-2 p-2 text-start">
                                <i class="bi bi-shield-fill me-2"></i>Silver Tier (Level 60-65)
                            </div>
                            <div class="badge bg-warning text-dark mb-2 p-2 text-start">
                                <i class="bi bi-shield-fill me-2"></i>Gold Tier (Level 70-75)
                            </div>
                            <div class="badge bg-info mb-2 p-2 text-start">
                                <i class="bi bi-shield-fill me-2"></i>Platinum/Jin Tier (Level 80-87)
                            </div>
                            <div class="badge bg-danger mb-2 p-2 text-start">
                                <i class="bi bi-shield-fill me-2"></i>Arch/Special Tier (Level 90+)
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            This polymorph belongs to the <strong><?php echo $tier; ?></strong> tier.
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- How to Obtain Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">How to Obtain</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($polymorph['itemId'])): ?>
                        <p>This polymorph can be obtained from the following sources:</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-primary me-2">
                                    <i class="bi bi-box"></i>
                                </span>
                                <span>Polymorph scroll (Item ID: <?php echo $polymorph['itemId']; ?>)</span>
                            </li>
                            <?php if ($polymorph['minlevel'] <= 30): ?>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-success me-2">
                                    <i class="bi bi-shop"></i>
                                </span>
                                <span>NPC Shops in major towns</span>
                            </li>
                            <?php elseif ($polymorph['minlevel'] <= 60): ?>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-danger me-2">
                                    <i class="bi bi-droplet-fill"></i>
                                </span>
                                <span>Monster drops in level <?php echo $polymorph['minlevel']; ?>+ areas</span>
                            </li>
                            <?php elseif ($polymorph['minlevel'] <= 80): ?>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-warning text-dark me-2">
                                    <i class="bi bi-trophy-fill"></i>
                                </span>
                                <span>Boss drops and special events</span>
                            </li>
                            <?php else: ?>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-danger me-2">
                                    <i class="bi bi-trophy-fill"></i>
                                </span>
                                <span>Raid bosses and high-level dungeons</span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            No specific item source found for this polymorph. It may be:
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-secondary me-2">
                                    <i class="bi bi-magic"></i>
                                </span>
                                <span>From a special event or promotion</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-secondary me-2">
                                    <i class="bi bi-gear-fill"></i>
                                </span>
                                <span>Internal game functionality or GM command</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <span class="badge bg-secondary me-2">
                                    <i class="bi bi-clock-history"></i>
                                </span>
                                <span>Legacy content no longer available</span>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Tips & Info Card -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tips & Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">
                            <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Advantages
                        </h6>
                        <ul class="mb-0 ps-3">
                            <?php if ($polymorph['isSkillUse'] == 1): ?>
                                <li>Allows use of skills while transformed</li>
                            <?php endif; ?>
                            
                            <?php if ($polymorph['formLongEnable'] == 'true'): ?>
                                <li>Enables long-range attacks</li>
                            <?php endif; ?>
                            
                            <?php if ($polymorph['bonusPVP'] == 'true'): ?>
                                <li>Provides PVP damage bonuses</li>
                            <?php endif; ?>
                            
                            <?php if (!empty($weapons_allowed)): ?>
                                <li>Can equip <?php echo strtolower(implode(', ', $weapons_allowed)); ?></li>
                            <?php endif; ?>
                            
                            <?php if ($polymorph['minlevel'] >= 70): ?>
                                <li>High-tier polymorph with enhanced stats</li>
                            <?php elseif ($polymorph['minlevel'] <= 30): ?>
                                <li>Low-level requirement makes it accessible for beginners</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div>
                        <h6 class="fw-bold">
                            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Limitations
                        </h6>
                        <ul class="mb-0 ps-3">
                            <?php if ($polymorph['isSkillUse'] != 1): ?>
                                <li>Cannot use skills while transformed</li>
                            <?php endif; ?>
                            
                            <?php if ($polymorph['formLongEnable'] != 'true'): ?>
                                <li>Cannot use long-range attacks</li>
                            <?php endif; ?>
                            
                            <?php if (count($weapons_allowed) <= 3 && !empty($weapons_allowed)): ?>
                                <li>Limited weapon selection (<?php echo strtolower(implode(', ', $weapons_allowed)); ?> only)</li>
                            <?php elseif (empty($weapons_allowed)): ?>
                                <li>Cannot equip any weapons</li>
                            <?php endif; ?>
                            
                            <?php if ($polymorph['minlevel'] > 1): ?>
                                <li>Requires character level <?php echo $polymorph['minlevel']; ?> or higher</li>
                            <?php endif; ?>
                            
                            <?php if (!empty($polymorph['duration']) && $polymorph['duration'] < 3600): ?>
                                <li>Limited duration (<?php echo floor($polymorph['duration']/60); ?> minutes)</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Community Notes -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Community Notes</h5>
                </div>
                <div class="card-body">
                    <!-- This would typically be populated from a user comments system -->
                    <div class="alert alert-secondary">
                        <i class="bi bi-people-fill me-2"></i>
                        No community notes available yet. Be the first to contribute!
                    </div>
                    
                    <!-- Placeholder for adding notes -->
                    <form class="mt-3">
                        <div class="form-group mb-3">
                            <label for="communityNote" class="form-label">Add a Note</label>
                            <textarea class="form-control" id="communityNote" rows="3" placeholder="Share your experience with this polymorph..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="alert('Feature coming soon!')">
                            <i class="bi bi-send me-1"></i>Submit Note
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
