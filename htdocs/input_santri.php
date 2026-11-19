<?php
// ==========================================
// PENGAMAN ERROR & INISIALISASI
// ==========================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Panggil header bawaan (Di dalamnya sudah ada session_start, koneksi.php, dan pembuka col-md-10)
include 'header.php';

$pesan_sukses = "";
$pesan_warning = ""; // Tambahan variabel untuk pop-up double/error

// ==========================================
// LOGIKA TAMBAH / UPDATE DATA ANAK
// ==========================================
if (isset($_POST['simpan_anak'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $no_kk = $conn->real_escape_string($_POST['no_kk']);
    $nik = $conn->real_escape_string($_POST['nik']);
    $tempat_lahir = $conn->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $nama_ayah = $conn->real_escape_string($_POST['nama_ayah']);
    $pekerjaan_ayah = $conn->real_escape_string($_POST['pekerjaan_ayah']);
    $nama_ibu = $conn->real_escape_string($_POST['nama_ibu']);
    $pekerjaan_ibu = $conn->real_escape_string($_POST['pekerjaan_ibu']);
    
    // Penanganan jika no_hp_keluarga tidak ada di form (untuk mencegah error undefined index)
    $no_hp_keluarga = isset($_POST['no_hp_keluarga']) ? $conn->real_escape_string($_POST['no_hp_keluarga']) : '';
    
    $alamat_lengkap = $conn->real_escape_string($_POST['alamat_lengkap']);

    if (isset($_POST['id_anak_edit']) && !empty($_POST['id_anak_edit'])) {
        // ================= UPDATE DATA =================
        $id = (int)$_POST['id_anak_edit'];
        $tabel_asal = $_POST['tabel_asal_lama'];
        
        $query = "UPDATE $tabel_asal SET 
                  nama='$nama', no_kk='$no_kk', nik='$nik', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
                  nama_ayah='$nama_ayah', pekerjaan_ayah='$pekerjaan_ayah', 
                  nama_ibu='$nama_ibu', pekerjaan_ibu='$pekerjaan_ibu', no_hp_keluarga='$no_hp_keluarga', 
                  alamat_lengkap='$alamat_lengkap' 
                  WHERE id=$id";
                  
        if ($conn->query($query) === TRUE) {
            // Refresh halaman ini sendiri dengan parameter status=updated
            echo "<script>window.location.href='?status=updated';</script>";
            exit();
        }
    } else {
        // ================= TAMBAH BARU =================
        $kelas_input = isset($_POST['kelas']) ? $_POST['kelas'] : '';
        $nama_tabel_anak = "";

        // Penentuan tabel berdasarkan pilihan dropdown (value 1, 2, atau 3)
        if ($kelas_input === '1') {
            $nama_tabel_anak = "kelas1";
        } elseif ($kelas_input === '2') {
            $nama_tabel_anak = "kelas2";
        } elseif ($kelas_input === '3') {
            $nama_tabel_anak = "kelas3";
        }

        // Pastikan kelas sudah dipilih
        if ($nama_tabel_anak !== "") {
            
            // CEK DUPLIKAT: Cek apakah nama dan tanggal lahir yang sama sudah ada di tabel tujuan
            $cek_double = $conn->query("SELECT id FROM $nama_tabel_anak WHERE nama = '$nama' AND tanggal_lahir = '$tanggal_lahir'");
            
            if ($cek_double->num_rows > 0) {
                // Jika data sudah ada, beri pesan peringatan
                $pesan_warning = "Data anak atas nama <b>$nama</b> sudah terdaftar di Kelas $kelas_input!";
            } else {
                // Jika belum ada, simpan ke database
                $query = "INSERT INTO $nama_tabel_anak (
                            nama, no_kk, nik, tempat_lahir, tanggal_lahir,
                            nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_hp_keluarga, 
                            alamat_lengkap
                        ) VALUES (
                            '$nama', '$no_kk', '$nik', '$tempat_lahir', '$tanggal_lahir',
                            '$nama_ayah', '$pekerjaan_ayah', '$nama_ibu', '$pekerjaan_ibu', '$no_hp_keluarga',
                            '$alamat_lengkap'
                        )";
                        
                if ($conn->query($query) === TRUE) {
                    $pesan_sukses = "Data Anak atas nama <b>$nama</b> berhasil ditambahkan ke Kelas $kelas_input!";
                } else {
                    $pesan_warning = "Gagal menyimpan data: " . $conn->error;
                }
            }
        } else {
            $pesan_warning = "Silakan pilih kelas terlebih dahulu sebelum menyimpan!";
        }
    }
}

// ==========================================
// LOGIKA HAPUS DATA ANAK
// ==========================================
if (isset($_GET['hapus_anak'])) {
    $id = (int)$_GET['hapus_anak'];
    $tabel = $_GET['tabel'];
    if ($tabel == 'kelas1' || $tabel == 'kelas2' || $tabel == 'kelas3')  {
        $conn->query("DELETE FROM $tabel WHERE id=$id");
        // Refresh halaman ini sendiri dengan parameter status=deleted
        echo "<script>window.location.href='?status=deleted';</script>";
        exit();
    }
}

// Menangkap notifikasi dari URL untuk memunculkan popup otomatis
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'updated') $pesan_sukses = "Perubahan data berhasil disimpan!";
    if ($_GET['status'] == 'deleted') $pesan_sukses = "Data anak berhasil dihapus!";
}

// AMBIL DATA ANAK DARI 3 TABEL
$data_anak = $conn->query("
    (SELECT id, nama, no_kk, nik, tempat_lahir, tanggal_lahir, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, alamat_lengkap, 'kelas1' AS tabel_asal FROM kelas1) 
    UNION ALL 
    (SELECT id, nama, no_kk, nik, tempat_lahir, tanggal_lahir, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, alamat_lengkap, 'kelas2' AS tabel_asal FROM kelas2) 
    UNION ALL 
    (SELECT id, nama, no_kk, nik, tempat_lahir, tanggal_lahir, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, alamat_lengkap, 'kelas3' AS tabel_asal FROM kelas3) 
    ORDER BY nama ASC
");

$active_edit_anak_id = isset($_GET['aksi_edit_anak']) ? (int)$_GET['id'] : 0;
?>

<style>
    .row-edit-form { display: none; background-color: rgba(255, 193, 7, 0.08) !important; }
    .row-edit-form.show-form { display: table-row; }
    .animasi-wrapper { max-height: 0; overflow: hidden; transition: max-height 0.35s ease-out, padding 0.35s ease-out; padding-top: 0; padding-bottom: 0; }
    .row-edit-form.show-form .animasi-wrapper { max-height: 800px; padding-top: 12px; padding-bottom: 12px; }
</style>

<div class="mb-4">
    <a href="management_anaklansia.php" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="bi bi-arrow-left"></i> Kembali ke Menu Utama
    </a>
</div>

<div class="card shadow border-0 mb-4" style="border-radius: 15px; overflow: hidden;">
    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);">
        <h5 class="mb-0 fw-bold"><i class="bi bi-person-fill-add me-2"></i> Tambah Data Anak Baru</h5>
    </div>
    <div class="card-body bg-white">
        <form method="POST" action="">
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama Anak" required>
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-6"><input type="text" name="no_kk" class="form-control form-control-sm" placeholder="No. KK"></div>
                <div class="col-md-6"><input type="text" name="nik" class="form-control form-control-sm" placeholder="NIK"></div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-6"><input type="text" name="tempat_lahir" class="form-control form-control-sm" placeholder="Tempat Lahir"></div>
                <div class="col-md-6"><input type="date" name="tanggal_lahir" class="form-control form-control-sm" required></div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-6"><input type="text" name="nama_ayah" class="form-control form-control-sm" placeholder="Nama Ayah"></div>
                <div class="col-md-6"><input type="text" name="pekerjaan_ayah" class="form-control form-control-sm" placeholder="Pekerjaan Ayah"></div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-md-6"><input type="text" name="nama_ibu" class="form-control form-control-sm" placeholder="Nama Ibu"></div>
                <div class="col-md-6"><input type="text" name="pekerjaan_ibu" class="form-control form-control-sm" placeholder="Pekerjaan Ibu"></div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <textarea name="alamat_lengkap" class="form-control form-control-sm" placeholder="Alamat Lengkap (Nama Jalan, No. Rumah, dll)" rows="2"></textarea>
                </div>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="kelas" class="form-select form-select-sm border-danger" required>
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" name="simpan_anak" class="btn text-white btn-sm w-100 fw-bold py-2 mt-2" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; border-radius: 10px;">
                <i class="bi bi-save-fill me-2"></i> Simpan Data Anak
            </button>
        </form>
    </div>
</div>

<div class="card shadow border-0" style="border-radius: 15px; overflow: hidden;">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #232526 0%, #414345 100%);">
        <h5 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i> Daftar Data Anak Terdaftar</h5>
    </div>
    <div class="card-body">
        <div class="mb-3 input-group shadow-sm">
            <span class="input-group-text bg-danger text-white border-0"><i class="bi bi-search"></i></span>
            <input type="text" id="searchAnak" class="form-control border-danger" onkeyup="cariAnak()" placeholder="Ketik nama anak untuk mencari...">
        </div>

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-striped table-hover table-bordered align-middle text-center small" id="tabelAnak">
                <thead class="table-dark" style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tgl Lahir</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data_anak && $data_anak->num_rows > 0): while($row = $data_anak->fetch_assoc()): 
                        $is_this_editing = ($active_edit_anak_id === (int)$row['id'] && isset($_GET['tabel']) && $_GET['tabel'] === $row['tabel_asal']);
                    ?>
                        <tr class="item-anak" id="anak-row-<?= $row['id']; ?>">
                            <td class="text-start nama-anak fw-bold"><?= htmlspecialchars($row['nama'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['nik'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_lahir'] ?? ''); ?></td>
                            <td><span class="badge bg-danger"><?= strtoupper($row['tabel_asal']); ?></span></td>
                            <td>
                                <a href="?aksi_edit_anak=true&id=<?= $row['id']; ?>&tabel=<?= $row['tabel_asal']; ?>" class="btn btn-warning btn-sm py-1 px-2 text-dark">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <button onclick="hapusData(<?= $row['id']; ?>, '<?= $row['tabel_asal']; ?>')" class="btn btn-outline-danger btn-sm py-1 px-2">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                        <tr class="row-edit-form item-anak-form <?= $is_this_editing ? 'show-form' : ''; ?>" id="form-anak-<?= $row['id']; ?>">
                            <td colspan="5" class="p-0 text-start">
                                <div class="animasi-wrapper px-3">
                                    <div class="border border-warning rounded p-4 bg-white shadow-sm my-2">
                                        <h6 class="mb-3 fw-bold text-warning-emphasis"><i class="bi bi-pencil-square me-2"></i> Edit Data: <?= htmlspecialchars($row['nama'] ?? ''); ?></h6>
                                        <form method="POST" action="">
                                            <input type="hidden" name="id_anak_edit" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="tabel_asal_lama" value="<?= $row['tabel_asal']; ?>">
                                            
                                            <div class="row g-2 mb-2">
                                                <div class="col-12">
                                                    <label class="fw-bold small mb-1 text-muted">Nama Anak</label>
                                                    <input type="text" name="nama" value="<?= htmlspecialchars($row['nama'] ?? ''); ?>" class="form-control form-control-sm" required>
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">No. KK</label>
                                                    <input type="text" name="no_kk" value="<?= htmlspecialchars($row['no_kk'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">NIK</label>
                                                    <input type="text" name="nik" value="<?= htmlspecialchars($row['nik'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($row['tempat_lahir'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" value="<?= $row['tanggal_lahir'] ?? ''; ?>" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Nama Ayah</label>
                                                    <input type="text" name="nama_ayah" value="<?= htmlspecialchars($row['nama_ayah'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Pekerjaan Ayah</label>
                                                    <input type="text" name="pekerjaan_ayah" value="<?= htmlspecialchars($row['pekerjaan_ayah'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Nama Ibu</label>
                                                    <input type="text" name="nama_ibu" value="<?= htmlspecialchars($row['nama_ibu'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="fw-bold small mb-1 text-muted">Pekerjaan Ibu</label>
                                                    <input type="text" name="pekerjaan_ibu" value="<?= htmlspecialchars($row['pekerjaan_ibu'] ?? ''); ?>" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-12">
                                                    <label class="fw-bold small mb-1 text-muted">Alamat Lengkap</label>
                                                    <textarea name="alamat_lengkap" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($row['alamat_lengkap'] ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 mt-3">
                                                <button type="submit" name="simpan_anak" class="btn btn-warning btn-sm text-dark flex-grow-1 fw-bold">
                                                    <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                                                </button>
                                                <a href="?" class="btn btn-secondary btn-sm">
                                                    <i class="bi bi-x-circle me-1"></i> Tutup
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="5" class="text-muted py-4">Belum ada data anak di database.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// FUNGSI PENCARIAN
function cariAnak() {
    let input = document.getElementById("searchAnak").value.toLowerCase();
    let rows = document.getElementsByClassName("item-anak");
    let forms = document.getElementsByClassName("item-anak-form");
    
    for (let i = 0; i < rows.length; i++) {
        let nama = rows[i].getElementsByClassName("nama-anak")[0].innerText.toLowerCase().trim();
        if (nama.includes(input)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
            if(forms[i]) forms[i].classList.remove("show-form");
        }
    }
}

// SCROLL OTOMATIS SAAT EDIT DIKLIK
document.addEventListener("DOMContentLoaded", function() {
    let activeForm = document.querySelector(".item-anak-form.show-form");
    if (activeForm) {
        setTimeout(() => { activeForm.scrollIntoView({ behavior: "smooth", block: "center" }); }, 200);
    }
});

// POPUP KONFIRMASI HAPUS (SweetAlert2)
function hapusData(id, tabel) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data anak ini tidak bisa dikembalikan setelah dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // JS DIUBAH AGAR MENGARAH KE FILE INI SENDIRI
            window.location.href = `?hapus_anak=${id}&tabel=${tabel}`;
        }
    })
}
</script>

<?php if (!empty($pesan_sukses)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            html: '<?= $pesan_sukses; ?>',
            icon: 'success',
            confirmButtonColor: '#198754',
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
<?php endif; ?>

<?php if (!empty($pesan_warning)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Peringatan!',
            html: '<?= $pesan_warning; ?>',
            icon: 'warning',
            confirmButtonColor: '#ffc107',
            timer: 4500,
            timerProgressBar: true
        });
    });
</script>
<?php endif; ?>

<?php 
// Panggil footer bawaan untuk menutup tag col-md-10, row, container, dan body.
include 'footer.php'; 
?>