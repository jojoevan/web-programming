-- Database untuk aplikasi Pendaftaran Siswa Baru
CREATE DATABASE IF NOT EXISTS pendaftaran_siswa;
USE pendaftaran_siswa;

CREATE TABLE calon_siswa (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(64) NOT NULL,
  alamat VARCHAR(255) NOT NULL,
  jenis_kelamin VARCHAR(16) NOT NULL,
  agama VARCHAR(16) NOT NULL,
  sekolah_asal VARCHAR(64) NOT NULL
);

INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES
('Priscili Ayuliani', 'Jl. Mangga No. 3, Mataram', 'perempuan', 'Islam', 'SMPN 32 Ampenan'),
('Budi Santoso', 'Jl. Melati No. 10, Surabaya', 'laki-laki', 'Kristen', 'SMPN 5 Surabaya'),
('Made Wirawan', 'Jl. Kenanga No. 7, Denpasar', 'laki-laki', 'Hindu', 'SMPN 1 Denpasar');
