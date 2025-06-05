<?php
require_once 'includes/header.php';
require_once 'function/tasks.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$tasks = getAllTasksByUser($username);
?>



<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  $('.delete-task').click(function() {
    const taskId = $(this).data('id');
    $.post('delete_task.php', { id: taskId }, function(response) {
      if (response.success) {
        $('#task-' + taskId).fadeOut(300, function() {
          $(this).remove();
        });
      }
    }, 'json');
  });
});
</script>

<style>
.task-item {
  background-color: #fff;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  position: relative;
}

.task-title {
  font-weight: bold;
  font-size: 1.1rem;
  margin-bottom: 8px;
}

.task-description {
  color: #555;
  margin-bottom: 10px;
}

.task-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.85rem;
  color: #666;
}

.task-btn {
  border: none;
  padding: 8px 12px;
  border-radius: 8px;
  font-size: 0.85rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  cursor: pointer;
}

.btn-danger {
  background-color: #f8d7da;
  color: #842029;
}

.btn-success {
  background-color: #d1e7dd;
  color: #0f5132;
}

.btn-info {
  background-color: #cff4fc;
  color: #055160;
}

.badge {
  padding: 6px 12px;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: bold;
  display: inline-block;
  text-align: center;
}

.bg-success {
  background-color: #198754;
  color: #fff;
}

.bg-warning {
  background-color: #ffc107;
  color: #000;
}

.bg-danger {
  background-color: #dc3545;
  color: #fff;
}

</style>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Tugas</h4>
    <a href="add_task.php" class="btn btn-primary">
      <i class="fas fa-plus me-1"></i> Tambah Tugas
    </a>
  </div>

  <?php if (empty($tasks)): ?>
    <div class="alert alert-info text-center">Belum ada tugas.</div>
  <?php else: ?>
    <?php foreach ($tasks as $task): ?>
      <div class="task-item" id="task-<?= $task['id'] ?>">
        <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
        <div class="task-description"><?= htmlspecialchars($task['description']) ?></div>
        <div class="task-meta">
          <span><i class="far fa-calendar-alt me-1"></i><?= date('d M Y', strtotime($task['deadline'])) ?></span>
          <span class="badge 
            <?= $task['status'] === 'not_started' ? 'bg-danger' : 
                ($task['status'] === 'completed' ? 'bg-success' : 'bg-warning') ?>">
            <?= $task['status'] === 'not_started' ? 'Belum' : 
                ($task['status'] === 'completed' ? 'Selesai' : 'Berjalan') ?>
          </span>
        </div>
        <div class="d-flex gap-2 mt-3">
          <button class="task-btn btn-danger delete-task" data-id="<?= $task['id'] ?>">
            <i class="fas fa-trash"></i> Hapus
          </button>

          <form action="update_task_status.php" method="POST" class="d-inline">
            <input type="hidden" name="id" value="<?= $task['id'] ?>">
            <input type="hidden" name="action" value="<?= $task['status'] == 'completed' ? 'undo' : 'complete' ?>">
            <button type="submit" class="task-btn btn-<?= $task['status'] == 'completed' ? 'info' : 'success' ?>">
              <i class="fas <?= $task['status'] == 'completed' ? 'fa-undo' : 'fa-check' ?>"></i>
              <?= $task['status'] == 'completed' ? 'Undo' : 'Selesai' ?>
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
