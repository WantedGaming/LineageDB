<?php
/**
 * Helper function to get polymorph icon paths
 * This function checks multiple possible locations for polymorph icons
 */
function getPolymorphIconPath($polymorph) {
    // 1. Check for item icon if available
    if (!empty($polymorph['etcitem_icon'])) {
        $iconPath = "icons/icon_{$polymorph['etcitem_icon']}.png";
        if (file_exists($iconPath)) {
            return $iconPath;
        }
    }
    
    // 2. Check for sprite image using polyID
    $spritePath = "icons/ms{$polymorph['polyid']}.png";
    if (file_exists($spritePath)) {
        return $spritePath;
    }
    
    // 3. Try to find a generic icon based on name
    $genericPath = null;
    if (stripos($polymorph['name'], 'knight') !== false) {
        $genericPath = "icons/type_knight.png";
    } elseif (stripos($polymorph['name'], 'assassin') !== false) {
        $genericPath = "icons/type_assassin.png";
    } elseif (stripos($polymorph['name'], 'ranger') !== false || stripos($polymorph['name'], 'scouter') !== false) {
        $genericPath = "icons/type_ranger.png";
    } elseif (stripos($polymorph['name'], 'wizard') !== false || stripos($polymorph['name'], 'magister') !== false) {
        $genericPath = "icons/type_wizard.png";
    } elseif (stripos($polymorph['name'], 'death') !== false) {
        $genericPath = "icons/type_death.png";
    } elseif (stripos($polymorph['name'], 'orc') !== false) {
        $genericPath = "icons/type_orc.png";
    }
    
    if ($genericPath && file_exists($genericPath)) {
        return $genericPath;
    }
    
    // 4. Return a default placeholder
    $defaultPath = "icons/default_polymorph.png";
    if (file_exists($defaultPath)) {
        return $defaultPath;
    }
    
    // No icon found
    return null;
}