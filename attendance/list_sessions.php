<?php
require_once "db_connect.php";

$conn = getConnection();
if (!$conn) die("Connection failed.");

// Fetch all sessions
try {
    $stmt = $conn->query("SELECT * FROM attendance_sessions ORDER BY date DESC, id DESC");
    $sessions = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching sessions: " . $e->getMessage());
}

echo "<h2>Attendance Sessions</h2>";

if (empty($sessions)) {
    echo "<p>No sessions found.</p>";
} else {
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID</th>
                <th>Course ID</th>
                <th>Group ID</th>
                <th>Date</th>
                <th>Opened By</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>";

    foreach ($sessions as $s) {
        echo "<tr>
                <td>{$s['id']}</td>
                <td>{$s['course_id']}</td>
                <td>{$s['group_id']}</td>
                <td>{$s['date']}</td>
                <td>{$s['opened_by']}</td>
                <td>{$s['status']}</td>
                <td>";
        
        if ($s['status'] === 'open') {
            echo "<a href='close_session.php?session_id={$s['id']}'>Close</a>";
        } else {
            echo "-";
        }

        echo "</td></tr>";
    }

    echo "</table>";
}
?>
