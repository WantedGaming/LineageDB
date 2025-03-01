<?php
// Inside the security_functions.php file

function securityLog($action, $username, $ip, $details = '') {
    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');
    
    // Format the log message
    $logMessage = "$timestamp | $action | $username | $ip | $details\n";
    
    // Specify the log file path
    $logFile = 'security.log';
    
    // Append the log message to the log file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>