-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql210.infinityfree.com
-- Waktu pembuatan: 18 Nov 2026 pada 23.41
-- Versi server: 11.4.13-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42180640_santriq_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `asal_kelas` varchar(20) NOT NULL,
  `mata_pelajaran` varchar(100) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status_hadir` varchar(20) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pelajaran`
--

CREATE TABLE `jadwal_pelajaran` (
  `id_jadwal` int(11) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `mata_pelajaran` varchar(100) NOT NULL,
  `ruangan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_smp`
--

CREATE TABLE `jadwal_smp` (
  `id_jadwal` int(11) NOT NULL,
  `tingkat_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `mata_pelajaran` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas1`
--

CREATE TABLE `kelas1` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_kk` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `no_hp_keluarga` varchar(20) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `status_anak` varchar(50) DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kelas1`
--

INSERT INTO `kelas1` (`id`, `nama`, `no_kk`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_hp_keluarga`, `alamat_lengkap`, `status_anak`, `usia`, `username`, `password`) VALUES
(1, 'ucup', '', '', '', '2026-06-05', NULL, '', '', '', '', '', '', NULL, NULL, '', ''),
(2, 'Siti Aisyah', '3201010101010002', '3201011002190002', 'Jakarta', '2019-02-10', 'P', 'Andi Wijaya', 'PNS', 'Dewi Lestari', 'Guru', '081234567891', 'Jl. Mawar No. 5, Bekasi', 'Aktif', 7, '', ''),
(3, 'Muhammad Rizky', '3201010101010003', '3201012008190003', 'Bogor', '2019-08-20', 'L', 'Hendra Kusuma', 'Pedagang', 'Ratna Sari', 'Ibu Rumah Tangga', '081234567892', 'Jl. Anggrek No. 12, Bekasi', 'Aktif', 7, '', ''),
(4, 'Fatima Zahra', '3201010101010004', '3201010501190004', 'Bandung', '2019-01-05', 'P', 'Joko Susilo', 'Karyawan Swasta', 'Eka Putri', 'Bidan', '081234567893', 'Jl. Tulip No. 8, Bekasi', 'Aktif', 7, '', ''),
(5, 'Fikri Haikal', '3201010101010005', '3201012503190005', 'Bekasi', '2019-03-25', 'L', 'Rahmat Hidayat', 'TNI', 'Ani Nuraini', 'Ibu Rumah Tangga', '081234567894', 'Jl. Kamboja No. 3, Bekasi', 'Aktif', 7, '', ''),
(6, 'Nurul Huda', '3201010101010006', '3201011211180006', 'Cirebon', '2018-11-12', 'P', 'Asep Saepudin', 'Petani', 'Lia Marlina', 'Ibu Rumah Tangga', '081234567895', 'Jl. Kenanga No. 2, Bekasi', 'Aktif', 7, '', ''),
(7, 'Bagas Pratama', '3201010101010007', '3201013006190007', 'Bekasi', '2019-06-30', 'L', 'Dedi Kurniawan', 'Buruh', 'Susi Susanti', 'Pedagang', '081234567896', 'Jl. Dahlia No. 4, Bekasi', 'Aktif', 7, '', ''),
(8, 'Zahra Amelia', '3201010101010008', '3201011809190008', 'Tangerang', '2019-09-18', 'P', 'Fajar Sidik', 'Supir', 'Maya Indah', 'Ibu Rumah Tangga', '081234567897', 'Jl. Flamboyan No. 9, Bekasi', 'Aktif', 7, '', ''),
(9, 'Yusuf Ibrahim', '3201010101010009', '3201010204190009', 'Bekasi', '2019-04-02', 'L', 'Ridwan Kamil', 'Arsitek', 'Atalia Praratya', 'Wiraswasta', '081234567898', 'Jl. Melati No. 10, Bekasi', 'Aktif', 7, '', ''),
(10, 'Khansa Qonita', '3201010101010010', '3201012212180010', 'Semarang', '2018-12-22', 'P', 'Taufik Hidayat', 'Atlet', 'Ami Gumelar', 'Ibu Rumah Tangga', '081234567899', 'Jl. Sakura No. 7, Bekasi', 'Aktif', 7, '', ''),
(11, 'Rafly Ramadhan', '3201010101010011', '3201011407190011', 'Bekasi', '2019-07-14', 'L', 'Wahyu Utama', 'Dokter', 'Sari Mulyani', 'Dokter', '081234567800', 'Jl. Mawar No. 15, Bekasi', 'Aktif', 7, '', ''),
(12, 'Keysha Azzahra', '3201010101010012', '3201010805190012', 'Surabaya', '2019-05-08', 'P', 'Bambang Pamungkas', 'Pelatih', 'Tribuana', 'Ibu Rumah Tangga', '081234567801', 'Jl. Anggrek No. 20, Bekasi', 'Aktif', 7, '', ''),
(13, 'Daffa Al-Fariz', '3201010101010013', '3201013001190013', 'Bekasi', '2019-01-30', 'L', 'Hendri Wijaya', 'Wiraswasta', 'Putri Diana', 'Ibu Rumah Tangga', '081234567802', 'Jl. Tulip No. 21, Bekasi', 'Aktif', 7, '', ''),
(14, 'Nadia Safitri', '3201010101010014', '3201011110190014', 'Malang', '2019-10-11', 'P', 'Gatot Subroto', 'Purnawirawan', 'Siti Rahma', 'Ibu Rumah Tangga', '081234567803', 'Jl. Kamboja No. 11, Bekasi', 'Aktif', 7, '', ''),
(15, 'Rayyan Al-Ghifari', '3201010101010015', '3201012502190015', 'Bekasi', '2019-02-25', 'L', 'Fahmi Idris', 'Pengusaha', 'Nadia Mulya', 'Presenter', '081234567804', 'Jl. Kenanga No. 5, Bekasi', 'Aktif', 7, '', ''),
(16, 'Ahmad Fauzi', '3201010101010001', '3201011505190001', 'Bekasi', '2019-05-15', 'L', 'Yanto', 'Wiraswasta', 'Mia', 'Ibu Rumah Tangga', '081234567890', 'Jl. Melati No. 1, Bekasi', 'Aktif', 7, 'fauzi', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas2`
--

CREATE TABLE `kelas2` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_kk` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `no_hp_keluarga` varchar(20) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `status_anak` varchar(50) DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kelas2`
--

INSERT INTO `kelas2` (`id`, `nama`, `no_kk`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_hp_keluarga`, `alamat_lengkap`, `status_anak`, `usia`, `username`, `password`) VALUES
(16, 'Bima Sakti', '3201010101010016', '3201010505190016', 'Bekasi', '2019-05-05', 'L', 'Suryo', 'Karyawan', 'Laras', 'Ibu Rumah Tangga', '081234567810', 'Jl. Garuda No. 1, Bekasi', 'Aktif', 7, '', ''),
(17, 'Citra Lestari', '3201010101010017', '3201011206190017', 'Jakarta', '2019-06-12', 'P', 'Wawan', 'Pedagang', 'Sari', 'Guru', '081234567811', 'Jl. Merpati No. 3, Bekasi', 'Aktif', 7, '', ''),
(18, 'Dian Pratama', '3201010101010018', '3201012007190018', 'Solo', '2019-07-20', 'L', 'Agung', 'PNS', 'Dewi', 'Perawat', '081234567812', 'Jl. Rajawali No. 8, Bekasi', 'Aktif', 7, '', ''),
(19, 'Eka Wahyuni', '3201010101010019', '3201010308190019', 'Bekasi', '2019-08-03', 'P', 'Budi', 'Wiraswasta', 'Ani', 'Ibu Rumah Tangga', '081234567813', 'Jl. Elang No. 5, Bekasi', 'Aktif', 7, '', ''),
(20, 'Fajar Ramadhan', '3201010101010020', '3201011509190020', 'Ciamis', '2019-09-15', 'L', 'Dadang', 'Buruh', 'Euis', 'Pedagang', '081234567814', 'Jl. Pipit No. 2, Bekasi', 'Aktif', 7, '', ''),
(21, 'Gina Fitriani', '3201010101010021', '3201012210190021', 'Bekasi', '2019-10-22', 'P', 'Hendra', 'Karyawan', 'Tati', 'Ibu Rumah Tangga', '081234567815', 'Jl. Kenari No. 9, Bekasi', 'Aktif', 7, '', ''),
(22, 'Hadi Saputra', '3201010101010022', '3201010111190022', 'Medan', '2019-11-01', 'L', 'Joko', 'Supir', 'Siska', 'Karyawan', '081234567816', 'Jl. Nuri No. 4, Bekasi', 'Aktif', 7, '', ''),
(23, 'Indah Permata', '3201010101010023', '3201011012190023', 'Bekasi', '2019-12-10', 'P', 'Kusuma', 'Arsitek', 'Rina', 'Arsitek', '081234567817', 'Jl. Parkit No. 7, Bekasi', 'Aktif', 7, '', ''),
(24, 'Jaka Sembung', '3201010101010024', '3201011801200024', 'Palembang', '2020-01-18', 'L', 'Lutfi', 'Wiraswasta', 'Mila', 'Ibu Rumah Tangga', '081234567818', 'Jl. Gelatik No. 6, Bekasi', 'Aktif', 6, '', ''),
(25, 'Kirana Putri', '3201010101010025', '3201012502200025', 'Bekasi', '2020-02-25', 'P', 'Maman', 'Tukang', 'Yanti', 'Ibu Rumah Tangga', '081234567819', 'Jl. Walet No. 10, Bekasi', 'Aktif', 6, '', ''),
(26, 'Lutfi Aziz', '3201010101010026', '3201010503200026', 'Padang', '2020-03-05', 'L', 'Nurdin', 'PNS', 'Wati', 'Guru', '081234567820', 'Jl. Beo No. 3, Bekasi', 'Aktif', 6, '', ''),
(27, 'Maya Sari', '3201010101010027', '3201011204200027', 'Bekasi', '2020-04-12', 'P', 'Oky', 'Wiraswasta', 'Sinta', 'Wiraswasta', '081234567821', 'Jl. Kakak Tua No. 2, Bekasi', 'Aktif', 6, '', ''),
(28, 'Naufal Hakim', '3201010101010028', '3201012005200028', 'Bandung', '2020-05-20', 'L', 'Pendi', 'Buruh', 'Desi', 'Ibu Rumah Tangga', '081234567822', 'Jl. Kakatua No. 5, Bekasi', 'Aktif', 6, '', ''),
(29, 'Olivia Cantika', '3201010101010029', '3201010306200029', 'Bekasi', '2020-06-03', 'P', 'Rahmat', 'Dokter', 'Fitri', 'Dokter', '081234567823', 'Jl. Kenari No. 11, Bekasi', 'Aktif', 6, '', ''),
(30, 'Putra Pratama', '3201010101010030', '3201011507200030', 'Surabaya', '2020-07-15', 'L', 'Sani', 'Wiraswasta', 'Lina', 'Ibu Rumah Tangga', '081234567824', 'Jl. Prenjak No. 8, Bekasi', 'Aktif', 6, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas3`
--

CREATE TABLE `kelas3` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_kk` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `no_hp_keluarga` varchar(20) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `status_anak` varchar(50) DEFAULT NULL,
  `usia` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kelas3`
--

INSERT INTO `kelas3` (`id`, `nama`, `no_kk`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `no_hp_keluarga`, `alamat_lengkap`, `status_anak`, `usia`, `username`, `password`) VALUES
(31, 'Qori Afifah', '3201010101010031', '3201010108200031', 'Bekasi', '2020-08-01', 'P', 'Taufan', 'Wiraswasta', 'Dina', 'Ibu Rumah Tangga', '081234567825', 'Jl. Merpati No. 12, Bekasi', 'Aktif', 6, '', ''),
(32, 'Raka Dirgantara', '3201010101010032', '3201011009200032', 'Cirebon', '2020-09-10', 'L', 'Ujang', 'Pedagang', 'Siti', 'Pedagang', '081234567826', 'Jl. Elang No. 4, Bekasi', 'Aktif', 6, '', ''),
(33, 'Salsa Bila', '3201010101010033', '3201012010200033', 'Bekasi', '2020-10-20', 'P', 'Vino', 'Karyawan', 'Rara', 'Ibu Rumah Tangga', '081234567827', 'Jl. Rajawali No. 9, Bekasi', 'Aktif', 6, '', ''),
(34, 'Tio Nugroho', '3201010101010034', '3201010511200034', 'Bandung', '2020-11-05', 'L', 'Wawan', 'Supir', 'Eka', 'Ibu Rumah Tangga', '081234567828', 'Jl. Garuda No. 15, Bekasi', 'Aktif', 6, '', ''),
(35, 'Utari Dewi', '3201010101010035', '3201011512200035', 'Bekasi', '2020-12-15', 'P', 'Xavier', 'Arsitek', 'Yuni', 'Guru', '081234567829', 'Jl. Pipit No. 3, Bekasi', 'Aktif', 6, '', ''),
(36, 'Vano Septian', '3201010101010036', '3201010101210036', 'Semarang', '2021-01-01', 'L', 'Yudi', 'TNI', 'Zahra', 'Ibu Rumah Tangga', '081234567830', 'Jl. Kenari No. 7, Bekasi', 'Aktif', 5, '', ''),
(37, 'Wulan Dari', '3201010101010037', '3201011002210037', 'Bekasi', '2021-02-10', 'P', 'Ahmad', 'Wiraswasta', 'Bunga', 'Wiraswasta', '081234567831', 'Jl. Nuri No. 1, Bekasi', 'Aktif', 5, '', ''),
(38, 'Xavier Putra', '3201010101010038', '3201012003210038', 'Jakarta', '2021-03-20', 'L', 'Budi', 'Dokter', 'Citra', 'Dokter', '081234567832', 'Jl. Parkit No. 2, Bekasi', 'Aktif', 5, '', ''),
(39, 'Yumna Azzahra', '3201010101010039', '3201010504210039', 'Bekasi', '2021-04-05', 'P', 'Dedi', 'Buruh', 'Euis', 'Ibu Rumah Tangga', '081234567833', 'Jl. Gelatik No. 11, Bekasi', 'Aktif', 5, '', ''),
(40, 'Zidan Al-Ghifari', '3201010101010040', '3201011505210040', 'Padang', '2021-05-15', 'L', 'Fahmi', 'Wiraswasta', 'Gina', 'Ibu Rumah Tangga', '081234567834', 'Jl. Walet No. 6, Bekasi', 'Aktif', 5, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kesehatan`
--

CREATE TABLE `kesehatan` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `asal_kelas` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `keluhan` text NOT NULL,
  `penanganan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `asal_kelas` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `nama_mapel`, `asal_kelas`) VALUES
(1, 'Matematika', ''),
(2, 'Fiqih', ''),
(3, 'Bahasa Arab', ''),
(4, 'Membaca & Menulis', 'kelas1'),
(5, 'Berhitung Dasar', 'kelas1'),
(6, 'Pendidikan Agama Islam', 'kelas1'),
(7, 'Bahasa Indonesia', 'kelas1'),
(8, 'Aqidah Akhlak', 'kelas1'),
(9, 'Fiqih Ibadah', 'kelas1'),
(10, 'Sejarah Kebudayaan Islam', 'kelas1'),
(11, 'Matematika Lanjut', 'kelas2'),
(12, 'Ilmu Pengetahuan Alam', 'kelas2'),
(13, 'Ilmu Pengetahuan Sosial', 'kelas2'),
(14, 'Bahasa Arab Dasar', 'kelas2'),
(15, 'Al-Quran Hadits', 'kelas2'),
(16, 'Fiqih Lanjutan', 'kelas2'),
(17, 'Pancasila & Kewarganegaraan', 'kelas2'),
(18, 'Persiapan Ujian Akhir', 'kelas3'),
(19, 'Bahasa Inggris', 'kelas3'),
(20, 'Aqidah Akhlak Pendalaman', 'kelas3'),
(21, 'Fiqih Muamalah', 'kelas3'),
(22, 'Sejarah Indonesia', 'kelas3'),
(23, 'Al-Quran Hadits Tahfidz', 'kelas3'),
(24, 'Bahasa Arab Percakapan', 'kelas3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `asal_kelas` varchar(20) NOT NULL,
  `mata_pelajaran` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `asal_kelas` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_pelanggaran` varchar(100) NOT NULL,
  `sanksi` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_kk` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `usia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','staff') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$vFr5R2H19D7HcJu8R/kkrO8HrPHeophO0wZeFk9QteIS9fvvDEC4a', 'super_admin'),
(2, 'guru', '$2y$10$T8VqUoE1hKbybS0Wb2Y0Oe6WJclvF9.Zg1lby8C6UptAehD7Yw/XW$2y$10$vFr5R2H19D7HcJu8R/kkrO8HrPHeophO0wZeFk9QteIS9fvvDEC4a', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `jadwal_smp`
--
ALTER TABLE `jadwal_smp`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `kelas1`
--
ALTER TABLE `kelas1`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas2`
--
ALTER TABLE `kelas2`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas3`
--
ALTER TABLE `kelas3`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kesehatan`
--
ALTER TABLE `kesehatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_pelajaran`
--
ALTER TABLE `jadwal_pelajaran`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_smp`
--
ALTER TABLE `jadwal_smp`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas1`
--
ALTER TABLE `kelas1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kelas2`
--
ALTER TABLE `kelas2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `kelas3`
--
ALTER TABLE `kelas3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `kesehatan`
--
ALTER TABLE `kesehatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
