<?php
require_once "db_connect.php";

$conn = getConnection();

if ($conn) {
    echo "<h2 style='color:green;'>Connection successful ✔️</h2>";
} else {
    echo "<h2 style='color:red;'>Connection failed ✘</h2>";
}
?>
mysql creat <table>add_student.php</table>
creat <table>list_students.php</table>
<table>update_student.php</table>
creat <table>delete_student.php</table>
