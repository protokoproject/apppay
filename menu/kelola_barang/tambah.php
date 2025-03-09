<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

$kd_sts_user = $_SESSION['kd_sts_user'] ?? null;
$username = $_SESSION['username'] ?? '';
$kantin_selected = '';

if ($kd_sts_user == 9) {
    $result = mysqli_query($koneksi, "SELECT k.id_kantin FROM t_kantin k JOIN tb_user u ON k.id_user = u.id_user WHERE u.username = '$username'");
    $row = mysqli_fetch_assoc($result);
    $kantin_selected = $row['id_kantin'] ?? '';
}

if (isset($_POST['simpan'])) {
    $nm_brg = $_POST['nm_brg'];
    $id_ktg = isset($_POST['kategori']) ? trim($_POST['kategori']) : null;
    $id_kantin = ($kd_sts_user == 1) ? (isset($_POST['kantin']) ? trim($_POST['kantin']) : null) : $kantin_selected;
    $st_brg = isset($_POST['st_brg']) ? 1 : 0;
    $hrg_jual = $_POST['hrg_jual'];

    if (empty($nm_brg) || empty($id_ktg) || empty($id_kantin) || empty($hrg_jual)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    $auto = mysqli_query($koneksi, "SELECT MAX(kd_brg) as max_code FROM t_brg");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $kd_brg = ($code) ? (int)$code + 1 : 1;

    $query = mysqli_query($koneksi, "INSERT INTO t_brg (kd_brg, nm_brg, id_ktg, id_kantin, st_brg, hrg_jual) 
                                     VALUES ('$kd_brg', '$nm_brg', '$id_ktg', '$id_kantin', '$st_brg', '$hrg_jual')");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
        header("refresh:0, barang.php");
    } else {
        echo "<script>alert('Data gagal ditambahkan!'); window.history.back();</script>";
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
                            <input type="text" placeholder="Nama Barang" name="nm_brg">
                        </div>
                        <div class="group-input mb-3">
                            <label for="kategori" class="form-label">Pilih Kategori</label>
                            <select class="select-wrapper" id="kategori" name="kategori">
                                <option value="" selected disabled>Pilih Kategori</option>
                                <?php
                                include "../../conn/koneksi.php";
                                $kategori_query = mysqli_query($koneksi, "SELECT id_ktg, nm_ktg FROM t_ktg");
                                while ($kategori = mysqli_fetch_array($kategori_query)) {
                                    echo "<option value='" . $kategori['id_ktg'] . "'>" . $kategori['nm_ktg'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <?php if ($kd_sts_user == 1) { ?>
                            <div class="group-input mb-3">
                                <label for="kantin" class="form-label">Pilih Kantin</label>
                                <select class="select-wrapper" id="kantin" name="kantin">
                                    <option value="" selected disabled>Pilih Kantin</option>
                                    <?php
                                    $kantin_query = mysqli_query($koneksi, "SELECT id_kantin, nm_kantin FROM t_kantin");
                                    while ($kantin = mysqli_fetch_array($kantin_query)) {
                                        echo "<option value='" . $kantin['id_kantin'] . "'>" . $kantin['nm_kantin'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } elseif ($kd_sts_user == 9) { ?>
                            <input type="hidden" name="kantin" value="<?php echo $kantin_selected; ?>">
                        <?php } ?>

                        <div class="mb-3">
                            <label for="hrg_jual" class="form-label">Harga Jual (Rp)</label>
                            <input type="number" class="form-control" id="hrg_jual" name="hrg_jual" placeholder="Contoh: 300000">
                        </div>
                        <div class="group-input">
                            <label>Status Barang</label>
                            <fieldset class="d-flex align-items-center gap-12">
                                <input class="tf-switch-check" id="switchCheckDefault" type="checkbox" name="st_brg">
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