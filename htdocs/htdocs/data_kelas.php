<?php 
// 1. Panggil Header (Di dalamnya sudah ada session_start dan koneksi.php)
include 'header.php';

// 2. Proteksi Halaman: Cek jika staf mencoba masuk, tendang ke halaman absensi
if ($_SESSION['role'] != 'super_admin') { 
    header("Location: absensi_kelas.php"); 
    exit; 
}

// 3. Tangkap ID Kelas dari URL (Default ke angka 1 jika tidak ada di URL)
$id_kelas = isset($_GET['id_kelas']) ? intval($_GET['id_kelas']) : 1;

// 4. Ambil nama kelas yang sedang dipilih untuk judul halaman
$query_nama_kelas = mysqli_query($conn, "SELECT nama_kelas FROM kelas WHERE id = $id_kelas");
$data_kelas = mysqli_fetch_assoc($query_nama_kelas);
$nama_halaman_kelas = $data_kelas ? $data_kelas['nama_kelas'] : "Tidak Diketahui";

// 5. Ambil data santri yang terdaftar di ID Kelas tersebut
$query_santri = mysqli_query($conn, "SELECT * FROM santri WHERE id_kelas = $id_kelas ORDER BY nama ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3>Kelola Data Anak - <?= htmlspecialchars($nama_halaman_kelas); ?></h3>
        <p class="text-muted mb-0">Daftar santri aktif yang terdaftar pada kelas ini.</p>
    </div>
    <a href="input_santri.php" class="btn btn-danger"><i class="bi bi-person-plus"></i> + Tambah Anak</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="80">No</th>
                        <th width="150">NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($query_santri) > 0):
                        while($row = mysqli_fetch_assoc($query_santri)): 
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><code><?= htmlspecialchars($row['nis']); ?></code></td>
                            <td><strong><?= htmlspecialchars($row['nama']); ?></strong></td>
                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                            <td class="text-center">
                                <a href="detail_santri.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-gear"></i> Kelola Data
                                </a>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Belum ada data anak di <?= htmlspecialchars($nama_halaman_kelas); ?>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
// 6. Panggil Footer
include 'footer.php'; 
?>