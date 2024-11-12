<?php
include "../../koneksi.php";

$kd_menu = $_GET['kd_menu'];

$sql = mysqli_query($koneksi, "SELECT * FROM tb_menu WHERE kd_menu = '$kd_menu'");
$data = mysqli_fetch_array($sql);

if (isset($_POST['simpan'])) {
    // Mengambil nilai dari input
    $nmmenu = $_POST['nmmenu'];
    $iconmenu = $_POST['iconmenu'];
    $linkmenu = $_POST['linkmenu'];
    $kdkey = $_POST['kdkey'];

    $query = "UPDATE tb_menu SET nm_menu = '$nmmenu', icon_menu = '$iconmenu', link_menu = '$linkmenu', kd_key = '$kdkey' WHERE kd_menu = '$kd_menu'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data berhasil diubah!');
                setTimeout(function() {
                    window.location.href = 'kelolamenu.php';
                }, 1000); // Redirects after 1 second
              </script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
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
    <title>Edit Menu</title>
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
                <h3>Edit Menu</h3>
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
                            <input type="text" placeholder="Nama Menu" name="nmmenu" value="<?php echo $data['nm_menu']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Icon Menu</label>
                            <input type="text" placeholder="Icon Menu" name="iconmenu" value="<?php echo $data['icon_menu']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Link Menu</label>
                            <input type="text" placeholder="Link Menu" name="linkmenu" value="<?php echo $data['link_menu']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Kode Key</label>
                            <input type="text" placeholder="Kode Key" name="kdkey" value="<?php echo $data['kd_key']; ?>">
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