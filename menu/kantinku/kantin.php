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
                <div class="d-flex justify-content-between align-items-center">
                    <p>Saldo:</p>
                    <h3>Rp. 3.000.000</h3>
                </div>
                <div class="tf-spacing-16"></div>
                <div class="tf-form">
                    <div class="group-input input-field">
                        <select id="kantin">
                            <option value="">Pilih Kantin</option>
                            <?php
                            // Koneksi ke database
                            include "../../conn/koneksi.php";

                            // Query untuk mengambil data kantin
                            $sql = "SELECT id_kantin, nm_kantin FROM t_kantin";
                            $result = $koneksi->query($sql);

                            // Looping hasil query ke dalam <option>
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["id_kantin"] . '">' . $row["nm_kantin"] . '</option>';
                                }
                            }

                            // Tutup koneksi
                            $koneksi->close();
                            ?>
                        </select>
                        <script>
                            new TomSelect("#kantin", {
                                maxOptions: null, // Tidak membatasi jumlah opsi yang bisa dipilih
                                dropdownParent: 'body', // Memastikan dropdown tidak terpotong
                                render: {
                                    option: function(data, escape) {
                                        return `<div class="custom-option">${escape(data.text)}</div>`;
                                    }
                                }
                            });
                        </script>
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

    <div class="amount-money mt-5" id="menu-container" style="display: none;">
        <div class="tf-container">
            <h3>Pilih Menu</h3>
            <ul class="box-card" id="menu-list">
                <!-- Menu akan dimuat di sini -->
            </ul>
        </div>
    </div>

    <script>
        document.getElementById("kantin").addEventListener("change", function() {
            let kantinId = this.value;
            let menuContainer = document.getElementById("menu-container");
            let menuList = document.getElementById("menu-list");

            if (kantinId) {
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "get_menu.php?kantin_id=" + kantinId, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            menuList.innerHTML = xhr.responseText;
                            menuContainer.style.display = "block";
                        } else {
                            console.error("Gagal mengambil data menu: " + xhr.statusText);
                        }
                    }
                };
                xhr.send();
            } else {
                menuContainer.style.display = "none";
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