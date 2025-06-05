<?php
require_once 'config/database.php';
require_once 'function/event.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$events = getAllEvent();
require_once 'includes/header.php';
?>


<?php if (isset($_SESSION['pesan'])): ?>
  <div class="alert alert-info"><?= $_SESSION['pesan'] ?></div>
  <?php unset($_SESSION['pesan']); ?>
<?php endif; 
?>

<div class="container my-4">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h4 class="mb-2 text-primary">Daftar Event Harian</h4>
    <div class="d-flex gap-2">
      <a href="event_form.php" class="btn btn-sm btn-primary">+ Tambah Event</a>
      <a href="event_reset.php" class="btn btn-sm btn-danger">Reset Event</a>
    </div>
  </div>

  <!-- TAMPILAN DESKTOP -->
  <div class="table-responsive d-none d-md-block">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light text-center">
        <tr>
          <th style="width: 10%;">Jam</th>
          <th style="width: 20%;">Judul</th>
          <th>Deskripsi</th>
          <th style="width: 10%;">Status</th>
          <th style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($events) > 0): ?>
          <?php foreach ($events as $e): ?>
            <tr>
              <td class="text-center"><?= htmlspecialchars($e['event_time']) ?></td>
              <td><?= htmlspecialchars($e['title']) ?></td>
              <td><?= htmlspecialchars($e['description']) ?></td>
              <td class="text-center">
                <span class="badge bg-<?= $e['status'] === 'selesai' ? 'success' : 'secondary' ?>">
                  <?= ucfirst(htmlspecialchars($e['status'])) ?>
                </span>
              </td>
              <td class="text-center">
                <?php if ($e['status'] !== 'selesai'): ?>
                  <button class="btn btn-success btn-sm me-1 btn-status" data-id="<?= $e['id'] ?>" title="Tandai Selesai">&#10003;</button>
                <?php else: ?>
                  <button class="btn btn-warning btn-sm me-1 btn-undo" data-id="<?= $e['id'] ?>" title="Batalkan Selesai">Undo</button>
                <?php endif; ?>
                <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $e['id'] ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted">Belum ada event harian</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- TAMPILAN MOBILE -->
  <div class="d-md-none">
    <?php if (count($events) > 0): ?>
      <?php foreach ($events as $e): ?>
        <div class="card mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-1"><?= htmlspecialchars($e['title']) ?></h5>
            <p class="text-muted mb-1"><i class="fas fa-clock me-1"></i> <?= htmlspecialchars($e['event_time']) ?></p>
            <p class="mb-2"><?= nl2br(htmlspecialchars($e['description'])) ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge bg-<?= $e['status'] === 'selesai' ? 'success' : 'secondary' ?>">
                <?= ucfirst(htmlspecialchars($e['status'])) ?>
              </span>
              <div class="d-flex gap-2">
                <?php if ($e['status'] === 'selesai'): ?>
                  <button class="btn btn-warning btn-sm btn-undo" data-id="<?= $e['id'] ?>">
                    <i class="fas fa-undo"></i>
                  </button>
                <?php else: ?>
                  <button class="btn btn-success btn-sm btn-status" data-id="<?= $e['id'] ?>" title="Tandai Selesai">
                    &#10003;
                  </button>
                <?php endif; ?>
                <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $e['id'] ?>">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-muted text-center">Belum ada event harian.</div>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $('.btn-status').click(function() {
    const id = $(this).data('id');
    $.post('event_status_ajax.php', { id: id, status: 'selesai' }, function(response) {
      if (response.success) {
        location.reload();
      } else {
        alert('Gagal mengubah status: ' + (response.error || 'Unknown error'));
      }
    }, 'json');
  });

  $('.btn-undo').click(function() {
    const id = $(this).data('id');
    $.post('event_status_ajax.php', { id: id, status: 'belum' }, function(response) {
      if (response.success) {
        location.reload();
      } else {
        alert('Gagal mengubah status: ' + (response.error || 'Unknown error'));
      }
    }, 'json');
  });

  $('.btn-delete').click(function() {
    const id = $(this).data('id');
    $.post('event_delete.php', { id: id, ajax: true }, function(response) {
      if (response.success) {
        location.reload();
      } else {
        alert('Gagal menghapus event: ' + (response.error || 'Unknown error'));
      }
    }, 'json');
  });
});
</script>
