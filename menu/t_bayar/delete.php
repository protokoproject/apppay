<?php
include "../../conn/koneksi.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_tgh = $_GET['id'];

    // Query untuk menghapus data berdasarkan id_tgh
    $delete_query = "DELETE FROM t_tghbyr WHERE id_tgh = '$id_tgh'";
    
    if (mysqli_query($koneksi, $delete_query)) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
        header("refresh:0; bayar.php");
        exit;
    } else {
        echo "<script>alert('Data gagal dihapus!');</script>";
        header("refresh:0; bayar.php");
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan!');</script>";
    header("refresh:0; bayar.php");
    exit;
}
?>
