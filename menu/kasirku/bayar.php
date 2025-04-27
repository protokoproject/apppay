<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Pembayaran</title>
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../../images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../fonts/icons-alipay.css">
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" href="../../styles/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }

        .total-bayar {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .qr-container {
            margin-bottom: 20px;
        }

        .expired-time {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
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
                <a href="#" class="back-btn"><i class="icon-left white_color"></i></a>
                <h3 class="white_color">Pembayaran</h3>
            </div>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="me-2 mb-0">Total Pembayaran:</p>
                    <h3 class="mb-0">Rp. 0</h3> <!-- Ubah Rp. 0 dengan total pembayaran dinamis jika diperlukan -->
                </div>
                <div class="tf-spacing-16"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="inner-left d-flex justify-content-between align-items-center">

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="tf-spacing-20"></div>
    <div class="transfer-content">
        <form class="tf-form">
            <div class="tf-container">
                <div class="group-input input-field input-money">
                    <h3 class="fw_6 d-flex justify-content-between mt-3"></h3>

                    <!-- Tampilan QR Code -->
                    <div class="payment-qr text-center my-4">
                        <img src="../../images/scan-qr/qrcode1.png" alt="QR Code Pembayaran" class="img-fluid" style="max-width: 250px;">
                    </div>

                    <!-- Expired Time -->
                    <div class="qr-expired text-center">
                        <p class="text-danger fw-bold">Expired: 10 Menit</p>
                    </div>

                    <div class="total">
                        <h3>Total: Rp. <span id="total-price">0</span></h3>
                    </div>
                </div>
            </div>

            <div class="bottom-navigation-bar bottom-btn-fixed">
                <div class="tf-container">
                    <a href="struk_kasir.php" id="btn-popup-up" class="tf-btn accent large">Selanjutnya</a>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>

</body>

</html>