<?php
ob_start();
session_start();
require_once 'function/savings.php';
require_once 'includes/header.php';
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['purpose'])) {
        $username = $_SESSION['username'] ?? '';

        if ($username == '') {
            $error = 'Anda harus login untuk menambah tabungan.';
        } else {
            $savingData = $_POST;
            $savingData['username'] = $username;

            // Validasi server-side
            $targetAmount = floatval($_POST['target_amount']);
            $currentAmount = floatval($_POST['current_amount']);
            $targetDate = $_POST['target_date'];
            $today = date('Y-m-d');

            if ($targetDate < $today) {
                $error = 'Tanggal target tidak boleh di masa lalu.';
            } elseif ($targetAmount <= 0) {
                $error = 'Target jumlah harus lebih dari 0.';
            } elseif ($currentAmount < 0) {
                $error = 'Jumlah saat ini tidak boleh negatif.';
            } elseif ($currentAmount > $targetAmount) {
                $error = 'Jumlah saat ini tidak boleh melebihi target.';
            } else {
                $savingData['status'] = $currentAmount > 0 ? 'in_progress' : 'not_started';

                if (addSaving($savingData)) {
                    $pesan = 'Tabungan baru telah dibuat.';
                    $status_baca = 'belum';
                    $created_at = date('Y-m-d H:i:s');

                    mysqli_query($conn, "INSERT INTO notifikasi (pesan, created_at, status_baca, username) 
                                         VALUES ('$pesan', '$created_at', '$status_baca', '$username')");

                    $_SESSION['pesan'] = 'Tabungan berhasil ditambahkan!';
                    header('Location: savings.php');
                    exit;
                } else {
                    $error = 'Gagal menambahkan tabungan';
                }
            }
        }
    }

    if (isset($_POST['add_amount'], $_POST['id'])) {
        global $conn;
        $id = intval($_POST['id']);
        $amount = floatval($_POST['add_amount']);

        mysqli_query($conn, "UPDATE savings SET current_amount = current_amount + $amount WHERE id = $id");

        $result = mysqli_query($conn, "SELECT current_amount, target_amount FROM savings WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        $username = $_SESSION['username'];
        $created_at = date('Y-m-d H:i:s');

        if ($row['current_amount'] >= $row['target_amount']) {
            mysqli_query($conn, "UPDATE savings SET status = 'completed' WHERE id = $id");
            $pesan = 'Selamat! Tabungan kamu telah mencapai target.';
        } else {
            $pesan = 'tabungan berhasil ditambahkan.';
        }

        mysqli_query($conn, "INSERT INTO notifikasi (pesan, created_at, status_baca, username) 
                             VALUES ('$pesan', '$created_at', 'belum_dibaca', '$username')");

        $_SESSION['pesan'] = 'Tabungan berhasil ditambahkan!';
        header('Location: savings.php');
        exit;
    }
}

?>

<!-- HTML + Form -->
<div class="card shadow">
    <!-- Modal Validasi -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Validasi Gagal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalErrorContent">
        <!-- Isi pesan error akan diisi dari JavaScript -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-piggy-bank me-2"></i>Tambah Tabungan Baru</h4>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" id="savingForm">
            <div class="mb-3">
                <label for="purpose" class="form-label">Tujuan Menabung</label>
                <input type="text" class="form-control" id="purpose" name="purpose" required placeholder="Misal: Liburan ke Bali">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="target_amount" class="form-label">Target Jumlah</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="target_amount" name="target_amount" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="current_amount" class="form-label">Jumlah Saat Ini</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" id="current_amount" name="current_amount" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="target_date" class="form-label">Target Tanggal</label>
                    <input type="date" class="form-control" id="target_date" name="target_date" required min="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <input type="hidden" name="status" value="auto">
            <input type="hidden" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>">

            <div class="d-flex justify-content-end mt-4">
                <a href="savings.php" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Validasi JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const targetDateInput = document.getElementById('target_date');
    const today = new Date().toISOString().split('T')[0];
    targetDateInput.setAttribute('min', today);
});

document.getElementById('savingForm').addEventListener('submit', function(e) {
    const targetAmount = parseFloat(document.getElementById('target_amount').value);
    const currentAmount = parseFloat(document.getElementById('current_amount').value);
    const targetDate = new Date(document.getElementById('target_date').value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let errors = [];

    if (targetDate < today) {
        errors.push("📅 Tanggal target tidak boleh di masa lalu.");
    }
    if (isNaN(targetAmount) || targetAmount <= 0) {
        errors.push("💰 Target jumlah harus lebih dari 0.");
    }
    if (isNaN(currentAmount) || currentAmount < 0) {
        errors.push("💸 Jumlah saat ini tidak boleh negatif.");
    }
    if (currentAmount > targetAmount) {
        errors.push("⚠️ Jumlah saat ini tidak boleh melebihi target.");
    }

    if (errors.length > 0) {
        e.preventDefault();
        const modalBody = document.getElementById('modalErrorContent');
        modalBody.innerHTML = errors.map(error => `<div>${error}</div>`).join('');
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    }
});
</script>


<?php require_once 'includes/footer.php'; ob_end_flush(); ?>
