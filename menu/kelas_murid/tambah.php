<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_kls = $_POST['kelas']; // ID Kelas dari form
    $id_mrd = $_POST['murid']; // ID Murid dari form

    // Cek apakah pasangan id_kls dan id_mrd sudah ada untuk mencegah duplikasi
    $cek_query = mysqli_query($koneksi, "SELECT * FROM t_klsmrd WHERE id_kls = '$id_kls' AND id_mrd = '$id_mrd'");
    if (mysqli_num_rows($cek_query) > 0) {
        echo "<script>
                alert('Data sudah ada! Murid sudah terdaftar di kelas ini.');
              </script>";
        header("refresh:0; url=kls_mrd.php"); // Redirect ke halaman kls_mrd.php
        exit;
    }

    // Query untuk menyimpan data ke tabel t_klsmrd
    $insert_query = "INSERT INTO t_klsmrd (id_kls, id_mrd) VALUES ('$id_kls', '$id_mrd')";

    if (mysqli_query($koneksi, $insert_query)) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
        header("refresh:0; url=kls_mrd.php"); // Redirect ke halaman kls_mrd.php
        exit;
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data!');</script>";
        header("refresh:0; url=kls_mrd.php"); // Redirect ke halaman kls_mrd.php meskipun terjadi error
        exit;
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
    <title>Tambah Kelas Murid</title>
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
                <h3>Tambah Kelas Murid</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <!-- Pilih Kelas -->
                        <div class="group-input mb-3">
                            <label for="kelas" class="form-label">Pilih Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option value="" selected disabled>Pilih Kelas</option>
                                <?php
                                include "../../conn/koneksi.php";
                                $kelas_query = mysqli_query($koneksi, "SELECT id_kls, nm_kls FROM t_kelas");
                                while ($kelas = mysqli_fetch_array($kelas_query)) {
                                    echo "<option value='" . $kelas['id_kls'] . "'>" . $kelas['nm_kls'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Pilih Murid -->
                        <div class="group-input mb-3">
                            <label for="murid" class="form-label">Pilih Murid</label>
                            <select class="form-select" id="murid" name="murid" required>
                                <option value="" selected disabled>Pilih Murid</option>
                                <?php
                                $murid_query = mysqli_query($koneksi, "SELECT id_mrd, nm_murid FROM t_murid");
                                while ($murid = mysqli_fetch_array($murid_query)) {
                                    echo "<option value='" . $murid['id_mrd'] . "'>" . $murid['nm_murid'] . "</option>";
                                }
                                ?>
                            </select>
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