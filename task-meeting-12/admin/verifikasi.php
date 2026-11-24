<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

// Filter berdasarkan status (opsional)
$filter = $_GET['status'] ?? '';
$daftar_status = ['Menunggu', 'Diverifikasi', 'Ditolak'];

$sql = "SELECT p.*, s.nisn, s.nama_lengkap, s.asal_sekolah, j.kode_jurusan
    FROM pendaftaran p JOIN siswa s ON s.id_siswa = p.id_siswa JOIN jurusan j ON j.id_jurusan = p.id_jurusan
    WHERE p.tahun_ajaran = ?";
$param = [TAHUN_AJARAN];
if (in_array($filter, $daftar_status)) {
    $sql .= " AND p.status = ?";
    $param[] = $filter;
}
$sql .= " ORDER BY p.tanggal_daftar";
$stmt = $pdo->prepare($sql);
$stmt->execute($param);
$data = $stmt->fetchAll();

$judul = 'Verifikasi Pendaftaran';
$menu_aktif = 'verifikasi';
include '../includes/header.php';
?>

<div class="panel">
  <div class="panel-head">
    <h2>Daftar Pendaftaran</h2>
    <div class="aksi">
      <a href="verifikasi.php" class="btn btn-kecil <?= $filter === '' ? 'btn-primary' : 'btn-outline' ?>">Semua</a>
      <?php foreach ($daftar_status as $st): ?>
        <a href="verifikasi.php?status=<?= $st ?>" class="btn btn-kecil <?= $filter === $st ? 'btn-primary' : 'btn-outline' ?>"><?= $st ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <table class="tabel">
    <tr><th>No. Pendaftaran</th><th>NISN</th><th>Nama</th><th>Asal Sekolah</th><th>Jurusan</th><th>Tanggal Daftar</th><th>Status</th><th></th></tr>
    <?php foreach ($data as $d): ?>
    <tr>
      <td><?= nomor_pendaftaran($d['id_pendaftaran']) ?></td>
      <td><?= e($d['nisn']) ?></td>
      <td><?= e($d['nama_lengkap']) ?></td>
      <td><?= e($d['asal_sekolah']) ?></td>
      <td><?= e($d['kode_jurusan']) ?></td>
      <td><?= tanggal_indo($d['tanggal_daftar']) ?></td>
      <td><?= badge_status($d['status']) ?></td>
      <td><a href="verifikasi-detail.php?id=<?= $d['id_pendaftaran'] ?>" class="btn btn-primary btn-kecil">Periksa</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$data): ?>
    <tr><td colspan="8" class="muted">Tidak ada data pendaftaran.</td></tr>
    <?php endif; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
