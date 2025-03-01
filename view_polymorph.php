<?php
// view_polymorph.php - Detailed view of a specific polymorph
require_once 'database.php';

$page_title = "Polymorph Details";
include 'header.php';

// Validate input
$polyId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($polyId <= 0) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">Invalid Polymorph ID</div>
    </div>
    <?php
    include 'footer.php';
    exit();
}

try {
    // Fetch polymorph details with related item and sprite information
    $query = "SELECT p.*, 
                     pi.itemId, pi.name AS item_name, pi.duration, pi.type AS item_type, 
                     ei.iconId, ei.desc_en AS item_desc,
                     si.spr_name, si.description AS sprite_desc, 
                     si.width, si.height
              FROM polymorphs p
              LEFT JOIN polyitems pi ON p.polyid = pi.polyId
              LEFT JOIN etcitem ei ON pi.itemId = ei.item_id
              LEFT JOIN spr_info si ON p.polyid = si.spr_id
              WHERE p.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $polyId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        ?>
        <div class="container mt-4">
            <div class="alert alert-warning">No polymorph found with ID <?php echo $polyId; ?></div>
        </div>
        <?php
        include 'footer.php';
        exit();
    }
    
    $polymorph = $result->fetch_assoc();
    
    // Get sprite actions
    $actionsQuery = "SELECT * FROM spr_action WHERE spr_id = ? LIMIT 10";
    $actionsStmt = $conn->prepare($actionsQuery);
    $actionsStmt->bind_param("i", $polymorph['polyid']);
    $actionsStmt->execute();
    $actionsResult = $actionsStmt->get_result();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>
                        <?php echo htmlspecialchars($polymorph['name']); ?>
                    </h4>
                </div>
                <div class="card-body text-center">
                    <?php 
                    // Try to get icon
                    $iconPath = !empty($polymorph['iconId']) 
                        ? "icons/icon_{$polymorph['iconId']}.png" 
                        : null;
                    
                    // Try to get sprite image
                    $spritePath = "icons/ms{$polymorph['polyid']}.png";
                    
                    if ($iconPath && file_exists($iconPath)): 
                    ?>
                        <img src="<?php echo $iconPath; ?>" 
                             alt="Polymorph Icon" 
                             class="img-fluid mb-3" 
                             style="max-height: 250px; object-fit: contain;">
                    <?php elseif (file_exists($spritePath)): ?>
                        <img src="<?php echo $spritePath; ?>" 
                             alt="Polymorph Sprite" 
                             class="img-fluid mb-3" 
                             style="max-height: 250px; object-fit: contain;">
                    <?php else: ?>
                        <div class="text-muted mb-3" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 6rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-3">
                        <h5 class="card-title"><?php echo htmlspecialchars($polymorph['name']); ?></h5>
                        <p class="text-muted">Polymorph ID: <?php echo htmlspecialchars($polymorph['polyid']); ?></p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Minimum Level:</strong> 
                            <?php echo htmlspecialchars($polymorph['minlevel']); ?>
                        </div>
                        <div class="badge bg-info">
                            <?php 
                            $tags = [];
                            if ($polymorph['weaponequip']) $tags[] = 'Weapon Equip';
                            if ($polymorph['armorequip']) $tags[] = 'Armor Equip';
                            if ($polymorph['isSkillUse']) $tags[] = 'Skill Use';
                            
                            echo implode(' | ', $tags);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($polymorph['item_name'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Polymorph Item</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>Item Name</th>
                                <td><?php echo htmlspecialchars($polymorph['item_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Item ID</th>
                                <td><?php echo htmlspecialchars($polymorph['itemId']); ?></td>
                            </tr>
                            <tr>
                                <th>Duration</th>
                                <td><?php echo htmlspecialchars($polymorph['duration'] ?: 'N/A'); ?> seconds</td>
                            </tr>
                            <tr>
                                <th>Item Type</th>
                                <td><?php echo htmlspecialchars($polymorph['item_type'] ?: 'N/A'); ?></td>
                            </tr>
                            <?php if (!empty($polymorph['item_desc'])): ?>
                            <tr>
                                <th>Description</th>
                                <td><?php echo htmlspecialchars($polymorph['item_desc']); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Polymorph Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Sprite Information</h6>
                            <table class="table table-sm table-borderless">
                                <?php if (!empty($polymorph['spr_name'])): ?>
                                <tr>
                                    <th>Sprite Name</th>
                                    <td><?php echo htmlspecialchars($polymorph['spr_name']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($polymorph['sprite_desc'])): ?>
                                <tr>
                                    <th>Sprite Description</th>
                                    <td><?php echo htmlspecialchars($polymorph['sprite_desc']); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($polymorph['width'] > 0 && $polymorph['height'] > 0): ?>
                                <tr>
                                    <th>Sprite Dimensions</th>
                                    <td><?php echo "{$polymorph['width']} x {$polymorph['height']}"; ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Polymorph Attributes</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Cause</th>
                                    <td><?php echo htmlspecialchars($polymorph['cause'] ?: 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <th>PVP Bonus</th>
                                    <td>
                                        <?php echo $polymorph['bonusPVP'] ? 
                                            '<span class="badge bg-success">Yes</span>' : 
                                            '<span class="badge bg-secondary">No</span>'; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Long Form Enabled</th>
                                    <td>
                                        <?php echo $polymorph['formLongEnable'] ? 
                                            '<span class="badge bg-success">Yes</span>' : 
                                            '<span class="badge bg-secondary">No</span>'; 
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if ($actionsResult->num_rows > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sprite Actions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Action Name</th>
                                    <th>Frame Count</th>
                                    <th>Frame Rate</th>
                                    <th>Number of Frames</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($action = $actionsResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($action['act_name']); ?></td>
                                    <td><?php echo htmlspecialchars($action['framecount']); ?></td>
                                    <td><?php echo htmlspecialchars($action['framerate']); ?></td>
                                    <td><?php echo htmlspecialchars($action['numOfFrame']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="text-center mt-4 mb-4">
        <a href="polymorph_list.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Polymorph List
        </a>
    </div>
</div>

<?php 
include 'footer.php'; 
} catch (Exception $e) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">
            <strong>Error:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>
        </div>
    </div>
    <?php
    include 'footer.php';
}
?>