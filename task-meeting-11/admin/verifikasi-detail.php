<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT p.*, s.*, u.email, j.kode_jurusan, j.nama_jurusan
    FROM pendaftaran p
    JOIN siswa s ON s.id_siswa = p.id_siswa
    JOIN users u ON u.id_user = s.id_user
    JOIN jurusan j ON j.id_jurusan = p.id_jurusan
    WHERE p.id_pendaftaran = ?");
$stmt->execute([$id]);
$d = $stmt->fetch();

if (!$d) {
    set_pesan('error', 'Data pendaftaran tidak ditemukan.');
    header('Location: verifikasi.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_baru = $_POST['status'] ?? '';
    $catatan = trim($_POST['catatan'] ?? '');

    if (!in_array($status_baru, ['Menunggu', 'Diverifikasi', 'Ditolak'])) {
        $error = 'Status tidak valid.';
    } elseif ($status_baru === $d['status']) {
        $error = 'Status masih sama dengan sebelumnya.';
    } elseif ($status_baru === 'Ditolak' && $catatan === '') {
        $error = 'Tuliskan catatan alasan penolakan agar siswa bisa memperbaiki data.';
    } else {
        $pdo->prepare("UPDATE pendaftaran SET status = ? WHERE id_pendaftaran = ?")->execute([$status_baru, $id]);
        catat_status($pdo, $id, $d['status'], $status_baru, $catatan ?: null, $_SESSION['id_user']);

        set_pesan('sukses', 'Status ' . nomor_pendaftaran($id) . ' diubah menjadi ' . $status_baru . '.');
        header('Location: verifikasi-detail.php?id=' . $id);
        exit;
    }
}

$stmt = $pdo->prepare("SELECT r.*, u.nama AS nama_admin FROM riwayat_status r
    LEFT JOIN users u ON u.id_user = r.id_admin
    WHERE r.id_pendaftaran = ? ORDER BY r.tanggal_perubahan, r.id_riwayat");
$stmt->execute([$id]);
$riwayat = $stmt->fetchAll();

$judul = 'Periksa Pendaftaran ' . nomor_pendaftaran($id);
$menu_aktif = 'verifikasi';
include '../includes/header.php';
?>

<div class="dua-kolom">
  <div class="panel">
    <h2>Biodata Calon Siswa</h2>
    <dl class="info-list">
      <dt>NISN</dt><dd><?= e($d['nisn']) ?></dd>
      <dt>Nama Lengkap</dt><dd><?= e($d['nama_lengkap']) ?></dd>
      <dt>Jenis Kelamin</dt><dd><?= e($d['jenis_kelamin']) ?></dd>
      <dt>Tempat, Tgl Lahir</dt><dd><?= e($d['tempat_lahir']) ?>, <?= tanggal_indo($d['tanggal_lahir']) ?></dd>
      <dt>Alamat</dt><dd><?= e($d['alamat']) ?></dd>
      <dt>Asal Sekolah</dt><dd><?= e($d['asal_sekolah']) ?></dd>
      <dt>No HP</dt><dd><?= e($d['no_hp']) ?></dd>
      <dt>Email</dt><dd><?= e($d['email']) ?></dd>
    </dl>
  </div>

  <div>
    <div class="panel">
      <h2>Data Pendaftaran</h2>
      <dl class="info-list">
        <dt>Nomor Pendaftaran</dt><dd><b><?= nomor_pendaftaran($id) ?></b></dd>
        <dt>Jurusan</dt><dd><?= e($d['kode_jurusan'] . ' - ' . $d['nama_jurusan']) ?></dd>
        <dt>Tanggal Daftar</dt><dd><?= tanggal_indo($d['tanggal_daftar']) ?></dd>
        <dt>Status Saat Ini</dt><dd><?= badge_status($d['status']) ?></dd>
      </dl>
    </div>

    <div class="panel">
      <h2>Ubah Status</h2>
      <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
      <form action="" method="post">
        <div class="form-grid">
          <div class="field full">
            <label for="status">Status Baru</label>
            <select id="status" name="status">
              <?php foreach (['Diverifikasi', 'Ditolak', 'Menunggu'] as $st): ?>
                <option value="<?= $st ?>" <?= ($_POST['status'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field full">
            <label for="catatan">Catatan untuk Siswa</label>
            <textarea id="catatan" name="catatan" rows="3" placeholder="Wajib diisi jika pendaftaran ditolak"><?= e($_POST['catatan'] ?? '') ?></textarea>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan Status</button>
          <a href="verifikasi.php" class="btn btn-outline">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="panel">
  <h2>Riwayat Status</h2>
  <table class="tabel">
    <tr><th>Tanggal</th><th>Status Sebelumnya</th><th>Status Baru</th><th>Catatan</th><th>Oleh</th></tr>
    <?php foreach ($riwayat as $r): ?>
    <tr>
      <td><?= date('d-m-Y H:i', strtotime($r['tanggal_perubahan'])) ?></td>
      <td><?= $r['status_sebelumnya'] ? badge_status($r['status_sebelumnya']) : '-' ?></td>
      <td><?= badge_status($r['status_baru']) ?></td>
      <td><?= e($r['catatan'] ?? '-') ?></td>
      <td><?= e($r['nama_admin'] ?? 'Siswa') ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
