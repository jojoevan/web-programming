<?php
// Koneksi database dengan PDO
$host = "localhost";
$user = "root";
$password = "";
$nama_database = "db_ppdb_smk";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$nama_database;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal terhubung dengan database: " . $e->getMessage());
}

// Tahun ajaran PPDB yang sedang dibuka
define('TAHUN_AJARAN', '2026/2027');
