<?php
// Pastikan tidak ada spasi atau baris kosong sebelum <?php
session_start();
require_once 'koneksi.php';

// Jangan hancurkan sesi di sini jika POST login ada, 
// agar proses pengecekan login bisa berjalan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login_status'] = true;
            $_SESSION['role'] = $row['role'];
            
            // Redirect sesuai role
            if ($_SESSION['role'] == 'super_admin') {
                header("Location: header.php");
            } else {
                header("Location: absensi_kelas.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
} else {
    // Jika tidak sedang login, baru bersihkan sesi agar selalu login ulang
    session_unset();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SantriQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
        }
        .btn-login {
            background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 71, 58, 0.4);
            background: linear-gradient(135deg, #b82333 0%, #dc3545 100%);
            color: white;
        }
        .form-floating > label {
            padding-left: 1rem;
            color: #6c757d;
        }
        .form-control {
            border-radius: 12px;
            padding-left: 1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(239, 71, 58, 0.25);
            border-color: #ef473a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card glass-card p-4 p-md-5 mt-4">
                    <div class="card-body p-0">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-circle bg-danger bg-opacity-10 mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-building-fill text-danger fs-1"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">Sistem SantriQ</h3>
                            <p class="text-muted small">Selamat datang, silakan masuk ke akun Anda</p>
                        </div>
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 text-start small" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingUsername" placeholder="Username" required>
                                <label for="floatingUsername"><i class="bi bi-person me-2"></i>Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword"><i class="bi bi-lock me-2"></i>Password</label>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100 btn-login text-white mt-2">
                                Masuk <i class="bi bi-box-arrow-in-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>