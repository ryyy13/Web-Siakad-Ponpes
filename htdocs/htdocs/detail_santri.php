<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'header.php';

// Validasi URL
if (!isset($_GET['id']) || !isset($_GET['kelas'])) {
    echo "<script>window.location.href='absensi_kelas.php';</script>";
    exit;
}

$id_santri = (int)$_GET['id'];
$kelas = $conn->real_escape_string($_GET['kelas']);

// ==========================================
// LOGIKA UPDATE PROFIL UTAMA ANAK
// ==========================================
$pesan_sukses = "";

if (isset($_POST['update_profil'])) {
    // Menggunakan isset() agar terhindar dari warning "Undefined array key"
    $nama = isset($_POST['nama']) ? $conn->real_escape_string($_POST['nama']) : '';
    $nik = isset($_POST['nik']) ? $conn->real_escape_string($_POST['nik']) : '';
    $tempat_lahir = isset($_POST['tempat_lahir']) ? $conn->real_escape_string($_POST['tempat_lahir']) : '';
    $tanggal_lahir = isset($_POST['tanggal_lahir']) ? $conn->real_escape_string($_POST['tanggal_lahir']) : '';
    $nama_ayah = isset($_POST['nama_ayah']) ? $conn->real_escape_string($_POST['nama_ayah']) : '';
    $nama_ibu = isset($_POST['nama_ibu']) ? $conn->real_escape_string($_POST['nama_ibu']) : '';
    $alamat_lengkap = isset($_POST['alamat_lengkap']) ? $conn->real_escape_string($_POST['alamat_lengkap']) : '';
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';

    // Kueri UPDATE sudah diperbaiki (TIDAK ADA KOMA SEBELUM WHERE)
    $update_query = "UPDATE $kelas SET 
                     nama='$nama', nik='$nik', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
                     nama_ayah='$nama_ayah', nama_ibu='$nama_ibu', alamat_lengkap='$alamat_lengkap', username='$username', password='$password' 
                     WHERE id=$id_santri";
                     
    if ($conn->query($update_query)) {
        $pesan_sukses = "Profil anak berhasil diupdate!";
    } else {
        echo "<div class='alert alert-danger m-3'>Error Database: " . $conn->error . "</div>";
    }
}

// Ambil Data Profil Anak (Ambil ulang setelah diupdate)
$query_profil = $conn->query("SELECT * FROM $kelas WHERE id = $id_santri");
if ($query_profil->num_rows == 0) {
    echo "Data anak tidak ditemukan."; exit;
}
$profil = $query_profil->fetch_assoc();

// ==========================================
// LOGIKA SIMPAN DATA PENDUKUNG
// ==========================================

// Simpan Absensi
if (isset($_POST['simpan_absensi'])) {
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $status_hadir = $conn->real_escape_string($_POST['status_hadir']);
    $keterangan = $conn->real_escape_string($_POST['keterangan']);
    $conn->query("INSERT INTO absensi (id_santri, asal_kelas, tanggal, status_hadir, keterangan) VALUES ($id_santri, '$kelas', '$tanggal', '$status_hadir', '$keterangan')");
    $pesan_sukses = "Absensi berhasil disimpan!";
}

// Simpan Nilai
if (isset($_POST['simpan_nilai'])) {
    $mapel = $conn->real_escape_string($_POST['mata_pelajaran']);
    $nilai = (int)$_POST['nilai'];
    $semester = $conn->real_escape_string($_POST['semester']);
    $conn->query("INSERT INTO nilai (id_santri, asal_kelas, mata_pelajaran, nilai, semester) VALUES ($id_santri, '$kelas', '$mapel', $nilai, '$semester')");
    $pesan_sukses = "Nilai berhasil disimpan!";
}

// Simpan Kesehatan
if (isset($_POST['simpan_kesehatan'])) {
    $tgl = $conn->real_escape_string($_POST['tanggal']);
    $keluhan = $conn->real_escape_string($_POST['keluhan']);
    $penanganan = $conn->real_escape_string($_POST['penanganan']);
    $conn->query("INSERT INTO kesehatan (id_santri, asal_kelas, tanggal, keluhan, penanganan) VALUES ($id_santri, '$kelas', '$tgl', '$keluhan', '$penanganan')");
    $pesan_sukses = "Catatan kesehatan disimpan!";
}

// Simpan Pelanggaran
if (isset($_POST['simpan_pelanggaran'])) {
    $tgl = $conn->real_escape_string($_POST['tanggal']);
    $jenis = $conn->real_escape_string($_POST['jenis_pelanggaran']);
    $sanksi = $conn->real_escape_string($_POST['sanksi']);
    $conn->query("INSERT INTO pelanggaran (id_santri, asal_kelas, tanggal, jenis_pelanggaran, sanksi) VALUES ($id_santri, '$kelas', '$tgl', '$jenis', '$sanksi')");
    $pesan_sukses = "Catatan pelanggaran disimpan!";
}
?>

<div class="container-fluid mb-4">
    <a href="<?= $kelas ?>.php" class="btn btn-outline-secondary btn-sm fw-bold mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas
    </a>

    <div class="card bg-danger text-white border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4 d-flex align-items-center gap-4">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 80px; height: 80px;">
                <i class="bi bi-person-fill text-danger" style="font-size: 3rem;"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-1"><?= htmlspecialchars($profil['nama']) ?></h3>
                <p class="mb-0 text-white-50 fs-5">
                    <span class="badge bg-white text-danger me-2"><?= strtoupper($kelas) ?></span> 
                    NIK: <?= htmlspecialchars($profil['nik'] ?? '-') ?>
                </p>
            </div>
        </div>
    </div>

   <ul class="nav nav-tabs nav-fill mb-3 border-danger" id="santriTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-dark fw-bold" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#tab-profil" data-target="#tab-profil" type="button" role="tab">Profil & Edit</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark fw-bold" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#tab-absen" data-target="#tab-absen" type="button" role="tab">Absensi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark fw-bold" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#tab-nilai" data-target="#tab-nilai" type="button" role="tab">Nilai</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark fw-bold" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#tab-sehat" data-target="#tab-sehat" type="button" role="tab">Kesehatan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark fw-bold" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#tab-pelanggaran" data-target="#tab-pelanggaran" type="button" role="tab">Pelanggaran</button>
        </li>
    </ul>

    <div class="tab-content bg-white p-4 border rounded-3 shadow-sm mb-5">
        
        <div class="tab-pane fade show active" id="tab-profil">
            <h5 class="fw-bold border-bottom pb-2 text-danger"><i class="bi bi-pencil-square me-2"></i>Edit Data Diri Anak</h5>
            <form method="POST" action="">
                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= htmlspecialchars($profil['nik'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="<?= htmlspecialchars($profil['tempat_lahir'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($profil['tanggal_lahir'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control" value="<?= htmlspecialchars($profil['nama_ayah'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control" value="<?= htmlspecialchars($profil['nama_ibu'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($profil['username'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-muted">Password</label>
                        <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($profil['password'] ?? '') ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="fw-bold small text-muted">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="2"><?= htmlspecialchars($profil['alamat_lengkap'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="update_profil" class="btn btn-warning fw-bold text-dark w-100">Simpan Perubahan Profil</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="tab-absen">
            <div class="row">
                <div class="col-md-4 border-end">
                    <h6 class="fw-bold text-danger mb-3">Input Absensi Baru</h6>
                    <form method="POST" action="">
                        <label class="small text-muted mb-1">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm mb-2" required>
                        
                        <label class="small text-muted mb-1">Status Kehadiran</label>
                        <select name="status_hadir" class="form-select form-select-sm mb-2" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Izin">Izin</option>
                            <option value="Alfa">Alfa</option>
                        </select>
                        
                        <label class="small text-muted mb-1">Keterangan Tambahan</label>
                        <input type="text" name="keterangan" class="form-control form-control-sm mb-3" placeholder="Opsional...">
                        
                        <button type="submit" name="simpan_absensi" class="btn btn-danger btn-sm w-100 fw-bold">Simpan Absen</button>
                    </form>
                </div>
                <div class="col-md-8 ps-4">
                    <h6 class="fw-bold text-dark mb-3">Riwayat Absensi</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-bordered text-center table-striped">
                            <thead class="table-light sticky-top"><tr><th>Tanggal</th><th>Status</th><th>Keterangan</th></tr></thead>
                            <tbody>
                                <?php 
                                $q_absen = $conn->query("SELECT * FROM absensi WHERE id_santri=$id_santri AND asal_kelas='$kelas' ORDER BY tanggal DESC");
                                if ($q_absen->num_rows > 0) {
                                    while($row = $q_absen->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['tanggal'] ?></td>
                                            <td><span class="badge <?= $row['status_hadir'] == 'Hadir' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= $row['status_hadir'] ?></span></td>
                                            <td><?= htmlspecialchars($row['keterangan'] ?: '-') ?></td>
                                        </tr>
                                    <?php endwhile; 
                                } else {
                                    echo "<tr><td colspan='3' class='text-muted'>Belum ada data absensi.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-nilai">
             <div class="row">
                <div class="col-md-4 border-end">
                    <h6 class="fw-bold text-danger mb-3">Input Nilai Ujian</h6>
                    <form method="POST" action="">
                        <label class="small text-muted mb-1">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control form-control-sm mb-2" placeholder="Contoh: Matematika" required>
                        
                        <label class="small text-muted mb-1">Nilai (0-100)</label>
                        <input type="number" name="nilai" class="form-control form-control-sm mb-2" placeholder="Angka Nilai" required>
                        
                        <label class="small text-muted mb-1">Semester</label>
                        <select name="semester" class="form-select form-select-sm mb-3" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                        
                        <button type="submit" name="simpan_nilai" class="btn btn-danger btn-sm w-100 fw-bold">Simpan Nilai</button>
                    </form>
                </div>
                <div class="col-md-8 ps-4">
                    <h6 class="fw-bold text-dark mb-3">Riwayat Nilai Rapor</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-bordered text-center table-striped">
                            <thead class="table-light sticky-top"><tr><th>Mata Pelajaran</th><th>Semester</th><th>Nilai</th></tr></thead>
                            <tbody>
                                <?php 
                                $q_nilai = $conn->query("SELECT * FROM nilai WHERE id_santri=$id_santri AND asal_kelas='$kelas' ORDER BY id DESC");
                                if ($q_nilai->num_rows > 0) {
                                    while($row = $q_nilai->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['mata_pelajaran']) ?></td>
                                            <td><?= htmlspecialchars($row['semester']) ?></td>
                                            <td class="fw-bold"><?= $row['nilai'] ?></td>
                                        </tr>
                                    <?php endwhile; 
                                } else {
                                    echo "<tr><td colspan='3' class='text-muted'>Belum ada data nilai.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-sehat">
             <div class="row mt-3">
                <div class="col-md-4 border-end">
                    <h6 class="fw-bold text-danger mb-3">Catat Rekam Medis</h6>
                    <form method="POST" action="">
                        <label class="small text-muted mb-1">Tanggal Periksa</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm mb-2" required>
                        
                        <label class="small text-muted mb-1">Keluhan Sakit</label>
                        <textarea name="keluhan" class="form-control form-control-sm mb-2" placeholder="Contoh: Demam dan flu" rows="2" required></textarea>
                        
                        <label class="small text-muted mb-1">Penanganan / Obat</label>
                        <textarea name="penanganan" class="form-control form-control-sm mb-3" placeholder="Contoh: Diberi paracetamol & istirahat" rows="2" required></textarea>
                        
                        <button type="submit" name="simpan_kesehatan" class="btn btn-danger btn-sm w-100 fw-bold">
                            <i class="bi bi-save-fill me-1"></i> Simpan Catatan Kesehatan
                        </button>
                    </form>
                </div>
                <div class="col-md-8 ps-4">
                    <h6 class="fw-bold text-dark mb-3">Riwayat Kesehatan Anak</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-bordered table-striped">
                            <thead class="table-light sticky-top">
                                <tr><th>Tanggal</th><th>Keluhan</th><th>Penanganan</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $q_sehat = $conn->query("SELECT * FROM kesehatan WHERE id_santri=$id_santri AND asal_kelas='$kelas' ORDER BY tanggal DESC");
                                if ($q_sehat->num_rows > 0) {
                                    while($row = $q_sehat->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-nowrap"><?= $row['tanggal'] ?></td>
                                            <td><?= htmlspecialchars($row['keluhan']) ?></td>
                                            <td><?= htmlspecialchars($row['penanganan']) ?></td>
                                        </tr>
                                    <?php endwhile; 
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada riwayat kesehatan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-pelanggaran">
             <div class="row mt-3">
                <div class="col-md-4 border-end">
                    <h6 class="fw-bold text-danger mb-3">Catat Kasus / Pelanggaran</h6>
                    <form method="POST" action="">
                        <label class="small text-muted mb-1">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" class="form-control form-control-sm mb-2" required>
                        
                        <label class="small text-muted mb-1">Jenis Pelanggaran</label>
                        <input type="text" name="jenis_pelanggaran" class="form-control form-control-sm mb-2" placeholder="Contoh: Terlambat masuk kelas" required>
                        
                        <label class="small text-muted mb-1">Sanksi yang Diberikan</label>
                        <input type="text" name="sanksi" class="form-control form-control-sm mb-3" placeholder="Contoh: Membersihkan halaman" required>
                        
                        <button type="submit" name="simpan_pelanggaran" class="btn btn-danger btn-sm w-100 fw-bold">
                            <i class="bi bi-save-fill me-1"></i> Simpan Data Kasus
                        </button>
                    </form>
                </div>
                <div class="col-md-8 ps-4">
                    <h6 class="fw-bold text-dark mb-3">Riwayat Pelanggaran Anak</h6>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-bordered table-striped">
                            <thead class="table-light sticky-top">
                                <tr><th>Tanggal</th><th>Jenis Pelanggaran</th><th>Sanksi</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $q_langgar = $conn->query("SELECT * FROM pelanggaran WHERE id_santri=$id_santri AND asal_kelas='$kelas' ORDER BY tanggal DESC");
                                if ($q_langgar->num_rows > 0) {
                                    while($row = $q_langgar->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-nowrap"><?= $row['tanggal'] ?></td>
                                            <td><?= htmlspecialchars($row['jenis_pelanggaran']) ?></td>
                                            <td class="text-danger fw-bold"><?= htmlspecialchars($row['sanksi']) ?></td>
                                        </tr>
                                    <?php endwhile; 
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Alhamdulillah, tidak ada riwayat pelanggaran.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($pesan_sukses)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ 
            title: 'Berhasil!', 
            text: '<?= $pesan_sukses; ?>', 
            icon: 'success', 
            timer: 2000, 
            showConfirmButton: false 
        });
    });
</script>
<?php endif; ?>

<?php include 'footer.php'; ?>