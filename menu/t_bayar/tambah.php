<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $id_ktgb = isset($_POST['kategori']) ? trim($_POST['kategori']) : null;
    $idta = isset($_POST['tahun']) ? trim($_POST['tahun']) : null;
    $nom = trim($_POST['nominal']);

    // Validasi input tidak boleh kosong
    if (empty($id_ktgb) || empty($idta) || empty($nom)) {
        echo "<script>alert('Semua field harus diisi!'); history.go(-1);</script>";
        exit;
    }

    // Pastikan nominal angka positif
    if (!is_numeric($nom) || $nom <= 0) {
        echo "<script>alert('Nominal harus berupa angka positif!'); history.go(-1);</script>";
        exit;
    }

    // Auto-increment id_tgh
    $auto = mysqli_query($koneksi, "SELECT MAX(id_tgh) as max_code FROM t_tghbyr");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $idtgh = ($code) ? (int)$code + 1 : 1;

    // Query untuk menyimpan data ke database
    $insert_query = "INSERT INTO t_tghbyr (id_tgh, id_ktgb, idta, nom) VALUES ('$idtgh', '$id_ktgb', '$idta', '$nom')";

    if (mysqli_query($koneksi, $insert_query)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='bayar.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan: " . mysqli_error($koneksi) . "'); history.go(-1);</script>";
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
    <title>Tambah Tagihan Bayar</title>
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
                <h3>Tambah Tagihan Bayar</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <!-- Pilih Kategori Bayar -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Pilih Kategori Bayar</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="" selected disabled>Pilih Kategori Bayar</option>
                                <?php
                                $kategori_query = mysqli_query($koneksi, "SELECT id_ktgb, nm_ktgb FROM t_ktgbyr");
                                while ($kategori = mysqli_fetch_array($kategori_query)) {
                                    echo "<option value='" . $kategori['id_ktgb'] . "'>" . $kategori['nm_ktgb'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Pilih Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="tahun" name="tahun">
                                <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                <?php
                                $tahun_query = mysqli_query($koneksi, "SELECT idta, CONCAT(thn_aw, ' - ', thn_ak) AS tahun_ajaran FROM t_ajaran");
                                while ($tahun = mysqli_fetch_array($tahun_query)) {
                                    echo "<option value='" . $tahun['idta'] . "'>" . $tahun['tahun_ajaran'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Input Nominal -->
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal Tagihan (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 300000">
                        </div>

                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
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