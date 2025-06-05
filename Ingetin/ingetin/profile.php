<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: auth/login.php');
    exit;
}

// Panggil file koneksi InfinityFree
require_once 'config/database.php'; // sesuaikan path jika perlu

// Ambil username dari session
$username = mysqli_real_escape_string($conn, $_SESSION['username']);

// Query data profil
$sql = "SELECT username, email, full_name, phone FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $userProfile = mysqli_fetch_assoc($result);
} else {
    header('Location: auth/logout.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Saya - Inget!n</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      color: #212529;
      margin: 0;
    }

    main.container {
      padding-top: 1rem;
      padding-bottom: 1.5rem;
    }

    .profile-card {
      max-width: 600px;
      background: #fff;
      margin: 0 auto;
      padding: 1.8rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .profile-header {
      display: flex;
      align-items: center;
      gap: 1.2rem;
      margin-bottom: 1.2rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    .profile-icon {
      font-size: 11rem;
      color: #0d6efd;
      flex-shrink: 0;
    }

    .profile-title h2 {
      font-weight: 600;
      font-size: 1.7rem;
      margin-bottom: 0.2rem;
      color: #0d6efd;
    }

    .profile-title p {
      font-size: 0.95rem;
      color: #6c757d;
      margin: 0;
    }

    .profile-info {
      margin-top: 1rem;
    }

    .info-group {
      margin-bottom: 1rem;
      gap: 0.8rem;
      color: #495057;
    }

    .info-label {
      font-weight: 600;
      min-width: 110px;
      display: inline-block;
      color: #343a40;
      position: relative;
      padding-right: 6px;
    }

    .info-label::after {
      content: ":";
      position: absolute;
      right: 0;
      top: 0;
      color: #343a40;
    }

    .info-value {
      flex: 1;
      word-break: break-word;
    }

    .info-group i {
      color: #0d6efd;
      min-width: 20px;
      text-align: center;
    }

    .btn-outline-primary {
      border-color: #0d6efd;
      color: #0d6efd;
      transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
      background-color: #0d6efd;
      color: #fff;
      border-color: #0d6efd;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
      border-color: #dc3545;
    }

    @media (max-width: 576px) {
      .profile-card {
        margin: 0.5rem 1rem;
        padding: 1.5rem 1rem;
      }

      .profile-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .profile-title h2 {
        font-size: 1.5rem;
      }

      .info-label {
        min-width: 90px;
      }

      .d-flex.flex-sm-row {
        flex-direction: column !important;
      }

      .d-flex.flex-sm-row > a {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <section class="profile-card">
      <div class="profile-header text-center text-md-start">
        <i class="fas fa-user-circle profile-icon mb-3 mb-md-0"></i>
        <div class="profile-title">
          <h2 class="mb-1">Halo, <?= htmlspecialchars($userProfile['username']) ?> 🤪!</h2>
          <p class="text-muted mb-0">Ini adalah halaman profil kamu.</p>
        </div>
      </div>

      <hr>

      <div class="profile-info">
        <div class="info-group d-flex align-items-center">
          <i class="fas fa-user me-2"></i>
          <span class="info-label">Username</span>
          <span class="info-value"><?= htmlspecialchars($userProfile['username']) ?></span>
        </div>
        <div class="info-group d-flex align-items-center">
          <i class="fas fa-envelope me-2"></i>
          <span class="info-label">Email</span>
          <span class="info-value"><?= htmlspecialchars($userProfile['email']) ?></span>
        </div>
        <div class="info-group d-flex align-items-center">
          <i class="fas fa-id-card me-2"></i>
          <span class="info-label">Nama Lengkap</span>
          <span class="info-value"><?= htmlspecialchars($userProfile['full_name']) ?></span>
        </div>
        <div class="info-group d-flex align-items-center">
          <i class="fas fa-phone me-2"></i>
          <span class="info-label">No. Telepon</span>
          <span class="info-value"><?= htmlspecialchars($userProfile['phone']) ?></span>
        </div>
      </div>

      <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-center justify-content-md-start">
        <a href="edit_profil.php" class="btn btn-outline-primary">
          <i class="fas fa-edit me-1"></i> Edit Profil
        </a>
        <a href="auth/logout.php" class="btn btn-outline-danger">
          <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
      </div>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
