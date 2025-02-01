<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

// Ambil id_kantin dari parameter URL jika ada
if (isset($_GET['id'])) {
    $id_kantin = $_GET['id'];

    // Ambil data kantin berdasarkan id_kantin
    $queryKantin = mysqli_query($koneksi, "SELECT * FROM t_kantin WHERE id_kantin = '$id_kantin'");
    $hasilKantin = mysqli_fetch_assoc($queryKantin);

    // Jika data kantin ditemukan, masukkan ke dalam variabel
    if ($hasilKantin) {
        $nmkantin = $hasilKantin['nm_kantin'];
        $st_kantin = $hasilKantin['st_kantin'];
    } else {
        echo "<script>alert('Data kantin tidak ditemukan!'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('ID Kantin tidak tersedia!'); window.history.back();</script>";
    exit;
}

if (isset($_POST['simpan'])) {
    $nmkantin = isset($_POST['nmkantin']) ? trim($_POST['nmkantin']) : '';
    $st_kantin = isset($_POST['sts_kantin']) ? 1 : 0; // Checkbox: jika diceklis = 1, jika tidak = 0
    $tgl_rilis = date("Y-m-d");

    // Validasi input tidak boleh kosong
    if (empty($nmkantin)) {
        echo "<script>alert('Nama kantin harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Ambil id_app berdasarkan session username
    $username_session = $_SESSION['username'];
    $queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
    $rowApp = mysqli_fetch_assoc($queryApp);
    $id_app = $rowApp['id_app'];

    // Ambil ID User berdasarkan id_kantin
    $queryUser = mysqli_query($koneksi, "SELECT id_user FROM t_kantin WHERE id_kantin = '$id_kantin'");
    $rowUser = mysqli_fetch_assoc($queryUser);
    $id_user = $rowUser['id_user'];

    // Buat username baru berdasarkan format (nmkantin + id_kantin + id_app)
    $nama_parts = explode(" ", $nmkantin);
    $username_baru = strtolower($nama_parts[0]) . $id_kantin . $id_app;

    // Update data ke tabel t_kantin
    $queryUpdateKantin = mysqli_query($koneksi, "UPDATE t_kantin SET nm_kantin = '$nmkantin', st_kantin = '$st_kantin' WHERE id_kantin = '$id_kantin'");

    if ($queryUpdateKantin) {
        // Update username dan nm_user di tabel tb_user
        $queryUpdateUser = mysqli_query($koneksi, "UPDATE tb_user SET nm_user = '$nmkantin', username = '$username_baru' WHERE id_user = '$id_user'");

        if ($queryUpdateUser) {
            echo "<script>alert('Data berhasil diubah!')</script>";
            header("refresh:0, kantin.php");
        } else {
            echo "<script>alert('Data gagal diperbarui di tb_user!')</script>";
            header("refresh:0, kantin.php");
        }
    } else {
        echo "<script>alert('Data gagal diperbarui di t_kantin!')</script>";
        header("refresh:0, kantin.php");
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
    <title>Tambah Kantin</title>
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
                <h3>Tambah Kantin</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">

                    <form method="post">
                        <div class="group-input">
                            <label>Nama Kantin</label>
                            <input type="text" placeholder="Nama Kantin" name="nmkantin" value="<?php echo htmlspecialchars($nmkantin); ?>">
                        </div>
                        <div class="group-input">
                            <label>Status Kantin</label>
                            <fieldset class="d-flex align-items-center gap-12">
                                <input class="tf-switch-check" id="switchCheckDefault" type="checkbox" name="sts_kantin" <?php echo $st_kantin == 1 ? 'checked' : ''; ?>>
                                <label for="switchCheckDefault">Aktif</label>
                            </fieldset>
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