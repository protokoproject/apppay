<?php
require "conn/koneksi.php";
require "function.php";

$sql = mysqli_query($koneksi, "SELECT * FROM tb_app INNER JOIN tb_user ON tb_app.id_app = tb_user.id_app");
$data = mysqli_fetch_array($sql);

if (isset($_POST['buat_akun'])) {
    $registrasi_result = registrasi($_POST);

    if ($registrasi_result > 0) {
        echo "<script>
                alert('User berhasil ditambahkan');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan user');</script>";
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
    <title>SIMAS | Daftar</title>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="images/logo.png" />
    <link rel="apple-touch-icon-precomposed" href="images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="fonts/icons-alipay.css">
    <link rel="stylesheet" href="styles/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="192x192" href="app/icons/icon-192x192.png">

</head>

<body>
    <!-- preloade -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div class="header">
        <div class="tf-container">
            <div class="tf-statusbar br-none d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            </div>
        </div>
    </div>
    <div class="mt-3 register-section">
        <div class="tf-container">
            <form class="tf-form" method="post">
                <h1>Daftar</h1>
                <div class="group-input">
                    <label>Nama Sekolah</label>
                    <input type="text" name="nm_sekolah">
                </div>
                <div class="group-input">
                    <label>Alamat</label>
                    <input type="text" name="alamat">
                </div>
                <div class="group-input">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="group-input">
                    <label>Telepon</label>
                    <input type="number" name="telepon">
                </div>
                <div class="group-input">
                    <label>Password</label>
                    <input type="password" name="password">
                </div>
                <div class="group-input auth-pass-input last">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="password-input" name="password2">
                    <a class="icon-eye password-addon" id="password-addon"></a>
                </div>
                <div class="group-cb mt-5">

                    <input type="checkbox" checked class="tf-checkbox">
                    <label class="fw_3">Saya Menyetujui <a>Syarat dan Ketentuan yang berlaku</a> </label>
                </div>
                <button type="submit" class="tf-btn accent large" name="buat_akun">Buat Akun</button>

            </form>

        </div>
    </div>





    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/password-addon.js"></script>
    <script type="text/javascript" src="javascript/main.js"></script>
    <script type="text/javascript" src="javascript/init.js"></script>


</body>

</html>