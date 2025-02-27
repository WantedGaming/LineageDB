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
        <!-- Equipment Categories -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-fill me-2"></i>Equipment
                    </h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="armor_list.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-shield me-2"></i>Armor
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php 
                            $armorCount = $conn->query("SELECT COUNT(*) as count FROM armor")->fetch_assoc()['count'];
                            echo number_format($armorCount); 
                            ?>
                        </span>
                    </a>
                    <a href="weapon_list.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-screwdriver"></i> Weapons
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php 
                            $weaponCount = $conn->query("SELECT COUNT(*) as count FROM weapon")->fetch_assoc()['count'];
                            echo number_format($weaponCount); 
                            ?>
                        </span>
                    </a>
                    <a href="accessory_list.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-backpack me-2"></i>Accessories
                        </span>
                        <span class="badge bg-secondary rounded-pill">Coming Soon</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Character Categories -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>Characters
                    </h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-person-badge me-2"></i>Classes
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

        <!-- World Categories -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-globe me-2"></i>World
                    </h4>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-map me-2"></i>Locations
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php 
                            $mapCount = $conn->query("SELECT COUNT(*) as count FROM mapids")->fetch_assoc()['count'];
                            echo number_format($mapCount); 
                            ?>
                        </span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-journal-text me-2"></i>Dungeons
                        </span>
                        <span class="badge bg-primary rounded-pill">
                            <?php 
                            $dungeonCount = $conn->query("SELECT COUNT(*) as count FROM dungeon")->fetch_assoc()['count'];
                            echo number_format($dungeonCount); 
                            ?>
                        </span>
                    </a>
                    <a href="view_monster.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-fullscreen-exit">  </i>Monsters
                        </span>
                        <span class="badge bg-primary rounded-pill">
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
<!-- Recent Updates or Featured Content -->
<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="bi bi-stars me-2"></i>Recent Database Updates
                </h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    Database is currently being populated. More sections will be added soon!
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
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            <div class="col-md-3">
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
            
            <!-- Boss Kill Card -->
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Boss Kills</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    try {
                                        // Try different potential boss kill tables
                                        $tablesToTry = ['boss_kills', 'boss_kill_log', 'boss_spawns', 'raid_log'];
                                        $bossKillsCount = 0;
                                        
                                        foreach ($tablesToTry as $table) {
                                            // Check if the table exists
                                            $result = $conn->query("SHOW TABLES LIKE '$table'");
                                            if ($result->num_rows > 0) {
                                                $bossKillsCount = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                                                break;
                                            }
                                        }
                                        
                                        echo number_format($bossKillsCount);
                                    } catch (Exception $e) {
                                        echo "N/A";
                                    }
                                    ?>
                                </h3>
                            </div>
                            <div class="display-5 text-warning">
                                <i class="bi bi-trophy"></i>
                            </div>
                        </div>
                        <div class="small text-muted mt-3">
                            Last Boss Kill: 
                            <?php 
                            try {
                                // Try different potential boss kill tables and time columns
                                $tablesToTry = ['boss_kills', 'boss_kill_log', 'boss_spawns', 'raid_log'];
                                $timeColumns = ['killed_time', 'kill_time', 'time', 'created_at', 'timestamp', 'death_time'];
                                $lastBossKill = null;
                                
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
                                        
                                        // Find time column
                                        foreach ($timeColumns as $col) {
                                            if (in_array($col, $columns)) {
                                                $query = "SELECT $col as time_col FROM $table ORDER BY $col DESC LIMIT 1";
                                                $result = $conn->query($query);
                                                if ($result && $result->num_rows > 0) {
                                                    $lastBossKill = $result->fetch_assoc();
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        if ($lastBossKill) break;
                                    }
                                }
                                
                                echo !empty($lastBossKill) ? date('M d, H:i', strtotime($lastBossKill['time_col'])) : 'None';
                            } catch (Exception $e) {
                                echo "None";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>