<?php
// view_monster.php - Monster Listing Page
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
$filterQuery = '';
$bindParams = [];
$bindTypes = '';

if (!empty($searchTerm)) {
    $filterQuery = "WHERE impl = 'L1Monster' AND (desc_en LIKE ? OR npcid LIKE ?)";
    $searchParam = "%{$searchTerm}%";
    $bindParams = [&$searchParam, &$searchParam];
    $bindTypes = 'ss';
} else {
    $filterQuery = "WHERE impl = 'L1Monster'";
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
    $query = "SELECT npcid, desc_en, lvl, hp, impl, spriteId 
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
                <a href="index.php" class="btn btn-secondary">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($monster = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($monster['npcid']); ?></td>
                            <td>
                                <?php 
                                $spritePath = "sprites/{$monster['spriteId']}.png";
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
                            <td><?php echo htmlspecialchars($monster['desc_en']); ?></td>
                            <td><?php echo htmlspecialchars($monster['lvl']); ?></td>
                            <td><?php echo htmlspecialchars($monster['hp']); ?></td>
                            <td>
                                <a href="view_monster.php?id=<?php echo $monster['npcid']; ?>" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                            </td>
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
                               echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
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
                               echo !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : ''; ?>">
                                Next<i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
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