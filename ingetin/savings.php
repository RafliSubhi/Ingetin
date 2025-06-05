<?php
require_once 'includes/header.php';
require_once 'function/savings.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$savings = getAllSavingsWithStatusUpdate();
?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<style>
    :root {
        --primary-color: #18327e;
        --primary-light: rgba(24, 50, 126, 0.1);
        --success-color: #189a46;
        --warning-color: #b38400;
        --danger-color: #b92e1e;
    }
    
    * {
        box-sizing: border-box;
    }
    
    body {
        background-color: #f8f9fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        padding-bottom: 80px; /* Space for floating button */
    }
    
    .container {
        padding: 0 15px;
        max-width: 100%;
    }
    
    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 0 10px;
    }
    
    .page-title {
        color: #343a40;
        font-weight: 600;
        font-size: 1.4rem;
        margin: 0;
    }
    h4 {
    color: var(--primary-color);
    font-weight: 600;
    margin: 15px 0;
    font-size: 1.3rem;
  }
    
    /* Savings Cards */
    .savings-card {
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 15px;
        border: none;
        overflow: hidden;
        transition: all 0.2s;
    }
    
    .savings-card:active {
        transform: scale(0.98);
    }
    
    .savings-card-body {
        padding: 16px;
    }
    
    .savings-purpose {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: #333;
    }
    
    .savings-progress {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin: 12px 0;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        background-color: var(--primary-color);
        border-radius: 4px;
        transition: width 0.6s ease;
    }
    
    .savings-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .savings-amount {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .savings-target {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .savings-date {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .savings-date i {
        margin-right: 6px;
    }
    
    /* Status Badge */
    .status-badge {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 12px;
        font-weight: 500;
        display: inline-block;
        margin-bottom: 10px;
    }
    
    .status-completed {
        background-color: rgba(24, 154, 70, 0.15);
        color: var(--success-color);
    }
    
    .status-in_progress {
        background-color: rgba(255, 193, 7, 0.15);
        color: var(--warning-color);
    }
    
    .status-pending {
        background-color: rgba(231, 74, 59, 0.15);
        color: var(--danger-color);
    }
    
    /* Action Buttons */
    .savings-actions {
        display: flex;
        gap: 10px;
    }
    
    .action-btn {
        flex: 1;
        padding: 8px 0;
        border-radius: 8px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
    }
    
    .action-btn i {
        font-size: 0.9rem;
    }
    
    .btn-add {
        background-color: rgba(24, 154, 70, 0.15);
        color: var(--success-color);
    }
    
    .btn-delete {
        background-color: rgba(231, 74, 59, 0.15);
        color: var(--danger-color);
    }
    
    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        border: none;
        font-size: 24px;
        transition: all 0.3s;
    }
    
    .fab:hover {
        background-color: #142b6b;
        transform: scale(1.1);
    }
    
    /* Modal */
    .modal-content {
        border-radius: 12px;
        border: none;
    }
    
    .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }
    
    /* Currency Format */
    .currency {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }
    
    /* Responsive Adjustments */
    @media (min-width: 768px) {
        .container {
            max-width: 750px;
            margin: 0 auto;
        }
        
        .savings-actions {
            justify-content: flex-end;
        }
        
        .action-btn {
            flex: 0 0 auto;
            padding: 8px 12px;
        }
    }
</style>


<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Tabungan</h4>
        <!-- Mobile-friendly Add Button that shows on smaller screens -->
        <a href="add_savings.php" class="btn btn-primary btn-add-mobile d-md-none">
            <i class="fas fa-plus"></i>
        </a>
        <!-- Regular Add Button that shows on larger screens -->
        <a href="add_savings.php" class="btn btn-primary d-none d-md-inline-flex align-items-center">
            <i class="fas fa-plus me-2"></i>
            <span>Tambah Tabungan</span>
        </a>
    </div>
  
    <?php if (empty($savings)): ?>
        <div class="empty-state">
            <i class="fas fa-piggy-bank"></i>
            <h5>Belum ada tabungan</h5>
            <p>Mulai menabung dengan menekan tombol + di bawah</p>
        </div>
    <?php else: ?>
        <?php foreach ($savings as $saving): 
            $progress = ($saving['current_amount'] / $saving['target_amount']) * 100;
            $progress = min($progress, 100);
        ?>
        <div class="savings-card">
            <div class="savings-card-body">
                <span class="status-badge status-<?= $saving['status'] ?>">
                    <?= ucfirst(str_replace('_', ' ', $saving['status'])) ?>
                </span>
                
                <h3 class="savings-purpose"><?= htmlspecialchars($saving['purpose']) ?></h3>
                
                <div class="savings-progress">
                    <div class="progress-bar" style="width: <?= $progress ?>%"></div>
                </div>
                
                <div class="savings-details">
                    <div>
                        <div class="savings-amount currency">Rp <?= number_format($saving['current_amount'], 0, ',', '.') ?></div>
                        <div class="savings-target">dari Rp <?= number_format($saving['target_amount'], 0, ',', '.') ?></div>
                    </div>
                    <div class="text-end">
                        <div class="savings-percentage"><?= round($progress) ?>%</div>
                    </div>
                </div>
                
                <div class="savings-date">
                    <i class="far fa-calendar-alt"></i>
                    Target: <?= date('d M Y', strtotime($saving['target_date'])) ?>
                </div>
                
                <div class="savings-actions">
                    <button class="action-btn btn-add" data-bs-toggle="modal" data-bs-target="#addMoneyModal<?= $saving['id'] ?>">
                        <i class="fas fa-money-bill-wave"></i>
                        <span class="d-none d-md-inline">Tambah</span>
                    </button>
                    <a href="delete_saving.php?id=<?= $saving['id'] ?>" class="action-btn btn-delete">
                        <i class="fas fa-trash"></i>
                        <span class="d-none d-md-inline">Hapus</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Modal for each savings item -->
        <div class="modal fade" id="addMoneyModal<?= $saving['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah ke Tabungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="add_to_saving.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $saving['id'] ?>">
                            <div class="mb-3">  
                                <label class="form-label">Jumlah (Rp)</label>
                                <input type="number" class="form-control" name="amount" required min="1000" step="1000">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Floating Action Button -->

<?php require_once 'includes/footer.php'; ?>