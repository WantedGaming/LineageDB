<?php
// view_monster.php - Monster Detail Page
require_once 'database.php';

// Page setup
$page_title = "Monster Details";
include 'header.php';

// Check if monster ID is provided
if (isset($_GET['id'])) {
    $monsterId = $_GET['id'];
    
    try {
        // Fetch monster details
        $query = "SELECT * FROM npc WHERE npcid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $monsterId);
        $stmt->execute();
        $result = $stmt->get_result();
        $monster = $result->fetch_assoc();
        
        if ($monster) {
            // Collect the monster skills
            $skillsQuery = "SELECT * FROM mobskill WHERE mobid = ?";
            $skillsStmt = $conn->prepare($skillsQuery);
            $skillsStmt->bind_param('i', $monsterId);
            $skillsStmt->execute();
            $skillsResult = $skillsStmt->get_result();
            
            $monsterSkills = [];
            if ($skillsResult && $skillsResult->num_rows > 0) {
                while ($skill = $skillsResult->fetch_assoc()) {
                    $monsterSkills[] = $skill;
                }
            }
            
            // Display monster details
            ?>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">
                                    <?php echo htmlspecialchars($monster['desc_en']); ?> 
                                    <span class="badge bg-secondary">Level <?php echo htmlspecialchars($monster['lvl']); ?></span>
                                    <?php if (!empty($monster['is_bossmonster']) && $monster['is_bossmonster'] == 1): ?>
                                        <span class="badge bg-danger ms-2">Boss Monster</span>
                                    <?php endif; ?>
                                </h4>
                            </div>
                            <div class="card-body text-center" style="padding: 0; display: flex; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.05);">
                                <?php
                                $spritePath = "icons/ms{$monster['spriteId']}.png";
                                if (file_exists($spritePath)):
                                ?>
                                    <div class="sprite-container" style="height: 500px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <img src="<?php echo $spritePath; ?>"
                                             alt="Monster Sprite"
                                             style="max-width: 100%; max-height: 500px; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div style="height: 500px; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-center">
                                            <i class="bi bi-image fs-1 text-muted" style="font-size: 6rem;"></i>
                                            <p class="mt-3">No Sprite Available</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($monster['weakAttr']) && $monster['weakAttr'] != 'NONE'): ?>
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                    <span class="me-2"><strong>Elemental Weakness:</strong></span>
                                    <span class="badge bg-danger"><?php echo htmlspecialchars($monster['weakAttr']); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($monsterSkills)): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Monster Skills</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Skill ID</th>
                                                <th>Type</th>
                                                <th>Distance</th>
                                                <th>Probability</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($monsterSkills as $skill): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($skill['skillid'] ?? $skill['skill_id'] ?? "Unknown Skill"); ?></td>
                                                <td><?php echo htmlspecialchars($skill['type'] ?? "Unknown"); ?></td>
                                                <td><?php echo htmlspecialchars($skill['distance'] ?? $skill['range'] ?? "Unknown"); ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($skill['probability'])) {
                                                        $skillProb = intval($skill['probability']);
                                                        echo ($skillProb / 10) . "%";
                                                    } elseif (isset($skill['chance'])) {
                                                        $skillProb = intval($skill['chance']);
                                                        echo ($skillProb / 10) . "%";
                                                    } else {
                                                        echo "Unknown";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <!-- Box 1: Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Info</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo htmlspecialchars($monster['desc_en']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Level</th>
                                            <td><?php echo htmlspecialchars($monster['lvl']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>HP</th>
                                            <td><?php echo number_format($monster['hp']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>MP</th>
                                            <td><?php echo number_format($monster['mp']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>AC</th>
                                            <td><?php echo htmlspecialchars($monster['ac']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Box 2: Stats -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Stats</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>STR</th>
                                            <td><?php echo htmlspecialchars($monster['str']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>CON</th>
                                            <td><?php echo htmlspecialchars($monster['con']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>DEX</th>
                                            <td><?php echo htmlspecialchars($monster['dex']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>WIS</th>
                                            <td><?php echo htmlspecialchars($monster['wis']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>INT</th>
                                            <td><?php echo htmlspecialchars($monster['intel']); ?></td>  
                                        </tr>
                                        <tr>
                                            <th>MR</th>
                                            <td><?php echo htmlspecialchars($monster['mr']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Box 3: Extra -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Extra</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>EXP Earn</th>
                                            <td><?php echo number_format($monster['exp']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alignment</th>
                                            <td><?php echo htmlspecialchars($monster['lawful'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Walk Speed</th>
                                            <td><?php echo htmlspecialchars($monster['passispeed'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Swing Speed</th>
                                            <td><?php echo htmlspecialchars($monster['atkspeed'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Cast Speed</th>
                                            <td><?php echo htmlspecialchars($monster['atk_magic_speed'] ?? 'N/A'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Box 4: Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Details</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2">Aggressive To</h6>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['agro']) && $monster['agro'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Normal</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_agro_poly']) && $monster['is_agro_poly'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Polymorph</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_agro_invis']) && $monster['is_agro_invis'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Invisible</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($monster['family'])): ?>
                                <div class="mb-3">
                                    <strong>Family:</strong> <?php echo htmlspecialchars($monster['family']); ?>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($monster['undead']) && $monster['undead'] != 'NONE'): ?>
                                <div class="mb-3">
                                    <strong>Type:</strong> <?php echo htmlspecialchars($monster['undead']); ?>
                                </div>
                                <?php endif; ?>
                                
                                <h6 class="mb-2">Abilities</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_picupitem']) && $monster['is_picupitem'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Can Loot</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_bravespeed']) && $monster['is_bravespeed'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Use Haste</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_teleport']) && $monster['is_teleport'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Teleport</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_hard']) && $monster['is_hard'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Hard</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['is_bossmonster']) && $monster['is_bossmonster'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Boss</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled 
                                                <?php echo (!empty($monster['can_turnundead']) && $monster['can_turnundead'] == 1) ? 'checked' : ''; ?>>
                                            <label class="form-check-label">Turn Undead</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (isAdminLoggedIn()): ?>
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <strong>Admin Info:</strong><br>
                                    <small>
                                        NPC ID: <?php echo htmlspecialchars($monster['npcid']); ?><br>
                                        Class ID: <?php echo htmlspecialchars($monster['classid'] ?? 'N/A'); ?><br>
                                        Sprite ID: <?php echo htmlspecialchars($monster['spriteId']); ?>
                                    </small>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-box-seam me-2"></i>Drops
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php
                                // Fetch drop data from database with icon information
                                $dropsQuery = "SELECT d.itemId, d.min, d.max, d.chance,
                                              COALESCE(a.desc_en, w.desc_en, e.desc_en, 'Unknown Item') as item_name,
                                              COALESCE(a.iconId, w.iconId, e.iconId, NULL) as iconId,
                                              CASE 
                                                WHEN a.item_id IS NOT NULL THEN 'armor'
                                                WHEN w.item_id IS NOT NULL THEN 'weapon'
                                                WHEN e.item_id IS NOT NULL THEN 'etcitem'
                                                ELSE NULL
                                              END as item_type
                                              FROM droplist d
                                              LEFT JOIN armor a ON d.itemId = a.item_id
                                              LEFT JOIN weapon w ON d.itemId = w.item_id
                                              LEFT JOIN etcitem e ON d.itemId = e.item_id
                                              WHERE d.mobId = ?
                                              ORDER BY d.chance DESC";

                                $dropsStmt = $conn->prepare($dropsQuery);
                                $dropsStmt->bind_param('i', $monsterId);
                                $dropsStmt->execute();
                                $dropsResult = $dropsStmt->get_result();

                                if ($dropsResult->num_rows > 0):
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 60px">Icon</th>
                                                <th>Item Name</th>
                                                <th style="width: 100px">Min-Max</th>
                                                <th style="width: 100px">Chance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($drop = $dropsResult->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php 
                                                        $iconPath = "icons/{$drop['iconId']}.png";
                                                        if (!empty($drop['iconId']) && file_exists($iconPath)):
                                                        ?>
                                                            <div style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                                <img src="<?php echo $iconPath; ?>" alt="Item Icon" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="text-muted"><i class="bi bi-question-circle"></i></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $itemUrl = '';
                                                        
                                                        if ($drop['item_type'] == 'armor') {
                                                            $itemUrl = "view_armor.php?id=" . $drop['itemId'];
                                                        } elseif ($drop['item_type'] == 'weapon') {
                                                            $itemUrl = "view_weapon.php?id=" . $drop['itemId'];
                                                        } elseif ($drop['item_type'] == 'etcitem') {
                                                            $itemUrl = "view_item.php?id=" . $drop['itemId'];
                                                        }
                                                        
                                                        if (!empty($itemUrl)): 
                                                        ?>
                                                            <a href="<?php echo $itemUrl; ?>" class="text-decoration-none">
                                                                <span><?php echo htmlspecialchars($drop['item_name']); ?></span>
                                                                <small class="text-muted d-block">ID: <?php echo htmlspecialchars($drop['itemId']); ?></small>
                                                            </a>
                                                        <?php else: ?>
                                                            <span><?php echo htmlspecialchars($drop['item_name']); ?></span>
                                                            <small class="text-muted d-block">ID: <?php echo htmlspecialchars($drop['itemId']); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php 
                                                        if ($drop['min'] == $drop['max']) {
                                                            echo htmlspecialchars($drop['min']);
                                                        } else {
                                                            echo htmlspecialchars($drop['min']) . '-' . htmlspecialchars($drop['max']);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php 
                                                        // Fixed drop chance calculation
                                                        $chanceValue = intval($drop['chance']);
                                                        $dropPercentage = ($chanceValue / 1000000) * 100;
                                                        
                                                        // Determine badge class based on rarity
                                                        $badgeClass = 'bg-danger'; // Very low chance (red)
                                                        
                                                        if ($dropPercentage >= 8) {
                                                            $badgeClass = 'bg-success'; // High chance (green)
                                                        } elseif ($dropPercentage >= 4) {
                                                            $badgeClass = 'bg-primary'; // Medium chance (blue)
                                                        } elseif ($dropPercentage >= 1) {
                                                            $badgeClass = 'bg-warning text-dark'; // Low chance (yellow)
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $badgeClass; ?>">
                                                            <?php echo number_format($dropPercentage, 2); ?>%
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                    <div class="alert alert-info text-center">
                                        <i class="bi bi-info-circle me-2"></i>No drop data available for this monster
                                    </div>
                                <?php endif; 
                                
                                // Close the statement
                                $dropsStmt->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-map me-2"></i>Locations
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php
                                // Fetch location data
                                $locationQuery = "SELECT m.locationname, m.mapid, m.pngId
                                                 FROM spawnlist s
                                                 JOIN mapids m ON s.mapid = m.mapid
                                                 WHERE s.npc_templateid = ?
                                                 GROUP BY m.mapid
                                                 ORDER BY m.locationname";
                                
                                $locationStmt = $conn->prepare($locationQuery);
                                $locationStmt->bind_param('i', $monsterId);
                                $locationStmt->execute();
                                $locationResult = $locationStmt->get_result();
                                
                                if ($locationResult->num_rows > 0):
                                ?>
                                <div class="row">
                                    <?php 
                                    // Store the first location for the main map display
                                    $firstLocation = null;
                                    
                                    while ($location = $locationResult->fetch_assoc()): 
                                        // Save the first location for the map display
                                        if ($firstLocation === null) {
                                            $firstLocation = $location;
                                        }
                                        
                                        $locationIcon = "icons/{$location['pngId']}.png";
                                        $hasIcon = !empty($location['pngId']) && file_exists($locationIcon);
                                    ?>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <a href="view_location.php?id=<?php echo $location['mapid']; ?>" class="text-decoration-none">
                                            <div class="card h-100 hover-effect">
                                                <div class="card-body p-0">
                                                    <div class="d-flex">
                                                        <div style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.1);">
                                                            <?php if ($hasIcon): ?>
                                                                <img src="<?php echo $locationIcon; ?>" alt="Location" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                            <?php else: ?>
                                                                <i class="bi bi-map" style="font-size: 2rem; color: var(--text-secondary);"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="p-3">
                                                            <h6 class="mb-1"><?php echo htmlspecialchars($location['locationname']); ?></h6>
                                                            <small class="text-muted">Map ID: <?php echo htmlspecialchars($location['mapid']); ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endwhile; 
                                    
                                    // Reset the result pointer to use it again if needed
                                    $locationResult->data_seek(0);
                                    ?>
                                </div>
                                
                                <?php if ($firstLocation !== null && !empty($firstLocation['pngId'])):
                                    $mapImagePath = "icons/{$firstLocation['pngId']}.png";
                                    if (file_exists($mapImagePath)):
                                ?>
                                <!-- Map Image Box -->
                                <div class="mt-4">
                                    <div class="card map-card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="bi bi-map-fill me-2"></i>Map View: <?php echo htmlspecialchars($firstLocation['locationname']); ?>
                                            </h5>
                                            <a href="view_location.php?id=<?php echo $firstLocation['mapid']; ?>" class="btn btn-sm btn-outline-primary">
                                                View Location Details <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                        <div class="card-body p-0 text-center" style="background-color: rgba(0,0,0,0.05);">
                                            <div class="map-container" style="height: 500px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                <img src="<?php echo $mapImagePath; ?>" alt="Map" class="map-image" style="max-width: 100%; max-height: 500px; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    endif;
                                endif;
                                ?>
                                
                                <?php else: ?>
                                    <div class="alert alert-info text-center">
                                        <i class="bi bi-info-circle me-2"></i>No location data available for this monster
                                    </div>
                                <?php 
                                endif;
                                $locationStmt->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-4">
                    <a href="monster_list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Monster List
                    </a>
                </div>
            </div>
            <?php
        } else {
            // Monster not found
            ?>
            <div class="container mt-4">
                <div class="alert alert-warning">
                    <strong>Monster not found.</strong> The requested monster does not exist.
                </div>
                <a href="monster_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Monster List
                </a>
            </div>
            <?php
        }
        
        // Close statement
        $stmt->close();
        
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
    // Redirect if monster ID is not provided
    header("Location: monster_list.php");
    exit();  
}

include 'footer.php';

// Add custom styles
?>
<style>
.hover-effect {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-effect:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.map-card {
    border: 1px solid var(--border-color);
    overflow: hidden;
}
.map-image {
    transition: transform 0.3s ease;
}
.map-card:hover .map-image {
    transform: scale(1.02);
}
.form-check-input:checked {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
}
.form-check-input:disabled {
    opacity: 1;
    pointer-events: none;
}
.form-check-input:disabled:not(:checked) {
    background-color: #444;
    border-color: #555;
}