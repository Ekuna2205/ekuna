<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Project ID not found.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: projects.php");
    exit;
} else {
    echo "Delete failed.";
}
?>