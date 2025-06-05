<?php
require_once 'function/event.php'; // Pastikan path sesuai struktur kamu

$isEdit = isset($_GET['id']);
$event = $isEdit ? getEventById($_GET['id']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'event_time' => $_POST['event_time'],
        'status' => $_POST['status']
    ];

    if ($isEdit) {
        updateEvent($_GET['id'], $data);
    } else {
        addEvent($data);
    }

    header("Location: event.php");
    exit;
}

require_once 'includes/header.php';
?>



<div class="container my-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3 text-primary"><?= $isEdit ? 'Edit Event Harian' : 'Tambah Event Harian' ?></h4>

      <form method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Judul Event</label>
          <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Deskripsi</label>
          <textarea id="description" name="description" class="form-control" rows="3"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label for="event_time" class="form-label">Jam Event</label>
          <input type="time" id="event_time" name="event_time" class="form-control" value="<?= htmlspecialchars($event['event_time'] ?? '') ?>" required>
        </div>

 <?php if ($isEdit): ?>
  <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select">
      <option value="belum" <?= $event['status'] == 'belum' ? 'selected' : '' ?>>Belum</option>
      <option value="selesai" <?= $event['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
    </select>
  </div>
<?php else: ?>
  <input type="hidden" name="status" value="belum">
<?php endif; ?>


        <div class="d-flex justify-content-between">
          <a href="event.php" class="btn btn-secondary">← Kembali</a>
          <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Simpan' ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>