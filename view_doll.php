<?php
// view_doll.php - Detailed view of a specific magic doll with enchantment and potential info
require_once 'database.php';

// Page setup
$page_title = "Magic Doll Details";
include 'header.php';

// Check if doll ID is provided
if (isset($_GET['id'])) {
    $dollId = intval($_GET['id']);
    
    try {
        // Fetch doll details from npc table with enhanced relationships
        $query = "SELECT n.*, 
                       mi.name as item_name, mi.grade, mi.itemId, mi.haste, 
                       mi.bonusCount, mi.bonusInterval, mi.bonusItemId, mi.damageChance,
                       e.iconid, e.desc_en as item_description,
                       mp.* 
                FROM npc n
                JOIN magicdoll_info mi ON n.npcid = mi.dollNpcId
                LEFT JOIN etcitem e ON mi.itemId = e.item_id 
                LEFT JOIN magicdoll_potential mp ON mi.bonusItemId = mp.bonusId
                WHERE n.npcid = ? AND n.impl = 'L1Doll'";
                
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $dollId);
        $stmt->execute();
        $result = $stmt->get_result();
        $doll = $result->fetch_assoc();
        
        if ($doll) {
            // Format display name by removing "Magic Doll" text
            $displayName = $doll['desc_en'];
            $displayName = preg_replace('/\bMagic Doll\b/', '', $displayName);
            $displayName = preg_replace('/ +/', ' ', $displayName); // Remove extra spaces
            $displayName = trim($displayName);
            
            // Get icons using multiple methods
            $iconPath = null;
            if (!empty($doll['iconid'])) {
                $iconPath = "icons/{$doll['iconid']}.png";
                // Check if file exists without icon_ prefix
                if (!file_exists($iconPath)) {
                    $iconPath = "icons/icon_{$doll['iconid']}.png";
                }
            }
            
            // If no direct icon, try sprite
            if ((!$iconPath || !file_exists($iconPath))) {
                $iconPath = "icons/ms{$doll['spriteId']}.png";
            }
            
            $hasIcon = file_exists($iconPath);
            
            // Fetch potential enchantment information
            $potentialQuery = "SELECT mp.* 
                           FROM magicdoll_potential mp 
                           WHERE mp.bonusId = ?";
            $potentialStmt = $conn->prepare($potentialQuery);
            $potentialStmt->bind_param('i', $doll['bonusItemId']);
            $potentialStmt->execute();
            $potentialResult = $potentialStmt->get_result();
            $potential = $potentialResult->fetch_assoc();
            
            // Get the potential grade information.
            // Instead of querying magicdoll_potential for a grade column (which doesn't exist), we use the grade from the magicdoll_info table.
            $enhancementGrades = [];
            if (isset($doll['grade'])) {
                $enhancementGrades[] = $doll['grade'];
            }
            
            // Collect all non-zero stat attributes for display
            $stats = [];
            if ($doll['str'] > 0) $stats['STR'] = $doll['str'];
            if ($doll['dex'] > 0) $stats['DEX'] = $doll['dex'];
            if ($doll['con'] > 0) $stats['CON'] = $doll['con'];
            if ($doll['intel'] > 0) $stats['INT'] = $doll['intel'];
            if ($doll['wis'] > 0) $stats['WIS'] = $doll['wis'];
            if ($doll['cha'] > 0) $stats['CHA'] = $doll['cha'];
            
            // Collect potential stats
            $potentialStats = [];
            $speedEffects = [];
            
            if (!empty($potential)) {
                $statFields = [
                    'str' => 'STR', 
                    'con' => 'CON', 
                    'dex' => 'DEX', 
                    'int' => 'INT', 
                    'wis' => 'WIS', 
                    'cha' => 'CHA',
                    'hp' => 'HP', 
                    'mp' => 'MP', 
                    'hpr' => 'HP Regen', 
                    'mpr' => 'MP Regen',
                    'shortDamage' => 'Melee Damage', 
                    'shortHit' => 'Melee Hit', 
                    'longDamage' => 'Ranged Damage',
                    'spellpower' => 'Magic Power',
                    'mr' => 'Magic Resistance',
                    'shortCritical' => 'Melee Crit',
                    'longCritical' => 'Ranged Crit',
                    'magicCritical' => 'Magic Crit',
                    'ac_bonus' => 'AC',
                    'dg' => 'Dodge',
                    'er' => 'Evasion',
                    'me' => 'Mental'
                ];
                
                foreach ($statFields as $field => $label) {
                    if (isset($potential[$field]) && $potential[$field] > 0) {
                        $potentialStats[$label] = $potential[$field];
                    }
                }
                
                // Add elemental resistances if present
                if (isset($potential['attrFire']) && $potential['attrFire'] > 0) $potentialStats['Fire Resist'] = $potential['attrFire'];
                if (isset($potential['attrWater']) && $potential['attrWater'] > 0) $potentialStats['Water Resist'] = $potential['attrWater'];
                if (isset($potential['attrWind']) && $potential['attrWind'] > 0) $potentialStats['Wind Resist'] = $potential['attrWind'];
                if (isset($potential['attrEarth']) && $potential['attrEarth'] > 0) $potentialStats['Earth Resist'] = $potential['attrEarth'];
                
                // Check for speed bonuses
                if (isset($potential['firstSpeed']) && $potential['firstSpeed'] == 1) $speedEffects[] = "First Speed";
                if (isset($potential['secondSpeed']) && $potential['secondSpeed'] == 1) $speedEffects[] = "Second Speed";
                if (isset($potential['thirdSpeed']) && $potential['thirdSpeed'] == 1) $speedEffects[] = "Third Speed";
                if (isset($potential['forthSpeed']) && $potential['forthSpeed'] == 1) $speedEffects[] = "Fourth Speed";
            }
            
            // Display the doll details
            ?>
            <div class="container mt-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="doll_list.php">Magic Dolls</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($displayName); ?></li>
                    </ol>
                </nav>
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><?php echo htmlspecialchars($displayName); ?></h4>
                                <span class="badge bg-primary">Grade <?php echo htmlspecialchars($doll['grade']); ?></span>
                            </div>
                            <div class="card-body text-center">
                                <?php if ($hasIcon): ?>
                                    <div class="image-container mb-4" style="height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <img src="<?php echo $iconPath; ?>" alt="<?php echo htmlspecialchars($displayName); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div class="text-center mb-4" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-robot fs-1 text-muted" style="font-size: 6rem;"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="doll-info">
                                    <h5>Level <?php echo $doll['lvl']; ?> Magic Doll</h5>
                                    <?php if (!empty($doll['item_name'])): ?>
                                        <p class="text-muted">Item: <?php echo htmlspecialchars($doll['item_name']); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($doll['haste'] == 1): ?>
                                        <div class="mt-3">
                                            <span class="badge bg-success p-2">
                                                <i class="bi bi-speedometer2 me-1"></i>Haste Effect
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($doll['damageChance'] > 0): ?>
                                        <div class="mt-2">
                                            <span class="badge bg-danger p-2">
                                                <i class="bi bi-lightning me-1"></i><?php echo $doll['damageChance']; ?>% Damage Chance
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($potentialStats) || !empty($speedEffects)): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-lightning-charge me-2"></i>Potential Abilities
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($potential['name'])): ?>
                                    <h6 class="text-primary mb-3"><?php echo htmlspecialchars($potential['name']); ?></h6>
                                <?php endif; ?>
                                
                                <?php if (!empty($potentialStats)): ?>
                                <div class="row">
                                    <?php foreach ($potentialStats as $statName => $statValue): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <div class="d-flex justify-content-between border-bottom pb-1">
                                            <span><?php echo htmlspecialchars($statName); ?></span>
                                            <span class="text-primary">+<?php echo htmlspecialchars($statValue); ?></span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($speedEffects)): ?>
                                <div class="mt-3">
                                    <h6 class="text-muted">Speed Effects</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($speedEffects as $effect): ?>
                                            <span class="badge bg-info p-2"><?php echo htmlspecialchars($effect); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (isset($potential['skill_id']) && $potential['skill_id'] > 0): ?>
                                <div class="mt-3">
                                    <h6 class="text-muted">Special Skill</h6>
                                    <p>
                                        <?php echo isset($potential['skillName']) ? htmlspecialchars($potential['skillName']) : 'Skill ID: '.$potential['skill_id']; ?>
                                        <?php if (isset($potential['skillChance']) && $potential['skillChance'] > 0): ?>
                                            <span class="badge bg-secondary ms-2"><?php echo $potential['skillChance']; ?>% chance</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Base Stats</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th>HP</th>
                                                    <td><?php echo number_format($doll['hp']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>MP</th>
                                                    <td><?php echo number_format($doll['mp']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>AC</th>
                                                    <td><?php echo $doll['ac']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>MR</th>
                                                    <td><?php echo $doll['mr']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tbody>
                                                <?php foreach ($stats as $statName => $statValue): ?>
                                                <tr>
                                                    <th><?php echo htmlspecialchars($statName); ?></th>
                                                    <td><?php echo htmlspecialchars($statValue); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Bonus Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php if ($doll['bonusInterval'] > 0): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-box p-3 border rounded">
                                            <h6 class="mb-2">
                                                <i class="bi bi-clock-history me-2"></i>Bonus Interval
                                            </h6>
                                            <p class="mb-0">
                                                This doll provides bonuses every <strong><?php echo $doll['bonusInterval']; ?> seconds</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($doll['bonusCount'] > 0): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-box p-3 border rounded">
                                            <h6 class="mb-2">
                                                <i class="bi bi-stoplights me-2"></i>Bonus Count
                                            </h6>
                                            <p class="mb-0">
                                                This doll provides up to <strong><?php echo $doll['bonusCount']; ?> bonuses</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($doll['passivespell'])): ?>
                                <div class="mt-3">
                                    <h5 class="text-primary mb-2">Passive Effects</h5>
                                    <div class="p-3 border rounded">
                                        <?php echo nl2br(htmlspecialchars($doll['passivespell'])); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- New Enchantment Potential Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-arrow-up-circle me-2"></i>Enchantment Potential
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($doll['bonusItemId'] > 0): ?>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    This magic doll can be enhanced using enchantment. Enhancing the doll increases its stats and abilities based on its potential.
                                </div>
                                
                                <div class="mt-4">
                                    <h6 class="mb-3">Available Enhancement Grades</h6>
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <?php 
                                        // Show available enhancement grades with current one highlighted
                                        foreach ($enhancementGrades as $grade):
                                            $isCurrentGrade = isset($potential['grade']) && $potential['grade'] == $grade;
                                            $gradeClass = $isCurrentGrade ? 'bg-primary' : 'bg-secondary';
                                        ?>
                                        <span class="badge <?php echo $gradeClass; ?> p-2">
                                            <?php echo "Grade " . htmlspecialchars($grade); ?>
                                            <?php if ($isCurrentGrade): ?>
                                                <i class="bi bi-check-circle ms-1"></i>
                                            <?php endif; ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php
                                    // Updated maximum stats query: remove grade reference since the column no longer exists.
                                    $maxStatsQuery = "SELECT * FROM magicdoll_potential WHERE bonusId = ? LIMIT 1";
                                    $maxStatsStmt = $conn->prepare($maxStatsQuery);
                                    $maxStatsStmt->bind_param('i', $doll['bonusItemId']);
                                    $maxStatsStmt->execute();
                                    $maxStatsResult = $maxStatsStmt->get_result();
                                    $maxStats = $maxStatsResult->fetch_assoc();
                                    
                                    if ($maxStats):
                                    ?>
                                    <h6 class="mb-3">Maximum Potential Stats at Highest Grade</h6>
                                    <div class="row">
                                        <?php
                                        // Display the maximum potential stats
                                        $maxPotentialStats = [];
                                        foreach ($statFields as $field => $label) {
                                            if (isset($maxStats[$field]) && $maxStats[$field] > 0) {
                                                $maxPotentialStats[$label] = $maxStats[$field];
                                            }
                                        }
                                        
                                        // Add elemental resistances
                                        if (isset($maxStats['attrFire']) && $maxStats['attrFire'] > 0) $maxPotentialStats['Fire Resist'] = $maxStats['attrFire'];
                                        if (isset($maxStats['attrWater']) && $maxStats['attrWater'] > 0) $maxPotentialStats['Water Resist'] = $maxStats['attrWater'];
                                        if (isset($maxStats['attrWind']) && $maxStats['attrWind'] > 0) $maxPotentialStats['Wind Resist'] = $maxStats['attrWind'];
                                        if (isset($maxStats['attrEarth']) && $maxStats['attrEarth'] > 0) $maxPotentialStats['Earth Resist'] = $maxStats['attrEarth'];
                                        
                                        foreach ($maxPotentialStats as $statName => $statValue):
                                        ?>
                                        <div class="col-6 col-md-4 mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span><?php echo htmlspecialchars($statName); ?></span>
                                                <span class="text-success">+<?php echo htmlspecialchars($statValue); ?></span>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php
                                    // Check for max speed bonuses
                                    $maxSpeedEffects = [];
                                    if (isset($maxStats['firstSpeed']) && $maxStats['firstSpeed'] == 1) $maxSpeedEffects[] = "First Speed";
                                    if (isset($maxStats['secondSpeed']) && $maxStats['secondSpeed'] == 1) $maxSpeedEffects[] = "Second Speed";
                                    if (isset($maxStats['thirdSpeed']) && $maxStats['thirdSpeed'] == 1) $maxSpeedEffects[] = "Third Speed";
                                    if (isset($maxStats['forthSpeed']) && $maxStats['forthSpeed'] == 1) $maxSpeedEffects[] = "Fourth Speed";
                                    
                                    if (!empty($maxSpeedEffects)):
                                    ?>
                                    <div class="mt-3">
                                        <h6 class="text-muted">Maximum Speed Effects</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php foreach ($maxSpeedEffects as $effect): ?>
                                                <span class="badge bg-success p-2"><?php echo htmlspecialchars($effect); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php 
                                    endif;
                                    endif; 
                                    ?>
                                    
                                    <div class="mt-4">
                                        <h6 class="mb-3">Enchantment Process</h6>
                                        <ol class="ps-3">
                                            <li class="mb-2">Obtain a Magic Doll Enhancement Stone (special item)</li>
                                            <li class="mb-2">Right-click the enhancement stone while the doll is in your inventory</li>
                                            <li class="mb-2">Success rate varies based on the current enhancement level</li>
                                            <li class="mb-2">Each successful enhancement will increase the doll's grade and stats</li>
                                            <li class="mb-2">Failed enhancements may result in decreased stats or grade</li>
                                        </ol>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    This magic doll cannot be enhanced with enchantment.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php 
                        // Fetch any special notes or lore based on available info
                        $notes = [];
                        if (!empty($doll['note'])) $notes[] = $doll['note'];
                        if (!empty($doll['item_description'])) $notes[] = $doll['item_description'];
                        
                        if (!empty($notes)):
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Additional Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php foreach ($notes as $note): ?>
                                    <p><?php echo nl2br(htmlspecialchars($note)); ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="text-center mt-4 mb-4">
                    <a href="doll_list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Magic Dolls
                    </a>
                </div>
            </div>
            <?php
        } else {
            // Doll not found
            ?>
            <div class="container mt-4">
                <div class="alert alert-warning">
                    <strong>Magic Doll not found.</strong> The requested doll does not exist or is not a valid magic doll.
                </div>
                <a href="doll_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Magic Dolls List
                </a>
            </div>
            <?php
        }
        
    } catch (Exception $e) {
        // Error handling 
        ?>
        <div class="container mt-4">
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>
            </div>
        </div>
        <?php
    }
} else {
    // Redirect if doll ID is not provided
    header("Location: doll_list.php");
    exit();
}

include 'footer.php';
?>