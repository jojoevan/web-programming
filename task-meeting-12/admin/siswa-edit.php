<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

$id_siswa = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT s.*, u.email FROM siswa s JOIN users u ON u.id_user = s.id_user WHERE s.id_siswa = ?");
$stmt->execute([$id_siswa]);
$siswa = $stmt->fetch();

if (!$siswa) {
    set_pesan('error', 'Data siswa tidak ditemukan.');
    header('Location: siswa.php');
    exit;
}

$error = [];
$b = $siswa;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$data, $error] = validasi_biodata($pdo, $_POST, $id_siswa);

    // Admin boleh mengganti pas foto, tetapi tidak wajib mengupload
    $foto = $_FILES['foto'] ?? null;
    $error_foto = validasi_foto($foto, false);
    if ($error_foto) {
        $error[] = $error_foto;
    }

    if (!$error) {
        simpan_biodata($pdo, $data, $id_siswa, $siswa['id_user']);
        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            simpan_foto($pdo, $foto, $id_siswa, $siswa['foto']);
        }
        set_pesan('sukses', 'Biodata ' . $data['nama_lengkap'] . ' berhasil diperbarui.');
        header('Location: siswa.php');
        exit;
    }
    $b = array_merge($siswa, $data);
}

$judul = 'Edit Data Siswa';
$menu_aktif = 'siswa';
include '../includes/header.php';
?>

<?php if ($error): ?>
  <div class="alert alert-error"><?php foreach ($error as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
<?php endif; ?>

<div class="panel">
  <h2>Biodata <?= e($siswa['nama_lengkap']) ?></h2>
  <form action="" method="post" enctype="multipart/form-data">
    <?php
    $kunci_form = false;
    include '../includes/form-biodata.php';
    ?>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="siswa.php" class="btn btn-outline">Batal</a>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
