<?php
// Dipanggil di awal setiap halaman: session, koneksi database, dan fungsi bantu
session_start();
require_once __DIR__ . '/../config/database.php';

// Escape output agar aman dari XSS
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// Pesan singkat yang tampil sekali setelah redirect
function set_pesan($tipe, $isi)
{
    $_SESSION['pesan'] = ['tipe' => $tipe, 'isi' => $isi];
}

function tampil_pesan()
{
    if (isset($_SESSION['pesan'])) {
        $p = $_SESSION['pesan'];
        unset($_SESSION['pesan']);
        echo '<div class="alert alert-' . e($p['tipe']) . '">' . e($p['isi']) . '</div>';
    }
}

// Halaman hanya boleh dibuka oleh pengguna yang login dengan role tertentu
function wajib_login($role)
{
    if (!isset($_SESSION['id_user'])) {
        set_pesan('error', 'Silakan login terlebih dahulu.');
        header('Location: ../auth/login.php');
        exit;
    }
    if ($_SESSION['role'] !== $role) {
        header('Location: ../' . $_SESSION['role'] . '/dashboard.php');
        exit;
    }
}

function nomor_pendaftaran($id_pendaftaran)
{
    return 'PPDB-' . substr(TAHUN_AJARAN, 0, 4) . '-' . str_pad($id_pendaftaran, 4, '0', STR_PAD_LEFT);
}

function badge_status($status)
{
    if (!$status) {
        return '<span class="badge badge-abu">Belum Mendaftar</span>';
    }
    $warna = ['Menunggu' => 'kuning', 'Diverifikasi' => 'hijau', 'Ditolak' => 'merah'];
    return '<span class="badge badge-' . $warna[$status] . '">' . e($status) . '</span>';
}

function tanggal_indo($tanggal)
{
    if (!$tanggal) {
        return '-';
    }
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $t = strtotime($tanggal);
    return date('j', $t) . ' ' . $bulan[(int) date('n', $t)] . ' ' . date('Y', $t);
}

// Biodata siswa berdasarkan id_user
function ambil_siswa($pdo, $id_user)
{
    $stmt = $pdo->prepare("SELECT s.*, u.email FROM siswa s JOIN users u ON u.id_user = s.id_user WHERE s.id_user = ?");
    $stmt->execute([$id_user]);
    return $stmt->fetch();
}

// Pendaftaran siswa pada tahun ajaran ini (false jika belum mendaftar)
function ambil_pendaftaran($pdo, $id_siswa)
{
    $stmt = $pdo->prepare("SELECT p.*, j.kode_jurusan, j.nama_jurusan FROM pendaftaran p
        JOIN jurusan j ON j.id_jurusan = p.id_jurusan
        WHERE p.id_siswa = ? AND p.tahun_ajaran = ?");
    $stmt->execute([$id_siswa, TAHUN_AJARAN]);
    return $stmt->fetch();
}

// Biodata dianggap lengkap jika semua isian dan pas foto sudah ada
function biodata_lengkap($siswa)
{
    $wajib = ['nisn', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah', 'no_hp', 'foto'];
    foreach ($wajib as $kolom) {
        if (empty($siswa[$kolom])) {
            return false;
        }
    }
    return true;
}

// Siswa boleh mengubah data selama belum diverifikasi
function boleh_diubah($pendaftaran)
{
    return !$pendaftaran || $pendaftaran['status'] !== 'Diverifikasi';
}

// Mencatat perubahan status ke tabel riwayat_status
function catat_status($pdo, $id_pendaftaran, $lama, $baru, $catatan, $id_admin = null)
{
    $stmt = $pdo->prepare("INSERT INTO riwayat_status (id_pendaftaran, status_sebelumnya, status_baru, catatan, id_admin, tanggal_perubahan)
        VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$id_pendaftaran, $lama, $baru, $catatan, $id_admin]);
}

// Jika siswa memperbaiki data setelah ditolak, status kembali ke Menunggu
function kembalikan_ke_menunggu($pdo, $pendaftaran)
{
    if ($pendaftaran && $pendaftaran['status'] === 'Ditolak') {
        $pdo->prepare("UPDATE pendaftaran SET status = 'Menunggu' WHERE id_pendaftaran = ?")
            ->execute([$pendaftaran['id_pendaftaran']]);
        catat_status($pdo, $pendaftaran['id_pendaftaran'], 'Ditolak', 'Menunggu', 'Data diperbaiki oleh siswa.');
    }
}

// Validasi form biodata, mengembalikan [data, daftar error]
function validasi_biodata($pdo, $input, $id_siswa)
{
    $data = [
        'nisn'          => trim($input['nisn'] ?? ''),
        'nama_lengkap'  => trim($input['nama_lengkap'] ?? ''),
        'jenis_kelamin' => $input['jenis_kelamin'] ?? '',
        'tempat_lahir'  => trim($input['tempat_lahir'] ?? ''),
        'tanggal_lahir' => $input['tanggal_lahir'] ?? '',
        'alamat'        => trim($input['alamat'] ?? ''),
        'asal_sekolah'  => trim($input['asal_sekolah'] ?? ''),
        'no_hp'         => trim($input['no_hp'] ?? ''),
    ];
    $error = [];

    if (!preg_match('/^[0-9]{10}$/', $data['nisn'])) {
        $error[] = 'NISN harus 10 digit angka.';
    } else {
        $cek = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE nisn = ? AND id_siswa <> ?");
        $cek->execute([$data['nisn'], $id_siswa]);
        if ($cek->fetchColumn() > 0) {
            $error[] = 'NISN sudah dipakai siswa lain.';
        }
    }
    if ($data['nama_lengkap'] === '') {
        $error[] = 'Nama lengkap wajib diisi.';
    }
    if (!in_array($data['jenis_kelamin'], ['Laki-laki', 'Perempuan'])) {
        $error[] = 'Pilih jenis kelamin.';
    }
    if ($data['tempat_lahir'] === '') {
        $error[] = 'Tempat lahir wajib diisi.';
    }
    $tgl = DateTime::createFromFormat('Y-m-d', $data['tanggal_lahir']);
    if (!$tgl || $tgl->format('Y-m-d') !== $data['tanggal_lahir']) {
        $error[] = 'Tanggal lahir tidak valid.';
    }
    if ($data['alamat'] === '') {
        $error[] = 'Alamat wajib diisi.';
    }
    if ($data['asal_sekolah'] === '') {
        $error[] = 'Asal sekolah wajib diisi.';
    }
    if (!preg_match('/^[0-9+() -]{9,18}$/', $data['no_hp'])) {
        $error[] = 'Nomor HP tidak valid.';
    }

    return [$data, $error];
}

function simpan_biodata($pdo, $data, $id_siswa, $id_user)
{
    $stmt = $pdo->prepare("UPDATE siswa SET nisn = ?, nama_lengkap = ?, jenis_kelamin = ?, tempat_lahir = ?,
        tanggal_lahir = ?, alamat = ?, asal_sekolah = ?, no_hp = ? WHERE id_siswa = ?");
    $stmt->execute([
        $data['nisn'], $data['nama_lengkap'], $data['jenis_kelamin'], $data['tempat_lahir'],
        $data['tanggal_lahir'], $data['alamat'], $data['asal_sekolah'], $data['no_hp'], $id_siswa,
    ]);
    // Nama di tabel users ikut disamakan
    $pdo->prepare("UPDATE users SET nama = ? WHERE id_user = ?")->execute([$data['nama_lengkap'], $id_user]);
}

// ===================== PAS FOTO =====================

// Folder tempat file pas foto disimpan. Database hanya menyimpan nama filenya.
define('FOLDER_FOTO', __DIR__ . '/../uploads/foto/');
define('MAKS_UKURAN_FOTO', 1024 * 1024); // 1 MB

// Tampilkan pas foto ukuran 3x4, atau kotak kosong jika belum ada foto
function tampil_foto($foto, $kelas = '')
{
    if (!$foto) {
        return '<div class="pas-foto kosong ' . $kelas . '">Belum ada<br>pas foto</div>';
    }
    return '<img src="../uploads/foto/' . e($foto) . '" alt="Pas foto" class="pas-foto ' . $kelas . '">';
}

// Validasi file pas foto dari $_FILES['foto'], mengembalikan pesan error ('' jika valid).
// $wajib = true jika siswa belum punya foto sama sekali.
function validasi_foto($file, $wajib)
{
    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return $wajib ? 'Pas foto wajib diupload.' : '';
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > MAKS_UKURAN_FOTO) {
        return 'Ukuran pas foto maksimal 1 MB.';
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'Pas foto gagal diupload, silakan coba lagi.';
    }

    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, ['jpg', 'jpeg', 'png'])) {
        return 'Format pas foto harus JPG atau PNG.';
    }
    // Pastikan isi file benar-benar gambar, bukan hanya ekstensinya
    $info = @getimagesize($file['tmp_name']);
    if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
        return 'File pas foto bukan gambar JPG/PNG yang valid.';
    }
    return '';
}

// Pindahkan file upload ke folder foto, simpan namanya ke database, lalu hapus foto lama
function simpan_foto($pdo, $file, $id_siswa, $foto_lama)
{
    $info = getimagesize($file['tmp_name']);
    $ekstensi = $info[2] === IMAGETYPE_PNG ? 'png' : 'jpg';
    $nama_baru = 'foto-' . $id_siswa . '-' . time() . '.' . $ekstensi;

    if (!move_uploaded_file($file['tmp_name'], FOLDER_FOTO . $nama_baru)) {
        return false;
    }
    $pdo->prepare("UPDATE siswa SET foto = ? WHERE id_siswa = ?")->execute([$nama_baru, $id_siswa]);
    hapus_file_foto($foto_lama);
    return true;
}

function hapus_file_foto($foto)
{
    if ($foto && is_file(FOLDER_FOTO . basename($foto))) {
        unlink(FOLDER_FOTO . basename($foto));
    }
}
