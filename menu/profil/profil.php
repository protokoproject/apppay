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
    <title>Profil Saya</title>
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
</head>

<body class="bg_surface_color">
     <!-- preloade -->
     <div class="preload preload-container">
        <div class="preload-logo">
          <div class="spinner"></div>
        </div>
      </div>
    <!-- /preload -->
    <div class="header mb-1 is-fixed">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-center align-items-center">
                <a href="../../home.php" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Profil Saya</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <a class="box-profile mt-1" href="profil-detail.php">
            <div class="inner d-flex align-items-center">
                <div class="box-avatar">
                    <img src="../../images/user/profile1.jpg" alt="image">
                    <span class="icon-camera-to-take-photos"></span>
                </div>
                <div class="info">
                    <h2 class="fw_8"><?php echo $data["nm_user"]; ?></h2>
                    <h6>@<?php echo $_SESSION["username"]; ?></h6>
                </div>
            </div>

            <span><i class="icon-right"></i></span>
                      
        </a>  
        <a class="list-profile mt-1" href="40_qr-code.html">
            <i class="icon-scan-qr-code"></i>
            <p>QR Code</p>
            <span ><i class="icon-right"></i></span>
        </a>
        <ul class="mt-1">
            <li>
                <a href="58_history.html" class="list-profile outline">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.625 12V15.375C23.6244 15.5737 23.5452 15.7642 23.4047 15.9047C23.2642 16.0452 23.0737 16.1244 22.875 16.125H17.625C17.4263 16.1244 17.2358 16.0452 17.0953 15.9047C16.9548 15.7642 16.8756 15.5737 16.875 15.375V13.125C16.8756 12.9263 16.9548 12.7358 17.0953 12.5953C17.2358 12.4548 17.4263 12.3756 17.625 12.375H22.125V11.25H22.875C23.0737 11.2506 23.2642 11.3298 23.4047 11.4703C23.5452 11.6108 23.6244 11.8013 23.625 12ZM19.5 14.25C19.5 14.1017 19.456 13.9567 19.3736 13.8333C19.2912 13.71 19.1741 13.6139 19.037 13.5571C18.9 13.5003 18.7492 13.4855 18.6037 13.5144C18.4582 13.5433 18.3246 13.6148 18.2197 13.7197C18.1148 13.8246 18.0433 13.9582 18.0144 14.1037C17.9855 14.2492 18.0003 14.4 18.0571 14.537C18.1139 14.6741 18.21 14.7912 18.3333 14.8736C18.4567 14.956 18.6017 15 18.75 15C18.9487 14.9994 19.1392 14.9202 19.2797 14.7797C19.4202 14.6392 19.4994 14.4487 19.5 14.25Z" fill="#E03E3E"/>
                        <path d="M20.49 0.375L23.625 9.2925L22.125 9.82875V7.5C22.1244 7.30127 22.0452 7.11085 21.9047 6.97033C21.7642 6.8298 21.5737 6.75059 21.375 6.75H20.7562L19.6987 3.7425C19.5193 3.80644 19.329 3.83425 19.1387 3.82433C18.9485 3.81441 18.7621 3.76696 18.5902 3.6847C18.4184 3.60245 18.2645 3.48701 18.1375 3.34504C18.0104 3.20308 17.9127 3.03738 17.85 2.8575L6.93 6.735V6.75H3.75C3.65704 6.75012 3.56423 6.74259 3.4725 6.7275L3.375 6.4575L16.14 1.92L20.49 0.375Z" fill="#36CE94"/>
                        <path d="M1.9125 5.23875C1.98704 5.61758 2.17701 5.96406 2.45632 6.23061C2.73563 6.49717 3.0906 6.67074 3.4725 6.7275C3.56423 6.74259 3.65704 6.75012 3.75 6.75H21.375C21.5737 6.7506 21.7642 6.82981 21.9047 6.97033C22.0452 7.11085 22.1244 7.30127 22.125 7.5V12.375H17.625C17.4263 12.3756 17.2358 12.4548 17.0953 12.5953C16.9548 12.7359 16.8756 12.9263 16.875 13.125V15.375C16.8756 15.5737 16.9548 15.7642 17.0953 15.9047C17.2358 16.0452 17.4263 16.1244 17.625 16.125H22.125V20.25C22.125 20.7038 21.4538 21.375 20.625 21.375H15.375V15.375C15.3744 15.1763 15.2952 14.9859 15.1547 14.8453C15.0142 14.7048 14.8237 14.6256 14.625 14.625H2.625C2.42627 14.6256 2.23585 14.7048 2.09533 14.8453C1.9548 14.9859 1.87559 15.1763 1.875 15.375V21.375C1.47718 21.375 1.09564 21.217 0.81434 20.9357C0.533035 20.6544 0.375 20.2728 0.375 19.875V5.25C0.375 4.65327 0.612053 4.08097 1.03401 3.65901C1.45597 3.23706 2.02826 3 2.625 3H3.82875C3.35291 2.99238 2.89102 3.16082 2.5318 3.47298C2.17257 3.78513 1.94134 4.219 1.8825 4.69125C1.86398 4.8742 1.8741 5.05892 1.9125 5.23875Z" fill="#FEBD55"/>
                        <path d="M19.6987 3.74254L20.7562 6.75004H6.92993V6.73504L17.8499 2.85754C17.9127 3.03743 18.0104 3.20312 18.1374 3.34509C18.2644 3.48705 18.4183 3.60249 18.5901 3.68475C18.762 3.767 18.9484 3.81446 19.1386 3.82438C19.3289 3.8343 19.5192 3.80649 19.6987 3.74254Z" fill="#2FB380"/>
                        <path d="M18.75 15C19.1642 15 19.5 14.6642 19.5 14.25C19.5 13.8358 19.1642 13.5 18.75 13.5C18.3358 13.5 18 13.8358 18 14.25C18 14.6642 18.3358 15 18.75 15Z" fill="#2B2B37"/>
                        <path d="M8.1076 3L15.3751 0.375L16.1251 1.875L16.1401 1.92L3.3751 6.4575L3.4726 6.7275C3.0907 6.67074 2.73573 6.49717 2.45642 6.23061C2.1771 5.96405 1.98714 5.61758 1.9126 5.23875L8.1076 3Z" fill="#2FB380"/>
                        <path d="M8.10753 3L1.91253 5.23875C1.87413 5.05892 1.86401 4.8742 1.88253 4.69125C1.94137 4.219 2.1726 3.78513 2.53182 3.47298C2.89105 3.16082 3.35293 2.99238 3.82878 3H8.10753Z" fill="#BD6F08"/>
                        <path d="M15.375 21.375V22.875C15.3744 23.0737 15.2952 23.2642 15.1547 23.4047C15.0142 23.5452 14.8237 23.6244 14.625 23.625H2.625C2.42627 23.6244 2.23585 23.5452 2.09533 23.4047C1.9548 23.2642 1.87559 23.0737 1.875 22.875V18H15.375V21.375Z" fill="#FF6161"/>
                        <path d="M15.375 16.875V18H15H2.25H1.875V16.875H2.25H15H15.375Z" fill="#EDF4FA"/>
                        <path d="M15.375 15.375V16.875H1.875V15.375C1.87559 15.1763 1.9548 14.9858 2.09533 14.8453C2.23585 14.7048 2.42627 14.6256 2.625 14.625H14.625C14.8237 14.6256 15.0142 14.7048 15.1547 14.8453C15.2952 14.9858 15.3744 15.1763 15.375 15.375Z" fill="#CB3541"/>
                        <path d="M14.625 22.5H10.5C9.10509 22.4992 7.74474 22.066 6.60617 21.2601C5.46761 20.4542 4.60681 19.3153 4.14225 18H1.875V22.875C1.87559 23.0737 1.9548 23.2642 2.09533 23.4047C2.23585 23.5452 2.42627 23.6244 2.625 23.625H14.625C14.8237 23.6244 15.0142 23.5452 15.1547 23.4047C15.2952 23.2642 15.3744 23.0737 15.375 22.875V21.75C15.375 21.9489 15.296 22.1397 15.1553 22.2803C15.0147 22.421 14.8239 22.5 14.625 22.5Z" fill="#E03E3E"/>
                        <path d="M4.14225 18C4.01286 17.6341 3.9155 17.2577 3.85125 16.875H1.875V18H4.14225Z" fill="#C1CFE8"/>
                        <path d="M3.85125 16.875C3.78628 16.5035 3.75242 16.1272 3.75 15.75V14.625H2.625C2.42627 14.6256 2.23585 14.7048 2.09533 14.8453C1.9548 14.9858 1.87559 15.1763 1.875 15.375V16.875H3.85125Z" fill="#A81E29"/>
                        <path d="M16.1251 1.87499L15.8206 1.26599L4.43185 5.37862C4.24893 5.44466 4.04752 5.43707 3.8701 5.35745C3.69267 5.27783 3.55311 5.13241 3.48085 4.95187L3.38297 4.70737L1.9126 5.23874C1.98714 5.61757 2.1771 5.96404 2.45642 6.2306C2.73573 6.49716 3.0907 6.67073 3.4726 6.72749L3.3751 6.45749L16.1401 1.91999L16.1251 1.87499Z" fill="#2AA173"/>
                        <path d="M10.056 5.625H5.71688L3.375 6.4575L3.4725 6.7275C3.56423 6.74259 3.65704 6.75012 3.75 6.75H6.93V6.735L10.056 5.625Z" fill="#2FB380"/>
                        <path d="M23.625 9.2925L22.3358 5.625H20.3625L20.7582 6.75H21.375C21.5738 6.75059 21.7642 6.8298 21.9047 6.97033C22.0452 7.11085 22.1245 7.30127 22.125 7.5V9.82875L23.625 9.2925Z" fill="#2FB380"/>
                        <path d="M10.0559 5.625L6.92993 6.735V6.75H20.7562L20.3606 5.625H10.0559Z" fill="#2AA173"/>
                        <path d="M23.25 15.375H19.5C19.3406 15.3746 19.183 15.3401 19.038 15.2738C18.893 15.2075 18.7639 15.111 18.6592 14.9906C18.4775 14.9697 18.3097 14.8827 18.1879 14.7461C18.0662 14.6096 17.9989 14.433 17.9989 14.25C17.9989 14.067 18.0662 13.8904 18.1879 13.7539C18.3097 13.6173 18.4775 13.5303 18.6592 13.5094C18.7639 13.389 18.893 13.2925 19.038 13.2262C19.183 13.1599 19.3406 13.1254 19.5 13.125H22.125C22.3239 13.125 22.5147 13.046 22.6553 12.9053C22.796 12.7647 22.875 12.5739 22.875 12.375V11.25H22.125V12.375H17.625C17.4263 12.3756 17.2358 12.4548 17.0953 12.5953C16.9548 12.7358 16.8756 12.9263 16.875 13.125V15.375C16.8756 15.5737 16.9548 15.7642 17.0953 15.9047C17.2358 16.0452 17.4263 16.1244 17.625 16.125H22.875C23.0737 16.1244 23.2642 16.0452 23.4047 15.9047C23.5452 15.7642 23.6244 15.5737 23.625 15.375V15C23.625 15.0995 23.5855 15.1948 23.5152 15.2652C23.4448 15.3355 23.3495 15.375 23.25 15.375Z" fill="#CB3541"/>
                        <path d="M18 17.25H22.125V16.125H17.625C17.4929 16.1242 17.3634 16.0881 17.25 16.0204V16.5C17.25 16.6989 17.329 16.8897 17.4697 17.0303C17.6103 17.171 17.8011 17.25 18 17.25Z" fill="#FC9E20"/>
                        <path d="M1.875 16.875V15.375C1.87559 15.1763 1.9548 14.9859 2.09533 14.8453C2.23585 14.7048 2.42627 14.6256 2.625 14.625H3.375V6.705C3.01367 6.63235 2.68195 6.45433 2.42167 6.19339C2.1614 5.93244 1.98422 5.60027 1.9125 5.23875C1.8741 5.05892 1.86398 4.8742 1.8825 4.69125C1.94134 4.219 2.17257 3.78513 2.5318 3.47298C2.89102 3.16082 3.35291 2.99238 3.82875 3H2.625C2.02826 3 1.45597 3.23706 1.03401 3.65901C0.612053 4.08097 0.375 4.65327 0.375 5.25V19.875C0.375 20.2728 0.533035 20.6544 0.81434 20.9357C1.09564 21.217 1.47718 21.375 1.875 21.375V16.875Z" fill="#FC9E20"/>
                        <path d="M21 19.875H18C17.6022 19.875 17.2206 19.717 16.9393 19.4357C16.658 19.1544 16.5 18.7728 16.5 18.375V16.5C16.5 16.3011 16.421 16.1103 16.2803 15.9697C16.1397 15.829 15.9489 15.75 15.75 15.75H15.375V21.375H20.625C21.4538 21.375 22.125 20.7038 22.125 20.25V18.75C22.125 19.0484 22.0065 19.3345 21.7955 19.5455C21.5845 19.7565 21.2984 19.875 21 19.875Z" fill="#FC9E20"/>
                    </svg>
                    <p>Saldo</p>
                    <span>Rp. 3.000.000 <i class="icon-right"></i></span>
                </a>    
            </li>
            
            <li >
                <a href="rewards.html" class="list-profile">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.4783 12.1688L17.2002 11.339C17.1299 11.3109 17.0455 11.2969 16.9612 11.2969H2.36426C1.97046 11.2969 1.66113 11.6062 1.66113 12V21.8906C1.66113 23.0578 2.60328 24 3.77051 24H17.833C19.0003 24 19.9424 23.0578 19.9424 21.8906V12.8296C19.9424 12.5344 19.7596 12.2672 19.4783 12.1688Z" fill="#FC1A40"/>
                        <path d="M19.9424 12.8296V21.8906C19.9424 23.0578 19.0003 24 17.833 24H10.8018V11.2969H16.9611C17.0455 11.2969 17.1299 11.3109 17.2002 11.339L19.4783 12.1688C19.7595 12.2672 19.9424 12.5344 19.9424 12.8296Z" fill="#C60034"/>
                        <path d="M19.6892 4.58381C19.4501 3.6135 18.7329 2.85417 17.7626 2.54475C16.8063 2.24939 15.7797 2.46037 15.0345 3.13533L13.4032 4.56975L13.0798 2.41823C12.9251 1.43385 12.2923 0.604118 11.3501 0.210414C11.1673 0.140054 10.9845 0.0838041 10.8017 0.055679C10.0282 -0.0990088 9.22668 0.0697415 8.57976 0.547914C7.72195 1.16667 7.28605 2.20729 7.42663 3.24787C7.58137 4.2885 8.28449 5.17444 9.28289 5.526L10.8017 6.07444L12.672 6.7635C12.6861 6.7635 12.6861 6.7635 12.6861 6.7635L15.9345 7.95877C16.2579 8.07132 16.5954 8.12762 16.9188 8.12762C17.608 8.12762 18.283 7.8744 18.8173 7.39632C19.6048 6.69319 19.9423 5.61033 19.6892 4.58381Z" fill="#FE9923"/>
                        <path d="M18.8174 7.39635C18.283 7.87443 17.608 8.12765 16.9189 8.12765C16.5955 8.12765 16.258 8.07135 15.9346 7.95881L12.6861 6.76354C12.6861 6.76354 12.6861 6.76354 12.6721 6.76354L10.8018 6.07447V0.0556641C10.9846 0.083836 11.1674 0.140039 11.3502 0.210399C12.2923 0.604103 12.9252 1.43384 13.0798 2.41822L13.4032 4.56974L15.0345 3.13531C15.7798 2.46036 16.8064 2.24937 17.7627 2.54473C18.733 2.85415 19.4502 3.61348 19.6892 4.5838C19.9424 5.61036 19.6049 6.69322 18.8174 7.39635Z" fill="#FE8821"/>
                        <path d="M22.3471 10.9733L21.3908 13.6171C21.2783 13.8983 21.0111 14.0671 20.7299 14.0671C20.6455 14.0671 20.5611 14.053 20.4908 14.0249L13.2205 11.3812L12.5596 9.20149L10.8018 9.5952L9.25493 9.94676L1.98455 7.30301C1.61893 7.16243 1.43616 6.75457 1.56268 6.403L2.53299 3.75934C2.7158 3.22497 3.1096 2.803 3.61585 2.56398C4.1221 2.32496 4.69862 2.29679 5.233 2.49367L10.8018 4.51867L11.1815 4.65925C11.1815 4.65925 12.7002 7.41555 12.7425 7.41555C12.7707 7.41555 13.3753 7.07805 13.9659 6.75457C14.5564 6.43113 15.1471 6.09367 15.1471 6.09367L21.0814 8.25926C21.6158 8.45613 22.0377 8.84993 22.2767 9.35618C22.5158 9.86239 22.5439 10.439 22.3471 10.9733Z" fill="#FF3E75"/>
                        <path d="M22.3471 10.9733L21.3908 13.6171C21.2783 13.8983 21.0111 14.0671 20.7299 14.0671C20.6455 14.0671 20.5611 14.053 20.4908 14.0249L13.2205 11.3812L12.5596 9.2015L10.8018 9.5952V4.51868L11.1815 4.65926C11.1815 4.65926 12.7002 7.41556 12.7424 7.41556C12.7706 7.41556 13.3752 7.07806 13.9659 6.75457C14.5564 6.43113 15.1471 6.09368 15.1471 6.09368L21.0814 8.25926C21.6158 8.45614 22.0377 8.84994 22.2767 9.35619C22.5158 9.86239 22.5439 10.439 22.3471 10.9733Z" fill="#FC1A40"/>
                        <path d="M8.69238 11.2969V24H12.9111V11.2969H8.69238Z" fill="#FCBF29"/>
                        <path d="M11.1814 4.6593L10.8017 5.69993L9.25488 9.94686L10.8017 10.5094L12.5595 11.1422L13.2204 11.3812L15.1471 6.09373L11.1814 4.6593Z" fill="#FCBF29"/>
                        <path d="M12.9114 11.2969H10.802V24H12.9114V11.2969Z" fill="#FE9923"/>
                        <path d="M15.1471 6.09373L13.2205 11.3812L12.5596 11.1422L10.8018 10.5094V5.69993L11.1814 4.6593L15.1471 6.09373Z" fill="#FE9923"/>
                    </svg>                    
                    <p>Point and Rewards</p>
                    <span>21 Gift<i class="icon-right"></i></span>
                </a>
            </li>
        </ul>        
        <ul class="box-settings-profile mt-1 mb-8">
            <li>
                <a href="../../setting.html" class="list-setting-profile">
                    <span class="icon icon-setting1"></span>
                    <p>Setting</p>
                    <i class="icon-right"></i>
                </a>   
            </li>
        </ul>
    </div>
    
    
    <div class="bottom-navigation-bar">
        <div class="tf-container">
            <ul class="tf-navigation-bar">
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="../../home.php"><i class="icon-home"></i> Home</a> 
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="58_history.html">
                        <i class="icon-history"></i> History</a> 
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="40_qr-code.html">
                        <i class="icon-scan-qr-code"></i> </a> 
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="62_rewards.html">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.25" cy="12" r="9.5" stroke="#717171" />
                            <path
                                d="M17.033 11.5318C17.2298 11.3316 17.2993 11.0377 17.2144 10.7646C17.1293 10.4914 16.9076 10.2964 16.6353 10.255L14.214 9.88781C14.1109 9.87213 14.0218 9.80462 13.9758 9.70702L12.8933 7.41717C12.7717 7.15989 12.525 7 12.2501 7C11.9754 7 11.7287 7.15989 11.6071 7.41717L10.5244 9.70723C10.4784 9.80483 10.3891 9.87234 10.286 9.88802L7.86469 10.2552C7.59257 10.2964 7.3707 10.4916 7.2856 10.7648C7.2007 11.038 7.27018 11.3318 7.46702 11.532L9.2189 13.3144C9.29359 13.3905 9.32783 13.5 9.31021 13.607L8.89692 16.1239C8.86027 16.3454 8.91594 16.5609 9.0533 16.7308C9.26676 16.9956 9.6394 17.0763 9.93735 16.9128L12.1027 15.7244C12.1932 15.6749 12.3072 15.6753 12.3975 15.7244L14.563 16.9128C14.6684 16.9707 14.7807 17 14.8966 17C15.1083 17 15.3089 16.9018 15.4469 16.7308C15.5845 16.5609 15.6399 16.345 15.6033 16.1239L15.1898 13.607C15.1722 13.4998 15.2064 13.3905 15.2811 13.3144L17.033 11.5318Z"
                                stroke="#717171" stroke-width="1.25" />
                        </svg>
                        Rewards</a> 
                </li>
                <li class="active">
                    <a class="fw_6 d-flex justify-content-center align-items-center flex-column" href="profil.php">
                        <i class="icon-user-fill"></i> Profil</a> 
                </li>
            </ul>
        </div>
    </div>


    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>