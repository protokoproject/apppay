<?php
include '../../conn/koneksi.php';
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['kd_sts_user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$kd_sts_user = $_SESSION['kd_sts_user'];

// Ambil nama dari tb_user
$query_user = "SELECT nm_user FROM tb_user WHERE username = ?";
$stmt_user = $koneksi->prepare($query_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();
$nama = $user_data['nm_user'] ?? 'Tidak Diketahui';

// Jika kd_sts_user = 7, ambil NISN dari t_murid
$nisn = "-";

if ($kd_sts_user == 7) {
    // Ambil id_user dari tb_user berdasarkan username
    $query_user = "SELECT id_user FROM tb_user WHERE username = ?";
    $stmt_user = $koneksi->prepare($query_user);

    if ($stmt_user) {
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user_data = $result_user->fetch_assoc();
        $stmt_user->close();

        if ($user_data) {
            $id_user = $user_data['id_user'];

            // Gunakan id_user untuk mencari nisn di t_murid
            $query_murid = "SELECT nisn FROM t_murid WHERE id_user = ?";
            $stmt_murid = $koneksi->prepare($query_murid);

            if ($stmt_murid) {
                $stmt_murid->bind_param("i", $id_user);
                $stmt_murid->execute();
                $result_murid = $stmt_murid->get_result();
                $murid_data = $result_murid->fetch_assoc();
                $stmt_murid->close();

                if ($murid_data) {
                    $nisn = $murid_data['nisn'];
                } else {
                    echo "<script>console.log('Data murid tidak ditemukan untuk id_user: " . $id_user . "');</script>";
                }
            } else {
                die("Query murid gagal: " . $koneksi->error);
            }
        } else {
            echo "<script>console.log('User tidak ditemukan dengan username: " . $username . "');</script>";
        }
    } else {
        die("Query user gagal: " . $koneksi->error);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Absensi Siswa</title>
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../../images/logo.png" />
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <link rel="stylesheet" href="../../fonts/icons-alipay.css ">
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="jsQR.js"></script>
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

        #scanButton {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
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

        #video {
            display: none;
            width: 100%;
            max-width: 400px;
        }

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
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
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
                <video id="video" autoplay playsinline></video>
                <canvas id="canvas" style="display: none;"></canvas>
                <button id="scanButton" class="btn btn-primary mt-3">Mulai Scan QR Code</button>
                <p id="qrResult" class="text-center mt-3" style="font-size: 15px;"><em>QR Code belum dipindai.</em></p>
                <div class="student-info">
                    <div class="info-card">
                        <h4>Nama:</h4>
                        <p><?php echo htmlspecialchars($nama); ?></p>
                    </div>
                    <div class="info-card">
                        <h4>NISN:</h4>
                        <p><?php echo htmlspecialchars($nisn); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const qrResult = $('#qrResult');
            const scanButton = $('#scanButton');
            let stream = null;
            let scanning = false;

            scanButton.click(function() {
                if (!scanning) {
                    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                        .then((mediaStream) => {
                            stream = mediaStream;
                            video.srcObject = stream;
                            video.style.display = 'block';
                            video.play();
                            scanning = true;
                            scanButton.text('Stop Scan QR Code');
                            requestAnimationFrame(scanQRCode);
                        })
                        .catch((err) => {
                            console.error("Error accessing camera: ", err);
                            qrResult.text("Gagal mengakses kamera. Periksa izin browser Anda.");
                        });
                } else {
                    stopScan();
                }
            });

            function scanQRCode() {
                if (!scanning) return;
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvas.height = video.videoHeight;
                    canvas.width = video.videoWidth;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: 'dontInvert',
                    });
                    if (code) {
                        qrResult.text('QR Code terdeteksi: ' + code.data);
                        $.ajax({
                            url: 'process_qr.php',
                            type: 'POST',
                            data: { qr_data: code.data },
                            success: function(response) {
                                alert('Absensi berhasil disimpan.');
                                stopScan();
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr, status, error);
                            }
                        });
                    }
                }
                requestAnimationFrame(scanQRCode);
            }

            function stopScan() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                video.style.display = 'none';
                scanning = false;
                scanButton.text('Mulai Scan QR Code');
            }
        });
    </script>

    
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>