<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

// Hapus siswa: akun, biodata, pendaftaran, dan riwayat ikut terhapus (ON DELETE CASCADE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $stmt = $pdo->prepare("SELECT id_user, nama_lengkap FROM siswa WHERE id_siswa = ?");
    $stmt->execute([(int) $_POST['hapus']]);
    $s = $stmt->fetch();

    if ($s) {
        $pdo->prepare("DELETE FROM users WHERE id_user = ?")->execute([$s['id_user']]);
        set_pesan('sukses', 'Data siswa ' . $s['nama_lengkap'] . ' berhasil dihapus.');
    }
    header('Location: siswa.php');
    exit;
}

$stmt = $pdo->prepare("SELECT s.*, u.email, p.id_pendaftaran, p.status, j.kode_jurusan
    FROM siswa s
    JOIN users u ON u.id_user = s.id_user
    LEFT JOIN pendaftaran p ON p.id_siswa = s.id_siswa AND p.tahun_ajaran = ?
    LEFT JOIN jurusan j ON j.id_jurusan = p.id_jurusan
    ORDER BY s.nama_lengkap");
$stmt->execute([TAHUN_AJARAN]);
$data_siswa = $stmt->fetchAll();

$judul = 'Data Calon Siswa';
$menu_aktif = 'siswa';
include '../includes/header.php';
?>

<div class="panel">
  <div class="panel-head"><h2>Daftar Calon Siswa</h2><span class="muted">Total: <?= count($data_siswa) ?> siswa</span></div>
  <table class="tabel">
    <tr><th>No</th><th>NISN</th><th>Nama Lengkap</th><th>L/P</th><th>Asal Sekolah</th><th>No HP</th><th>Jurusan</th><th>Status</th><th>Aksi</th></tr>
    <?php foreach ($data_siswa as $i => $s): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($s['nisn']) ?></td>
      <td><?= e($s['nama_lengkap']) ?><br><small class="muted"><?= e($s['email']) ?></small></td>
      <td><?= $s['jenis_kelamin'] ? substr($s['jenis_kelamin'], 0, 1) : '-' ?></td>
      <td><?= e($s['asal_sekolah'] ?: '-') ?></td>
      <td><?= e($s['no_hp']) ?></td>
      <td><?= e($s['kode_jurusan'] ?? '-') ?></td>
      <td><?= badge_status($s['status']) ?></td>
      <td>
        <div class="aksi">
          <a href="siswa-edit.php?id=<?= $s['id_siswa'] ?>" class="btn btn-outline btn-kecil">Edit</a>
          <form action="" method="post" onsubmit="return confirm('Hapus data siswa ini beserta akun dan pendaftarannya?')">
            <button type="submit" name="hapus" value="<?= $s['id_siswa'] ?>" class="btn btn-danger btn-kecil">Hapus</button>
          </form>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
