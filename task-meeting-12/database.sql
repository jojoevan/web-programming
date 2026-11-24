-- Database PPDB Online SMK Nusantara (MVP Tahap 1 + upload pas foto)
CREATE DATABASE IF NOT EXISTS db_ppdb_smk;
USE db_ppdb_smk;

-- Akun login (admin dan calon siswa)
CREATE TABLE users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'siswa') NOT NULL DEFAULT 'siswa'
);

-- Biodata calon siswa (1 akun = 1 biodata)
CREATE TABLE siswa (
  id_siswa INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL UNIQUE,
  nisn CHAR(10) NOT NULL UNIQUE,
  nama_lengkap VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('Laki-laki', 'Perempuan') NULL,
  tempat_lahir VARCHAR(50) NULL,
  tanggal_lahir DATE NULL,
  alamat VARCHAR(255) NULL,
  asal_sekolah VARCHAR(100) NULL,
  no_hp VARCHAR(20) NOT NULL,
  foto VARCHAR(255) NULL, -- nama file pas foto di folder uploads/foto/
  FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- Program keahlian
CREATE TABLE jurusan (
  id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
  kode_jurusan VARCHAR(10) NOT NULL UNIQUE,
  nama_jurusan VARCHAR(100) NOT NULL,
  kuota INT NOT NULL,
  deskripsi VARCHAR(255) NULL,
  aktif TINYINT(1) NOT NULL DEFAULT 1
);

-- Pendaftaran (1 siswa = 1 pendaftaran per tahun ajaran)
CREATE TABLE pendaftaran (
  id_pendaftaran INT AUTO_INCREMENT PRIMARY KEY,
  id_siswa INT NOT NULL,
  id_jurusan INT NOT NULL,
  tahun_ajaran VARCHAR(9) NOT NULL,
  tanggal_daftar DATETIME NOT NULL,
  status ENUM('Menunggu', 'Diverifikasi', 'Ditolak') NOT NULL DEFAULT 'Menunggu',
  UNIQUE (id_siswa, tahun_ajaran),
  FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
  FOREIGN KEY (id_jurusan) REFERENCES jurusan(id_jurusan) ON DELETE RESTRICT
);

-- Riwayat perubahan status (id_admin kosong = perubahan oleh siswa)
CREATE TABLE riwayat_status (
  id_riwayat INT AUTO_INCREMENT PRIMARY KEY,
  id_pendaftaran INT NOT NULL,
  status_sebelumnya VARCHAR(20) NULL,
  status_baru VARCHAR(20) NOT NULL,
  catatan VARCHAR(255) NULL,
  id_admin INT NULL,
  tanggal_perubahan DATETIME NOT NULL,
  FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id_pendaftaran) ON DELETE CASCADE,
  FOREIGN KEY (id_admin) REFERENCES users(id_user) ON DELETE SET NULL
);

-- ===================== DATA CONTOH =====================
-- Semua akun contoh memakai password: ppdb2026

INSERT INTO users (id_user, nama, email, password, role) VALUES
(1, 'Admin PPDB', 'admin@smknusantara.sch.id', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'admin'),
(2, 'Rizky Pratama', 'rizky.pratama@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(3, 'Siti Nurhaliza', 'siti.nurhaliza@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(4, 'Bagus Setiawan', 'bagus.setiawan@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(5, 'Dewi Lestari', 'dewi.lestari@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(6, 'Ahmad Fauzi', 'ahmad.fauzi@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(7, 'Rina Kartika', 'rina.kartika@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa'),
(8, 'Putri Ayu Wulandari', 'putri.ayu@gmail.com', '$2y$10$eQ7PDE47qEokKAAPU0OIm.0N7CPy4yj0wANBo/Q/crGe7pXgV3Bmu', 'siswa');

INSERT INTO siswa (id_siswa, id_user, nisn, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, asal_sekolah, no_hp, foto) VALUES
(1, 2, '0101234561', 'Rizky Pratama', 'Laki-laki', 'Sidoarjo', '2011-03-14', 'Jl. Raya Gedangan No. 21, Sidoarjo', 'SMPN 1 Sidoarjo', '081234567801', 'foto-1-1780275900.jpg'),
(2, 3, '0101234562', 'Siti Nurhaliza', 'Perempuan', 'Surabaya', '2011-07-02', 'Jl. Ketintang Baru No. 5, Surabaya', 'SMPN 3 Surabaya', '081234567802', 'foto-2-1780371000.jpg'),
(3, 4, '0101234563', 'Bagus Setiawan', 'Laki-laki', 'Gresik', '2010-11-25', 'Jl. Veteran No. 48, Gresik', 'MTsN 1 Gresik', '081234567803', 'foto-3-1780379700.jpg'),
(4, 5, '0101234564', 'Dewi Lestari', 'Perempuan', 'Sidoarjo', '2011-01-19', 'Perum Pondok Jati Blok C-7, Sidoarjo', 'SMPN 2 Sidoarjo', '081234567804', 'foto-4-1780452600.jpg'),
(5, 6, '0101234565', 'Ahmad Fauzi', 'Laki-laki', 'Mojokerto', '2011-05-30', 'Jl. Majapahit No. 112, Mojokerto', 'SMP Muhammadiyah 1 Mojokerto', '081234567805', 'foto-5-1780576500.jpg'),
(6, 7, '0101234566', 'Rina Kartika', 'Perempuan', 'Sidoarjo', '2011-09-08', 'Jl. Taman Pinang Indah No. 9, Sidoarjo', 'SMPN 4 Sidoarjo', '081234567806', 'foto-6-1780620300.jpg'),
(7, 8, '0101234567', 'Putri Ayu Wulandari', NULL, NULL, NULL, NULL, NULL, '081234567807', NULL);

INSERT INTO jurusan (id_jurusan, kode_jurusan, nama_jurusan, kuota, deskripsi, aktif) VALUES
(1, 'RPL', 'Rekayasa Perangkat Lunak', 36, 'Pemrograman, basis data, dan pengembangan aplikasi.', 1),
(2, 'TKJ', 'Teknik Komputer dan Jaringan', 36, 'Perakitan komputer, jaringan, dan administrasi server.', 1),
(3, 'AKL', 'Akuntansi dan Keuangan Lembaga', 36, 'Pencatatan keuangan, perpajakan, dan aplikasi akuntansi.', 1),
(4, 'TBG', 'Tata Boga', 36, 'Pengolahan makanan, pastry, dan manajemen dapur.', 1),
(5, 'TKR', 'Teknik Kendaraan Ringan', 36, 'Perawatan dan perbaikan mobil.', 1);

INSERT INTO pendaftaran (id_pendaftaran, id_siswa, id_jurusan, tahun_ajaran, tanggal_daftar, status) VALUES
(1, 1, 1, '2026/2027', '2026-06-01 08:15:00', 'Diverifikasi'),
(2, 2, 3, '2026/2027', '2026-06-02 10:40:00', 'Menunggu'),
(3, 3, 5, '2026/2027', '2026-06-02 13:05:00', 'Ditolak'),
(4, 4, 4, '2026/2027', '2026-06-03 09:20:00', 'Diverifikasi'),
(5, 5, 2, '2026/2027', '2026-06-04 19:45:00', 'Menunggu'),
(6, 6, 1, '2026/2027', '2026-06-05 07:55:00', 'Menunggu');

INSERT INTO riwayat_status (id_pendaftaran, status_sebelumnya, status_baru, catatan, id_admin, tanggal_perubahan) VALUES
(1, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-01 08:15:00'),
(2, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-02 10:40:00'),
(3, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-02 13:05:00'),
(4, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-03 09:20:00'),
(5, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-04 19:45:00'),
(6, NULL, 'Menunggu', 'Pendaftaran dikirim.', NULL, '2026-06-05 07:55:00'),
(1, 'Menunggu', 'Diverifikasi', 'Data lengkap dan sesuai.', 1, '2026-06-03 10:00:00'),
(3, 'Menunggu', 'Ditolak', 'Tanggal lahir tidak sesuai akta kelahiran. Mohon perbaiki biodata.', 1, '2026-06-03 10:30:00'),
(4, 'Menunggu', 'Diverifikasi', 'Data lengkap dan sesuai.', 1, '2026-06-04 08:10:00');
