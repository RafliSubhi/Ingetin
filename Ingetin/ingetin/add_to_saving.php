<?php
session_start();
require_once 'config/database.php';
require_once 'function/savings.php';

// Validasi request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['pesan'] = ['type' => 'danger', 'text' => 'Metode request tidak valid'];
    header('Location: savings.php');
    exit;
}

// Validasi input
if (!isset($_POST['id']) || !isset($_POST['amount'])) {
    $_SESSION['pesan'] = ['type' => 'danger', 'text' => 'Data yang dikirim tidak lengkap'];
    header('Location: savings.php');
    exit;
}

$id = intval($_POST['id']);
$amount = floatval(str_replace(',', '', $_POST['amount'])); // Handle input dengan format angka

// Validasi jumlah
if ($amount <= 0) {
    $_SESSION['pesan'] = ['type' => 'danger', 'text' => 'Jumlah harus lebih besar dari 0'];
    header("Location: savings.php");
    exit;
}

// Dapatkan data tabungan saat ini untuk validasi
$saving = getSavingById($id);
if (!$saving) {
    $_SESSION['pesan'] = ['type' => 'danger', 'text' => 'Tabungan tidak ditemukan'];
    header('Location: savings.php');
    exit;
}

// Tambahkan ke tabungan
if (addToSaving($id, $amount)) {
    // Periksa apakah sudah mencapai target setelah penambahan
    $updated_saving = getSavingById($id);
    $new_status = ($updated_saving['current_amount'] >= $updated_saving['target_amount']) ? 'completed' : 'in_progress';
    
    // Update status jika diperlukan
    if ($updated_saving['status'] !== $new_status) {
        updateSaving($id, [
            'purpose' => $updated_saving['purpose'],
            'target_amount' => $updated_saving['target_amount'],
            'current_amount' => $updated_saving['current_amount'],
            'target_date' => $updated_saving['target_date'],
            'status' => $new_status
        ]);
    }
    
    // Format pesan sukses
    $formatted_amount = 'Rp ' . number_format($amount, 0, ',', '.');
    $formatted_current = 'Rp ' . number_format($updated_saving['current_amount'], 0, ',', '.');
    $formatted_target = 'Rp ' . number_format($updated_saving['target_amount'], 0, ',', '.');
    
    $_SESSION['pesan'] = [
        'type' => 'success', 
        'text' => "Berhasil menambahkan $formatted_amount ke tabungan '" . htmlspecialchars($updated_saving['purpose']) . "'",
        'details' => "Total terkumpul: $formatted_current dari target $formatted_target"
    ];
} else {
    $_SESSION['pesan'] = ['type' => 'danger', 'text' => 'Gagal menambahkan ke tabungan'];
}

header('Location: savings.php');
exit;
?>