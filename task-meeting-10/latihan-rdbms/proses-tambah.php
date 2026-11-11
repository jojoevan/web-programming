<?php

include("config.php");

// cek apakah tombol simpan sudah diklik
if (isset($_POST['simpan'])) {

    // ambil data dari formulir
    $name = mysqli_real_escape_string($db, trim($_POST['name']));
    $email = mysqli_real_escape_string($db, trim($_POST['email']));
    $age = (int) $_POST['age'];

    // data tidak boleh kosong
    if ($name == "" || $email == "" || $age <= 0) {
        header('Location: index.php?status=gagal');
        exit;
    }

    // buat query simpan
    $sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";
    $query = mysqli_query($db, $sql);

    // alihkan ke index.php dengan status sukses/gagal
    if ($query) {
        header('Location: index.php?status=sukses');
    } else {
        header('Location: index.php?status=gagal');
    }

} else {
    die("Akses dilarang...");
}

?>
