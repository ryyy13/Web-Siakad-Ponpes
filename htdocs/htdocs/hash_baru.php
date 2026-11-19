<?php
// Tulis password yang ingin kamu jadikan hash di sini
$password_kamu = 'bismillah';

// Proses mengubah password menjadi hash aman bcrypt
$password_hash = password_hash($password_kamu, PASSWORD_BCRYPT);

echo "<h3>Generator Hash Password SantriQ</h3>";
echo "Password Asli: <b>" . $password_kamu . "</b><br>";
echo "Hasil Hash (Masukkan ini ke Database):<br>";
echo "<textarea rows='3' cols='70' style='font-family:monospace; padding:10px; margin-top:5px;' readonly>" . $password_hash . "</textarea>";
echo "<br><br><small><i>Tips: Segarkan/refresh halaman untuk menghasilkan hash yang baru (isinya akan selalu berbeda tetapi tetap valid saat login).</i></small>";
?>