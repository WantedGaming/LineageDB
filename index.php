<?php
// index.php - Main landing page for the game database
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database.php';

// Function to safely get count or return 'N/A'
function getSafeCount($conn, $table, $condition = '1') {
    try {
        $query = "SELECT COUNT(*) as count FROM $table WHERE $condition";
        $result = $conn->query($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return number_format($row['count']);
        }
    } catch (Exception $e) {
        error_log("Error counting in table $table: " . $e->getMessage());
    }
    return 'N/A';
}

$page_title = "Lineage Remaster DB";
include 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">
                        <i class="bi bi-database-fill me-2"></i>Lineage Remaster DB
                    </h1>
                </div>
                <div class="card-body">
                    <p class="lead">Explore comprehensive information about the game's items, characters, and game mechanics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Updates Section -->
    <div class="row mt-4">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-stars me-2"></i>Recent Updates
                    </h4>
                    <span class="badge bg-success">Live Updates</span>
                </div>
                <div class="card-body">
                    <!-- Boss Spawn Alert -->
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1"><strong>Boss Spawn Alert!</strong></h5>
                                <p class="mb-0"><strong>Antharas</strong> has appeared in <strong>Dragon Valley (Ancient Island)</strong> at <strong><?php echo date('H:i'); ?></strong></p>
                                <small class="text-muted">Estimated despawn time: <?php echo date('H:i', strtotime('+2 hours')); ?></small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <!-- Database Update Information -->
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">New Weapon Data Added</h5>
                                <small class="text-muted">Today</small>
                            </div>
                            <p class="mb-1">Added 25 new weapon entries to the database including Mythical-grade items.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Monster Database Updated</h5>
                                <small class="text-muted">Yesterday</small>
                            </div>
                            <p class="mb-1">Updated drop tables for all dungeon monsters with latest patch changes.</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Event Items Section Coming Soon</h5>
                                <small class="text-muted">2 days ago</small>
                            </div>
                            <p class="mb-1">Development has begun on the Event Items database section, coming next week.</p>
                        </div>
                    </div>
                    
                    <!-- Information about boss spawn system -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Boss spawn alerts are displayed in real-time when they appear in the game world. 
                            Click on a boss name to view detailed information about their location, stats, and drops.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Categories - Big Boxes -->
        <div class="col-12 mb-2">
            <h4>
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Main Categories
            </h4>
        </div>
        
        <!-- Armor Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary category-card" data-href="armor_list.php">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-shield-fill" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Armor</h4>
                    <p class="card-text mb-4">Browse all armor items including helmets, body armor, shields, and more.</p>
                    <a href="armor_list.php" class="btn btn-primary d-flex justify-content-between align-items-center">
                        <span>View Armor</span>
                        <span class="badge bg-light text-primary rounded-pill ms-2">
                            <?php echo getSafeCount($conn, 'armor'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Weapons Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-danger category-card" data-href="weapon_list.php">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-hammer" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Weapons</h4>
                    <p class="card-text mb-4">Find detailed information about swords, axes, bows, and all combat weapons.</p>
                    <a href="weapon_list.php" class="btn btn-danger d-flex justify-content-between align-items-center">
                        <span>View Weapons</span>
                        <span class="badge bg-light text-danger rounded-pill ms-2">
                            <?php echo getSafeCount($conn, 'weapon'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Accessories Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success category-card" data-href="accessory_list.php">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-gem" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Accessories</h4>
                    <p class="card-text mb-4">Explore rings, earrings, necklaces and other stat-boosting accessories.</p>
                    <a href="accessory_list.php" class="btn btn-success d-flex justify-content-between align-items-center">
                        <span>View Accessories</span>
                        <span class="badge bg-light text-success rounded-pill ms-2">
                            <?php 
                            $accessoryTypes = ['PENDANT', 'BADGE', 'SENTENCE', 'RON', 'EARRING', 'BELT', 'RING', 'RING_2', 'AMULET'];
                            $typesString = "'" . implode("','", $accessoryTypes) . "'";
                            echo getSafeCount($conn, 'armor', "type IN ($typesString)");
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Locations Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-info category-card" data-href="locations_list.php">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-map" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Locations</h4>
                    <p class="card-text mb-4">Discover all game locations including towns, fields, and special areas.</p>
                    <a href="locations_list.php" class="btn btn-info d-flex justify-content-between align-items-center">
                        <span>View Locations</span>
                        <span class="badge bg-light text-info rounded-pill ms-2">
                            <?php echo getSafeCount($conn, 'mapids'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Replace the Dungeons Box with Magic Doll Box -->
<div class="col-md-4 mb-4">
    <div class="card h-100 border-dark category-card" data-href="doll_list.php">
        <div class="card-body text-center">
            <div class="mb-3">
                <i class="bi bi-robot" style="font-size: 3.5rem; color: var(--accent-color);"></i>
            </div>
            <h4 class="card-title mb-3">Magic Dolls</h4>
            <p class="card-text mb-4">Browse magic dolls that can be summoned to assist you in battle.</p>
            <a href="doll_list.php" class="btn btn-dark d-flex justify-content-between align-items-center">
                <span>View Magic Dolls</span>
                <span class="badge bg-light text-dark rounded-pill ms-2">
                    <?php echo getSafeCount($conn, 'npc', "impl = 'L1Doll'"); ?>
                </span>
            </a>
        </div>
    </div>
</div>
        
         <!-- Monsters Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-warning category-card" data-href="monster_list.php">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-bug" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Monsters</h4>
                    <p class="card-text mb-4">Search for monsters by level, location, and loot tables.</p>
                    <a href="monster_list.php" class="btn btn-warning d-flex justify-content-between align-items-center">
                        <span>View Monsters</span>
                        <span class="badge bg-light text-warning rounded-pill ms-2">
                            <?php echo getSafeCount($conn, 'npc'); ?>
                        </span>
                    </a>
                </div>
    </div>
</div>
    <!-- Game Items Categories -->
    <div class="row mt-4">
        <div class="col-12 mb-3">
            <h4>
                <i class="bi bi-box-seam me-2"></i>Game Items
            </h4>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--accent-color);>
                        <i class="bi bi-book me-2"></i>Magical
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-journal me-2"></i>Polymorphs
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-book-half me-2"></i>Spellbooks
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-magic me-2"></i>Wands
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-activity me-2"></i>Skills
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php echo getSafeCount($conn, 'skills'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--accent-color);>
                        <i class="bi bi-heart-pulse me-2"></i>Consumeables
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-cup-hot me-2"></i>Potions
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><span>
                            <i class="bi bi-egg-fried me-2"></i>Scrolls
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-arrow-up-right me-2"></i>Food
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-magic me-2"></i>Arrows
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php echo getSafeCount($conn, 'polymorphs'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--accent-color);>
                        <i class="bi bi-stars me-2"></i>Valuables
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-gem me-2"></i>Gems
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-brightness-high me-2"></i>Light
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-lightning me-2"></i>Totems
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Item Categories -->
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--accent-color);>
                        <i class="bi bi-trophy me-2"></i>Adventure Items
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-box2 me-2"></i>Treasure Boxes
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-flag me-2"></i>Quest Items
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-bandaid me-2"></i>Stings
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--accent-color);>
                        <i class="bi bi-calendar-event me-2"></i>Rarities
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-balloon me-2"></i>Event Items
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-fire me-2"></i>Fire Crackers
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-emoji-smile me-2"></i>Pet Items
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Add New Item
                    </h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-database-add" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <p>Add missing items to our database and help other players.</p>
                    <a href="add_item.php" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-2"></i>Add New Item
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryCards = document.querySelectorAll('.category-card');
        
        categoryCards.forEach(card => {
            // Make entire card clickable
            card.style.cursor = 'pointer';
            
            // Add hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'transform 0.2s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
            
            // Navigate to link on click
            card.addEventListener('click', function() {
                const href = this.getAttribute('data-href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });
    });
    </script>

    <?php include 'footer.php'; ?>
</div>
</body>
</html>