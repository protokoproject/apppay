<?php
include "../../conn/koneksi.php";

if (isset($_GET['id'])) {
    $id_hisdp = $_GET['id'];

    // Ambil data topup berdasarkan id
    $query = mysqli_query($koneksi, "
        SELECT h.nom_dp, u.id_user 
        FROM t_hisdepo h 
        INNER JOIN tb_user u ON h.id_user = u.id_user 
        WHERE h.id_hisdp = '$id_hisdp'
    ");

    if ($data = mysqli_fetch_assoc($query)) {
        $nominal = $data['nom_dp'];
        $id_user = $data['id_user'];

        // Ambil saldo terakhir dari t_murid
        $cek_saldo = mysqli_query($koneksi, "SELECT saldo FROM t_murid WHERE id_user = '$id_user' LIMIT 1");

        if ($murid = mysqli_fetch_assoc($cek_saldo)) {
            $saldo_lama = $murid['saldo'];
            $saldo_baru = $saldo_lama + $nominal;

            // Update saldo baru ke t_murid
            $update_saldo = mysqli_query($koneksi, "UPDATE t_murid SET saldo = '$saldo_baru' WHERE id_user = '$id_user'");

            // Update status topup di t_hisdepo
            $update_status = mysqli_query($koneksi, "UPDATE t_hisdepo SET stsdp = '2' WHERE id_hisdp = '$id_hisdp'");

            if ($update_saldo && $update_status) {
                echo "<script>alert('Topup berhasil disetujui dan saldo diperbarui.'); window.location.href='daftar_topup.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Data murid tidak ditemukan.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data topup tidak ditemukan.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ID topup tidak valid.'); window.history.back();</script>";
}
?>
