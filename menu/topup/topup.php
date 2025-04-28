<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover" />
    <title>Topup</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../../images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="../../images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="../../fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../fonts/icons-alipay.css" />
    <link rel="stylesheet" href="../../styles/bootstrap.css" />
    <link rel="stylesheet" href="../../styles/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
    <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js" />
    <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        .list-wrapper {
            display: flex;
            gap: 10px;
        }

        .list-group {
            border-radius: 8px;
            background-color: #fff;
            /* Warna latar putih */
            padding: 20px;
        }

        .list-group-item {
            display: flex;
            align-items: center;
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .list-group-item.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .list-group-item i {
            margin-right: 10px;
            font-size: 18px;
            color: #007bff;
        }

        .list-group-item:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #f8f9fa;
        }

        .list-group-item.active i {
            color: #fff;
        }

        .list-group-item span {
            flex-grow: 1;
        }

        .card-murid {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #ffffff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 12px;
            border: 1px solid #ddd;
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }

        .card-murid:hover {
            background: #e0f7fa;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .avatar-murid {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>
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
                <a href="home.php" class="back-btn"><i class="icon-left white_color"></i></a>
                <h3 class="white_color">Top Up</h3>
            </div>
        </div>
    </div>
    <div class="card-secton topup-content">
        <div class="tf-container">
        </div>
        <div class="bottom-navigation-bar">

        </div>
    </div>

    <?php
    include "../../conn/koneksi.php"; // file koneksi database

    $username = $_SESSION['username'];

    // Ambil id_user dari tb_user
    $queryUser = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE username = '$username'");
    $dataUser = mysqli_fetch_assoc($queryUser);
    $id_user = $dataUser['id_user'];

    // Ambil id_ortu dari t_ortu
    $queryOrtu = mysqli_query($koneksi, "SELECT id_ortu FROM t_ortu WHERE id_user = '$id_user'");
    $dataOrtu = mysqli_fetch_assoc($queryOrtu);
    $id_ortu = $dataOrtu['id_ortu'];

    // Ambil murid dan kelas dari t_murid dan t_kelas
    $queryMurid = mysqli_query($koneksi, "
    SELECT t_murid.nm_murid, t_kelas.nm_kls, t_murid.id_mrd
    FROM t_murid
    JOIN t_klsmrd ON t_murid.id_mrd = t_klsmrd.id_mrd
    JOIN t_kelas ON t_klsmrd.id_kls = t_kelas.id_kls
    WHERE t_murid.id_ortu = '$id_ortu'
");
    ?>

    <div class="amount-money mt-9">
        <div class="tf-container">
            <h4 class="mb-4" style="color: #007bff;"><i class="fas fa-users"></i> Pilih Nama Siswa</h4>
            <div class="list-wrapper" style="width: 75%;">

                <?php while ($murid = mysqli_fetch_assoc($queryMurid)) { ?>
                    <a href="javascript:void(0)" class="card-murid" data-nama-murid="<?php echo addslashes($murid['nm_murid']); ?>" data-nama-kelas="<?php echo addslashes($murid['nm_kls']); ?>" data-id-mrd="<?php echo $murid['id_mrd']; ?>" onclick="konfirmasiTopup(this)">
                        <div class="avatar-murid"><?php echo strtoupper(substr($murid['nm_murid'], 0, 1)); ?></div>
                        <span><?php echo htmlspecialchars($murid['nm_murid']); ?> - <?php echo htmlspecialchars($murid['nm_kls']); ?></span>
                    </a>
                <?php } ?>

            </div>
        </div>
    </div>

    <!-- MODAL konfirmasi -->
    <div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Konfirmasi Top Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Nama murid akan diisi dengan JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="btnLanjutTopup" class="btn btn-primary">Lanjutkan</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiTopup(element) {
            // Mengambil data dari data-* attributes
            var namaMurid = element.getAttribute('data-nama-murid');
            var namaKelas = element.getAttribute('data-nama-kelas');
            var idMrd = element.getAttribute('data-id-mrd'); // Ambil id_mrd

            // Mengupdate konten modal dengan nama murid dan kelas
            document.getElementById('modalBody').innerHTML = `Anda akan melakukan top up saldo untuk <b>${namaMurid}</b> dari kelas <b>${namaKelas}</b>. Lanjutkan?`;

            // Mengatur link untuk melanjutkan top up menggunakan id_mrd sebagai parameter
            document.getElementById('btnLanjutTopup').href = "nom-topup.php?id_mrd=" + encodeURIComponent(idMrd);

            // Menampilkan modal menggunakan Bootstrap
            var myModal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
            myModal.show();
        }
    </script>

    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>