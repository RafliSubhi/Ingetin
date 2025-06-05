<?php
ob_start();
session_start();
require_once 'includes/header.php';
require_once 'function/tasks.php';

date_default_timezone_set('Asia/Jakarta');
$default_date = date('Y-m-d');
?>

<style>
/* CSS sama seperti sebelumnya... (tidak diubah untuk ringkas) */
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 animated-form">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Tugas Baru</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mb-4"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" id="taskForm" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="title" class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required
                                   placeholder="Masukkan judul tugas">
                            <div class="invalid-feedback">Judul tugas harus diisi</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                      placeholder="Tambahkan deskripsi tugas (opsional)"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="deadline" name="deadline" 
                                       value="<?= htmlspecialchars($_POST['deadline'] ?? $default_date) ?>" required
                                       min="<?= $default_date ?>">
                                <div class="invalid-feedback">Harap pilih tanggal deadline yang valid</div>
                            </div>

                            <input type="hidden" name="status" value="not_started">
                            <input type="hidden" id="username" name="username" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="tasks.php" class="btn btn-success">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i> Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Validasi Client-side -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('taskForm');
    const deadlineField = document.getElementById('deadline');
    const today = new Date().toISOString().split('T')[0];

    if (!deadlineField.value) {
        deadlineField.value = today;
    }
    deadlineField.min = today;

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $deadline = $_POST['deadline'] ?? '';
    $status = $_POST['status'] ?? '';
    $username = $_SESSION['username'] ?? '';

    if (!$username) {
        die("User belum login.");
    }

    if ($title === '' || $deadline === '' || $status === '') {
        $error = "Semua field yang wajib harus diisi!";
    } elseif ($deadline < date('Y-m-d')) {
        $error = "Tanggal deadline tidak boleh di masa lalu!";
    } else {
        $conn = new mysqli("sql302.infinityfree.com", "if0_39155967", "ingetin1234", "if0_39155967_inget_app");
        if ($conn->connect_error) {
            $error = "Gagal koneksi DB: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("INSERT INTO tasks (username, title, description, deadline, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $title, $description, $deadline, $status);

            if ($stmt->execute()) {
                header("Location: tasks.php");
                exit;
            } else {
                $error = "Gagal menyimpan tugas: " . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        }
    }
}

require_once 'includes/footer.php';
ob_end_flush();
?>
