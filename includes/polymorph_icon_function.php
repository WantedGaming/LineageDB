<?php
/**
 * Find the best icon for a polymorph
 * 
 * @param mysqli $conn Database connection
 * @param int $polyId Polymorph ID
 * @param int $polyItemId Item ID from polyitems
 * @return string|null Path to the icon
 */
function findPolymorphIcon($conn, $polyId, $polyItemId = null) {
    // Possible icon sources in order of preference
    $iconSources = [
        // 1. Check etcitem for icon via polyitems
        function() use ($conn, $polyItemId) {
            if (!$polyItemId) return null;
            
            $query = "SELECT iconId FROM etcitem WHERE item_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $polyItemId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $iconPath = "icons/icon_{$row['iconId']}.png";
                return file_exists($iconPath) ? $iconPath : null;
            }
            return null;
        },
        
        // 2. Check sprite image
        function() use ($polyId) {
            $spritePath = "icons/ms{$polyId}.png";
            return file_exists($spritePath) ? $spritePath : null;
        },
        
        // 3. Fallback to default polymorph icon
        function() {
            $defaultIconPath = "icons/polymorph_default.png";
            return file_exists($defaultIconPath) ? $defaultIconPath : null;
        }
    ];
    
    // Try each icon source
    foreach ($iconSources as $sourceFunc) {
        $iconPath = $sourceFunc();
        if ($iconPath) return $iconPath;
    }
    
    return null;
}
