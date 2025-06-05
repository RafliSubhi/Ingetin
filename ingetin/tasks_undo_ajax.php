<script>
$(document).ready(function(){
  // Undo
  $(document).on('click', '.undo-task-btn', function() {
    const taskId = $(this).data('id');
    const button = $(this);

    $.post('undo_task.php', { id: taskId }, function(res) {
      if (res.success) {
        button.replaceWith(`
          <button class="task-btn btn btn-success complete-task-btn" data-id="${taskId}">
            <i class="fas fa-check"></i>
            <span class="d-none d-md-inline">Selesai</span>
          </button>
        `);
      }
    }, 'json');
  });

  // Selesai
  $(document).on('click', '.complete-task-btn', function() {
    const taskId = $(this).data('id');
    const button = $(this);

    $.post('complete_task.php', { id: taskId }, function(res) {
      if (res.success) {
        button.replaceWith(`
          <button class="task-btn btn btn-info undo-task-btn" data-id="${taskId}">
            <i class="fas fa-undo"></i>
            <span class="d-none d-md-inline">Undo</span>
          </button>
        `);
      }
    }, 'json');
  });
});
</script>
