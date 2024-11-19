<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Akses Pengguna</title>
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
        /* General Table Styling */
        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 1rem;
            background-color: #fff;
        }

        /* Remove default border collapse conflict */
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            /* Set border color for all sides */
        }

        .table th {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 14px;
            background-color: #f8f9fa;
            color: #333;
            padding: 10px;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            padding: 10px;
        }

        /* Status Badge Styling */
        .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge.bg-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge.bg-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-primary {
            font-size: 12px;
            padding: 5px 8px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #28a745;
            /* Green for Edit */
            border: none;
            color: #fff;
        }

        .btn-primary i {
            font-size: 14px;
            margin-right: 0;
        }

        /* Delete Button Styling */
        .btn-danger {
            font-size: 12px;
            padding: 5px 8px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #dc3545;
            /* Red for Delete */
            border: none;
            color: #fff;
        }

        .btn-danger i {
            font-size: 14px;
        }

        /* Hover Effects */
        .btn-primary:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Darker red on hover */
        }

        /* Table Row Hover Effect */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Table Adjustments */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Modal Custom Styles */
        #staticBackdrop .modal-dialog {
            max-width: 60%;
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
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Akses Pengguna</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap">
        <div class="app-section st1 mt-1 mb-5 bg_white_color">
            <div class="tf-container">
                <div class="trading-month">

                </div>
                <div class="trading-month">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Role Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../../conn/koneksi.php";

                            $sql = mysqli_query($koneksi, "SELECT * FROM tb_sts_user");
                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <tr>
                                    <td><?php echo $data['nm_sts_user']; ?></td>
                                    <td><?php echo $data['ket_sts_user']; ?></td>
                                    <td>
                                        <?php
                                        if ($data['st_sts_user'] == 1) {
                                            echo '<span class="badge bg-success" style="text-transform: none;">' . ucfirst(strtolower('aktif')) . '</span>';
                                        } else {
                                            echo '<span class="badge bg-danger" style="text-transform: none;">' . ucfirst(strtolower('tidak')) . '</span>';
                                        }
                                        ?>
                                    </td>
                                    <td style="justify-content: center; display: flex;">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="tf-btn accent" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" style="width: 50%; height:15px;"><i class="fa-solid fa-gear"></i>
                                            Atur
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Master Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Menu</th>
                                                                        <th>View</th>
                                                                        <th>Tambah</th>
                                                                        <th>Edit</th>
                                                                        <th>Hapus</th>
                                                                        <th>Lainnya</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $mysql = mysqli_query($koneksi, "SELECT * FROM tb_menu");
                                                                    while ($tampil = mysqli_fetch_array($mysql)) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $tampil['nm_menu']; ?></td>
                                                                            <td>
                                                                                <fieldset class="d-flex justify-content-center">
                                                                                    <input class="tf-switch-check" id="switchCheckDefault" type="checkbox">
                                                                                    <label for="switchCheckDefault"></label>
                                                                                </fieldset>
                                                                            </td>
                                                                            <td>
                                                                                <fieldset class="d-flex justify-content-center">
                                                                                    <input class="tf-switch-check" id="switchCheckDefault" type="checkbox">
                                                                                    <label for="switchCheckDefault"></label>
                                                                                </fieldset>
                                                                            </td>
                                                                            <td>
                                                                                <fieldset class="d-flex justify-content-center">
                                                                                    <input class="tf-switch-check" id="switchCheckDefault" type="checkbox">
                                                                                    <label for="switchCheckDefault"></label>
                                                                                </fieldset>
                                                                            </td>
                                                                            <td>
                                                                                <fieldset class="d-flex justify-content-center">
                                                                                    <input class="tf-switch-check" id="switchCheckDefault" type="checkbox">
                                                                                    <label for="switchCheckDefault"></label>
                                                                                </fieldset>
                                                                            </td>
                                                                            <td>
                                                                                <fieldset class="d-flex justify-content-center">
                                                                                    <input class="tf-switch-check" id="switchCheckDefault" type="checkbox">
                                                                                    <label for="switchCheckDefault"></label>
                                                                                </fieldset>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="tf-btn secondary" data-bs-dismiss="modal" style="height: 40px;">Tutup</button>
                                                        <button type="button" class="tf-btn accent" style="height: 40px;">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="edit.php?kd_sts_user=<?php echo $data['kd_sts_user']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="delete.php?kd_sts_user=<?php echo $data['kd_sts_user']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda Yakin Menghapus Data?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-navigation-bar">
        <div class="tf-container">
            <ul class="tf-navigation-bar">
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column"
                        href="../../home.php"><i class="icon-home"></i> Home</a>
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
                            <path
                                d="M17.033 11.5318C17.2298 11.3316 17.2993 11.0377 17.2144 10.7646C17.1293 10.4914 16.9076 10.2964 16.6353 10.255L14.214 9.88781C14.1109 9.87213 14.0218 9.80462 13.9758 9.70702L12.8933 7.41717C12.7717 7.15989 12.525 7 12.2501 7C11.9754 7 11.7287 7.15989 11.6071 7.41717L10.5244 9.70723C10.4784 9.80483 10.3891 9.87234 10.286 9.88802L7.86469 10.2552C7.59257 10.2964 7.3707 10.4916 7.2856 10.7648C7.2007 11.038 7.27018 11.3318 7.46702 11.532L9.2189 13.3144C9.29359 13.3905 9.32783 13.5 9.31021 13.607L8.89692 16.1239C8.86027 16.3454 8.91594 16.5609 9.0533 16.7308C9.26676 16.9956 9.6394 17.0763 9.93735 16.9128L12.1027 15.7244C12.1932 15.6749 12.3072 15.6753 12.3975 15.7244L14.563 16.9128C14.6684 16.9707 14.7807 17 14.8966 17C15.1083 17 15.3089 16.9018 15.4469 16.7308C15.5845 16.5609 15.6399 16.345 15.6033 16.1239L15.1898 13.607C15.1722 13.4998 15.2064 13.3905 15.2811 13.3144L17.033 11.5318Z"
                                stroke="#717171" stroke-width="1.25" />
                        </svg>
                        Rewards</a>
                </li>
                <li>
                    <a class="fw_4 d-flex justify-content-center align-items-center flex-column"
                        href="../profil/profil.php">
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