<?php
// view_monster.php - Detailed view of a specific monster
require_once 'database.php';

// Page setup
$page_title = "Monster Details";
include 'header.php';

// Validate and sanitize input
$monsterId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($monsterId <= 0) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">Invalid Monster ID</div>
    </div>
    <?php
    include 'footer.php';
    exit();
}

try {
    // Fetch monster details from npc table
    $monsterQuery = "SELECT * FROM npc WHERE npcid = ?";
    $monsterStmt = $conn->prepare($monsterQuery);
    $monsterStmt->bind_param("i", $monsterId);
    $monsterStmt->execute();
    $monsterResult = $monsterStmt->get_result();

    // Check if monster exists
    if ($monsterResult->num_rows === 0) {
        ?>
        <div class="container mt-4">
            <div class="alert alert-warning">No monster found with ID <?php echo $monsterId; ?></div>
        </div>
        <?php
        include 'footer.php';
        exit();
    }

    // Fetch monster details
    $monster = $monsterResult->fetch_assoc();

    // Fetch drops for this monster
    $dropsQuery = "SELECT 
                    d.itemId, 
                    a.desc_en AS item_name, 
                    a.type AS item_type, 
                    d.chance 
                   FROM droplist d
                   LEFT JOIN armor a ON d.itemId = a.item_id
                   WHERE d.mobId = ?
                   ORDER BY d.chance DESC";
    $dropsStmt = $conn->prepare($dropsQuery);
    $dropsStmt->bind_param("i", $monsterId);
    $dropsStmt->execute();
    $dropsResult = $dropsStmt->get_result();

    // Prepare sprite path (adjust as needed)
    $spritePath = "sprites/{$monster['spriteId']}.png";
    $hasSprite = !empty($monster['spriteId']) && file_exists($spritePath);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-bug me-2"></i>Monster Details
                    </h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($hasSprite): ?>
                        <img src="<?php echo $spritePath; ?>" alt="Monster Sprite" class="img-fluid mb-3" style="max-width: 200px;">
                    <?php else: ?>
                        <div class="no-sprite text-muted mb-3" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 4rem;"></i>
                            <p>No Sprite Available</p>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="card-title">
                        <?php echo htmlspecialchars($monster['desc_en']); ?>
                    </h4>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Monster Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Monster ID</th>
                                    <td><?php echo htmlspecialchars($monster['npcid']); ?></td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td><?php echo htmlspecialchars($monster['lvl']); ?></td>
                                </tr>
                                <tr>
                                    <th>HP</th>
                                    <td><?php echo htmlspecialchars($monster['hp']); ?></td>
                                </tr>
                                <tr>
                                    <th>MP</th>
                                    <td><?php echo htmlspecialchars($monster['mp']); ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Combat Statistics</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Armor Class</th>
                                    <td><?php echo htmlspecialchars($monster['ac']); ?></td>
                                </tr>
                                <tr>
                                    <th>Strength</th>
                                    <td><?php echo htmlspecialchars($monster['str']); ?></td>
                                </tr>
                                <tr>
                                    <th>Constitution</th>
                                    <td><?php echo htmlspecialchars($monster['con']); ?></td>
                                </tr>
                                <tr>
                                    <th>Experience</th>
                                    <td><?php echo htmlspecialchars($monster['exp']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>Additional Attributes</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Boss Monster:</strong> 
                                <?php echo $monster['is_bossmonster'] ? 'Yes' : 'No'; ?><br>
                                <strong>Aggressive:</strong> 
                                <?php echo $monster['is_agro'] ? 'Yes' : 'No'; ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Undead Type:</strong> 
                                <?php echo !empty($monster['undead']) ? htmlspecialchars($monster['undead']) : 'N/A'; ?><br>
                                <strong>Weakness:</strong> 
                                <?php echo !empty($monster['weakAttr']) ? htmlspecialchars($monster['weakAttr']) : 'N/A'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($dropsResult->num_rows > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam me-2"></i>Item Drops
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Type</th>
                                <th>Drop Chance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($drop = $dropsResult->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <a href="view_armor.php?id=<?php echo intval($drop['itemId']); ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($drop['item_name']); ?>
                                        <i class="bi bi-box-arrow-up-right small text-muted ms-1"></i>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($drop['item_type']); ?></td>
                                <td><?php echo htmlspecialchars($drop['chance']); ?>%</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Listing
        </a>
    </div>
</div>

<?php 
// Close statements
$monsterStmt->close();
$dropsStmt->close();

include 'footer.php'; 
?>