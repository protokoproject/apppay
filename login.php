<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>SIMAS | Masuk</title>
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
    <div class="mt-7 login-section">
        <div class="tf-container">
            <form class="tf-form" action="home.html">
                    <h1>Masuk</h1>
                    <div class="group-input">
                        <label>Email</label>
                        <input type="text" placeholder="simas@gmail.com">
                    </div>
                    <div class="group-input auth-pass-input last">
                        <label>Password</label>
                        <input type="password" class="password-input" placeholder="Password">
                        <a class="icon-eye password-addon" id="password-addon"></a>
                    </div>
                    <a href="08_reset-password.html" class="auth-forgot-password mt-3">Lupa Password?</a>

                <button type="submit" class="tf-btn accent large">Masuk</button>

            </form>
            <div class="auth-line">Atau</div>
            <ul class="bottom socials-login mb-4">
                <li><a href=""><img src="images/icon-socials/google.png" alt="image">Lanjutkan dengan Google</a></li>
            </ul>
            <p class="mb-9 fw-3 text-center ">Belum Memiliki Akun? <a href="register.php" class="auth-link-rg" >Daftar</a></p>
        </div>
    </div>
    
  



    <script type="text/javascript" src="javascript/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/password-addon.js"></script>
    <script type="text/javascript" src="javascript/main.js"></script>
    <script type="text/javascript" src="javascript/init.js"></script>


</body>

</html>