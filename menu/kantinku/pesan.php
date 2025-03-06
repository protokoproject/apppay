<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Keranjang</title>
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
        .order-list {
            list-style: none;
            padding: 0;
        }

        .list-card-invoice {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .content-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-quantity-text {
            font-size: 20px;
            /* Ukuran lebih besar */
            font-weight: bold;
        }

        .menu-info {
            display: flex;
            flex-direction: column;
        }

        .menu-info h4 {
            margin: 0;
            font-size: 16px;
        }

        .menu-info p {
            margin: 2px 0 0;
            font-size: 14px;
            color: #555;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-minus,
        .btn-plus {
            background-color: #6c5ce7;
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 20px;
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
                <a href="#" class="back-btn"><i class="icon-left white_color"></i></a>
                <h3 class="white_color">Keranjang</h3>
            </div>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center">
                    <p>Saldo:</p>
                    <h3>3.000.000</h3>
                </div>
                <div class="tf-spacing-16"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="inner-left d-flex justify-content-between align-items-center">
                        <?php
                        session_start();
                        include '../../conn/koneksi.php'; // Pastikan file koneksi database sudah terhubung

                        // Mengambil data dari session
                        $username = $_SESSION['username'];
                        $kd_sts_user = $_SESSION['kd_sts_user'];

                        // Cek apakah user adalah admin atau bukan
                        if ($kd_sts_user == 1) {
                            echo '<p class="fw_7 on_surface_color">Admin</p>';
                        } else {
                            // Mengambil nm_user dari database berdasarkan username
                            $query = "SELECT nm_user FROM tb_user WHERE username = '$username'";
                            $result = mysqli_query($koneksi, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $nm_user = $row['nm_user'];
                                echo '<p class="fw_7 on_surface_color">' . htmlspecialchars($nm_user) . '</p>';
                            } else {
                                echo '<p class="fw_7 on_surface_color">User Tidak Ditemukan</p>';
                            }
                        }
                        ?>
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
                    <ul class="order-list" id="order-list">
                        <!-- Pesanan yang dipilih akan ditampilkan di sini -->
                    </ul>

                    <div class="total">
                        <h3>Total: Rp. <span id="total-price">0</span></h3>
                    </div>
                </div>
                <div class="group-input">
                    <label>Message</label>
                    <input type="text" placeholder="Placeholder">
                </div>
            </div>

            <script>
                // Fungsi untuk memperbarui daftar pesanan
                function updateOrderList() {
                    let orderList = document.getElementById('order-list');
                    let selectedMenus = JSON.parse(localStorage.getItem('selectedMenus')) || [];
                    orderList.innerHTML = '';
                    let totalPrice = 0;

                    selectedMenus.forEach(menu => {
                        // Menghitung total harga setiap item berdasarkan jumlah dan harga
                        let price = parseInt(menu.price.replace(/[^0-9]/g, ''));
                        totalPrice += price * menu.quantity;

                        orderList.innerHTML += `
                <li class="list-card-invoice">
                    <div class="content-left">
                        <span class="order-quantity-text">${menu.quantity}x</span>
                        <div class="menu-info">
                            <h4>${menu.name}</h4>
                            <p>${menu.price}</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button class="btn-minus" onclick="changeQuantity('${menu.name}', -1)">−</button>
                        <span class="order-quantity">${menu.quantity}</span>
                        <button class="btn-plus" onclick="changeQuantity('${menu.name}', 1)">+</button>
                    </div>
                </li>
            `;
                    });

                    // Menampilkan total harga
                    document.getElementById('total-price').textContent = formatRupiah(totalPrice);
                }

                // Fungsi untuk mengubah jumlah pesanan
                function changeQuantity(menuName, delta) {
                    let selectedMenus = JSON.parse(localStorage.getItem('selectedMenus')) || [];
                    selectedMenus = selectedMenus.map(menu => {
                        if (menu.name === menuName) {
                            menu.quantity = Math.max(1, menu.quantity + delta);
                        }
                        return menu;
                    });
                    localStorage.setItem('selectedMenus', JSON.stringify(selectedMenus));
                    updateOrderList();
                }

                // Set quantity default ke 1 untuk setiap item baru yang dipilih
                window.onload = function() {
                    let selectedMenus = JSON.parse(localStorage.getItem('selectedMenus')) || [];
                    selectedMenus = selectedMenus.map(menu => {
                        if (!menu.quantity) {
                            menu.quantity = 1; // Tetapkan quantity default menjadi 1
                        }
                        return menu;
                    });
                    localStorage.setItem('selectedMenus', JSON.stringify(selectedMenus));
                    updateOrderList();
                };

                // Fungsi untuk memformat angka menjadi format Rupiah
                function formatRupiah(angka) {
                    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            </script>

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
                                        <div class="logo-img">
                                            <img src="images/logo-banks/card-visa3.png" alt="image" />
                                        </div>
                                        <div class="content">
                                            <h4><a href="#" class="fw_6">Nama Siswa</a></h4>
                                            <p>Kelas</p>
                                        </div>
                                    </div>
                                    <i class="icon-right"></i>
                                </div>
                                <ul class="info">
                                    <li>
                                        <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                            Jumlah
                                            <a href="#" class="on_surface_color fw_7">Rp. 100.000</a>
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                            Nama Kantin
                                            <a href="#" class="on_surface_color fw_7">Warung ABC</a>
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
                                        <h2>Rp. 100.000</h2>
                                    </div>
                                    <a href="struk.php" class="tf-btn accent large"><i class="icon-secure1"></i>Bayar</a>
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