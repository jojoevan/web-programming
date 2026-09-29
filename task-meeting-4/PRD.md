# PRODUCT REQUIREMENTS DOCUMENT (PRD)

## Website Profil SMA Katolik Frateran Surabaya (Versi 2)

## 1. Informasi Produk

| Item | Detail |
|---|---|
| Nama Produk | Website Profil SMA Katolik Frateran Surabaya |
| Jenis Produk | Website Informasi & Profil Institusi |
| Target Pengguna | Calon siswa, orang tua, siswa, alumni, masyarakat umum |
| Platform | Web Responsive (desktop dan mobile) |
| Tujuan | Menyediakan informasi resmi sekolah secara terstruktur, menarik, dan mudah diakses |

## 2. Latar Belakang

Pada task meeting 3 telah dibuat website profil sekolah sederhana dengan tiga halaman (Home, Jurusan, Kontak). Website tersebut belum memuat sejarah, makna logo, fasilitas, kegiatan, prestasi, maupun informasi penerimaan murid baru, dan tampilannya belum menyesuaikan layar ponsel dengan baik.

Task meeting 4 melanjutkan website tersebut menjadi media digital yang lebih lengkap untuk menyampaikan identitas sekolah, program akademik, kegiatan siswa, prestasi, fasilitas, dan informasi Sistem Penerimaan Murid Baru (SPMB). Semua isi diambil dari sumber resmi sekolah.

## 3. Tujuan Produk

- Menampilkan profil dan identitas sekolah.
- Menyampaikan informasi akademik dan kelas khusus.
- Menyampaikan informasi kesiswaan: OSIS, ekstrakurikuler, prestasi, dan kegiatan siswa.
- Menampilkan berita dan kegiatan sekolah.
- Menampilkan dokumentasi dalam bentuk galeri.
- Menyediakan informasi SPMB (dahulu PPDB).
- Menyediakan informasi kontak sekolah.
- Memberikan pengalaman pengguna yang responsif pada desktop dan mobile.

## 4. Target Pengguna

**Pengunjung Umum:** Mencari informasi mengenai sekolah, fasilitas, dan kontak.

**Calon Siswa:** Mencari informasi akademik, ekstrakurikuler, kegiatan, prestasi, dan SPMB.

**Orang Tua:** Mencari informasi program sekolah, jadwal dan biaya SPMB, serta kegiatan.

**Siswa dan Alumni:** Melihat berita, kegiatan, prestasi, dan galeri sekolah.

**Guru/Staff:** Tidak menjadi pengguna pengelola karena website bersifat statis tanpa sistem administrasi (lihat bagian 7).

## 5. Struktur Website

```
Website Profil SMA Katolik Frateran Surabaya
│
├── Home (index.html)
│   ├── Tentang Sekolah
│   ├── Nilai FRATER
│   ├── Prestasi Siswa
│   ├── Berita Terbaru
│   └── Lembaga Kerja Sama
├── Profil (profil.html)
│   ├── Sambutan Kepala Sekolah
│   ├── Visi & Misi
│   ├── Motto
│   ├── Makna Logo
│   └── Sejarah Singkat
├── Akademik (akademik.html)
│   ├── Kurikulum
│   ├── Kelas Khusus (Natural Science dan Social Science)
│   └── Fasilitas Sekolah
├── Kesiswaan (kesiswaan.html)
│   ├── OSIS
│   ├── Ekstrakurikuler
│   ├── Prestasi Siswa
│   └── Kegiatan Siswa
├── Berita (berita.html)
│   ├── Cari Berita
│   └── Berita Terbaru (filter kategori, pagination, detail)
├── Galeri (galeri.html)
│   └── Dokumentasi Sekolah (filter kategori, preview foto)
├── SPMB (spmb.html)
│   ├── 3 Langkah Menjadi Fratorian
│   ├── Jadwal Pendaftaran
│   ├── Biaya SPMB
│   └── Potongan dan Beasiswa
└── Kontak (kontak.html)
    ├── Informasi Kontak
    ├── Jam Operasional
    ├── Kirim Pesan
    └── Lokasi
```

Menu PPDB pada layout acuan diberi nama SPMB sesuai istilah yang dipakai sekolah. Halaman Kegiatan pada versi sebelumnya digabung ke halaman Kesiswaan sebagai bagian Kegiatan Siswa.

## 6. Functional Requirements

### FR-01 - Home

- Header dengan logo, nama sekolah, dan navigasi dengan penanda halaman aktif.
- Hero section: nama sekolah, foto sekolah, tombol Profil Sekolah dan Info SPMB.
- Tentang sekolah: tahun berdiri, akreditasi, kelas khusus.
- Keunggulan sekolah: enam nilai FRATER.
- Cuplikan prestasi siswa dengan tautan ke halaman Kesiswaan.
- Berita terbaru (tiga berita) dengan tautan ke halaman Berita.
- Lembaga kerja sama.
- Footer berisi alamat singkat, tautan halaman, dan media sosial.

### FR-02 - Profil Sekolah

- Sambutan kepala sekolah.
- Visi dan misi.
- Motto.
- Makna logo.
- Sejarah singkat dalam bentuk tabel linimasa.

### FR-03 - Akademik

- Kurikulum (Kurikulum Merdeka, Kurikulum 2013, pembelajaran paperless).
- Kelas Natural Science (MIPA) dan Kelas Social Science (IPS).
- Fasilitas sekolah dalam bentuk galeri foto.

### FR-04 - Kesiswaan

- OSIS: dokumentasi LDKS 2023 dan serah terima jabatan pengurus.
- Ekstrakurikuler: Pramuka, Public Speaking, Paduan Suara, Dance, E-Sport, Basket dan Futsal.
- Prestasi siswa dengan poster resmi.
- Kegiatan siswa: MPLS, Outdoor Study, Live In, Study Tour, Graduation, dilengkapi video YouTube resmi sekolah.

### FR-05 - Berita

- Kartu berita berisi judul, thumbnail, tanggal, kategori, ringkasan, dan penulis.
- Detail berita dibuka dengan tombol "Baca selengkapnya" (elemen `details`) beserta tautan ke video sumber.
- Filter kategori: Semua, Kegiatan, Prestasi, Akademik, Fasilitas.
- Pagination dua halaman (enam berita per halaman).
- Search: form pencarian yang diarahkan ke kanal YouTube resmi sekolah.

### FR-06 - Galeri

- Kategori: semua, kegiatan, prestasi, fasilitas, ekstrakurikuler, upacara, laboratorium.
- Klik foto untuk melihat preview ukuran lebih besar.

### FR-07 - SPMB

- Alur pendaftaran tiga langkah: Pre-Registrasi, Tes Potensi Akademik, Pengumuman.
- Jadwal pendaftaran per gelombang.
- Tabel biaya SPMB.
- Potongan dan beasiswa.
- CTA: bagian Daftar Sekarang dengan tombol menuju situs SPMB resmi (spmb.frateran.sch.id).

### FR-08 - Kontak

- Alamat, telepon, email, jam operasional, media sosial.
- Google Maps lokasi sekolah.
- Form: nama, email, subjek, pesan (hanya tampilan, tidak mengirim data).

## 7. Admin / Content Management

Tidak diimplementasikan. Website ini statis (HTML dan CSS saja), sehingga isi halaman diubah langsung pada file HTML dan dipublikasikan ulang melalui GitHub Pages. Admin dashboard dan operasi CRUD termasuk pengembangan berikutnya (lihat bagian 11).

## 8. Non-Functional Requirements

### Responsive

- Desktop.
- Tablet.
- Mobile: media query pada lebar 768px, navigasi turun ke beberapa baris.

### Performance

- Gambar memakai format JPG/PNG yang umum didukung browser.
- Satu file `style.css` untuk semua halaman.
- Tanpa JavaScript dan tanpa framework sehingga halaman ringan.
- Filter, pagination, dan preview galeri dibuat dengan CSS saja (radio button, `:checked`, dan `:target`).

### Accessibility

- Kontras warna teks dengan latar (warna utama navy #1e3a8a).
- Ukuran teks yang mudah dibaca.
- Setiap gambar memiliki atribut `alt`.
- Tombol filter dan pagination memakai `label` yang terhubung ke radio button.
- Semua tautan dan form dapat diakses dengan keyboard.
- Struktur heading berurutan (`h1`, `h2`, `h3`) dan tabel memiliki header `th`.

### Security

- Validasi input form dengan atribut HTML (`required`, `type="email"`).
- HTTPS melalui GitHub Pages.
- Tidak ada data pengguna yang disimpan karena tidak ada backend.

## 9. Teknologi yang Digunakan

### Level 1 - Static Website

```
HTML5 + CSS3 (Flexbox, CSS Grid, media query)
```

- Tanpa JavaScript dan tanpa Bootstrap sesuai ketentuan tugas.
- Version control: Git + GitHub.
- Deployment: GitHub Pages.

## 10. Struktur Database

Tidak menggunakan database. Semua data ditulis langsung pada file HTML. Sumber data:

- Website resmi: https://frateran.sch.id/
- Website SPMB: https://spmb.frateran.sch.id/
- Kanal YouTube resmi: https://www.youtube.com/@SMAKFrateran (sumber berita, dokumentasi OSIS, ekstrakurikuler, dan sebagian foto galeri)

Bagian yang datanya tidak tersedia di sumber resmi (misalnya jumlah siswa) tidak ditampilkan. Tanggal berita mengikuti tanggal unggah video di kanal YouTube resmi.

## 11. Prioritas Fitur

### MVP (sudah dikerjakan)

- Home
- Profil
- Akademik
- Kesiswaan
- Berita
- Galeri
- SPMB
- Kontak
- Responsive Design
- Integrasi Google Maps
- Integrasi media sosial dan video YouTube

### Pengembangan Berikutnya

- Admin Dashboard
- Database
- Login Admin
- CMS Berita
- CMS Galeri
- Search berita di dalam website sendiri
- Form kontak yang benar-benar mengirim pesan
- Statistik pengunjung

## 12. User Flow

```
Pengunjung
    │
    ▼
  Home
    │
    ├── Profil
    ├── Akademik
    ├── Kesiswaan
    ├── Berita
    ├── Galeri
    ├── SPMB
    └── Kontak
```

### Contoh Flow Calon Siswa

```
Home → Profil → Akademik (Kelas Khusus) → Kesiswaan (Prestasi) → SPMB → Biaya → Daftar Sekarang
```

## 13. Struktur Project

```
task-meeting-4/
│
├── index.html
├── profil.html
├── akademik.html
├── kesiswaan.html
├── berita.html
├── galeri.html
├── spmb.html
├── kontak.html
├── style.css
├── PRD.md
├── README.md
├── images/
│   ├── berita/
│   ├── fasilitas/
│   ├── galeri/
│   └── prestasi/
├── wireframe/
└── screenshots/
```

Semua halaman berada di satu folder agar tautan antarhalaman sederhana, dan tidak ada folder `js/` maupun `components/` karena tidak memakai JavaScript.

## 14. Acceptance Criteria

- Semua menu utama dapat diakses.
- Navigasi berfungsi dan menandai halaman aktif.
- Tampilan responsive pada lebar 375px (ponsel) dan 1280px (desktop).
- Konten profil sekolah tersedia dan sesuai sumber resmi.
- Informasi kesiswaan (OSIS, ekstrakurikuler, prestasi, kegiatan) tersedia.
- Berita dapat ditampilkan, difilter per kategori, dan dibuka detailnya.
- Galeri dapat ditampilkan, difilter per kategori, dan dipreview dalam ukuran besar.
- Informasi SPMB tersedia.
- Form kontak dapat diisi dan divalidasi.
- Footer tersedia pada seluruh halaman.
- Tidak terdapat broken link.
- Website dapat dijalankan secara lokal.
- Project disimpan di GitHub dan dapat dibuka melalui GitHub Pages.

## 15. Tahapan Pengerjaan

**Tema:** "Membangun Website Profil Sekolah SMA yang Informatif dan Responsive."

1. Analisis kebutuhan
2. Sitemap
3. Wireframe
4. UI Design
5. HTML
6. CSS
7. Git + GitHub
8. Testing
9. Deployment (GitHub Pages)

**Output:** Website Profil Sekolah + Source Code + GitHub Repository + Dokumentasi (PRD, wireframe, screenshot, desain UI).
