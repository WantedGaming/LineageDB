<?php
// view_weapon.php - Detailed view of a specific weapon item
require_once 'database.php';

// Page setup
$page_title = "Weapon Details";
include 'header.php';

// Function to clean text
function cleanText($text) {
    // Remove Korean characters
    $cleaned = preg_replace('/[가-힣]/u', '', $text);
    
    // Remove content within parentheses
    $cleaned = preg_replace('/\s*\([^)]*\)/', '', $cleaned);
    
    // Remove extra spaces and trim
    $cleaned = trim(preg_replace('/\s+/', ' ', $cleaned));
    
    // Return the cleaned text, or 'N/A' if empty
    return $cleaned ?: 'N/A';
}

// Comprehensive stat mapping
$statCategories = [
    'Add Stats' => [
        'add_str' => 'Strength',
        'add_con' => 'Constitution', 
        'add_dex' => 'Dexterity',
        'add_int' => 'Intelligence', 
        'add_wis' => 'Wisdom',
        'add_cha' => 'Charisma'
    ],
    'Vitals' => [
        'add_hp' => 'HP',
        'add_mp' => 'MP',
        'add_sp' => 'SP',
        'add_hpr' => 'HP Regen',
        'add_mpr' => 'MP Regen'
    ],
    'Combat Stats' => [
        'hitmodifier' => 'Hit Modifier',
        'dmgmodifier' => 'Damage Modifier',
        'double_dmg_chance' => 'Double Damage Chance',
        'magicdmgmodifier' => 'Magic Damage Modifier',
        'shortCritical' => 'Melee Critical',
        'longCritical' => 'Ranged Critical',
        'magicCritical' => 'Magic Critical'
    ],
    'Defense' => [
        'addDg' => 'Dodge',
        'addEr' => 'Evasion',
        'addMe' => 'Mental',
        'damage_reduction' => 'Damage Reduction',
        'MagicDamageReduction' => 'Magic Damage Reduction'
    ],
    'Status Resist' => [
        'regist_skill' => 'Skill',
        'regist_spirit' => 'Spirit',
        'regist_dragon' => 'Dragon',
        'regist_fear' => 'Fear',
        'regist_all' => 'All'
    ],
    'Attack Bonus' => [
        'hitup_skill' => 'Skill',
        'hitup_spirit' => 'Spirit',
        'hitup_dragon' => 'Dragon',
        'hitup_fear' => 'Fear',
        'hitup_all' => 'All',
        'hitup_magic' => 'Magic'
    ],
    'PVP Stats' => [
        'PVPDamage' => 'PVP Damage',
        'PVPDamageReduction' => 'PVP Damage Reduction',
        'PVPMagicDamageReduction' => 'PVP Magic Damage Reduction',
        'PVPDamagePercent' => 'PVP Damage Percent'
    ]
];

// Validate and sanitize input
$item_id= isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($item_id <= 0) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">Invalid Weapon ID</div>
    </div>
    <?php
    include 'footer.php';
    exit();
}

// Prepare query
try {
    // Query to get weapon details
    $query = "SELECT * FROM weapon WHERE item_id = ?";
    
    // Prepare statement
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("i", $item_id);
    
    // Execute query
    $stmt->execute();
    
    // Get results
    $result = $stmt->get_result();
    
    // Check if item exists
    if ($result->num_rows === 0) {
        ?>
        <div class="container mt-4">
            <div class="alert alert-warning">No weapon found with ID <?php echo $item_id; ?></div>
        </div>
        <?php
        include 'footer.php';
        exit();
    }

    // Fetch weapon details
    $weapon = $result->fetch_assoc();

    // Clean specific fields
    $weapon['material'] = cleanText($weapon['material']);
    $weapon['desc_en'] = cleanText($weapon['desc_en']);

    // Collect non-zero stats
    $additionalStats = [];
    foreach ($statCategories as $category => $stats) {
        $categoryStats = [];
        foreach ($stats as $statKey => $statLabel) {
            if (isset($weapon[$statKey]) && $weapon[$statKey] != 0) {
                $categoryStats[$statKey] = [
                    'label' => $statLabel,
                    'value' => $weapon[$statKey]
                ];
            }
        }
        if (!empty($categoryStats)) {
            $additionalStats[$category] = $categoryStats;
        }
    }

    // Determine class restrictions
    $classRestrictions = [];
    $classMapping = [
        'use_royal' => 'Royal',
        'use_knight' => 'Knight',
        'use_mage' => 'Mage',
        'use_elf' => 'Elf', 
        'use_darkelf' => 'Dark Elf',
        'use_dragonknight' => 'Dragon Knight',
        'use_illusionist' => 'Illusionist',
        'use_warrior' => 'Warrior',
        'use_fencer' => 'Fencer',
        'use_lancer' => 'Lancer'
    ];

    foreach ($classMapping as $key => $className) {
        if (isset($weapon[$key]) && $weapon[$key] == 1) {
            $classRestrictions[] = $className;
        }
    }

    // Prepare icon path
    $iconPath = "icons/{$weapon['iconId']}.png";
    $hasIcon = !empty($weapon['iconId']) && file_exists($iconPath);

} catch (Exception $e) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">
            Error: <?php echo htmlspecialchars($e->getMessage()); ?>
        </div>
    </div>
    <?php
    include 'footer.php';
    exit();
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-sword me-2"></i>
                        Weapon Details
                    </h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($hasIcon): ?>
                        <img src="<?php echo $iconPath; ?>" alt="Weapon Icon" class="img-fluid mb-3" style="max-width: 768px; max-height: 768px; width: auto; height: auto;">
                    <?php else: ?>
                        <div class="no-icon text-muted mb-3" style="height: 400px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 6rem;"></i>
                            <p>No Icon Available</p>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="card-title grade-<?php echo htmlspecialchars($weapon['itemGrade']); ?>">
                        <?php echo htmlspecialchars($weapon['desc_en']); ?>
                    </h4>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Item Specifications</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Item ID</th>
                                    <td><?php echo htmlspecialchars($weapon['item_id']); ?></td>
                                </tr>
                                <tr>
                                    <th>Grade</th>
                                    <td>
                                        <span class="badge grade-<?php echo htmlspecialchars($weapon['itemGrade']); ?>">
                                            <?php echo htmlspecialchars($weapon['itemGrade']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td><?php echo htmlspecialchars($weapon['type']); ?></td>
                                </tr>
                                <tr>
                                    <th>Material</th>
                                    <td><?php echo htmlspecialchars($weapon['material']); ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Combat Specifications</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Damage</th>
                                    <td><?php echo htmlspecialchars($weapon['dmg_small']); ?> - <?php echo htmlspecialchars($weapon['dmg_large']); ?></td>
                                </tr>
                                <tr>
                                    <th>Level Range</th>
                                    <td>
                                        <?php 
                                        $minLevel = $weapon['min_lvl'] > 0 ? $weapon['min_lvl'] : 'None';
                                        $maxLevel = $weapon['max_lvl'] > 0 ? $weapon['max_lvl'] : 'None';
                                        echo "$minLevel - $maxLevel"; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Weight</th>
                                    <td><?php echo htmlspecialchars($weapon['weight']); ?></td>
                                </tr>
                                <tr>
                                    <th>Safe Enchant</th>
                                    <td><?php echo htmlspecialchars($weapon['safenchant']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Class Restrictions</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($classRestrictions)): ?>
                                <?php foreach ($classRestrictions as $class): ?>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($class); ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">No class restrictions</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($additionalStats)): ?>
                <?php foreach ($additionalStats as $category => $stats): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo htmlspecialchars($category); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($stats as $statKey => $stat): ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <strong><?php echo htmlspecialchars($stat['label']); ?></strong>
                                            <span><?php echo htmlspecialchars($stat['value']); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Monster Drops Section
    try {
        // Prepare query to find monster drops for this weapon
        $dropQuery = "SELECT d.mobId, d.mobname_en, d.moblevel, d.chance 
                      FROM droplist d
                      WHERE d.itemId = ? 
                      ORDER BY d.chance DESC";
        
        $dropStmt = $conn->prepare($dropQuery);
        $dropStmt->bind_param("i", $item_id);
        $dropStmt->execute();
        $dropResult = $dropStmt->get_result();

        // Check if there are any drops
        if ($dropResult && $dropResult->num_rows > 0):
    ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-box-seam me-2"></i>Monster Drops
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Monster Name</th>
                        <th>Monster Level</th>
                        <th>Drop Chance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($drop = $dropResult->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="view_monster.php?id=<?php echo intval($drop['mobId']); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($drop['mobname_en']); ?>
                                <i class="bi bi-box-arrow-up-right small text-muted ms-1"></i>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($drop['moblevel']); ?></td>
                        <td><?php echo htmlspecialchars($drop['chance']); ?>%</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
        endif; 
        $dropStmt->close();
    } catch (Exception $e) {
        ?>
        <div class="alert alert-warning">
            Error retrieving drop information: <?php echo htmlspecialchars($e->getMessage()); ?>
        </div>
        <?php
    }
    ?>
    
    <div class="text-center mt-4">
        <a href="weapon_list.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Weapon List
        </a>
    </div>
</div>

<?php 
// Close main statement
$stmt->close();

include 'footer.php'; 
?>