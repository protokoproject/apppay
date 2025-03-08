<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Kantinku</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg_surface_color">
    <!-- preloade -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div class="header bg_white_color is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Pilih Kantin</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="mt-3">
            <div class="tf-container">
                <div class="input-field box-card-search">
                    <span class="icon-search"></span>
                    <input required class="search-field value_input" type="text">
                    <span class="icon-clear"></span>
                </div>
            </div>

        </div>
        <?php
        session_start();
        include '../../conn/koneksi.php'; // Pastikan koneksi database sudah disiapkan

        // Ambil username dari session
        $username = $_SESSION['username'];

        // Dapatkan id_app berdasarkan username dari tb_user
        $query_user = "SELECT id_app FROM tb_user WHERE username = '$username'";
        $result_user = mysqli_query($koneksi, $query_user);
        $row_user = mysqli_fetch_assoc($result_user);
        $id_app = $row_user['id_app'];

        // Ambil semua kantin yang sesuai dengan id_app dari tb_user
        $query_kantin = "SELECT id_kantin, nm_kantin FROM t_kantin WHERE id_user IN (SELECT id_user FROM tb_user WHERE id_app = '$id_app')";
        $result_kantin = mysqli_query($koneksi, $query_kantin);

        // Hitung jumlah kantin
        $total_kantin = mysqli_num_rows($result_kantin);
        ?>

        <div class="wrap-banks mt-5">
            <div class="tf-container">
                <h3 class="fw_6">Semua Kantin (<?= $total_kantin; ?>)</h3>
                <div class="tf-spacing-12"></div>
                <div class="bank-list-transfer-container" style="max-height: 300px; overflow-y: auto;">
                    <ul class="bank-list-transfer">
                        <?php while ($row_kantin = mysqli_fetch_assoc($result_kantin)) { ?>
                            <li>
                                <a href="kantin.php?kantin_id=<?= $row_kantin['id_kantin']; ?>">
                                    <i class="fas fa-store"></i> <!-- Menggunakan ikon untuk kantin -->
                                    <?= htmlspecialchars($row_kantin['nm_kantin']); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>



    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>

</body>

</html>