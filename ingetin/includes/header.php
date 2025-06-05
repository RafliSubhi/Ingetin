<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

$username = $_SESSION['username'] ?? null;
$jumlah_notif = 0;

if ($username) {
    $notif_q = $conn->prepare("SELECT COUNT(*) as jumlah FROM notifikasi WHERE username = ? AND status_baca = 'belum'");
    $notif_q->bind_param("s", $username);
    $notif_q->execute();
    $result = $notif_q->get_result();
    $jumlah_notif = $result->fetch_assoc()['jumlah'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inget! - Aplikasi To-Do List & Menabung</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #7b2cbf;
      --primary-light: #9d4edd;
      --primary-dark: rgb(24, 70, 154);
      --white: #ffffff;
      --light-gray: rgb(4, 79, 154);
      --dark-gray: #343a40;
      --text-dark: #212529;
      --text-light: #6c757d;
      --transition: all 0.2s ease;
    }

    body {
      background-color: var(--white);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      line-height: 1.6;
      padding-bottom: 80px;
    }

    .navbar {
      background-color: var(--white);
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      padding: 0.8rem 1rem;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      color: var(--primary-dark);
      transition: var(--transition);
    }

    .navbar-brand:hover {
      color: var(--primary-color);
    }

    .navbar-brand i {
      margin-right: 0.5rem;
      font-size: 1.4rem;
    }

    .nav-icons {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .notification-badge {
      position: relative;
      color: var(--text-dark);
      font-size: 1.1rem;
      cursor: pointer;
      transition: var(--transition);
      padding: 0.5rem;
    }

    .notification-badge:hover {
      color: var(--primary-color);
    }

    .badge-count {
      position: absolute;
      top: 2px;
      right: 2px;
      background-color: var(--primary-color);
      color: var(--white);
      border-radius: 50%;
      width: 16px;
      height: 16px;
      font-size: 0.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 500;
    }

    .menu-toggle {
      color: var(--text-dark);
      font-size: 1.1rem;
      cursor: pointer;
      transition: var(--transition);
      padding: 0.5rem;
    }

    .menu-toggle:hover {
      color: var(--primary-color);
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      border-radius: 8px;
      padding: 0.5rem 0;
      margin-top: 0.5rem;
    }

    .dropdown-item {
      padding: 0.5rem 1.2rem;
      font-size: 0.9rem;
      font-weight: 400;
      color: var(--text-dark);
      transition: var(--transition);
    }

    .dropdown-item:hover {
      background-color: var(--light-gray);
      color: var(--primary-color);
    }

    .dropdown-item i {
      margin-right: 0.7rem;
      width: 18px;
      text-align: center;
      color: var(--primary-color);
    }

    .dropdown-item.active,
    .dropdown-item:active {
      background-color: var(--primary-light);
      color: var(--white);
    }

    .dropdown-item.active i,
    .dropdown-item:active i {
      color: var(--white);
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 0.8rem;
      }

      .navbar-brand {
        font-size: 1.3rem;
      }

      .nav-icons {
        gap: 0.8rem;
      }

      .notification-badge,
      .menu-toggle {
        font-size: 1rem;
        padding: 0.4rem;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
     <a class="navbar-brand d-flex align-items-center" href="index.php" style="font-weight: bold; font-size: 18px;">
  <img src="/assets/img/notif-icon.png" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;">
  <span>Inget!n</span>
</a>


      <div class="nav-icons ms-auto">
        <!-- Notification Icon -->
        <div class="notification-badge dropdown">
          <a href="notifikasi.php">
            <i class="fas fa-bell"></i>
            <?php if ($jumlah_notif > 0): ?>
              <span class="badge-count"><?= $jumlah_notif ?></span>
            <?php endif; ?>
          </a>
        </div>

        <!-- Profile icon -->
        <a href="profile.php" class="nav-item text-center text-decoration-none px-3 py-2 rounded-pill hover-scale">
          <i class="fas fa-user"></i>
        </a>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
