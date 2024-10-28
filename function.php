<?php
function registrasi($data)
{
    global $koneksi;

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        $auto = mysqli_query($koneksi, "SELECT MAX(id_app) AS max_id FROM tb_app");
        if (!$auto) {
            throw new Exception("Error on selecting max id: " . mysqli_error($koneksi));
        }

        // Ambil hasil query sebagai array asosiatif
        $row = mysqli_fetch_assoc($auto);
        $id_app = $row['max_id'] + 1;

        $nm_sekolah = $_POST['nm_sekolah'];
        $alamat = $_POST['alamat'];
        $telepon = $_POST['telepon'];
        $logo_app = "app.png";
        $tgl_rilis = date("Y-m-d");
        $kab = "3522";
        $nm_user = "admin" . $id_app;
        $kd_sts_user = 2;
        $username = "-";
        $email = strtolower(trim($data['email']));
        $password = mysqli_real_escape_string($koneksi, $data["password"]);
        $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

        // Validasi email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Format email tidak valid.";
            exit;
        }

        // Cek konfirmasi password
        if ($password !== $password2) {
            echo "<script>
                    alert('Konfirmasi password tidak sesuai');
                  </script>";
            return false;
        }

        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tambahkan data ke tabel tb_app
        $insert_app = "INSERT INTO tb_app (id_app, nm_app, logo_app, tgl_rilis, kab, almt, no_telp) 
                       VALUES ('$id_app', '$nm_sekolah', '$logo_app', '$tgl_rilis', '$kab', '$alamat', '$telepon')";
        
        if (!mysqli_query($koneksi, $insert_app)) {
            throw new Exception("Error inserting into tb_app: " . mysqli_error($koneksi));
        }

        // Tambahkan data ke tabel tb_user
        $insert_user = "INSERT INTO tb_user (id_app, nm_user, kd_sts_user, username, pass, pass_txt, nohp, tgl_lhr, email, tgl_gbng) 
                        VALUES ('$id_app', '$nm_user', '$kd_sts_user', '$username', '$hashed_password', '$password', '$telepon', '$tgl_rilis', '$email', '$tgl_rilis')";
        
        if (!mysqli_query($koneksi, $insert_user)) {
            throw new Exception("Error inserting into tb_user: " . mysqli_error($koneksi));
        }

        // Commit transaksi jika kedua query berhasil
        if (mysqli_commit($koneksi)) {
            return 1; // Berhasil
        } else {
            return 0; // Gagal
        }
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        mysqli_rollback($koneksi);
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>