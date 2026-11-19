<?php
    
$host = "sql210.infinityfree.com"; // MySQL Hostname
$user = "if0_42180640";           // MySQL Username
$pass = "ryy12345";             // Password akun hosting
$db   = "if0_42180640_santriq_db"; // Nama database

// Membuat koneksi ke database menggunakan MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    // Jika gagal, hentikan proses dan tampilkan pesan error
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

?>