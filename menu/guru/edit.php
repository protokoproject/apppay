<?php
include "../../conn/koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

$id = $_GET['id'];
$sql = mysqli_query($koneksi, "SELECT nm_guru, sp_mapel, id_user FROM t_guru WHERE id_guru = '$id'");
$data = mysqli_fetch_array($sql);

if (isset($_POST['simpan'])) {
    $nmguru = $_POST['nmguru'];
    $spmapel = $_POST['spmapel'];

    // Ambil id_app berdasarkan session username
    $username_session = $_SESSION['username'];
    $queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
    $rowApp = mysqli_fetch_assoc($queryApp);
    $id_app = $rowApp['id_app'];

    // Update data di t_guru
    $query = mysqli_query($koneksi, "UPDATE t_guru SET nm_guru='$nmguru', sp_mapel='$spmapel' WHERE id_guru='$id'");

    if ($query) {
        // Ambil id_user terkait dengan id_guru
        $id_user = $data['id_user'];

        // Update data di tb_user
        $nama_parts = explode(" ", trim($nmguru));
        $username = strtolower($nama_parts[0]) . $id . $id_app;
        $update_user = mysqli_query($koneksi, "UPDATE tb_user SET nm_user='$nmguru', username='$username', id_app='$id_app' WHERE id_user='$id_user'");

        if ($update_user) {
            echo "<script>alert('Data berhasil diubah!')</script>";
            header("refresh:0, guru.php");
            exit;
        } else {
            echo "<script>alert('Data guru berhasil diubah, tetapi update user gagal!')</script>";
            header("refresh:0, guru.php");
            exit;
        }
    } else {
        echo "<script>alert('Data gagal diubah!')</script>";
        header("refresh:0, guru.php");
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
    <title>Edit Spesialis Mata Pelajaran</title>
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
                <h3>Edit Spesialis Mata Pelajaran</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="nm_guru" class="form-label">Nama Guru</label>
                            <input type="text" class="form-control" id="nmguru" placeholder="Nama Guru" name="nmguru" value="<?php echo $data['nm_guru'] ?>">
                        </div>
                        <div class="group-input mb-3">
                            <label for="spmapel" class="form-label">Spesialis Mata Pelajaran</label>
                            <select class="form-select" id="spmapel" name="spmapel">
                                <option value="" disabled>Pilih Mata Pelajaran</option>
                                <?php
                                include "../../conn/koneksi.php";

                                // Ambil daftar mata pelajaran dari database
                                $mapel_query = mysqli_query($koneksi, "SELECT nm_mapel FROM t_mapel");

                                // Pastikan nilai sebelumnya tersimpan
                                $selected_mapel = isset($data['sp_mapel']) ? $data['sp_mapel'] : '';

                                while ($mapel = mysqli_fetch_array($mapel_query)) {
                                    $selected = ($mapel['nm_mapel'] == $selected_mapel) ? "selected" : "";
                                    echo "<option value='" . $mapel['nm_mapel'] . "' $selected>" . $mapel['nm_mapel'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="simpan">Simpan</button>
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