<?php
session_start();
require_once('../config/database.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $username = mysqli_real_escape_string($conn, $username);
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        
        if (mysqli_num_rows($check) > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$hashed')");
            
            if ($insert) {
                $_SESSION['pesan'] = "Registrasi berhasil, silakan login.";
                header("Location: login.php");
                exit;
            } else {
                $error = "Gagal registrasi. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Register - Inget!n</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgb(24, 70, 154), rgb(86, 149, 255));
            padding: 20px;
        }

        .register-container {
            background-color: white;
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .left-panel {
            background: rgb(24, 70, 154);
            color: white;
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            user-select: none;
        }

        .left-panel h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .left-panel p {
            font-size: 16px;
            line-height: 1.5;
        }

        .right-panel {
            flex: 1;
            padding: 40px 40px 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: rgb(24, 70, 154);
            box-shadow: 0 0 5px rgba(24, 70, 154, 0.5);
            outline: none;
        }

        .btn-primary {
            background-color: rgb(24, 70, 154);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 12px 0;
            width: 100%;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: rgb(17, 50, 111);
        }

        .alert {
            font-size: 0.95rem;
            border-radius: 12px;
        }

        .form-footer {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
            user-select: none;
        }

        .form-footer a {
            color: rgb(24, 70, 154);
            text-decoration: none;
            font-weight: 600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                max-width: 100%;
                border-radius: 12px;
            }
            .left-panel, .right-panel {
                padding: 30px 20px;
            }
            .left-panel h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="left-panel">
            <div>
                <img src="/assets/img/notif-icon.jpg" alt="Icon" style="width: 30px; height: 30px; border-radius: 50%; margin-bottom: 16px;">
                <h1>Welcome!</h1>
                <p>Buat akun baru untuk mulai mengelola aktivitasmu dengan Inget!n.</p>
            </div>
        </div>
        <div class="right-panel">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        placeholder="Username"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Password"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <div class="mb-3">
                    <label for="confirm" class="form-label">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="confirm"
                        id="confirm"
                        class="form-control"
                        placeholder="Konfirmasi Password"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>

            <div class="form-footer">
                Sudah punya akun? <a href="login.php">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
