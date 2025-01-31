<?php
include "../../conn/koneksi.php";

if (isset($_POST['simpan'])) {
    // Mengambil nilai dari input dan memastikan aman
    $nmmenu = mysqli_real_escape_string($koneksi, $_POST['nmmenu']);
    $iconmenu = mysqli_real_escape_string($koneksi, $_POST['iconmenu']);
    $linkmenu = mysqli_real_escape_string($koneksi, $_POST['linkmenu']);
    $urutmenu = $_POST['urutmenu'] ?? 0; // Jika tidak diisi, default 0
    $sts_menu = isset($_POST['sts_menu']) ? 1 : 0; // Checkbox: aktif = 1, tidak aktif = 0
    $kdkey = $_POST['kdkey'] ?? 'utama'; // Default 'utama' jika tidak diisi

    // Validasi input (Pastikan tidak ada yang kosong kecuali urutmenu)
    if (empty($nmmenu) || empty($iconmenu) || empty($linkmenu)) {
        echo "<script>alert('Nama Menu, Icon Menu, dan Link Menu harus diisi!');</script>";
        echo "<script>window.history.back();</script>";
        exit;
    }

    // Mendapatkan kd_menu terakhir
    $last_menu = mysqli_query($koneksi, "SELECT MAX(kd_menu) AS last_menu FROM tb_menu");
    $last_menu_data = mysqli_fetch_assoc($last_menu);
    $kd_menu = $last_menu_data['last_menu'] ? $last_menu_data['last_menu'] + 1 : 1; // Jika NULL, mulai dari 1

    // Menyimpan data ke tb_menu
    $query_menu = "INSERT INTO tb_menu (kd_menu, nm_menu, icon_menu, link_menu, kd_key, gmbr_menu, sts_menu, urut_menu, menu_utama, class_menu) 
                   VALUES ('$kd_menu', '$nmmenu', '$iconmenu', '$linkmenu', '$kdkey', '', '$sts_menu', '$urutmenu', '0', '')";

    if (mysqli_query($koneksi, $query_menu)) {
        // Ambil semua kd_sts_user dari tb_sts_user
        $result_sts_user = mysqli_query($koneksi, "SELECT kd_sts_user FROM tb_sts_user");
        if ($result_sts_user) {
            while ($row = mysqli_fetch_assoc($result_sts_user)) {
                $kd_sts_user = $row['kd_sts_user'];

                // Insert ke tb_role_akses dengan hak akses default (misal: semua diatur ke '0')
                $query_role = "INSERT INTO tb_role_akses (kd_sts_user, kd_menu, edit_menu, tmbh_menu, hapus_menu, view_menu, lainnya) 
                               VALUES ('$kd_sts_user', '$kd_menu', '0', '0', '0', '0', '0')";
                if (!mysqli_query($koneksi, $query_role)) {
                    error_log("Error inserting role: " . mysqli_error($koneksi));
                }
            }
        }

        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("refresh:0, menu.php");
    } else {
        error_log("Error executing query: " . mysqli_error($koneksi));
        echo "<script>alert('Terjadi kesalahan saat menambahkan data! Cek log untuk detail.');</script>";
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
    <title>Tambah Menu</title>
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
                <h3>Tambah Menu</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama Menu</label>
                            <input type="text" placeholder="Nama Menu" name="nmmenu">
                        </div>
                        <div class="group-input">
                            <label>Icon Menu</label>
                            <input type="text" placeholder="Icon Menu" name="iconmenu">
                        </div>
                        <div class="group-input">
                            <label>Link Menu</label>
                            <input type="text" placeholder="Link Menu" name="linkmenu">
                        </div>
                        <div class="group-input">
                            <label>Urut Menu</label>
                            <input type="text" placeholder="Urut Menu" name="urutmenu">
                        </div>
                        <div class="group-input">
                            <label>Status Menu</label>
                            <fieldset class="d-flex align-items-center gap-12">
                                <input class="tf-switch-check" id="switchCheckDefault" type="checkbox" name="sts_menu">
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