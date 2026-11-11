# Spesifikasi Proyek Website

## Nama Proyek

**PPDB Online SMK Nusantara** (Penerimaan Peserta Didik Baru)

## Deskripsi

PPDB Online SMK Nusantara adalah website untuk pendaftaran siswa baru secara daring. Calon siswa membuat akun, mengisi formulir pendaftaran, mengunggah berkas, membayar biaya pendaftaran, lalu memantau status seleksinya dari rumah. Panitia sekolah memakai halaman admin untuk memeriksa data pendaftar, memverifikasi berkas dan pembayaran, serta mengumumkan hasil seleksi.

Proyek ini melanjutkan aplikasi Pendaftaran Siswa Baru pada [task-meeting-9](../task-meeting-9/) yang baru berisi CRUD data calon siswa.

## Tujuan

1. Memudahkan calon siswa mendaftar tanpa harus datang ke sekolah.
2. Mengurangi pencatatan manual di kertas sehingga data pendaftar tersimpan rapi di satu database.
3. Mempercepat panitia dalam memverifikasi berkas dan pembayaran.
4. Membuat proses seleksi lebih terbuka karena status dan hasilnya bisa dilihat langsung oleh pendaftar.

## Fitur

### Front End

| Halaman | Isi |
|---|---|
| Beranda | Informasi sekolah, jurusan, jadwal, dan alur pendaftaran |
| Daftar Akun dan Login | Formulir pembuatan akun dan masuk untuk calon siswa |
| Formulir Pendaftaran | Data diri, data orang tua, sekolah asal, nilai rapor, pilihan jurusan, unggah berkas |
| Pembayaran | Tagihan biaya pendaftaran dan pilihan metode pembayaran |
| Status Pendaftaran | Tahap pendaftaran saat ini: berkas, pembayaran, hasil seleksi |
| Pengumuman | Daftar siswa yang diterima per jurusan |
| Dashboard Admin | Jumlah pendaftar, tabel pendaftar, verifikasi berkas, input hasil seleksi |

### Back End

| Fitur | Keterangan |
|---|---|
| Manajemen akun | Registrasi, login, logout, dan pembagian peran (calon siswa dan admin) |
| CRUD pendaftaran | Simpan, tampilkan, ubah, dan hapus data pendaftaran |
| Unggah berkas | Menyimpan file ijazah/rapor, pas foto, dan kartu keluarga |
| Verifikasi | Admin menyetujui atau menolak berkas disertai catatan |
| Pembayaran | Membuat tagihan dan menerima konfirmasi dari payment gateway |
| Seleksi | Mengurutkan pendaftar berdasarkan nilai dan kuota jurusan |
| Laporan | Rekap pendaftar per jurusan yang bisa diunduh admin |

## Ruang Lingkup Proyek

### 1. Pengelolaan Data

Data disimpan di MySQL karena datanya terstruktur dan saling berhubungan. Tabel utamanya:

| Tabel | Isi |
|---|---|
| `users` | Akun login: nama, email, password, peran |
| `calon_siswa` | Data diri pendaftar, terhubung ke `users` |
| `jurusan` | Nama jurusan dan kuota |
| `pendaftaran` | Pilihan jurusan, nilai, status, terhubung ke `calon_siswa` dan `jurusan` |
| `berkas` | File yang diunggah dan status verifikasinya |
| `pembayaran` | Tagihan, metode, status, dan waktu pembayaran |

### 2. Logika Bisnis

- Satu akun hanya boleh memiliki satu pendaftaran.
- Pendaftaran hanya bisa dilakukan selama periode pendaftaran dibuka.
- Alur status: **Draf → Menunggu Pembayaran → Menunggu Verifikasi → Terverifikasi → Diterima / Tidak Diterima**.
- Berkas baru diperiksa admin setelah pembayaran lunas.
- Seleksi diurutkan dari rata-rata nilai rapor tertinggi sampai kuota jurusan terpenuhi.
- Pendaftar yang berkasnya ditolak bisa mengunggah ulang sebelum pendaftaran ditutup.

### 3. Autentikasi dan Security

- Login memakai email dan password dengan session PHP.
- Password disimpan dalam bentuk hash (`password_hash`), bukan teks asli.
- Halaman admin hanya bisa dibuka oleh akun berperan admin.
- Query memakai prepared statement untuk mencegah SQL Injection.
- Output di-escape dengan `htmlspecialchars` untuk mencegah XSS.
- Formulir dilindungi token CSRF.
- Berkas unggahan dibatasi jenisnya (PDF, JPG, PNG) dan ukurannya (maksimal 2 MB).
- Website dijalankan dengan HTTPS.

### 4. API (Application Programming Interface)

| API | Kegunaan |
|---|---|
| Payment Gateway (Midtrans) | Membuat transaksi biaya pendaftaran (transfer bank, QRIS, e-wallet) dan mengirim notifikasi ke server saat pembayaran berhasil |
| Email (SMTP) | Mengirim bukti pendaftaran dan pemberitahuan hasil seleksi |
| API internal | Endpoint JSON, misalnya `GET /api/status-pendaftaran` dan `POST /api/pembayaran/notifikasi` |

## Teknologi

| Bagian | Teknologi |
|---|---|
| Front End | HTML, CSS, JavaScript, Bootstrap |
| Back End | PHP |
| Database | MySQL |
| Pembayaran | Midtrans |
| Server lokal | XAMPP |

## Rencana Implementasi

| Minggu | Kegiatan | Hasil |
|---|---|---|
| 1 | Analisis kebutuhan dan perancangan database (ERD) | Daftar fitur dan rancangan tabel |
| 2 | Desain tampilan dan pembuatan halaman front end | Halaman beranda, login, dan formulir |
| 3 | Back end: akun, login, dan CRUD pendaftaran | Calon siswa bisa mendaftar dan login |
| 4 | Unggah berkas dan dashboard admin | Admin bisa memverifikasi berkas |
| 5 | Integrasi payment gateway dan email | Pembayaran dan notifikasi berjalan |
| 6 | Seleksi, pengumuman, dan laporan | Hasil seleksi tampil di website |
| 7 | Pengujian dan perbaikan | Daftar bug sudah diperbaiki |
| 8 | Hosting dan serah terima | Website bisa diakses secara online |
