<?php
// 1. Wajib jalankan session dulu agar sistem tahu session mana yang mau dihapus
session_start();

// 2. Kosongkan semua variabel session
$_SESSION = array();

// 3. Hancurkan cookie session di browser jika ada (Biar benar-benar bersih)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Hancurkan semua data session di server
session_destroy();

// 5. Tendang langsung ke halaman login (index.php) dan stop script!
header("Location: index.php");
exit;
?>