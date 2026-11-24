<?php
require_once '../includes/fungsi.php';
wajib_login('siswa');

$siswa = ambil_siswa($pdo, $_SESSION['id_user']);
$daftar = ambil_pendaftaran($pdo, $siswa['id_siswa']);
$lengkap = biodata_lengkap($siswa);

$riwayat = [];
if ($daftar) {
    $stmt = $pdo->prepare("SELECT * FROM riwayat_status WHERE id_pendaftaran = ? ORDER BY tanggal_perubahan DESC, id_riwayat DESC");
    $stmt->execute([$daftar['id_pendaftaran']]);
    $riwayat = $stmt->fetchAll();
}

$judul = 'Dashboard Siswa';
$menu_aktif = 'dashboard';
include '../includes/header.php';
?>

<div class="panel welcome">
  <?= tampil_foto($siswa['foto'], 'kecil') ?>
  <div>
    <h2>Halo, <?= e($siswa['nama_lengkap']) ?>!</h2>
    <p>Selamat datang di PPDB Online SMK Nusantara Tahun Ajaran <?= TAHUN_AJARAN ?>.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card"><small>Nomor Pendaftaran</small><b style="font-size:20px"><?= $daftar ? nomor_pendaftaran($daftar['id_pendaftaran']) : '-' ?></b></div>
  <div class="stat-card"><small>Jurusan Pilihan</small><b style="font-size:20px"><?= $daftar ? e($daftar['kode_jurusan']) : '-' ?></b></div>
  <div class="stat-card"><small>Status</small><b style="font-size:16px;margin-top:10px"><?= badge_status($daftar['status'] ?? null) ?></b></div>
  <div class="stat-card"><small>Tanggal Daftar</small><b style="font-size:20px"><?= $daftar ? tanggal_indo($daftar['tanggal_daftar']) : '-' ?></b></div>
</div>

<?php if (!$lengkap): ?>
  <div class="alert alert-info">Biodata atau pas foto Anda belum lengkap. <a href="biodata.php"><b>Lengkapi biodata sekarang →</b></a></div>
<?php elseif (!$daftar): ?>
  <div class="alert alert-info">Biodata sudah lengkap. <a href="pendaftaran.php"><b>Pilih jurusan dan kirim pendaftaran →</b></a></div>
<?php elseif ($daftar['status'] === 'Ditolak'): ?>
  <div class="alert alert-error">Pendaftaran Anda ditolak: <b><?= e($riwayat[0]['catatan'] ?? '-') ?></b><br>Silakan perbaiki biodata atau pilihan jurusan, status akan kembali menjadi Menunggu.</div>
<?php elseif ($daftar['status'] === 'Diverifikasi'): ?>
  <div class="alert alert-sukses">Pendaftaran Anda sudah diverifikasi. Silakan tunggu jadwal seleksi dan pengumuman.</div>
<?php else: ?>
  <div class="alert alert-info">Pendaftaran Anda sedang menunggu verifikasi oleh panitia.</div>
<?php endif; ?>

<div class="dua-kolom">
  <div class="panel">
    <h2>Langkah Pendaftaran</h2>
    <ol class="langkah">
      <li class="selesai"><span>1</span> Membuat akun</li>
      <li class="<?= $lengkap ? 'selesai' : '' ?>"><span>2</span> Melengkapi biodata dan pas foto</li>
      <li class="<?= $daftar ? 'selesai' : '' ?>"><span>3</span> Memilih jurusan dan mengirim pendaftaran</li>
      <li class="<?= ($daftar['status'] ?? '') === 'Diverifikasi' ? 'selesai' : '' ?>"><span>4</span> Verifikasi oleh panitia</li>
    </ol>
  </div>
  <div class="panel">
    <h2>Jadwal PPDB <?= TAHUN_AJARAN ?></h2>
    <dl class="info-list">
      <dt>Pendaftaran</dt><dd>1 – 20 Juni 2026</dd>
      <dt>Verifikasi</dt><dd>1 – 22 Juni 2026</dd>
      <dt>Seleksi</dt><dd>23 – 25 Juni 2026</dd>
      <dt>Pengumuman</dt><dd>26 Juni 2026</dd>
    </dl>
  </div>
</div>

<?php if ($riwayat): ?>
<div class="panel">
  <h2>Riwayat Status</h2>
  <table class="tabel">
    <tr><th>Tanggal</th><th>Status</th><th>Catatan</th></tr>
    <?php foreach ($riwayat as $r): ?>
    <tr>
      <td><?= date('d-m-Y H:i', strtotime($r['tanggal_perubahan'])) ?></td>
      <td><?= badge_status($r['status_baru']) ?></td>
      <td><?= e($r['catatan']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
