<?php
// crud_functions.php - Centralized CRUD helper functions
function sanitizeInput($conn, $input) {
    // Trim and escape input to prevent SQL injection
    return $conn->real_escape_string(trim($input));
}

function validateArmorInput($armorData) {
    $errors = [];

    // Basic validation rules
    if (empty($armorData['desc_en'])) {
        $errors[] = "English description is required.";
    }

    if (empty($armorData['type'])) {
        $errors[] = "Armor type is required.";
    }

    if (!is_numeric($armorData['grade']) || $armorData['grade'] < 0) {
        $errors[] = "Invalid grade value.";
    }

    if (!is_numeric($armorData['ac']) || $armorData['ac'] < 0) {
        $errors[] = "Invalid armor class (AC) value.";
    }

    return $errors;
}

function logDatabaseAction($conn, $action, $itemId, $details = '') {
    // Optional: Implement logging for tracking CRUD operations
    $logQuery = "INSERT INTO action_log (action, item_id, details, created_at) 
                 VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($logQuery);
    $stmt->bind_param('sss', $action, $itemId, $details);
    $stmt->execute();
}

function generateUniqueItemId($conn, $tableName = 'armor') {
    $query = "SELECT MAX(item_id) as max_id FROM $tableName";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['max_id'] + 1;
}

function handleUploadedIcon($file, $uploadPath = 'icons/') {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Invalid file type. Only PNG, JPEG, and GIF are allowed.");
    }

    if ($file['size'] > $maxFileSize) {
        throw new Exception("File is too large. Maximum size is 5MB.");
    }

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExtension;
    $destination = $uploadPath . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $newFileName;
    }

    return null;
}

// Function to display error messages
function displayErrorMessages() {
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . 
             htmlspecialchars($_SESSION['error_message']) . 
             '</div>';
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['form_errors']) && is_array($_SESSION['form_errors'])) {
        echo '<div class="alert alert-warning">';
        echo '<ul>';
        foreach ($_SESSION['form_errors'] as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        unset($_SESSION['form_errors']);
    }
}

// Function to display success messages
function displaySuccessMessages() {
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . 
             htmlspecialchars($_SESSION['success_message']) . 
             '</div>';
        unset($_SESSION['success_message']);
    }
}
?>