<?php
include "../../conn/koneksi.php";

$kd_sts_user = $_GET['kd_sts_user'];

$sql = mysqli_query($koneksi,"SELECT * FROM tb_sts_user WHERE kd_sts_user = '$kd_sts_user'");
$data = mysqli_fetch_array($sql);

if (isset($_POST['simpan'])) {
    $nmuser = $_POST['nmuser'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];

    if(empty($nmuser) || empty($keterangan) || empty($status)) {
        echo "<script>alert('Nama User, Keterangan, dan Status harus diisi!');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    $query = "UPDATE tb_sts_user
              SET nm_sts_user = '$nmuser' , ket_sts_user = '$keterangan' , st_sts_user = '$status' 
              WHERE kd_sts_user = '$kd_sts_user'";


    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        header("refresh:0, aksespengguna.php");
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
        header("refresh:0, aksespengguna.php");
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
    <title>Edit Akses Pengguna</title>
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
                <h3>Edit Akses Pengguna</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama User</label>
                            <input type="text" placeholder="Nama User" name="nmuser" value="<?php echo $data['nm_sts_user']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Keterangan</label>
                            <input type="text" placeholder="Keterangan" name="keterangan" value="<?php echo $data['ket_sts_user']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Status</label>
                            <input type="text" placeholder="Status" name="status" value="<?php echo $data['st_sts_user']; ?>">
                        </div>
                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="simpan">Simpan</button>
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