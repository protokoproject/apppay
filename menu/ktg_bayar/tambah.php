<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nm_ktgb = $_POST['nm_ktgb'];

    // Validasi input tidak boleh kosong
    if (empty($nm_ktgb)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Ambil ID Kategori Bayar terbaru dari tabel t_ktgbyr
    $auto = mysqli_query($koneksi, "SELECT MAX(id_ktgb) as max_code FROM t_ktgbyr");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $id_ktgb = ($code) ? (int)$code + 1 : 1;

    // Insert ke tabel t_ktgbyr
    $query = mysqli_query($koneksi, "INSERT INTO t_ktgbyr (id_ktgb, nm_ktgb) VALUES ('$id_ktgb', '$nm_ktgb')");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("refresh:0, ktg_bayar.php");
    } else {
        echo "<script>alert('Data gagal ditambahkan!'); window.history.back();</script>";
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
    <title>Tambah Kategori Bayar</title>
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
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Tambah Kategori Bayar</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama Kategori Bayar</label>
                            <input type="text" placeholder="Nama Kategori Bayar" name="nm_ktgb">
                        </div>
                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
                    </form>
                </div>
            </div>
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
        </div>
    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>

</body>

</html>