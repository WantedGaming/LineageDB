<?php
// doll_list.php - Listing of available magic dolls
require_once 'database.php';

// Page setup
$page_title = "Magic Dolls Catalog";
include 'header.php';

// Pagination setup
$itemsPerPage = 12;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Filtering options
$gradeFilter = isset($_GET['grade']) ? intval($_GET['grade']) : null;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query with optional filters
$query = "SELECT n.npcid, n.desc_en, mi.name, mi.grade, n.spriteId, 
                 ei.iconid
          FROM npc n
          JOIN magicdoll_info mi ON n.npcid = mi.dollNpcId
          LEFT JOIN etcitem ei ON mi.itemId = ei.item_id
          WHERE n.impl = 'L1Doll'";

$params = [];
$types = '';

if ($gradeFilter !== null) {
    $query .= " AND mi.grade = ?";
    $params[] = $gradeFilter;
    $types .= 'i';
}

if (!empty($searchTerm)) {
    $query .= " AND (n.desc_en LIKE ? OR mi.name LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $types .= 'ss';
}

// Count total filtered results
$countQuery = str_replace('n.npcid, n.desc_en, mi.name, mi.grade, n.spriteId, ei.iconid', 'COUNT(*) as total', $query);
$countStmt = $conn->prepare($countQuery);
if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $itemsPerPage);

// Add pagination to main query
$query .= " ORDER BY mi.grade, n.desc_en LIMIT ? OFFSET ?";
$types .= 'ii';
$params[] = $itemsPerPage;
$params[] = $offset;

// Prepare and execute main query
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h1 class="mb-4">Magic Dolls Catalog</h1>
    
    <!-- Search and Filter Form -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search dolls..." 
                       value="<?php echo htmlspecialchars($searchTerm); ?>">
            </div>
            <div class="col-md-3">
                <select name="grade" class="form-select">
                    <option value="">All Grades</option>
                    <?php 
                    // Get unique grades
                    $gradeQuery = "SELECT DISTINCT grade FROM magicdoll_info ORDER BY grade";
                    $gradeResult = $conn->query($gradeQuery);
                    while ($gradeRow = $gradeResult->fetch_assoc()): ?>
                        <option value="<?php echo $gradeRow['grade']; ?>"
                                <?php echo ($gradeFilter === intval($gradeRow['grade']) ? 'selected' : ''); ?>>
                            Grade <?php echo $gradeRow['grade']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Search
                </button>
            </div>
            <div class="col-md-3 text-end">
                <span class="text-muted">
                    <?php echo $totalRows; ?> dolls found
                </span>
            </div>
        </div>
    </form>
    
    <!-- Dolls Grid -->
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php while ($doll = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-100 doll-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Grade <?php echo $doll['grade']; ?></span>
                    </div>
                    <div class="card-body text-center">
                        <?php
                        // Use iconid from etcitem if available
                        $itemIconPath = null;
                        if (!empty($doll['iconid'])) {
                            $itemIconPath = "icons/icon_{$doll['iconid']}.png";
                        }
                        
                        // Fallback to sprite icon
                        if (!$itemIconPath || !file_exists($itemIconPath)) {
                            $itemIconPath = "icons/ms{$doll['spriteId']}.png";
                        }
                        
                        if (file_exists($itemIconPath)):
                        ?>
                            <img src="<?php echo $itemIconPath; ?>" 
                                 alt="<?php echo htmlspecialchars($doll['desc_en']); ?>" 
                                 class="img-fluid mb-3" 
                                 style="max-height: 200px; object-fit: contain;">
                        <?php else: ?>
                            <div class="text-center mb-3">
                                <i class="bi bi-robot fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h5 class="card-title"><?php echo htmlspecialchars($doll['desc_en']); ?></h5>
                        <?php if (!empty($doll['name'])): ?>
                            <p class="text-muted"><?php echo htmlspecialchars($doll['name']); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-center">
                        <a href="view_doll.php?id=<?php echo $doll['npcid']; ?>" 
                           class="btn btn-sm btn-outline-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Doll list navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page ? 'active' : ''); ?>">
                    <a class="page-link" href="?page=<?php echo $i; 
                        echo ($gradeFilter !== null ? "&grade=$gradeFilter" : '');
                        echo (!empty($searchTerm) ? "&search=" . urlencode($searchTerm) : ''); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>