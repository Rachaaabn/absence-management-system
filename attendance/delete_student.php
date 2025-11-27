<?php
require_once "db_connect.php";

if (!isset($_GET["id"])) die("ID missing.");

$id = (int)$_GET["id"];

$conn = getConnection();
if (!$conn) die("Connection failed.");

try {
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$id]);
    echo "Student deleted successfully!";
} catch (PDOException $e) {
    echo "Error deleting student: " . $e->getMessage();
}
?>
