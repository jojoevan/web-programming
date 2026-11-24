<?php
require_once '../includes/fungsi.php';

// Sudah login: langsung ke dashboard sesuai role
if (isset($_SESSION['id_user'])) {
    header('Location: ../' . $_SESSION['role'] . '/dashboard.php');
    exit;
}

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../' . $user['role'] . '/dashboard.php');
        exit;
    }
    $error = 'Email atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Login calon siswa PPDB Online SMK Nusantara.">
<title>Login Siswa | PPDB Online SMK Nusantara</title><link rel="stylesheet" href="../assets/css/auth.css">
</head><body>
<header class="auth-header">
  <a class="brand" href="../index.php"><span class="brand-logo">⌂</span><span>SMK<br><b>Nusantara</b></span></a>
  <a class="back-link" href="../index.php">← Kembali ke Beranda</a>
</header>
<main class="auth-layout">
  <section class="welcome-panel">
    <div class="welcome-content">
      <span class="tag">PPDB ONLINE 2026/2027</span>
      <h1>Selamat Datang<br>Calon Siswa!</h1>
      <p>Masuk ke akun PPDB Online SMK Nusantara untuk melanjutkan proses pendaftaran dan memantau status seleksi.</p>
      <div class="welcome-points">
        <div><span>✓</span> Pantau status pendaftaran</div>
        <div><span>✓</span> Perbarui biodata dan dokumen</div>
        <div><span>✓</span> Lihat informasi hasil seleksi</div>
      </div>
    </div>
    <div class="decor-circle circle-one"></div><div class="decor-circle circle-two"></div>
    <div class="school-illustration" aria-hidden="true"><div class="ill-cloud"></div><div class="ill-roof"></div>
      <div class="ill-building"><div class="ill-sign">SMK NUSANTARA</div><div class="ill-windows"><i></i><i></i><i></i></div><div class="ill-door"></div></div><div class="ill-ground"></div>
    </div>
  </section>
  <section class="form-panel"><div class="form-card">
    <div class="form-brand-mark">SN</div><p class="form-eyebrow">PORTAL PESERTA DIDIK</p>
    <h2>Login Siswa</h2><p class="form-intro">Silakan masuk menggunakan email dan password yang telah didaftarkan.</p>
    <?php tampil_pesan(); ?>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form action="" method="post">
      <label for="email">Email</label><input id="email" name="email" type="email" placeholder="nama@email.com" autocomplete="username" value="<?= e($email) ?>" required>
      <label for="password">Password</label><input id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required>
      <button class="submit-button" type="submit">Masuk ke Akun <span>→</span></button>
    </form>
    <div class="form-divider"><span>Belum memiliki akun?</span></div>
    <a class="outline-button" href="register.php">Registrasi Siswa</a>
    <p class="back-home"><a href="../index.php">← Kembali ke halaman utama</a></p>
  </div><p class="copyright">© 2026 SMK Nusantara · PPDB Online</p></section>
</main></body></html>
