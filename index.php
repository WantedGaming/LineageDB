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
                            <i class="bi bi-sword me-2"></i>Weapons
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
                            <i class="bi bi-monster me-2"></i>Monsters
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
        <div class="col-12">
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
    </div>
</div>

<?php include 'footer.php'; ?>