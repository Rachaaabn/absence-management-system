<?php
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = $_POST["fullname"];
    $matricule = $_POST["matricule"];
    $group_id = $_POST["group_id"];

    $conn = getConnection();
    if (!$conn) die("Connection failed.");

    try {
        $stmt = $conn->prepare("INSERT INTO students (fullname, matricule, group_id) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $matricule, $group_id]);

        echo "Student added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="POST">
  Full Name: <input name="fullname"><br>
  Matricule: <input name="matricule"><br>
  Group ID: <input name="group_id"><br>
  <button type="submit">Add Student</button>
</form>
