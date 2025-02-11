<?php
include "../../conn/koneksi.php";

if (isset($_GET['id'])) {
    $id_jadwal = $_GET['id'];

    // Hapus data dari database
    $delete = mysqli_query($koneksi, "DELETE FROM t_jadwal WHERE id_jadwal = '$id_jadwal'");

    if ($delete) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='jadwal.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
