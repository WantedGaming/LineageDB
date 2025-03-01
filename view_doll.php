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
        // Fetch doll details from npc table
        $query = "SELECT * FROM npc WHERE npcid = ? AND impl = 'L1Doll'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $dollId);
        $stmt->execute();
        $result = $stmt->get_result();
        $doll = $result->fetch_assoc();
        
        // Fetch doll info from magicdoll_info table
        $dollInfoQuery = "SELECT * FROM magicdoll_info WHERE dollNpcId = ?";
        $dollInfoStmt = $conn->prepare($dollInfoQuery);
        $dollInfoStmt->bind_param('i', $dollId);
        $dollInfoStmt->execute();
        $dollInfoResult = $dollInfoStmt->get_result();
        $dollInfo = ($dollInfoResult && $dollInfoResult->num_rows > 0) ? $dollInfoResult->fetch_assoc() : null;
        
        // If we have doll info, get potential details
        $potential = null;
        if ($dollInfo && !empty($dollInfo['bonusItemId'])) {
            $potentialQuery = "SELECT * FROM magicdoll_potential WHERE bonusId = ?";
            $potentialStmt = $conn->prepare($potentialQuery);
            $potentialStmt->bind_param('i', $dollInfo['bonusItemId']);
            $potentialStmt->execute();
            $potentialResult = $potentialStmt->get_result();
            $potential = ($potentialResult && $potentialResult->num_rows > 0) ? $potentialResult->fetch_assoc() : null;
        }
        
        if ($doll) {
            // Display doll details
            ?>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><?php echo htmlspecialchars($doll['desc_en']); ?></h4>
                                <?php if ($dollInfo && isset($dollInfo['grade'])): ?>
                                    <span class="badge bg-primary">Grade <?php echo $dollInfo['grade']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-center" style="padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: rgba(0,0,0,0.05);">
                                <?php
                                // Try to get item icon from etcitem
                                $itemIconPath = null;
                                if ($dollInfo && !empty($dollInfo['itemId'])) {
                                    $itemIconQuery = "SELECT iconid FROM etcitem WHERE item_id = ?";
                                    $itemIconStmt = $conn->prepare($itemIconQuery);
                                    $itemIconStmt->bind_param('i', $dollInfo['itemId']);
                                    $itemIconStmt->execute();
                                    $itemIconResult = $itemIconStmt->get_result();
                                    $itemIcon = $itemIconResult->fetch_assoc();
                                    
                                    if ($itemIcon && !empty($itemIcon['iconid'])) {
                                        $itemIconPath = "icons/icon_{$itemIcon['iconid']}.png";
                                    }
                                }
                                
                                // Fallback to sprite icon
                                if (!$itemIconPath || !file_exists($itemIconPath)) {
                                    $itemIconPath = "icons/ms{$doll['spriteId']}.png";
                                }
                                
                                if (file_exists($itemIconPath)):
                                ?>
                                    <div class="sprite-container" style="height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <img src="<?php echo $itemIconPath; ?>"
                                             alt="Doll Icon"
                                             style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div style="height: 300px; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-center">
                                            <i class="bi bi-robot fs-1 text-muted" style="font-size: 6rem;"></i>
                                            <p class="mt-3">No Icon Available</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-3 text-center">
                                    <p class="lead mb-0">Level <?php echo $doll['lvl']; ?> Magic Doll</p>
                                    <?php if ($dollInfo && isset($dollInfo['name'])): ?>
                                        <p class="text-primary mb-0">Item Name: <?php echo htmlspecialchars($dollInfo['name']); ?></p>
                                    <?php endif; ?>
                                    <?php if (isset($doll['note']) && !empty($doll['note'])): ?>
                                        <p class="text-muted mt-2"><?php echo htmlspecialchars($doll['note']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if ($dollInfo && $dollInfo['haste']): ?>
                            <div class="card-footer text-center">
                                <span class="badge bg-success me-2">Haste Effect</span>
                                <?php if ($dollInfo['damageChance'] > 0): ?>
                                    <span class="badge bg-danger">
                                        <?php echo $dollInfo['damageChance']; ?>% Damage Chance
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($potential): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-lightning-charge me-2"></i>Potential Abilities
                                </h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-primary"><?php echo htmlspecialchars($potential['name']); ?></h6>
                                
                                <?php
                                // Display all stat bonuses that have values
                                $statBonuses = [];
                                
                                // Basic stats
                                if ($potential['str'] > 0) $statBonuses[] = "STR +" . $potential['str'];
                                if ($potential['con'] > 0) $statBonuses[] = "CON +" . $potential['con'];
                                if ($potential['dex'] > 0) $statBonuses[] = "DEX +" . $potential['dex'];
                                if ($potential['int'] > 0) $statBonuses[] = "INT +" . $potential['int'];
                                if ($potential['wis'] > 0) $statBonuses[] = "WIS +" . $potential['wis'];
                                if ($potential['cha'] > 0) $statBonuses[] = "CHA +" . $potential['cha'];
                                if ($potential['allStatus'] > 0) $statBonuses[] = "All Stats +" . $potential['allStatus'];
                                
                                // Combat stats
                                if ($potential['shortDamage'] > 0) $statBonuses[] = "Melee Damage +" . $potential['shortDamage'];
                                if ($potential['shortHit'] > 0) $statBonuses[] = "Melee Hit +" . $potential['shortHit'];
                                if ($potential['shortCritical'] > 0) $statBonuses[] = "Melee Crit +" . $potential['shortCritical'];
                                if ($potential['longDamage'] > 0) $statBonuses[] = "Ranged Damage +" . $potential['longDamage'];
                                if ($potential['longHit'] > 0) $statBonuses[] = "Ranged Hit +" . $potential['longHit'];
                                if ($potential['longCritical'] > 0) $statBonuses[] = "Ranged Crit +" . $potential['longCritical'];
                                if ($potential['spellpower'] > 0) $statBonuses[] = "Spell Power +" . $potential['spellpower'];
                                if ($potential['magicHit'] > 0) $statBonuses[] = "Magic Hit +" . $potential['magicHit'];
                                if ($potential['magicCritical'] > 0) $statBonuses[] = "Magic Crit +" . $potential['magicCritical'];
                                
                                // HP/MP stats
                                if ($potential['hp'] > 0) $statBonuses[] = "HP +" . $potential['hp'];
                                if ($potential['mp'] > 0) $statBonuses[] = "MP +" . $potential['mp'];
                                if ($potential['hpr'] > 0) $statBonuses[] = "HP Regen +" . $potential['hpr'];
                                if ($potential['mpr'] > 0) $statBonuses[] = "MP Regen +" . $potential['mpr'];
                                
                                // Defensive stats
                                if ($potential['ac_bonus'] > 0) $statBonuses[] = "AC +" . $potential['ac_bonus'];
                                if ($potential['mr'] > 0) $statBonuses[] = "MR +" . $potential['mr'];
                                if ($potential['dg'] > 0) $statBonuses[] = "Dodge +" . $potential['dg'];
                                if ($potential['er'] > 0) $statBonuses[] = "Evasion +" . $potential['er'];
                                if ($potential['me'] > 0) $statBonuses[] = "Mental +" . $potential['me'];
                                
                                // Elemental stats
                                if ($potential['attrFire'] > 0) $statBonuses[] = "Fire Resist +" . $potential['attrFire'];
                                if ($potential['attrWater'] > 0) $statBonuses[] = "Water Resist +" . $potential['attrWater'];
                                if ($potential['attrWind'] > 0) $statBonuses[] = "Wind Resist +" . $potential['attrWind'];
                                if ($potential['attrEarth'] > 0) $statBonuses[] = "Earth Resist +" . $potential['attrEarth'];
                                if ($potential['attrAll'] > 0) $statBonuses[] = "All Element Resist +" . $potential['attrAll'];
                                
                                // Utility stats
                                if ($potential['expBonus'] > 0) $statBonuses[] = "EXP Bonus +" . $potential['expBonus'] . "%";
                                if ($potential['carryBonus'] > 0) $statBonuses[] = "Weight Limit +" . $potential['carryBonus'];
                                
                                // Speed bonuses
                                $speedBonuses = [];
                                if ($potential['firstSpeed']) $speedBonuses[] = "First Speed";
                                if ($potential['secondSpeed']) $speedBonuses[] = "Second Speed";
                                if ($potential['thirdSpeed']) $speedBonuses[] = "Third Speed";
                                if ($potential['forthSpeed']) $speedBonuses[] = "Fourth Speed";
                                
                                if (!empty($statBonuses)):
                                ?>
                                <div class="mb-3">
                                    <div class="d-flex flex-wrap mt-2">
                                        <?php foreach ($statBonuses as $bonus): ?>
                                            <span class="badge bg-secondary me-2 mb-2 p-2">
                                                <?php echo $bonus; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($speedBonuses)): ?>
                                <div class="mb-3">
                                    <h6>Speed Bonuses</h6>
                                    <div class="d-flex flex-wrap">
                                        <?php foreach ($speedBonuses as $speed): ?>
                                            <span class="badge bg-info me-2 mb-2 p-2">
                                                <?php echo $speed; ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($potential['skilId'] > 0): ?>
                                <div class="mt-3">
                                    <h6>Special Skill</h6>
                                    <p>
                                        Skill ID: <?php echo $potential['skilId']; ?>
                                        <?php if ($potential['skillChance'] > 0): ?>
                                            (<?php echo $potential['skillChance']; ?>% chance)
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
                                <h5 class="mb-0">Stats</h5>
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
                                                <tr>
                                                    <th>STR</th>
                                                    <td><?php echo $doll['str']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>DEX</th>
                                                    <td><?php echo $doll['dex']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>CON</th>
                                                    <td><?php echo $doll['con']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>INT</th>
                                                    <td><?php echo $doll['intel']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>WIS</th>
                                                    <td><?php echo $doll['wis']; ?></td>
                                                </tr>
                                                <?php if (isset($doll['cha'])): ?>
                                                <tr>
                                                    <th>CHA</th>
                                                    <td><?php echo $doll['cha']; ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Combat Abilities</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tbody>
                                                <?php if (isset($doll['dmgmin']) && isset($doll['dmgmax'])): ?>
                                                <tr>
                                                    <th>Damage</th>
                                                    <td><?php echo $doll['dmgmin']; ?> - <?php echo $doll['dmgmax']; ?></td>
                                                </tr>
                                                <?php else: ?>
                                                <tr>
                                                    <th>Damage</th>
                                                    <td>N/A</td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (isset($doll['range'])): ?>
                                                <tr>
                                                    <th>Range</th>
                                                    <td><?php echo $doll['range']; ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tbody>
                                                <?php if (isset($doll['atkspeed'])): ?>
                                                <tr>
                                                    <th>Attack Speed</th>
                                                    <td><?php echo $doll['atkspeed']; ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                
                                                <?php if (isset($doll['movespeed'])): ?>
                                                <tr>
                                                    <th>Move Speed</th>
                                                    <td><?php echo $doll['movespeed']; ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <?php if (isset($doll['passivespell']) && !empty($doll['passivespell'])): ?>
                                <div class="mt-3">
                                    <h6>Passive Effects</h6>
                                    <p><?php echo htmlspecialchars($doll['passivespell']); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if ($dollInfo && $dollInfo['bonusInterval'] > 0): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Bonus Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Bonus Interval:</strong> <?php echo $dollInfo['bonusInterval']; ?> seconds</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Bonus Count:</strong> <?php echo $dollInfo['bonusCount']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($dollInfo && $dollInfo['blessItemId'] > 0): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Enchantment Information</h5>
                            </div>
                            <div class="card-body">
                                <p>This doll can be enhanced using a blessing item (ID: <?php echo $dollInfo['blessItemId']; ?>).</p>
                                <p>Enchanting magic dolls can improve their stats and abilities. Higher grade dolls provide stronger bonuses and passive effects.</p>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    To enchant this doll, you'll need to obtain the specified blessing item and use it on the doll. 
                                    Successful enchantment will increase the doll's grade and enhance its abilities.
                                </div>
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
                    <strong>Magic Doll not found.</strong> The requested doll does not exist.
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