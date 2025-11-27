<?php
require_once "db_connect.php";

$conn = getConnection();
if (!$conn) die("Connection failed.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = $_POST['session_id'];

    try {
        $stmt = $conn->prepare("
            UPDATE attendance_sessions SET status='closed' WHERE id=:id
        ");
        $stmt->execute([':id' => $session_id]);

        echo "<p style='color:green;'>Session $session_id closed successfully!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<h2>Close Attendance Session</h2>
<form method="POST">
    Session ID: <input type="number" name="session_id"><br><br>
    <button type="submit">Close Session</button>
</form>
