<?php
require_once '../includes/fungsi.php';

if (isset($_SESSION['id_user'])) {
    header('Location: ../' . $_SESSION['role'] . '/dashboard.php');
    exit;
}

$input = ['fullname' => '', 'email' => '', 'phone' => '', 'nisn' => ''];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($input as $kunci => $nilai) {
        $input[$kunci] = trim($_POST[$kunci] ?? '');
    }
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['confirm_password'] ?? '';

    // Validasi di sisi server
    if ($input['fullname'] === '') {
        $error[] = 'Nama lengkap wajib diisi.';
    }
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Format email tidak valid.';
    } else {
        $cek = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $cek->execute([$input['email']]);
        if ($cek->fetchColumn() > 0) {
            $error[] = 'Email sudah terdaftar.';
        }
    }
    if (!preg_match('/^[0-9+() -]{9,18}$/', $input['phone'])) {
        $error[] = 'Nomor HP tidak valid.';
    }
    if (!preg_match('/^[0-9]{10}$/', $input['nisn'])) {
        $error[] = 'NISN harus 10 digit angka.';
    } else {
        $cek = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE nisn = ?");
        $cek->execute([$input['nisn']]);
        if ($cek->fetchColumn() > 0) {
            $error[] = 'NISN sudah terdaftar.';
        }
    }
    if (strlen($password) < 8) {
        $error[] = 'Password minimal 8 karakter.';
    } elseif ($password !== $konfirmasi) {
        $error[] = 'Konfirmasi password tidak sama.';
    }

    if (!$error) {
        // Simpan akun dan biodata awal dalam satu transaksi
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'siswa')");
        $stmt->execute([$input['fullname'], $input['email'], password_hash($password, PASSWORD_DEFAULT)]);
        $id_user = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO siswa (id_user, nisn, nama_lengkap, no_hp) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_user, $input['nisn'], $input['fullname'], $input['phone']]);
        $pdo->commit();

        set_pesan('sukses', 'Registrasi berhasil. Silakan login dengan email dan password Anda.');
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Registrasi akun calon siswa PPDB Online SMK Nusantara.">
<title>Registrasi Siswa | PPDB Online SMK Nusantara</title><link rel="stylesheet" href="../assets/css/auth.css">
</head><body>
<header class="auth-header">
  <a class="brand" href="../index.php"><span class="brand-logo">⌂</span><span>SMK<br><b>Nusantara</b></span></a>
  <a class="back-link" href="../index.php">← Kembali ke Beranda</a>
</header>
<main class="auth-layout register-layout">
  <section class="welcome-panel">
    <div class="welcome-content">
      <span class="tag">PPDB ONLINE 2026/2027</span>
      <h1>Mulai Langkah<br>Menuju Masa Depan!</h1>
      <p>Buat akun calon siswa untuk memulai pendaftaran di SMK Nusantara. Pastikan data yang dimasukkan benar dan aktif.</p>
      <div class="welcome-points"><div><span>1</span> Buat akun menggunakan email aktif</div><div><span>2</span> Lengkapi biodata calon siswa</div><div><span>3</span> Lanjutkan proses pendaftaran</div></div>
    </div>
    <div class="decor-circle circle-one"></div><div class="decor-circle circle-two"></div>
    <div class="school-illustration" aria-hidden="true"><div class="ill-cloud"></div><div class="ill-roof"></div>
      <div class="ill-building"><div class="ill-sign">SMK NUSANTARA</div><div class="ill-windows"><i></i><i></i><i></i></div><div class="ill-door"></div></div><div class="ill-ground"></div>
    </div>
  </section>
  <section class="form-panel"><div class="form-card register-card">
    <div class="form-brand-mark">SN</div><p class="form-eyebrow">PORTAL PESERTA DIDIK</p>
    <h2>Registrasi Siswa</h2><p class="form-intro">Isi data berikut untuk membuat akun PPDB Online.</p>
    <?php if ($error): ?>
      <div class="alert alert-error"><?php foreach ($error as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
    <?php endif; ?>
    <form action="" method="post">
      <div class="field-grid">
        <div class="field full"><label for="fullname">Nama Lengkap</label><input id="fullname" name="fullname" type="text" placeholder="Masukkan nama sesuai identitas" autocomplete="name" value="<?= e($input['fullname']) ?>" required></div>
        <div class="field"><label for="email">Email Aktif</label><input id="email" name="email" type="email" placeholder="nama@email.com" autocomplete="email" value="<?= e($input['email']) ?>" required></div>
        <div class="field"><label for="phone">Nomor HP / WhatsApp</label><input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx" autocomplete="tel" pattern="[0-9+() -]{9,18}" value="<?= e($input['phone']) ?>" required></div>
        <div class="field full"><label for="nisn">NISN</label><input id="nisn" name="nisn" type="text" inputmode="numeric" placeholder="Masukkan 10 digit NISN" pattern="[0-9]{10}" maxlength="10" value="<?= e($input['nisn']) ?>" required><small class="field-hint">NISN terdiri dari 10 digit angka.</small></div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" placeholder="Minimal 8 karakter" minlength="8" autocomplete="new-password" required></div>
        <div class="field"><label for="confirm-password">Konfirmasi Password</label><input id="confirm-password" name="confirm_password" type="password" placeholder="Ulangi password" minlength="8" autocomplete="new-password" required></div>
      </div>
      <label class="terms"><input type="checkbox" required><span>Saya menyatakan data yang diisi benar dan bersedia mengikuti ketentuan PPDB SMK Nusantara.</span></label>
      <button class="submit-button" type="submit">Buat Akun <span>→</span></button>
    </form>
    <div class="form-divider"><span>Sudah memiliki akun?</span></div>
    <a class="outline-button" href="login.php">Login Siswa</a>
    <p class="back-home"><a href="../index.php">← Kembali ke halaman utama</a></p>
  </div><p class="copyright">© 2026 SMK Nusantara · PPDB Online</p></section>
</main></body></html>
