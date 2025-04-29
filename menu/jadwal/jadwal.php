<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Specific Metas -->
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover" />
  <title>Jadwal Pelajaran</title>
  <!-- Favicon and Touch Icons  -->
  <link rel="shortcut icon" href="../../images/logo.png" />
  <link rel="apple-touch-icon-precomposed" href="images/logo.png" />
  <!-- Font -->
  <link rel="stylesheet" href="../../fonts/fonts.css" />
  <!-- Icons -->
  <link rel="stylesheet" href="../../fonts/icons-alipay.css ">
  <link rel="stylesheet" href="../../styles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../styles/styles.css" />
  <link rel="manifest" href="../../_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
  <link rel="apple-touch-icon" sizes="192x192" href="../../app/icons/icon-192x192.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
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
      <div
        class="tf-statusbar d-flex justify-content-center align-items-center">
        <a href="home.php" class="back-btn"> <i class="icon-left"></i> </a>
        <h3>Jadwal Pelajaran</h3>
      </div>
    </div>
  </div>
  <div id="app-wrap">
    <div class="bill-payment-content">
      <div class="tf-container">
        <?php
        session_start();
        include '../../conn/koneksi.php'; // pastikan path-nya benar

        // Cek apakah username ada di session
        if (!isset($_SESSION['username'])) {
          die("Anda belum login.");
        }

        $username = $_SESSION['username']; // ambil username dari session

        // Query untuk ambil id_user berdasarkan username
        $query_user = mysqli_query($koneksi, "SELECT id_user FROM tb_user WHERE username = '$username'");
        if (!$query_user) {
          die('Query error: ' . mysqli_error($koneksi));
        }

        // Ambil id_user
        $data_user = mysqli_fetch_assoc($query_user);
        if ($data_user) {
          $id_user = $data_user['id_user']; // simpan id_user
        } else {
          die('User tidak ditemukan.');
        }

        // Ambil id_ortu dari t_ortu berdasarkan id_user
        $query_ortu = mysqli_query($koneksi, "SELECT id_ortu FROM t_ortu WHERE id_user = '$id_user'");
        if (!$query_ortu) {
          die('Query error: ' . mysqli_error($koneksi));
        }

        $data_ortu = mysqli_fetch_assoc($query_ortu);
        if ($data_ortu) {
          $id_ortu = $data_ortu['id_ortu'];
        } else {
          die('Data orang tua tidak ditemukan.');
        }

        // Ambil daftar siswa berdasarkan id_ortu
        $query_murid = mysqli_query($koneksi, "SELECT id_mrd, nm_murid FROM t_murid WHERE id_ortu = '$id_ortu'");
        ?>

        <div class="bill-topbar mt-3">
          <select class="form-select fw_6" style="font-size: 18px;">
            <option selected disabled>Pilih Siswa</option>
            <?php while ($murid = mysqli_fetch_assoc($query_murid)) : ?>
              <option value="<?= $murid['id_mrd'] ?>"><?= $murid['nm_murid'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="wrap-banks mt-5">
          <div class="tf-container">
            <div class="tf-spacing-10"></div>
            <div
              class="bank-list"
              style="
    position: relative;
    height: 200px;
    width: 100%;
    background-image: url('../../images/img/set-bg-14.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  ">
              <!-- Overlay semi-transparan -->
              <div style="
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    border-radius: 10px;
  "></div>

              <!-- Teks di atas overlay -->
              <div style="
    position: relative;
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #1a237e; /* biru tua */
    text-align: center;
    line-height: 1.4;
  ">
                Selamat Datang<br>di Tahun Ajaran Baru
              </div>
            </div>

          </div>
        </div>
        <div class="container mt-5">
          <!-- Card Besar -->
          <div
            class="card"
            style="
                border-radius: 20px;
                background-color: #e3f2fd;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
              ">
            <div class="card-header text-center" style="
  background-color: #42a5f5;
  color: white;
  font-size: 2.5rem;
  padding: 20px;
  font-family: 'Dancing Script', cursive;
">
              Jadwal Pelajaran
            </div>
            <div class="card-body">
              <!-- Row Pertama: Senin, Selasa, Rabu -->
              <div class="row mb-4">
                <div class="col-md-4">
                  <!-- Card Senin -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #4caf50;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Senin
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>Matematika</td>
                          </tr>
                          <tr>
                            <td>09.00-11.00</td>
                            <td>IPA</td>
                          </tr>
                          <tr>
                            <td>11.00-13.00</td>
                            <td>Seni Budaya</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <!-- Card Selasa -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #f57f17;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Selasa
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>Bahasa Indonesia</td>
                          </tr>
                          <tr>
                            <td>09.00-11.00</td>
                            <td>IPA</td>
                          </tr>
                          <tr>
                            <td>11.00-13.00</td>
                            <td>Penjaskes</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <!-- Card Rabu -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #29b6f6;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Rabu
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>Matematika</td>
                          </tr>
                          <tr>
                            <td>09.00-11.00</td>
                            <td>IPS</td>
                          </tr>
                          <tr>
                            <td>11.00-13.00</td>
                            <td>Bahasa Inggris</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Row Kedua: Kamis, Jumat -->
              <div class="row mb-4">
                <div class="col-md-4">
                  <!-- Card Kamis -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #8e24aa;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Kamis
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>PPKN</td>
                          </tr>
                          <tr>
                            <td>09.00-11.00</td>
                            <td>Bahasa Indonesia</td>
                          </tr>
                          <tr>
                            <td>11.00-13.00</td>
                            <td>Penjaskes</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <!-- Card Jumat -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #e53935;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Jumat
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>Matematika</td>
                          </tr>
                          <tr>
                            <td>09.00-10.30</td>
                            <td>IPA</td>
                          </tr>
                          <tr>
                            <td>10.30-12.00</td>
                            <td>Seni Budaya</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <!-- Card Sabtu -->
                  <div
                    class="card mb-4"
                    style="border-radius: 15px; background-color: #f1f8ff">
                    <div
                      class="card-header text-center"
                      style="
                          background-color: #43a047;
                          color: white;
                          font-size: 1.5rem;
                        ">
                      Sabtu
                    </div>
                    <div class="card-body">
                      <table
                        class="table table-bordered table-striped text-center">
                        <thead class="table-primary">
                          <tr>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>07.00-09.00</td>
                            <td>Olahraga</td>
                          </tr>
                          <tr>
                            <td>09.00-11.00</td>
                            <td>Kesenian</td>
                          </tr>
                          <tr>
                            <td>11.00-12.30</td>
                            <td>Prakarya</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bottom-navigation-bar st1 bottom-btn-fixed"></div>

  <script type="text/javascript" src="../../javascript/jquery.min.js"></script>
  <script type="text/javascript" src="../../javascript/bootstrap.min.js"></script>
  <script type="text/javascript" src="../../javascript/count-down.js"></script>
  <script type="text/javascript" src="../../javascript/main.js"></script>
</body>

</html>