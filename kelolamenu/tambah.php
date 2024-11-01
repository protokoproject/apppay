<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    // Mengambil nilai dari input
    $nmmenu = $_POST['nmmenu'];
    $iconmenu = $_POST['iconmenu'];
    $linkmenu = $_POST['linkmenu'];
    $kdkey = $_POST['kdkey'];

    $last_menu = mysqli_query($koneksi, "SELECT MAX(kd_menu) AS last_menu FROM tb_menu");
    $last_menu_data = mysqli_fetch_assoc($last_menu);
    $kd_menu = $last_menu_data['last_menu'] + 1;
    $urut_menu = $last_menu_data['last_menu'] + 1;
    $gmbr_menu = '';
    $class_menu = '';
    $sts_menu = 1;
    $menu_utama = 0;

    $query = "INSERT INTO tb_menu (kd_menu, nm_menu, icon_menu, link_menu, kd_key, gmbr_menu, sts_menu, urut_menu, menu_utama, class_menu) 
              VALUES ('$kd_menu', '$nmmenu', '$iconmenu', '$linkmenu', '$kdkey', '$gmbr_menu', '$sts_menu', '$urut_menu', '$menu_utama', '$class_menu')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Tambah Menu</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../fonts/icons-alipay.css">
    <link rel="stylesheet" href="../styles/bootstrap.css">
    <link rel="stylesheet" href="../styles/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/styles.css" />
    <link rel="manifest" href="../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../app/icons/icon-192x192.png">
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
                            <label>Kode Key</label>
                            <input type="text" placeholder="Kode Key" name="kdkey">
                        </div>
                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-navigation-bar">
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

    <script type="text/javascript" src="../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../javascript/swiper.js"></script>
    <script type="text/javascript" src="../javascript/main.js"></script>

</body>

</html>