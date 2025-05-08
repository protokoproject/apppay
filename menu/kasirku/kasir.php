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
        <div class="bottom-navigation-bar" id="cart-container">
            <!-- Tombol Keranjang akan dihasilkan oleh JS jika ada menu yang dipilih -->
        </div>
    </div>

    <?php
    session_start();
    include "../../conn/koneksi.php"; // file koneksi ke database

    $username = $_SESSION['username'];

    // Ambil id_user dari username
    $queryUser = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE username = '$username'");
    $dataUser = mysqli_fetch_assoc($queryUser);
    $id_user = $dataUser['id_user'];

    // Ambil id_kantin dari id_user
    $queryKantin = mysqli_query($koneksi, "SELECT id_kantin FROM t_kantin WHERE id_user = '$id_user'");
    $dataKantin = mysqli_fetch_assoc($queryKantin);
    $id_kantin = $dataKantin['id_kantin'];

    // Ambil menu dari t_brg berdasarkan id_kantin
    $queryMenu = mysqli_query($koneksi, "SELECT nm_brg, hrg_jual FROM t_brg WHERE id_kantin = '$id_kantin'");
    $jumlahMenu = mysqli_num_rows($queryMenu); // hitung jumlah baris data
    ?>

    <div class="amount-money mt-5" id="menu-container" style="display: block;">
        <div class="tf-container">
            <h3>Pilih Menu</h3>

            <ul class="box-card" id="menu-list" style="max-height: 300px; overflow-y: auto;">
                <?php if ($jumlahMenu > 0) : ?>
                    <?php while ($menu = mysqli_fetch_assoc($queryMenu)) : ?>
                        <li class="card p-2 mb-2 menu-item">
                            <div class="row w-100">
                                <div class="col-8">
                                    <strong><?php echo htmlspecialchars($menu['nm_brg']); ?></strong>
                                </div>
                                <div class="col-4 text-end">
                                    Rp <?php echo number_format($menu['hrg_jual'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                <?php else : ?>
                    <li class="card p-2 mb-2 text-center">Belum ada menu yang ditambahkan</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        const username = "<?php echo $_SESSION['username']; ?>";

        // Fungsi menyimpan menu ke localStorage
        function saveMenuToLocalStorage(menuName, itemElement) {
            let selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};

            if (!selectedData[username]) {
                selectedData[username] = {};
            }

            if (!selectedData[username][menuName]) {
                const priceText = itemElement.querySelector('.col-4').textContent.replace(/[^\d]/g, '');
                const price = parseInt(priceText);

                selectedData[username][menuName] = {
                    jumlah: 1,
                    harga: price
                };
            }

            localStorage.setItem('selectedData', JSON.stringify(selectedData));
            console.log('Isi localStorage setelah memilih menu:', selectedData);
            updateCartButtonStatus();
        }

        // Highlight menu yang sudah dipilih
        function updateMenuHighlight() {
            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
            const userSelected = selectedData[username] || {};

            document.querySelectorAll('.menu-item').forEach(item => {
                const menuName = item.querySelector('.col-8 strong').textContent.trim();
                if (userSelected[menuName]) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });

            updateCartButtonStatus();
        }

        // Periksa tombol keranjang
        function updateCartButtonStatus() {
            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
            const userSelected = selectedData[username] || {};
            const cartContainer = document.getElementById('cart-container');

            if (Object.keys(userSelected).length > 0) {
                if (!document.getElementById('keranjangButton')) {
                    const cartButton = document.createElement('a');
                    cartButton.href = 'keranjang.php';
                    cartButton.className = 'tf-btn accent large';
                    cartButton.id = 'keranjangButton';
                    cartButton.innerText = 'Keranjang';
                    cartContainer.appendChild(cartButton);
                }
            } else {
                const cartButton = document.getElementById('keranjangButton');
                if (cartButton) {
                    cartButton.remove();
                }
            }
        }

        // Event listener klik menu
        function attachMenuClickHandlers() {
            const items = document.querySelectorAll('.menu-item');
            items.forEach(item => {
                item.addEventListener('click', () => {
                    if (!item.classList.contains('selected')) {
                        item.classList.add('selected');
                        const menuName = item.querySelector('.col-8 strong').textContent.trim();
                        saveMenuToLocalStorage(menuName, item);
                    }
                });
            });
        }

        // Panggil semua saat halaman siap
        window.onload = function() {
            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
            if (selectedData[username]) {
                delete selectedData[username]['id_user'];
                delete selectedData[username]['nm_murid'];
                delete selectedData[username]['total_harga'];
                localStorage.setItem('selectedData', JSON.stringify(selectedData));
            }

            attachMenuClickHandlers();
            updateMenuHighlight();
        };


        // Pencarian menu
        const searchInput = document.getElementById('searchMenu');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('#menu-list .menu-item');

                menuItems.forEach(item => {
                    const text = item.querySelector('.col-8 strong').textContent.toLowerCase();
                    item.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    </script>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>