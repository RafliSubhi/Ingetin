<?php
ob_start(); // Tambahkan ini di paling atas
session_start();
require_once 'function/savings.php';
require_once 'includes/header.php';


if (!isset($_GET['id'])) {
    header('Location: savings.php');
    exit;
}

$id = $_GET['id'];
$saving = getSavingById($id);

if (!$saving) {
    header('Location: savings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (updateSaving($id, $_POST)) {
        $_SESSION['pesan'] = 'Tabungan berhasil diperbarui!';
        header('Location: savings.php');
        exit;
    } else {
        $error = 'Gagal memperbarui tabungan';
    }
}
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Edit Tabungan</h4>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="purpose" class="form-label">Tujuan Menabung</label>
                <input type="text" class="form-control" id="purpose" name="purpose" 
                       value="<?= htmlspecialchars($saving['purpose']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="target_amount" class="form-label">Target Jumlah</label>
                <input type="number" class="form-control" id="target_amount" name="target_amount" 
                       value="<?= $saving['target_amount'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="current_amount" class="form-label">Jumlah Saat Ini</label>
                <input type="number" class="form-control" id="current_amount" name="current_amount" 
                       value="<?= $saving['current_amount'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="target_date" class="form-label">Target Tanggal</label>
                <input type="date" class="form-control" id="target_date" name="target_date" 
                       value="<?= $saving['target_date'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="savings.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
