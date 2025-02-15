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

// Proses penyimpanan data setelah scan QR Code
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qr_data'])) {
    $qr_data = $_POST['qr_data'];
    // Asumsikan qr_data berisi id_jadwal dan id_kls dipisahkan oleh tanda |
    list($id_jadwal, $id_kls) = explode('|', $qr_data);

    // Ambil id_mrd dari t_murid berdasarkan id_user
    $query_murid = "SELECT id_mrd FROM t_murid WHERE id_user = ?";
    $stmt_murid = $koneksi->prepare($query_murid);
    $stmt_murid->bind_param("i", $id_user);
    $stmt_murid->execute();
    $result_murid = $stmt_murid->get_result();
    $murid_data = $result_murid->fetch_assoc();
    $id_mrd = $murid_data['id_mrd'];

    // Generate id_absen secara otomatis
    $auto = mysqli_query($koneksi, "SELECT MAX(id_absen) as max_code FROM t_absen");
    $hasil = mysqli_fetch_array($auto);
    $code = $hasil['max_code'];
    $id_absen = ($code) ? (int)$code + 1 : 1;

    // Tanggal dan waktu saat ini
    $tgl_abs = date('Y-m-d');
    $jam_abs = date('H:i:s');

    // Insert data ke t_absen
    $query_insert = "INSERT INTO t_absen (id_absen, id_mrd, id_jadwal, id_kls, tgl_abs, jam_abs, ket_abs) VALUES (?, ?, ?, ?, ?, ?, NULL)";
    $stmt_insert = $koneksi->prepare($query_insert);
    $stmt_insert->bind_param("iiisss", $id_absen, $id_mrd, $id_jadwal, $id_kls, $tgl_abs, $jam_abs);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Absensi berhasil disimpan.');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan absensi.');</script>";
    }
    $stmt_insert->close();
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

                <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>

                <div class="logo-qr">
                    <button id="scanButton" class="btn btn-primary">
                        <i class="fas fa-qrcode"></i> Scan QR Code
                    </button>
                </div>

                <p class="text-center mt-3" style="font-size: 15px;">
                    <em>Klik tombol di atas untuk memindai QR Code</em>
                </p>

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
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('scanButton').addEventListener('click', function() {
                let scanner = new Html5QrcodeScanner("reader", {
                    fps: 10,
                    qrbox: 250
                });
                scanner.render(
                    function(qrCodeMessage) {
                        console.log(`QR Code detected: ${qrCodeMessage}`);

                        // Kirim data hasil scan ke server
                        fetch(window.location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `qr_data=${encodeURIComponent(qrCodeMessage)}`
                        }).then(response => {
                            if (response.ok) {
                                alert('Absensi berhasil disimpan.');
                                location.reload();
                            } else {
                                alert('Gagal menyimpan absensi.');
                            }
                        });
                    },
                    function(errorMessage) {
                        console.warn(`QR Code scan error: ${errorMessage}`);
                    }
                );
            });
        });
    </script>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>