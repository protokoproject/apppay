<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

// Periksa apakah id_kantin ada di URL
if (isset($_GET['id'])) {
    $id_kantin = $_GET['id'];

    // Ambil id_user yang terkait dengan id_kantin
    $queryUser = mysqli_query($koneksi, "SELECT id_user FROM t_kantin WHERE id_kantin = '$id_kantin'");
    $rowUser = mysqli_fetch_assoc($queryUser);

    if ($rowUser) {
        $id_user = $rowUser['id_user'];

        // Hapus data dari tabel t_kantin
        $deleteKantin = mysqli_query($koneksi, "DELETE FROM t_kantin WHERE id_kantin = '$id_kantin'");

        if ($deleteKantin) {
            // Hapus data dari tabel tb_user berdasarkan id_user
            $deleteUser = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user = '$id_user'");

            if ($deleteUser) {
                echo "<script>alert('Data berhasil dihapus!'); window.location.href='kantin.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus data di tb_user!'); window.location.href='kantin.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal menghapus data di t_kantin!'); window.location.href='kantin.php';</script>";
        }
    } else {
        echo "<script>alert('Data kantin tidak ditemukan!'); window.location.href='kantin.php';</script>";
    }
} else {
    echo "<script>alert('ID Kantin tidak tersedia!'); window.location.href='kantin.php';</script>";
}
?>
