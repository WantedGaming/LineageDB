<?php
// armor_list.php - Main page showing armor list with advanced filters
require_once 'database.php';

$page_title = "Armor List - Game Armor Database";
include 'header.php';

// Default filters
$filters = [
    'search' => '',
    'grade' => [],
    'type' => [],
    'min_level' => '',
    'max_level' => '',
    'class' => [],
    'material' => '',
    'sort' => 'item_id',
    'order' => 'ASC'
];

// Get filter values from URL
foreach ($filters as $key => $default) {
    if ($key == 'grade' || $key == 'type' || $key == 'class') {
        $filters[$key] = isset($_GET[$key]) && is_array($_GET[$key]) ? $_GET[$key] : [];
    } else {
        $filters[$key] = isset($_GET[$key]) ? sanitize($conn, $_GET[$key]) : $default;
    }
}

// Items per page and pagination
$itemsPerPage = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Build the WHERE clause based on filters
$conditions = [];
$params = [];

// Exclude accessory types (these will go to accessory_list.php)
$accessoryTypes = ['PENDANT', 'BADGE', 'SENTENCE', 'RON', 'EARRING', 'BELT', 'RING', 'RING_2', 'AMULET'];
$conditions[] = "type NOT IN ('" . implode("','", $accessoryTypes) . "')";


if (!empty($filters['search'])) {
    $conditions[] = "(desc_en LIKE ? OR item_name_id LIKE ? OR item_id = ?)";
    $params[] = "%" . $filters['search'] . "%";
    $params[] = "%" . $filters['search'] . "%";
    $params[] = is_numeric($filters['search']) ? (int)$filters['search'] : 0;
}

if (!empty($filters['grade'])) {
    $gradeConditions = [];
    foreach ($filters['grade'] as $grade) {
        $gradeConditions[] = "itemGrade = ?";
        $params[] = sanitize($conn, $grade);
    }
    if (!empty($gradeConditions)) {
        $conditions[] = "(" . implode(" OR ", $gradeConditions) . ")";
    }
}

if (!empty($filters['type'])) {
    $typeConditions = [];
    foreach ($filters['type'] as $type) {
        $typeConditions[] = "type = ?";
        $params[] = sanitize($conn, $type);
    }
    if (!empty($typeConditions)) {
        $conditions[] = "(" . implode(" OR ", $typeConditions) . ")";
    }
}

if (!empty($filters['min_level'])) {
    $conditions[] = "grade >= ?";
    $params[] = (int)$filters['min_level'];
}

if (!empty($filters['max_level'])) {
    $conditions[] = "grade <= ?";
    $params[] = (int)$filters['max_level'];
}

if (!empty($filters['class'])) {
    $classConditions = [];
    foreach ($filters['class'] as $class) {
        switch ($class) {
            case 'royal':
                $classConditions[] = "use_royal = 1";
                break;
            case 'knight':
                $classConditions[] = "use_knight = 1";
                break;
            case 'mage':
                $classConditions[] = "use_mage = 1";
                break;
            case 'elf':
                $classConditions[] = "use_elf = 1";
                break;
            case 'darkelf':
                $classConditions[] = "use_darkelf = 1";
                break;
            case 'dragonknight':
                $classConditions[] = "use_dragonknight = 1";
                break;
            case 'illusionist':
                $classConditions[] = "use_illusionist = 1";
                break;
            case 'warrior':
                $classConditions[] = "use_warrior = 1";
                break;
            case 'fencer':
                $classConditions[] = "use_fencer = 1";
                break;
            case 'lancer':
                $classConditions[] = "use_lancer = 1";
                break;
        }
    }
    if (!empty($classConditions)) {
        $conditions[] = "(" . implode(" OR ", $classConditions) . ")";
    }
}

if (!empty($filters['material'])) {
    $conditions[] = "material = ?";
    $params[] = sanitize($conn, $filters['material']);
}

// Create the WHERE clause
$whereClause = !empty($conditions) ? " WHERE " . implode(" AND ", $conditions) : "";

// Count total items for pagination
$countQuery = "SELECT COUNT(*) as total FROM armor" . $whereClause;
$stmt = $conn->prepare($countQuery);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$countResult = $stmt->get_result();
$totalItems = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Validate sorting parameters
$validSortColumns = ['item_id', 'desc_en', 'itemGrade', 'type', 'grade', 'ac', 'iconId'];
$validOrders = ['ASC', 'DESC'];

$sortColumn = in_array($filters['sort'], $validSortColumns) ? $filters['sort'] : 'item_id';
$sortOrder = in_array(strtoupper($filters['order']), $validOrders) ? strtoupper($filters['order']) : 'ASC';

// Get armor items with sorting - Only select needed columns
$query = "SELECT item_id, desc_en, itemGrade, type, grade, ac, iconId 
          FROM armor" . $whereClause . 
         " ORDER BY $sortColumn $sortOrder LIMIT ?, ?";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $paramsCopy = $params; // Create a copy to avoid modifying the original array
    $paramsCopy[] = $offset;
    $paramsCopy[] = $itemsPerPage;
    $types = str_repeat('s', count($params)) . 'ii';
    $stmt->bind_param($types, ...$paramsCopy);
} else {
    $stmt->bind_param('ii', $offset, $itemsPerPage);
}

$stmt->execute();
$result = $stmt->get_result();

// Get all item grades for filter
$gradesQuery = "SELECT DISTINCT itemGrade FROM armor ORDER BY CASE 
                WHEN itemGrade = 'MYTH' THEN 1
                WHEN itemGrade = 'LEGEND' THEN 2
                WHEN itemGrade = 'HERO' THEN 3
                WHEN itemGrade = 'RARE' THEN 4
                WHEN itemGrade = 'ADVANC' THEN 5
                WHEN itemGrade = 'NORMAL' THEN 6
                ELSE 7 END";
$gradesResult = $conn->query($gradesQuery);

// Get all armor types for filter (excluding accessory types)
$typesQuery = "SELECT DISTINCT type FROM armor WHERE type NOT IN ('" . implode("','", $accessoryTypes) . "') AND type != 'NONE' ORDER BY type";
$typesResult = $conn->query($typesQuery);

// Get all materials for filter
$materialsQuery = "SELECT DISTINCT material FROM armor WHERE material != 'NONE(-)' ORDER BY material";
$materialsResult = $conn->query($materialsQuery);

// Build the filter query string for pagination links
function buildFilterQueryString($filters, $excludeParams = []) {
    $queryParams = [];
    
    foreach ($filters as $key => $value) {
        if (in_array($key, $excludeParams)) {
            continue;
        }
        
        if (is_array($value)) {
            foreach ($value as $val) {
                $queryParams[] = $key . "[]=" . urlencode($val);
            }
        } else if ($value !== '' && $value !== null) {
            $queryParams[] = $key . "=" . urlencode($value);
        }
    }
    
    return implode("&", $queryParams);
}

// Define the classes for filter
$classes = [
    'royal' => 'Royal',
    'knight' => 'Knight',
    'mage' => 'Mage',
    'elf' => 'Elf',
    'darkelf' => 'Dark Elf',
    'dragonknight' => 'Dragon Knight',
    'illusionist' => 'Illusionist',
    'warrior' => 'Warrior',
    'fencer' => 'Fencer',
    'lancer' => 'Lancer'
];
?>

<!-- Main Content Area -->
<div class="row">
    <!-- Filter Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="filter-sidebar mb-4">
            <h5 class="filter-header">
                <i class="bi bi-funnel-fill me-2"></i>Filters
                <?php if(array_filter($filters, function($v) { return !empty($v) && $v !== 'item_id' && $v !== 'ASC'; })): ?>
                    <a href="armor_list.php" class="btn btn-sm btn-outline-danger float-end" title="Reset filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </h5>
            <form id="filterForm" method="get" action="armor_list.php">
                <!-- Search Filter -->
                <div class="filter-section">
                    <div class="filter-label">Search</div>
                    <input type="text" class="form-control" name="search" placeholder="Search by name or ID" value="<?php echo htmlspecialchars($filters['search']); ?>">
                </div>
                
                <!-- Item Grade Filter -->
                <div class="filter-section">
                    <div class="filter-label">Item Grade</div>
                    <?php if ($gradesResult): 
                        while ($grade = $gradesResult->fetch_assoc()): ?>
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="grade[]" 
                                value="<?php echo htmlspecialchars($grade['itemGrade']); ?>" 
                                id="grade-<?php echo htmlspecialchars($grade['itemGrade']); ?>"
                                <?php echo in_array($grade['itemGrade'], $filters['grade']) ? 'checked' : ''; ?>
                            >
                            <label class="form-check-label grade-<?php echo htmlspecialchars($grade['itemGrade']); ?>" for="grade-<?php echo htmlspecialchars($grade['itemGrade']); ?>">
                                <?php echo htmlspecialchars($grade['itemGrade']); ?>
                            </label>
                        </div>
                    <?php endwhile; 
                    endif; ?>
                </div>
                
                <!-- Armor Type Filter -->
                <div class="filter-section">
                    <div class="filter-label">Armor Type</div>
                    <select class="form-select mb-2" name="type[]" multiple size="5">
                        <?php if ($typesResult): 
                            while ($type = $typesResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($type['type']); ?>" <?php echo in_array($type['type'], $filters['type']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type['type']); ?>
                            </option>
                        <?php endwhile; 
                        endif; ?>
                    </select>
                    <div class="form-text small">Hold Ctrl to select multiple types</div>
                </div>
                
                <!-- Level Range Filter -->
                <div class="filter-section">
                    <div class="filter-label">Level Range</div>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" placeholder="Min" name="min_level" value="<?php echo htmlspecialchars($filters['min_level']); ?>">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" placeholder="Max" name="max_level" value="<?php echo htmlspecialchars($filters['max_level']); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Class Restrictions Filter -->
                <div class="filter-section">
                    <div class="filter-label">Class Restrictions</div>
                    <?php foreach ($classes as $classKey => $className): ?>
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                name="class[]" 
                                value="<?php echo $classKey; ?>" 
                                id="class-<?php echo $classKey; ?>"
                                <?php echo in_array($classKey, $filters['class']) ? 'checked' : ''; ?>
                            >
                            <label class="form-check-label" for="class-<?php echo $classKey; ?>">
                                <?php echo htmlspecialchars($className); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Material Filter -->
                <div class="filter-section">
                    <div class="filter-label">Material</div>
                    <select class="form-select" name="material">
                        <option value="">Any Material</option>
                        <?php if ($materialsResult): 
                            while ($material = $materialsResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($material['material']); ?>" <?php echo $filters['material'] == $material['material'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($material['material']); ?>
                            </option>
                        <?php endwhile; 
                        endif; ?>
                    </select>
                </div>
                
                <!-- Sort Options -->
                <div class="filter-section">
                    <div class="filter-label">Sort By</div>
                    <div class="row mb-2">
                        <div class="col-8">
                            <select class="form-select form-select-sm" name="sort">
                                <option value="item_id" <?php echo $filters['sort'] == 'item_id' ? 'selected' : ''; ?>>Item ID</option>
                                <option value="desc_en" <?php echo $filters['sort'] == 'desc_en' ? 'selected' : ''; ?>>Name</option>
                                <option value="itemGrade" <?php echo $filters['sort'] == 'itemGrade' ? 'selected' : ''; ?>>Grade</option>
                                <option value="type" <?php echo $filters['sort'] == 'type' ? 'selected' : ''; ?>>Type</option>
                                <option value="grade" <?php echo $filters['sort'] == 'grade' ? 'selected' : ''; ?>>Level</option>
                                <option value="ac" <?php echo $filters['sort'] == 'ac' ? 'selected' : ''; ?>>AC</option>
                                <option value="iconId" <?php echo $filters['sort'] == 'iconId' ? 'selected' : ''; ?>>Icon</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select form-select-sm" name="order">
                                <option value="ASC" <?php echo $filters['order'] == 'ASC' ? 'selected' : ''; ?>>Asc</option>
                                <option value="DESC" <?php echo $filters['order'] == 'DESC' ? 'selected' : ''; ?>>Desc</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Items per page -->
                <div class="filter-section">
                    <div class="filter-label">Items per page</div>
                    <select class="form-select form-select-sm" name="limit">
                        <option value="10" <?php echo $itemsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="20" <?php echo $itemsPerPage == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="50" <?php echo $itemsPerPage == 50 ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?php echo $itemsPerPage == 100 ? 'selected' : ''; ?>>100</option>
                    </select>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Armor List -->
    <div class="col-lg-9">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-shield-fill me-2"></i>Armor List
                    <span class="text-muted small ms-2">(<?php echo number_format($totalItems); ?> items)</span>
                </h5>
                <a href="accessory_list.php" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-gem me-1"></i>View Accessories
                </a>
            </div>
            <div class="card-body p-0">
                <?php if ($result && $result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="px-3 text-center">
                                        <a href="armor_list.php?<?php echo buildFilterQueryString($filters, ['sort', 'order']); ?>&sort=iconId&order=<?php echo $sortColumn == 'iconId' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-decoration-none">
                                            Icon
                                            <?php if ($sortColumn == 'iconId'): ?>
                                                <i class="bi bi-arrow-<?php echo $sortOrder == 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-3">
                                        <a href="armor_list.php?<?php echo buildFilterQueryString($filters, ['sort', 'order']); ?>&sort=desc_en&order=<?php echo $sortColumn == 'desc_en' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-decoration-none">
                                            Name
                                            <?php if ($sortColumn == 'desc_en'): ?>
                                                <i class="bi bi-arrow-<?php echo $sortOrder == 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-3">
                                        <a href="armor_list.php?<?php echo buildFilterQueryString($filters, ['sort', 'order']); ?>&sort=ac&order=<?php echo $sortColumn == 'ac' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-decoration-none">
                                            AC
                                            <?php if ($sortColumn == 'ac'): ?>
                                                <i class="bi bi-arrow-<?php echo $sortOrder == 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <th class="px-3">
                                        <a href="armor_list.php?<?php echo buildFilterQueryString($filters, ['sort', 'order']); ?>&sort=type&order=<?php echo $sortColumn == 'type' && $sortOrder == 'ASC' ? 'DESC' : 'ASC'; ?>" class="text-decoration-none">
                                            Type
                                            <?php if ($sortColumn == 'type'): ?>
                                                <i class="bi bi-arrow-<?php echo $sortOrder == 'ASC' ? 'up' : 'down'; ?>"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="clickable-row" data-href="view_armor.php?id=<?php echo $row['item_id']; ?>">
            <td class="px-3 text-center">
                <?php 
                $iconPath = "icons/{$row['iconId']}.png";
                if (!empty($row['iconId']) && file_exists($iconPath)) {
                    echo "<img src='{$iconPath}' alt='Icon' width='32' height='32' class='item-icon'>";
                } else {
                    echo "<div class='no-icon' style='width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;'><i class='bi bi-question-circle'></i></div>";
                }
                ?>
            </td>
            <td class="grade-<?php echo htmlspecialchars($row['itemGrade']); ?> px-3">
    <?php echo htmlspecialchars($row['desc_en']); ?>
    <!-- Add action buttons only if the user is logged in as admin -->
    <?php if (isAdminLoggedIn()): ?>
        <div class="float-end">
            <a href="edit_armor.php?id=<?php echo $row['item_id']; ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="delete_armor.php?id=<?php echo $row['item_id']; ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this armor item?');">
                <i class="bi bi-trash"></i>
            </a>
        </div>
    <?php endif; ?>
</td>
            <td class="px-3"><?php echo htmlspecialchars($row['type']); ?></td>
            <td class="px-3"><?php echo htmlspecialchars($row['ac']); ?></td>
        </tr>
    <?php endwhile; ?>
</tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-4 text-center">
                        <div class="display-6 text-muted mb-3"><i class="bi bi-search"></i></div>
                        <h5>No armor items found</h5>
                        <p class="text-muted">Try adjusting your filters.</p>
                        <a href="armor_list.php" class="btn btn-outline-secondary">Reset Filters</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($totalPages > 1): ?>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="armor_list.php?<?php echo buildFilterQueryString($filters, ['page']); ?>&page=<?php echo $page - 1; ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            // Calculate range of pages to show
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            // Always show first page
                            if ($startPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="armor_list.php?<?php echo buildFilterQueryString($filters, ['page']); ?>&page=1">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="armor_list.php?<?php echo buildFilterQueryString($filters, ['page']); ?>&page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php
                            // Always show last page
                            if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="armor_list.php?<?php echo buildFilterQueryString($filters, ['page']); ?>&page=<?php echo $totalPages; ?>">
                                        <?php echo $totalPages; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="armor_list.php?<?php echo buildFilterQueryString($filters, ['page']); ?>&page=<?php echo $page + 1; ?>">
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

<!-- JavaScript for clickable rows -->
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

<?php include 'footer.php'; ?>