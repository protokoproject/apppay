<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover" />
    <title>Kasirku</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <style>
        .tag-money.active {
            background-color: #533dea !important;
            color: white;
        }

        .ts-dropdown {
            max-height: 150px !important;
            /* Batasi tinggi dropdown */
            overflow-y: auto !important;
            /* Tambahkan scrollbar vertikal */
        }

        .menu-item.selected {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: bold;
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
                <a href="home.php" class="back-btn"><i class="icon-left white_color"></i></a>
                <h3 class="white_color">Kasirku</h3>
            </div>
        </div>
    </div>
    <div class="card-secton topup-content">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="searchMenu" class="me-2 mb-0">Cari Menu Kantin:</label>
                    <input type="text" id="searchMenu" class="form-control" placeholder="Ketik nama menu...">
                </div>
            </div>

        </div>
        <div class="bottom-navigation-bar">
            <div class="tf-container">
                <a href="keranjang.php" class="tf-btn accent large">Keranjang</a>
            </div>
        </div>
    </div>

    <div class="amount-money mt-5" id="menu-container" style="display: block;">
        <div class="tf-container">
            <h3>Pilih Menu</h3>
            <ul class="box-card" id="menu-list" style="max-height: 300px; overflow-y: auto;">
                <li class="card p-2 mb-2 menu-item">Nasi Goreng</li>
                <li class="card p-2 mb-2 menu-item">Mie Goreng</li>
                <li class="card p-2 mb-2 menu-item">Bakso</li>
                <li class="card p-2 mb-2 menu-item">Soto Ayam</li>
                <li class="card p-2 mb-2 menu-item">Nasi Kuning</li>
                <li class="card p-2 mb-2 menu-item">Ayam Geprek</li>
                <li class="card p-2 mb-2 menu-item">Es Teh</li>
                <li class="card p-2 mb-2 menu-item">Es Jeruk</li>
                <li class="card p-2 mb-2 menu-item">Air Mineral</li>
                <li class="card p-2 mb-2 menu-item">Gorengan</li>
            </ul>
        </div>
    </div>
    <script>
        const items = document.querySelectorAll('.menu-item');
        items.forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('selected');
            });
        });
    </script>
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>