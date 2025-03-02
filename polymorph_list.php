<?php
// polymorph_list.php - List of Polymorphs
require_once 'database.php';

// Include helper functions
require_once 'includes/polymorph_icon_function.php"';
require_once 'includes/polymorph_categories.php';

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
    'category' => $_GET['category'] ?? '',
    'subcategory' => $_GET['subcategory'] ?? '',
    'weapon' => $_GET['weapon'] ?? '',
    'skill_use' => isset($_GET['skill_use']) ? intval($_GET['skill_use']) : -1, 
    'pvp_bonus' => isset($_GET['pvp_bonus']) ? $_GET['pvp_bonus'] : ''
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

// Weapon restriction filter
if (!empty($filters['weapon'])) {
    if ($filters['weapon'] === 'bow') {
        $conditions[] = "(pw.weapon = 'bow' OR p.weaponequip & 256)";
    } elseif ($filters['weapon'] === 'spear') {
        $conditions[] = "(pw.weapon = 'spear' OR p.weaponequip & 16)";
    } elseif ($filters['weapon'] === 'both') {
        $conditions[] = "(pw.weapon = 'both' OR (p.weaponequip & 256 AND p.weaponequip & 16))";
    }
}

// Skill use filter
if ($filters['skill_use'] !== -1) {
    $conditions[] = "p.isSkillUse = ?";
    $params[] = $filters['skill_use'];
    $types .= 'i';
}

// PVP bonus filter
if (!empty($filters['pvp_bonus'])) {
    $conditions[] = "p.bonusPVP = ?";
    $params[] = $filters['pvp_bonus'];
    $types .= 's';
}

// Category filters using pattern matching on name
if (!empty($filters['category']) && !empty($filters['subcategory'])) {
    if ($filters['category'] === 'tier') {
        // Handle tier categories
        switch ($filters['subcategory']) {
            case 'basic':
                $conditions[] = "p.minlevel <= 45";
                break;
            case 'dark': 
                $conditions[] = "(p.minlevel BETWEEN 46 AND 55 OR p.name LIKE '%dark%' OR p.name LIKE '%black%')";
                break;
            case 'silver':
                $conditions[] = "(p.minlevel BETWEEN 56 AND 65 OR p.name LIKE '%silver%')";
                break;
            case 'gold':
                $conditions[] = "(p.minlevel BETWEEN 66 AND 75 OR p.name LIKE '%gold%')";
                break;
            case 'platinum':
                $conditions[] = "(p.minlevel BETWEEN 76 AND 85 OR p.name LIKE '%platinum%' OR p.name LIKE '%jin%')";
                break;
            case 'arch':
                $conditions[] = "(p.minlevel >= 86 OR p.name LIKE '%arch%')";
                break;
        }
    } elseif ($filters['category'] === 'character') {
        // Character class filters
        $conditions[] = "p.name LIKE ?";
        $params[] = "%{$filters['subcategory']}%";
        $types .= 's';
    } elseif ($filters['category'] === 'monster') {
        // Monster categories
        $monster_patterns = [
            'humanoid' => ['orc', 'kobold', 'ratman', 'dwarf', 'giant', 'troll'],
            'undead' => ['skeleton', 'zombie', 'ghoul', 'ghost', 'death'],
            'demon' => ['demon', 'baphomet', 'beleth', 'lesser demon'],
            'beast' => ['wolf', 'bear', 'tiger', 'rabbit', 'deer', 'boar'],
            'dragon' => ['dragon', 'drake', 'wyvern']
        ];
        
        if (isset($monster_patterns[$filters['subcategory']])) {
            $pattern_parts = [];
            foreach ($monster_patterns[$filters['subcategory']] as $keyword) {
                $pattern_parts[] = "p.name LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            }
            $conditions[] = "(" . implode(' OR ', $pattern_parts) . ")";
        }
    } elseif ($filters['category'] === 'special') {
        // Special categories
        if ($filters['subcategory'] === 'pvp') {
            $conditions[] = "p.bonusPVP = 'true'";
        } elseif ($filters['subcategory'] === 'event') {
            $conditions[] = "p.name LIKE '%event%'";
        } elseif ($filters['subcategory'] === 'seasonal') {
            $seasonal_patterns = ['halloween', 'christmas', 'winter', 'summer', 'spring'];
            $pattern_parts = [];
            foreach ($seasonal_patterns as $keyword) {
                $pattern_parts[] = "p.name LIKE ?";
                $params[] = "%$keyword%";
                $types .= 's';
            }
            $conditions[] = "(" . implode(' OR ', $pattern_parts) . ")";
        }
    }
}

// Construct WHERE clause
$whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Count total items
$countQuery = "SELECT COUNT(*) as total FROM polymorphs p 
               LEFT JOIN polyweapon pw ON p.polyid = pw.polyId
               $whereClause";
$countStmt = $conn->prepare($countQuery);
if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalItems = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Main query to fetch polymorphs
$query = "SELECT p.*, pi.itemId, pi.duration, pi.type as poly_type, pi.delete as is_delete,
                 pw.weapon as weapon_restriction, ei.iconId as etcitem_icon
          FROM polymorphs p
          LEFT JOIN polyitems pi ON p.polyid = pi.polyId
          LEFT JOIN polyweapon pw ON p.polyid = pw.polyId
          LEFT JOIN etcitem ei ON pi.itemId = ei.item_id
          $whereClause
          GROUP BY p.id
          ORDER BY p.minlevel DESC, p.name ASC
          LIMIT ? OFFSET ?";

// Add pagination parameters
$types .= 'ii';
$params[] = $itemsPerPage;
$params[] = $offset;

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Get list of distinct minimum levels for filter dropdown
$levelQuery = "SELECT DISTINCT minlevel FROM polymorphs ORDER BY minlevel ASC";
$levelResult = $conn->query($levelQuery);
$levelOptions = [];
while ($levelRow = $levelResult->fetch_assoc()) {
    $levelOptions[] = $levelRow['minlevel'];
}

// Count polymorphs per category for sidebar statistics
$categoryStats = [];
foreach ($polymorph_categories as $catKey => $category) {
    $categoryStats[$catKey] = [
        'name' => $category['name'],
        'count' => 0,
        'subcategories' => []
    ];
    
    foreach ($category['subcategories'] as $subKey => $subName) {
        $categoryStats[$catKey]['subcategories'][$subKey] = 0;
    }
}

// Quick stats query (this could be optimized with caching in a production environment)
$statsQuery = "SELECT COUNT(*) as count, 
               MIN(minlevel) as min_level,
               MAX(minlevel) as max_level,
               SUM(CASE WHEN bonusPVP = 'true' THEN 1 ELSE 0 END) as pvp_count,
               SUM(CASE WHEN isSkillUse = 1 THEN 1 ELSE 0 END) as skill_use_count
               FROM polymorphs";
$statsResult = $conn->query($statsQuery);
$statsData = $statsResult->fetch_assoc();
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3">
            <!-- Filter Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-funnel me-2"></i>Filter Polymorphs
                    </h5>
                </div>
                <div class="card-body">
                    <form method="get" action="" id="filterForm">
                        <!-- Search input -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="<?php echo htmlspecialchars($filters['search']); ?>" 
                                       placeholder="Name or ID">
                            </div>
                        </div>
                        
                        <!-- Category filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                <?php foreach ($polymorph_categories as $key => $category): ?>
                                <option value="<?php echo $key; ?>" <?php echo $filters['category'] === $key ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Subcategory filter (dynamic based on category) -->
                        <div class="mb-3" id="subcategoryContainer">
                            <label for="subcategory" class="form-label">Subcategory</label>
                            <select class="form-select" id="subcategory" name="subcategory" 
                                    <?php echo empty($filters['category']) ? 'disabled' : ''; ?>>
                                <option value="">All Subcategories</option>
                                
                                <?php if (!empty($filters['category']) && isset($polymorph_categories[$filters['category']])): ?>
                                    <?php foreach ($polymorph_categories[$filters['category']]['subcategories'] as $key => $name): ?>
                                    <option value="<?php echo $key; ?>" <?php echo $filters['subcategory'] === $key ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($name); ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Level Range -->
                        <div class="mb-3">
                            <label class="form-label d-flex justify-content-between">
                                <span>Level Range</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 level-preset-btn" data-preset="all">All</button>
                            </label>
                            <div class="input-group mb-2">
                                <input type="number" class="form-control" name="min_level" id="min_level"
                                       placeholder="Min" min="0" max="100"
                                       value="<?php echo $filters['min_level'] ?: ''; ?>">
                                <span class="input-group-text">-</span>
                                <input type="number" class="form-control" name="max_level" id="max_level"
                                       placeholder="Max" min="0" max="100"
                                       value="<?php echo $filters['max_level'] ?: ''; ?>">
                            </div>
                            
                            <!-- Level preset buttons -->
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 level-preset-btn" data-min="1" data-max="45">Beginner</button>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 level-preset-btn" data-min="50" data-max="55">Level 50+</button>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 level-preset-btn" data-min="60" data-max="75">Mid-tier</button>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 level-preset-btn" data-min="80" data-max="100">High-tier</button>
                            </div>
                        </div>
                        
                        <!-- Additional filters -->
                        <div class="mb-3">
                            <label class="form-label">Weapon Type</label>
                            <select class="form-select" name="weapon">
                                <option value="">Any Weapon</option>
                                <option value="bow" <?php echo $filters['weapon'] === 'bow' ? 'selected' : ''; ?>>Bow Only</option>
                                <option value="spear" <?php echo $filters['weapon'] === 'spear' ? 'selected' : ''; ?>>Spear Only</option>
                                <option value="both" <?php echo $filters['weapon'] === 'both' ? 'selected' : ''; ?>>Bow and Spear</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Skill Usage</label>
                            <select class="form-select" name="skill_use">
                                <option value="-1">Any</option>
                                <option value="1" <?php echo $filters['skill_use'] === 1 ? 'selected' : ''; ?>>Can Use Skills</option>
                                <option value="0" <?php echo $filters['skill_use'] === 0 ? 'selected' : ''; ?>>Cannot Use Skills</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">PVP Bonus</label>
                            <select class="form-select" name="pvp_bonus">
                                <option value="">Any</option>
                                <option value="true" <?php echo $filters['pvp_bonus'] === 'true' ? 'selected' : ''; ?>>Has PVP Bonus</option>
                                <option value="false" <?php echo $filters['pvp_bonus'] === 'false' ? 'selected' : ''; ?>>No PVP Bonus</option>
                            </select>
                        </div>
                        
                        <!-- Filter actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-filter me-2"></i>Apply Filters
                            </button>
                            
                            <?php if (!empty($filters['search']) || $filters['min_level'] > 0 || $filters['max_level'] > 0 || 
                                     !empty($filters['category']) || !empty($filters['subcategory']) || 
                                     !empty($filters['weapon']) || $filters['skill_use'] != -1 || !empty($filters['pvp_bonus'])): ?>
                                <a href="polymorph_list.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Clear All Filters
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Stats & Info Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Polymorph Info
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="border-bottom pb-2 mb-3">Quick Stats</h6>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Polymorphs:</span>
                        <span class="fw-bold"><?php echo number_format($statsData['count']); ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Level Range:</span>
                        <span class="fw-bold"><?php echo $statsData['min_level']; ?> - <?php echo $statsData['max_level']; ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>With PVP Bonus:</span>
                        <span class="fw-bold"><?php echo number_format($statsData['pvp_count']); ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Can Use Skills:</span>
                        <span class="fw-bold"><?php echo number_format($statsData['skill_use_count']); ?></span>
                    </div>
                    
                    <h6 class="border-bottom pb-2 mb-3 mt-4">What are Polymorphs?</h6>
                    <p>Polymorphs transform your character into a different form with unique appearances, abilities, and stat changes.</p>
                    
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Change your character's appearance</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Modify your character's stats</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Enable special abilities</span>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Temporary effects (usually 30 minutes)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Results Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>Polymorphs
                        <small class="ms-2">(<?php echo number_format($totalItems); ?> found)</small>
                    </h4>
                    
                    <?php if (!empty($filters['search']) || $filters['min_level'] > 0 || $filters['max_level'] > 0 || 
                             !empty($filters['category']) || !empty($filters['subcategory']) || 
                             !empty($filters['weapon']) || $filters['skill_use'] != -1 || !empty($filters['pvp_bonus'])): ?>
                        <span class="badge bg-light text-dark p-2">
                            <i class="bi bi-funnel-fill me-1"></i>Filtered Results
                        </span>
                    <?php endif; ?>
                </div>
                
                <?php if ($result->num_rows > 0): ?>
                    <!-- Display Results in Card Grid -->
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                            <?php while ($polymorph = $result->fetch_assoc()): 
                                // Get polymorph icon
                                $iconPath = getPolymorphIconPath($polymorph);
                                
                                // Determine the card accent class based on level
                                $cardClass = '';
                                if ($polymorph['minlevel'] >= 80) {
                                    $cardClass = 'border-danger';
                                } elseif ($polymorph['minlevel'] >= 60) {
                                    $cardClass = 'border-warning';
                                } elseif ($polymorph['minlevel'] >= 50) {
                                    $cardClass = 'border-info';
                                } else {
                                    $cardClass = 'border-success';
                                }
                                
                                // Determine badge for level
                                $levelBadgeClass = '';
                                if ($polymorph['minlevel'] >= 80) {
                                    $levelBadgeClass = 'bg-danger';
                                } elseif ($polymorph['minlevel'] >= 60) {
                                    $levelBadgeClass = 'bg-warning';
                                } elseif ($polymorph['minlevel'] >= 50) {
                                    $levelBadgeClass = 'bg-info';
                                } else {
                                    $levelBadgeClass = 'bg-success';
                                }
                            ?>
                            <div class="col">
                                <div class="card h-100 polymorph-card <?php echo $cardClass; ?>" 
                                     onclick="window.location.href='view_polymorph.php?id=<?php echo $polymorph['id']; ?>'">
                                    
                                    <div class="card-header d-flex justify-content-between align-items-center py-2 bg-light">
                                        <span class="badge <?php echo $levelBadgeClass; ?>">
                                            Level <?php echo $polymorph['minlevel']; ?>+
                                        </span>
                                        <span class="small text-muted">
                                            ID: <?php echo $polymorph['polyid']; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="card-body d-flex p-3">
                                        <div class="polymorph-icon me-3">
                                            <?php if ($iconPath && file_exists($iconPath)): ?>
                                                <img src="<?php echo $iconPath; ?>" 
                                                     alt="<?php echo htmlspecialchars($polymorph['name']); ?>" 
                                                     class="img-fluid rounded" 
                                                     style="width: 64px; height: 64px; object-fit: contain;">
                                            <?php else: ?>
                                                <div class="placeholder-icon d-flex align-items-center justify-content-center bg-light rounded" 
                                                     style="width: 64px; height: 64px;">
                                                    <i class="bi bi-person-fill text-secondary" style="font-size: 2rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <h5 class="card-title mb-1">
                                                <?php echo htmlspecialchars($polymorph['name']); ?>
                                            </h5>
                                            
                                            <div class="polymorph-features mt-2">
                                                <div class="d-flex flex-wrap gap-1">
                                                    <?php if ($polymorph['isSkillUse'] == 1): ?>
                                                        <span class="badge bg-success">Skills</span>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($polymorph['formLongEnable'] == 'true'): ?>
                                                        <span class="badge bg-primary">Long-range</span>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($polymorph['bonusPVP'] == 'true'): ?>
                                                        <span class="badge bg-danger">PVP Bonus</span>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (!empty($polymorph['weapon_restriction'])): ?>
                                                        <span class="badge bg-secondary">
                                                            <?php echo ucfirst($polymorph['weapon_restriction']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent border-top-0 text-end">
                                        <span class="text-primary small">View Details <i class="bi bi-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    
                    <?php if ($totalPages > 1): ?>
                    <!-- Pagination -->
                    <div class="card-footer bg-light">
                        <nav aria-label="Polymorph list pagination">
                            <ul class="pagination justify-content-center mb-0">
                                <?php 
                                // Calculate page range
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);
                                
                                // Build pagination query string
                                $paginationQueryParams = [];
                                if (!empty($filters['search'])) $paginationQueryParams[] = 'search=' . urlencode($filters['search']);
                                if ($filters['min_level'] > 0) $paginationQueryParams[] = 'min_level=' . $filters['min_level'];
                                if ($filters['max_level'] > 0) $paginationQueryParams[] = 'max_level=' . $filters['max_level'];
                                if (!empty($filters['category'])) $paginationQueryParams[] = 'category=' . $filters['category'];
                                if (!empty($filters['subcategory'])) $paginationQueryParams[] = 'subcategory=' . $filters['subcategory'];
                                if (!empty($filters['weapon'])) $paginationQueryParams[] = 'weapon=' . $filters['weapon'];
                                if ($filters['skill_use'] != -1) $paginationQueryParams[] = 'skill_use=' . $filters['skill_use'];
                                if (!empty($filters['pvp_bonus'])) $paginationQueryParams[] = 'pvp_bonus=' . $filters['pvp_bonus'];
                                
                                $queryString = !empty($paginationQueryParams) ? '&' . implode('&', $paginationQueryParams) : '';
                                
                                // Previous page
                                if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; echo $queryString; ?>">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php 
                                // First page
                                if ($startPage > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=1<?php echo $queryString; ?>">1</a>
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
                                        <a class="page-link" href="?page=<?php echo $i; echo $queryString; ?>">
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
                                        <a class="page-link" href="?page=<?php echo $totalPages; echo $queryString; ?>">
                                            <?php echo $totalPages; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php // Next page
                                if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; echo $queryString; ?>">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- No Results Found -->
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-muted mb-4">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3>No polymorphs found</h3>
                        <p class="text-muted mb-4">
                            No results match your current filter criteria. 
                            Try adjusting your filters or search terms.
                        </p>
                        <a href="polymorph_list.php" class="btn btn-primary">
                            <i class="bi bi-arrow-repeat me-2"></i>Reset All Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Quick Reference Section (only shown when not filtering) -->
            <?php if (empty($filters['search']) && $filters['min_level'] === 0 && $filters['max_level'] === 0 && 
                      empty($filters['category']) && empty($filters['subcategory']) && 
                      empty($filters['weapon']) && $filters['skill_use'] === -1 && empty($filters['pvp_bonus'])): ?>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-star-fill me-2"></i>Popular Polymorphs
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <!-- This would typically be populated from a database query for most popular polymorphs -->
                                <!-- Here we're showing some sample high-level options -->
                                <?php
                                // Example popular polymorph query - in a real implementation, this would be based on usage stats
                                $popularQuery = "SELECT p.id, p.name, p.polyid, p.minlevel FROM polymorphs p 
                                                WHERE (p.name LIKE '%jin death knight%' OR p.name LIKE '%arch knight%' OR 
                                                       p.name LIKE '%dark shadow%' OR p.name LIKE '%baphomet%')
                                                ORDER BY p.minlevel DESC LIMIT 5";
                                $popularResult = $conn->query($popularQuery);
                                
                                while ($popular = $popularResult->fetch_assoc()):
                                    // Determine level badge
                                    $popularLevelClass = $popular['minlevel'] >= 80 ? 'bg-danger' :
                                                        ($popular['minlevel'] >= 60 ? 'bg-warning' : 
                                                        ($popular['minlevel'] >= 50 ? 'bg-info' : 'bg-success'));
                                ?>
                                <a href="view_polymorph.php?id=<?php echo $popular['id']; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold"><?php echo htmlspecialchars($popular['name']); ?></span>
                                        <small class="d-block text-muted">ID: <?php echo $popular['polyid']; ?></small>
                                    </div>
                                    <span class="badge <?php echo $popularLevelClass; ?> rounded-pill">
                                        Lv.<?php echo $popular['minlevel']; ?>
                                    </span>
                                </a>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-bookmark-star-fill me-2"></i>Polymorph Tiers
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p>Polymorphs are organized into tiers based on level requirements and power:</p>
                            </div>
                            
                            <div class="d-flex flex-column gap-2">
                                <a href="?min_level=1&max_level=45" class="btn btn-outline-success d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-star me-2"></i>Basic Tier (Level 1-45)</span>
                                    <span class="badge bg-secondary rounded-pill">Beginner</span>
                                </a>
                                
                                <a href="?min_level=50&max_level=55" class="btn btn-outline-info d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-star me-2"></i>Dark Tier (Level 50-55)</span>
                                    <span class="badge bg-secondary rounded-pill">Intermediate</span>
                                </a>
                                
                                <a href="?min_level=60&max_level=65" class="btn btn-outline-primary d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-star me-2"></i>Silver Tier (Level 60-65)</span>
                                    <span class="badge bg-secondary rounded-pill">Advanced</span>
                                </a>
                                
                                <a href="?min_level=70&max_level=75" class="btn btn-outline-warning d-flex justify-content-between align-items-center text-dark">
                                    <span><i class="bi bi-star me-2"></i>Gold Tier (Level 70-75)</span>
                                    <span class="badge bg-secondary rounded-pill">Expert</span>
                                </a>
                                
                                <a href="?min_level=80&max_level=85" class="btn btn-outline-danger d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-star me-2"></i>Platinum/Jin Tier (Level 80-85)</span>
                                    <span class="badge bg-secondary rounded-pill">Elite</span>
                                </a>
                                
                                <a href="?min_level=90&max_level=100" class="btn btn-dark d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-stars me-2"></i>Arch Tier (Level 90+)</span>
                                    <span class="badge bg-danger rounded-pill">Legendary</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle category and subcategory selection
    const categorySelect = document.getElementById('category');
    const subcategorySelect = document.getElementById('subcategory');
    const subcategoryContainer = document.getElementById('subcategoryContainer');
    
    categorySelect.addEventListener('change', function() {
        // Reset subcategory
        subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
        
        if (this.value) {
            // Enable subcategory select
            subcategorySelect.disabled = false;
            
            // Populate subcategories based on selected category
            const categories = <?php echo json_encode($polymorph_categories); ?>;
            const subcategories = categories[this.value].subcategories;
            
            for (const [key, name] of Object.entries(subcategories)) {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = name;
                subcategorySelect.appendChild(option);
            }
        } else {
            // Disable subcategory select if no category selected
            subcategorySelect.disabled = true;
        }
    });
    
    // Handle level preset buttons
    const levelPresetBtns = document.querySelectorAll('.level-preset-btn');
    const minLevelInput = document.getElementById('min_level');
    const maxLevelInput = document.getElementById('max_level');
    
    levelPresetBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const preset = this.dataset.preset;
            if (preset === 'all') {
                minLevelInput.value = '';
                maxLevelInput.value = '';
            } else {
                minLevelInput.value = this.dataset.min;
                maxLevelInput.value = this.dataset.max;
            }
        });
    });
    
    // Make polymorph cards clickable
    const polymorphCards = document.querySelectorAll('.polymorph-card');
    polymorphCards.forEach(card => {
        card.style.cursor = 'pointer';
    });
});
</script>

<!-- Additional CSS for polymorph cards -->
<style>
.polymorph-card {
    transition: all 0.2s ease-in-out;
}

.polymorph-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.placeholder-icon {
    border: 1px dashed #ccc;
}
</style>

<?php include 'footer.php'; ?>
