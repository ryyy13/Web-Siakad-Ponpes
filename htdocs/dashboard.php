<?php
// ==========================================
// PENGAMAN ERROR
// ==========================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

//include 'header.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SantriQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: transparent; /* Assuming this is loaded inside main-content of header.php, or independent. It doesn't include header.php currently based on the commented code */
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
        }
        .modul-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .modul-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .card-header-gradient-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
        }
        .card-header-gradient-2 {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 30px 20px;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            backdrop-filter: blur(5px);
        }
        .btn-custom-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            transition: all 0.3s;
        }
        .btn-custom-1:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            transform: scale(1.02);
        }
        .btn-custom-2 {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            border-radius: 12px;
            color: white;
            transition: all 0.3s;
        }
        .btn-custom-2:hover {
            background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
            color: white;
            transform: scale(1.02);
        }
        .page-title {
            font-weight: 800;
            color: #2d3748;
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }
        .page-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background: linear-gradient(90deg, #cb2d3e, #ef473a);
            bottom: -10px;
            left: 25%;
            border-radius: 2px;
        }
    </style>
</head>
<body class="pb-5" style="padding-top: 80px;">

    <div class="container px-4 text-center">
        
        <h2 class="page-title fs-2">Pilih Modul Sistem</h2>

        <div class="row g-4 justify-content-center mt-3">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-5">
                <div class="card modul-card h-100">
                    <div class="card-header-gradient-1 text-center">
                        <div class="icon-circle">
                            <i class="fas fa-user-plus fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Input Data Anak</h4>
                    </div>
                    <div class="card-body text-center p-4 d-flex flex-column">
                        <p class="text-muted mb-4">Tambahkan data santri baru ke dalam sistem dengan cepat dan mudah.</p>
                        <a href="input_santri.php" class="btn btn-custom-1 btn-lg fw-bold mt-auto w-100">
                            Masuk Modul <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-5">
                <div class="card modul-card h-100">
                    <div class="card-header-gradient-2 text-center">
                        <div class="icon-circle">
                            <i class="fas fa-users-cog fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-0">Kelola Data Anak</h4>
                    </div>
                    <div class="card-body text-center p-4 d-flex flex-column">
                        <p class="text-muted mb-4">Akses, edit, dan kelola informasi serta profil lengkap santri.</p>
                        <a href="kelas_1.php" class="btn btn-custom-2 btn-lg fw-bold mt-auto w-100">
                            Masuk Modul <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>