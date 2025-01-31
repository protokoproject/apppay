<?php
include '../../conn/koneksi.php';

$id = $_GET['id'];

// Ambil id_user dari t_guru sebelum menghapus
$user_query = mysqli_query($koneksi, "SELECT id_user FROM t_guru WHERE id_guru = '$id'");
$user_data = mysqli_fetch_array($user_query);
$id_user = $user_data['id_user'];

// Hapus data dari t_guru
$delete_guru = mysqli_query($koneksi, "DELETE FROM t_guru WHERE id_guru = '$id'");

if ($delete_guru) {
    // Hapus data dari tb_user
    $delete_user = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user = '$id_user'");
    
    if ($delete_user) {
        echo "<script>alert('Data Berhasil Dihapus!')</script>";
        header("refresh:0, guru.php");
    } else {
        echo "<script>alert('Data guru berhasil dihapus, tetapi data user gagal dihapus!')</script>";
        header("refresh:0, guru.php");
    }
} else {
    echo "<script>alert('Data Gagal Dihapus!')</script>";
    header("refresh:0, guru.php");
}

?>
