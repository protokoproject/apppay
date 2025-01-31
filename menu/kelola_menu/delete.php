<?php
include "../../conn/koneksi.php";

$kd_menu = $_GET['kd_menu'];

$hapus = mysqli_query($koneksi, "DELETE FROM tb_menu WHERE kd_menu = '$kd_menu'");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus!');</script>";
    header("refresh:0, menu.php");
} else {
    echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    header("refresh:0, menu.php");

}
?>