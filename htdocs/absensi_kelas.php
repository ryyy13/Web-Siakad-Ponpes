<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['login_status'])) { 
    header("Location: index.php"); 
    exit; 
}

require_once 'koneksi.php';
include 'header.php'; // Memanggil header bawaan template Anda

$pesan_sukses = "";
$pesan_error = "";

// ==========================================
// LOGIKA SIMPAN ABSENSI MASSAL
// ==========================================
if (isset($_POST['simpan_absen_massal'])) {
    $kelas_target = $conn->real_escape_string($_POST['kelas_target']);
    $mapel = $conn->real_escape_string($_POST['id_mapel']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    
    $status_array = $_POST['status']; // Array berisi status kehadiran tiap id_santri
    $keterangan_array = $_POST['keterangan']; // Array berisi keterangan tiap id_santri

    $berhasil = 0;
    
    // Looping data yang dikirim dari tabel form
    foreach ($status_array as $id_santri => $status_hadir) {
        $id_santri = (int)$id_santri;
        $status_hadir = $conn->real_escape_string($status_hadir);
        $keterangan = $conn->real_escape_string($keterangan_array[$id_santri] ?? '');

        // Cek apakah hari ini & mapel ini anak tersebut sudah diabsen (mencegah double)
        $cek = $conn->query("SELECT id FROM absensi WHERE id_santri=$id_santri AND asal_kelas='$kelas_target' AND tanggal='$tanggal' AND mata_pelajaran='$mapel'");
        
        if ($cek->num_rows == 0) {
            // Jika belum ada, masukkan data baru
            $query_insert = "INSERT INTO absensi (id_santri, asal_kelas, mata_pelajaran, tanggal, status_hadir, keterangan) 
                             VALUES ($id_santri, '$kelas_target', '$mapel', '$tanggal', '$status_hadir', '$keterangan')";
            if ($conn->query($query_insert)) {
                $berhasil++;
            }
        } else {
            // Jika sudah ada, update data absen yang lama
            $query_update = "UPDATE absensi SET status_hadir='$status_hadir', keterangan='$keterangan' 
                             WHERE id_santri=$id_santri AND asal_kelas='$kelas_target' AND tanggal='$tanggal' AND mata_pelajaran='$mapel'";
            $conn->query($query_update);
            $berhasil++;
        }
    }

    if ($berhasil > 0) {
        $pesan_sukses = "Berhasil menyimpan absensi untuk $berhasil siswa!";
    } else {
        $pesan_error = "Gagal menyimpan absensi atau data kosong.";
    }
}
?>

<div class="container-fluid mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0"><i class="bi bi-calendar2-check-fill text-primary me-2"></i> Input Absensi Kelas</h3>
    </div>

    <?php 
    // ==========================================
    // TAHAP 1: JIKA KELAS BELUM DIPILIH (TAMPILKAN GRID KELAS)
    // ==========================================
    if (!isset($_GET['kelas'])): 
    ?>
        <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-info-circle-fill me-2"></i> Silakan pilih kelas terlebih dahulu untuk memulai absensi.
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-lift transition-all">
                    <div class="card-body p-5">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <h1 class="text-primary m-0 fw-black">1</h1>
                        </div>
                        <h4 class="fw-bold mb-3">Kelas 1</h4>
                        <a href="?kelas=kelas1" class="btn btn-primary rounded-pill w-100 fw-bold">Pilih Kelas 1 <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-lift transition-all">
                    <div class="card-body p-5">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <h1 class="text-success m-0 fw-black">2</h1>
                        </div>
                        <h4 class="fw-bold mb-3">Kelas 2</h4>
                        <a href="?kelas=kelas2" class="btn btn-success rounded-pill w-100 fw-bold">Pilih Kelas 2 <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-lift transition-all">
                    <div class="card-body p-5">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <h1 class="text-warning m-0 fw-black">3</h1>
                        </div>
                        <h4 class="fw-bold mb-3">Kelas 3</h4>
                        <a href="?kelas=kelas3" class="btn btn-warning rounded-pill w-100 fw-bold text-dark">Pilih Kelas 3 <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

    <?php 
    // ==========================================
    // TAHAP 2: JIKA KELAS SUDAH DIPILIH (TAMPILKAN DAFTAR SISWA & FORM)
    // ==========================================
    else: 
        $kelas_aktif = $conn->real_escape_string($_GET['kelas']);
        
        // Ambil daftar siswa dari kelas yang dipilih
        $query_siswa = $conn->query("SELECT id, nama, nik FROM $kelas_aktif ORDER BY nama ASC");
    ?>
        
        <div class="mb-3">
            <a href="absensi_kelas.php" class="btn btn-outline-secondary btn-sm fw-bold">
                <i class="bi bi-arrow-left"></i> Kembali Pilih Kelas
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4" style="overflow: hidden;">
            <div class="card-header text-white p-3 border-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h5 class="m-0 fw-bold"><i class="bi bi-card-checklist me-2"></i> Form Absensi: <?= strtoupper($kelas_aktif) ?></h5>
            </div>
            <div class="card-body p-4">
                
                <form method="POST" action="">
                    <input type="hidden" name="kelas_target" value="<?= $kelas_aktif ?>">

                    <div class="row g-3 mb-4 bg-light p-3 rounded-3 border">
                        <div class="col-md-6">
                            <label class="fw-bold small text-muted mb-1">Tanggal Absensi</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small text-muted mb-1">Mata Pelajaran</label>
                            <select name="id_mapel" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                <?php 
                                // Ambil daftar mapel (Pastikan tabel mata_pelajaran benar-benar ada)
                               // Mengambil mapel HANYA untuk kelas yang sedang dibuka ($kelas_aktif)
$q_mapel = $conn->query("SELECT * FROM mata_pelajaran WHERE asal_kelas='$kelas_aktif' ORDER BY nama_mapel ASC");
                                if ($q_mapel && $q_mapel->num_rows > 0) {
                                    while($m = $q_mapel->fetch_assoc()) {
                                        echo "<option value='".$m['nama_mapel']."'>".$m['nama_mapel']."</option>";
                                    }
                                } else {
                                    // Fallback statis jika tabel mata_pelajaran belum siap
                                    echo "<option value='Matematika'>Matematika</option>";
                                    echo "<option value='Bahasa Indonesia'>Bahasa Indonesia</option>";
                                    echo "<option value='Agama'>Agama Islam</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Siswa</th>
                                    <th width="40%">Status Kehadiran</th>
                                    <th width="30%">Keterangan Tambahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($query_siswa && $query_siswa->num_rows > 0):
                                    $no = 1;
                                    while($siswa = $query_siswa->fetch_assoc()): 
                                        $id_s = $siswa['id'];
                                ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $no++ ?></td>
                                        <td class="fw-bold text-dark">
                                            <?= htmlspecialchars($siswa['nama']) ?>
                                            <br><small class="text-muted fw-normal">NIK: <?= htmlspecialchars($siswa['nik'] ?: '-') ?></small>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border-success" type="radio" name="status[<?= $id_s ?>]" id="hadir_<?= $id_s ?>" value="Hadir" checked>
                                                    <label class="form-check-label fw-bold text-success" for="hadir_<?= $id_s ?>">Hadir</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border-info" type="radio" name="status[<?= $id_s ?>]" id="izin_<?= $id_s ?>" value="Izin">
                                                    <label class="form-check-label fw-bold text-info" for="izin_<?= $id_s ?>">Izin</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border-warning" type="radio" name="status[<?= $id_s ?>]" id="sakit_<?= $id_s ?>" value="Sakit">
                                                    <label class="form-check-label fw-bold text-warning" for="sakit_<?= $id_s ?>">Sakit</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input border-danger" type="radio" name="status[<?= $id_s ?>]" id="alfa_<?= $id_s ?>" value="Alfa">
                                                    <label class="form-check-label fw-bold text-danger" for="alfa_<?= $id_s ?>">Alfa</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan[<?= $id_s ?>]" class="form-control form-control-sm" placeholder="Opsional...">
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile; 
                                else: 
                                ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder2-open fa-3x d-block mb-3"></i>
                                            Belum ada data siswa di kelas ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" name="simpan_absen_massal" class="btn text-white btn-lg fw-bold rounded-pill px-5 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none;">
                            <i class="bi bi-save2-fill me-2"></i> Simpan Absensi Massal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($pesan_sukses)): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ title: 'Tersimpan!', text: '<?= $pesan_sukses; ?>', icon: 'success', timer: 2500, showConfirmButton: false });
    });
</script>
<?php endif; ?>

<?php if (!empty($pesan_error)): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({ title: 'Gagal!', text: '<?= $pesan_error; ?>', icon: 'error' });
    });
</script>
<?php endif; ?>

<style>
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; cursor: pointer; }
    .transition-all { transition: all 0.3s ease; }
    .fw-black { font-weight: 900; }
</style>

<?php include 'footer.php'; ?>