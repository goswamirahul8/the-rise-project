<?php
// Database Configuration for Local XAMPP & Production Environments

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'fullstack_project';

function getDBConnection() {
    global $db_host, $db_user, $db_pass, $db_name;
    static $conn = null;
    
    if ($conn === null) {
        try {
            $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $conn = new PDO($dsn, $db_user, $db_pass, $options);
        } catch (PDOException $e) {
            // Fallback or graceful error handling
            error_log("Database Connection Error: " . $e->getMessage());
            $conn = false;
        }
    }
    return $conn;
}
?>
