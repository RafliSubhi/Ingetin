<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pilih Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-blue: rgb(24, 70, 154);
            --white: #ffffff;
        }

        body {
            background-color: var(--white);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-blue);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        h2 {
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            letter-spacing: 1px;
        }

        .card-custom {
            background-color: var(--white);
            border: 2px solid var(--primary-blue);
            border-radius: 15px;
            box-shadow: 0 3px 6px rgba(24, 70, 154, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            padding: 2rem 1rem;
            text-align: center;
            color: var(--primary-blue);
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(24, 70, 154, 0.25);
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .card-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .card-custom:hover .card-icon {
            color: var(--white);
        }

        .card-title {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .card-custom:hover .card-text {
            opacity: 1;
        }

        a.text-decoration-none {
            text-decoration: none !important;
        }

        /* Container agar konten tidak tertutup header/footer */
        main.container {
            flex-grow: 1;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    </style>
</head>


<body>
    <main class="container">
        <h2>Pilih Kategori</h2>

        <div class="row g-4 justify-content-center">

            <!-- Tugas -->
            <div class="col-12 col-md-4">
                <a href="add_task.php" class="text-decoration-none">
                    <div class="card-custom">
                        <i class="fas fa-tasks card-icon"></i>
                        <h5 class="card-title">Tugas</h5>
                        <p class="card-text">Kelola daftar tugas harianmu.</p>
                    </div>
                </a>
            </div>

            <!-- Acara -->
            <div class="col-12 col-md-4">
                <a href="event.php" class="text-decoration-none">
                    <div class="card-custom">
                        <i class="fas fa-calendar-alt card-icon"></i>
                        <h5 class="card-title">Acara</h5>
                        <p class="card-text">Lihat dan catat acara pentingmu.</p>
                    </div>
                </a>
            </div>

            <!-- Tabungan -->
            <div class="col-12 col-md-4">
                <a href="add_savings.php" class="text-decoration-none">
                    <div class="card-custom">
                        <i class="fas fa-piggy-bank card-icon"></i>
                        <h5 class="card-title">Tabungan</h5>
                        <p class="card-text">Kelola uang tabunganmu dengan mudah.</p>
                    </div>
                </a>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
