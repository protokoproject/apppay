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
                <a href="#" class="back-btn"><i class="icon-left white_color"></i></a>
                <h3 class="white_color">Transfer</h3>
            </div>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center">
                    <p>Your Balance:</p>
                    <h3>$3.466,9</h3>
                </div>
                <div class="tf-spacing-16"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="inner-left d-flex justify-content-between align-items-center">
                        <img src="images/user/user15.jpg" alt="images">
                        <p class="fw_7 on_surface_color">Themesflat</p>
                    </div>
                    <i class="icon-down on_surface_color"></i>
                </div>
            </div>
           
        </div>
    </div>
    <div class="tf-spacing-20"></div>
    <div class="transfer-content">
            <form class="tf-form">
                <div class="tf-container">

                    <div class="group-input input-field input-money">
                    <label for="">Amout Of Money</label>
                    <input type="text" value="$ 5" required class="search-field value_input st1" type="text">
                    <span class="icon-clear"></span>
                    <div class="money">
                       <a class="tag-money" href="#">$ 50</a>
                       <a class="tag-money" href="#">$ 100</a> 
                       <a class="tag-money" href="#">$ 150</a> 
                    </div>
                    </div>
                    <div class="group-input">
                    <label>Message</label>
                    <input type="text" placeholder="Placeholder">
                    </div>
                </div>

                <div class="bottom-navigation-bar bottom-btn-fixed">
                    <div class="tf-container">
                        <a href="18_payment-source.html" class="tf-btn accent large">Continue</a>
                    </div>
                </div>
            </form>
        
      
    </div>
  
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
    <script type="text/javascript" src="../../javascript/init.js"></script>
    
</body>

</html>