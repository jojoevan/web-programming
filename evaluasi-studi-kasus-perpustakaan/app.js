// Fungsi bersama untuk semua halaman LibraryReg
const KOLOM = ["nama", "nim", "prodi", "alamat", "telepon", "email", "jenis"];

function ambilData() {
  const data = localStorage.getItem("anggota");
  if (data === null) {
    return [];
  }
  return JSON.parse(data);
}

function simpanData(daftar) {
  localStorage.setItem("anggota", JSON.stringify(daftar));
}

// Ambil isi form (id input sama dengan nama kolom) menjadi objek anggota
function ambilIsiForm() {
  const anggota = {};
  for (const k of KOLOM) {
    anggota[k] = document.getElementById(k).value.trim();
  }
  return anggota;
}

// Hasilnya objek berisi pesan error per kolom. Kalau kosong berarti valid.
// indexEdit = -1 saat daftar baru, atau index anggota yang sedang diedit
function validasi(a, indexEdit) {
  const error = {};

  if (a.nama == "") error.nama = "Nama wajib diisi.";
  if (a.prodi == "") error.prodi = "Pilih program studi / unit.";
  if (a.alamat == "") error.alamat = "Alamat wajib diisi.";
  if (a.jenis == "") error.jenis = "Pilih jenis keanggotaan.";

  if (a.nim == "") {
    error.nim = "NIM/NIP wajib diisi.";
  } else if (!/^[0-9]+$/.test(a.nim)) {
    error.nim = "NIM/NIP hanya boleh berisi angka.";
  } else {
    const daftar = ambilData();
    for (let i = 0; i < daftar.length; i++) {
      if (daftar[i].nim == a.nim && i != indexEdit) {
        error.nim = "NIM/NIP sudah terdaftar.";
      }
    }
  }

  if (a.telepon == "") {
    error.telepon = "Nomor telepon wajib diisi.";
  } else if (!/^[0-9]{10,13}$/.test(a.telepon)) {
    error.telepon = "Nomor telepon harus 10-13 digit angka.";
  }

  if (a.email == "") {
    error.email = "Email wajib diisi.";
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(a.email)) {
    error.email = "Format email tidak valid, contoh: nama@email.com";
  }

  return error;
}

// Beri tanda merah dan pesan di bawah kolom yang salah
function tampilkanError(error) {
  for (const k of KOLOM) {
    const input = document.getElementById(k);
    if (error[k]) {
      input.classList.add("is-invalid");
      input.nextElementSibling.textContent = error[k];
    } else {
      input.classList.remove("is-invalid");
    }
  }
}

// Notifikasi kecil di pojok kanan bawah (toast Bootstrap)
function notifikasi(pesan, warna) {
  const wadah = document.getElementById("wadah-toast");
  const toast = document.createElement("div");
  toast.className = "toast align-items-center text-bg-" + warna + " border-0";
  toast.innerHTML = `<div class="d-flex">
      <div class="toast-body">${pesan}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>`;
  wadah.appendChild(toast);
  new bootstrap.Toast(toast).show();
}

// Supaya teks yang diketik pengguna tidak dibaca sebagai HTML
function aman(teks) {
  return String(teks).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}
