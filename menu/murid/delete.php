<?php
include "../../conn/koneksi.php";
session_start(); // Pastikan session sudah dimulai

if (isset($_GET['id'])) {
    $id_mrd = $_GET['id'];

    // Ambil id_user yang terkait dengan id_mrd dari tabel t_murid
    $queryMurid = mysqli_query($koneksi, "SELECT id_user FROM t_murid WHERE id_mrd = '$id_mrd'");
    $dataMurid = mysqli_fetch_assoc($queryMurid);

    if ($dataMurid) {
        $id_user = $dataMurid['id_user'];

        // Mulai transaksi untuk memastikan data terhapus dari kedua tabel
        mysqli_begin_transaction($koneksi);

        try {
            // Hapus data dari tabel t_murid
            $queryDeleteMurid = mysqli_query($koneksi, "DELETE FROM t_murid WHERE id_mrd = '$id_mrd'");

            if (!$queryDeleteMurid) {
                throw new Exception("Gagal menghapus data dari t_murid!");
            }

            // Hapus data dari tabel tb_user yang terkait dengan id_user
            $queryDeleteUser = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id_user = '$id_user'");

            if (!$queryDeleteUser) {
                throw new Exception("Gagal menghapus data dari tb_user!");
            }

            // Commit transaksi jika kedua query berhasil
            mysqli_commit($koneksi);
            echo "<script>alert('Data berhasil dihapus!'); window.location.href='murid.php';</script>";
        } catch (Exception $e) {
            // Rollback jika terjadi error
            mysqli_rollback($koneksi);
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='murid.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='murid.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='murid.php';</script>";
}
?>
