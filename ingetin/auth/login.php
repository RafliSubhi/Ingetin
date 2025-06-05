<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' LIMIT 1");

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: ../index.php');
            exit;
        } else {
            $error = 'Password salah.';
        }
    } else {
        $error = 'Akun tidak ditemukan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Login - Inget!n</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgb(24, 70, 154), rgb(86, 149, 255));
            padding: 10px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: white;
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            min-height: 450px;
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
        }

        .left-panel img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            margin-left: auto;
            margin-right: auto;
        }

        .left-panel h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .left-panel p {
            font-size: 14px;
            margin-top: 10px;
            line-height: 1.4;
        }

        .right-panel {
            flex: 1;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 8px;
            font-size: 14px;
            padding: 8px 12px;
        }

        .btn-primary {
            background-color: rgb(24, 70, 154);
            border: none;
            border-radius: 8px;
            font-size: 14px;
            padding: 10px 20px;
        }

        .btn-outline-primary {
            border-color: rgb(24, 70, 154);
            color: rgb(24, 70, 154);
            border-radius: 8px;
            font-size: 14px;
            padding: 10px 20px;
        }

        .btn-outline-primary:hover {
            background-color: rgb(24, 70, 154);
            color: white;
        }

        .form-footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }

        .form-footer p {
            margin-bottom: 6px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #555;
            font-size: 12px;
        }

        .form-footer .creator-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            font-family: 'Poppins', monospace;
            font-size: 11px;
            color: #777;
        }

        .alert {
            font-size: 14px;
        }

        /* Media Query untuk mobile */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                min-height: auto;
                max-width: 100%;
                border-radius: 12px;
            }
            .left-panel, .right-panel {
                padding: 20px 15px;
                flex: none;
            }
            .left-panel h1 {
                font-size: 26px;
            }
            .left-panel p {
                font-size: 13px;
            }
            .form-control, .btn-primary, .btn-outline-primary {
                font-size: 13px;
                padding: 8px 16px;
            }
            .form-footer {
                font-size: 11px;
                margin-top: 15px;
            }
            form > .d-grid {
                flex-direction: column !important;
                gap: 10px;
            }
            form > .d-grid > * {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <img src="/assets/img/notif-icon.png" alt="Notif Icon" />
            <h1>Hello, welcome!</h1>
            <p>Selamat datang kembali di Inget!n.<br />Kelola aktivitasmu dengan lebih mudah.</p>
        </div>
        <div class="right-panel">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus />
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required />
                </div>
                <div class="mb-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <button type="submit" class="btn btn-primary px-4">Login</button>
                        <a href="register.php" class="btn btn-outline-primary px-4">Sign up</a>
                    </div>
                </div>
            </form>

            <div class="form-footer">
                <p>Dibuat oleh Tim Inget!n</p>
                <div class="creator-list">
                    <span>@aribimaprasetya</span>
                    <span>@rafly.fahreza_</span>
                    <span>@bandone</span>
                    <span>@rafli_subhi</span>
                    <span>@rafeliansyah</span>
                    <span>@nafissdua</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
