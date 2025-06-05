<nav class="navbar fixed-bottom navbar-light">
  <div class="container-fluid justify-content-around px-0">
    
    <!-- Home Button -->
    <a href="index.php" class="nav-item text-center text-decoration-none px-2 py-1 hover-scale <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
      <div class="icon-wrapper">
        <i class="fas fa-home fa-lg d-block mb-1"></i>
        <span class="small d-none d-sm-inline">Beranda</span>
        <div class="active-indicator"></div>
      </div>
    </a>

    <!-- Tasks Button -->
    <a href="tasks.php" class="nav-item text-center text-decoration-none px-2 py-1 hover-scale <?= (basename($_SERVER['PHP_SELF']) == 'tasks.php') ? 'active' : '' ?>">
      <div class="icon-wrapper">
        <i class="fas fa-tasks fa-lg d-block mb-1"></i>
        <span class="small d-none d-sm-inline">Tugas</span>
        <div class="active-indicator"></div>
      </div>
    </a>

    <!-- Floating Add Button -->
    <div class="nav-item position-relative" style="margin-top: -35px;">
      <a href="pilihan.php" class="btn btn-light rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
        <i class="fas fa-plus fs-5 text-navy" style="line-height: 1;"></i>
      </a>
    </div>

    <!-- Savings Button -->
    <a href="savings.php" class="nav-item text-center text-decoration-none px-2 py-1 hover-scale <?= (basename($_SERVER['PHP_SELF']) == 'savings.php') ? 'active' : '' ?>">
      <div class="icon-wrapper">
        <i class="fas fa-wallet fa-lg d-block mb-1"></i>
        <span class="small d-none d-sm-inline">Tabungan</span>
        <div class="active-indicator"></div>
      </div>
    </a>

    <!-- Profile Button -->
    <a href="event.php" class="nav-item text-center text-decoration-none px-2 py-1 hover-scale <?= (basename($_SERVER['PHP_SELF']) == 'event.php') ? 'active' : '' ?>">
      <div class="icon-wrapper">
        <i class="fas fa-calendar   -alt fa-lg d-block mb-1"></i>
        <span class="small d-none d-sm-inline">Acara</span>
        <div class="active-indicator"></div>
      </div>
    </a>
    
  </div>
</nav>

<style>
  :root {
    --primary-color: rgb(24, 70, 154);
    --transition: all 0.2s ease;
  }

  .navbar {
    background-color: white !important;
    border-top: 5px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 -1px 15px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(8px);
    padding: 1.25rem 0;
  }

  .btn-light {
    background-color: white !important;
    border: none;
    transition: var(--transition);
  }

  .text-navy {
    color: var(--primary-color);
  }

  .btn-light:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .nav-item {
    color: #212529;
    font-size: 0.85rem;
    position: relative;
    text-align: center;
    flex: 1 1 auto;
    user-select: none;
  }

  .icon-wrapper {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    white-space: nowrap;
    border-bottom-width: 1px;
  }

  .active-indicator {
    height: 3px;
    width: 20px;
    background-color: transparent;
    border-radius: 10px;
    margin-top: 4px;
    transition: all 0.3s ease;
  }

  .nav-item.active .active-indicator {
    background-color: var(--primary-color);
  }

  .nav-item i {
    transition: color 0.2s;
  }

  .nav-item:hover i {
    color: var(--primary-color);
  }

  .hover-scale {
    transition: transform 0.2s ease;
  }

  .hover-scale:hover {
    transform: translateY(-2px);
  }

  /* Floating button fix */
  .nav-item.position-relative {
    flex: 0 0 auto;
  }

  /* Responsive tweaks */
  @media (max-width: 576px) {
    .nav-item {
      font-size: 0.75rem;
      padding-top: 0.1rem !important;
      padding-bottom: 0.1rem !important;
    }
    .btn-light {
      width: 48px !important;
      height: 48px !important;
    }
    .nav-item .small {
      display: none !important;
    }
  }

  @media (min-width: 577px) {
    .nav-item .small {
      display: inline;
    }
  }
</style>
