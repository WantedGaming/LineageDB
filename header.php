<?php
// Inside the header.php file

// Include the necessary files
require_once 'database.php';
require_once 'crud_functions.php';
require_once 'session.php';

// ...
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Lineage Remaster'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-bg: #121212;
            --secondary-bg: #1e1e1e;
            --card-bg: #252525;
            --accent-color: #B07A45; /* Light brown */
            --accent-hover: #C18A55; /* Lighter brown */
            --text-primary: #e0e0e0;
            --text-secondary: #aaaaaa;
            --border-color: #333333;
        }
        
        body {
            background-color: var(--primary-bg);
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: var(--secondary-bg) !important;
            border-bottom: 1px solid var(--border-color);
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--accent-color) !important;
        }
        
        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--accent-color) !important;
        }
        
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-primary:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }
        
        .pagination .page-link {
            background-color: var(--secondary-bg);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(255, 255, 255, 0.05);
        }
        
        .table th {
            border-top: none;
            color: var(--accent-color);
        }
        
        .form-control, .form-select {
            background-color: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus, .form-select:focus {
            background-color: var(--secondary-bg);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(176, 122, 69, 0.25);
            color: var(--text-primary);
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        
        .breadcrumb-item a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--text-secondary);
        }
        
        .badge {
            font-weight: 500;
        }
        
        .stat-group {
            border: 1px solid var(--border-color);
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        /* Grade colors */
        .grade-MYTH { color: #FF00FF; font-weight: bold; }
        .grade-LEGEND { color: #FFA500; font-weight: bold; }
        .grade-HERO { color: #FF0000; font-weight: bold; }
        .grade-RARE { color: #0000FF; font-weight: bold; }
        .grade-ADVANC { color: #00FF00; }
        .grade-NORMAL { color: #FFFFFF; }
        
        /* Filter sidebar */
        .filter-sidebar {
            background-color: var(--secondary-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 1rem;
            height: fit-content;
        }
        
        .filter-header {
            color: var(--accent-color);
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .filter-section {
            margin-bottom: 1.5rem;
        }
        
        .filter-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        /* Item icons */
        .item-icon {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, 0.2);
            padding: 2px;
            vertical-align: middle;
            object-fit: contain;
        }

        .no-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background-color: rgba(0, 0, 0, 0.2);
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shield-fill me-2"></i>Game Armor DB
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto">
        <?php if (isAdminLoggedIn()): ?>
            <!-- Only show Add dropdown to admin users -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo ($current_page == 'add_armor.php' || $current_page == 'add_weapon.php') ? 'active' : ''; ?>" href="#" id="addDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle me-1"></i>Add
                </a>
                <ul class="dropdown-menu" aria-labelledby="addDropdown">
                    <li><a class="dropdown-item" href="add_armor.php">Armor</a></li>
                    <li><a class="dropdown-item" href="add_weapon.php">Weapon</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="add_accessory.php">Accessory</a></li>
                </ul>
            </li>
        <?php endif; ?>
        
        <!-- Other navigation items that should always be visible -->
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'armor_list.php') ? 'active' : ''; ?>" href="armor_list.php">
                <i class="bi bi-shield me-1"></i>Armor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'weapon_list.php') ? 'active' : ''; ?>" href="weapon_list.php">
                <i class="bi bi-sword me-1"></i>Weapons
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'accessory_list.php') ? 'active' : ''; ?>" href="accessory_list.php">
                <i class="bi bi-gem me-1"></i>Accessories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'locations_list.php') ? 'active' : ''; ?>" href="locations_list.php">
                <i class="bi bi-map me-1"></i>Locations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'monster_list.php') ? 'active' : ''; ?>" href="monster_list.php">
                <i class="bi bi-bug me-1"></i>Monsters
            </a>
        </li>
    </ul>
    
    <ul class="navbar-nav ms-auto">
        <?php if (isAdminLoggedIn()): ?>
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">
                    <i class="bi bi-speedometer2 me-1"></i>Admin Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Admin Login
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
        </div>
    </nav>
    
    <div class="container mb-4">