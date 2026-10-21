const formDaftar = document.getElementById("form-daftar");
const pesanBerhasil = document.getElementById("pesan-berhasil");

formDaftar.addEventListener("submit", function (e) {
  e.preventDefault();

  const anggota = ambilIsiForm();
  const error = validasi(anggota, -1);
  tampilkanError(error);

  if (Object.keys(error).length > 0) {
    pesanBerhasil.classList.add("d-none");
    return;
  }

  anggota.tanggal = new Date().toLocaleDateString("id-ID");
  const daftar = ambilData();
  daftar.push(anggota);
  simpanData(daftar);

  document.getElementById("nama-berhasil").textContent = anggota.nama;
  pesanBerhasil.classList.remove("d-none");
  formDaftar.reset();
});

// Saat form dikosongkan, hapus juga tanda error
formDaftar.addEventListener("reset", function () {
  tampilkanError({});
});
