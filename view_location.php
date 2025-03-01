<?php
// view_location.php - Detailed view of a specific location
require_once 'database.php';

// Page setup
$page_title = "Location Details";
include 'header.php';

// Check if location ID is provided
if (isset($_GET['id'])) {
    $locationId = intval($_GET['id']);
    
    try {
        // Fetch location details 
        $query = "SELECT * FROM mapids WHERE mapid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $locationId);
        $stmt->execute();
        $result = $stmt->get_result();
        $location = $result->fetch_assoc();
        
        if ($location) {
            // Fetch monsters spawning in this location
            $monsterQuery = "SELECT DISTINCT n.npcid, n.desc_en, n.lvl, n.hp, n.spriteId
                             FROM spawnlist s
                             JOIN npc n ON s.npc_templateid = n.npcid
                             WHERE s.mapid = ? AND n.impl = 'L1Monster'
                             ORDER BY n.lvl DESC
                             LIMIT 50";
            $monsterStmt = $conn->prepare($monsterQuery);
            $monsterStmt->bind_param("i", $locationId);
            $monsterStmt->execute();
            $monsterResult = $monsterStmt->get_result();
            ?>
            <div class="container mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="bi bi-map me-2"></i>
                            <?php echo htmlspecialchars($location['locationname'] ?: "Location " . $location['mapid']); ?>
                        </h2>
                        <?php if (!empty($location['dungeon']) && $location['dungeon'] == 1): ?>
                            <span class="badge bg-warning">Dungeon</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Location Details</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Map ID</th>
                                            <td><?php echo $location['mapid']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Coordinates</th>
                                            <td>
                                                X: <?php echo $location['startX'] . ' - ' . $location['endX']; ?><br>
                                                Y: <?php echo $location['startY'] . ' - ' . $location['endY']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monster Count</th>
                                            <td><?php echo number_format($location['monster_amount'] ?? 0); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Location Properties</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <?php
                                        $properties = [
                                            'underwater' => 'Underwater',
                                            'markable' => 'Markable',
                                            'teleportable' => 'Teleportable',
                                            'escapable' => 'Escapable',
                                            'resurrection' => 'Resurrection Possible',
                                            'take_pets' => 'Pets Allowed',
                                            'recall_pets' => 'Pets Recallable'
                                        ];
                                        
                                        foreach ($properties as $key => $label) {
                                            $value = $location[$key] ?? 0;
                                            ?>
                                            <tr>
                                                <th><?php echo $label; ?></th>
                                                <td>
                                                    <?php 
                                                    echo match($value) {
                                                        0 => '<span class="text-danger">No</span>',
                                                        1 => '<span class="text-success">Yes</span>',
                                                        default => htmlspecialchars($value)
                                                    };
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($monsterResult && $monsterResult->num_rows > 0): ?>
                    <div class="card mt-4">
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
                                            <th class="px-3">Icon</th>
                                            <th class="px-3">Monster Name</th>
                                            <th class="px-3">Level</th>
                                            <th class="px-3">HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($monster = $monsterResult->fetch_assoc()): ?>
                                            <tr class="clickable-row" data-href="view_monster.php?id=<?php echo $monster['npcid']; ?>">
                                                <td class="px-3 text-center">
                                                    <?php 
                                                    $monsterIconPath = "icons/ms{$monster['spriteId']}.png";
                                                    if (file_exists($monsterIconPath)): 
                                                    ?>
                                                        <img src="<?php echo $monsterIconPath; ?>" 
                                                             alt="Monster Icon" 
                                                             width="36" 
                                                             height="36" 
                                                             class="img-thumbnail">
                                                    <?php else: ?>
                                                        <div class="text-muted" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-question-circle"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-3">
                                                    <?php echo htmlspecialchars($monster['desc_en']); ?>
                                                </td>
                                                <td class="px-3"><?php echo htmlspecialchars($monster['lvl']); ?></td>
                                                <td class="px-3"><?php echo number_format($monster['hp']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
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
        } else {
            // Location not found
            ?>
            <div class="container mt-4">
                <div class="alert alert-warning">
                    <strong>Location not found.</strong> The requested location does not exist.
                </div>
                <a href="locations_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Locations List
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
    // Redirect if location ID is not provided
    header("Location: locations_list.php");
    exit();
}

include 'footer.php';
?>