<?php
// view_location.php - Detailed view of a specific location
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database.php';

// Page setup
$page_title = "Location Details";
include 'header.php';

// Validate and sanitize input
$mapId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Debug logging
error_log("Requested Map ID: " . $mapId);

if ($mapId <= 0) {
    ?>
    <div class="container mt-4">
        <div class="alert alert-danger">
            Invalid Location ID. 
            <?php 
            // Additional debugging information
            echo "Raw ID from GET: " . htmlspecialchars($_GET['id'] ?? 'No ID provided'); 
            ?>
        </div>
    </div>
    <?php
    include 'footer.php';
    exit();
}

try {
    // Fetch total number of locations first
    $totalLocationsQuery = "SELECT COUNT(*) as total FROM mapids";
    $totalStmt = $conn->prepare($totalLocationsQuery);
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalLocations = $totalResult->fetch_assoc()['total'];
    
    error_log("Total locations in database: " . $totalLocations);

    // Fetch location details
    $query = "SELECT * FROM mapids WHERE mapid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $mapId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if location exists
    if ($result->num_rows === 0) {
        ?>
        <div class="container mt-4">
            <div class="alert alert-warning">
                No location found with ID <?php echo $mapId; ?>
                <br>
                Total locations in database: <?php echo $totalLocations; ?>
                <br>
                Available Map IDs range from 1 to <?php echo $totalLocations; ?>
            </div>
        </div>
        <?php
        include 'footer.php';
        exit();
    }

    // Fetch location details
    $location = $result->fetch_assoc();

    // Prepare icon path
    $iconPath = "icons/{$location['pngId']}.png";
    $hasIcon = !empty($location['pngId']) && file_exists($iconPath);

    // Boolean columns to display (with more descriptive names)
    $booleanColumns = [
        'underwater' => 'Underwater Access',
        'markable' => 'Can Mark Location',
        'teleportable' => 'Teleportation Allowed',
        'escapable' => 'Can Escape',
        'resurrection' => 'Resurrection Possible',
        'painwand' => 'Painwand Usable',
        'take_pets' => 'Pets Allowed',
        'recall_pets' => 'Pets Can Be Recalled',
        'usable_item' => 'Items Usable',
        'usable_skill' => 'Skills Usable',
        'dungeon' => 'Dungeon Location',
    ];

    // Fetch monsters spawning in this location
    $monsterQuery = "SELECT DISTINCT n.npcid, n.desc_en, n.hp, n.mp, n.exp 
                 FROM spawnlist s
                 JOIN npc n ON s.npc_templateid = n.npcid
                 WHERE s.mapid = ?
                 LIMIT 50";
    $monsterStmt = $conn->prepare($monsterQuery);
    $monsterStmt->bind_param("i", $mapId);
    $monsterStmt->execute();
    $monsterResult = $monsterStmt->get_result();

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

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="map-container mb-4" style="
                background-color: rgba(255,255,255,0.05);
                border: 2px solid var(--border-color);
                border-radius: 12px;
                padding: 15px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                overflow: hidden;
            ">
                <?php if ($hasIcon): ?>
                    <img 
                        src="<?php echo $iconPath; ?>" 
                        alt="Location Icon" 
                        class="img-fluid w-100" 
                        style="
                            max-height: 800px; 
                            object-fit: contain; 
                            border-radius: 8px;
                            border: 1px solid rgba(255,255,255,0.1);
                        "
                    >
                <?php else: ?>
                    <div class="no-icon text-muted" style="
                        height: 600px; 
                        display: flex; 
                        align-items: center; 
                        justify-content: center; 
                        background-color: rgba(255,255,255,0.1);
                        border-radius: 8px;
                    ">
                        <div class="text-center">
                            <i class="bi bi-image" style="font-size: 6rem;"></i>
                            <p class="mt-3">No Icon Available</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th class="ps-0">Map ID</th>
                            <td class="text-end pe-0"><?php echo htmlspecialchars($location['mapid']); ?></td>
                        </tr>
                        <tr>
                            <th class="ps-0">Location Name</th>
                            <td class="text-end pe-0"><?php echo htmlspecialchars($location['locationname']); ?></td>
                        </tr>
                        <tr>
                            <th class="ps-0">Coordinates</th>
                            <td class="text-end pe-0">
                                Start: (<?php echo htmlspecialchars($location['startX']) . ',' . htmlspecialchars($location['startY']); ?>)<br>
                                End: (<?php echo htmlspecialchars($location['endX']) . ',' . htmlspecialchars($location['endY']); ?>)
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
			
        </div>
    </div>

    <?php 
    // Filter out attributes that are false
    $activeAttributes = array_filter($booleanColumns, function($column) use ($location) {
        return $location[$column] == 1;
    }, ARRAY_FILTER_USE_KEY);

    if (!empty($activeAttributes)): 
    ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Allowed</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($activeAttributes as $column => $label): ?>
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="<?php echo $column; ?>" 
                                        checked 
                                        disabled
                                    >
                                    <label class="form-check-label" for="<?php echo $column; ?>">
                                        <?php echo htmlspecialchars($label); ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($monsterResult && $monsterResult->num_rows > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-bug me-2"></i>Monsters
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="px-3">Monster Name</th>
                                    <th class="px-3 text-center">HP</th>
                                    <th class="px-3 text-center">MP</th>
                                    <th class="px-3 text-center">EXP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($monster = $monsterResult->fetch_assoc()): ?>
                                    <tr class="clickable-row" data-href="view_monster.php?id=<?php echo $monster['npcid']; ?>">
                                        <td class="px-3">
                                            <?php echo htmlspecialchars($monster['desc_en']); ?>
                                        </td>
                                        <td class="px-3 text-center"><?php echo htmlspecialchars($monster['hp']); ?></td>
                                        <td class="px-3 text-center"><?php echo htmlspecialchars($monster['mp']); ?></td>
                                        <td class="px-3 text-center"><?php echo htmlspecialchars($monster['exp']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="text-center mt-4">
        <a href="locations_list.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Locations
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.clickable-row');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
        row.style.cursor = 'pointer';
    });
});
</script>

<?php 
// Close statements
$stmt->close();
$monsterStmt->close();
$totalStmt->close();

include 'footer.php'; 
?>