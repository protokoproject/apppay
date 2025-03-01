<?php
include "../../conn/koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID murid tidak ditemukan!'); window.location.href='murid.php';</script>";
    exit;
}

$id_mrd = $_GET['id'];

// Ambil data murid berdasarkan id_mrd
$queryMurid = mysqli_query($koneksi, "SELECT t_murid.*, tb_user.id_user, tb_user.username, t_ortu.nm_ortu 
    FROM t_murid 
    JOIN tb_user ON t_murid.id_user = tb_user.id_user 
    LEFT JOIN t_ortu ON t_murid.id_ortu = t_ortu.id_ortu 
    WHERE t_murid.id_mrd = '$id_mrd'");

$dataMurid = mysqli_fetch_assoc($queryMurid);

if (!$dataMurid) {
    echo "<script>alert('Data murid tidak ditemukan!'); window.location.href='murid.php';</script>";
    exit;
}

$id_user = $dataMurid['id_user'];
$nmmurid = $dataMurid['nm_murid'];
$nisn = $dataMurid['nisn'];
$saldo = $dataMurid['saldo'];
$kls_aktif = $dataMurid['kls_aktif'];
$id_ortu = $dataMurid['id_ortu'];

// Ambil daftar kelas dan orang tua
$queryKelas = mysqli_query($koneksi, "SELECT id_kls, nm_kls FROM t_kelas");
$queryOrtu = mysqli_query($koneksi, "SELECT id_ortu, nm_ortu FROM t_ortu");

if (isset($_POST['update'])) {
    $nmmurid = isset($_POST['nmmurid']) ? trim($_POST['nmmurid']) : '';
    $nisn = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';
    $saldo = isset($_POST['saldo']) ? trim($_POST['saldo']) : ''; // Bisa angka 0
    $kls_aktif = isset($_POST['kls_aktif']) ? trim($_POST['kls_aktif']) : '';
    $id_ortu = isset($_POST['id_ortu']) ? trim($_POST['id_ortu']) : '';
    $tgl_rilis = date("Y-m-d");

    // Validasi: Pastikan semua field diisi dengan benar
    if (
        empty($nmmurid) || empty($nisn) ||
        empty($kls_aktif) || empty($id_ortu) ||
        !isset($_POST['saldo']) || !is_numeric($saldo) || $saldo < 0
    ) {
        echo "<script>alert('Semua field harus diisi dengan benar! Saldo tidak boleh negatif atau kosong.'); window.history.back();</script>";
        exit;
    }

    // Ambil id_app berdasarkan session username
    $username_session = $_SESSION['username'];
    $queryApp = mysqli_query($koneksi, "SELECT id_app FROM tb_user WHERE username = '$username_session'");
    $rowApp = mysqli_fetch_assoc($queryApp);
    if (!$rowApp) {
        echo "<script>alert('Gagal mengambil data aplikasi!'); window.history.back();</script>";
        exit;
    }
    $id_app = $rowApp['id_app'];

    // Buat username baru
    $nama_parts = explode(" ", $nmmurid);
    $username = strtolower($nama_parts[0]) . $id_mrd . $id_app;

    // Update data tb_user
    $queryUser = mysqli_query($koneksi, "UPDATE tb_user SET nm_user = '$nmmurid', username = '$username', tgl_gbng = '$tgl_rilis' WHERE id_user = '$id_user'");

    if ($queryUser) {
        $queryMurid = mysqli_query($koneksi, "UPDATE t_murid SET nm_murid = '$nmmurid', nisn = '$nisn', saldo = '$saldo', kls_aktif = '$kls_aktif', id_ortu = '$id_ortu' WHERE id_mrd = '$id_mrd'");

        if ($queryMurid) {
            // Cek apakah murid sudah ada di t_klsmrd
            $cekKlsMrd = mysqli_query($koneksi, "SELECT * FROM t_klsmrd WHERE id_mrd = '$id_mrd'");

            if (mysqli_num_rows($cekKlsMrd) > 0) {
                $queryKlsMrd = mysqli_query($koneksi, "UPDATE t_klsmrd SET id_kls = '$kls_aktif' WHERE id_mrd = '$id_mrd'");
            } else {
                $queryKlsMrd = mysqli_query($koneksi, "INSERT INTO t_klsmrd (id_kls, id_mrd) VALUES ('$kls_aktif', '$id_mrd')");
            }

            if ($queryKlsMrd) {
                echo "<script>alert('Data murid berhasil diperbarui!'); window.location.href='murid.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui kelas di t_klsmrd: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Gagal memperbarui data di t_murid: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal memperbarui data di tb_user: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
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
    <title>Edit Murid</title>
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
                <h3>Edit Murid</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input mb-3">
                            <label for="nm_mrd" class="form-label">Nama Murid</label>
                            <input type="text" class="form-control" id="nmmurid" name="nmmurid" value="<?php echo $nmmurid; ?>" required>
                        </div>
                        <div class="group-input mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="number" class="form-control" id="nisn" name="nisn" value="<?php echo $nisn; ?>" required>
                        </div>
                        <div class="group-input">
                            <label for="nm_ortu">Nama Orang Tua</label>
                            <select name="id_ortu" id="id_ortu" class="form-control" required>
                                <option value="" disabled>Pilih Nama Orang Tua</option>
                                <?php while ($ortu = mysqli_fetch_assoc($queryOrtu)) {
                                    echo "<option value='{$ortu['id_ortu']}' " . ($ortu['id_ortu'] == $id_ortu ? 'selected' : '') . ">{$ortu['nm_ortu']}</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="group-input">
                            <label for="kls_aktif">Kelas</label>
                            <select name="kls_aktif" id="kls_aktif" class="form-control" required>
                                <option value="" disabled>Pilih Kelas</option>
                                <?php while ($kelas = mysqli_fetch_assoc($queryKelas)) {
                                    echo "<option value='{$kelas['id_kls']}' " . ($kelas['id_kls'] == $kls_aktif ? 'selected' : '') . ">{$kelas['nm_kls']}</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="group-input mb-3">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="number" class="form-control" id="saldo" name="saldo" value="<?php echo $saldo; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary tf-btn accent small" style="width: 20%;" name="update">Simpan</button>
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