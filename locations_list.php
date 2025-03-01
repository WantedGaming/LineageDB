<?php
// locations_list.php - Listing of all locations
require_once 'database.php';

// Page setup
$page_title = "Game Locations";
include 'header.php';

// Fetch all locations
$query = "SELECT mapid, locationname, startX, startY, endX, endY, pngId, 
                 COALESCE(monster_amount, 0) as monster_count, 
                 COALESCE(dungeon, 0) as is_dungeon 
          FROM mapids 
          WHERE locationname != '' 
          ORDER BY mapid";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">
                        <i class="bi bi-map me-2"></i>Game Locations
                        <span class="text-muted small ms-2">(<?php echo $result ? number_format($result->num_rows) : '0'; ?> locations)</span>
                    </h1>
                </div>
                <div class="card-body p-0">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="px-3">Map ID</th>
                                        <th class="px-3">Location Name</th>
                                        <th class="px-3">Coordinates</th>
                                        <th class="px-3 text-center">Monsters</th>
                                        <th class="px-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($location = $result->fetch_assoc()): ?>
                                        <tr class="clickable-row" data-href="view_location.php?id=<?php echo $location['mapid']; ?>">
                                            <td class="px-3"><?php echo htmlspecialchars($location['mapid']); ?></td>
                                            <td class="px-3">
                                                <?php 
                                                $locationName = !empty($location['locationname']) 
                                                    ? $location['locationname'] 
                                                    : "Location " . $location['mapid'];
                                                echo htmlspecialchars($locationName);
                                                
                                                if ($location['is_dungeon'] == 1): ?>
                                                    <span class="badge bg-warning ms-2">Dungeon</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3">
                                                X: <?php echo htmlspecialchars($location['startX'] . ' - ' . $location['endX']); ?><br>
                                                Y: <?php echo htmlspecialchars($location['startY'] . ' - ' . $location['endY']); ?>
                                            </td>
                                            <td class="px-3 text-center">
                                                <?php echo number_format($location['monster_count']); ?>
                                            </td>
                                            <td class="px-3 text-center">
                                                <a href="view_location.php?id=<?php echo $location['mapid']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
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
            </div>
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