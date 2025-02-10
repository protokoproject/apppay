<?php
session_start();
require "../../conn/koneksi.php";
require __DIR__ . '/vendor/autoload.php'; // Pastikan composer autoload sudah dipanggil

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium; // Perbaikan namespace
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin; // Perbaikan namespace

if (isset($_POST['simpan'])) {
    $id_kls = $_POST['kelas'];
    $id_mapel = $_POST['mapel'];
    $id_guru = $_POST['guru'];
    $id_tahun_ajaran = $_POST['tahun_ajaran'];
    $hari = $_POST['hari'];
    $jam_aw = $_POST['jam_aw'];
    $jam_ak = $_POST['jam_ak'];

    // Generate auto increment untuk id_jadwal
    $auto = mysqli_query($koneksi, "SELECT MAX(id_jadwal) as max_code FROM t_jadwal");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $id_jadwal = ($code) ? (int)$code + 1 : 1;

    // Format data QR Code
    $qr_text = "id_jadwal:$id_jadwal\nid_kls:$id_kls";

    // Membuat QR Code menggunakan Endroid
    $qrCode = new QrCode($qr_text);
    $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelMedium()); // ✅ Perbaikan Error Correction Level
    $qrCode->setSize(300);
    $qrCode->setMargin(10);
    $qrCode->setRoundBlockSizeMode(new RoundBlockSizeModeMargin()); // ✅ Perbaikan Round Block Size Mode

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Folder untuk menyimpan QR Code
    $qr_folder = "qr_codes/";
    if (!file_exists($qr_folder)) {
        mkdir($qr_folder, 0777, true);
    }

    // Nama file unik
    $qr_filename = $qr_folder . uniqid() . ".png";

    // Simpan QR Code sebagai file PNG
    file_put_contents($qr_filename, $result->getString());

    // Simpan ke database
    $query = "INSERT INTO t_jadwal (id_jadwal, id_kls, id_mapel, id_guru, idta, hari, jam_aw, jam_ak, qr_code) 
              VALUES ('$id_jadwal', '$id_kls', '$id_mapel', '$id_guru', '$id_tahun_ajaran', '$hari', '$jam_aw', '$jam_ak', '$qr_filename')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!')</script>";
        header("refresh:0, jadwal.php");
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "')</script>";
        header("refresh:0, jadwal.php");
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
    <title>Tambah Jadwal Pelanjaran</title>
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
                <h3>Tambah Jadwal Pelajaran</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas" name="kelas">
                                <option value="" selected disabled>Pilih Kelas</option>
                                <?php
                                include "../../conn/koneksi.php";
                                $kelas_query = mysqli_query($koneksi, "SELECT id_kls, nm_kls FROM t_kelas");
                                while ($kelas = mysqli_fetch_array($kelas_query)) {
                                    echo "<option value='" . $kelas['id_kls'] . "'>" . $kelas['nm_kls'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mapel" name="mapel">
                                <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                <?php
                                include "../../conn/koneksi.php";
                                $mapel_query = mysqli_query($koneksi, "SELECT id_mapel, nm_mapel FROM t_mapel");
                                while ($mapel = mysqli_fetch_array($mapel_query)) {
                                    echo "<option value='" . $mapel['id_mapel'] . "'>" . $mapel['nm_mapel'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label for="guru" class="form-label">Guru</label>
                            <select class="form-select" id="guru" name="guru">
                                <option value="" selected disabled>Pilih Guru</option>
                                <?php
                                include "../../conn/koneksi.php";
                                $guru_query = mysqli_query($koneksi, "SELECT id_guru, nm_guru FROM t_guru");
                                while ($guru = mysqli_fetch_array($guru_query)) {
                                    echo "<option value='" . $guru['id_guru'] . "'>" . $guru['nm_guru'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label>Tahun Ajaran</label>
                            <select name="tahun_ajaran" required>
                                <option value="" disabled selected>Pilih Tahun Ajaran</option>
                                <?php
                                // Koneksi ke database dan mengambil data Tahun Ajaran dari tabel t_ajaran
                                $result_tahun = mysqli_query($koneksi, "SELECT * FROM t_ajaran");
                                while ($row = mysqli_fetch_assoc($result_tahun)) {
                                    echo "<option value='" . $row['idta'] . "'>Tahun Ajaran " . $row['thn_aw'] . " - " . $row['thn_ak'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="group-input mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <input type="text" class="form-control" id="hari" placeholder="Hari" name="hari">
                        </div>
                        <div class="group-input mb-3">
                            <label for="jam_aw" class="form-label">Jam Awal</label>
                            <input type="time" class="form-control" id="jam_aw" name="jam_aw">
                        </div>
                        <div class="group-input mb-3">
                            <label for="jam_ak" class="form-label">Jam Akhir</label>
                            <input type="time" class="form-control" id="jam_ak" name="jam_ak">
                        </div>

                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
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