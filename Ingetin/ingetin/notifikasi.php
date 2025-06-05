<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: auth/login.php');
    exit;
}

require_once 'config/database.php';

$username = $_SESSION['username'];

// ✅ Cek jika ada permintaan untuk tandai sudah dibaca
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_notifikasi'])) {
        // Update status baca 1 notifikasi
        $notif_id = $_POST['id_notifikasi'];
        $updateQuery = "UPDATE notifikasi SET status_baca = 'sudah' WHERE id = ? AND username = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("is", $notif_id, $username);
        $updateStmt->execute();
    } elseif (isset($_POST['hapus_semua'])) {
        // Hapus semua notifikasi user
        $deleteQuery = "DELETE FROM notifikasi WHERE username = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("s", $username);
        $deleteStmt->execute();
    }
    header("Location: notifikasi.php"); // Redirect agar tidak mengulang POST
    exit;
}

// Ambil semua notifikasi user
$query = "SELECT * FROM notifikasi WHERE username = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$notifikasi = [];
while ($row = $result->fetch_assoc()) {
    $notifikasi[] = $row;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
  <h4>Notifikasi</h4>

  <?php if (count($notifikasi) > 0): ?>
    <form method="post" class="mb-3">
      <button type="submit" name="hapus_semua" class="btn btn-danger btn-sm">Hapus Semua Notifikasi</button>
    </form>

    <ul class="list-group">
      <?php foreach ($notifikasi as $n): ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div>
            <div><strong><?= htmlspecialchars($n['pesan']) ?></strong></div>
            <small class="text-muted"><?= $n['created_at'] ?></small>
          </div>
          <?php if ($n['status_baca'] === 'belum'): ?>
            <form method="post" action="notifikasi.php">
              <input type="hidden" name="id_notifikasi" value="<?= $n['id'] ?>">
              <button class="btn btn-sm btn-outline-success">✔️</button>
            </form>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">Belum ada notifikasi.</p>
  <?php endif; ?>
</div>
</body>
</html>
<?php require_once 'includes/footer.php'; ?>
