<?php
// monster_list.php - Monster Listing Page
require_once 'database.php';

// Page setup
$page_title = "Monster Database";
include 'header.php';

// Pagination setup
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$monstersPerPage = 25;
$offset = ($page - 1) * $monstersPerPage;

// Prepare filtered query
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$minLevel = isset($_GET['min_level']) ? intval($_GET['min_level']) : 0; 
$maxLevel = isset($_GET['max_level']) ? intval($_GET['max_level']) : 0;
$minHP = isset($_GET['min_hp']) ? intval($_GET['min_hp']) : 0;
$maxHP = isset($_GET['max_hp']) ? intval($_GET['max_hp']) : 0;
$isBoss = isset($_GET['is_boss']) ? boolval($_GET['is_boss']) : false;
$elementalResist = isset($_GET['elemental_resist']) ? $_GET['elemental_resist'] : '';

$filterQuery = "WHERE impl = 'L1Monster'";
$bindParams = [];
$bindTypes = '';

if (!empty($searchTerm)) {
    $filterQuery .= " AND (desc_en LIKE ? OR npcid LIKE ?)";
    $searchParam = "%{$searchTerm}%";
    $bindParams[] = &$searchParam;
    $bindParams[] = &$searchParam;
    $bindTypes .= 'ss'; 
}

if ($minLevel > 0) {
    $filterQuery .= " AND lvl >= ?";
    $bindParams[] = &$minLevel;
    $bindTypes .= 'i';
}

if ($maxLevel > 0) {
    $filterQuery .= " AND lvl <= ?";
    $bindParams[] = &$maxLevel;
    $bindTypes .= 'i';
}

if ($minHP > 0) {
    $filterQuery .= " AND hp >= ?"; 
    $bindParams[] = &$minHP;
    $bindTypes .= 'i';
}

if ($maxHP > 0) {
    $filterQuery .= " AND hp <= ?";
    $bindParams[] = &$maxHP; 
    $bindTypes .= 'i';
}

if ($isBoss) {
    $filterQuery .= " AND is_bossmonster = true";
}

if (!empty($elementalResist)) {
    $filterQuery .= " AND weakAttr LIKE ?";
    $resistParam = "%{$elementalResist}%";
    $bindParams[] = &$resistParam;
    $bindTypes .= 's';
}

try {
    // Count total monsters
    $countQuery = "SELECT COUNT(*) AS total FROM npc {$filterQuery}";
    $countStmt = $conn->prepare($countQuery);
    
    if (!empty($bindParams)) {
        $countStmt->bind_param($bindTypes, ...$bindParams);
    }
    
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalMonsters = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalMonsters / $monstersPerPage);
    $countStmt->close();

    // Fetch monsters
    $query = "SELECT npcid, desc_en, lvl, hp, impl, spriteId, weakAttr, is_bossmonster  
              FROM npc
              {$filterQuery}
              ORDER BY npcid
              LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($query);
    
    if (!empty($bindParams)) {
        // Add LIMIT and OFFSET parameters
        $bindParams[] = &$monstersPerPage;
        $bindParams[] = &$offset;
        $bindTypes .= 'ii';
        $stmt->bind_param($bindTypes, ...$bindParams);
    } else {
        // Just bind LIMIT and OFFSET
        $stmt->bind_param('ii', $monstersPerPage, $offset);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
?>

<div class="container mt-4">
    <h1 class="mb-4">Monster Database</h1>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Filters -->
            <form method="GET" action="" class="mb-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="min_level" class="form-label">Min Level</label>
                            <input type="number" name="min_level" id="min_level"
                                   class="form-control" min="0"  
                                   value="<?php echo htmlspecialchars($minLevel); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="max_level" class="form-label">Max Level</label>
                            <input type="number" name="max_level" id="max_level"
                                   class="form-control" min="0"
                                   value="<?php echo htmlspecialchars($maxLevel); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="min_hp" class="form-label">Min HP</label>
                            <input type="number" name="min_hp" id="min_hp"
                                   class="form-control" min="0"
                                   value="<?php echo htmlspecialchars($minHP); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="max_hp" class="form-label">Max HP</label>
                            <input type="number" name="max_hp" id="max_hp" 
                                   class="form-control" min="0"
                                   value="<?php echo htmlspecialchars($maxHP); ?>">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_boss" id="is_boss" 
                                       class="form-check-input"
                                       <?php if ($isBoss) echo 'checked'; ?>>
                                <label for="is_boss" class="form-check-label">Boss Monster</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="elemental_resist" class="form-label">Elemental Resistance</label>
                            <select name="elemental_resist" id="elemental_resist" class="form-select">
                                <option value="" <?php if (empty($elementalResist)) echo 'selected'; ?>>Any</option>
                                <option value="water" <?php if ($elementalResist === 'water') echo 'selected'; ?>>Water</option>
                                <option value="wind" <?php if ($elementalResist === 'wind') echo 'selected'; ?>>Wind</option>
                                <option value="earth" <?php if ($elementalResist === 'earth') echo 'selected'; ?>>Earth</option>
                                <option value="fire" <?php if ($elementalResist === 'fire') echo 'selected'; ?>>Fire</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-2"></i>Apply Filters
                        </button>
                        <?php if ($minLevel > 0 || $maxLevel > 0 || $minHP > 0 || $maxHP > 0 || 
                                  $isBoss || !empty($elementalResist)): ?>
                            <a href="monster_list.php" class="btn btn-secondary w-100 mt-2">
                                <i class="bi bi-x-circle me-2"></i>Clear Filters
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="col-md-9">
            <!-- Search Form -->  
            <form method="GET" action="" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search monsters by name or ID"
                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                    <?php if (!empty($searchTerm)): ?>
                        <a href="monster_list.php?min_level=<?=$minLevel?>&max_level=<?=$maxLevel?>&min_hp=<?=$minHP?>&max_hp=<?=$maxHP?>&is_boss=<?=$isBoss?>&elemental_resist=<?=$elementalResist?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Clear
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Monsters Table -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-bug me-2"></i>Monsters
                            <?php if (!empty($searchTerm)): ?>
                                <small class="text-muted">
                                    (Search: <?php echo htmlspecialchars($searchTerm); ?>)
                                </small>
                            <?php endif; ?>
                        </h5>
                        <span class="badge bg-info">
                            Total Monsters: <?php echo $totalMonsters; ?>
                        </span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sprite</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>HP</th>
                                <th>Weakness</th>
                                <th>Boss</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($monster = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($monster['npcid']); ?></td>
                                    <td>
                                        <?php
                                        $spritePath = "icons/ms{$monster['spriteId']}.png";
                                        if (file_exists($spritePath)):
                                        ?>
                                            <img src="<?php echo $spritePath; ?>"
                                                 alt="Sprite"
                                                 style="max-width: 50px; max-height: 50px;"
                                                 class="img-thumbnail">
                                        <?php else: ?>
                                            <i class="bi bi-image text-muted"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="view_monster.php?id=<?php echo $monster['npcid']; ?>">
                                            <?php echo htmlspecialchars($monster['desc_en']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($monster['lvl']); ?></td>
                                    <td><?php echo htmlspecialchars($monster['hp']); ?></td>
                                    <td><?php echo htmlspecialchars($monster['weakAttr']); ?></td>
                                    <td><?php echo $monster['is_bossmonster'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <nav aria-label="Monster page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" 
                                       href="?page=<?php echo $page - 1;
                                       echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : '';
                                       echo $minLevel > 0 ? '&min_level=' . $minLevel : '';
                                       echo $maxLevel > 0 ? '&max_level=' . $maxLevel : '';
                                       echo $minHP > 0 ? '&min_hp=' . $minHP : '';
                                       echo $maxHP > 0 ? '&max_hp=' . $maxHP : '';
                                       echo $isBoss ? '&is_boss=1' : '';
                                       echo !empty($elementalResist) ? '&elemental_resist=' . $elementalResist : '';
                                       ?>">
                                        <i class="bi bi-chevron-left me-1"></i>Previous
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li class="page-item disabled">
                                <span class="page-link">
                                    Page <?php echo $page; ?> of <?php echo $totalPages; ?>
                                </span>
                            </li>
                
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="?page=<?php echo $page + 1;
                                       echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : '';
                                       echo $minLevel > 0 ? '&min_level=' . $minLevel : '';
                                       echo $maxLevel > 0 ? '&max_level=' . $maxLevel : '';
                                       echo $minHP > 0 ? '&min_hp=' . $minHP : '';
                                       echo $maxHP > 0 ? '&max_hp=' . $maxHP : '';
                                       echo $isBoss ? '&is_boss=1' : '';
                                       echo !empty($elementalResist) ? '&elemental_resist=' . $elementalResist : '';  
                                       ?>">
                                        Next<i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
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
} finally {
    include 'footer.php';
}
?>