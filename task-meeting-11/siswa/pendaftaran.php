<?php
require_once '../includes/fungsi.php';
wajib_login('siswa');

$siswa = ambil_siswa($pdo, $_SESSION['id_user']);
$daftar = ambil_pendaftaran($pdo, $siswa['id_siswa']);
$bisa_ubah = boleh_diubah($daftar);
$id_pendaftaran_saya = $daftar['id_pendaftaran'] ?? 0;

// Jurusan aktif + jumlah pendaftar yang tidak ditolak (pendaftaran sendiri tidak dihitung)
$stmt = $pdo->prepare("SELECT j.*,
        (SELECT COUNT(*) FROM pendaftaran p
         WHERE p.id_jurusan = j.id_jurusan AND p.tahun_ajaran = ? AND p.status <> 'Ditolak'
         AND p.id_pendaftaran <> ?) AS terisi
    FROM jurusan j WHERE j.aktif = 1 ORDER BY j.kode_jurusan");
$stmt->execute([TAHUN_AJARAN, $id_pendaftaran_saya]);
$daftar_jurusan = $stmt->fetchAll();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $bisa_ubah && biodata_lengkap($siswa)) {
    $id_jurusan = (int) ($_POST['id_jurusan'] ?? 0);

    // Cari jurusan yang dipilih di daftar jurusan aktif
    $pilihan = null;
    foreach ($daftar_jurusan as $j) {
        if ((int) $j['id_jurusan'] === $id_jurusan) {
            $pilihan = $j;
        }
    }

    if (!$pilihan) {
        $error = 'Pilih salah satu jurusan yang tersedia.';
    } elseif ($pilihan['terisi'] >= $pilihan['kuota']) {
        $error = 'Kuota jurusan ' . $pilihan['nama_jurusan'] . ' sudah penuh.';
    } elseif (!$daftar) {
        // Pendaftaran baru
        $stmt = $pdo->prepare("INSERT INTO pendaftaran (id_siswa, id_jurusan, tahun_ajaran, tanggal_daftar, status)
            VALUES (?, ?, ?, NOW(), 'Menunggu')");
        $stmt->execute([$siswa['id_siswa'], $id_jurusan, TAHUN_AJARAN]);
        $id_baru = $pdo->lastInsertId();
        catat_status($pdo, $id_baru, null, 'Menunggu', 'Pendaftaran dikirim.');

        set_pesan('sukses', 'Pendaftaran berhasil dikirim. Nomor pendaftaran Anda: ' . nomor_pendaftaran($id_baru));
        header('Location: dashboard.php');
        exit;
    } else {
        // Ubah pilihan jurusan
        $pdo->prepare("UPDATE pendaftaran SET id_jurusan = ? WHERE id_pendaftaran = ?")
            ->execute([$id_jurusan, $daftar['id_pendaftaran']]);
        kembalikan_ke_menunggu($pdo, $daftar);

        set_pesan('sukses', 'Pilihan jurusan berhasil disimpan.');
        header('Location: pendaftaran.php');
        exit;
    }
}

$judul = 'Pendaftaran';
$menu_aktif = 'pendaftaran';
include '../includes/header.php';
?>

<?php if (!biodata_lengkap($siswa)): ?>
  <div class="panel">
    <h2>Biodata Belum Lengkap</h2>
    <p class="muted">Anda harus melengkapi biodata terlebih dahulu sebelum memilih jurusan dan mengirim pendaftaran.</p>
    <a href="biodata.php" class="btn btn-primary">Lengkapi Biodata</a>
  </div>

<?php else: ?>

  <?php if ($daftar): ?>
  <div class="panel">
    <h2>Data Pendaftaran</h2>
    <dl class="info-list">
      <dt>Nomor Pendaftaran</dt><dd><b><?= nomor_pendaftaran($daftar['id_pendaftaran']) ?></b></dd>
      <dt>Tahun Ajaran</dt><dd><?= e($daftar['tahun_ajaran']) ?></dd>
      <dt>Tanggal Daftar</dt><dd><?= tanggal_indo($daftar['tanggal_daftar']) ?></dd>
      <dt>Jurusan</dt><dd><?= e($daftar['kode_jurusan'] . ' - ' . $daftar['nama_jurusan']) ?></dd>
      <dt>Status</dt><dd><?= badge_status($daftar['status']) ?></dd>
    </dl>
  </div>
  <?php endif; ?>

  <?php if ($bisa_ubah): ?>
  <div class="panel">
    <h2><?= $daftar ? 'Ubah Pilihan Jurusan' : 'Pilih Jurusan' ?></h2>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form action="" method="post">
      <div class="pilihan-jurusan">
        <?php foreach ($daftar_jurusan as $j):
            $sisa = $j['kuota'] - $j['terisi'];
            $penuh = $sisa <= 0;
            $dipilih = $daftar && $daftar['id_jurusan'] == $j['id_jurusan'];
        ?>
        <label class="opsi <?= $penuh ? 'penuh' : '' ?>">
          <input type="radio" name="id_jurusan" value="<?= $j['id_jurusan'] ?>" <?= $dipilih ? 'checked' : '' ?> <?= $penuh ? 'disabled' : '' ?> required>
          <span>
            <b><?= e($j['kode_jurusan']) ?> - <?= e($j['nama_jurusan']) ?></b>
            <small><?= e($j['deskripsi']) ?></small>
            <small><?= $penuh ? 'Kuota penuh' : 'Sisa kuota: ' . $sisa . ' dari ' . $j['kuota'] ?></small>
          </span>
        </label>
        <?php endforeach; ?>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $daftar ? 'Simpan Pilihan' : 'Kirim Pendaftaran' ?></button>
      </div>
    </form>
  </div>
  <?php else: ?>
    <div class="alert alert-info">Pendaftaran sudah diverifikasi, pilihan jurusan tidak dapat diubah lagi.</div>
  <?php endif; ?>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>
