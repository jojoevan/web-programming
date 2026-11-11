<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengguna | Latihan RDBMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Data Pengguna</h1>
            <p>Latihan RDBMS dengan PHP dan MySQL</p>
        </div>
    </header>

    <div class="container">

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'sukses'): ?>
                <p class="pesan sukses">Data pengguna berhasil disimpan.</p>
            <?php else: ?>
                <p class="pesan gagal">Data pengguna gagal disimpan. Periksa kembali isian formulir.</p>
            <?php endif; ?>
        <?php endif; ?>

        <div class="kolom">

            <div class="kartu form">
                <h2>Tambah Pengguna</h2>
                <form action="proses-tambah.php" method="POST">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" placeholder="Nama lengkap" maxlength="100" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="nama@example.com" maxlength="100" required>

                    <label for="age">Umur</label>
                    <input type="number" name="age" id="age" placeholder="Umur" min="1" max="120" required>

                    <button type="submit" name="simpan">Simpan</button>
                </form>
            </div>

            <div class="kartu">
                <?php
                $query = mysqli_query($db, "SELECT * FROM users ORDER BY id");
                $total = mysqli_num_rows($query);
                ?>
                <h2>Daftar Pengguna <span class="jumlah"><?php echo $total; ?></span></h2>

                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Umur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php while ($user = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo $user['age']; ?> tahun</td>
                            </tr>
                        <?php endwhile; ?>

                        <?php if ($total == 0): ?>
                            <tr>
                                <td colspan="4" class="kosong">Belum ada data pengguna.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <footer>
        Task Meeting 10 &middot; Pemrograman Web
    </footer>

</body>
</html>
