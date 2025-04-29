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
                A
              </div>
              <div class="content ms-3">
                <h4 class="fw_6">Ahmad Fauzan</h4>
                <p>Kelas 6A</p>
              </div>
            </div>
          </div>

          <ul class="info">
            <li>
              <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                Orang Tua/Wali
                <span class="on_surface_color fw_6">Rudi Hartono</span>
              </h4>
            </li>
            <li>
              <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                Jumlah Top Up
                <span class="on_surface_color fw_7">Rp. 200.000</span>
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
              <h2>Rp. 200.000</h2>
            </div>
            <a href="enter-pin.html" class="tf-btn accent large">
              <i class="icon-secure1"></i> Konfirmasi & Lanjut
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const inputTopup = document.getElementById('input-topup');

    inputTopup.addEventListener('input', function(e) {
      let value = this.value.replace(/\D/g, ''); // Hanya angka
      value = new Intl.NumberFormat('id-ID').format(value); // Format ribuan dengan titik
      this.value = value;
    });
  </script>


  <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
  <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>