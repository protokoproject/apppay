<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if(isset($_POST['simpan'])){
    // Mendapatkan id_kelas berikutnya
    $auto = mysqli_query($koneksi, "SELECT MAX(id_kls) as max_code FROM t_kelas");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $idkelas = ($code) ? (int)$code + 1 : 1;

    // Mengambil data dari form
    $nm_kelas = $_POST['nmkelas'];
    $wali_kelas = $_POST['wali_kelas'];  // ID wali kelas yang dipilih
    $tahun_ajaran = $_POST['tahun_ajaran'];  // ID tahun ajaran yang dipilih

    if (empty($nm_kelas) || empty($wali_kelas) || empty($tahun_ajaran)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Query untuk memasukkan data ke tabel t_kelas
    $query = "INSERT INTO t_kelas (id_kls, nm_kls, wali, idta) VALUES ('$idkelas', '$nm_kelas', '$wali_kelas', '$tahun_ajaran')";

    // Eksekusi query
    if(mysqli_query($koneksi, $query)){
        echo "<script>alert('Data berhasil ditambahkan!')</script>";
        header("refresh:0, kelas.php");
    } else {
        echo "<script>alert('Gagal menambahkan data!')</script>";
        header("refresh:0, kelas.php");
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
    <title>Tambah Kelas</title>
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
                <h3>Tambah Kelas</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama Kelas</label>
                            <input type="text" placeholder="Nama Kelas" name="nmkelas">
                        </div>

                        <!-- Select Wali Kelas -->
                        <div class="group-input">
                            <label>Wali Kelas</label>
                            <select name="wali_kelas">
                                <option value="" disabled selected>Pilih Wali Kelas</option>
                                <?php
                                // Koneksi ke database dan mengambil data Wali Kelas dari tabel t_guru
                                $result_wali = mysqli_query($koneksi, "SELECT * FROM t_guru");
                                while ($row = mysqli_fetch_assoc($result_wali)) {
                                    echo "<option value='" . $row['id_guru'] . "'>" . $row['nm_guru'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Select Tahun Ajaran -->
                        <div class="group-input">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran">
                                <option value="" disabled selected>Pilih Tahun Ajaran</option>
                                <?php
                                // Koneksi ke database dan mengambil data Tahun Ajaran dari tabel t_ajaran
                                $result_tahun = mysqli_query($koneksi, "SELECT * FROM t_ajaran");
                                while ($row = mysqli_fetch_assoc($result_tahun)) {
                                    echo "<option value='" . $row['idta'] . "'>Tahun Ajaran " . $row['thn_aw'] . " - " . $row['thn_ak'] . "</option>";
                                }
                                ?>
                            </select>
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