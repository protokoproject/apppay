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
                    <h3 class="fw_6 d-flex justify-content-between mt-3">Detail Pesanan <p>Jumlah</p>
                    </h3>
                    <!-- List Menu Kantin -->
                    <ul class="order-list" id="order-list">
                        <li class="menu-item card p-2 mb-2" data-name="Nasi Goreng">Nasi Goreng</li>
                        <li class="menu-item card p-2 mb-2" data-name="Es Teh">Es Teh</li>
                    </ul>

                    <!-- Modal -->
                    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="menuModalLabel">Atur Pesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p id="selected-menu-name" class="fw-bold"></p>
                                    <label for="quantity">Jumlah:</label>
                                    <input type="number" id="quantity" class="form-control" min="1" value="1">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-hapus">Hapus</button>
                                    <button type="button" class="btn btn-primary" id="btn-oke" data-bs-dismiss="modal">Oke</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total">
                        <h3>Total: Rp. <span id="total-price">0</span></h3>
                    </div>
                </div>
                <!-- <div class="group-input">
                    <label>Message</label>
                    <input type="text" placeholder="Placeholder">
                </div> -->
            </div>

            <div class="bottom-navigation-bar bottom-btn-fixed">
                <div class="tf-container">
                    <a href="#" id="btn-popup-up" class="tf-btn accent large">Selanjutnya</a>
                </div>
                <div class="tf-panel up">
                    <div class="panel_overlay"></div>
                    <div class="panel-box panel-up wrap-content-panel">
                        <div class="heading">
                            <div class="tf-container">
                                <div class="d-flex align-items-center position-relative justify-content-center">
                                    <i class="icon-close1 clear-panel"></i>
                                    <h3>Konfirmasi Pembayaran</h3>
                                </div>
                            </div>
                        </div>
                        <div class="main-topup">
                            <div class="tf-container">
                                <h3>Detail Pembayaran</h3>
                                <div class="tf-card-block d-flex align-items-center justify-content-between">
                                    <div class="inner d-flex align-items-center">
                                        <div class="content">
                                            <h4><a href="#" class="fw_6">Nama pembeli: Budi</a></h4>
                                        </div>
                                    </div>
                                    <i class="icon-right"></i>
                                </div>
                                <ul class="info">
                                    <li>
                                        <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                            Jumlah
                                            <a href="#" class="on_surface_color fw_7" id="jumlah-pembayaran">Rp. 0</a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                            Nama Kantin
                                            <a href="#" class="on_surface_color fw_7" id="nama-kantin">Warung bu siti</a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                            Biaya admin <a href="#" class="success_color fw_7">Gratis</a>
                                        </h4>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="total">
                                        <h4 class="secondary_color fw_4">Total</h4>
                                        <h2 id="total-pembayaran">Rp. 0</h2>
                                    </div>
                                    <a href="" id="bayar-btn" class="tf-btn accent large"><i class="icon-secure1"></i>Bayar</a>
                                </div>
                            </div>
                        </div>
                    </div>
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