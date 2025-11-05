<?php
include '../includes/db.php';
$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: manage_books.php");
?>
