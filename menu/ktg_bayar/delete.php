<?php
include "../../conn/koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Validasi id_ktgb
$id_ktgb = $_GET['id'];

// Hapus data
$delete = mysqli_query($koneksi, "DELETE FROM t_ktgbyr WHERE id_ktgb = '$id_ktgb'");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header("refresh:0, ktg_bayar.php");
}else{
    echo "<script>alert('Data gagal dihapus!')</script>";
    header("refresh:0, ktg_bayar.php");
}
?>
