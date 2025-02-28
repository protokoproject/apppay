<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    // Mengambil nilai dari input
    $nm_sts_user = $_POST['nm_sts_user'];
    $ket_sts_user = $_POST['ket_sts_user'];

    // Validasi input (Pastikan tidak ada yang kosong)
    if (empty($nm_sts_user) || empty($ket_sts_user)) {
        echo "<script>alert('Semua Field harus diisi!');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // Memulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Mendapatkan kd_sts_user terakhir
        $last_sts = mysqli_query($koneksi, "SELECT MAX(kd_sts_user) AS last_sts FROM tb_sts_user");
        $last_sts_data = mysqli_fetch_assoc($last_sts);
        $kd_sts_user = $last_sts_data['last_sts'] ? $last_sts_data['last_sts'] + 1 : 1;

        // Menyimpan data ke tb_sts_user
        $query = "INSERT INTO tb_sts_user (kd_sts_user, nm_sts_user, st_sts_user, ket_sts_user) 
                  VALUES ('$kd_sts_user', '$nm_sts_user', '1', '$ket_sts_user')";

        if (!mysqli_query($koneksi, $query)) {
            throw new Exception("Gagal menambahkan ke tb_sts_user: " . mysqli_error($koneksi));
        }

        // Ambil semua kd_menu dari tb_menu dan tambahkan ke tb_role_akses
        $menu_query = mysqli_query($koneksi, "SELECT kd_menu FROM tb_menu");

        if (mysqli_num_rows($menu_query) > 0) {
            while ($menu = mysqli_fetch_assoc($menu_query)) {
                $kd_menu = $menu['kd_menu'];

                // Insert default role akses untuk setiap menu
                $role_query = "INSERT INTO tb_role_akses (kd_sts_user, kd_menu, edit_menu, tmbh_menu, hapus_menu, view_menu, lainnya) 
                               VALUES ('$kd_sts_user', '$kd_menu', '0', '0', '0', '0', '0')";

                if (!mysqli_query($koneksi, $role_query)) {
                    throw new Exception("Gagal menambahkan ke tb_role_akses: " . mysqli_error($koneksi));
                }
            }
        } else {
            throw new Exception("Data di tb_menu tidak ditemukan!");
        }

        // Commit transaksi jika semua query sukses
        mysqli_commit($koneksi);

        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("refresh:0, st_user.php");
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($koneksi);
        error_log($e->getMessage());
        echo "<script>alert('Terjadi kesalahan: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>console.log('Error: " . addslashes($e->getMessage()) . "');</script>";
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
    <title>Tambah Status Pengguna</title>
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
                <h3>Tambah Status Pengguna</h3>
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
                            <input type="text" placeholder="Nama Status Pengguna" name="nm_sts_user">
                        </div>
                        <div class="group-input">
                            <label>Keterangan</label>
                            <textarea placeholder="Keterangan" name="ket_sts_user"></textarea>
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