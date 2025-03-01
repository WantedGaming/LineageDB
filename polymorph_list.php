<?php
// polymorph_list.php - List of Polymorphs
require_once 'database.php';

$page_title = "Polymorph List";
include 'header.php';

// Pagination setup
$itemsPerPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Filtering options
$filters = [
    'search' => $_GET['search'] ?? '',
    'min_level' => isset($_GET['min_level']) ? intval($_GET['min_level']) : 0,
    'max_level' => isset($_GET['max_level']) ? intval($_GET['max_level']) : 0,
    'class' => $_GET['class'] ?? []
];

// Build query
$conditions = [];
$params = [];
$types = '';

// Search condition
if (!empty($filters['search'])) {
    $conditions[] = "(p.name LIKE ? OR p.polyid = ?)";
    $searchParam = "%{$filters['search']}%";
    $params[] = $searchParam;
    $params[] = is_numeric($filters['search']) ? intval($filters['search']) : 0;
    $types .= 'si';
}

// Level range conditions
if ($filters['min_level'] > 0) {
    $conditions[] = "p.minlevel >= ?";
    $params[] = $filters['min_level'];
    $types .= 'i';
}

if ($filters['max_level'] > 0) {
    $conditions[] = "p.minlevel <= ?";
    $params[] = $filters['max_level'];
    $types .= 'i';
}

// Construct WHERE clause
$whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Count total items
$countQuery = "SELECT COUNT(*) as total FROM polymorphs p $whereClause";
$countStmt = $conn->prepare($countQuery);
if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalItems = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Main query to fetch polymorphs
// Include the icon finding function
require_once 'includes/polymorph_icon_function.php';

$query = "SELECT p.*, pi.itemId, ei.iconId as etcitem_icon
          FROM polymorphs p
          LEFT JOIN polyitems pi ON p.polyid = pi.polyId
          LEFT JOIN etcitem ei ON pi.itemId = ei.item_id
          $whereClause
          GROUP BY p.id
          LIMIT ? OFFSET ?";

// Add pagination parameters
$types .= 'ii';
$params[] = $itemsPerPage;
$params[] = $offset;

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-funnel me-2"></i>Filters
                    </h5>
                </div>
                <div class="card-body">
                    <form method="get" action="">
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="<?php echo htmlspecialchars($filters['search']); ?>" 
                                   placeholder="Search by name or ID">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Level Range</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" name="min_level" 
                                           placeholder="Min Level"
                                           value="<?php echo $filters['min_level'] ?: ''; ?>">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="max_level" 
                                           placeholder="Max Level"
                                           value="<?php echo $filters['max_level'] ?: ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-2"></i>Apply Filters
                        </button>
                        
                        <?php if (!empty($filters['search']) || $filters['min_level'] > 0 || $filters['max_level'] > 0): ?>
                            <a href="polymorph_list.php" class="btn btn-secondary w-100 mt-2">
                                <i class="bi bi-x-circle me-2"></i>Clear Filters
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>What are Polymorphs?
                    </h5>
                </div>
                <div class="card-body">
                    <p>Polymorphs are special transformation abilities in the game that allow characters to change their form, gaining unique characteristics and abilities.</p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle text-success me-2"></i>Change appearance</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Modify character stats</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Enable special skills</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Temporary transformation</li>
                    </ul>
                    <p class="small text-muted">Each polymorph has unique requirements and effects.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-badge me-2"></i>Polymorphs
                        <small class="text-muted ms-2">(<?php echo number_format($totalItems); ?> total)</small>
                    </h4>
                </div>
                <div class="card-body p-0">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 clickable-table">
                                <thead>
                                    <tr>
                                        <th class="px-3">Icon</th>
                                        <th class="px-3">Name</th>
                                        <th class="px-3">Poly ID</th>
                                        <th class="px-3">Min Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($polymorph = $result->fetch_assoc()): ?>
                                        <tr data-href="view_polymorph.php?id=<?php echo $polymorph['id']; ?>" 
                                            class="cursor-pointer">
                                            <td class="px-3">
                                                <?php 
                                                $iconPath = !empty($polymorph['iconId']) 
                                                    ? "icons/icon_{$polymorph['iconId']}.png" 
                                                    : null;
                                                
                                                $spritePath = "icons/ms{$polymorph['polyid']}.png";
                                                
                                                if ($iconPath && file_exists($iconPath)): 
                                                ?>
                                                    <img src="<?php echo $iconPath; ?>" 
                                                         alt="Polymorph Icon" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 50px; max-height: 50px;">
                                                <?php elseif (file_exists($spritePath)): ?>
                                                    <img src="<?php echo $spritePath; ?>" 
                                                         alt="Polymorph Sprite" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 50px; max-height: 50px;">
                                                <?php else: ?>
                                                    <div class="text-muted text-center">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3">
                                                <?php echo htmlspecialchars($polymorph['name']); ?>
                                            </td>
                                            <td class="px-3">
                                                <?php echo htmlspecialchars($polymorph['polyid']); ?>
                                            </td>
                                            <td class="px-3">
                                                <?php echo htmlspecialchars($polymorph['minlevel']); ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center">
                            <div class="display-6 text-muted mb-3"><i class="bi bi-search"></i></div>
                            <h5>No polymorphs found</h5>
                            <p class="text-muted">Try adjusting your filters.</p>
                            <a href="polymorph_list.php" class="btn btn-outline-secondary">Reset Filters</a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($totalPages > 1): ?>
                    <div class="card-footer">
                        <nav aria-label="Polymorph list navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <?php 
                                // Calculate page range
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                
                                // Previous page
                                if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; 
                                            echo !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '';
                                            echo $filters['min_level'] > 0 ? '&min_level=' . $filters['min_level'] : '';
                                            echo $filters['max_level'] > 0 ? '&max_level=' . $filters['max_level'] : '';
                                        ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php 
                                // First page
                                if ($startPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=1<?php 
                                            echo !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '';
                                            echo $filters['min_level'] > 0 ? '&min_level=' . $filters['min_level'] : '';
                                            echo $filters['max_level'] > 0 ? '&max_level=' . $filters['max_level'] : '';
                                        ?>">1</a>
                                    </li>
                                    <?php if ($startPage > 2): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; 
                                endif; 
                                
                                // Page numbers
                                for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; 
                                            echo !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '';
                                            echo $filters['min_level'] > 0 ? '&min_level=' . $filters['min_level'] : '';
                                            echo $filters['max_level'] > 0 ? '&max_level=' . $filters['max_level'] : '';
                                        ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; 
                                
                                // Last page
                                if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $totalPages; 
                                            echo !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '';
                                            echo $filters['min_level'] > 0 ? '&min_level=' . $filters['min_level'] : '';
                                            echo $filters['max_level'] > 0 ? '&max_level=' . $filters['max_level'] : '';
                                        ?>"><?php echo $totalPages; ?></a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php // Next page
                                if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; 
                                            echo !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '';
                                            echo $filters['min_level'] > 0 ? '&min_level=' . $filters['min_level'] : '';
                                            echo $filters['max_level'] > 0 ? '&max_level=' . $filters['max_level'] : '';
                                        ?>">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make entire rows clickable
    const rows = document.querySelectorAll('.clickable-table tr[data-href]');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
        row.style.cursor = 'pointer';
    });
});
</script>
