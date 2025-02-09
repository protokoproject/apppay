<?php
require "../../conn/koneksi.php";

if (isset($_GET['id'])) {
    $id_jadwal = $_GET['id'];

    // Ambil informasi QR Code sebelum menghapus data
    $query = mysqli_query($koneksi, "SELECT qr_code FROM t_jadwal WHERE id_jadwal = '$id_jadwal'");
    $data = mysqli_fetch_assoc($query);
    $qr_filename = $data['qr_code']; // Path file QR Code

    // Hapus data dari database
    $delete = mysqli_query($koneksi, "DELETE FROM t_jadwal WHERE id_jadwal = '$id_jadwal'");

    if ($delete) {
        // Hapus file QR Code jika ada
        if (!empty($qr_filename) && file_exists($qr_filename)) {
            unlink($qr_filename);
        }

        echo "<script>alert('Data berhasil dihapus!'); window.location='jadwal.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
