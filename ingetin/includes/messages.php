<?php if (isset($_SESSION['pesan'])): ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto">Inget!</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php 
            if (is_array($_SESSION['pesan'])) {
                foreach ($_SESSION['pesan'] as $msg) {
                    echo htmlspecialchars($msg) . "<br>";
                }
            } else {
                echo htmlspecialchars($_SESSION['pesan']);
            }
            ?>
        </div>
    </div>
</div>
<?php unset($_SESSION['pesan']); endif; ?>
