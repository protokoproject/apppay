<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan sesi dimulai

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil id_app berdasarkan session username
$username_session = $_SESSION['username'];
$queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
$rowApp = mysqli_fetch_assoc($queryApp);
$id_app = isset($rowApp['id_app']) ? trim($rowApp['id_app']) : '';

// Query untuk mendapatkan data bagian
$query_bagian = "SELECT kd_bgn, nm_bgn FROM tb_bagian";
$result_bagian = mysqli_query($koneksi, $query_bagian);

// Query untuk mendapatkan data app
$query_app = "SELECT id_app, nm_app FROM tb_app";
$result_app = mysqli_query($koneksi, $query_app);

// Query untuk mendapatkan data status user
$query_status_user = "SELECT kd_sts_user, nm_sts_user FROM tb_sts_user";
$result_status_user = mysqli_query($koneksi, $query_status_user);

if (isset($_POST['simpan'])) {
    $nm_user = trim($_POST['nm_user']);
    $email = trim($_POST['email']);
    $no_hp = trim($_POST['no_hp']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $kd_bgn = $_POST['kd_bgn'];
    $kdsts_user = $_POST['kdsts_user'];
    $id_app_input = $_POST['id_app'];

    // Validasi input tidak boleh kosong
    if (empty($nm_user) || empty($email) || empty($no_hp) || empty($password) || empty($konfirmasi_password) || empty($kd_bgn) || empty($kdsts_user) || empty($id_app_input)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Validasi nomor HP (hanya angka dan panjang minimal 10)
    if (!preg_match("/^[0-9]{10,15}$/", $no_hp)) {
        echo "<script>alert('Nomor HP harus berupa angka dan minimal 10 digit!'); window.history.back();</script>";
        exit;
    }

    // Validasi password dan konfirmasi password
    if ($password !== $konfirmasi_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak sesuai!'); window.history.back();</script>";
        exit;
    }

    // Enkripsi password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Ambil ID User terbaru
    $auto2 = mysqli_query($koneksi, "SELECT MAX(id_user) AS max_user FROM tb_user");
    $row2 = mysqli_fetch_assoc($auto2);
    $id_user = $row2['max_user'] + 1;

    // Buat username (kombinasi nama depan + id_user + id_app)
    $nama_parts = explode(" ", $nm_user);
    $username = strtolower($nama_parts[0]) . $id_user . $id_app;

    // Query untuk menyimpan data ke tabel tb_user
    $sql = "INSERT INTO tb_user (id_user, id_app, nm_user, kd_sts_user, username, pass, pass_txt, kd_bgn, nohp, tgl_lhr, email, tgl_gbng) 
            VALUES ('$id_user', '$id_app_input', '$nm_user', '$kdsts_user', '$username', '$hashed_password', '$password', '$kd_bgn', '$no_hp', CURRENT_DATE, '$email', CURRENT_DATE)";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='user.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Kelola Pengguna</title>
    <!-- Favicon and Touch Icons  -->
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    <style>
        /* Menyamakan TomSelect dengan input */
        .tomselect {
            width: 100% !important;
            height: 40px !important;
            /* Sesuaikan dengan input */
            border-radius: 8px !important;
            border: 1px solid #ccc !important;
            font-size: 14px !important;
            /* Ukuran font lebih kecil */
            padding: 8px 12px !important;
            background-color: white !important;
            box-sizing: border-box !important;
            position: relative;
        }

        /* Memastikan dropdown TomSelect juga memiliki gaya yang seragam */
        .ts-control {
            border-radius: 8px !important;
            height: 40px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            border: 1px solid #ccc !important;
            display: flex;
            align-items: center;
            position: relative;
        }

        /* Menambahkan ikon dropdown di sebelah kanan */
        .ts-control::after {
            content: "▼";
            /* Icon dropdown */
            font-size: 12px;
            /* Ukuran lebih kecil */
            position: absolute;
            right: 12px;
            color: #888;
            pointer-events: none;
            /* Supaya tidak bisa diklik */
        }

        /* Menyamakan tampilan dropdown list */
        .ts-dropdown {
            border-radius: 8px !important;
            font-size: 14px !important;
            border: 1px solid #ccc !important;
        }

        /* Mengatur item dalam dropdown */
        .ts-dropdown .option {
            font-size: 14px !important;
            padding: 8px 12px !important;
        }
    </style>
</head>

<body class="bg_surface_color">
    <!-- preloade -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div class="header is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-center align-items-center">
                <a href="../menu_lengkap/menu_lengkap.php" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Tambah User</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="trading-month">

                </div>
                <div class="tf-container">
                    <div class="trading-month">
                        <div class="form-container">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="nm_user">Nama User</label>
                                    <input type="text" id="nm_user" name="nm_user" placeholder="Masukkan Nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="nohp">No HP</label>
                                    <input type="text" id="nohp" name="no_hp" placeholder="Masukkan No HP" required>
                                </div>
                                <div class="form-group">
                                    <label for="kd_bgn">Bagian</label>
                                    <div class="select-wrapper">
                                        <select id="kd_bgn" name="kd_bgn" required>
                                            <option value="">--Pilih Bagian--</option>
                                            <?php while ($row = mysqli_fetch_assoc($result_bagian)) : ?>
                                                <option value="<?= $row['kd_bgn']; ?>"><?= $row['nm_bgn']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_app">App</label>
                                    <div class="select-wrapper">
                                        <select id="id_app" name="id_app" required>
                                            <option value="">--Pilih App--</option>
                                            <?php while ($row = mysqli_fetch_assoc($result_app)) : ?>
                                                <option value="<?= $row['id_app']; ?>"><?= $row['nm_app']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kdsts_user">Status User</label>
                                    <div class="select-wrapper">
                                        <select id="kdsts_user" name="kdsts_user" required>
                                            <option value="">--Pilih Status User--</option>
                                            <?php while ($row = mysqli_fetch_assoc($result_status_user)) : ?>
                                                <option value="<?= $row['kd_sts_user']; ?>"><?= $row['nm_sts_user']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password</label>
                                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan Konfirmasi Password" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="mt-3 tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bottom-navigation-bar">
        <div class="tf-container">
            <ul class="tf-navigation-bar">
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="../../home.php"><i class="icon-home"></i> Home</a>
                </li>
                <li class="active">
                    <a class="fw_6 d-flex justify-content-center align-items-center flex-column" href="58_history.html">
                        <i class="icon-history"></i> History</a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="40_qr-code.html">
                        <i class="icon-scan-qr-code"></i> </a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="62_rewards.html">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.25" cy="12" r="9.5" stroke="#717171" />
                            <path d="M17.033 11.5318C17.2298 11.3316 17.2993 11.0377 17.2144 10.7646C17.1293 10.4914 16.9076 10.2964 16.6353 10.255L14.214 9.88781C14.1109 9.87213 14.0218 9.80462 13.9758 9.70702L12.8933 7.41717C12.7717 7.15989 12.525 7 12.2501 7C11.9754 7 11.7287 7.15989 11.6071 7.41717L10.5244 9.70723C10.4784 9.80483 10.3891 9.87234 10.286 9.88802L7.86469 10.2552C7.59257 10.2964 7.3707 10.4916 7.2856 10.7648C7.2007 11.038 7.27018 11.3318 7.46702 11.532L9.2189 13.3144C9.29359 13.3905 9.32783 13.5 9.31021 13.607L8.89692 16.1239C8.86027 16.3454 8.91594 16.5609 9.0533 16.7308C9.26676 16.9956 9.6394 17.0763 9.93735 16.9128L12.1027 15.7244C12.1932 15.6749 12.3072 15.6753 12.3975 15.7244L14.563 16.9128C14.6684 16.9707 14.7807 17 14.8966 17C15.1083 17 15.3089 16.9018 15.4469 16.7308C15.5845 16.5609 15.6399 16.345 15.6033 16.1239L15.1898 13.607C15.1722 13.4998 15.2064 13.3905 15.2811 13.3144L17.033 11.5318Z" stroke="#717171" stroke-width="1.25" />
                        </svg>
                        Rewards</a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="../profil/profil.php">
                        <i class="icon-user-outline"></i> Profil</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tf-panel up">
        <div class="panel-box panel-up panel-filter-history">
            <div class="header mb-1 is-fixed">
                <div class="tf-container">
                    <div class="tf-statusbar d-flex justify-content-center align-items-center">
                        <a href="#" class="clear-panel"> <i class="icon-left"></i> </a>
                        <h3>Filter</h3>
                    </div>
                </div>
            </div>
            <div id="app-wrap" class="style1">
                <div class="mt-6">
                    <div class="tf-container">
                        <h4 class="mt-3 mb-3">Monthly</h4>
                        <ul class="filter-history">
                            <li><a href="#" class="tf-btn large active">All</a></li>
                            <li><a href="#" class="tf-btn large">Jan</a></li>
                            <li><a href="#" class="tf-btn large">Feb</a></li>
                            <li><a href="#" class="tf-btn large">Mar</a></li>
                            <li><a href="#" class="tf-btn large">Apr</a></li>
                            <li><a href="#" class="tf-btn large">May</a></li>
                            <li><a href="#" class="tf-btn large">Jun</a></li>
                            <li><a href="#" class="tf-btn large">July</a></li>
                            <li><a href="#" class="tf-btn large">Aug</a></li>
                            <li><a href="#" class="tf-btn large">Sep</a></li>
                            <li><a href="#" class="tf-btn large">Oct</a></li>
                            <li><a href="#" class="tf-btn large">Nov</a></li>
                            <li><a href="#" class="tf-btn large">Dec</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="container">
                        <h4 class="mt-3 mb-3">Status</h4>
                        <ul class="filter-history status">
                            <li><a href="#" class="tf-btn large active">All</a></li>
                            <li><a href="#" class="tf-btn large">Successful</a></li>
                            <li><a href="#" class="tf-btn large">Processing</a></li>
                            <li><a href="#" class="tf-btn large">Failure</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-btn">
                    <div class="tf-container">
                        <a href="61_filter-research.html" class="tf-btn accent large">Apply</a>

                    </div>
                </div>
            </div>




        </div>

    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("select").forEach(function(select) {
                let ts = new TomSelect(select, {
                    placeholder: "Pilih salah satu...",
                    create: false,
                    allowEmptyOption: true, // Tetap biarkan opsi kosong
                    maxItems: 1,
                    hideSelected: true,
                    dropdownParent: "body", // Pastikan dropdown tidak berantakan
                });

                // Tambahkan scrollbar jika lebih dari 4 opsi
                let optionCount = select.options.length;
                if (optionCount > 4) {
                    let dropdown = ts.dropdown_content;
                    dropdown.style.maxHeight = "150px"; // Batasi tinggi dropdown
                    dropdown.style.overflowY = "auto"; // Tambahkan scrollbar jika lebih dari 4 opsi
                }
            });
        });
    </script>

</body>

</html>