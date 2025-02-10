<?php
session_start();

include "../../conn/koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

$sql = mysqli_query($koneksi, "SELECT nm_user, nohp, email FROM tb_user WHERE username = '{$_SESSION['username']}'");
$data = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Detail Profil</title>
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
</head>

<body> 
       <!-- preloade -->
       <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>
    <!-- /preload -->
    <div class="header header-st2">
        <div class="tf-container">
            <div class="tf-statusbar  br-none d-flex justify-content-between align-items-center">
                <a href="profil.php" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Profil Saya</h3>
                <a href="#" id="btn-popup-up"><i class="icon-more1"></i> </a>
            </div>
        </div>
    </div>
    <div class="mt-1">
       <div class="tf-container">
        <div class="box-user">
            <div class="inner d-flex flex-column align-items-center justify-content-center">
                <div class="box-avatar">
                    <img src="../../images/user/profile1.jpg" alt="image">
                    <span class="icon-camera-to-take-photos"></span>
                </div>
                <div class="info">
                    <h2 class="fw_8 mt-3 text-center"><?php echo $data['nm_user']; ?></h2>
                    <h6>@<?php echo $_SESSION["username"]; ?></h6>
                </div>
            </div>
            
              
        </div>
        <ul class="mt-7">
            <li class="list-user-info"><span class="icon-user"></span><a href="ubah-profil.php"><?php echo $data['nm_user']; ?></a></li>
            <li class="list-user-info"><span class="icon-phone"></span><?php echo $data['nohp']; ?></li>
            <li class="list-user-info"><span class="icon-email"></span><?php echo $data['email']; ?></li>
        </ul>
       </div>
     
    </div>
    <div class="tf-panel up">
        <div class="panel_overlay"></div>
          <div class="panel-box panel-up wrap-panel-clear panel-change-profile">
            <div class="heading">
                <a href="#">Show Profile Picture</a>
                <a href="#">New Photo Shoot</a>
                <a href="#">Select Photo Form Device</a>
                <a href="#">Choose An Existing Avatar</a>
            </div>
            <div class="bottom">
                <a class="clear-panel" href="#">Dismiss</a>
            </div>
          </div>
    </div>
  
    

    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>

</body>

</html>