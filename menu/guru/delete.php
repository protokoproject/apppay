<?php
include '../../conn/koneksi.php';

$id = $_GET['id'];

$delete = mysqli_query($koneksi,"DELETE FROM t_guru WHERE id_guru = '$id'");

if($delete){
    echo"<script>alert('Data Berhasil Dihapus!')</script>";
    header("refresh:0, guru.php");
}else{
    echo"<script>alert('Data Gagal Dihapus!')</script>";
    header("refresh:0, guru.php");
}

?>