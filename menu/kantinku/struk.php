<?php
// Include file koneksi.php
require_once '../../conn/koneksi.php';

// Ambil id_jual dari URL
$id_jual = isset($_GET['id_jual']) ? $_GET['id_jual'] : null;

if (!$id_jual) {
    die("ID Jual tidak ditemukan!");
}

// Query untuk mengambil data dari t_jual, t_jualdtl, t_murid, t_kantin, dan t_brg
$sql = "
    SELECT 
        j.nt_jual, 
        j.tgl_jual, 
        m.nm_murid, 
        k.nm_kantin, 
        b.nm_brg, 
        jd.qty,
        jd.hrgj
    FROM 
        t_jual j
    JOIN 
        t_murid m ON j.id_user = m.id_user
    JOIN 
        t_kantin k ON j.id_kantin = k.id_kantin
    JOIN 
        t_jualdtl jd ON j.id_jual = jd.id_jual
    JOIN 
        t_brg b ON jd.kd_brg = b.kd_brg
    WHERE 
        j.id_jual = ?
";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_jual);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$items = [];
$total = 0; // Inisialisasi total harga

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Hitung total harga berdasarkan hrgj dan qty
        $total += intval($row['hrgj']) * intval($row['qty']);

        // Simpan data lainnya
        $data['nt_jual'] = $row['nt_jual'];
        $data['tgl_jual'] = $row['tgl_jual'];
        $data['nm_murid'] = $row['nm_murid'];
        $data['nm_kantin'] = $row['nm_kantin'];
        $items[] = [
            'nm_brg' => $row['nm_brg'],
            'qty' => $row['qty'],
            'hrgj' => $row['hrgj']
        ];
    }
    $data['items'] = $items;
    $data['total'] = $total; // Simpan total harga
} else {
    die("Data tidak ditemukan untuk ID Jual ini.");
}

$stmt->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Struk Pembayaran</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../../images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../fonts/icons-alipay.css">
    <link rel="stylesheet" href="../../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg_surface_color">
    <!-- preloade -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div class="app-header st1">
        <div class="tf-container">
            <div class="tf-topbar d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left white_color"></i></a>
                <h3 class="white_color">Struk Pembayaran</h3>
            </div>
            <h4 class="text-center white_color fw_4 mt-5">Total</h4>
            <h1 class="text-center white_color mt-2">Rp. <?= number_format($data['total'], 0, ',', '.') ?>,-</h1>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box transfer-confirm" style="height: 100%;">
                <div class="top">
                    <p>From</p>
                    <div class="tf-card-block d-flex align-items-center" style="gap: 1px;">
                        <div class="logo-img">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div class="info">
                            <h4><a href="#"><?= $data['nm_murid'] ?></a></h4>
                            <p>**** **** **** 4234</p>
                        </div>
                    </div>
                </div>
                <div class="line"></div>
                <div class="bottom">
                    <p>To</p>
                    <div class="tf-card-block d-flex align-items-center" style="gap: 3%;">
                        <i class="fa-solid fa-store fa-2x"></i> <!-- Ikon Font Awesome -->
                        <div class="info">
                            <h4><a href="#"><?= $data['nm_kantin'] ?></a></h4>
                            <p>**** **** **** 2424</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="transfer-list mt-5">
        <div class="tf-container">
            <ul class="list-view">
                <li>
                    Nomor Transaksi
                    <span><?= $data['nt_jual'] ?></span>
                </li>
                <li>
                    Pesanan
                    <span><?= implode("<br>", array_map(function ($item) {
                                return "{$item['qty']}x {$item['nm_brg']} (Rp. " . number_format($item['hrgj'], 0, ',', '.') . ")";
                            }, $data['items'])) ?></span>
                </li>
                <li>
                    Tanggal
                    <span><?= $data['tgl_jual'] ?></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="bottom-navigation-bar st1 bottom-btn-fixed">
        <div class="tf-container">
            <a href="../../home.php" class="tf-btn accent large">Kembali </a>
        </div>
    </div>

    <div class="tf-panel down">
        <div class="panel_overlay"></div>
        <div class="panel-box panel-down">
            <div class="header">
                <div class="tf-container">
                    <div class="tf-statusbar br-none d-flex justify-content-center align-items-center">
                        <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                        <h3>Verification OTP</h3>
                    </div>

                </div>
            </div>

            <div class="mt-5">
                <div class="tf-container">
                    <form class="tf-form tf-form-verify" action="22_successful.html">
                        <div class="d-flex group-input-verify">
                            <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify" value="1">
                            <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify" value="2">
                            <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify" value="3">
                            <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify" value="4">
                        </div>
                        <div class="text-send-code">
                            <p class="fw_4">A code has been sent to your phone</p>
                            <p class="primary_color fw_7">Resend in&nbsp;<span class="js-countdown" data-timer="60" data-labels=" :  ,  : , : , "></span></p>
                        </div>
                        <div class="mt-7 mb-6">
                            <button type="submit" class="tf-btn accent large">Continue</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/count-down.js"></script>
    <script type="text/javascript" src="../../javascript/verify-input.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
    <script type="text/javascript" src="../../javascript/init.js"></script>


</body>

</html>