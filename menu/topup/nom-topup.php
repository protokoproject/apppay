<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover" />
  <title>Top Up</title>
  <!-- Favicon and Touch Icons  -->
  <link rel="shortcut icon" href="../../images/logo.png" />
  <link rel="apple-touch-icon-precomposed" href="images/logo.png" />
  <!-- Font -->
  <link rel="stylesheet" href="../../fonts/fonts.css" />
  <!-- Icons -->
  <link rel="stylesheet" href="../../fonts/icons-alipay.css ">
  <link rel="stylesheet" href="../../styles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
  <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
  <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
</head>

<body>
  <!-- preloade -->
  <div class="preload preload-container">
    <div class="preload-logo">
      <div class="spinner"></div>
    </div>
  </div>
  <!-- /preload -->
  <div class="app-header st1">
    <div class="tf-container">
      <div class="tf-topbar d-flex justify-content-center align-items-center">
        <a href="home.php" class="back-btn"><i class="icon-left white_color"></i></a>
        <h3 class="white_color">Top Up</h3>
      </div>
    </div>
  </div>
  <div class="card-secton topup-content">
    <div class="tf-container">
      <div class="tf-balance-box">
        <div class="tf-form">
          <div class="group-input input-field input-money">
            <label for="input-topup">Jumlah Top Up</label>
            <input id="input-topup" type="text" value="0" required class="search-field value_input st1" />
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-navigation-bar">
      <div class="tf-container">
        <a href="#" id="btn-popup-up" class="tf-btn accent large">Selanjutnya</a>
      </div>
    </div>
  </div>

  <div class="amount-money mt-5">
    <div class="tf-container">
      <h3>Jumlah Top Up</h3>
      <ul class="money list-money">
        <li><a class="tag-money" href="#">50.000</a></li>
        <li><a class="tag-money" href="#">100.000</a></li>
        <li><a class="tag-money" href="#">200.000</a></li>
        <li><a class="tag-money" href="#">500.000</a></li>
        <li><a class="tag-money" href="#">1.000.000</a></li>
        <li><a class="tag-money" href="#">2.000.000</a></li>
      </ul>
    </div>
  </div>

  <div class="tf-panel up">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-up wrap-content-panel">
      <div class="heading">
        <div class="tf-container">
          <div class="d-flex align-items-center position-relative justify-content-center">
            <i class="icon-close1 clear-panel"></i>
            <h3>Konfirmasi Top Up</h3>
          </div>
        </div>
      </div>
      <div class="main-topup">
        <?php
        include '../../conn/koneksi.php'; // memuat koneksi dari file terpisah

        $id_mrd = $_GET['id_mrd'];

        // Query untuk mengambil data murid, orang tua, dan kelas
        $sql = "SELECT 
          m.nm_murid, 
          o.nm_ortu, 
          k.nm_kls
        FROM t_murid m
        LEFT JOIN t_ortu o ON m.id_ortu = o.id_ortu
        LEFT JOIN t_klsmrd km ON m.id_mrd = km.id_mrd
        LEFT JOIN t_kelas k ON km.id_kls = k.id_kls
        WHERE m.id_mrd = '$id_mrd'";

        $query = mysqli_query($koneksi, $sql);

        if ($data = mysqli_fetch_assoc($query)) {
          $namaMurid = $data['nm_murid'];
          $namaOrtu  = $data['nm_ortu'];
          $kelas     = $data['nm_kls'];
          $inisial   = strtoupper(substr($namaMurid, 0, 1));
        } else {
          $namaMurid = "Tidak ditemukan";
          $namaOrtu  = "-";
          $kelas     = "-";
          $inisial   = "-";
        }
        ?>
        <div class="tf-container">
          <h3>Detail Topup</h3>
          <div class="tf-card-block d-flex align-items-center justify-content-between">
            <div class="inner d-flex align-items-center">
              <div class="avatar-img" style="
        width: 48px;
        height: 48px;
        background-color: #5A8DEE;
        color: white;
        font-weight: bold;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
      ">
                <?= $inisial ?>
              </div>
              <div class="content ms-3">
                <h4 class="fw_6"><?= $namaMurid ?></h4>
                <p>Kelas <?= $kelas ?></p>
              </div>
            </div>
          </div>

          <ul class="info">
            <li>
              <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                Orang Tua/Wali
                <span class="on_surface_color fw_6"><?= $namaOrtu ?></span>
              </h4>
            </li>
            <li>
              <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                Jumlah Top Up
                <span class="on_surface_color fw_7" id="display-topup">Rp. 0</span>
              </h4>
            </li>
            <li>
              <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                Biaya Admin <span class="success_color fw_7">Gratis</span>
              </h4>
            </li>
          </ul>

          <div class="d-flex justify-content-between align-items-center">
            <div class="total">
              <h4 class="secondary_color fw_4">Total Bayar</h4>
              <h2 id="display-total">Rp. 0</h2>
            </div>
            <button id="btn-confirm" class="tf-btn accent large">
              <i class="icon-secure1"></i> Konfirmasi & Lanjut
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const inputTopup = document.getElementById('input-topup');
    const btnNext = document.getElementById('btn-popup-up');
    const displayTopup = document.getElementById('display-topup');
    const displayTotal = document.getElementById('display-total');

    // Format angka ke format Rupiah (IDR)
    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(angka);
    }

    // Format input saat diketik
    inputTopup.addEventListener('input', function() {
      let value = this.value.replace(/\D/g, ''); // Ambil hanya angka
      if (value === '') value = '0';
      this.value = new Intl.NumberFormat('id-ID').format(value); // Tampilkan dengan titik
    });

    // Update nilai di panel konfirmasi saat tombol ditekan
    btnNext.addEventListener('click', function(e) {
      e.preventDefault();

      let rawValue = inputTopup.value.replace(/\D/g, ''); // Ambil angka saja
      let numericValue = parseInt(rawValue || '0');

      displayTopup.textContent = formatRupiah(numericValue);
      displayTotal.textContent = formatRupiah(numericValue);

      // Tampilkan panel (kalau pakai panel slide-up misalnya)
      document.querySelector('.tf-panel.up').classList.add('active'); // pastikan class ini sesuai logikamu
    });

    const btnConfirm = document.getElementById('btn-confirm');

    btnConfirm.addEventListener('click', function() {
      let rawValue = inputTopup.value.replace(/\D/g, ''); // Ambil hanya angka

      fetch(`simpan_topup.php?id_mrd=<?= $id_mrd ?>`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "jumlah_topup=" + rawValue
        })
        .then(response => response.text())
        .then(data => {
          alert(data); // tampilkan respon dari server
        })
        .catch(error => {
          alert("Terjadi kesalahan saat menyimpan top up.");
          console.error("Error:", error);
        });
    });
  </script>

  <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
  <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>