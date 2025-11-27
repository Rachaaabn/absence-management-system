<?php
require_once "db_connect.php";

$conn = getConnection();
if (!$conn) die("Connection failed.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $group_id = $_POST['group_id'];
    $prof_id = $_POST['prof_id'];
    $date = date('Y-m-d'); // today's date

    try {
        $stmt = $conn->prepare("
            INSERT INTO attendance_sessions (course_id, group_id, date, opened_by)
            VALUES (:course_id, :group_id, :date, :opened_by)
        ");
        $stmt->execute([
            ':course_id' => $course_id,
            ':group_id' => $group_id,
            ':date' => $date,
            ':opened_by' => $prof_id
        ]);

        echo "<p style='color:green;'>Session created. Session ID: " . $conn->lastInsertId() . "</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<h2>Create Attendance Session</h2>
<form method="POST">
    Course ID: <input type="number" name="course_id"><br><br>
    Group ID: <input type="text" name="group_id"><br><br>
    Professor ID: <input type="number" name="prof_id"><br><br>
    <button type="submit">Create Session</button>
</form>
