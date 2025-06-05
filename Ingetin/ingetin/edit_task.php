<?php
require_once 'function/tasks.php';

if (!isset($_GET['id'])) {
    header('Location: tasks.php');
    exit;
}

$id = $_GET['id'];
$task = getTaskById($id);

if (!$task) {
    header('Location: tasks.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (updateTask($id, $_POST)) {
        $_SESSION['pesan'] = 'Tugas berhasil diperbarui!';
        header('Location: tasks.php');
        exit;
    } else {
        $error = 'Gagal memperbarui tugas';
    }
}
require_once 'includes/header.php';
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Edit Tugas</h4>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Tugas</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" value="<?= $task['deadline'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="not_started" <?= $task['status'] == 'not_started' ? 'selected' : '' ?>>Belum Dimulai</option>
                    <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                    <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="tasks.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>