<?php
session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['login_status'])) {
    header("Location: index.php");
    exit;
}

// Panggil koneksi database
require_once 'koneksi.php';

// Ambil role dari session, defaultnya staff jika kosong
$role = $_SESSION['role'] ?? 'staff'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SantriQ Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9; /* Latar yang lebih terang dan modern */
            margin: 0;
            overflow-x: hidden;
            color: #333;
        }

        /* --- DESAIN SIDEBAR FIXED MODERN --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0; 
            left: 0;
            background: linear-gradient(180deg, #cb2d3e 0%, #ef473a 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        
        .sidebar .sidebar-brand {
            padding: 25px 20px;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .sidebar .sidebar-brand i {
            font-size: 1.8rem;
            margin-right: 12px;
            background: rgba(255,255,255,0.2);
            padding: 8px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 0 25px 25px 0;
            margin-right: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link[aria-expanded="true"] {
            color: #fff;
            background-color: rgba(255,255,255,0.15);
            transform: translateX(5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .sidebar .submenu .nav-link {
            padding-left: 55px; /* Menjorok ke dalam untuk sub-menu */
            font-size: 0.9rem;
            border-radius: 0;
            margin-right: 0;
            margin-left: 10px;
            border-left: 2px solid rgba(255,255,255,0.2);
        }
        .sidebar .submenu .nav-link:hover {
            color: #ffc107;
            background-color: transparent;
            border-left-color: #ffc107;
            transform: translateX(3px);
            box-shadow: none;
        }

        /* Badge/Marker untuk menu aktif (opsional, via CSS class) */
        .sidebar .nav-link.active {
            background-color: white;
            color: #cb2d3e !important;
            font-weight: 600;
        }

        /* --- DESAIN AREA KONTEN KANAN --- */
        .main-content {
            margin-left: 260px;
            padding: 40px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Glassmorphism scrollbar untuk sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-building"></i> SantriQ
        </div>
        
        <nav class="nav flex-column">
            
            <?php if($role === 'super_admin'): ?>
    <a class="nav-link text-white d-inline-flex align-items-center" href="input_santri.php">
    <!-- fa-4x dibuang, diganti bi-person-plus-fill yang ukurannya pas -->
    <i class="bi bi-person-plus-fill me-2" style="font-size: 1rem; vertical-align: middle;"></i> 
    Input Data Santri
</a>
                
   <a class="nav-link text-white d-flex justify-content-between align-items-center" 
   href="javascript:void(0);" 
   onclick="toggleSubmenu()" 
   style="cursor: pointer;">
<span><i class="bi bi-people-fill me-2 fs-6" style="font-size: 1rem; vertical-align: -1px;"></i> Kelola Data Anak</span>
    <i class="bi bi-chevron-down" id="panah-dropdown" style="transition: transform 0.3s ease; font-size: 0.8rem;"></i>
</a>

<div id="sub-menu-anak" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background-color: rgba(0,0,0,0.05);">
    <a class="nav-link ps-4 py-2 small text-white-50 text-decoration-none d-block" href="kelas_1.php">
        <i class="bi bi-dot"></i> Kelas 1
    </a>
    <a class="nav-link ps-4 py-2 small text-white-50 text-decoration-none d-block" href="kelas_2.php">
        <i class="bi bi-dot"></i> Kelas 2
    </a>
    <a class="nav-link ps-4 py-2 small text-white-50 text-decoration-none d-block" href="kelas_3.php">
        <i class="bi bi-dot"></i> Kelas 3
    </a>
</div>

<script>
function toggleSubmenu() {
    var menu = document.getElementById("sub-menu-anak");
    var panah = document.getElementById("panah-dropdown");
    
    // Jika sedang tertutup, buka kodenya
    if (menu.style.maxHeight === "0px" || menu.style.maxHeight === "") {
        menu.style.maxHeight = menu.scrollHeight + "px";
        panah.style.transform = "rotate(180deg)"; // Panah berputar ke atas
    } else {
        // Jika sedang terbuka, tutup kodenya
        menu.style.maxHeight = "0px";
        panah.style.transform = "rotate(0deg)"; // Panah balik normal
    }
}

// Otomatis menjaga menu tetap terbuka jika admin sedang berada di dalam page kelas 1, 2, atau 3
document.addEventListener("DOMContentLoaded", function() {
    var currentPage = window.location.pathname.split("/").pop();
    if (currentPage === "kelas_1.php" || currentPage === "kelas_2.php" || currentPage === "kelas_3.php") {
        var menu = document.getElementById("sub-menu-anak");
        var panah = document.getElementById("panah-dropdown");
        menu.style.maxHeight = menu.scrollHeight + "px";
        menu.style.transition = "none"; // Tanpa animasi loading awal
        panah.style.transform = "rotate(180deg)";
    }
});
</script>
            <?php endif; ?>

            <a class="nav-link" href="absensi_kelas.php">
                <i class="bi bi-calendar-check-fill me-2"></i> Input Absensi
            </a>
            
            <hr class="border-light border-opacity-25 my-3 mx-3">
            
            <a class="nav-link text-warning" href="logout.php">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </a>
            
        </nav>
    </div>

    <div class="main-content">