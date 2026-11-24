<?php
// Isian form biodata, dipakai di siswa/biodata.php dan admin/siswa-edit.php.
// Sebelum include, isi $b (data biodata) dan $kunci_form (true = hanya baca).
// $foto_wajib = true jika input pas foto wajib diisi (siswa yang belum punya foto).
// Form yang memakai file ini harus memakai enctype="multipart/form-data".
$dis = $kunci_form ? 'disabled' : '';
$foto_wajib = $foto_wajib ?? false;
?>
<div class="foto-field">
  <?= tampil_foto($b['foto']) ?>
  <div class="field">
    <label for="foto">Pas Foto 3x4</label>
    <?php if ($kunci_form): ?>
      <p class="muted">Pas foto sudah tersimpan dan tidak dapat diganti lagi.</p>
    <?php else: ?>
      <input id="foto" name="foto" type="file" accept=".jpg,.jpeg,.png" <?= $foto_wajib ? 'required' : '' ?>>
      <small class="muted">Format JPG/PNG, maksimal 1 MB, pas foto ukuran 3x4.
        <?= $b['foto'] ? 'Kosongkan jika tidak ingin mengganti foto.' : '' ?></small>
    <?php endif; ?>
  </div>
</div>
<div class="form-grid">
  <div class="field">
    <label for="nisn">NISN</label>
    <input id="nisn" name="nisn" type="text" maxlength="10" value="<?= e($b['nisn']) ?>" <?= $dis ?> required>
  </div>
  <div class="field">
    <label for="email">Email</label>
    <input id="email" type="email" value="<?= e($b['email']) ?>" disabled>
  </div>
  <div class="field full">
    <label for="nama_lengkap">Nama Lengkap</label>
    <input id="nama_lengkap" name="nama_lengkap" type="text" value="<?= e($b['nama_lengkap']) ?>" <?= $dis ?> required>
  </div>
  <div class="field">
    <label>Jenis Kelamin</label>
    <div class="radio-row">
      <label><input type="radio" name="jenis_kelamin" value="Laki-laki" <?= $b['jenis_kelamin'] === 'Laki-laki' ? 'checked' : '' ?> <?= $dis ?>> Laki-laki</label>
      <label><input type="radio" name="jenis_kelamin" value="Perempuan" <?= $b['jenis_kelamin'] === 'Perempuan' ? 'checked' : '' ?> <?= $dis ?>> Perempuan</label>
    </div>
  </div>
  <div class="field">
    <label for="no_hp">Nomor HP / WhatsApp</label>
    <input id="no_hp" name="no_hp" type="tel" value="<?= e($b['no_hp']) ?>" <?= $dis ?> required>
  </div>
  <div class="field">
    <label for="tempat_lahir">Tempat Lahir</label>
    <input id="tempat_lahir" name="tempat_lahir" type="text" value="<?= e($b['tempat_lahir']) ?>" <?= $dis ?> required>
  </div>
  <div class="field">
    <label for="tanggal_lahir">Tanggal Lahir</label>
    <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="<?= e($b['tanggal_lahir']) ?>" <?= $dis ?> required>
  </div>
  <div class="field full">
    <label for="alamat">Alamat</label>
    <textarea id="alamat" name="alamat" rows="2" <?= $dis ?> required><?= e($b['alamat']) ?></textarea>
  </div>
  <div class="field full">
    <label for="asal_sekolah">Asal Sekolah (SMP/MTs)</label>
    <input id="asal_sekolah" name="asal_sekolah" type="text" value="<?= e($b['asal_sekolah']) ?>" <?= $dis ?> required>
  </div>
</div>
