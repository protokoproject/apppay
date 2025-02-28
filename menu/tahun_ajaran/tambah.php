<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $tahun_awal = trim($_POST['tahun_awal']);
    $tahun_akhir = trim($_POST['tahun_akhir']);
    $sts_ajaran = isset($_POST['sts_ajaran']) ? 1 : 0;

    if (empty($tahun_awal) || empty($tahun_akhir)) {
        echo "<script>alert('Semua field harus diisi!')</script>";
    } elseif (!is_numeric($tahun_awal) || !is_numeric($tahun_akhir) || strlen($tahun_awal) != 4 || strlen($tahun_akhir) != 4 || $tahun_awal >= $tahun_akhir) {
        echo "<script>alert('Tahun awal dan tahun akhir harus berupa angka 4 digit dan tahun awal harus lebih kecil dari tahun akhir!')</script>";
    } else {
        $auto = mysqli_query($koneksi, "SELECT MAX(idta) as max_code FROM t_ajaran");
        $hasil = mysqli_fetch_array($auto);
        $code = $hasil['max_code'];

        $idta = ($code) ? (int)$code + 1 : 1;

        $query = mysqli_query($koneksi, "INSERT INTO t_ajaran(idta, thn_aw, thn_ak, sts_thn) VALUES ('$idta', '$tahun_awal', '$tahun_akhir', '$sts_ajaran')");

        if ($query) {
            echo "<script>alert('Data berhasil ditambahkan!')</script>";
            header("refresh:0, ta.php");
        } else {
            echo "<script>alert('Data gagal ditambahkan!')</script>";
            header("refresh:0, ta.php");
        }
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
    <title>Tambah Tahun Ajaran</title>
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
                <h3>Tambah Tahun Ajaran</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tahunAwal" class="form-label">Tahun Awal</label>
                                    <input type="number" name="tahun_awal" id="tahun_awal" placeholder="Masukkan Tahun Awal">
                                </div>
                                <div class="col-md-6">
                                    <label for="tahunAkhir" class="form-label">Tahun Akhir</label>
                                    <input type="number" name="tahun_akhir" id="tahun_akhir" placeholder="Masukkan Tahun Akhir">
                                </div>
                            </div>
                        </div>
                        <div class="group-input">
                            <label>Status</label>
                            <fieldset class="d-flex align-items-center gap-12">
                                <input class="tf-switch-check" id="switchCheckDefault" type="checkbox" name="sts_ajaran">
                                <label for="switchCheckDefault">Aktif</label>
                            </fieldset>
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