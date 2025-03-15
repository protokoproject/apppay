<?php
session_start();
include "../../conn/koneksi.php";

$kantin_id = isset($_GET['kantin_id']) ? $_GET['kantin_id'] : '';
$menu_html = '';
$show_menu = false;

if (!empty($kantin_id)) {
    $sql = "SELECT kd_brg, nm_brg, hrg_jual FROM t_brg WHERE id_kantin = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $kantin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $menu_html .= '<li class="tf-card-list medium bt-line">
                    <div class="info">
                        <h4 class="fw_6">' . htmlspecialchars($row["nm_brg"]) . '</h4>
                        <p>Rp. ' . number_format($row["hrg_jual"], 0, ',', '.') . ',-</p>
                    </div>
                    <input type="checkbox" class="tf-checkbox circle-check">
                  </li>';
        }
    } else {
        $menu_html = "<p>Tidak ada menu tersedia</p>";
    }
    $show_menu = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover" />
    <title>Kantinku</title>
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
                <h3 class="white_color">Kantinku</h3>
            </div>
        </div>
    </div>
    <div class="card-secton topup-content">
        <div class="tf-container">
            <div class="tf-balance-box">
                <?php
                include '../../conn/koneksi.php'; // Pastikan file koneksi database sudah benar

                // Pastikan user sudah login
                if (!isset($_SESSION['username'])) {
                    echo "<p>Silakan login terlebih dahulu.</p>";
                    exit;
                }

                $username = $_SESSION['username'];

                // Ambil id_user dari tb_user berdasarkan username
                $queryUser = "SELECT id_user FROM tb_user WHERE username = ?";
                $stmtUser = $koneksi->prepare($queryUser);
                $stmtUser->bind_param("s", $username);
                $stmtUser->execute();
                $resultUser = $stmtUser->get_result();

                if ($resultUser->num_rows > 0) {
                    $rowUser = $resultUser->fetch_assoc();
                    $id_user = $rowUser['id_user'];

                    // Ambil saldo dari t_murid berdasarkan id_user
                    $querySaldo = "SELECT saldo FROM t_murid WHERE id_user = ?";
                    $stmtSaldo = $koneksi->prepare($querySaldo);
                    $stmtSaldo->bind_param("i", $id_user);
                    $stmtSaldo->execute();
                    $resultSaldo = $stmtSaldo->get_result();

                    if ($resultSaldo->num_rows > 0) {
                        $rowSaldo = $resultSaldo->fetch_assoc();
                        $saldo = number_format($rowSaldo['saldo'], 0, ',', '.');
                    } else {
                        $saldo = "0";
                    }
                } else {
                    $saldo = "0";
                }
                ?>

                <div class="d-flex justify-content-between align-items-center">
                    <p>Saldo:</p>
                    <h3>Rp. <?php echo $saldo; ?></h3>
                </div>

                <div class="tf-spacing-16"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <?php
                    // Pastikan file koneksi.php sudah di-include
                    include '../../conn/koneksi.php';

                    // Ambil id_kantin dari URL
                    $id_kantin = isset($_GET['kantin_id']) ? intval($_GET['kantin_id']) : 0;

                    // Query untuk mengambil nama kantin berdasarkan id_kantin
                    $query = "SELECT nm_kantin FROM t_kantin WHERE id_kantin = ?";
                    $stmt = $koneksi->prepare($query);
                    $stmt->bind_param("i", $id_kantin);
                    $stmt->execute();
                    $stmt->bind_result($nm_kantin);
                    $stmt->fetch();
                    $stmt->close();
                    ?>

                    <div class="inner-left d-flex justify-content-between align-items-center">
                        <p class="fw_7 on_surface_color">Nama Kantin: <?php echo htmlspecialchars($nm_kantin); ?></p>
                    </div>
                </div>
            </div>

        </div>
        <div class="bottom-navigation-bar">
            <div class="tf-container">
                <a href="pesan.php" class="tf-btn accent large">Selanjutnya</a>
            </div>
        </div>
    </div>

    <div class="amount-money mt-5" id="menu-container" style="display: <?php echo $show_menu ? 'block' : 'none'; ?>;">
        <div class="tf-container">
            <h3>Pilih Menu</h3>
            <div class="mb-3">
                <input type="text" class="form-control" id="search-menu" placeholder="Cari menu...">
            </div>
            <ul class="box-card" id="menu-list" style="max-height: 300px; overflow-y: auto;"> <?php echo $menu_html; ?> </ul>
            <input type="hidden" id="username" value="<?php echo $_SESSION['username']; ?>">
        </div>
    </div>
    <script>
        // Ambil username dari elemen HTML
        let username = document.getElementById("username").value;

        // Ambil kantin_id dari URL
        let urlParams = new URLSearchParams(window.location.search);
        let kantinId = urlParams.get('kantin_id');

        // Simpan kantin_id di localStorage dengan kunci khusus
        localStorage.setItem(`currentKantinId_${username}`, kantinId);

        // Tampilkan kantin_id yang dipilih di console
        console.log(`Kantin yang dipilih: ID = ${kantinId}`);

        // Kunci untuk localStorage berdasarkan username (tanpa kantin_id)
        let storageKey = `selectedMenus_${username}`;

        // Cek apakah session masih ada (dengan AJAX request ke check_session.php)
        fetch('check_session.php')
            .then(response => response.json())
            .then(data => {
                if (!data.session_exists) {
                    // Jika session tidak ada, hapus localStorage yang terkait dengan username
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(`currentKantinId_${username}`);
                    console.log(`LocalStorage untuk ${username} telah dihapus karena session tidak ada.`);
                }
            })
            .catch(error => {
                console.error('Error saat memeriksa session:', error);
            });

        // Ambil data dari localStorage atau inisialisasi array kosong
        let selectedMenus = JSON.parse(localStorage.getItem(storageKey)) || [];

        // Tampilkan data yang tersimpan di localStorage di console
        console.log(`Menu yang tersimpan untuk ${username}:`, selectedMenus);

        // Fungsi untuk memulihkan status checkbox berdasarkan data di localStorage
        function restoreCheckedMenus() {
            let checkboxes = document.querySelectorAll('.tf-checkbox');
            let storedMenus = JSON.parse(localStorage.getItem(storageKey)) || [];

            checkboxes.forEach(checkbox => {
                let menuItem = checkbox.closest('li');
                let menuName = menuItem.querySelector('h4').textContent;

                // Cek apakah menu ada di localStorage
                if (storedMenus.some(item => item.name === menuName)) {
                    checkbox.checked = true; // Centang checkbox jika menu ada di localStorage
                } else {
                    checkbox.checked = false; // Jangan centang checkbox jika menu tidak ada
                }
            });

            // Tampilkan data yang dipulihkan di console
            console.log(`Menu yang dipulihkan untuk ${username}:`, storedMenus);
        }

        // Panggil restoreCheckedMenus saat halaman selesai dimuat
        window.onload = function() {
            restoreCheckedMenus();
        };

        document.getElementById("search-menu").addEventListener("input", function() {
            let searchText = this.value.toLowerCase();
            let items = document.querySelectorAll("#menu-list li");

            items.forEach(function(item) {
                let text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchText) ? "flex" : "none";
            });
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('tf-checkbox')) {
                let menuItem = e.target.closest('li');
                let menuName = menuItem.querySelector('h4').textContent;
                let menuPrice = menuItem.querySelector('p').textContent;

                if (e.target.checked) {
                    // Tambahkan menu ke dalam array jika checkbox dipilih
                    selectedMenus.push({
                        name: menuName,
                        price: menuPrice
                    });
                } else {
                    // Hapus menu yang di-unchecklist
                    selectedMenus = selectedMenus.filter(item => item.name !== menuName);
                }

                // Simpan data yang telah diperbarui ke localStorage dengan kunci unik
                localStorage.setItem(storageKey, JSON.stringify(selectedMenus));

                // Tampilkan data yang diperbarui di console
                console.log(`Menu yang tersimpan untuk ${username}:`, selectedMenus);
            }
        });

        // Tambahkan event listener ke setiap item list untuk toggle checkbox
        document.addEventListener('click', function(e) {
            let menuItem = e.target.closest('li');
            if (menuItem && !e.target.classList.contains('tf-checkbox')) {
                let checkbox = menuItem.querySelector('.tf-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            }
        });
    </script>

    <script>
        document.querySelectorAll(".tag-money").forEach(function(item) {
            item.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove active class from all items
                document.querySelectorAll(".tag-money").forEach(function(link) {
                    link.classList.remove("active");
                });

                // Add active class to the clicked item
                item.classList.add("active");
            });
        });
    </script>

    <div class="tf-panel up">
        <div class="panel_overlay"></div>
        <div class="panel-box panel-up wrap-content-panel">
            <div class="heading">
                <div class="tf-container">
                    <div class="d-flex align-items-center position-relative justify-content-center">
                        <i class="icon-close1 clear-panel"></i>
                        <h3>Konfirmasi Donasi</h3>
                    </div>
                </div>
            </div>
            <div class="main-topup">
                <div class="tf-container">
                    <h3>Pilih Sumber</h3>
                    <div class="tf-card-block d-flex align-items-center justify-content-between">
                        <div class="inner d-flex align-items-center">
                            <div class="logo-img">
                                <img src="images/logo-banks/card-visa3.png" alt="image" />
                            </div>
                            <div class="content">
                                <h4><a href="#" class="fw_6">Mastercard</a></h4>
                                <p>**** **** **** 7576</p>
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
                                Nama Donasi
                                <a href="#" class="on_surface_color fw_7">Baznas</a>
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
                        <a href="enter-pin-donasi.html" class="tf-btn accent large"><i class="icon-secure1"></i> Donasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>