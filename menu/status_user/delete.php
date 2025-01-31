<?php
include "../../conn/koneksi.php";

// Proses delete data jika parameter `kd_sts_user` diberikan
if (isset($_GET['kd_sts_user'])) {
    $kd_sts_user = $_GET['kd_sts_user'];

    // Query untuk menghapus data berdasarkan `kd_sts_user`
    $query = "DELETE FROM tb_sts_user WHERE kd_sts_user = '$kd_sts_user'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        echo "<script>window.location.href='st_user.php';</script>";
    } else {
        error_log("Error executing query: " . mysqli_error($koneksi));
        echo "<script>alert('Terjadi kesalahan saat menghapus data!');</script>";
        echo "<script>console.log('Error: " . addslashes(mysqli_error($koneksi)) . "');</script>";
    }
}
?>
