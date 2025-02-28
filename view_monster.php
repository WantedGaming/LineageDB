<?php
// view_monster.php - Monster Detail Page
require_once 'database.php';

// Page setup
$page_title = "Monster Details";
include 'header.php';

// Check if monster ID is provided
if (isset($_GET['id'])) {
    $monsterId = $_GET['id'];
    
    try {
        // Fetch monster details
        $query = "SELECT * FROM npc WHERE npcid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $monsterId);
        $stmt->execute();
        $result = $stmt->get_result();
        $monster = $result->fetch_assoc();
        
        if ($monster) {
            // Display monster details
            ?>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <?php
                                $spritePath = "icons/ms{$monster['spriteId']}.png";
                                if (file_exists($spritePath)):
                                ?>
                                    <img src="<?php echo $spritePath; ?>"
                                         alt="Monster Sprite"
                                         class="img-fluid">
                                <?php else: ?>
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0"><?php echo htmlspecialchars($monster['desc_en']); ?></h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td><?php echo htmlspecialchars($monster['npcid']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Level</th>
                                            <td><?php echo htmlspecialchars($monster['lvl']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>HP</th>
                                            <td><?php echo htmlspecialchars($monster['hp']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>MP</th>
                                            <td><?php echo htmlspecialchars($monster['mp']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>AC</th>
                                            <td><?php echo htmlspecialchars($monster['ac']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>STR</th>
                                            <td><?php echo htmlspecialchars($monster['str']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>CON</th>
                                            <td><?php echo htmlspecialchars($monster['con']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>DEX</th>
                                            <td><?php echo htmlspecialchars($monster['dex']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>WIS</th>
                                            <td><?php echo htmlspecialchars($monster['wis']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>INT</th>
                                            <td><?php echo htmlspecialchars($monster['intel']); ?></td>  
                                        </tr>
                                        <tr>
                                            <th>MR</th>
                                            <td><?php echo htmlspecialchars($monster['mr']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>EXP</th>
                                            <td><?php echo htmlspecialchars($monster['exp']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Drops</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Item Name</th>
                                                <th>Min</th>
                                                <th>Max</th>
                                                <th>Chance</th>
                                                <th>Enchant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch drop data based on droplist.csv
                                            $dropsFile = fopen('droplist.csv', 'r');
                                            fgetcsv($dropsFile); // Skip header row

                                            while ($drop = fgetcsv($dropsFile)) {
                                                list($mobId, $mobname_kr, $mobname_en, $moblevel, $itemId, $itemname_kr, $itemname_en, $min, $max, $chance, $Enchant) = $drop;
                                                
                                                if ($mobId == $monsterId):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($itemId); ?></td>
                                                    <td><?php echo htmlspecialchars($itemname_en); ?></td>
                                                    <td><?php echo htmlspecialchars($min); ?></td>
                                                    <td><?php echo htmlspecialchars($max); ?></td>
                                                    <td><?php echo htmlspecialchars($chance); ?></td>
                                                    <td><?php echo htmlspecialchars($Enchant); ?></td>
                                                </tr>
                                            <?php
                                                endif;
                                            }
                                            
                                            fclose($dropsFile);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Locations</h5>
                            </div>
                            <div class="card-body">
                                <!-- TODO: Implement location data display -->
                                <p>Location data goes here</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="monster_list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Monster List
                    </a>
                </div>
            </div>
            <?php
        } else {
            // Monster not found
            ?>
            <div class="container mt-4">
                <div class="alert alert-warning">
                    <strong>Monster not found.</strong> The requested monster does not exist.
                </div>
                <a href="monster_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Monster List
                </a>
            </div>
            <?php
        }
        
        // Close statement
        $stmt->close();
        
    } catch (Exception $e) {
        // Error handling 
        ?>
        <div class="container mt-4">
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>  
            </div>
        </div>
        <?php
    }
} else {
    // Redirect if monster ID is not provided
    header("Location: monster_list.php");
    exit();  
}

include 'footer.php';
?>