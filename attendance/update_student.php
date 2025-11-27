<?php
require_once "db_connect.php";

$pdo = getConnection();
if (!$pdo) die("Connection failed.");

if (!isset($_GET['id'])) die("Student ID missing.");
$id = (int)$_GET['id'];

// Fetch old data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) die("Student not found.");

// Handle form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $matricule = trim($_POST['matricule']);
    $group_id = trim($_POST['group_id']);

    if (empty($fullname) || empty($matricule) || empty($group_id)) {
        die("All fields required.");
    }

    $stmt = $pdo->prepare("UPDATE students SET fullname=?, matricule=?, group_id=? WHERE id=?");
    $stmt->execute([$fullname, $matricule, $group_id, $id]);

    echo "Student updated successfully!";
    exit();
}
?>

<form method="POST">
    Full Name: <input type="text" name="fullname" value="<?php echo $student['fullname']; ?>"><br>
    Matricule: <input type="text" name="matricule" value="<?php echo $student['matricule']; ?>"><br>
    Group ID: <input type="text" name="group_id" value="<?php echo $student['group_id']; ?>"><br>
    <button type="submit">Update</button>
</form>
