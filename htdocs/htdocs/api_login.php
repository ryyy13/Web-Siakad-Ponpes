<?php
// Izinkan akses dari luar (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once 'koneksi.php';

// Menangkap data yang dikirim dari Flutter
$username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Ganti 'users' dengan nama tabel yang menyimpan data login wali santri/user Anda
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Cek password (mendukung password yang di-hash maupun teks biasa)
    if (password_verify($password, $row['password']) || $password === $row['password']) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'id' => $row['id'],
                'username' => $row['username']
                // Tambahkan data lain jika perlu
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username tidak ditemukan!']);
}
?>