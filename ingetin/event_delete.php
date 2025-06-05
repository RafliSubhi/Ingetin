<?php
require_once 'config/database.php';
require_once 'function/event.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $deleted = deleteEvent($id);

    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $deleted]);
        exit;
    }

    $_SESSION['pesan'] = $deleted ? 'Event berhasil dihapus.' : 'Gagal menghapus event.';
    header('Location: event_list.php');
    exit;
}

// fallback GET (misal masih ada link lama pakai ?id=)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $deleted = deleteEvent($id);
    $_SESSION['pesan'] = $deleted ? 'Event berhasil dihapus.' : 'Gagal menghapus event.';
    header('Location: event_list.php');
    exit;
}
