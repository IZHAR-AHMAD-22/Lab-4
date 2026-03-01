<?php
/**
 * PHP CRUD Application
 * Author: Izhar Ahmad
 * Delete user and resequence IDs
 */
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$id = (int)$_GET['id'];

// Step 1: Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Step 2: Resequence IDs — assign new consecutive IDs
$conn->query("SET @new_id = 0");
$conn->query("UPDATE users SET id = (@new_id := @new_id + 1) ORDER BY id ASC");

// Step 3: Reset AUTO_INCREMENT to avoid gaps on next insert
$result = $conn->query("SELECT MAX(id) AS max_id FROM users");
$row = $result->fetch_assoc();
$next_id = ($row['max_id'] ?? 0) + 1;
$conn->query("ALTER TABLE users AUTO_INCREMENT = $next_id");

header("Location: users.php?deleted=1");
exit;
?>
