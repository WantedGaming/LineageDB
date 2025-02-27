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

    // Boolean columns to display
    $booleanColumns = [
        'underwater' => 'Underwater Location',
        'markable' => 'Can Mark Location',
        'teleportable' => 'Teleportation Allowed',
        'escapable' => 'Can Escape',
        'resurrection' => 'Resurrection Possible',
        'painwand' => 'Painwand Usable',
        'take_pets' => 'Pets Allowed',
        'recall_pets' => 'Pets Can Be Recalled',
        'usable_item' => 'Items Usable',
        'usable_skill' => 'Skills Usable',
        'dungeon' => 'Is Dungeon',
    ];

    // Fetch monsters spawning in this location
    $monsterQuery = "SELECT DISTINCT n.npcid, n.desc_en, n.hp, n.mp, n.exp 
                     FROM spawnlist s
                     JOIN npc n ON s.npcid = n.npcid
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

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="locations_list.php">Locations</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($location['locationname']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-map me-2"></i>Location Details
                    </h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($hasIcon): ?>
                        <img src="<?php echo $iconPath; ?>" alt="Location Icon" class="img-fluid mb-3" style="max-width: 200px;">
                    <?php else: ?>
                        <div class="no-icon text-muted mb-3" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image" style="font-size: 4rem;"></i>
                            <p>No Icon Available</p>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="card-title">
                        <?php echo htmlspecialchars($location['locationname']); ?>
                    </h4>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Location Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Map ID</th>
                                    <td><?php echo htmlspecialchars($location['mapid']); ?></td>
                                </tr>
                                <tr>
                                    <th>Coordinates</th>
                                    <td>
                                        Start: (<?php echo htmlspecialchars($location['startX']) . ',' . htmlspecialchars($location['startY']); ?>)<br>
                                        End: (<?php echo htmlspecialchars($location['endX']) . ',' . htmlspecialchars($location['endY']); ?>)
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Location Attributes</h6>
                            <div class="row">
                                <?php foreach ($booleanColumns as $column => $label): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="<?php echo $column; ?>" 
                                                <?php echo $location[$column] ? 'checked' : ''; ?> 
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

            <?php if ($monsterResult && $monsterResult->num_rows > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-bug me-2"></i>Monsters in this Location
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
            <?php endif; ?>
        </div>
    </div>
    
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