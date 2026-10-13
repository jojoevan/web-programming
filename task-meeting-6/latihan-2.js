const dataKodePos = [
  { kecamatan: "Asem Rowo", kelurahan: "Asem Rowo", kodePos: "60182" },
  { kecamatan: "Asem Rowo", kelurahan: "Genting Kalianak", kodePos: "60183" },
  { kecamatan: "Asem Rowo", kelurahan: "Tambak Sarioso", kodePos: "60184" },
  { kecamatan: "Benowo", kelurahan: "Kandangan", kodePos: "60199" },
  { kecamatan: "Benowo", kelurahan: "Romokalisari", kodePos: "60192" },
  { kecamatan: "Benowo", kelurahan: "Sememi", kodePos: "60198" },
  { kecamatan: "Benowo", kelurahan: "Tambak Oso Wilangun", kodePos: "60191" },
  { kecamatan: "Bubutan", kelurahan: "Alun-alun Contong", kodePos: "60174" },
  { kecamatan: "Bubutan", kelurahan: "Bubutan", kodePos: "60174" },
  { kecamatan: "Bubutan", kelurahan: "Gundih", kodePos: "60172" },
  { kecamatan: "Bubutan", kelurahan: "Jepara", kodePos: "60171" },
  { kecamatan: "Bubutan", kelurahan: "Tembok Dukuh", kodePos: "60173" },
  { kecamatan: "Bulak", kelurahan: "Bulak", kodePos: "60124" },
  { kecamatan: "Bulak", kelurahan: "Kedung Cowek", kodePos: "60125" },
  { kecamatan: "Bulak", kelurahan: "Kenjeran", kodePos: "60123" },
  { kecamatan: "Bulak", kelurahan: "Sukolilo Baru", kodePos: "60122" },
  { kecamatan: "Dukuh Pakis", kelurahan: "Dukuh Kupang", kodePos: "60225" },
  { kecamatan: "Dukuh Pakis", kelurahan: "Dukuh Pakis", kodePos: "60225" },
  { kecamatan: "Dukuh Pakis", kelurahan: "Gunung Sari", kodePos: "60224" },
  { kecamatan: "Dukuh Pakis", kelurahan: "Pradah Kalikendal", kodePos: "60226" },
  { kecamatan: "Gayungan", kelurahan: "Dukuh Menanggal", kodePos: "60234" },
  { kecamatan: "Gayungan", kelurahan: "Gayungan", kodePos: "60235" },
  { kecamatan: "Gayungan", kelurahan: "Ketintang", kodePos: "60231" },
  { kecamatan: "Gayungan", kelurahan: "Menanggal", kodePos: "60234" },
  { kecamatan: "Genteng", kelurahan: "Embong Kaliasin", kodePos: "60271" },
  { kecamatan: "Genteng", kelurahan: "Genteng", kodePos: "60275" },
  { kecamatan: "Genteng", kelurahan: "Kapasari", kodePos: "60273" },
  { kecamatan: "Genteng", kelurahan: "Ketabang", kodePos: "60272" },
  { kecamatan: "Genteng", kelurahan: "Peneleh", kodePos: "60274" },
  { kecamatan: "Gubeng", kelurahan: "Airlangga", kodePos: "60286" },
  { kecamatan: "Gubeng", kelurahan: "Baratajaya", kodePos: "60284" },
  { kecamatan: "Gubeng", kelurahan: "Gubeng", kodePos: "60281" },
  { kecamatan: "Gubeng", kelurahan: "Kertajaya", kodePos: "60282" },
  { kecamatan: "Gubeng", kelurahan: "Mojo", kodePos: "60285" },
  { kecamatan: "Gubeng", kelurahan: "Pucang Sewu", kodePos: "60283" },
  { kecamatan: "Gunung Anyar", kelurahan: "Gunung Anyar", kodePos: "60294" },
  { kecamatan: "Gunung Anyar", kelurahan: "Gunung Anyar Tambak", kodePos: "60294" },
  { kecamatan: "Gunung Anyar", kelurahan: "Rungkut Menanggal", kodePos: "60293" },
  { kecamatan: "Gunung Anyar", kelurahan: "Rungkut Tengah", kodePos: "60293" },
  { kecamatan: "Jambangan", kelurahan: "Jambangan", kodePos: "60232" },
  { kecamatan: "Jambangan", kelurahan: "Karah", kodePos: "60232" },
  { kecamatan: "Jambangan", kelurahan: "Kebonsari", kodePos: "60233" },
  { kecamatan: "Jambangan", kelurahan: "Pagesangan", kodePos: "60233" },
  { kecamatan: "Karang Pilang", kelurahan: "Karang Pilang", kodePos: "60221" },
  { kecamatan: "Karang Pilang", kelurahan: "Kebraon", kodePos: "60222" },
  { kecamatan: "Karang Pilang", kelurahan: "Kedurus", kodePos: "60223" },
  { kecamatan: "Karang Pilang", kelurahan: "Waru Gunung", kodePos: "60221" },
  { kecamatan: "Kenjeran", kelurahan: "Bulak Banteng", kodePos: "60127" },
  { kecamatan: "Kenjeran", kelurahan: "Sidotopo Wetan", kodePos: "60128" },
  { kecamatan: "Kenjeran", kelurahan: "Tambak Wedi", kodePos: "60126" },
  { kecamatan: "Kenjeran", kelurahan: "Tanah Kali Kedinding", kodePos: "60129" },
  { kecamatan: "Krembangan", kelurahan: "Dupak", kodePos: "60179" },
  { kecamatan: "Krembangan", kelurahan: "Kemayoran", kodePos: "60176" },
  { kecamatan: "Krembangan", kelurahan: "Krembangan Selatan", kodePos: "60175" },
  { kecamatan: "Krembangan", kelurahan: "Morokrembangan", kodePos: "60178" },
  { kecamatan: "Krembangan", kelurahan: "Perak Barat", kodePos: "60177" },
  { kecamatan: "Lakarsantri", kelurahan: "Bangkingan", kodePos: "60214" },
  { kecamatan: "Lakarsantri", kelurahan: "Jeruk", kodePos: "60212" },
  { kecamatan: "Lakarsantri", kelurahan: "Lakarsantri", kodePos: "60211" },
  { kecamatan: "Lakarsantri", kelurahan: "Lidah kulon", kodePos: "60213" },
  { kecamatan: "Lakarsantri", kelurahan: "Lidah Wetan", kodePos: "60213" },
  { kecamatan: "Lakarsantri", kelurahan: "Sumurwelut", kodePos: "60215" },
  { kecamatan: "Mulyorejo", kelurahan: "Dukuh Sutorejo", kodePos: "60113" },
  { kecamatan: "Mulyorejo", kelurahan: "Kalijudan", kodePos: "60114" },
  { kecamatan: "Mulyorejo", kelurahan: "Kalisari", kodePos: "60112" },
  { kecamatan: "Mulyorejo", kelurahan: "Kejawaan Putih Tambak", kodePos: "60112" },
  { kecamatan: "Mulyorejo", kelurahan: "Manyar Sabrangan", kodePos: "60116" },
  { kecamatan: "Mulyorejo", kelurahan: "Mulyorejo", kodePos: "60115" },
  { kecamatan: "Pabean Cantian", kelurahan: "Bongkaran", kodePos: "60161" },
  { kecamatan: "Pabean Cantian", kelurahan: "Krembangan Utara", kodePos: "60163" },
  { kecamatan: "Pabean Cantian", kelurahan: "Nyamplungan", kodePos: "60162" },
  { kecamatan: "Pabean Cantian", kelurahan: "Tanjung Perak", kodePos: "60164" },
  { kecamatan: "Pakal", kelurahan: "Babat Jerawat", kodePos: "60197" },
  { kecamatan: "Pakal", kelurahan: "Benowo", kodePos: "60195" },
  { kecamatan: "Pakal", kelurahan: "Pakal", kodePos: "60196" },
  { kecamatan: "Pakal", kelurahan: "Sumber Rejo", kodePos: "60192" },
  { kecamatan: "Rungkut", kelurahan: "Kalirungkut", kodePos: "60293" },
  { kecamatan: "Rungkut", kelurahan: "Kedung Baruk", kodePos: "60298" },
  { kecamatan: "Rungkut", kelurahan: "Medokan Ayu", kodePos: "60295" },
  { kecamatan: "Rungkut", kelurahan: "Penjaringansari", kodePos: "60297" },
  { kecamatan: "Rungkut", kelurahan: "Rungkut Kidul", kodePos: "60293" },
  { kecamatan: "Rungkut", kelurahan: "Wonorejo", kodePos: "60296" },
  { kecamatan: "Sambikerep", kelurahan: "Beringin", kodePos: "60218" },
  { kecamatan: "Sambikerep", kelurahan: "Lontar", kodePos: "60216" },
  { kecamatan: "Sambikerep", kelurahan: "Made", kodePos: "60219" },
  { kecamatan: "Sambikerep", kelurahan: "Sambikerep", kodePos: "60217" },
  { kecamatan: "Sawahan", kelurahan: "Banyu Urip", kodePos: "60254" },
  { kecamatan: "Sawahan", kelurahan: "Kupang Krajan", kodePos: "60253" },
  { kecamatan: "Sawahan", kelurahan: "Pakis", kodePos: "60256" },
  { kecamatan: "Sawahan", kelurahan: "Petemon", kodePos: "60252" },
  { kecamatan: "Sawahan", kelurahan: "Putat Jaya", kodePos: "60255" },
  { kecamatan: "Sawahan", kelurahan: "Sawahan", kodePos: "60251" },
  { kecamatan: "Semampir", kelurahan: "Ampel", kodePos: "60151" },
  { kecamatan: "Semampir", kelurahan: "Pegirian", kodePos: "60153" },
  { kecamatan: "Semampir", kelurahan: "Sidotopo", kodePos: "60152" },
  { kecamatan: "Semampir", kelurahan: "Ujung", kodePos: "60155" },
  { kecamatan: "Semampir", kelurahan: "Wonokusumo", kodePos: "60154" },
  { kecamatan: "Simokerto", kelurahan: "Kapasan", kodePos: "60141" },
  { kecamatan: "Simokerto", kelurahan: "Sidodadi", kodePos: "60145" },
  { kecamatan: "Simokerto", kelurahan: "Simokerto", kodePos: "60143" },
  { kecamatan: "Simokerto", kelurahan: "Simolawang", kodePos: "60144" },
  { kecamatan: "Simokerto", kelurahan: "Tambakrejo", kodePos: "60142" },
  { kecamatan: "Sukolilo", kelurahan: "Gebang Putih", kodePos: "60117" },
  { kecamatan: "Sukolilo", kelurahan: "Keputih", kodePos: "60111" },
  { kecamatan: "Sukolilo", kelurahan: "Klampis Ngasem", kodePos: "60117" },
  { kecamatan: "Sukolilo", kelurahan: "Medokan Semampir", kodePos: "60119" },
  { kecamatan: "Sukolilo", kelurahan: "Menur Pumpungan", kodePos: "60118" },
  { kecamatan: "Sukolilo", kelurahan: "Nginden Jangkungan", kodePos: "60118" },
  { kecamatan: "Sukolilo", kelurahan: "Semolowaru", kodePos: "60119" },
  { kecamatan: "Sukomanunggal", kelurahan: "Putat Gede", kodePos: "60189" },
  { kecamatan: "Sukomanunggal", kelurahan: "Simomulyo", kodePos: "60281" },
  { kecamatan: "Sukomanunggal", kelurahan: "Simomulyo Baru", kodePos: "60281" },
  { kecamatan: "Sukomanunggal", kelurahan: "Sonokwijenan", kodePos: "60189" },
  { kecamatan: "Sukomanunggal", kelurahan: "Sukomanunggal", kodePos: "60188" },
  { kecamatan: "Sukomanunggal", kelurahan: "Tanjungsari", kodePos: "60187" },
  { kecamatan: "Tambaksari", kelurahan: "Dukuh Setro", kodePos: "60138" },
  { kecamatan: "Tambaksari", kelurahan: "Gading", kodePos: "60134" },
  { kecamatan: "Tambaksari", kelurahan: "Kapas Madya Baru", kodePos: "60137" },
  { kecamatan: "Tambaksari", kelurahan: "Pacarkeling", kodePos: "60131" },
  { kecamatan: "Tambaksari", kelurahan: "Pacarkembang", kodePos: "60132" },
  { kecamatan: "Tambaksari", kelurahan: "Ploso", kodePos: "60133" },
  { kecamatan: "Tambaksari", kelurahan: "Rangkah", kodePos: "60135" },
  { kecamatan: "Tambaksari", kelurahan: "Tambaksari", kodePos: "60136" },
  { kecamatan: "Tandes", kelurahan: "Balongsari", kodePos: "60186" },
  { kecamatan: "Tandes", kelurahan: "Banjar Sugihan", kodePos: "60185" },
  { kecamatan: "Tandes", kelurahan: "Karang Poh", kodePos: "60186" },
  { kecamatan: "Tandes", kelurahan: "Manukan Kulon", kodePos: "60185" },
  { kecamatan: "Tandes", kelurahan: "Manukan Wetan", kodePos: "60184" },
  { kecamatan: "Tandes", kelurahan: "Tandes", kodePos: "60187" },
  { kecamatan: "Tegalsari", kelurahan: "Dr. Soetomo", kodePos: "60264" },
  { kecamatan: "Tegalsari", kelurahan: "Kedungdoro", kodePos: "60261" },
  { kecamatan: "Tegalsari", kelurahan: "Keputran", kodePos: "60265" },
  { kecamatan: "Tegalsari", kelurahan: "Tegalsari", kodePos: "60262" },
  { kecamatan: "Tegalsari", kelurahan: "Wonorejo", kodePos: "60263" },
  { kecamatan: "Tenggilis Mejoyo", kelurahan: "Kendangsari", kodePos: "60292" },
  { kecamatan: "Tenggilis Mejoyo", kelurahan: "Kutisari", kodePos: "60291" },
  { kecamatan: "Tenggilis Mejoyo", kelurahan: "Panjang Jiwo", kodePos: "60299" },
  { kecamatan: "Tenggilis Mejoyo", kelurahan: "Tengilis Mejoyo", kodePos: "60292" },
  { kecamatan: "Wiyung", kelurahan: "Babatan", kodePos: "60227" },
  { kecamatan: "Wiyung", kelurahan: "Balas Klumprik", kodePos: "60222" },
  { kecamatan: "Wiyung", kelurahan: "Jajar Tunggal", kodePos: "60229" },
  { kecamatan: "Wiyung", kelurahan: "Wiyung", kodePos: "60228" },
  { kecamatan: "Wonocolo", kelurahan: "Bendul Merisi", kodePos: "60239" },
  { kecamatan: "Wonocolo", kelurahan: "Jemur Wonosari", kodePos: "60237" },
  { kecamatan: "Wonocolo", kelurahan: "Margorejo", kodePos: "60238" },
  { kecamatan: "Wonocolo", kelurahan: "Sidosermo", kodePos: "60239" },
  { kecamatan: "Wonocolo", kelurahan: "Siwalankerto", kodePos: "60236" },
  { kecamatan: "Wonokromo", kelurahan: "Darmo", kodePos: "60241" },
  { kecamatan: "Wonokromo", kelurahan: "Jagir", kodePos: "60244" },
  { kecamatan: "Wonokromo", kelurahan: "Ngagel", kodePos: "60246" },
  { kecamatan: "Wonokromo", kelurahan: "Ngagel Rejo", kodePos: "60245" },
  { kecamatan: "Wonokromo", kelurahan: "Sawunggaling", kodePos: "60242" },
  { kecamatan: "Wonokromo", kelurahan: "Wonokromo", kodePos: "60243" }
];

const form = document.getElementById("form-kodepos");
const selectKecamatan = document.getElementById("kecamatan");
const inputKataKunci = document.getElementById("kata-kunci");
const bagianHasil = document.getElementById("hasil");
const hasilInfo = document.getElementById("hasil-info");
const hasilGrid = document.getElementById("hasil-grid");

const daftarKecamatan = [];
dataKodePos.forEach(function (data) {
  if (!daftarKecamatan.includes(data.kecamatan)) {
    daftarKecamatan.push(data.kecamatan);
  }
});

daftarKecamatan.forEach(function (kecamatan) {
  const option = document.createElement("option");
  option.textContent = kecamatan;
  selectKecamatan.appendChild(option);
});

function cariKodePos() {
  const kecamatan = selectKecamatan.value;
  const kataKunci = inputKataKunci.value.trim().toLowerCase();

  const hasil = dataKodePos.filter(function (data) {
    const cocokKecamatan = kecamatan === "" || data.kecamatan === kecamatan;
    const cocokKataKunci = kataKunci === "" ||
      data.kelurahan.toLowerCase().includes(kataKunci) ||
      data.kodePos.includes(kataKunci);
    return cocokKecamatan && cocokKataKunci;
  });

  hasilGrid.innerHTML = "";

  let keterangan = "";
  if (kataKunci !== "") {
    keterangan += ' dengan kata kunci "' + inputKataKunci.value.trim() + '"';
  }
  keterangan += kecamatan !== "" ? " di Kecamatan " + kecamatan : " di Kota Surabaya";

  if (hasil.length === 0) {
    hasilInfo.textContent = "Kode pos" + keterangan + " tidak ditemukan.";
  } else {
    hasilInfo.textContent = "Hasil pencarian kode pos" + keterangan + " telah ditemukan sebanyak " + hasil.length + " buah.";
  }

  hasil.forEach(function (data) {
    const item = document.createElement("div");
    item.className = "hasil-item";

    const judul = document.createElement("h3");
    judul.textContent = data.kelurahan;

    const isi = document.createElement("p");
    const kode = document.createElement("b");
    kode.textContent = data.kodePos;
    isi.append("Kode pos ", kode, " untuk daerah Kelurahan " + data.kelurahan + ", Kecamatan " + data.kecamatan + ".");

    item.append(judul, isi);
    hasilGrid.appendChild(item);
  });

  bagianHasil.hidden = false;
}

form.addEventListener("submit", function (e) {
  e.preventDefault();
  cariKodePos();
});

selectKecamatan.addEventListener("change", cariKodePos);
