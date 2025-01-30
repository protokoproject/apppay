<?php
include "../../conn/koneksi.php";

$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM t_ajaran WHERE idta = '$id'");

if($hapus){
    echo "<script>alert('Data berhasil dihapus!')</script>";
    header("refresh:0, ta.php");
}else{
    echo "<script>alert('Data gagal dihapus!')</script>";
    header("refresh:0, ta.php");
}

?>