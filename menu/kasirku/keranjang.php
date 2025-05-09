<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>Keranjang</title>
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
        .order-list {
            list-style: none;
            padding: 0;
        }

        .list-card-invoice {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .content-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-quantity-text {
            font-size: 20px;
            /* Ukuran lebih besar */
            font-weight: bold;
        }

        .menu-info {
            display: flex;
            flex-direction: column;
        }

        .menu-info h4 {
            margin: 0;
            font-size: 16px;
        }

        .menu-info p {
            margin: 2px 0 0;
            font-size: 14px;
            color: #555;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-minus,
        .btn-plus {
            background-color: #6c5ce7;
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .total {
            text-align: right;
            margin-top: 15px;
            font-size: 20px;
            font-weight: bold;
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
                <h3 class="white_color">Keranjang</h3>
            </div>
        </div>
    </div>
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="form-group position-relative" style="width: 100%;">
                    <label for="nama-siswa" class="me-2 mb-0">Nama Siswa:</label>
                    <input type="text" id="nama-siswa" class="form-control" placeholder="Masukkan nama siswa...">
                    <!-- Tempat hasil autosuggest -->
                    <div id="list-siswa" class="list-group" style="position: absolute; width: 100%; z-index: 1000; top: 100%;"></div>
                </div>

                <div class="tf-spacing-16"></div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="inner-left d-flex justify-content-between align-items-center">
                        <!-- Bagian lain jika ada -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#nama-siswa").keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "search_siswa.php",
                        method: "POST",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            $("#list-siswa").fadeIn();
                            $("#list-siswa").html(data);
                        }
                    });
                } else {
                    $("#list-siswa").fadeOut();
                }
            });

            $(document).on('click', '.list-group-item', function() {
                const fullText = $(this).text();
                const nmMurid = $(this).data('nama');
                const idUser = $(this).data('id');

                $('#nama-siswa').val(fullText);
                $('#list-siswa').fadeOut();

                localStorage.setItem('nm_murid', nmMurid);
                localStorage.setItem('id_user', idUser);

                const username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";

                // Simpan juga ke dalam selectedData[username]
                let selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
                if (!selectedData[username]) selectedData[username] = {};

                selectedData[username]["id_user"] = idUser;
                selectedData[username]["nm_murid"] = nmMurid;

                localStorage.setItem('selectedData', JSON.stringify(selectedData));

                // Hitung total dan tampilkan data
                calculateTotal();
                tampilkanDataSetelahNamaMuridDipilih();
            });

        });
    </script>

    <div class="tf-spacing-20"></div>
    <div class="transfer-content">
        <form class="tf-form">
            <div class="tf-container">
                <div class="group-input input-field input-money">
                    <h3 class="fw_6 d-flex justify-content-between mt-3">Detail Pesanan <p>Subtotal</p>
                    </h3>
                    <!-- List Menu Kantin -->
                    <ul class="order-list" id="order-list"></ul>

                    <!-- Modal -->
                    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="menuModalLabel">Atur Pesanan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p id="selected-menu-name" class="fw-bold"></p>
                                    <label for="quantity">Jumlah:</label>
                                    <input type="number" id="quantity" class="form-control" min="1" value="1">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-hapus">Hapus</button>
                                    <button type="button" class="btn btn-primary" id="btn-oke" data-bs-dismiss="modal">Oke</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        let currentItem = null;

                        // Pastikan username di-escape dengan benar
                        const username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>"; // Escape username

                        // Function untuk menampilkan pesanan yang tersimpan di localStorage
                        // Fungsi untuk menampilkan pesanan yang tersimpan di localStorage
                        function displayOrderList() {
                            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
                            const userOrder = selectedData[username] || {};
                            const orderList = document.getElementById('order-list');

                            orderList.innerHTML = '';
                            let total = 0;

                            for (const menuName in userOrder) {
                                const itemData = userOrder[menuName];

                                // Skip entri non-menu
                                if (typeof itemData !== 'object' || itemData.jumlah === undefined || itemData.harga === undefined) {
                                    continue;
                                }

                                const qty = parseInt(itemData.jumlah);
                                const price = parseInt(itemData.harga);
                                const subtotal = price * qty;
                                total += subtotal;

                                const li = document.createElement('li');
                                li.classList.add('menu-item', 'card', 'p-2', 'mb-2');
                                li.dataset.name = menuName;
                                li.dataset.quantity = qty;

                                const itemRow = document.createElement('div');
                                itemRow.classList.add('d-flex', 'justify-content-between', 'align-items-start', 'fs-5');

                                const itemNameQty = document.createElement('div');
                                itemNameQty.textContent = `${menuName} (x${qty})`;

                                const itemSubtotal = document.createElement('div');
                                itemSubtotal.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
                                itemSubtotal.classList.add('text-end', 'text-muted', 'small');

                                itemRow.appendChild(itemNameQty);
                                itemRow.appendChild(itemSubtotal);

                                li.appendChild(itemRow);
                                orderList.appendChild(li);

                                li.addEventListener('click', () => {
                                    currentItem = li;
                                    document.getElementById('selected-menu-name').textContent = menuName;
                                    document.getElementById('quantity').value = qty;
                                    const modal = new bootstrap.Modal(document.getElementById('menuModal'));
                                    modal.show();
                                });
                            }

                            // Pastikan hanya isi angka di #total-price (tanpa tambahan "Rp" karena sudah di HTML)
                            document.getElementById('total-price').textContent = total.toLocaleString('id-ID');
                        }


                        // Fungsi untuk menghitung total harga dari localStorage
                        function calculateTotal() {
                            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
                            const userOrder = selectedData[username] || {};
                            let total = 0;

                            for (const menuName in userOrder) {
                                const itemData = userOrder[menuName];

                                if (typeof itemData !== 'object' || itemData.jumlah === undefined || itemData.harga === undefined) {
                                    continue;
                                }

                                const qty = parseInt(itemData.jumlah);
                                const price = parseInt(itemData.harga);
                                total += price * qty;
                            }

                            // Simpan total harga ke tampilan dan ke localStorage
                            document.getElementById('total-price').textContent = total.toLocaleString('id-ID');

                            // Tambahkan total ke dalam data user dan simpan ulang ke localStorage
                            if (!selectedData[username]) selectedData[username] = {};
                            selectedData[username]['total_harga'] = total;
                            localStorage.setItem('selectedData', JSON.stringify(selectedData));
                        }

                        // Saat halaman dimuat
                        window.onload = function() {
                            displayOrderList();
                        };

                        // Fungsi untuk menghapus item pesanan
                        document.getElementById('btn-hapus').addEventListener('click', () => {
                            if (currentItem) {
                                const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
                                if (selectedData[username] && selectedData[username][currentItem.dataset.name]) {
                                    delete selectedData[username][currentItem.dataset.name];
                                    localStorage.setItem('selectedData', JSON.stringify(selectedData));
                                }
                                currentItem.remove();
                                calculateTotal(); // Update total
                            }
                            const modal = bootstrap.Modal.getInstance(document.getElementById('menuModal'));
                            modal.hide();
                        });

                        // Fungsi untuk memperbarui jumlah pesanan
                        document.getElementById('btn-oke').addEventListener('click', () => {
                            if (currentItem) {
                                const qty = parseInt(document.getElementById('quantity').value);
                                const menuName = currentItem.dataset.name;

                                const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};
                                const userOrder = selectedData[username] || {};

                                if (userOrder[menuName]) {
                                    const harga = parseInt(userOrder[menuName].harga); // ambil harga lama

                                    // Update data dengan jumlah baru
                                    userOrder[menuName] = {
                                        jumlah: qty,
                                        harga: harga
                                    };

                                    selectedData[username] = userOrder;
                                    localStorage.setItem('selectedData', JSON.stringify(selectedData));

                                    // Update tampilan item di daftar
                                    const subtotal = harga * qty;
                                    currentItem.dataset.quantity = qty;

                                    currentItem.innerHTML = ''; // kosongkan dulu

                                    const itemRow = document.createElement('div');
                                    itemRow.classList.add('d-flex', 'justify-content-between', 'align-items-start', 'fs-5');

                                    const itemNameQty = document.createElement('div');
                                    itemNameQty.textContent = `${menuName} (x${qty})`;

                                    const itemSubtotal = document.createElement('div');
                                    itemSubtotal.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
                                    itemSubtotal.classList.add('text-end', 'text-muted', 'small');

                                    itemRow.appendChild(itemNameQty);
                                    itemRow.appendChild(itemSubtotal);
                                    currentItem.appendChild(itemRow);

                                    calculateTotal(); // Update total harga
                                }

                                const modal = bootstrap.Modal.getInstance(document.getElementById('menuModal'));
                                modal.hide();
                            }
                        });


                        function tampilkanDataSetelahNamaMuridDipilih() {
                            const username = "<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>";
                            const selectedData = JSON.parse(localStorage.getItem('selectedData')) || {};

                            if (selectedData[username]) {
                                const userData = selectedData[username];
                                console.log(`${username} {`);
                                for (const key in userData) {
                                    if (typeof userData[key] === 'object' && userData[key].harga !== undefined) {
                                        console.log(`  ${key}: {jumlah: ${userData[key].jumlah}, harga: ${userData[key].harga}}`);
                                    }
                                }
                                console.log(`  id_user: ${userData.id_user}`);
                                console.log(`  nm_murid: ${userData.nm_murid}`);
                                console.log(`  total_harga: ${userData.total_harga}`);
                                console.log(`}`);
                            } else {
                                console.log("Data tidak ditemukan. Pastikan nama murid telah dipilih.");
                            }
                        }

                        $(document).ready(function() {
                            // Sembunyikan tombol saat halaman dimuat
                            $('#btn-popup-up').hide();

                            // Pantau perubahan pada input nama siswa
                            $('#nama-siswa').on('input', function() {
                                const namaSiswa = $(this).val().trim();

                                if (namaSiswa === '') {
                                    $('#btn-popup-up').hide();
                                } else {
                                    $('#btn-popup-up').show();
                                }
                            });

                            // Validasi saat tombol diklik
                            $('#btn-popup-up').click(function(e) {
                                const namaSiswa = $('#nama-siswa').val().trim();

                                if (namaSiswa === '') {
                                    e.preventDefault();
                                    alert('Silakan isi nama siswa terlebih dahulu.');
                                    return false;
                                } else {
                                    // Isi data konfirmasi pembayaran
                                    $('#selected-menu-name').text('');
                                    $('#jumlah-pembayaran').text('Rp. ' + $('#total-price').text());
                                    $('#total-pembayaran').text('Rp. ' + $('#total-price').text());
                                    $('.main-topup h4 a.fw_6').text('Nama pembeli: ' + namaSiswa);

                                    $('.tf-panel.up').addClass('active');
                                }

                            });

                            // Tutup panel
                            $('.clear-panel').click(function() {
                                $('.tf-panel.up').removeClass('active');
                            });
                        });

                        $('#bayar-btn').click(function(e) {
                            const idUser = localStorage.getItem('id_user');

                            if (!idUser) {
                                e.preventDefault();
                                alert('Silakan pilih nama siswa dari daftar yang tersedia.');
                            }
                        });
                    </script>

                    <div class="total">
                        <h3>Total: Rp. <span id="total-price">0</span></h3>
                    </div>

                </div>

                <?php
                include '../../conn/koneksi.php'; // pastikan file ini berisi koneksi ke database

                $nm_kantin = 'Kantin Tidak Ditemukan';

                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];

                    // Ambil id_user dari tb_user
                    $query_user = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE username = '$username'");
                    if ($row_user = mysqli_fetch_assoc($query_user)) {
                        $id_user = $row_user['id_user'];

                        // Ambil nm_kantin dari t_kantin berdasarkan id_user
                        $query_kantin = mysqli_query($koneksi, "SELECT nm_kantin FROM t_kantin WHERE id_user = '$id_user'");
                        if ($row_kantin = mysqli_fetch_assoc($query_kantin)) {
                            $nm_kantin = $row_kantin['nm_kantin'];
                        }
                    }
                }
                ?>


                <div class="bottom-navigation-bar bottom-btn-fixed">
                    <div class="tf-container">
                        <a href="#" id="btn-popup-up" class="tf-btn accent large" style="display: none;">Selanjutnya</a>
                    </div>
                    <div class="tf-panel up">
                        <div class="panel_overlay"></div>
                        <div class="panel-box panel-up wrap-content-panel">
                            <div class="heading">
                                <div class="tf-container">
                                    <div class="d-flex align-items-center position-relative justify-content-center">
                                        <i class="icon-close1 clear-panel"></i>
                                        <h3>Konfirmasi Pembayaran</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="main-topup">
                                <div class="tf-container">
                                    <h3>Detail Pembayaran</h3>
                                    <div class="tf-card-block d-flex align-items-center justify-content-between">
                                        <div class="inner d-flex align-items-center">
                                            <div class="content">
                                                <h4><a href="#" class="fw_6">Nama pembeli: User</a></h4>
                                            </div>
                                        </div>
                                        <i class="icon-right"></i>
                                    </div>
                                    <ul class="info">
                                        <li>
                                            <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                                Jumlah
                                                <a href="#" class="on_surface_color fw_7" id="jumlah-pembayaran">Rp. 0</a>
                                            </h4>
                                        </li>
                                        <li>
                                            <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                                Nama Kantin
                                                <a href="#" class="on_surface_color fw_7" id="nama-kantin"><?php echo htmlspecialchars($nm_kantin); ?></a>
                                            </h4>
                                        </li>
                                        <li>
                                            <h4 class="secondary_color fw_4 d-flex justify-content-between align-items-center">
                                                Biaya admin <a href="#" class="success_color fw_7">Gratis</a>
                                            </h4>
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="total">
                                            <h4 class="secondary_color fw_4">Total</h4>
                                            <h2 id="total-pembayaran">Rp. 0</h2>
                                        </div>
                                        <a href="bayar.php" id="bayar-btn" class="tf-btn accent large"><i class="icon-secure1"></i>Bayar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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