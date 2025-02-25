<?php
include "../../conn/koneksi.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

// Validasi id_ktgb
$id_ktg = $_GET['id'];

// Hapus data
$delete = mysqli_query($koneksi, "DELETE FROM t_ktg WHERE id_ktg = '$id_ktg'");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header("refresh:0, kategori.php");
}else{
    echo "<script>alert('Data gagal dihapus!')</script>";
    header("refresh:0, kategori.php");
}
?>
