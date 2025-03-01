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
                                <?php
                                // Set color for different grades
                                $gradeColor = 'bg-primary';
                                switch(intval($doll['grade'])) {
                                    case 1:
                                        $gradeColor = 'bg-secondary'; // Grey for common
                                        break;
                                    case 2:
                                        $gradeColor = 'bg-info'; // Blue for uncommon
                                        break;
                                    case 3:
                                        $gradeColor = 'bg-success'; // Green for rare
                                        break;
                                    case 4:
                                        $gradeColor = 'bg-warning text-dark'; // Yellow for epic
                                        break;
                                    case 5:
                                    case 6:
                                        $gradeColor = 'bg-danger'; // Red for legendary
                                        break;
                                    case 7:
                                    case 8:
                                        $gradeColor = 'bg-dark border border-warning'; // Dark with gold border for mythic
                                        break;
                                    default:
                                        $gradeColor = 'bg-primary'; // Default blue
                                }
                                ?>
                                <span class="badge <?php echo $gradeColor; ?>">Grade <?php echo htmlspecialchars($doll['grade']); ?></span>
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
                                            
                                            // Set color for different grades
                                            $gradeClass = 'bg-primary';
                                            switch(intval($grade)) {
                                                case 1:
                                                    $gradeClass = 'bg-secondary'; // Grey for common
                                                    break;
                                                case 2:
                                                    $gradeClass = 'bg-info'; // Blue for uncommon
                                                    break;
                                                case 3:
                                                    $gradeClass = 'bg-success'; // Green for rare
                                                    break;
                                                case 4:
                                                    $gradeClass = 'bg-warning text-dark'; // Yellow for epic
                                                    break;
                                                case 5:
                                                case 6:
                                                    $gradeClass = 'bg-danger'; // Red for legendary
                                                    break;
                                                case 7:
                                                case 8:
                                                    $gradeClass = 'bg-dark border border-warning'; // Dark with gold border for mythic
                                                    break;
                                                default:
                                                    $gradeClass = $isCurrentGrade ? 'bg-primary' : 'bg-secondary';
                                            }
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
                        <!-- Add this after the Enchantment Potential section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-lightbulb me-2"></i>Usage Tips
        </h5>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <?php
            // Generate tips based on doll properties
            $tips = [];
            
            // Haste tips
            if ($doll['haste'] == 1) {
                $tips[] = "This doll provides a Haste effect, making it excellent for combat-focused characters who need faster attack speed.";
            }
            
            // Damage chance tips
            if ($doll['damageChance'] > 0) {
                $tips[] = "With a {$doll['damageChance']}% damage chance, this doll can significantly boost your damage output in prolonged battles.";
            }
            
            // Bonus interval tips
            if ($doll['bonusInterval'] > 0) {
                $tips[] = "The bonus activates every {$doll['bonusInterval']} seconds. For maximum efficiency, summon this doll before engaging in longer battles.";
            }
            
            // Speed effects tips
            if (!empty($speedEffects)) {
                $tips[] = "This doll provides speed enhancement effects, making it valuable for PvP situations and quick maneuvers.";
            }
            
            // Elemental resistance tips
            $hasElementalResist = false;
            if (!empty($potentialStats)) {
                foreach ($potentialStats as $statName => $statValue) {
                    if (strpos($statName, 'Resist') !== false) {
                        $hasElementalResist = true;
                        break;
                    }
                }
            }
            
            if ($hasElementalResist) {
                $tips[] = "The elemental resistances provided by this doll make it particularly useful in areas with elemental damage.";
            }
            
            // Grade-based tips
            if (isset($doll['grade'])) {
                if ($doll['grade'] >= 4) {
                    $tips[] = "As a Grade {$doll['grade']} doll, this is one of the more powerful dolls available. Prioritize using this over lower-grade alternatives.";
                } else {
                    $tips[] = "While this is a Grade {$doll['grade']} doll, it can still be valuable until you obtain higher-grade dolls.";
                }
            }
            
            // Add generic tip if no specific tips were generated
            if (empty($tips)) {
                $tips[] = "Summon this doll to receive its passive bonuses while adventuring.";
                $tips[] = "Magic dolls will remain active until you summon a different doll or log out.";
            }
            
            // Output the tips
            foreach ($tips as $tip):
            ?>
                <li class="list-group-item">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <?php echo $tip; ?>
                </li>
            <?php endforeach; ?>
        </ul>
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
                <?php
// Fetch similar dolls with icon information
$similarDollsQuery = "SELECT n.npcid, n.desc_en, n.spriteId, 
                             mi.grade, 
                             e.iconid
                      FROM npc n
                      JOIN magicdoll_info mi ON n.npcid = mi.dollNpcId
                      LEFT JOIN etcitem e ON mi.itemId = e.item_id
                      WHERE mi.grade = ? AND n.npcid != ?
                      LIMIT 5";
$similarDollsStmt = $conn->prepare($similarDollsQuery);
$similarDollsStmt->bind_param('ii', $doll['grade'], $dollId);
$similarDollsStmt->execute();
$similarDollsResult = $similarDollsStmt->get_result();
$similarDolls = $similarDollsResult->fetch_all(MYSQLI_ASSOC);

if (!empty($similarDolls)): ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Similar Magic Dolls</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($similarDolls as $similarDoll): 
                        $similarDisplayName = preg_replace('/\bMagic Doll\b/', '', $similarDoll['desc_en']);
                        $similarDisplayName = trim(preg_replace('/ +/', ' ', $similarDisplayName));
                        
                        // Determine icon path (similar to the logic in the main page)
                        $similarIconPath = null;
                        if (!empty($similarDoll['iconid'])) {
                            $similarIconPath = "icons/{$similarDoll['iconid']}.png";
                            if (!file_exists($similarIconPath)) {
                                $similarIconPath = "icons/icon_{$similarDoll['iconid']}.png";
                            }
                        }
                        
                        // Fallback to sprite icon if no item icon
                        if ((!$similarIconPath || !file_exists($similarIconPath))) {
                            $similarIconPath = "icons/ms{$similarDoll['spriteId']}.png";
                        }
                        
                        $hasIcon = file_exists($similarIconPath);
                        
                        // Set color for similar doll grade
                        $similarGradeColor = 'bg-primary';
                        switch(intval($similarDoll['grade'])) {
                            case 1:
                                $similarGradeColor = 'bg-secondary'; // Grey for common
                                break;
                            case 2:
                                $similarGradeColor = 'bg-info'; // Blue for uncommon
                                break;
                            case 3:
                                $similarGradeColor = 'bg-success'; // Green for rare
                                break;
                            case 4:
                                $similarGradeColor = 'bg-warning text-dark'; // Yellow for epic
                                break;
                            case 5:
                            case 6:
                                $similarGradeColor = 'bg-danger'; // Red for legendary
                                break;
                            case 7:
                            case 8:
                                $similarGradeColor = 'bg-dark border border-warning'; // Dark with gold border for mythic
                                break;
                            default:
                                $similarGradeColor = 'bg-primary'; // Default blue
                        }
                    ?>
                    <div class="col-md-4 mb-3">
                        <a href="view_doll.php?id=<?php echo $similarDoll['npcid']; ?>" class="text-decoration-none">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <?php if ($hasIcon): ?>
                                        <img src="<?php echo $similarIconPath; ?>" alt="<?php echo htmlspecialchars($similarDisplayName); ?>" class="img-fluid mb-2" style="max-height: 150px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="text-center mb-2" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-robot fs-1 text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="text-primary me-2"><?php echo htmlspecialchars($similarDisplayName); ?></span>
                                        <span class="badge <?php echo $similarGradeColor; ?>">Grade <?php echo $similarDoll['grade']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
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