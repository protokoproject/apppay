<?php
include '../../conn/koneksi.php';

// Ambil ID event dari parameter GET
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query untuk mendapatkan data event berdasarkan ID
    $query = "SELECT * FROM tb_events WHERE id_event = '$id'";
    $result = mysqli_query($koneksi, $query);
    $event = mysqli_fetch_assoc($result);

    if (!$event) {
        echo "<script>alert('Event tidak ditemukan!'); window.location.href = 'event.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href = 'event.php';</script>";
    exit;
}

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $start_date = mysqli_real_escape_string($koneksi, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($koneksi, $_POST['end_date']);

    // Validasi input
    if (empty($title) || empty($start_date) || empty($end_date)) {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
        exit;
    }

    // Query untuk memperbarui data event
    $sql = "UPDATE tb_events SET title = '$title', start_date = '$start_date', end_date = '$end_date' WHERE id = '$id'";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
            alert('Event berhasil diperbarui!');
            window.location.href = 'event.php';
        </script>";
    } else {
        $error_message = addslashes(mysqli_error($koneksi));
        echo "<script>
            alert('Terjadi kesalahan saat memperbarui data: $error_message');
            window.history.back();
        </script>";
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
    <title>Edit Event</title>
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
                <h3>Edit Event</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="box-components mt-4">
                    <form method="post">
                        <div class="group-input">
                            <label>Judul Event</label>
                            <input type="text" placeholder="Judul Event" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                        </div>
                        <div class="group-input">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" value="<?php echo htmlspecialchars($event['start_date']); ?>" required>
                        </div>
                        <div class="group-input">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" value="<?php echo htmlspecialchars($event['end_date']); ?>" required>
                        </div>
                        <button type="submit" class="mb-3 tf-btn accent small" style="width: 20%;" name="simpan">Tambah Data</button>
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