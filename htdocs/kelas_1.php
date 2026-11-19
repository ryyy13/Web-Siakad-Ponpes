<?php
session_start();
require_once 'koneksi.php';

include "header.php";
// Proteksi halaman (pastikan user sudah login)
if (!isset($_SESSION['login_status'])) {
    header("Location: index.php");
    exit;
}

// Mengambil semua data khusus dari tabel kelas1
$query = mysqli_query($conn, "SELECT * FROM kelas1 ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Santri Kelas 1 - SantriQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: transparent;
        }
        .page-header {
            background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(239, 71, 58, 0.2);
        }
        .card-santri {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .card-santri:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
        .card-santri .card-footer {
            background-color: transparent;
            border-top: 1px dashed rgba(0,0,0,0.1);
        }
        .btn-action {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
            transform: scale(1.05);
            color: white;
        }
        .icon-box {
            width: 25px;
            text-align: center;
        }
    </style>
</head>
<body class="pb-5 pt-3">

    <div class="container-fluid px-4">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-0"><i class="fas fa-users me-2"></i> Data Santri Kelas 1</h3>
                <p class="mb-0 text-white-50 small mt-1">Kelola data dan profil anak kelas 1</p>
            </div>
            <div>
                <a href="input_santri.php" class="btn btn-light rounded-pill fw-bold text-danger px-4 shadow-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Anak
                </a>
            </div>
        </div>



        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php if (mysqli_num_rows($query) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <div class="col">
                        <div class="card card-santri h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <?php 
                                    // Cek apakah ada foto_anak di database, jika tidak tampilkan inisial nama
                                    $foto = !empty($row['foto_anak']) ? 'uploads/'.$row['foto_anak'] : 'https://ui-avatars.com/api/?name='.urlencode($row['nama']).'&background=random&color=fff'; 
                                    ?>
                                    <img src="<?= $foto ?>" alt="Foto" class="rounded-circle me-3 object-fit-cover shadow-sm" style="width: 65px; height: 65px;">
                                    
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1 text-truncate" style="max-width: 180px;" title="<?= htmlspecialchars($row['nama']) ?>">
                                            <?= htmlspecialchars($row['nama']) ?>
                                        </h5>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">
                                            NIK: <?= htmlspecialchars($row['nik'] ?: '-') ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="text-muted small">
                                    <p class="mb-2"><i class="fas fa-map-marker-alt text-danger me-2 icon-box"></i> <?= htmlspecialchars($row['tempat_lahir']).', '.htmlspecialchars($row['tanggal_lahir']) ?></p>
                                    <p class="mb-2"><i class="fas fa-user-friends text-info me-2 icon-box"></i> <?= htmlspecialchars($row['nama_ayah'] ?: '-') ?> (Ayah)</p>
                                    <p class="mb-0 d-flex"><i class="fas fa-home text-secondary me-2 icon-box mt-1"></i> <span class="text-truncate d-inline-block align-bottom" style="max-width: 200px;"><?= htmlspecialchars($row['alamat_lengkap'] ?: 'Alamat belum diisi') ?></span></p>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-end gap-2">
                           <a href="detail_santri.php?id=<?= $row['id'] ?>&kelas=kelas1" class="btn btn-action btn-sm rounded-pill px-4 fw-bold">
    <i class="fas fa-user-edit me-1"></i> Kelola Profil
</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12 w-100 text-center py-5">
                    <div class="p-5 border-dashed border-2 rounded-4 text-muted">
                        <i class="fas fa-folder-open fa-4x mb-3 text-secondary opacity-50"></i>
                        <h4 class="fw-bold text-dark">Data Kosong</h4>
                        <p>Belum ada data santri yang terdaftar di Kelas 1.</p>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>