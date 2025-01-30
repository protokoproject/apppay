<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Kelola User</title>
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

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .tf-trading-history {
            display: block;
            text-decoration: none;
            color: inherit;
            width: 100%;
            padding: 15px;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .inner-left {
            display: flex;
            align-items: center;
        }

        .icon-box {
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #f2f2f2;
            border-radius: 50%;
        }

        .icon-box i {
            font-size: 20px;
            color: #333;
        }

        .content h4 {
            margin: 0;
            font-size: 16px;
        }

        .content p {
            margin: 0;
            font-size: 14px;
            color: #888;
        }

        .num-val {
            display: flex;
            align-items: center;
            gap: 15px;
            /* Space between edit and delete buttons */
        }

        .num-val a {
            color: #333;
            font-size: 18px;
            text-decoration: none;
        }

        .num-val a i {
            cursor: pointer;
        }

        .tf-navigation-bar {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            background-color: #fff;
        }

        .tf-navigation-bar li {
            list-style: none;
        }

        .tf-navigation-bar a {
            text-align: center;
            color: #717171;
            font-size: 12px;
            text-decoration: none;
        }

        .tf-navigation-bar .active a {
            color: #000;
            font-weight: bold;
        }
    </style>
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
                <a href="../menu_lengkap/menu_lengkap.php" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Kelola User</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="trading-month">

                </div>
                <div class="tf-container">
                    <div class="trading-month">
                        <button class="mb-3 tf-btn accent small" style="width: 20%;">
                            <a href="tambah.php" style="color: white; text-decoration: none;" onmouseover="this.style.color='#533dea'" onmouseout="this.style.color='white'">Tambah Data</a>
                        </button>
                        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th style="padding: 10px;">No</th>
                                    <th style="padding: 10px;">Nama</th>
                                    <th style="padding: 10px;">Email</th>
                                    <th style="padding: 10px;">No HP</th>
                                    <th style="padding: 10px;">Tanggal Gabung</th>
                                    <th style="padding: 10px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "../../conn/koneksi.php";
                                $no = 1;

                                $sql = mysqli_query($koneksi, "SELECT * FROM tb_user");
                                while ($data = mysqli_fetch_array($sql)) {
                                    echo "<tr>";
                                    echo "<td style='padding: 10px;'>" . ($no) . "</td>";
                                    echo "<td style='padding: 10px;'>{$data['nm_user']}</td>";
                                    echo "<td style='padding: 10px;'>{$data['email']}</td>";
                                    echo "<td style='padding: 10px;'>{$data['nohp']}</td>";
                                    echo "<td style='padding: 10px;'>{$data['tgl_gbng']}</td>";
                                    echo "<td style='padding: 10px;'>
        <a href='edit.php?id={$data['id_user']}' style='margin-right: 10px;'>
            <i class='fa fa-pencil'></i>
        </a>
        <a href='delete.php?id={$data['id_user']}' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">
            <i class='fa fa-trash'></i>
        </a>
    </td>";
                                    echo "</tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bottom-navigation-bar">
        <div class="tf-container">
            <ul class="tf-navigation-bar">
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="../../home.php"><i class="icon-home"></i> Home</a>
                </li>
                <li class="active">
                    <a class="fw_6 d-flex justify-content-center align-items-center flex-column" href="58_history.html">
                        <i class="icon-history"></i> History</a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="40_qr-code.html">
                        <i class="icon-scan-qr-code"></i> </a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="62_rewards.html">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.25" cy="12" r="9.5" stroke="#717171" />
                            <path d="M17.033 11.5318C17.2298 11.3316 17.2993 11.0377 17.2144 10.7646C17.1293 10.4914 16.9076 10.2964 16.6353 10.255L14.214 9.88781C14.1109 9.87213 14.0218 9.80462 13.9758 9.70702L12.8933 7.41717C12.7717 7.15989 12.525 7 12.2501 7C11.9754 7 11.7287 7.15989 11.6071 7.41717L10.5244 9.70723C10.4784 9.80483 10.3891 9.87234 10.286 9.88802L7.86469 10.2552C7.59257 10.2964 7.3707 10.4916 7.2856 10.7648C7.2007 11.038 7.27018 11.3318 7.46702 11.532L9.2189 13.3144C9.29359 13.3905 9.32783 13.5 9.31021 13.607L8.89692 16.1239C8.86027 16.3454 8.91594 16.5609 9.0533 16.7308C9.26676 16.9956 9.6394 17.0763 9.93735 16.9128L12.1027 15.7244C12.1932 15.6749 12.3072 15.6753 12.3975 15.7244L14.563 16.9128C14.6684 16.9707 14.7807 17 14.8966 17C15.1083 17 15.3089 16.9018 15.4469 16.7308C15.5845 16.5609 15.6399 16.345 15.6033 16.1239L15.1898 13.607C15.1722 13.4998 15.2064 13.3905 15.2811 13.3144L17.033 11.5318Z" stroke="#717171" stroke-width="1.25" />
                        </svg>
                        Rewards</a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column" href="../profil/profil.php">
                        <i class="icon-user-outline"></i> Profil</a>
                </li>
            </ul>
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
            <div id="app-wrap" class="style1">
                <div class="mt-6">
                    <div class="tf-container">
                        <h4 class="mt-3 mb-3">Monthly</h4>
                        <ul class="filter-history">
                            <li><a href="#" class="tf-btn large active">All</a></li>
                            <li><a href="#" class="tf-btn large">Jan</a></li>
                            <li><a href="#" class="tf-btn large">Feb</a></li>
                            <li><a href="#" class="tf-btn large">Mar</a></li>
                            <li><a href="#" class="tf-btn large">Apr</a></li>
                            <li><a href="#" class="tf-btn large">May</a></li>
                            <li><a href="#" class="tf-btn large">Jun</a></li>
                            <li><a href="#" class="tf-btn large">July</a></li>
                            <li><a href="#" class="tf-btn large">Aug</a></li>
                            <li><a href="#" class="tf-btn large">Sep</a></li>
                            <li><a href="#" class="tf-btn large">Oct</a></li>
                            <li><a href="#" class="tf-btn large">Nov</a></li>
                            <li><a href="#" class="tf-btn large">Dec</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="container">
                        <h4 class="mt-3 mb-3">Status</h4>
                        <ul class="filter-history status">
                            <li><a href="#" class="tf-btn large active">All</a></li>
                            <li><a href="#" class="tf-btn large">Successful</a></li>
                            <li><a href="#" class="tf-btn large">Processing</a></li>
                            <li><a href="#" class="tf-btn large">Failure</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-btn">
                    <div class="tf-container">
                        <a href="61_filter-research.html" class="tf-btn accent large">Apply</a>

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