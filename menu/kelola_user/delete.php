<?php
// Pastikan koneksi ke database sudah dilakukan
include '../../conn/koneksi.php'; // Sesuaikan dengan path database Anda

// Periksa apakah parameter id_user ada pada URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Cek status pengguna berdasarkan id_user
    $query_check = "SELECT kd_sts_user FROM tb_user WHERE id_user = '$id_user'";
    $result_check = mysqli_query($koneksi, $query_check);
    $row = mysqli_fetch_assoc($result_check);

    if ($row) {
        $kd_sts_user = $row['kd_sts_user'];

        // Cek apakah status user termasuk dalam daftar yang tidak boleh dihapus
        if (in_array($kd_sts_user, [6, 7, 8])) {
            echo "<script>
                alert('Data tidak dapat terhapus. Silahkan hapus pada menu orang tua, guru, atau siswa sesuai dengan status pengguna!');
                window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
            </script>";
            exit;
        }

        // Jika bukan status yang dilarang, lakukan penghapusan
        $query_delete = "DELETE FROM tb_user WHERE id_user = '$id_user'";

        if (mysqli_query($koneksi, $query_delete)) {
            echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
            </script>";
        } else {
            echo "<script>
                alert('Terjadi kesalahan saat menghapus data!');
                window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
            </script>";
        }
    } else {
        echo "<script>
            alert('ID user tidak ditemukan!');
            window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
        </script>";
    }
} else {
    echo "<script>
        alert('ID user tidak ditemukan!');
        window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
    </script>";
}
