<?php
// Layout halaman dashboard. Sebelum include, isi $judul dan $menu_aktif.
if ($_SESSION['role'] === 'admin') {
    $menu = [
        'dashboard'  => ['dashboard.php', 'Dashboard'],
        'siswa'      => ['siswa.php', 'Data Siswa'],
        'jurusan'    => ['jurusan.php', 'Data Jurusan'],
        'verifikasi' => ['verifikasi.php', 'Verifikasi'],
    ];
} else {
    $menu = [
        'dashboard'   => ['dashboard.php', 'Dashboard'],
        'biodata'     => ['biodata.php', 'Biodata'],
        'pendaftaran' => ['pendaftaran.php', 'Pendaftaran'],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($judul) ?> | PPDB Online SMK Nusantara</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
  <header class="dash-header">
    <a class="brand" href="../index.php"><span class="brand-logo">⌂</span><span>SMK<br><b>Nusantara</b></span></a>
    <div class="dash-user">
      <span><?= e($_SESSION['nama']) ?> <small><?= $_SESSION['role'] === 'admin' ? 'Admin' : 'Calon Siswa' ?></small></span>
      <a class="back-link" href="../auth/logout.php">Logout</a>
    </div>
  </header>
  <div class="dash-layout">
    <aside class="sidebar">
      <p class="sidebar-title"><?= $_SESSION['role'] === 'admin' ? 'MENU ADMIN' : 'MENU SISWA' ?></p>
      <?php foreach ($menu as $kunci => $item): ?>
        <a href="<?= $item[0] ?>" class="<?= $kunci === $menu_aktif ? 'aktif' : '' ?>"><?= $item[1] ?></a>
      <?php endforeach; ?>
    </aside>
    <main class="content">
      <h1 class="page-title"><?= e($judul) ?></h1>
      <?php tampil_pesan(); ?>
