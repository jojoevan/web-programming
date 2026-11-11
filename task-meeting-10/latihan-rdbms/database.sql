-- Database untuk latihan RDBMS: menyimpan data pengguna
CREATE DATABASE IF NOT EXISTS latihan_users;
USE latihan_users;

-- Membuat tabel users
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  age INT NOT NULL
);

-- Menambahkan data contoh
INSERT INTO users (name, email, age) VALUES
('Andi Pratama', 'andi@example.com', 25),
('Dewi Lestari', 'dewi@example.com', 30),
('Budi Santoso', 'budi@example.com', 21);

-- Mengambil data pengguna
SELECT * FROM users;
