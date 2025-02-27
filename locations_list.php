<?php
// locations_list.php - List of game locations
require_once 'database.php';

$page_title = "Game Locations - Lineage Remaster";
include 'header.php';

// Pagination setup
$itemsPerPage = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Prepare query to get locations
try {
    // Count total locations
    $countQuery = "SELECT COUNT(*) as total FROM mapids WHERE locationname != ''";
    $countStmt = $conn->prepare($countQuery);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $totalItems = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Get locations with pagination
    $query = "SELECT mapid, locationname, 
                    startX, endX, startY, endY, 
                    pngId
              FROM mapids 
              WHERE locationname != ''
              ORDER BY mapid 
              LIMIT ?, ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $offset, $itemsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();

} catch (Exception $e) {
    // Error handling
    $_SESSION['error_message'] = "Error retrieving locations: " . $e->getMessage();
    header('Location: error_page.php');
    exit;
}
?>

<style>
.location-row {
    transition: background-color 0.2s ease;
}
.location-row:hover {
    background-color: rgba(255, 255, 255, 0.05);
}
.location-icon {
    width: 48px;
    height: 48px;
    object-fit: contain;
    margin-right: 15px;
    border-radius: 4px;
    background-color: rgba(0, 0, 0, 0.2);
    padding: 4px;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-map me-2"></i>Game Locations
                    <span class="text-muted small ms-2">(<?php echo number_format($totalItems); ?> locations)</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if ($result && $result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="px-3 py-3">Map ID</th>
                                    <th class="px-3 py-3">Location Name</th>
                                    <th class="px-3 py-3">Coordinates</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="clickable-row location-row" data-href="view_location.php?id=<?php echo $row['mapid']; ?>">
                                        <td class="px-3 py-3 align-middle"><?php echo htmlspecialchars($row['mapid']); ?></td>
                                        <td class="px-3 py-3 align-middle">
                                            <?php 
                                            // Prepare location icon path
                                            $iconPath = "icons/{$row['pngId']}.png";
                                            if (!empty($row['pngId']) && file_exists($iconPath)) {
                                                echo "<img src='{$iconPath}' alt='Location Icon' class='location-icon d-inline-block align-middle me-3'>";
                                            }
                                            echo htmlspecialchars($row['locationname']); 
                                            ?>
                                        </td>
                                        <td class="px-3 py-3 align-middle">
                                            (<?php 
                                            echo htmlspecialchars($row['startX']) . ',' . 
                                                 htmlspecialchars($row['startY']) . ') - (' . 
                                                 htmlspecialchars($row['endX']) . ',' . 
                                                 htmlspecialchars($row['endY']); 
                                            ?>)
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-4 text-center">
                        <div class="display-6 text-muted mb-3"><i class="bi bi-map"></i></div>
                        <h5>No locations found</h5>
                        <p class="text-muted">There are no locations in the database.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="card-footer">
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center mb-0">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $itemsPerPage; ?>">
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
                                    <a class="page-link" href="?page=1&limit=<?php echo $itemsPerPage; ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $itemsPerPage; ?>">
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
                                    <a class="page-link" href="?page=<?php echo $totalPages; ?>&limit=<?php echo $itemsPerPage; ?>">
                                        <?php echo $totalPages; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $itemsPerPage; ?>">
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