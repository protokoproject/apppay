<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Mendapatkan data pengguna berdasarkan ID (kd_sts_user) jika ada permintaan edit
if (isset($_GET['kd_sts_user'])) {
    $kd_sts_user = $_GET['kd_sts_user'];
    $query = "SELECT * FROM tb_sts_user WHERE kd_sts_user = '$kd_sts_user'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Data tidak ditemukan!');</script>";
        echo "<script>window.location.href='st_user.php';</script>";
        exit;
    }
}

// Proses penyimpanan perubahan data setelah form disubmit
if (isset($_POST['update'])) {
    $nm_sts_user = $_POST['nm_sts_user'];
    $ket_sts_user = $_POST['ket_sts_user'];

    // Validasi input
    if (empty($nm_sts_user) || empty($ket_sts_user)) {
        echo "<script>alert('Semua Field harus diisi!');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // Query untuk mengupdate data
    $query = "UPDATE tb_sts_user 
              SET nm_sts_user = '$nm_sts_user', 
                  ket_sts_user = '$ket_sts_user' 
              WHERE kd_sts_user = '$kd_sts_user'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diperbarui!');</script>";
        header("refresh:0, st_user.php");
    } else {
        error_log("Error executing query: " . mysqli_error($koneksi));
        echo "<script>alert('Terjadi kesalahan saat memperbarui data!');</script>";
        echo "<script>console.log('Error: " . addslashes(mysqli_error($koneksi)) . "');</script>";
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
    <title>Edit Status Pengguna</title>
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
                <h3>Edit Status Pengguna</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                <form method="post">

                        <div class="group-input">
                            <label>Nama Status Pengguna</label>
                            <input type="text" placeholder="Nama Status Pengguna" name="nm_sts_user" value="<?= $data['nm_sts_user'] ?>">
                        </div>
                        <div class="group-input">
                            <label>Keterangan</label>
                            <textarea placeholder="Keterangan" name="ket_sts_user"><?= $data['ket_sts_user'] ?></textarea>
                        </div>
                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="update">Simpan</button>
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