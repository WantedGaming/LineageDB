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

// Filtering options - enhanced with additional filters from schema
$gradeFilter = isset($_GET['grade']) ? intval($_GET['grade']) : null;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$hasteFilter = isset($_GET['has_haste']) ? intval($_GET['has_haste']) : null;

// Build query with optional filters and additional information from schema
$query = "SELECT n.npcid, n.desc_en, n.lvl, n.hp, n.mp, n.spriteId, 
                 mi.name, mi.grade, mi.itemId, mi.haste, mi.bonusCount, mi.bonusInterval, mi.bonusItemId, 
                 ei.iconid, ei.desc_en as item_desc,
                 mp.name as potential_name
          FROM npc n
          JOIN magicdoll_info mi ON n.npcid = mi.dollNpcId
          LEFT JOIN etcitem ei ON mi.itemId = ei.item_id
          LEFT JOIN magicdoll_potential mp ON mi.bonusItemId = mp.bonusId
          WHERE n.impl = 'L1Doll'";

$params = [];
$types = '';

if ($gradeFilter !== null) {
    $query .= " AND mi.grade = ?";
    $params[] = $gradeFilter;
    $types .= 'i';
}

if (!empty($searchTerm)) {
    $query .= " AND (n.desc_en LIKE ? OR mi.name LIKE ? OR mp.name LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $types .= 'sss';
}

// Add haste filter based on schema data
if ($hasteFilter !== null) {
    $query .= " AND mi.haste = ?";
    $params[] = $hasteFilter;
    $types .= 'i';
}

// Count total filtered results - FIX: Make sure we get a 'total' in the result
$countQuery = "SELECT COUNT(*) as total FROM npc n 
               JOIN magicdoll_info mi ON n.npcid = mi.dollNpcId
               LEFT JOIN magicdoll_potential mp ON mi.bonusItemId = mp.bonusId
               WHERE n.impl = 'L1Doll'";

// Add the same filters to the count query
if ($gradeFilter !== null) {
    $countQuery .= " AND mi.grade = ?";
}

if (!empty($searchTerm)) {
    $countQuery .= " AND (n.desc_en LIKE ? OR mi.name LIKE ? OR mp.name LIKE ?)";
}

// Add haste filter to count query too
if ($hasteFilter !== null) {
    $countQuery .= " AND mi.haste = ?";
}

$countStmt = $conn->prepare($countQuery);
if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalRows = $totalRow['total']; // FIX: Now we get the 'total' value safely
$totalPages = ceil($totalRows / $itemsPerPage);

// Add pagination to main query
$query .= " ORDER BY n.lvl ASC, mi.grade ASC, n.desc_en ASC LIMIT ? OFFSET ?";
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
    <div class="card mb-4">
        <div class="card-header">
            <h1 class="mb-0">
                <i class="bi bi-robot me-2"></i>Magic Dolls
            </h1>
        </div>
        <div class="card-body">
            <p class="lead">Magic dolls can be summoned to provide special bonuses and abilities. They come in different grades and offer a variety of effects.</p>
            <div class="row text-center g-2 mt-3">
                <div class="col-md-3">
                    <div class="p-3 border rounded bg-dark">
                        <i class="bi bi-stars text-warning fs-4"></i>
                        <h5 class="mt-2 text-light">Stat Bonuses</h5>
                        <p class="small text-light">Enhance your character's abilities</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded bg-dark">
                        <i class="bi bi-lightning-charge text-danger fs-4"></i>
                        <h5 class="mt-2 text-light">Combat Buffs</h5>
                        <p class="small text-light">Get an edge in battle</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded bg-dark">
                        <i class="bi bi-stopwatch text-primary fs-4"></i>
                        <h5 class="mt-2 text-light">Haste Effects</h5>
                        <p class="small text-light">Increase your attack speed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded bg-dark">
                        <i class="bi bi-shield-shaded text-success fs-4"></i>
                        <h5 class="mt-2 text-light">Protection</h5>
                        <p class="small text-light">Defensive bonuses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search and Filter Form with Additional Options -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-funnel-fill me-2"></i>Search & Filters</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" id="search" name="search" class="form-control" 
                               placeholder="Search dolls by name..." 
                               value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select id="grade" name="grade" class="form-select">
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
                    
                    <!-- Added additional filter for Haste based on schema -->
                    <div class="col-md-3">
                        <label for="has_haste" class="form-label">Special Effect</label>
                        <select id="has_haste" name="has_haste" class="form-select">
                            <option value="">Any</option>
                            <option value="1" <?php echo (isset($_GET['has_haste']) && $_GET['has_haste'] == '1') ? 'selected' : ''; ?>>
                                Has Haste Effect
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Apply Filters
                        </button>
                    </div>
                </div>
                
                <!-- Show reset filters button when filters are active -->
                <?php if (!empty($searchTerm) || $gradeFilter !== null || isset($_GET['has_haste'])): ?>
                <div class="mt-2 text-end">
                    <a href="doll_list.php" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Reset Filters
                    </a>
                </div>
                <?php endif; ?>
            </form>
            
            <div class="d-flex justify-content-between align-items-center mt-1">
                <div>
                    <span class="badge bg-primary me-1"><?php echo $totalRows; ?></span>
                    <span class="text-muted small">dolls found</span>
                </div>
                <div class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    Magic dolls are special pets that provide stat bonuses and abilities
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dolls Grid with Enhanced Information -->
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php while ($doll = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-100 doll-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Grade <?php echo $doll['grade']; ?></span>
                        <span class="badge bg-secondary">Lvl <?php echo $doll['lvl']; ?></span>
                    </div>
                    <div class="card-body text-center">
                        <?php
                        // Use iconid from etcitem directly from the query result
                        $iconPath = null;
                        if (!empty($doll['iconid'])) {
                            $iconPath = "icons/{$doll['iconid']}.png";
                            // Check if file exists without icon_ prefix
                            if (!file_exists($iconPath)) {
                                $iconPath = "icons/icon_{$doll['iconid']}.png";
                            }
                        }
                        
                        // If no direct icon, try to get it via item_id from etcitem
                        if ((!$iconPath || !file_exists($iconPath)) && !empty($doll['itemId'])) {
                            $itemQuery = "SELECT iconid FROM etcitem WHERE item_id = ?";
                            $itemStmt = $conn->prepare($itemQuery);
                            $itemStmt->bind_param("i", $doll['itemId']);
                            $itemStmt->execute();
                            $itemResult = $itemStmt->get_result();
                            if ($itemResult && $itemResult->num_rows > 0) {
                                $itemData = $itemResult->fetch_assoc();
                                if (!empty($itemData['iconid'])) {
                                    $iconPath = "icons/{$itemData['iconid']}.png";
                                    if (!file_exists($iconPath)) {
                                        $iconPath = "icons/icon_{$itemData['iconid']}.png";
                                    }
                                }
                            }
                            $itemStmt->close();
                        }
                        
                        // Final fallback to sprite icon
                        if (!$iconPath || !file_exists($iconPath)) {
                            $iconPath = "icons/ms{$doll['spriteId']}.png";
                        }
                        
                        if (file_exists($iconPath)):
                        ?>
                            <img src="<?php echo $iconPath; ?>" 
                                 alt="<?php echo htmlspecialchars($doll['desc_en']); ?>" 
                                 class="img-fluid mb-3" 
                                 style="max-height: 150px; object-fit: contain;">
                        <?php else: ?>
                            <div class="text-center mb-3">
                                <i class="bi bi-robot fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h5 class="card-title">
                            <?php 
                            // Clean up name by removing "Magic Doll" text
                            $displayName = htmlspecialchars($doll['desc_en']);
                            $displayName = preg_replace('/\bMagic Doll\b/', '', $displayName);
                            $displayName = preg_replace('/ +/', ' ', $displayName); // Remove extra spaces
                            echo trim($displayName); 
                            ?>
                        </h5>
                        <?php if (!empty($doll['name'])): ?>
                            <p class="mb-2"><?php echo htmlspecialchars($doll['name']); ?></p>
                        <?php endif; ?>
                        
                        <!-- Added Stats -->
                        <div class="stats-container mt-2 mb-3">
                            <div class="d-flex justify-content-center mb-1">
                                <div class="px-2 text-center">
                                    <small class="d-block text-muted">HP</small>
                                    <span class="badge bg-danger"><?php echo number_format($doll['hp']); ?></span>
                                </div>
                                <div class="px-2 text-center">
                                    <small class="d-block text-muted">MP</small>
                                    <span class="badge bg-primary"><?php echo number_format($doll['mp']); ?></span>
                                </div>
                                <?php if ($doll['bonusInterval'] > 0): ?>
                                <div class="px-2 text-center">
                                    <small class="d-block text-muted">Interval</small>
                                    <span class="badge bg-info"><?php echo $doll['bonusInterval']; ?>s</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($doll['potential_name'])): ?>
                            <div class="text-center mt-2">
                                <small class="text-success">
                                    <i class="bi bi-lightning-charge me-1"></i>
                                    <?php echo htmlspecialchars($doll['potential_name']); ?>
                                </small>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($doll['haste'] == 1): ?>
                            <div class="text-center mt-1">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-speedometer2 me-1"></i>Haste
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
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
                        echo (!empty($searchTerm) ? "&search=" . urlencode($searchTerm) : '');
                        echo ($hasteFilter !== null ? "&has_haste=$hasteFilter" : ''); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- Additional information about Magic Dolls based on schema -->
<div class="container mb-5">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i>About Magic Dolls</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>What are Magic Dolls?</h5>
                    <p>Magic Dolls are special companions in Lineage that can be summoned to provide various stat bonuses and special abilities. They appear as small creatures that follow your character.</p>
                    
                    <h5 class="mt-4">How to Use Magic Dolls</h5>
                    <ol>
                        <li>Obtain a Magic Doll item from drops, quests, or shops</li>
                        <li>Right-click the doll in your inventory to summon it</li>
                        <li>The doll will remain active until dismissed</li>
                        <li>Only one doll can be summoned at a time</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h5>Doll Grades</h5>
                    <p>Magic Dolls come in different grades, with higher grades providing stronger benefits:</p>
                    <ul>
                        <li><strong>Grade 1-2:</strong> Basic stat bonuses</li>
                        <li><strong>Grade 3-4:</strong> Enhanced bonuses and some special effects</li>
                        <li><strong>Grade 5+:</strong> Powerful bonuses and unique abilities</li>
                    </ul>
                    
                    <h5 class="mt-4">Special Effects</h5>
                    <p>Some dolls provide special effects beyond stat bonuses:</p>
                    <ul>
                        <li><strong>Haste:</strong> Increases attack speed</li>
                        <li><strong>Bonus Skills:</strong> Grants access to special abilities</li>
                        <li><strong>Damage Reduction:</strong> Decreases damage taken</li>
                        <li><strong>Elemental Resistance:</strong> Provides protection against elements</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>