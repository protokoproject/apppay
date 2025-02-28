<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Periksa apakah parameter id_kls dan id_mrd tersedia
if (!isset($_GET['id_kls']) || !isset($_GET['id_mrd'])) {
    echo "<script>alert('ID kelas atau murid tidak ditemukan!'); window.location.href='kls_mrd.php';</script>";
    exit;
}

$id_kls = $_GET['id_kls'];
$id_mrd = $_GET['id_mrd'];

// Ambil data kelas berdasarkan id_kls dan id_mrd
$query = mysqli_query($koneksi, "SELECT * FROM t_klsmrd WHERE id_kls = '$id_kls' AND id_mrd = '$id_mrd'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='kls_mrd.php';</script>";
    exit;
}

// Proses update kelas jika tombol simpan ditekan
if (isset($_POST['update'])) {
    $id_kls_baru = $_POST['kelas'];

    if (empty($id_kls_baru)) {
        echo "<script>alert('Kelas harus dipilih!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah kelas baru sama dengan yang lama
    if ($id_kls_baru == $id_kls) {
        echo "<script>alert('Kelas tidak berubah!'); window.location.href='kls_mrd.php';</script>";
        exit;
    }

    // Update kelas di t_klsmrd
    $updateKlsmrd = mysqli_query($koneksi, "UPDATE t_klsmrd SET id_kls = '$id_kls_baru' WHERE id_kls = '$id_kls' AND id_mrd = '$id_mrd'");

    // Update kelas aktif di t_murid
    $updateMurid = mysqli_query($koneksi, "UPDATE t_murid SET kls_aktif = '$id_kls_baru' WHERE id_mrd = '$id_mrd'");

    if ($updateKlsmrd && $updateMurid) {
        echo "<script>alert('Kelas berhasil diperbarui!'); window.location.href='kls_mrd.php';</script>";
        exit;
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui kelas!'); window.history.back();</script>";
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
    <title>Edit Kelas Murid</title>
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
                <h3>Edit Kelas Murid</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <!-- Form Edit Data -->
                    <form method="post">
                        <!-- Pilih Kelas -->
                        <div class="group-input mb-3">
                            <label for="kelas" class="form-label">Pilih Kelas</label>
                            <select class="form-select" id="kelas" name="kelas" required>
                                <option value="" disabled>Pilih Kelas</option>
                                <?php
                                $kelas_query = mysqli_query($koneksi, "SELECT id_kls, nm_kls FROM t_kelas");
                                while ($kelas = mysqli_fetch_array($kelas_query)) {
                                    $selected = ($kelas['id_kls'] == $data['id_kls']) ? "selected" : "";
                                    echo "<option value='" . $kelas['id_kls'] . "' $selected>" . $kelas['nm_kls'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="update">Simpan</button>
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