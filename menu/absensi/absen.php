<?php
session_start();

include "../../conn/koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Absensi Siswa</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../../images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../fonts/icons-alipay.css ">
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
    <style>
        /* Custom styling */
        .wrap-qr {
            margin-top: 50px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            background-color: #fff;
        }

        .logo-qr img {
            width: 100%; /* Adjusted size for QR code */
            height: auto;
            margin: 0 auto;
        }

        .student-info {
            margin-top: 30px;
        }

        .info-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f5f5f5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-card h4 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .info-card p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .logo-qr img {
                width: 150px;
            }

            .info-card h4 {
                font-size: 16px;
            }

            .info-card p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div class="header">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-center align-items-center">
                <a href="home.php" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Absensi Siswa</h3>
            </div>
        </div>
    </div>

    <div class="wrap-qr">
        <div class="card">
            <div class="tf-container text-center">
                <h2 class="fw_6 text-center">Absensi dengan QR Code</h2>
                <div class="logo-qr">
                    <img src="../../images/scan-qr/codeqr.png" alt="QR Code">
                </div>
                <!-- Kalimat yang diminta -->
                <p class="text-center mt-3" style="font-size: 15px;"><em>Tunjukkan QR kepada petugas sekolah</em></p>

                <div class="student-info">
                    <div class="info-card">
                        <h4>Nama:</h4>
                        <p>John Doe</p>
                    </div>
                    <div class="info-card">
                        <h4>NISN:</h4>
                        <p>1234567890</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>
