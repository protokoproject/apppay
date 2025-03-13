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
                    <input type="hidden" id="username" value="<?php echo $_SESSION['username']; ?>">
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

                        <?php
                        include '../../conn/koneksi.php'; // Pastikan file koneksi database sudah terhubung

                        // Mengambil data dari session
                        $username = $_SESSION['username'];
                        $kd_sts_user = $_SESSION['kd_sts_user'];

                        // Inisialisasi variabel
                        $nama_siswa = "Nama Siswa Tidak Ditemukan";
                        $kelas = "Kelas Tidak Ditemukan";
                        $nama_kantin = "Nama Kantin Tidak Ditemukan";

                        // Jika pengguna adalah admin
                        if ($kd_sts_user == 1) {
                            $nama_siswa = "Admin";
                            $kelas = "Admin";
                        } else if ($kd_sts_user == 7) {
                            // Query untuk mengambil id_user dari tb_user berdasarkan username
                            $query_user = "SELECT id_user FROM tb_user WHERE username = '$username'";
                            $result_user = mysqli_query($koneksi, $query_user);

                            if ($result_user && mysqli_num_rows($result_user) > 0) {
                                $row_user = mysqli_fetch_assoc($result_user);
                                $id_user = $row_user['id_user'];

                                // Query untuk mengambil nama siswa (nm_murid) dan id_mrd dari t_murid berdasarkan id_user
                                $query_murid = "SELECT nm_murid, id_mrd FROM t_murid WHERE id_user = '$id_user'";
                                $result_murid = mysqli_query($koneksi, $query_murid);

                                if ($result_murid && mysqli_num_rows($result_murid) > 0) {
                                    $row_murid = mysqli_fetch_assoc($result_murid);
                                    $nama_siswa = $row_murid['nm_murid'];
                                    $id_mrd = $row_murid['id_mrd'];

                                    // Query untuk mengambil id_kls dari t_klsmrd berdasarkan id_mrd
                                    $query_klsmrd = "SELECT id_kls FROM t_klsmrd WHERE id_mrd = '$id_mrd'";
                                    $result_klsmrd = mysqli_query($koneksi, $query_klsmrd);

                                    if ($result_klsmrd && mysqli_num_rows($result_klsmrd) > 0) {
                                        $row_klsmrd = mysqli_fetch_assoc($result_klsmrd);
                                        $id_kls = $row_klsmrd['id_kls'];

                                        // Query untuk mengambil nm_kelas dari t_kelas berdasarkan id_kls
                                        $query_kelas = "SELECT nm_kls FROM t_kelas WHERE id_kls = '$id_kls'";
                                        $result_kelas = mysqli_query($koneksi, $query_kelas);

                                        if ($result_kelas && mysqli_num_rows($result_kelas) > 0) {
                                            $row_kelas = mysqli_fetch_assoc($result_kelas);
                                            $kelas = $row_kelas['nm_kls'];
                                        } else {
                                            // Jika nm_kelas tidak ditemukan
                                            $kelas = "Kelas Tidak Ditemukan (t_kelas)";
                                        }
                                    } else {
                                        // Jika id_kls tidak ditemukan
                                        $kelas = "Kelas Tidak Ditemukan (t_klsmrd)";
                                    }
                                } else {
                                    // Jika nm_murid atau id_mrd tidak ditemukan
                                    $nama_siswa = "Nama Siswa Tidak Ditemukan (t_murid)";
                                }
                            } else {
                                // Jika id_user tidak ditemukan
                                $nama_siswa = "Nama Siswa Tidak Ditemukan (tb_user)";
                            }
                        }
                        ?>

                        <div class="main-topup">
                            <div class="tf-container">
                                <h3>Detail Pembayaran</h3>
                                <div class="tf-card-block d-flex align-items-center justify-content-between">
                                    <div class="inner d-flex align-items-center">
                                        <div class="content">
                                            <h4><a href="#" class="fw_6"><?php echo htmlspecialchars($nama_siswa); ?></a></h4>
                                            <p><?php echo htmlspecialchars($kelas); ?></p>
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
                                            <a href="#" class="on_surface_color fw_7" id="nama-kantin"><?php echo htmlspecialchars($nama_kantin); ?></a>
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

                        <script>
                            // Ambil username dari elemen HTML
                            let username = document.getElementById("username").value;

                            // Kunci untuk localStorage berdasarkan username
                            let storageKey = `selectedMenus_${username}`;

                            // Fungsi untuk memperbarui daftar pesanan
                            function updateOrderList() {
                                let orderList = document.getElementById('order-list');
                                let selectedMenus = JSON.parse(localStorage.getItem(storageKey)) || [];
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

                                // Update jumlah dan total di Detail Pembayaran
                                document.getElementById('jumlah-pembayaran').textContent = formatRupiah(totalPrice);
                                document.getElementById('total-pembayaran').textContent = formatRupiah(totalPrice);
                            }

                            // Fungsi untuk mengubah jumlah pesanan
                            function changeQuantity(menuName, delta) {
                                let selectedMenus = JSON.parse(localStorage.getItem(storageKey)) || [];
                                selectedMenus = selectedMenus.map(menu => {
                                    if (menu.name === menuName) {
                                        menu.quantity = Math.max(1, menu.quantity + delta);
                                    }
                                    return menu;
                                });
                                localStorage.setItem(storageKey, JSON.stringify(selectedMenus));
                                updateOrderList();
                            }

                            // Set quantity default ke 1 untuk setiap item baru yang dipilih
                            window.onload = function() {
                                let selectedMenus = JSON.parse(localStorage.getItem(storageKey)) || [];
                                selectedMenus = selectedMenus.map(menu => {
                                    if (!menu.quantity) {
                                        menu.quantity = 1; // Tetapkan quantity default menjadi 1
                                    }
                                    return menu;
                                });
                                localStorage.setItem(storageKey, JSON.stringify(selectedMenus));
                                updateOrderList();
                            };

                            // Fungsi untuk memformat angka menjadi format Rupiah
                            function formatRupiah(angka) {
                                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }

                            // Ambil username dari session PHP
                            const usernameFromPHP = "<?php echo $username; ?>";

                            // Ambil kantin_id dari localStorage
                            const kantinId = localStorage.getItem(`currentKantinId_${usernameFromPHP}`);

                            if (kantinId) {
                                // Kirim kantin_id ke server untuk mendapatkan nama kantin
                                fetch('get_nama_kantin.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: `kantin_id=${kantinId}`
                                    })
                                    .then(response => response.text())
                                    .then(namaKantin => {
                                        // Tampilkan nama kantin di halaman
                                        document.getElementById('nama-kantin').textContent = namaKantin;
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            } else {
                                console.log('Kantin ID tidak ditemukan di localStorage.');
                            }

                            document.getElementById("bayar-btn").addEventListener("click", function(event) {
                                event.preventDefault(); // Mencegah reload jika tombol ada dalam form

                                let username = document.getElementById("username").value;
                                let kantinId = localStorage.getItem(`currentKantinId_${username}`);
                                let selectedMenus = JSON.parse(localStorage.getItem(`selectedMenus_${username}`)) || [];

                                if (!kantinId) {
                                    alert("Kantin ID tidak ditemukan!");
                                    return;
                                }

                                if (selectedMenus.length === 0) {
                                    alert("Tidak ada menu yang dipilih!");
                                    return;
                                }

                                console.log("Mengirim data ke server:", {
                                    kantin_id: kantinId,
                                    menus: selectedMenus
                                });

                                fetch("proses_pembayaran.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json"
                                        },
                                        body: JSON.stringify({
                                            kantin_id: kantinId,
                                            menus: selectedMenus
                                        })
                                    })
                                    .then(response => response.json()) // Pastikan respons diubah menjadi JSON
                                    .then(data => {
                                        console.log("Response dari server:", data);

                                        if (data.status === "success") {
                                            alert(data.message); // Tampilkan alert sukses
                                            localStorage.removeItem(`selectedMenus_${username}`);
                                            setTimeout(() => {
                                                window.location.href = data.redirect; // Redirect setelah alert
                                            }, 1000); // Delay 1 detik untuk memberi waktu alert tampil
                                        } else {
                                            alert("Error: " + data.message); // Alert untuk pesan error
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Terjadi kesalahan:", error);
                                        alert("Terjadi kesalahan saat memproses pembayaran.");
                                    });
                            });
                        </script>
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