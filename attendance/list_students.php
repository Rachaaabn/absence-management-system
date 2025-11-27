<?php
require_once "db_connect.php";

$conn = getConnection();
if (!$conn) die("Connection failed.");

$stmt = $conn->query("SELECT * FROM students ORDER BY fullname");
$students = $stmt->fetchAll();

echo "<h2>Student List</h2>";
echo "<table border='1'>
<tr><th>ID</th><th>Full Name</th><th>Matricule</th><th>Group</th><th>Actions</th></tr>";

foreach ($students as $s) {
    echo "<tr>
            <td>{$s['id']}</td>
            <td>{$s['fullname']}</td>
            <td>{$s['matricule']}</td>
            <td>{$s['group_id']}</td>
            <td>
                <a href='update_student.php?id={$s['id']}'>Edit</a> |
                <a href='delete_student.php?id={$s['id']}'>Delete</a>
            </td>
          </tr>";
}

echo "</table>";
?>
