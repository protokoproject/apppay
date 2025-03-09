<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil data berdasarkan id_tgh dari URL
$id_tgh = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM t_tghbyr WHERE id_tgh = '$id_tgh'");
$data = mysqli_fetch_array($query);

// Simpan perubahan
if (isset($_POST['simpan'])) {
    $id_ktgb = isset($_POST['kategori']) ? trim($_POST['kategori']) : null;
    $idta = isset($_POST['tahun']) ? trim($_POST['tahun']) : null;
    $nom = $_POST['nominal'];

    // Validasi input tidak boleh kosong
    if (empty($id_ktgb) || empty($idta) || empty($nom)) {
        echo "<script>alert('Semua field harus diisi!'); history.go(-1);</script>";
        exit;
    }

    $update_query = "UPDATE t_tghbyr SET id_ktgb='$id_ktgb', idta='$idta', nom='$nom' WHERE id_tgh='$id_tgh'";

    if (mysqli_query($koneksi, $update_query)) {
        echo "<script>alert('Data berhasil diubah!');</script>";
        header("refresh:0; bayar.php");
        exit;
    } else {
        echo "<script>alert('Data gagal diubah!');</script>";
        header("refresh:0; bayar.php");
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
    <title>Tambah Tagihan Bayar</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    <style>
        /* Menyamakan TomSelect dengan input */
        .tomselect {
            width: 100% !important;
            height: 40px !important;
            /* Sesuaikan dengan input */
            border-radius: 8px !important;
            border: 1px solid #ccc !important;
            font-size: 14px !important;
            /* Ukuran font lebih kecil */
            padding: 8px 12px !important;
            background-color: white !important;
            box-sizing: border-box !important;
            position: relative;
        }

        /* Memastikan dropdown TomSelect juga memiliki gaya yang seragam */
        .ts-control {
            border-radius: 8px !important;
            height: 40px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            border: 1px solid #ccc !important;
            display: flex;
            align-items: center;
            position: relative;
        }

        /* Menambahkan ikon dropdown di sebelah kanan */
        .ts-control::after {
            content: "▼";
            /* Icon dropdown */
            font-size: 12px;
            /* Ukuran lebih kecil */
            position: absolute;
            right: 12px;
            color: #888;
            pointer-events: none;
            /* Supaya tidak bisa diklik */
        }

        /* Menyamakan tampilan dropdown list */
        .ts-dropdown {
            border-radius: 8px !important;
            font-size: 14px !important;
            border: 1px solid #ccc !important;
        }

        /* Mengatur item dalam dropdown */
        .ts-dropdown .option {
            font-size: 14px !important;
            padding: 8px 12px !important;
        }
    </style>
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
                <h3>Tambah Tagihan Bayar</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <!-- Pilih Kategori Bayar -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Pilih Kategori Bayar</label>
                            <select class="select-wrapper" id="kategori" name="kategori">
                                <option value="" disabled>Pilih Kategori Bayar</option>
                                <?php
                                $kategori_query = mysqli_query($koneksi, "SELECT id_ktgb, nm_ktgb FROM t_ktgbyr");
                                while ($kategori = mysqli_fetch_array($kategori_query)) {
                                    $selected = ($kategori['id_ktgb'] == $data['id_ktgb']) ? "selected" : "";
                                    echo "<option value='" . $kategori['id_ktgb'] . "' $selected>" . $kategori['nm_ktgb'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Pilih Tahun Ajaran -->
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun Ajaran</label>
                            <select class="select-wrapper" id="tahun" name="tahun">
                                <option value="" disabled>Pilih Tahun Ajaran</option>
                                <?php
                                $tahun_query = mysqli_query($koneksi, "SELECT idta, thn_aw, thn_ak FROM t_ajaran");
                                while ($tahun = mysqli_fetch_array($tahun_query)) {
                                    // Mengecek apakah sedang dalam mode edit dan mencocokkan idta yang sedang diedit
                                    $selected = (isset($data['idta']) && $tahun['idta'] == $data['idta']) ? "selected" : "";
                                    echo "<option value='" . $tahun['idta'] . "' $selected>Tahun Ajaran " . $tahun['thn_aw'] . " - " . $tahun['thn_ak'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Input Nominal -->
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal Tagihan (Rp)</label>
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Contoh: 300000" value="<?= $data['nom']; ?>">
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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("select").forEach(function(select) {
                let ts = new TomSelect(select, {
                    placeholder: "Pilih salah satu...",
                    create: false,
                    allowEmptyOption: true, // Tetap biarkan opsi kosong
                    maxItems: 1,
                    hideSelected: true,
                    dropdownParent: "body", // Pastikan dropdown tidak berantakan
                });

                // Tambahkan scrollbar jika lebih dari 4 opsi
                let optionCount = select.options.length;
                if (optionCount > 4) {
                    let dropdown = ts.dropdown_content;
                    dropdown.style.maxHeight = "150px"; // Batasi tinggi dropdown
                    dropdown.style.overflowY = "auto"; // Tambahkan scrollbar jika lebih dari 4 opsi
                }
            });
        });
    </script>

</body>

</html>