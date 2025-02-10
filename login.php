<?php
session_start();

require "conn/koneksi.php";

if (isset($_POST["login"])) {
  $identifier = $_POST["identifier"];
  $password = $_POST["password"];

  // Query untuk mencari user berdasarkan email atau username
  $result = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE email = '$identifier' OR username = '$identifier'");

  // Cek apakah user ditemukan
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    // Cek password
    if (password_verify($password, $row["pass"])) {
      // Set session
      $_SESSION["login"] = true;
      $_SESSION["username"] = $row["username"];
      $_SESSION["kd_sts_user"] = $row["kd_sts_user"];
      
      header("Location: home.php");
      exit;
    } else {
      echo "<script>alert('Username, Email atau Password salah');</script>";
      header("refresh:0;url=login.php");
      exit;
    }
  } else {
    echo "<script>alert('Username, Email atau Password salah');</script>";
    header("refresh:0;url=login.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
  <title>SIMAS | Masuk</title>
  <link rel="shortcut icon" href="images/logo.png" />
  <link rel="apple-touch-icon-precomposed" href="images/logo.png" />
  <link rel="stylesheet" href="fonts/fonts.css" />
  <link rel="stylesheet" href="fonts/icons-alipay.css">
  <link rel="stylesheet" href="styles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="styles/styles.css" />
  <link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
  <link rel="apple-touch-icon" sizes="192x192" href="app/icons/icon-192x192.png">
</head>

<body>
  <div class="preload preload-container">
    <div class="preload-logo">
      <div class="spinner"></div>
    </div>
  </div>
  <div class="mt-7 login-section">
    <div class="tf-container">
      <form class="tf-form" method="post">
        <h1>Masuk</h1>
        <div class="group-input">
          <label>Username atau Email</label>
          <input type="text" placeholder="Masukkan Username atau Email" name="identifier" required>
        </div>
        <div class="group-input auth-pass-input last">
          <label>Password</label>
          <input type="password" class="password-input" placeholder="Password" name="password" required>
          <a class="icon-eye password-addon" id="password-addon"></a>
        </div>
        <a href="08_reset-password.html" class="auth-forgot-password mt-3">Lupa Password?</a>
        <button type="submit" class="tf-btn accent large" name="login">Masuk</button>
      </form>
      <div class="auth-line">Atau</div>
      <ul class="bottom socials-login mb-4">
        <li><a href=""><img src="images/icon-socials/google.png" alt="image">Lanjutkan dengan Google</a></li>
      </ul>
      <p class="mb-9 fw-3 text-center">Belum Memiliki Akun? <a href="register.php" class="auth-link-rg">Daftar</a></p>
    </div>
  </div>

  <script type="text/javascript" src="javascript/jquery.min.js"></script>
  <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
  <script type="text/javascript" src="javascript/password-addon.js"></script>
  <script type="text/javascript" src="javascript/main.js"></script>
  <script type="text/javascript" src="javascript/init.js"></script>
</body>
</html>
