<?php 
include 'header.php'; 

// Cek apakah ada request hapus data
if(isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pelanggaran WHERE id_pelanggaran = $id_hapus");
}

// Ambil data pelanggaran beserta nama santrinya menggunakan JOIN
$query = "SELECT p.*, s.nama_lengkap, s.kelas 
          FROM pelanggaran p 
          JOIN santri s ON p.id_santri = s.id_santri 
          ORDER BY p.tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Riwayat Pelanggaran</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
        + Catat Pelanggaran
    </button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Tindakan / Poin</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['nama_lengkap'] ?></td>
                    <td><?= $row['kelas'] ?></td>
                    <td><?= $row['jenis_pelanggaran'] ?></td>
                    <td><?= $row['tindakan'] ?> <span class="badge bg-danger"><?= $row['poin'] ?> Poin</span></td>
                    <td>
                        <a href="?hapus=<?= $row['id_pelanggaran'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>