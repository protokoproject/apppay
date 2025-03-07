<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Struk</title>
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
    <div class="app-header st1">
        <div class="tf-container">
            <div class="tf-topbar d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left white_color"></i></a>
                <h3 class="white_color">Struk</h3>
            </div>
            <h4 class="text-center white_color fw_4 mt-5">Transfer amount</h4>
            <h1 class="text-center white_color mt-2">$  1200.0</h1>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box transfer-confirm">
                <div class="top">
                    <p>From</p>
                    <div class="tf-card-block d-flex align-items-center">
                        <div class="../../logo-img">
                            <img src="../../images/logo-banks/card-visa2.png" alt="images">
                        </div>
                        <div class="info">
                            <h4><a href="#">Visacard</a></h4>
                            <p>****  ****  ****  4234</p>
                        </div>
                    </div>
                </div>
                <div class="line"></div>
                <div class="bottom">
                    <p>To</p>
                    <div class="tf-card-block d-flex align-items-center">
                        <img src="../../images/user/user15.jpg" alt="images">
                        <div class="info">
                            <h4><a href="#">Themesflat</a></h4>
                            <p>****  ****  ****  2424</p>
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
                    Transaction fee
                    <span>Free</span>
                </li>
                <li>
                   Amount in words 
                    <span>One thousand two <br> hundred dollars</span>
                </li>
                <li>
                    Transfer form 
                    <span>In wallet</span>
                </li>
                <li>
                    Message
                    <span>Marverick Nguyen <br> send loan payment</span>
                </li>
    
            </ul>
       
            
        </div>
    </div>
    <div class="bottom-navigation-bar st1 bottom-btn-fixed">
        <div class="tf-container">
            <a href="#" id="btn-popup-down" class="tf-btn accent large">Confirm</a>
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