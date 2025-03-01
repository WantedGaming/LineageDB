<?php
// crud_functions.php - Centralized CRUD helper functions with admin checks

// Existing functions remain the same, adding new admin-specific functions

function requireAdminLogin() {
    session_start();
    
    // Check if admin is logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Store the current page to redirect back after login
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        
        // Set error message
        $_SESSION['error_message'] = "You must be logged in as an admin to access this page.";
        
        // Redirect to login page
        header("Location: login.php");
        exit;
    }
}

function checkAdminPermission($requiredAccessLevel = 100) {
    // Ensure admin is logged in and has sufficient access level
    if (!isset($_SESSION['admin_logged_in']) || 
        $_SESSION['admin_logged_in'] !== true || 
        $_SESSION['admin_access_level'] < $requiredAccessLevel) {
        
        // Set error message
        $_SESSION['error_message'] = "Insufficient permissions to perform this action.";
        
        // Redirect to dashboard or home page
        header("Location: admin_dashboard.php");
        exit;
    }
    
    return true;
}

function disableFeatureForNonAdmins($message = "This feature is only available to administrators.") {
    session_start();
    
    // If not logged in or not an admin
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        // Set error message
        $_SESSION['error_message'] = $message;
        
        // Redirect to login page
        header("Location: login.php");
        exit;
    }
}

// This can be used to show/hide admin-only buttons or links
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}
if (!function_exists('isAdminLoggedIn')) {
    function isAdminLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
}

// Function to get current admin's access level
function getCurrentAdminAccessLevel() {
    return isset($_SESSION['admin_access_level']) ? intval($_SESSION['admin_access_level']) : 0;
}

// Extend existing validation functions to check for admin-specific requirements
function validateItemInput($itemData, $itemType = 'armor') {
    $errors = [];

    // Basic validation rules (same as before)
    if (empty($itemData['desc_en'])) {
        $errors[] = "English description is required.";
    }

    // Additional admin-specific validations can be added here
    if ($itemType === 'armor') {
        // Armor-specific validations
        if (empty($itemData['type'])) {
            $errors[] = "Armor type is required.";
        }

        if (!is_numeric($itemData['ac']) || $itemData['ac'] < 0) {
            $errors[] = "Invalid armor class (AC) value.";
        }
    } elseif ($itemType === 'weapon') {
        // Weapon-specific validations
        if (empty($itemData['type'])) {
            $errors[] = "Weapon type is required.";
        }

        if (!is_numeric($itemData['dmg_small']) || $itemData['dmg_small'] < 0) {
            $errors[] = "Invalid minimum damage value.";
        }

        if (!is_numeric($itemData['dmg_large']) || $itemData['dmg_large'] < 0) {
            $errors[] = "Invalid maximum damage value.";
        }
    }

    return $errors;
}

// Wrapper for logging admin actions with more context
function logAdminAction($action, $itemId, $itemType, $details = '') {
    global $conn;
    
    // Ensure admin is logged in before logging
    if (!isAdminLoggedIn()) {
        error_log("Attempted to log action without admin login");
        return false;
    }

    $adminUsername = $_SESSION['admin_username'] ?? 'Unknown Admin';
    $fullDetails = "[{$adminUsername}] {$details}";

    return logDatabaseAction($conn, $action, $itemId, $fullDetails);
}
?>