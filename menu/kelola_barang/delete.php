<?php
include "../../conn/koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Validasi id_ktgb
$kd_brg = $_GET['kd_brg'];

// Hapus data
$delete = mysqli_query($koneksi, "DELETE FROM t_brg WHERE kd_brg = '$kd_brg'");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header("refresh:0, barang.php");
}else{
    echo "<script>alert('Data gagal dihapus!')</script>";
    header("refresh:0, barang.php");
}
?>
