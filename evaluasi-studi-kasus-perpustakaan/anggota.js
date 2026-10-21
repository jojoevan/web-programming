const modalDetail = new bootstrap.Modal(document.getElementById("modal-detail"));
const modalEdit = new bootstrap.Modal(document.getElementById("modal-edit"));
const modalHapus = new bootstrap.Modal(document.getElementById("modal-hapus"));
let indexEdit = -1;
let indexHapus = -1;

// Warna badge untuk setiap jenis keanggotaan
function badgeJenis(jenis) {
  let warna = "primary";
  if (jenis == "Dosen") warna = "success";
  if (jenis == "Tenaga Kependidikan") warna = "warning text-dark";
  return `<span class="badge bg-${warna}">${aman(jenis)}</span>`;
}

function hitungRingkasan(daftar) {
  let mahasiswa = 0, dosen = 0, tendik = 0;
  for (const a of daftar) {
    if (a.jenis == "Mahasiswa") mahasiswa++;
    if (a.jenis == "Dosen") dosen++;
    if (a.jenis == "Tenaga Kependidikan") tendik++;
  }
  document.getElementById("jml-total").textContent = daftar.length;
  document.getElementById("jml-mahasiswa").textContent = mahasiswa;
  document.getElementById("jml-dosen").textContent = dosen;
  document.getElementById("jml-tendik").textContent = tendik;
}

function tampilkanTabel() {
  const daftar = ambilData();
  const cari = document.getElementById("cari").value.toLowerCase();
  const filter = document.getElementById("filter-jenis").value;
  let isi = "";
  let no = 1;

  for (let i = 0; i < daftar.length; i++) {
    const a = daftar[i];
    const cocokCari = a.nama.toLowerCase().includes(cari) || a.nim.includes(cari);
    const cocokJenis = filter == "" || a.jenis == filter;
    if (cocokCari && cocokJenis) {
      isi += `<tr>
        <td>${no++}</td>
        <td class="fw-semibold">${aman(a.nama)}</td>
        <td>${aman(a.nim)}</td>
        <td>${aman(a.prodi)}</td>
        <td>${badgeJenis(a.jenis)}</td>
        <td class="text-center text-nowrap">
          <button class="btn btn-outline-info btn-sm" onclick="lihatDetail(${i})" title="Detail"><i class="bi bi-eye"></i></button>
          <button class="btn btn-outline-warning btn-sm" onclick="editAnggota(${i})" title="Edit"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-outline-danger btn-sm" onclick="hapusAnggota(${i})" title="Hapus"><i class="bi bi-trash"></i></button>
        </td>
      </tr>`;
    }
  }

  if (isi == "") {
    const pesan = daftar.length == 0 ? "Belum ada anggota yang terdaftar." : "Data tidak ditemukan.";
    isi = `<tr><td colspan="6" class="text-center text-muted py-5">
        <i class="bi bi-inbox fs-1 d-block"></i>${pesan}
      </td></tr>`;
  }
  document.getElementById("isi-tabel").innerHTML = isi;
  hitungRingkasan(daftar);
}

function lihatDetail(i) {
  const a = ambilData()[i];
  document.getElementById("isi-detail").innerHTML = `
    <table class="table table-borderless mb-0">
      <tr><th style="width: 40%">Nama</th><td>${aman(a.nama)}</td></tr>
      <tr><th>NIM/NIP</th><td>${aman(a.nim)}</td></tr>
      <tr><th>Jenis Keanggotaan</th><td>${badgeJenis(a.jenis)}</td></tr>
      <tr><th>Program Studi / Unit</th><td>${aman(a.prodi)}</td></tr>
      <tr><th>Alamat</th><td>${aman(a.alamat)}</td></tr>
      <tr><th>Telepon</th><td>${aman(a.telepon)}</td></tr>
      <tr><th>Email</th><td>${aman(a.email)}</td></tr>
      <tr><th>Tanggal Daftar</th><td>${aman(a.tanggal || "-")}</td></tr>
    </table>`;
  modalDetail.show();
}

function editAnggota(i) {
  const a = ambilData()[i];
  indexEdit = i;
  for (const k of KOLOM) {
    document.getElementById(k).value = a[k];
  }
  tampilkanError({});
  modalEdit.show();
}

function hapusAnggota(i) {
  indexHapus = i;
  document.getElementById("nama-hapus").textContent = ambilData()[i].nama;
  modalHapus.show();
}

document.getElementById("tombol-hapus").addEventListener("click", function () {
  const daftar = ambilData();
  daftar.splice(indexHapus, 1);
  simpanData(daftar);
  modalHapus.hide();
  tampilkanTabel();
  notifikasi("Data anggota berhasil dihapus.", "danger");
});

document.getElementById("form-edit").addEventListener("submit", function (e) {
  e.preventDefault();

  const anggota = ambilIsiForm();
  const error = validasi(anggota, indexEdit);
  tampilkanError(error);
  if (Object.keys(error).length > 0) {
    notifikasi("Periksa kembali data yang diisi.", "warning");
    return;
  }

  const daftar = ambilData();
  anggota.tanggal = daftar[indexEdit].tanggal;
  daftar[indexEdit] = anggota;
  simpanData(daftar);
  modalEdit.hide();
  tampilkanTabel();
  notifikasi("Data anggota berhasil diperbarui.", "success");
});

document.getElementById("cari").addEventListener("input", tampilkanTabel);
document.getElementById("filter-jenis").addEventListener("change", tampilkanTabel);

tampilkanTabel();
