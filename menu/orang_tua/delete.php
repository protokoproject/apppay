<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (isset($_GET['id'])) {
    $id_ortu = $_GET['id'];

    // Ambil id_user yang terkait dengan id_ortu dari tabel t_ortu
    $queryOrtu = mysqli_query($koneksi, "SELECT id_user FROM t_ortu WHERE id_ortu = '$id_ortu'");
    $dataOrtu = mysqli_fetch_assoc($queryOrtu);

    if ($dataOrtu) {
        $id_user = $dataOrtu['id_user'];

        // Mulai transaksi untuk memastikan data terhapus dari kedua tabel
        mysqli_begin_transaction($koneksi);

        try {
            // Hapus data dari tabel t_ortu
            $queryDeleteOrtu = mysqli_query($koneksi, "DELETE FROM t_ortu WHERE id_ortu = '$id_ortu'");

            if (!$queryDeleteOrtu) {
                throw new Exception("Gagal menghapus data dari t_ortu!");
            }

            // Hapus data dari tabel tb_user yang terkait dengan id_user
            $queryDeleteUser = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user = '$id_user'");

            if (!$queryDeleteUser) {
                throw new Exception("Gagal menghapus data dari tb_user!");
            }

            // Commit transaksi jika kedua query berhasil
            mysqli_commit($koneksi);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href='ortu.php';</script>";
        } catch (Exception $e) {
            // Rollback jika terjadi error
            mysqli_rollback($koneksi);
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='ortu.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='ortu.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='ortu.php';</script>";
}
?>
