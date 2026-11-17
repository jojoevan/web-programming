<?php
require_once '../includes/fungsi.php';
wajib_login('siswa');

$siswa = ambil_siswa($pdo, $_SESSION['id_user']);
$daftar = ambil_pendaftaran($pdo, $siswa['id_siswa']);
$bisa_ubah = boleh_diubah($daftar);
$error = [];
$b = $siswa;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $bisa_ubah) {
    [$data, $error] = validasi_biodata($pdo, $_POST, $siswa['id_siswa']);

    if (!$error) {
        simpan_biodata($pdo, $data, $siswa['id_siswa'], $_SESSION['id_user']);
        kembalikan_ke_menunggu($pdo, $daftar);
        $_SESSION['nama'] = $data['nama_lengkap'];

        set_pesan('sukses', 'Biodata berhasil disimpan.');
        header('Location: biodata.php');
        exit;
    }
    // Tampilkan kembali isian yang salah
    $b = array_merge($siswa, $data);
}

$judul = 'Biodata Siswa';
$menu_aktif = 'biodata';
include '../includes/header.php';
?>

<?php if (!$bisa_ubah): ?>
  <div class="alert alert-info">Pendaftaran Anda sudah diverifikasi, biodata tidak dapat diubah lagi.</div>
<?php elseif ($daftar && $daftar['status'] === 'Ditolak'): ?>
  <div class="alert alert-error">Pendaftaran Anda ditolak. Setelah biodata diperbaiki, status akan kembali menjadi Menunggu.</div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="alert alert-error"><?php foreach ($error as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
<?php endif; ?>

<div class="panel">
  <h2>Data Diri Calon Siswa</h2>
  <form action="" method="post">
    <?php
    $kunci_form = !$bisa_ubah;
    include '../includes/form-biodata.php';
    ?>
    <?php if ($bisa_ubah): ?>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan Biodata</button>
        <?php if (biodata_lengkap($siswa) && !$daftar): ?>
          <a href="pendaftaran.php" class="btn btn-kuning">Lanjut Pilih Jurusan →</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
