const form = document.getElementById("form-pendaftaran");
const kotakBerhasil = document.getElementById("berhasil");

const aturan = {
  nama: function (nilai) {
    if (nilai === "") {
      return "Nama tidak boleh kosong";
    }
    if (!/^[A-Za-z\s]+$/.test(nilai)) {
      return "Nama hanya boleh berisi huruf dan spasi";
    }
    return "";
  },
  alamat: function (nilai) {
    return nilai === "" ? "Alamat tidak boleh kosong" : "";
  },
  email: function (nilai) {
    if (nilai === "") {
      return "Email tidak boleh kosong";
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(nilai)) {
      return "Format email tidak valid, contoh: nama@domain.com";
    }
    return "";
  },
  password: function (nilai) {
    if (nilai === "") {
      return "Password tidak boleh kosong";
    }
    if (nilai.length < 8) {
      return "Password minimal 8 karakter";
    }
    if (!/[A-Za-z]/.test(nilai) || !/\d/.test(nilai)) {
      return "Password harus berisi huruf dan angka";
    }
    return "";
  },
  prodi: function (nilai) {
    return nilai === "" ? "Program studi harus dipilih" : "";
  },
  kampus: function (nilai) {
    return nilai === "" ? "Nama kampus tidak boleh kosong" : "";
  },
  setuju: function (nilai, input) {
    return input.checked ? "" : "Anda harus menyetujui pernyataan ini";
  }
};

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

function periksa(id) {
  const input = document.getElementById(id);
  const pesan = aturan[id](input.value.trim(), input);
  if (pesan === "") {
    hapusError(input);
    return true;
  }
  tampilkanError(input, pesan);
  return false;
}

Object.keys(aturan).forEach(function (id) {
  const input = document.getElementById(id);
  const event = input.type === "checkbox" ? "change" : "blur";
  input.addEventListener(event, function () {
    periksa(id);
  });
});

function tampilkanBerhasil(data) {
  kotakBerhasil.innerHTML = "";

  const judul = document.createElement("h3");
  judul.innerHTML = '<i class="fa-solid fa-circle-check"></i> Pendaftaran berhasil';
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

  let valid = true;
  Object.keys(aturan).forEach(function (id) {
    if (!periksa(id)) {
      valid = false;
    }
  });

  if (!valid) {
    form.querySelector(".salah input, .salah select, .salah textarea").focus();
    return;
  }

  tampilkanBerhasil([
    ["Nama", document.getElementById("nama").value.trim()],
    ["Alamat", document.getElementById("alamat").value.trim()],
    ["Email", document.getElementById("email").value.trim()],
    ["Program Studi", document.getElementById("prodi").value],
    ["Nama Kampus", document.getElementById("kampus").value.trim()]
  ]);

  form.reset();
});

form.addEventListener("reset", function () {
  Object.keys(aturan).forEach(function (id) {
    hapusError(document.getElementById(id));
  });
});
