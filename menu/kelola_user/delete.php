<?php
// Pastikan koneksi ke database sudah dilakukan
include '../../conn/koneksi.php'; // Sesuaikan dengan path database Anda

// Periksa apakah parameter id_user ada pada URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Query untuk menghapus data berdasarkan id_user
    $query = "DELETE FROM tb_user WHERE id_user = '$id_user'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat menghapus data!');
            window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
        </script>";
    }
} else {
    echo "<script>
        alert('ID user tidak ditemukan!');
        window.location.href = 'user.php'; // Ganti dengan halaman tujuan Anda
    </script>";
}
?>
