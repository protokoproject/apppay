<?php
include "../../conn/koneksi.php";

$kd_sts_user = $_GET['kd_sts_user'];

$delete = mysqli_query($koneksi, "DELETE FROM tb_sts_user WHERE kd_sts_user ='$kd_sts_user'");

if($delete){
    echo "<script>alert('Data berhasil dihapus!');</script>";
    header("refresh:0, akses.php");
} else {
    echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    header("refresh:0, akses.php");

}
?>