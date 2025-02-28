<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_ortu = $_GET['id'];

    // Ambil data orang tua berdasarkan id_ortu
    $queryOrtu = mysqli_query($koneksi, "SELECT t_ortu.id_ortu, t_ortu.nm_ortu, tb_user.id_user, tb_user.nm_user, tb_user.username FROM t_ortu JOIN tb_user ON t_ortu.id_user = tb_user.id_user WHERE t_ortu.id_ortu = '$id_ortu'");
    $dataOrtu = mysqli_fetch_assoc($queryOrtu);

    if (!$dataOrtu) {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='ortu.php';</script>";
        exit;
    }

    $nmortu = $dataOrtu['nm_ortu'];
    $id_user = $dataOrtu['id_user'];
    $current_username = $dataOrtu['username']; // Ambil username saat ini
}

if (isset($_POST['update'])) {
    $nmortu = isset($_POST['nmortu']) ? trim($_POST['nmortu']) : '';
    $tgl_rilis = date("Y-m-d");

    // Validasi input tidak boleh kosong
    if (empty($nmortu)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Ambil id_app berdasarkan session username
    $username_session = $_SESSION['username'];
    $queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
    $rowApp = mysqli_fetch_assoc($queryApp);
    $id_app = $rowApp['id_app']; // Ambil id_app dari session username

    // Buat username baru berdasarkan nama depan orang tua + id_ortu + id_app
    $nama_parts = explode(" ", $nmortu);
    $username = strtolower($nama_parts[0]) . $id_ortu . $id_app; // Format username yang benar

    // Update ke tabel tb_user dengan username yang baru
    $queryUser = mysqli_query($koneksi, "UPDATE tb_user SET nm_user = '$nmortu', username = '$username', tgl_gbng = '$tgl_rilis' WHERE id_user = '$id_user'");

    if ($queryUser) {
        // Update ke tabel t_ortu dengan id_user
        $queryOrtu = mysqli_query($koneksi, "UPDATE t_ortu SET nm_ortu = '$nmortu' WHERE id_ortu = '$id_ortu'");

        if ($queryOrtu) {
            echo "<script>alert('Data berhasil diperbarui!')</script>";
            header("refresh:0, ortu.php");
        } else {
            echo "<script>alert('Data gagal diperbarui di t_ortu!')</script>";
            header("refresh:0, ortu.php");
        }
    } else {
        echo "<script>alert('Data gagal diperbarui di tb_user!')</script>";
        header("refresh:0, ortu.php");
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
    <title>Edit Orang Tua</title>
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
                <h3>Edit Orang Tua</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="nm_ortu" class="form-label">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="nmortu" placeholder="Nama Orang Tua" name="nmortu" value="<?php echo isset($nmortu) ? $nmortu : ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="update">Update</button>
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