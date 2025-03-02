<?php
require_once 'database.php';

// Page setup
$page_title = "Magic Doll Enhancement Guide";
include 'header.php';
?>

<div class="container mt-4">
    <h1 class="mb-4">English Guide to Magic Doll Potential Enhancement</h1>
    <div class="card">
        <div class="card-body">
            <h2>Overview</h2>
            <p>
                Magic Doll Potential Enhancement allows players to upgrade their magic dolls by boosting hidden potential stats.
                Enhancements can improve a doll's performance by increasing various attributes, including:
            </p>
            <ul>
                <li><strong>Base Stats</strong>: Boosts to HP, MP, Strength, Dexterity, etc.</li>
                <li><strong>Additional Bonuses</strong>: Enhancements in attack, defense, speed, and special effects.</li>
                <li><strong>Special Effects</strong>: Activation of unique abilities or visual effects tied to potential milestones.</li>
            </ul>
            
            <h2>Requirements</h2>
            <p>Before attempting an enhancement, ensure you have the following:</p>
            <ul>
                <li><strong>Magic Doll</strong>: The target doll must have a baseline potential level available.</li>
                <li><strong>Enhancement Material</strong>: Typically, a Magic Doll Enhancement Stone or similar special item is required.</li>
                <li><strong>Sufficient Resources</strong>: Confirm you have the necessary in-game resources (currency, items, etc.) as required by the process.</li>
            </ul>
            
            <h2>Enhancement Process</h2>
            <ol>
                <li>
                    <strong>Initiation</strong>:<br>
                    Select the magic doll you wish to enhance and verify that the doll meets the minimum criteria for potential enhancement.
                </li>
                <li>
                    <strong>Enhancement Attempt</strong>:<br>
                    Use the enhancement material (e.g. right-click the Magic Doll Enhancement Stone in your inventory). The outcome is determined 
                    by various factors, including the doll's current enhancement level and inherent success probability.
                </li>
                <li>
                    <strong>Outcome</strong>:<br>
                    <em>Success</em>: The doll's potential grade increases, leading to improved stats and possibly unlocking new abilities.<br>
                    <em>Failure</em>: The doll may suffer a reduction in potential stats or even lose a grade. The risk and consequences are part of the 
                    enhancement challenge.
                </li>
            </ol>
            
            <h2>Stat Improvement and Display</h2>
            <p>
                Once an enhancement attempt is made, the doll's details are updated: 
            </p>
            <ul>
                <li><strong>Grade</strong>: Represents the current potential enhancement level.</li>
                <li><strong>Potential Stats</strong>: Displays the improvements or changes to the doll's stats.</li>
                <li><strong>Additional Effects</strong>: Includes speed effects and special abilities that may be activated based on specific enhancement thresholds.</li>
            </ul>
            
            <h2>Example Integration</h2>
            <p>
                In the LineageDB application, potential enhancement information is displayed on the <code>view_doll.php</code> page. The app retrieves
                enhancement details from the database and shows them alongside base stats, even if the database schema differs slightly from the expected structure.
                This guide helps clarify the enhancement logic for both developers and players.
            </p>
            
            <h2>Additional Resources</h2>
            <p>
                For further details and the full original explanation (in Korean), please refer to the official document:
            </p>
            <p>
                <a href="https://lineage.plaync.com/powerbook/wiki/%EB%A7%88%EB%B2%95%EC%9D%B8%ED%98%95%20%EC%9E%A0%EC%9E%AC%EB%A0%A5%20%EA%B0%95%ED%99%94" target="_blank" class="btn btn-secondary">
                    Official Magic Doll Potential Enhancement Guide (Korean)
                </a>
            </p>
            
            <h2>Conclusion</h2>
            <p>
                Understanding the potential enhancement process is essential for maximizing the performance of your magic dolls.
                Use this guide as a reference to integrate, test, and explain the enhancement feature within your application.
            </p>
            
            <p class="text-muted">
                <em>This guide is intended to complement the official documentation and assist both developers and players in mastering the Magic Doll Potential Enhancement system.</em>
            </p>
        </div>
    </div>

    <!-- Link Back to Doll List -->
    <div class="mt-4">
        <a href="doll_list.php" class="btn btn-primary">
            <i class="bi bi-arrow-left me-2"></i>Back to Magic Dolls
        </a>
    </div>
</div>

<?php
include 'footer.php';
?>