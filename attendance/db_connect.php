<?php
require_once "config.php";

function getConnection() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;

    try {
        // Create PDO connection
        $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8";
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS);

        // Error mode
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;  // SUCCESS

    } catch (PDOException $e) {

        // ---- OPTIONAL LOGGING ----
        $logMessage = date("Y-m-d H:i:s") . " - ERROR: " . $e->getMessage() . "\n";
        file_put_contents("db_errors.log", $logMessage, FILE_APPEND);

        return null;  // return null if failed
    }
}
?>
