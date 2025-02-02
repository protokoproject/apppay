<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (isset($_POST['simpan'])) {
    // Pastikan semua input di-trim untuk menghindari spasi yang tidak disengaja
    $nmmurid = isset($_POST['nmmurid']) ? trim($_POST['nmmurid']) : '';
    $nisn = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';
    $saldo = isset($_POST['saldo']) ? trim($_POST['saldo']) : '';
    $kls_aktif = isset($_POST['kls_aktif']) ? trim($_POST['kls_aktif']) : '';
    $id_ortu = isset($_POST['nm_ortu']) ? trim($_POST['nm_ortu']) : '';
    $tgl_rilis = date("Y-m-d");

    // Validasi input agar tidak ada yang kosong
    if ($nmmurid === '' || $nisn === '' || $saldo === '' || $kls_aktif === '' || $id_ortu === '') {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Validasi format NISN
    if (!ctype_digit($nisn) || strlen($nisn) != 10) {
        echo "<script>alert('NISN harus berupa 10 digit angka!'); window.history.back();</script>";
        exit;
    }

    // Validasi saldo sebagai angka positif
    if (!is_numeric($saldo) || $saldo < 0) {
        echo "<script>alert('Saldo harus berupa angka positif!'); window.history.back();</script>";
        exit;
    }

    // Validasi unik NISN
    $cekNISN = mysqli_query($koneksi, "SELECT * FROM t_murid WHERE nisn = '$nisn'");
    if (mysqli_num_rows($cekNISN) > 0) {
        echo "<script>alert('NISN sudah terdaftar. Silakan gunakan NISN lain!'); window.history.back();</script>";
        exit;
    }

    // Ambil id_app berdasarkan session username
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Session tidak valid. Silakan login kembali.'); window.location.href='login.php';</script>";
        exit;
    }

    $username_session = $_SESSION['username'];
    $queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
    if (!$queryApp || mysqli_num_rows($queryApp) == 0) {
        echo "<script>alert('Kesalahan dalam mengambil data aplikasi.'); window.history.back();</script>";
        exit;
    }
    $rowApp = mysqli_fetch_assoc($queryApp);
    $id_app = $rowApp['id_app'];

    // Ambil ID Murid terbaru dan tambahkan 1
    $auto = mysqli_query($koneksi, "SELECT MAX(id_mrd) as max_code FROM t_murid");
    $hasil = mysqli_fetch_assoc($auto);
    $idmurid = ($hasil['max_code']) ? (int)$hasil['max_code'] + 1 : 1;

    // Ambil ID User terbaru (pastikan bertambah dengan benar)
    $auto2 = mysqli_query($koneksi, "SELECT IFNULL(MAX(id_user), 0) + 1 AS new_user_id FROM tb_user");
    $row2 = mysqli_fetch_assoc($auto2);
    $id_user = $row2['new_user_id'];

    // Buat username (kombinasi nama depan + id_mrd + id_app)
    $nama_parts = explode(" ", $nmmurid);
    $username = strtolower($nama_parts[0]) . $idmurid . $id_app;

    // Hash password
    $password_default = "1234";
    $password_hash = password_hash($password_default, PASSWORD_DEFAULT);

    // Insert ke tabel tb_user
    $queryUser = mysqli_query($koneksi, "INSERT INTO tb_user(id_user, id_app, nm_user, kd_sts_user, username, pass, pass_txt, nohp, tgl_lhr, tgl_gbng) 
                                         VALUES ('$id_user', '$id_app', '$nmmurid', '7', '$username', '$password_hash', '$password_default', '', '$tgl_rilis', '$tgl_rilis')");

    if ($queryUser) {
        // Insert ke tabel t_murid dengan id_ortu
        $queryMurid = mysqli_query($koneksi, "INSERT INTO t_murid(id_mrd, nm_murid, nisn, saldo, kls_aktif, id_ortu, id_user) 
                                              VALUES ('$idmurid','$nmmurid', '$nisn', '$saldo', '$kls_aktif', '$id_ortu', '$id_user')");

        if ($queryMurid) {
            echo "<script>alert('Data Murid berhasil ditambahkan!'); window.location.href='murid.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data murid. Silakan coba lagi.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal menyimpan data pengguna. Silakan coba lagi.'); window.history.back();</script>";
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
    <title>Tambah Murid</title>
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
                <h3>Tambah Murid</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="nm_mrd" class="form-label">Nama Murid</label>
                            <input type="text" class="form-control" id="nmmurid" placeholder="Nama Murid" name="nmmurid">
                        </div>
                        <div class="group-input mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="number" class="form-control" id="nisn" placeholder="NISN" name="nisn">
                        </div>
                        <div class="group-input">
                            <label for="nm_ortu">Nama Orang Tua</label>
                            <select name="nm_ortu" id="nm_ortu" class="form-control" required>
                                <option value="" disabled selected>Pilih Nama Orang Tua</option>
                                <?php
                                $result_kelas = mysqli_query($koneksi, "SELECT * FROM t_ortu");
                                while ($row = mysqli_fetch_assoc($result_kelas)) {
                                    echo "<option value='" . $row['id_ortu'] . "'>" . $row['nm_ortu'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input">
                            <label for="kls_aktif">Kelas</label>
                            <select name="kls_aktif" id="kls_aktif" class="form-control" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                <?php
                                $result_kelas = mysqli_query($koneksi, "SELECT * FROM t_kelas");
                                while ($row = mysqli_fetch_assoc($result_kelas)) {
                                    echo "<option value='" . $row['id_kls'] . "'>" . $row['nm_kls'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="number" class="form-control" id="saldo" placeholder="Saldo" name="saldo">
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