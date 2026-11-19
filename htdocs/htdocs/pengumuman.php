<?php
session_start();
if(!isset($_SESSION['login_admin'])) {
    header("Location: index.php");
    exit;
}
include 'koneksi.php';

// Proses Simpan Data
if(isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    $query = "INSERT INTO pengumuman (kategori, judul, isi) VALUES ('$kategori', '$judul', '$isi')";
    mysqli_query($koneksi, $query);
    header("Location: pengumuman.php?sukses=1");
}

// Mengambil data untuk ditampilkan di tabel
$data_pengumuman = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Pengumuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">⬅ Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Kelola Pengumuman</h3>
        
        <?php if(isset($_GET['sukses'])): ?>
            <div class="alert alert-success">Pengumuman berhasil ditambahkan!</div>
        <?php endif; ?>

        <div class="row">
            <!-- Form Input -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">Tambah Pengumuman Baru</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control" required>
                                    <option value="PENGUMUMAN">PENGUMUMAN</option>
                                    <option value="INFORMASI">INFORMASI</option>
                                    <option value="PERINGATAN">PERINGATAN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Isi Pengumuman</label>
                                <textarea name="isi" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="col-md-8">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($data_pengumuman)): 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_dibuat'])); ?></td>
                            <td><span class="badge bg-secondary"><?= $row['kategori']; ?></span></td>
                            <td>
                                <strong><?= $row['judul']; ?></strong><br>
                                <small class="text-muted"><?= $row['isi']; ?></small>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>