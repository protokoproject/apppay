<?php
include "../../conn/koneksi.php";
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM t_mapel WHERE id_mapel = '$id'");

if($hapus){
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header("refresh:0, mapel.php");
}else{
    echo "<script>alert('Data gagal dihapus!')</script>";
    header("refresh:0, mapel.php");
}

?>