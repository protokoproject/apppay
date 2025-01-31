<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Specific Metas -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover"
    />
    <title>Riwayat Absensi</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../fonts/icons-alipay.css">
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
    <style>
        .table-attendance {
          width: 100%;
          border-collapse: collapse;
          margin: 20px 0;
          font-size: 16px;
          text-align: left;
        }
        .table-attendance thead tr {
          background-color: #009879;
          color: #ffffff;
          text-align: center;
        }
        .table-attendance th, .table-attendance td {
          padding: 12px 15px;
          border: 1px solid #ddd;
        }
        .table-attendance tbody tr {
          border-bottom: 1px solid #ddd;
        }
        .table-attendance tbody tr:nth-of-type(even) {
          background-color: #f3f3f3;
        }
        .table-attendance tbody tr:hover {
          background-color: #f1f1f1;
        }
        
        .action-right {
          color: #fff;
        }
      </style>
  </head>

  <body class="bg_surface_color">
    <!-- preload -->
    <div class="preload preload-container">
      <div class="preload-logo">
        <div class="spinner"></div>
      </div>
    </div>
    <!-- /preload -->
    <div class="header is-fixed">
      <div class="tf-container">
        <div
          class="tf-statusbar d-flex justify-content-center align-items-center"
        >
          <a href="home.php" class="back-btn"> <i class="icon-left"></i> </a>
          <h3>Riwayat Absensi</h3>
          <a href="#" id="btn-popup-up" class="action-right">
            <i class="icon icon-filter"></i>
          </a>
        </div>
      </div>
    </div>
    <div id="app-wrap">
      <div class="app-section st1 mt-1 mb-5 bg_white_color">
        <div class="container mt-4">
            <table class="table-attendance">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Masuk</th>
                  <th>Pulang</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>13 November 2024</td>
                  <td>07:30</td>
                  <td>14:00</td>
                  <td>Hadir</td>
                </tr>
                <tr>
                  <td>12 November 2024</td>
                  <td>07:25</td>
                  <td>14:10</td>
                  <td>Hadir</td>
                </tr>
                <tr>
                  <td>31 Oktober 2024</td>
                  <td>07:40</td>
                  <td>14:00</td>
                  <td>Hadir</td>
                </tr>
                <tr>
                  <td>30 Oktober 2024</td>
                  <td>07:35</td>
                  <td>14:05</td>
                  <td>Hadir</td>
                </tr>
              </tbody>
            </table>
          </div>      
      </div>
    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
  </body>
</html>
