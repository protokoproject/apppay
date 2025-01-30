<?php
include "../../conn/koneksi.php";

if(isset($_GET['id'])){
    $id_app = $_GET['id'];

    $query="DELETE FROM tb_app WHERE id_app = '$id_app'";
    
    if(mysqli_query($koneksi, $query)){
        echo"<script>alert('Data Berhasil Dihapus!')</script>";
        header("refresh:0, kelolaapp.php");
        exit;
    }else{
        echo"<script>alert('Data Gagal Dihapus')</script>";
        header("refresh:0, kelolaapp.php");
        exit;
    }
}

?>