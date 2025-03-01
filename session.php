<?php
// Inside the session.php file

// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    // Start the session if it's not already started
    session_start();
}
?>