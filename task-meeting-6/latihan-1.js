const daftarNama = [
  "Agus Santoso",
  "Andi Saputra",
  "Angela Christina",
  "Anisa Rahmawati",
  "Anton Wijaya",
  "Bayu Pratama",
  "Benedictus Halim",
  "Budi Setiawan",
  "Citra Kirana",
  "Clarissa Wijaya",
  "Dimas Prasetyo",
  "Dewi Anggraini",
  "Eka Putra",
  "Elisabeth Tanoto",
  "Fajar Nugroho",
  "Felicia Gunawan",
  "Gilang Ramadhan",
  "Hana Pertiwi",
  "Indra Kusuma",
  "Joko Susilo",
  "Kevin Hartono",
  "Lina Marlina",
  "Michael Susanto",
  "Nadia Safitri",
  "Putri Maharani",
  "Rizky Firmansyah",
  "Sinta Dewi",
  "Teguh Wibowo",
  "Vincent Tanujaya",
  "Yohanes Kurniawan"
];

const form = document.getElementById("form-registrasi");
const inputNama = document.getElementById("nama");
const listSaran = document.getElementById("saran-nama");
const kotakBerhasil = document.getElementById("berhasil");

let saranAktif = -1;

function tampilkanSaran() {
  const kata = inputNama.value.trim().toLowerCase();
  listSaran.innerHTML = "";
  saranAktif = -1;

  if (kata === "") {
    listSaran.hidden = true;
    return;
  }

  const hasil = daftarNama.filter(function (nama) {
    return nama.toLowerCase().includes(kata);
  });

  if (hasil.length === 0) {
    listSaran.hidden = true;
    return;
  }

  hasil.slice(0, 8).forEach(function (nama) {
    const li = document.createElement("li");
    const awal = nama.toLowerCase().indexOf(kata);
    li.append(nama.slice(0, awal));
    const tebal = document.createElement("b");
    tebal.textContent = nama.slice(awal, awal + kata.length);
    li.append(tebal, nama.slice(awal + kata.length));
    li.addEventListener("mousedown", function (e) {
      e.preventDefault();
      pilihSaran(nama);
    });
    listSaran.appendChild(li);
  });

  listSaran.hidden = false;
}

function pilihSaran(nama) {
  inputNama.value = nama;
  listSaran.hidden = true;
  hapusError(inputNama);
}

function tandaiSaran() {
  const item = listSaran.querySelectorAll("li");
  item.forEach(function (li, i) {
    li.classList.toggle("aktif", i === saranAktif);
  });
}

inputNama.addEventListener("input", tampilkanSaran);

inputNama.addEventListener("keydown", function (e) {
  const item = listSaran.querySelectorAll("li");
  if (listSaran.hidden || item.length === 0) {
    return;
  }

  if (e.key === "ArrowDown") {
    e.preventDefault();
    saranAktif = (saranAktif + 1) % item.length;
    tandaiSaran();
  } else if (e.key === "ArrowUp") {
    e.preventDefault();
    saranAktif = (saranAktif - 1 + item.length) % item.length;
    tandaiSaran();
  } else if (e.key === "Enter" && saranAktif >= 0) {
    e.preventDefault();
    pilihSaran(item[saranAktif].textContent);
  } else if (e.key === "Escape") {
    listSaran.hidden = true;
  }
});

inputNama.addEventListener("blur", function () {
  listSaran.hidden = true;
});

function tampilkanError(input, pesan) {
  const field = input.closest(".field");
  field.classList.add("salah");
  let span = field.querySelector(".pesan-error");
  if (!span) {
    span = document.createElement("span");
    span.className = "pesan-error";
    field.appendChild(span);
  }
  span.textContent = pesan;
}

function hapusError(input) {
  const field = input.closest(".field");
  field.classList.remove("salah");
  const span = field.querySelector(".pesan-error");
  if (span) {
    span.remove();
  }
}

function validasi() {
  const nama = inputNama;
  const nim = document.getElementById("nim");
  const matkul = document.getElementById("matkul");
  const dosen = document.getElementById("dosen");
  let valid = true;

  [nama, nim, matkul, dosen].forEach(hapusError);

  if (nama.value.trim() === "") {
    tampilkanError(nama, "Nama tidak boleh kosong");
    valid = false;
  }

  if (nim.value.trim() === "") {
    tampilkanError(nim, "NIM tidak boleh kosong");
    valid = false;
  } else if (!/^\d{5,15}$/.test(nim.value.trim())) {
    tampilkanError(nim, "NIM harus berupa angka 5-15 digit");
    valid = false;
  }

  if (matkul.value === "") {
    tampilkanError(matkul, "Mata kuliah harus dipilih");
    valid = false;
  }

  if (dosen.value === "") {
    tampilkanError(dosen, "Dosen harus dipilih");
    valid = false;
  }

  return valid;
}

function tampilkanBerhasil(data) {
  kotakBerhasil.innerHTML = "";

  const judul = document.createElement("h3");
  judul.innerHTML = '<i class="fa-solid fa-circle-check"></i> Registrasi berhasil';
  kotakBerhasil.appendChild(judul);

  const tabel = document.createElement("table");
  data.forEach(function (baris) {
    const tr = tabel.insertRow();
    tr.insertCell().textContent = baris[0];
    tr.insertCell().textContent = baris[1];
  });
  kotakBerhasil.appendChild(tabel);

  kotakBerhasil.hidden = false;
}

form.addEventListener("submit", function (e) {
  e.preventDefault();
  kotakBerhasil.hidden = true;

  if (!validasi()) {
    return;
  }

  tampilkanBerhasil([
    ["Nama", inputNama.value.trim()],
    ["NIM", document.getElementById("nim").value.trim()],
    ["Mata Kuliah", document.getElementById("matkul").value],
    ["Dosen", document.getElementById("dosen").value]
  ]);

  form.reset();
});

form.addEventListener("reset", function () {
  form.querySelectorAll("input, select").forEach(hapusError);
  listSaran.hidden = true;
});
