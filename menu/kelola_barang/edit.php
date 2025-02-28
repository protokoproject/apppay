<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}
// Ambil kd_brg dari URL
$kd_brg = $_GET['kd_brg'];

// Ambil data barang berdasarkan kd_brg
$query = "SELECT * FROM t_brg WHERE kd_brg = '$kd_brg'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data barang tidak ditemukan!";
    exit;
}

// Ambil data kategori dan kantin untuk dropdown
$result_kategori = mysqli_query($koneksi, "SELECT * FROM t_ktg");
$result_kantin = mysqli_query($koneksi, "SELECT * FROM t_kantin");

if (isset($_POST['simpan'])) {
    // Mengambil data dari form
    $nm_brg = $_POST['nm_brg'];
    $id_ktg = isset($_POST['kategori']) ? trim($_POST['kategori']) : null;
    $id_kantin = isset($_POST['kantin']) ? trim($_POST['kantin']) : null;
    $st_brg = isset($_POST['st_brg']) ? 1 : 0;
    $hrg_jual = $_POST['hrg_jual'];

    // Validasi: Cek apakah semua input sudah diisi
    if (empty($nm_brg) || empty($id_ktg) || empty($id_kantin) || empty($hrg_jual)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Query untuk memperbarui data ke tabel t_brg
    $query_update = "UPDATE t_brg SET 
        nm_brg = '$nm_brg', 
        id_ktg = '$id_ktg', 
        id_kantin = '$id_kantin', 
        st_brg = '$st_brg', 
        hrg_jual = '$hrg_jual' 
        WHERE kd_brg = '$kd_brg'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Data berhasil diubah!'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Data gagal diubah!'); window.history.back();</script>";
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
    <title>Tambah Barang</title>
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
                <h3>Tambah Barang</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama Barang</label>
                            <input type="text" name="nm_brg" value="<?php echo $data['nm_brg']; ?>">
                        </div>
                        <div class="group-input mb-3">
                            <label for="kategori" class="form-label">Pilih Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="" disabled>Pilih Kategori</option>
                                <?php
                                $kategori_query = mysqli_query($koneksi, "SELECT id_ktg, nm_ktg FROM t_ktg");
                                while ($kategori = mysqli_fetch_array($kategori_query)) {
                                    $selected = ($kategori['id_ktg'] == $data['id_ktg']) ? "selected" : "";
                                    echo "<option value='" . $kategori['id_ktg'] . "' $selected>" . $kategori['nm_ktg'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label for="kantin" class="form-label">Pilih Kantin</label>
                            <select class="form-select" id="kantin" name="kantin">
                                <option value="" disabled>Pilih Kantin</option>
                                <?php
                                $kantin_query = mysqli_query($koneksi, "SELECT id_kantin, nm_kantin FROM t_kantin");
                                while ($kantin = mysqli_fetch_array($kantin_query)) {
                                    $selected = ($kantin['id_kantin'] == $data['id_kantin']) ? "selected" : "";
                                    echo "<option value='" . $kantin['id_kantin'] . "' $selected>" . $kantin['nm_kantin'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hrg_jual" class="form-label">Harga Jual (Rp)</label>
                            <input type="number" class="form-control" id="hrg_jual" name="hrg_jual" value="<?php echo $data['hrg_jual']; ?>">
                        </div>
                        <div class="group-input">
                            <label>Status Barang</label>
                            <fieldset class="d-flex align-items-center gap-2">
                                <input class="tf-switch-check" id="switchCheckDefault" type="checkbox" name="st_brg" <?php echo ($data['st_brg'] == 1) ? "checked" : ""; ?>>
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