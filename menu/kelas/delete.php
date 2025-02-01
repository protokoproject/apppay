<?php
include "../../conn/koneksi.php";

// Periksa apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id_kls = $_GET['id'];

    // Query untuk menghapus data kelas berdasarkan ID
    $query = "DELETE FROM t_kelas WHERE id_kls = '$id_kls'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        header("refresh:0, kelas.php"); // Redirect ke halaman kelas
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
        header("refresh:0, kelas.php");
    }
} else {
    echo "<script>alert('ID tidak ditemukan!');</script>";
    header("refresh:0, kelas.php");
}
?>
