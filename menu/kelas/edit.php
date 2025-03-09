<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil id_kls dari URL
$id_kls = $_GET['id'];

// Ambil data kelas berdasarkan id_kls
$query = "SELECT * FROM t_kelas WHERE id_kls = '$id_kls'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data kelas tidak ditemukan!";
    exit;
}

// Ambil data wali kelas dan tahun ajaran untuk dropdown
$result_wali = mysqli_query($koneksi, "SELECT * FROM t_guru");
$result_tahun = mysqli_query($koneksi, "SELECT * FROM t_ajaran");

if(isset($_POST['update'])){
    // Mengambil data dari form
    $nm_kelas = $_POST['nmkelas'];
    $wali_kelas = $_POST['wali_kelas'];  // ID wali kelas yang dipilih
    $tahun_ajaran = $_POST['tahun_ajaran'];  // ID tahun ajaran yang dipilih

    if (empty($nm_kelas) || empty($wali_kelas) || empty($tahun_ajaran)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Query untuk memperbarui data ke tabel t_kelas
    $query_update = "UPDATE t_kelas SET nm_kls = '$nm_kelas', wali = '$wali_kelas', idta = '$tahun_ajaran' WHERE id_kls = '$id_kls'";

    // Eksekusi query
    if(mysqli_query($koneksi, $query_update)){
        echo "<script>alert('Data berhasil diperbarui!')</script>";
        header("refresh:0, kelas.php");
    } else {
        echo "<script>alert('Gagal memperbarui data!')</script>";
        header("refresh:0, kelas.php");
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
    <title>Edit Kelas</title>
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
                <h3>Edit Kelas</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Nama Kelas</label>
                            <input type="text" placeholder="Nama Kelas" name="nmkelas" value="<?php echo $data['nm_kls']; ?>">
                        </div>

                        <!-- Select Wali Kelas -->
                        <div class="group-input">
                            <label>Wali Kelas</label>
                            <select name="wali_kelas" class="select-wrapper">
                                <option value="" disabled>Pilih Wali Kelas</option>
                                <?php
                                // Menampilkan opsi wali kelas
                                while ($row = mysqli_fetch_assoc($result_wali)) {
                                    $selected = ($row['id_guru'] == $data['wali']) ? 'selected' : ''; // Set selected pada wali yang sudah ada
                                    echo "<option value='" . $row['id_guru'] . "' $selected>" . $row['nm_guru'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Select Tahun Ajaran -->
                        <div class="group-input">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="select-wrapper">
                                <option value="" disabled>Pilih Tahun Ajaran</option>
                                <?php
                                // Menampilkan opsi tahun ajaran
                                while ($row = mysqli_fetch_assoc($result_tahun)) {
                                    $selected = ($row['idta'] == $data['idta']) ? 'selected' : ''; // Set selected pada tahun ajaran yang sudah ada
                                    echo "<option value='" . $row['idta'] . "' $selected>Tahun Ajaran " . $row['thn_aw'] . " - " . $row['thn_ak'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="update">Simpan</button>
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