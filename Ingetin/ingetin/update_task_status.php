<?php
require 'config/database.php'; // ganti sesuai koneksi yang kamu pakai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($id && $action) {
        $new_status = ($action === 'complete') ? 'completed' : 'not_started';

        $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $id);
        $stmt->execute();
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
