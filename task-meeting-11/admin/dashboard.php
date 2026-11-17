<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

// Jumlah pendaftar per status
$stmt = $pdo->prepare("SELECT status, COUNT(*) AS jumlah FROM pendaftaran WHERE tahun_ajaran = ? GROUP BY status");
$stmt->execute([TAHUN_AJARAN]);
$per_status = ['Menunggu' => 0, 'Diverifikasi' => 0, 'Ditolak' => 0];
foreach ($stmt->fetchAll() as $baris) {
    $per_status[$baris['status']] = $baris['jumlah'];
}
$total = array_sum($per_status);

$akun_siswa = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();

// Rekap per jurusan
$stmt = $pdo->prepare("SELECT j.kode_jurusan, j.nama_jurusan, j.kuota, j.aktif,
        COUNT(p.id_pendaftaran) AS pendaftar,
        SUM(p.status = 'Menunggu') AS menunggu,
        SUM(p.status = 'Diverifikasi') AS diverifikasi,
        SUM(p.status = 'Ditolak') AS ditolak
    FROM jurusan j
    LEFT JOIN pendaftaran p ON p.id_jurusan = j.id_jurusan AND p.tahun_ajaran = ?
    GROUP BY j.id_jurusan ORDER BY j.kode_jurusan");
$stmt->execute([TAHUN_AJARAN]);
$rekap = $stmt->fetchAll();

// Pendaftar terbaru
$stmt = $pdo->prepare("SELECT p.id_pendaftaran, p.tanggal_daftar, p.status, s.nama_lengkap, j.kode_jurusan
    FROM pendaftaran p JOIN siswa s ON s.id_siswa = p.id_siswa JOIN jurusan j ON j.id_jurusan = p.id_jurusan
    WHERE p.tahun_ajaran = ? ORDER BY p.tanggal_daftar DESC LIMIT 5");
$stmt->execute([TAHUN_AJARAN]);
$terbaru = $stmt->fetchAll();

$judul = 'Dashboard Admin';
$menu_aktif = 'dashboard';
include '../includes/header.php';
?>

<div class="stat-grid">
  <div class="stat-card"><small>Total Pendaftar</small><b><?= $total ?></b></div>
  <div class="stat-card kuning"><small>Menunggu Verifikasi</small><b><?= $per_status['Menunggu'] ?></b></div>
  <div class="stat-card hijau"><small>Diverifikasi</small><b><?= $per_status['Diverifikasi'] ?></b></div>
  <div class="stat-card merah"><small>Ditolak</small><b><?= $per_status['Ditolak'] ?></b></div>
</div>
<p class="muted">Akun calon siswa terdaftar: <b><?= $akun_siswa ?></b> · Belum mengirim pendaftaran: <b><?= $akun_siswa - $total ?></b></p>

<div class="panel">
  <h2>Jumlah Pendaftar per Jurusan</h2>
  <table class="tabel">
    <tr><th>Kode</th><th>Jurusan</th><th>Kuota</th><th>Pendaftar</th><th>Menunggu</th><th>Diverifikasi</th><th>Ditolak</th><th>Sisa Kuota</th></tr>
    <?php foreach ($rekap as $r): ?>
    <tr>
      <td><b><?= e($r['kode_jurusan']) ?></b></td>
      <td><?= e($r['nama_jurusan']) ?><?= $r['aktif'] ? '' : ' <span class="badge badge-abu">Nonaktif</span>' ?></td>
      <td><?= $r['kuota'] ?></td>
      <td><?= $r['pendaftar'] ?></td>
      <td><?= (int) $r['menunggu'] ?></td>
      <td><?= (int) $r['diverifikasi'] ?></td>
      <td><?= (int) $r['ditolak'] ?></td>
      <td><?= $r['kuota'] - $r['pendaftar'] + (int) $r['ditolak'] ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<div class="panel">
  <div class="panel-head"><h2>Pendaftar Terbaru</h2><a href="verifikasi.php" class="btn btn-outline btn-kecil">Lihat Semua</a></div>
  <table class="tabel">
    <tr><th>No. Pendaftaran</th><th>Nama</th><th>Jurusan</th><th>Tanggal Daftar</th><th>Status</th><th></th></tr>
    <?php foreach ($terbaru as $t): ?>
    <tr>
      <td><?= nomor_pendaftaran($t['id_pendaftaran']) ?></td>
      <td><?= e($t['nama_lengkap']) ?></td>
      <td><?= e($t['kode_jurusan']) ?></td>
      <td><?= tanggal_indo($t['tanggal_daftar']) ?></td>
      <td><?= badge_status($t['status']) ?></td>
      <td><a href="verifikasi-detail.php?id=<?= $t['id_pendaftaran'] ?>" class="btn btn-outline btn-kecil">Detail</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
