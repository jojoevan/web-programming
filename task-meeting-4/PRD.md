# PRD - Website Profil SMA Katolik Frateran Surabaya (Versi 2)

## 1. Latar Belakang

Pada task meeting 3 telah dibuat website profil sekolah sederhana dengan tiga halaman (Home, Jurusan, Kontak). Website tersebut masih kurang lengkap: belum ada sejarah, makna logo, fasilitas, kegiatan, prestasi, maupun informasi penerimaan murid baru. Tampilannya juga belum menyesuaikan layar ponsel dengan baik.

Task meeting 4 melanjutkan website tersebut menjadi lebih lengkap dengan tetap menggunakan HTML dan CSS saja.

## 2. Tujuan

- Menyajikan profil sekolah secara lengkap dalam enam halaman yang saling terhubung.
- Semua isi diambil dari sumber resmi sekolah, bukan data karangan.
- Tampilan rapi di desktop maupun ponsel (responsif).

## 3. Target Pengguna

| Pengguna | Kebutuhan |
|---|---|
| Calon siswa dan orang tua | Mengenal sekolah, jurusan, fasilitas, biaya dan alur pendaftaran |
| Siswa dan alumni | Melihat kegiatan dan prestasi sekolah |
| Masyarakat umum | Mencari alamat, kontak, dan jam operasional |

## 4. Halaman dan Fitur

| Halaman | File | Isi |
|---|---|---|
| Home | `index.html` | Hero dengan foto sekolah, sekilas tentang sekolah, nilai FRATER, cuplikan prestasi, lembaga kerja sama |
| Profil | `profil.html` | Sambutan kepala sekolah, visi, misi, motto, nilai, makna logo, sejarah (tabel linimasa) |
| Akademik | `akademik.html` | Kurikulum, Kelas Natural Science, Kelas Social Science, fasilitas sekolah (galeri foto) |
| Kegiatan | `kegiatan.html` | MPLS, Outdoor Study, Live In, Study Tour, Graduation (dengan video YouTube resmi), prestasi siswa |
| SPMB | `spmb.html` | Alur pendaftaran 3 langkah, jadwal per gelombang, tabel biaya, potongan dan beasiswa |
| Kontak | `kontak.html` | Informasi kontak, jam operasional, media sosial, peta Google Maps, form kirim pesan |

Fitur umum di setiap halaman:

- Header dengan logo dan nama sekolah, serta navigasi dengan penanda halaman aktif.
- Footer berisi alamat singkat, tautan halaman, dan media sosial.
- Layout kartu dan grid menggunakan Flexbox dan CSS Grid.
- Responsif dengan media query, menu turun ke beberapa baris di layar kecil.

## 5. Kebutuhan Non-Fungsional

- Hanya HTML5 dan CSS3, tanpa JavaScript dan tanpa framework.
- Satu file `style.css` untuk semua halaman.
- Setiap gambar memiliki atribut `alt`.
- Tabel memiliki header (`th`) yang jelas.
- Dipublikasikan melalui GitHub Pages.

## 6. Sumber Data

- Website resmi: https://frateran.sch.id/
- Website SPMB: https://spmb.frateran.sch.id/
- Kanal YouTube resmi: https://www.youtube.com/@SMAKFrateran

Bagian yang datanya tidak tersedia di sumber resmi (misalnya jumlah siswa) tidak ditampilkan.

## 7. Di Luar Cakupan

- JavaScript, animasi interaktif, dan framework CSS.
- Form yang benar-benar mengirim pesan (form hanya tampilan).
- Sistem login, E-Learning, dan pendaftaran online (diarahkan ke situs resmi).
- Data ilustrasi atau data yang tidak bersumber dari sekolah.

## 8. Kriteria Selesai

- Enam halaman dapat diakses dan saling terhubung melalui navigasi.
- Semua isi sesuai dengan sumber resmi.
- Tampilan tetap rapi pada lebar layar 375px (ponsel) dan 1280px (desktop).
- Website dapat dibuka melalui URL GitHub Pages.
- Dokumentasi tersedia: screenshot, wireframe, desain UI, dan README.
