<?php
session_start();
require_once 'function/savings.php';

if (!isset($_GET['id'])) {
    $_SESSION['pesan'] = 'Saving ID tidak valid!';
    header('Location: savings.php');
    exit;
}

if (deleteSaving($_GET['id'])) {
    $_SESSION['pesan'] = 'Tabungan berhasil dihapus!';
} else {
    $_SESSION['pesan'] = 'Gagal menghapus tabungan!';
}

header('Location: savings.php');
exit;
?>