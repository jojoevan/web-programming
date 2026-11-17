<?php
require_once '../includes/fungsi.php';
wajib_login('admin');

$error = [];
$form = ['id_jurusan' => 0, 'kode_jurusan' => '', 'nama_jurusan' => '', 'kuota' => 36, 'deskripsi' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'simpan') {
        $form = [
            'id_jurusan'   => (int) ($_POST['id_jurusan'] ?? 0),
            'kode_jurusan' => strtoupper(trim($_POST['kode_jurusan'] ?? '')),
            'nama_jurusan' => trim($_POST['nama_jurusan'] ?? ''),
            'kuota'        => (int) ($_POST['kuota'] ?? 0),
            'deskripsi'    => trim($_POST['deskripsi'] ?? ''),
        ];

        if ($form['kode_jurusan'] === '' || strlen($form['kode_jurusan']) > 10) {
            $error[] = 'Kode jurusan wajib diisi (maksimal 10 karakter).';
        } else {
            $cek = $pdo->prepare("SELECT COUNT(*) FROM jurusan WHERE kode_jurusan = ? AND id_jurusan <> ?");
            $cek->execute([$form['kode_jurusan'], $form['id_jurusan']]);
            if ($cek->fetchColumn() > 0) {
                $error[] = 'Kode jurusan sudah dipakai.';
            }
        }
        if ($form['nama_jurusan'] === '') {
            $error[] = 'Nama jurusan wajib diisi.';
        }
        if ($form['kuota'] < 1) {
            $error[] = 'Kuota minimal 1.';
        }

        if (!$error) {
            if ($form['id_jurusan']) {
                $stmt = $pdo->prepare("UPDATE jurusan SET kode_jurusan = ?, nama_jurusan = ?, kuota = ?, deskripsi = ? WHERE id_jurusan = ?");
                $stmt->execute([$form['kode_jurusan'], $form['nama_jurusan'], $form['kuota'], $form['deskripsi'], $form['id_jurusan']]);
                set_pesan('sukses', 'Jurusan ' . $form['kode_jurusan'] . ' berhasil diperbarui.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO jurusan (kode_jurusan, nama_jurusan, kuota, deskripsi) VALUES (?, ?, ?, ?)");
                $stmt->execute([$form['kode_jurusan'], $form['nama_jurusan'], $form['kuota'], $form['deskripsi']]);
                set_pesan('sukses', 'Jurusan ' . $form['kode_jurusan'] . ' berhasil ditambahkan.');
            }
            header('Location: jurusan.php');
            exit;
        }
    }

    if ($aksi === 'status') {
        $pdo->prepare("UPDATE jurusan SET aktif = 1 - aktif WHERE id_jurusan = ?")->execute([(int) $_POST['id_jurusan']]);
        set_pesan('sukses', 'Status jurusan berhasil diubah.');
        header('Location: jurusan.php');
        exit;
    }

    if ($aksi === 'hapus') {
        try {
            $pdo->prepare("DELETE FROM jurusan WHERE id_jurusan = ?")->execute([(int) $_POST['id_jurusan']]);
            set_pesan('sukses', 'Jurusan berhasil dihapus.');
        } catch (PDOException $e) {
            // Gagal karena foreign key: jurusan sudah dipilih pendaftar
            set_pesan('error', 'Jurusan sudah dipakai oleh pendaftar sehingga tidak bisa dihapus. Nonaktifkan saja.');
        }
        header('Location: jurusan.php');
        exit;
    }
}

// Mode edit: isi form dengan data jurusan yang dipilih
if (isset($_GET['edit']) && !$error) {
    $stmt = $pdo->prepare("SELECT * FROM jurusan WHERE id_jurusan = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $form = $stmt->fetch() ?: $form;
}

$stmt = $pdo->prepare("SELECT j.*, COUNT(p.id_pendaftaran) AS pendaftar FROM jurusan j
    LEFT JOIN pendaftaran p ON p.id_jurusan = j.id_jurusan AND p.tahun_ajaran = ?
    GROUP BY j.id_jurusan ORDER BY j.kode_jurusan");
$stmt->execute([TAHUN_AJARAN]);
$data_jurusan = $stmt->fetchAll();

$judul = 'Data Jurusan';
$menu_aktif = 'jurusan';
include '../includes/header.php';
?>

<div class="panel">
  <h2>Daftar Jurusan</h2>
  <table class="tabel">
    <tr><th>Kode</th><th>Nama Jurusan</th><th>Deskripsi</th><th>Kuota</th><th>Pendaftar</th><th>Status</th><th>Aksi</th></tr>
    <?php foreach ($data_jurusan as $j): ?>
    <tr>
      <td><b><?= e($j['kode_jurusan']) ?></b></td>
      <td><?= e($j['nama_jurusan']) ?></td>
      <td class="muted"><?= e($j['deskripsi']) ?></td>
      <td><?= $j['kuota'] ?></td>
      <td><?= $j['pendaftar'] ?></td>
      <td><?= $j['aktif'] ? '<span class="badge badge-hijau">Aktif</span>' : '<span class="badge badge-abu">Nonaktif</span>' ?></td>
      <td>
        <div class="aksi">
          <a href="jurusan.php?edit=<?= $j['id_jurusan'] ?>" class="btn btn-outline btn-kecil">Edit</a>
          <form action="" method="post">
            <input type="hidden" name="aksi" value="status">
            <input type="hidden" name="id_jurusan" value="<?= $j['id_jurusan'] ?>">
            <button type="submit" class="btn btn-outline btn-kecil"><?= $j['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?></button>
          </form>
          <form action="" method="post" onsubmit="return confirm('Hapus jurusan ini?')">
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id_jurusan" value="<?= $j['id_jurusan'] ?>">
            <button type="submit" class="btn btn-danger btn-kecil">Hapus</button>
          </form>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<div class="panel">
  <h2><?= $form['id_jurusan'] ? 'Edit Jurusan ' . e($form['kode_jurusan']) : 'Tambah Jurusan' ?></h2>
  <?php if ($error): ?>
    <div class="alert alert-error"><?php foreach ($error as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
  <?php endif; ?>
  <form action="" method="post">
    <input type="hidden" name="aksi" value="simpan">
    <input type="hidden" name="id_jurusan" value="<?= $form['id_jurusan'] ?>">
    <div class="form-grid">
      <div class="field">
        <label for="kode_jurusan">Kode Jurusan</label>
        <input id="kode_jurusan" name="kode_jurusan" type="text" maxlength="10" placeholder="Contoh: DKV" value="<?= e($form['kode_jurusan']) ?>" required>
      </div>
      <div class="field">
        <label for="kuota">Kuota</label>
        <input id="kuota" name="kuota" type="number" min="1" value="<?= e($form['kuota']) ?>" required>
      </div>
      <div class="field full">
        <label for="nama_jurusan">Nama Jurusan</label>
        <input id="nama_jurusan" name="nama_jurusan" type="text" placeholder="Contoh: Desain Komunikasi Visual" value="<?= e($form['nama_jurusan']) ?>" required>
      </div>
      <div class="field full">
        <label for="deskripsi">Deskripsi</label>
        <input id="deskripsi" name="deskripsi" type="text" value="<?= e($form['deskripsi']) ?>">
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><?= $form['id_jurusan'] ? 'Simpan Perubahan' : 'Tambah Jurusan' ?></button>
      <?php if ($form['id_jurusan']): ?><a href="jurusan.php" class="btn btn-outline">Batal</a><?php endif; ?>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
