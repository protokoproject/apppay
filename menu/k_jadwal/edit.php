<?php
session_start();

include "../../conn/koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

$id_jadwal = $_GET['id'];

if (isset($_POST['simpan'])) {
    $id_kls = $_POST['kelas'];
    $id_mapel = $_POST['mapel'];
    $id_guru = $_POST['guru'];
    $id_tahun_ajaran = $_POST['tahun_ajaran'];
    $hari = $_POST['hari'];
    $jam_aw = $_POST['jam_aw'];
    $jam_ak = $_POST['jam_ak'];

    // Validasi input tidak boleh kosong
    if (empty($id_kls) || empty($id_mapel) || empty($id_guru) || empty($id_tahun_ajaran) || empty($hari) || empty($jam_aw) || empty($jam_ak)) {
        echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
        exit;
    }

    // Update data ke database
    $query = "UPDATE t_jadwal SET 
              id_kls='$id_kls', 
              id_mapel='$id_mapel', 
              id_guru='$id_guru', 
              idta='$id_tahun_ajaran', 
              hari='$hari', 
              jam_aw='$jam_aw', 
              jam_ak='$jam_ak' 
              WHERE id_jadwal='$id_jadwal'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='jadwal.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
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
    <title>Edit Jadwal Pelajaran</title>
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
                <h3>Edit Jadwal Pelajaran</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <?php
                    include "../../conn/koneksi.php";


                    // Query untuk mengambil data jadwal berdasarkan id_jadwal
                    $query = "SELECT * FROM t_jadwal WHERE id_jadwal = '$id_jadwal'";
                    $result = mysqli_query($koneksi, $query);
                    $data = mysqli_fetch_assoc($result);
                    ?>

                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="select-wrapper" id="kelas" name="kelas">
                                <option value="" disabled>Pilih Kelas</option>
                                <?php
                                $kelas_query = mysqli_query($koneksi, "SELECT id_kls, nm_kls FROM t_kelas");
                                while ($kelas = mysqli_fetch_array($kelas_query)) {
                                    $selected = ($kelas['id_kls'] == $data['id_kls']) ? "selected" : "";
                                    echo "<option value='" . $kelas['id_kls'] . "' $selected>" . $kelas['nm_kls'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="group-input mb-3">
                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                            <select class="select-wrapper" id="mapel" name="mapel">
                                <option value="" disabled>Pilih Mata Pelajaran</option>
                                <?php
                                $mapel_query = mysqli_query($koneksi, "SELECT id_mapel, nm_mapel FROM t_mapel");
                                while ($mapel = mysqli_fetch_array($mapel_query)) {
                                    $selected = ($mapel['id_mapel'] == $data['id_mapel']) ? "selected" : "";
                                    echo "<option value='" . $mapel['id_mapel'] . "' $selected>" . $mapel['nm_mapel'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="group-input mb-3">
                            <label for="guru" class="form-label">Guru</label>
                            <select class="select-wrapper" id="guru" name="guru">
                                <option value="" disabled>Pilih Guru</option>
                                <?php
                                $guru_query = mysqli_query($koneksi, "SELECT id_guru, nm_guru FROM t_guru");
                                while ($guru = mysqli_fetch_array($guru_query)) {
                                    $selected = ($guru['id_guru'] == $data['id_guru']) ? "selected" : "";
                                    echo "<option value='" . $guru['id_guru'] . "' $selected>" . $guru['nm_guru'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="group-input mb-3">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="select-wrapper" required>
                                <option value="" disabled>Pilih Tahun Ajaran</option>
                                <?php
                                $result_tahun = mysqli_query($koneksi, "SELECT * FROM t_ajaran");
                                while ($row = mysqli_fetch_assoc($result_tahun)) {
                                    $selected = ($row['idta'] == $data['idta']) ? "selected" : "";
                                    echo "<option value='" . $row['idta'] . "' $selected>Tahun Ajaran " . $row['thn_aw'] . " - " . $row['thn_ak'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="group-input mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <input type="text" class="form-control" id="hari" name="hari" value="<?php echo $data['hari']; ?>">
                        </div>

                        <div class="group-input mb-3">
                            <label for="jam_aw" class="form-label">Jam Awal</label>
                            <input type="time" class="form-control" id="jam_aw" name="jam_aw" value="<?php echo $data['jam_aw']; ?>">
                        </div>

                        <div class="group-input mb-3">
                            <label for="jam_ak" class="form-label">Jam Akhir</label>
                            <input type="time" class="form-control" id="jam_ak" name="jam_ak" value="<?php echo $data['jam_ak']; ?>">
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