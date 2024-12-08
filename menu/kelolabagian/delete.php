<?php
include "../../conn/koneksi.php";

// Mengecek apakah parameter kd_bgn ada di URL
if (isset($_GET['kd_bgn'])) {
    $kd_bagian = $_GET['kd_bgn'];

    // Mengecek apakah data dengan kd_bgn tersebut ada di database
    $query_check = "SELECT * FROM tb_bagian WHERE kd_bgn = '$kd_bagian'";
    $result_check = mysqli_query($koneksi, $query_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        // Jika data ditemukan, hapus data
        $query_delete = "DELETE FROM tb_bagian WHERE kd_bgn = '$kd_bagian'";
        if (mysqli_query($koneksi, $query_delete)) {
            echo "<script>alert('Data berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus data!');</script>";
            echo "<script>console.log('Error: " . addslashes(mysqli_error($koneksi)) . "');</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!');</script>";
    }
} else {
    echo "<script>alert('Kode bagian tidak valid!');</script>";
}

// Redirect ke halaman kelola bagian setelah proses selesai
echo "<script>window.location.href = 'kelolabagian.php';</script>";
?>
