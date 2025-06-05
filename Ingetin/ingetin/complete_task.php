<?php
require 'config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    // Kalau akses bukan via POST (misalnya langsung buka via link), redirect
    header('Location: tasks.php');
    exit;
}
