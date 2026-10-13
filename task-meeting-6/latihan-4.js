const dataProduk = {
  Desktop: ["Dell", "HP", "Lenovo", "Acer"],
  Laptop: ["Asus", "Acer", "Lenovo", "Apple", "HP"],
  Smartphone: ["Samsung", "Apple", "Xiaomi", "Oppo", "Vivo"]
};

const selectJenis = document.getElementById("jenis");
const selectMerk = document.getElementById("merk");
const teksPilihan = document.getElementById("pilihan");

Object.keys(dataProduk).forEach(function (jenis) {
  const option = document.createElement("option");
  option.textContent = jenis;
  selectJenis.appendChild(option);
});

function tampilkanPilihan() {
  if (selectJenis.value === "" || selectMerk.value === "") {
    teksPilihan.hidden = true;
    return;
  }
  teksPilihan.textContent = "Anda memilih: " + selectJenis.value + " - " + selectMerk.value;
  teksPilihan.hidden = false;
}

selectJenis.addEventListener("change", function () {
  selectMerk.innerHTML = '<option value="">Pilih Merk</option>';

  const daftarMerk = dataProduk[selectJenis.value];
  if (daftarMerk) {
    daftarMerk.forEach(function (merk) {
      const option = document.createElement("option");
      option.textContent = merk;
      selectMerk.appendChild(option);
    });
  }

  selectMerk.disabled = !daftarMerk;
  tampilkanPilihan();
});

selectMerk.addEventListener("change", tampilkanPilihan);
