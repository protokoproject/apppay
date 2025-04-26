<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Struk Kasir</title>
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
            text-align: center;
            padding: 40px;
        }

        .total-bayar {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .qr-container {
            margin-bottom: 20px;
        }

        .expired-time {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }

        body {
            background: #f9f9f9;
            font-family: 'Courier New', Courier, monospace;
        }

        .section-struk {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .struk-container {
            background: #fff;
            padding: 25px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 360px;
            width: 100%;
            text-align: center;
        }

        .struk-title {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-cetak {
            background-color: #4A90E2;
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-cetak:hover {
            background-color: #357ABD;
        }

        .receipt {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            text-align: center;
            border: 1px dashed #000;
            padding: 20px;
            margin-top: 20px;
            background: #fff;
        }

        .receipt hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .receipt p {
            margin: 2px 0;
            font-size: 12px;
        }

        .receipt h5 {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .wrapper-tombol {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            /* Kasih jarak antar tombol */
        }
    </style>
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
                <h3 class="white_color">Struk</h3>
            </div>
        </div>
    </div>
    <!-- Struk Kasir -->
    <section class="section-struk">
        <div class="struk-container">
            <h2 class="struk-title">Struk</h2>
            <form id="form-struk">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" id="item-name" value="Es Teh">
                </div>

                <div class="form-group">
                    <label>Harga Satuan</label>
                    <input type="number" class="form-control" id="item-price" value="3000">
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="item-quantity" value="1">
                </div>

                <div class="form-group">
                    <label>Bayar (Saldo)</label>
                    <input type="number" class="form-control" id="saldo" value="5000">
                </div>

                <button type="button" class="btn-cetak" onclick="proceedPayment()">Cetak Struk</button>
            </form>
        </div>
    </section>
    <!-- Tampilan Hasil Struk -->
    <section class="section-struk d-none" id="result-section">
        <div class="struk-container">
            <div id="payment-status"></div>
            <div id="payment-actions" class="mt-3"></div>
        </div>
    </section>

    <script>
        function proceedPayment() {
            const itemName = document.getElementById('item-name').value;
            const itemPrice = parseInt(document.getElementById('item-price').value);
            const itemQty = parseInt(document.getElementById('item-quantity').value);
            const saldo = parseInt(document.getElementById('saldo').value);

            const totalPrice = itemPrice * itemQty;
            const kembali = saldo - totalPrice;
            const now = new Date();
            const date = now.toISOString().split('T')[0];
            const time = now.toTimeString().split(' ')[0];

            document.querySelector('.section-struk').classList.add('d-none');
            document.getElementById('result-section').classList.remove('d-none');

            if (saldo >= totalPrice) {
                document.getElementById('payment-status').innerHTML = `
                <div class="receipt">
                    <h5>WARUNG BU SITI</h5>
                    <p>No Struk: #${Math.floor(Math.random()*100000)}</p>
                    <p>Tanggal: ${date}</p>
                    <p>Jam: ${time}</p>
                    <hr>
                    <p>${itemName}</p>
                    <p>${itemQty} x Rp${itemPrice.toLocaleString()}</p>
                    <hr>
                    <p><b>Total :</b> Rp${totalPrice.toLocaleString()}</p>
                    <p><b>Bayar :</b> Rp${saldo.toLocaleString()}</p>
                    <hr>
                    <p>*** Terima Kasih ***</p>
                </div>
            `;

                document.getElementById('payment-actions').innerHTML = `
                <div class="wrapper-tombol">
                    <button class="btn-cetak" onclick="printReceipt()">Cetak</button>
                    <a href="struk_kasir.php" class="btn-cetak btn-transaksi-baru">Transaksi Baru</a>
                </div>
            `;

            } else {
                document.getElementById('payment-status').innerHTML = `
                <h4 class="text-danger">Pembayaran Gagal</h4>
                <p>Saldo tidak cukup.</p>
            `;
                document.getElementById('payment-actions').innerHTML = `
                <a href="struk_kasir.php" class="btn-cetak" style="background:#f00;">Coba Lagi</a>
            `;
            }
        }

        function printReceipt() {
            window.print();
        }
    </script>
    <!-- <div class="group-input">
                    <label>Message</label>
                    <input type="text" placeholder="Placeholder">
                </div> -->
    </div>

    <div class="bottom-navigation-bar bottom-btn-fixed">
        <div class="tf-container">
            <a href="../../home.php" id="btn-popup-up" class="tf-btn accent large">Kembali</a>
        </div>
    </div>
    </form>
    </div>
    <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
    <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="../../javascript/swiper.js"></script>
    <script type="text/javascript" src="../../javascript/main.js"></script>

</body>

</html>