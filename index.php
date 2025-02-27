<?php
// index.php - Main landing page for the game database
require_once 'database.php';

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

    <div class="row g-4">
        <!-- Main Categories - Big Boxes -->
        <div class="col-12 mb-2">
            <h4>
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Main Categories
            </h4>
        </div>
        
        <!-- Armor Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-shield-fill" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Armor</h4>
                    <p class="card-text mb-4">Browse all armor items including helmets, body armor, shields, and more.</p>
                    <a href="armor_list.php" class="btn btn-primary d-flex justify-content-between align-items-center">
                        <span>View Armor</span>
                        <span class="badge bg-light text-primary rounded-pill ms-2">
                            <?php 
                            $armorCount = $conn->query("SELECT COUNT(*) as count FROM armor")->fetch_assoc()['count'];
                            echo number_format($armorCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Weapons Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-danger">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-hammer" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Weapons</h4>
                    <p class="card-text mb-4">Find detailed information about swords, axes, bows, and all combat weapons.</p>
                    <a href="weapon_list.php" class="btn btn-danger d-flex justify-content-between align-items-center">
                        <span>View Weapons</span>
                        <span class="badge bg-light text-danger rounded-pill ms-2">
                            <?php 
                            $weaponCount = $conn->query("SELECT COUNT(*) as count FROM weapon")->fetch_assoc()['count'];
                            echo number_format($weaponCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Accessories Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-success">
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
                            // Define accessory types to count from the armor table
                            $accessoryTypes = ['PENDANT', 'BADGE', 'SENTENCE', 'RON', 'EARRING', 'BELT', 'RING', 'RING_2', 'AMULET'];
                            $typesString = "'" . implode("','", $accessoryTypes) . "'";
                            $accessoryCount = $conn->query("SELECT COUNT(*) as count FROM armor WHERE type IN ($typesString)")->fetch_assoc()['count'];
                            echo number_format($accessoryCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Locations Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-info">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-map" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Locations</h4>
                    <p class="card-text mb-4">Discover all game locations including towns, fields, and special areas.</p>
                    <a href="#" class="btn btn-info d-flex justify-content-between align-items-center">
                        <span>View Locations</span>
                        <span class="badge bg-light text-info rounded-pill ms-2">
                            <?php 
                            $mapCount = $conn->query("SELECT COUNT(*) as count FROM mapids")->fetch_assoc()['count'];
                            echo number_format($mapCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Dungeons Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-dark">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-door-open" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Dungeons</h4>
                    <p class="card-text mb-4">Learn about instanced dungeons, rewards, boss fights and level requirements.</p>
                    <a href="#" class="btn btn-dark d-flex justify-content-between align-items-center">
                        <span>View Dungeons</span>
                        <span class="badge bg-light text-dark rounded-pill ms-2">
                            <?php 
                            $dungeonCount = $conn->query("SELECT COUNT(*) as count FROM dungeon")->fetch_assoc()['count'];
                            echo number_format($dungeonCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Monsters Box -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-warning">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-bug" style="font-size: 3.5rem; color: var(--accent-color);"></i>
                    </div>
                    <h4 class="card-title mb-3">Monsters</h4>
                    <p class="card-text mb-4">Search for monsters by level, location, and loot tables.</p>
                    <a href="view_monster.php" class="btn btn-warning d-flex justify-content-between align-items-center">
                        <span>View Monsters</span>
                        <span class="badge bg-light text-warning rounded-pill ms-2">
                            <?php 
                            $npcCount = $conn->query("SELECT COUNT(*) as count FROM npc")->fetch_assoc()['count'];
                            echo number_format($npcCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- *** NEW SECTION: Items Categories *** -->
    <div class="row mt-4">
        <div class="col-12 mb-3">
            <h4>
                <i class="bi bi-box-seam me-2"></i>Game Items
            </h4>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-book me-2"></i>Magical Artifacts
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-journal me-2"></i>Scrolls
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
                            <?php 
                            $skillCount = $conn->query("SELECT COUNT(*) as count FROM skills")->fetch_assoc()['count'];
                            echo number_format($skillCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-heart-pulse me-2"></i>Recovery Items
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-cup-hot me-2"></i>Potions
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-egg-fried me-2"></i>Food
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-arrow-up-right me-2"></i>Arrows
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-magic me-2"></i>Polymorphs
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php 
                            $polyCount = $conn->query("SELECT COUNT(*) as count FROM polymorphs")->fetch_assoc()['count'];
                            echo number_format($polyCount); 
                            ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-stars me-2"></i>Valuables & Rarities
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
                    <h5 class="mb-0">
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
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event me-2"></i>Seasonal & Special
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
    <!-- END OF NEW SECTIONS -->

<!-- Recent Updates or Featured Content -->
<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-stars me-2"></i>Recent Database Updates
                </h4>
                <span class="badge bg-success">Live Updates</span>
            </div>
            <div class="card-body">
                <!-- Boss Spawn Alert - This would be dynamically shown when a boss appears -->
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
    
    <!-- Game Statistics Cards -->
    <div class="col-12">
        <h4 class="mb-3">
            <i class="bi bi-graph-up me-2"></i>Game Statistics
        </h4>
        <div class="row g-3">
            <!-- Players Card -->
            <div class="col-md-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Active Players</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    try {
                                        // Try different potential character table names
                                        $tablesToTry = ['characters', 'character_data', 'character_list', 'chars'];
                                        $statusColumns = ['OnlineStatus', 'online_status', 'is_online', 'online'];
                                        $activePlayersCount = 0;
                                        
                                        foreach ($tablesToTry as $table) {
                                            // Check if the table exists
                                            $result = $conn->query("SHOW TABLES LIKE '$table'");
                                            if ($result->num_rows > 0) {
                                                // Table exists, check which status column exists
                                                $columns = [];
                                                $columnsResult = $conn->query("SHOW COLUMNS FROM $table");
                                                while($column = $columnsResult->fetch_assoc()) {
                                                    $columns[] = $column['Field'];
                                                }
                                                
                                                foreach ($statusColumns as $statusColumn) {
                                                    if (in_array($statusColumn, $columns)) {
                                                        $query = "SELECT COUNT(*) as count FROM $table WHERE $statusColumn = 1";
                                                        $activePlayersCount = $conn->query($query)->fetch_assoc()['count'];
                                                        break 2; // Exit both loops
                                                    }
                                                }
                                                
                                                // If no status column found, just count all entries
                                                $activePlayersCount = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                                                break;
                                            }
                                        }
                                        echo number_format($activePlayersCount);
                                    } catch (Exception $e) {
                                        echo "N/A";
                                    }
                                    ?>
                                </h3>
                            </div>
                            <div class="display-5 text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <div class="small text-muted mt-3">
                            Total Characters: 
                            <?php 
                            try {
                                // Try different potential character table names
                                $tablesToTry = ['characters', 'character_data', 'character_list', 'chars'];
                                $totalCharsCount = 0;
                                
                                foreach ($tablesToTry as $table) {
                                    // Check if the table exists
                                    $result = $conn->query("SHOW TABLES LIKE '$table'");
                                    if ($result->num_rows > 0) {
                                        $totalCharsCount = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                                        break;
                                    }
                                }
                                echo number_format($totalCharsCount);
                            } catch (Exception $e) {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Accounts Card -->
            <div class="col-md-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Registered Accounts</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    $accountsCount = $conn->query("SELECT COUNT(*) as count FROM accounts")->fetch_assoc()['count'];
                                    echo number_format($accountsCount); 
                                    ?>
                                </h3>
                            </div>
                            <div class="display-5 text-success">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>
                        <div class="small text-muted mt-3">
                            <?php 
                            try {
                                // Try different possible column names for account creation date
                                $dateColumns = ['createdate', 'create_date', 'creation_date', 'created_at', 'register_date'];
                                $newAccountsCount = 0;
                                $foundColumn = false;
                                
                                // Get the column names from the accounts table
                                $columnsResult = $conn->query("SHOW COLUMNS FROM accounts");
                                $columns = [];
                                while($column = $columnsResult->fetch_assoc()) {
                                    $columns[] = $column['Field'];
                                }
                                
                                // Check if any of our potential date columns exist
                                foreach($dateColumns as $dateColumn) {
                                    if(in_array($dateColumn, $columns)) {
                                        $newAccountsQuery = "SELECT COUNT(*) as count FROM accounts WHERE $dateColumn > DATE_SUB(NOW(), INTERVAL 7 DAY)";
                                        $newAccountsCount = $conn->query($newAccountsQuery)->fetch_assoc()['count'];
                                        $foundColumn = true;
                                        break;
                                    }
                                }
                                
                                echo "Recent Activity: " . number_format($newAccountsCount); 
                            } catch (Exception $e) {
                                echo "Recent Activity: N/A";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PK Deaths Card -->
            <div class="col-md-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">PK Deaths</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    try {
                                        // Try different potential death tracking tables and columns
                                        $tablesToTry = ['character_deaths', 'death_log', 'kill_log', 'pk_log'];
                                        $pkFlagColumns = ['pk_flag', 'is_pk', 'pk', 'is_player_kill'];
                                        $pkDeathsCount = 0;
                                        $tableFound = false;
                                        
                                        foreach ($tablesToTry as $table) {
                                            // Check if the table exists
                                            $result = $conn->query("SHOW TABLES LIKE '$table'");
                                            if ($result->num_rows > 0) {
                                                $tableFound = true;
                                                
                                                // Check which PK flag column exists
                                                $columns = [];
                                                $columnsResult = $conn->query("SHOW COLUMNS FROM $table");
                                                while($column = $columnsResult->fetch_assoc()) {
                                                    $columns[] = $column['Field'];
                                                }
                                                
                                                $flagFound = false;
                                                foreach ($pkFlagColumns as $flagColumn) {
                                                    if (in_array($flagColumn, $columns)) {
                                                        $query = "SELECT COUNT(*) as count FROM $table WHERE $flagColumn = 1";
                                                        $pkDeathsCount = $conn->query($query)->fetch_assoc()['count'];
                                                        $flagFound = true;
                                                        break;
                                                    }
                                                }
                                                
                                                // If we found the table but no PK flag column, count all deaths
                                                if (!$flagFound) {
                                                    $pkDeathsCount = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                                                }
                                                
                                                break;
                                            }
                                        }
                                        
                                        if (!$tableFound) {
                                            // If no death table exists, show 0
                                            $pkDeathsCount = 0;
                                        }
                                        
                                        echo number_format($pkDeathsCount);
                                    } catch (Exception $e) {
                                        echo "N/A";
                                    }
                                    ?>
                                </h3>
                            </div>
                            <div class="display-5 text-danger">
                                <i class="bi bi-shield-x"></i>
                            </div>
                        </div>
                        <div class="small text-muted mt-3">
                            Recent Activity 
                            <?php 
                            try {
                                // Try different potential death tracking tables and columns
                                $tablesToTry = ['character_deaths', 'death_log', 'kill_log', 'pk_log'];
                                $pkFlagColumns = ['pk_flag', 'is_pk', 'pk', 'is_player_kill'];
                                $timeColumns = ['death_time', 'killed_at', 'time', 'created_at', 'timestamp'];
                                $todayPkDeathsCount = 0;
                                
                                foreach ($tablesToTry as $table) {
                                    // Check if the table exists
                                    $result = $conn->query("SHOW TABLES LIKE '$table'");
                                    if ($result->num_rows > 0) {
                                        // Get all columns for this table
                                        $columns = [];
                                        $columnsResult = $conn->query("SHOW COLUMNS FROM $table");
                                        while($column = $columnsResult->fetch_assoc()) {
                                            $columns[] = $column['Field'];
                                        }
                                        
                                        // Find PK flag column and time column
                                        $pkFlagColumn = null;
                                        foreach ($pkFlagColumns as $col) {
                                            if (in_array($col, $columns)) {
                                                $pkFlagColumn = $col;
                                                break;
                                            }
                                        }
                                        
                                        $timeColumn = null;
                                        foreach ($timeColumns as $col) {
                                            if (in_array($col, $columns)) {
                                                $timeColumn = $col;
                                                break;
                                            }
                                        }
                                        
                                        // Construct query based on available columns
                                        if ($timeColumn) {
                                            $query = "SELECT COUNT(*) as count FROM $table WHERE ";
                                            if ($pkFlagColumn) {
                                                $query .= "$pkFlagColumn = 1 AND ";
                                            }
                                            $query .= "$timeColumn > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
                                            $todayPkDeathsCount = $conn->query($query)->fetch_assoc()['count'];
                                        } else {
                                            // If we found the table but no time column, just count by PK flag
                                            if ($pkFlagColumn) {
                                                $todayPkDeathsCount = $conn->query("SELECT COUNT(*) as count FROM $table WHERE $pkFlagColumn = 1")->fetch_assoc()['count'];
                                            } else {
                                                $todayPkDeathsCount = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                                            }
                                        }
                                        
                                        break;
                                    }
                                }
                                
                                echo number_format($todayPkDeathsCount); 
                            } catch (Exception $e) {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Events Card (New) -->
            <div class="col-md-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Active Events</h6>
                                <h3 class="mb-0">
                                    <?php
                                    // This would be replaced with actual event counting logic
                                    $activeEventsCount = 2; // Example value - would be dynamic in real implementation
                                    echo $activeEventsCount > 0 ? number_format($activeEventsCount) : "None";
                                    ?>
                                </h3>
                            </div>
                            <div class="display-5 text-warning">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        </div>
                        <div class="small mt-3">
                            <?php if ($activeEventsCount > 0): ?>
                                <span class="text-success">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Valentine's Day (ends in 3 days)
                                </span>
                                <br>
                                <span class="text-success">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Double XP Weekend (ends Monday)
                                </span>
                            <?php else: ?>
                                <span class="text-muted">
                                    <i class="bi bi-calendar-x me-1"></i>
                                    No Events Active
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>